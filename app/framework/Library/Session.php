<?php declare(strict_types=1);

namespace Framework\Library;

use DateTimeImmutable;
use Framework\Models\Session as SessionModel;
use Framework\Models\User;

final class Session
{
    private const TOUCH_INTERVAL = 60;
    private const TOKEN_PATTERN  = '/^[a-f0-9]{64}$/D';

    private static ?self $booted  = null;
    public ?SessionModel $current = null;

    private string $cookieName;
    private int $idle;

    private function __construct()
    {
        $cookieName = (string) Config::boot()->get('session.cookie', 'trello_session');
        $idle       = (int) Config::boot()->get('session.idle', 7200);

        $this->cookieName = $cookieName !== '' ? $cookieName : 'trello_session';
        $this->idle       = $idle > 0 ? $idle : 7200;
    }

    public static function boot(): self
    {
        return self::$booted ??= new self();
    }

    public function start(): void
    {
        if ($this->current !== null) {
            return;
        }

        $token = $this->cookieToken();

        if ($token === null) {
            return;
        }

        $now = new DateTimeImmutable();

        $this->current = SessionModel::query()
            ->with('user')
            ->find(hash('sha256', $token));

        if ($this->current === null) {
            $this->clearCookie();
            return;
        }

        if ($this->current->expires_at <= $now ||
            $this->current->last_seen_at <= $now->modify(sprintf('-%d seconds', $this->idle))) {
            $this->current->delete();
            $this->current = null;
            $this->clearCookie();
            return;
        }

        if ($this->current->last_seen_at <= $now->modify(sprintf('-%d seconds', self::TOUCH_INTERVAL))) {
            $this->current->last_seen_at = $now;
            $this->current->save();
        }
    }

    public function login(User $user): void
    {
        $this->logout();
        $this->create((int) $user->user_id);
    }

    public function logout(): void
    {
        if ($this->current !== null) {
            $this->current->delete();
            $this->current = null;
        } else {
            $token = $this->cookieToken();

            if ($token !== null) {
                SessionModel::query()->whereKey(hash('sha256', $token))->delete();
            }
        }

        $this->clearCookie();
    }

    private function create(int $userId): void
    {
        $token    = bin2hex(random_bytes(32));
        $now      = new DateTimeImmutable();
        $lifetime = (int) Config::boot()->get('session.lifetime', 604800);

        $lifetime = $lifetime > 0 ? $lifetime : 604800;

        $this->current = SessionModel::create([
            'session_id'   => hash('sha256', $token),
            'user_id'      => $userId,
            'ip_address'   => $_SERVER['REMOTE_ADDR'] ?? null,
            'created_at'   => $now,
            'expires_at'   => $now->modify(sprintf('+%d seconds', $lifetime)),
            'last_seen_at' => $now,
        ]);

        $this->setCookie($token, $lifetime);
    }

    private function cookieToken(): ?string
    {
        $token = $_COOKIE[$this->cookieName] ?? null;

        if (!is_string($token) || preg_match(self::TOKEN_PATTERN, $token) !== 1) {
            if ($token !== null) {
                $this->clearCookie();
            }

            return null;
        }

        return $token;
    }

    private function clearCookie(): void
    {
        if (!headers_sent()) {
            setcookie($this->cookieName, '', $this->cookieOptions(time() - 3600));
        }

        unset($_COOKIE[$this->cookieName]);
    }

    private function setCookie(string $token, int $lifetime): void
    {
        setcookie($this->cookieName, $token, $this->cookieOptions(time() + $lifetime));
    }

    private function cookieOptions(int $expires): array
    {
        $sameSite = (string) Config::boot()->get('session.same_site', 'Lax');

        return [
            'expires'  => $expires,
            'path'     => '/',
            'httponly' => true,
            'secure'   => (bool) Config::boot()->get('session.secure', false),
            'samesite' => $sameSite !== '' ? $sameSite : 'Lax',
        ];
    }
}

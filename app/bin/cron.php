<?php declare(strict_types=1);

use Framework\Library\Config;
use Framework\Library\Database;
use Framework\Library\Logger;
use Framework\Models\Session as SessionModel;

require __DIR__ . '/../bootstrap.php';

try {
    Database::boot();

    $now  = new DateTimeImmutable();
    $idle = $now->modify(sprintf('-%d seconds', (int) Config::boot()->get('session.idle', 7200)));

    $deleted = SessionModel::query()
        ->where(static function($query) use ($now, $idle): void {
            $query->where('expires_at', '<=', $now)
                  ->orWhere('last_seen_at', '<=', $idle);
        })
        ->delete();

    Logger::boot('cron')->info('session cleanup', ['deleted' => $deleted]);
} catch (Throwable $exception) {
    Logger::boot('cron')->info('session cleanup failed', ['exception' => $exception]);
    exit(1);
}

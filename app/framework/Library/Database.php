<?php declare(strict_types=1);

namespace Framework\Library;

use Illuminate\Database\Capsule\Manager as Capsule;

final class Database extends Capsule
{
    public static ?self $booted = null;

    private function __construct()
    {
        parent::__construct();

        $config = Config::boot();

        $this->addConnection([
            'driver'    => 'pgsql',
            'host'      => $config->get('db.host'),
            'port'      => $config->get('db.port'),
            'database'  => $config->get('db.database'),
            'username'  => $config->get('db.username'),
            'password'  => $config->get('db.password'),
        ]);

        $this->setAsGlobal();
        $this->bootEloquent();
    }

    public static function boot(): self
    {
        return self::$booted ??= new self();
    }
}

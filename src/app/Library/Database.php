<?php

declare(strict_types=1);

namespace App\Library;

use Illuminate\Database\Capsule\Manager as Capsule;

final class Database extends Capsule
{
    private static ?self $booted = null;

    private function __construct()
    {
        parent::__construct();

        $config = Config::boot();

        $this->addConnection([
            'driver'    => 'pgsql',
            'host'      => (string) $config->get('db.host'),
            'port'      => (string) $config->get('db.port'),
            'database'  => (string) $config->get('db.database'),
            'username'  => (string) $config->get('db.username'),
            'password'  => (string) $config->get('db.password'),
            'charset'   => 'utf8',
            'prefix'    => '',
            'schema'    => 'public',
        ]);

        $this->setAsGlobal();
        $this->bootEloquent();
    }

    public static function boot(): self
    {
        return self::$booted ??= new self();
    }
}

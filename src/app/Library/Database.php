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

        $this->addConnection([
            'driver'    => 'pgsql',
            'host'      => getenv('DB_HOST') ?: 'postgres',
            'port'      => getenv('DB_PORT') ?: '5432',
            'database'  => getenv('DB_NAME') ?: 'app',
            'username'  => getenv('DB_USER') ?: 'app',
            'password'  => getenv('DB_PASSWORD') ?: '',
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

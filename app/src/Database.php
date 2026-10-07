<?php

declare(strict_types=1);

namespace App;

final class Database
{
    private static ?Capsule $instance = null;

    public static function boot(): Capsule
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $capsule = new Capsule();

        $capsule->addConnection([
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

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        self::$instance = $capsule;

        return $capsule;
    }
}

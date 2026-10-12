<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Library\Database;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;

$resolver = Database::boot()->getDatabaseManager();

$repository = new DatabaseMigrationRepository($resolver, 'migrations');

if (! $repository->repositoryExists()) {
    $repository->createRepository();
}

$migrator = new Migrator($repository, $resolver, new Filesystem(), new Dispatcher());

$migrator->run(__DIR__ . '/../database/migrations');

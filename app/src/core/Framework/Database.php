<?php declare(strict_types=1);

namespace App\Framework;

use Illuminate\Database\Capsule\Manager as Capsule;

final class Database extends Capsule
{
    public static ?self $booted = null;

    private function __construct()
    {
        parent::__construct();

        $this->addConnection([
            'driver' => 'pgsql',
            'host'   => Config::boot()->get('db.host')
        ]);
    }
}

<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Capsule::schema()->create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('email', 255);
            $table->string('password_hash', 255);
            $table->string('name', 255);
            $table->timestamp('created_datetime');
            $table->timestamp('updated_datetime')->nullable();
            $table->unique('email', 'idx_email');
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('users');
    }
};

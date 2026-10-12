<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Capsule::schema()->create('boards', function (Blueprint $table) {
            $table->increments('board_id');
            $table->string('title', 255);
            $table->integer('owner_user_id');
            $table->boolean('is_public')->default(false);
            $table->timestamp('created_datetime');
            $table->timestamp('updated_datetime')->nullable();
            $table->foreign('owner_user_id')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('boards');
    }
};

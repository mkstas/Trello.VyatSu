<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Capsule::schema()->create('cards', function (Blueprint $table) {
            $table->increments('card_id');
            $table->integer('board_id');
            $table->integer('column_id');
            $table->smallInteger('sort_index');
            $table->string('title', 255);
            $table->text('content')->nullable();
            $table->string('color', 6)->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamp('created_datetime');
            $table->timestamp('updated_datetime')->nullable();
            $table->foreign('board_id')->references('board_id')->on('boards');
            $table->foreign('column_id')->references('column_id')->on('board_columns');
        });

        Capsule::statement('CREATE INDEX idx_active_board_id ON cards (board_id) WHERE is_archived = false');
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('cards');
    }
};

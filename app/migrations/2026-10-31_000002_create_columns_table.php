<?php declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Capsule::schema()->create('columns', function (Blueprint $table) {
            $table->increments('column_id');
            $table->integer('board_id');
            $table->smallInteger('ordinal_position');
            $table->string('title', 255);
            $table->string('color', 6)->nullable();
            $table->index('board_id', 'idx_board_id');
            $table->unique(['board_id', 'ordinal_position'], 'uq_board_ordinal');
            $table->foreign('board_id')->references('board_id')->on('boards')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('columns');
    }
};

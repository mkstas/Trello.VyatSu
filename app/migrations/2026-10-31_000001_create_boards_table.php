<?php declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Capsule::schema()->create('boards', function (Blueprint $table) {
            $table->increments('board_id');
            $table->integer('user_id');
            $table->string('title', 255);
            $table->boolean('is_public')->default(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->index('user_id', 'idx_user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('boards');
    }
};

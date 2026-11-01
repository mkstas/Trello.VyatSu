<?php declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Capsule::schema()->create("sessions", function(Blueprint $table) {
            $table->string('session_id', 64)->primary();
            $table->integer('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at');
            $table->timestamp('expires_at');
            $table->timestamp('last_seen_at');
            $table->index('user_id', 'idx_sessions_user_id');
            $table->index('expires_at', 'idx_sessions_expires_at');
            $table->index('last_seen_at', 'idx_sessions_last_seen_at');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('sessions');
    }
};

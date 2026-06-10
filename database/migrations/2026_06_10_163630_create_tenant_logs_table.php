<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenant_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id');
            $table->string('account_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('room_number')->nullable();
            $table->tinyInteger('floor')->nullable();
            $table->enum('action', ['time_in', 'time_out']);
            $table->timestamp('logged_at')->useCurrent();
            $table->string('logged_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_logs');
    }
};
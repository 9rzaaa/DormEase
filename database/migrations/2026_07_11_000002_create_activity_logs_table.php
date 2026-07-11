<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable()->index();
            $table->string('staff_name')->nullable();
            $table->string('staff_role')->nullable();
            $table->string('module')->index();
            $table->string('action')->index();
            $table->string('description');
            $table->string('method', 12)->nullable();
            $table->string('route_name')->nullable()->index();
            $table->string('path')->nullable();
            $table->string('ip_address', 64)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();

            $table->index(['module', 'action', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

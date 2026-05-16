<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->increments('tenant_id');

            // ── Login Credentials ─────────────────────────────────────────
            $table->string('account_id')->unique();
            // format: TNT-2026-001 — auto-generated when admin adds tenant
            $table->string('password_hash');
            // stores the hashed version of the temporary password
            $table->boolean('is_temp_password')->default(true);
            // true  = tenant has not changed their password yet
            // false = tenant has already changed their password

            // ── Personal Information ──────────────────────────────────────
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('contact_number')->nullable();
            $table->string('profile_photo')->nullable();
            // stores file path of uploaded profile photo

            // ── Room Information ──────────────────────────────────────────
            $table->string('room_number')->nullable();
            $table->tinyInteger('floor')->nullable();
            $table->string('stay_type')->nullable();
            // e.g. Bed Spacer, Solo Room, etc.
            $table->date('move_in_date')->nullable();
            $table->date('move_out_date')->nullable();

            // ── Account Status ────────────────────────────────────────────
            $table->enum('status', ['active', 'pending', 'move_out', 'inactive'])
                ->default('pending');
            // pending   = account created but tenant has not logged in yet
            // active    = tenant is currently staying and using the app
            // move_out  = tenant has submitted move-out request
            // inactive  = tenant account has been deactivated by admin
            $table->boolean('is_active')->default(true);

            // ── Timestamps ────────────────────────────────────────────────
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('tenants');
        Schema::enableForeignKeyConstraints();
    }
};

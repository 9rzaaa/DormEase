<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE tenants
            MODIFY COLUMN status
            ENUM('active', 'pending', 'reserved', 'move_out', 'inactive')
            NOT NULL DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE tenants
            MODIFY COLUMN status
            ENUM('active', 'pending', 'move_out', 'inactive')
            NOT NULL DEFAULT 'pending'
        ");
    }
};
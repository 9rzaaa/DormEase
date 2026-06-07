<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archive_settings', function (Blueprint $table) {
            $table->id();
            $table->string('module')->unique();
            $table->boolean('is_enabled')->default(false);
            $table->unsignedInteger('retention_days')->default(365);
            $table->unsignedInteger('warn_days_before')->default(7);
            $table->timestamp('last_cleared_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        DB::table('archive_settings')->insert([
            ['module' => 'water_billing',                   'is_enabled' => false, 'retention_days' => 365, 'warn_days_before' => 7, 'last_cleared_at' => null, 'updated_by' => null, 'updated_at' => null],
            ['module' => 'visitor_logs',                    'is_enabled' => false, 'retention_days' => 365, 'warn_days_before' => 7, 'last_cleared_at' => null, 'updated_by' => null, 'updated_at' => null],
            ['module' => 'announcements',                   'is_enabled' => false, 'retention_days' => 365, 'warn_days_before' => 7, 'last_cleared_at' => null, 'updated_by' => null, 'updated_at' => null],
            ['module' => 'tenant_archive',                  'is_enabled' => false, 'retention_days' => 365, 'warn_days_before' => 7, 'last_cleared_at' => null, 'updated_by' => null, 'updated_at' => null],
            ['module' => 'maintenance_archive',             'is_enabled' => false, 'retention_days' => 365, 'warn_days_before' => 7, 'last_cleared_at' => null, 'updated_by' => null, 'updated_at' => null],
            ['module' => 'emergency_archive',               'is_enabled' => false, 'retention_days' => 365, 'warn_days_before' => 7, 'last_cleared_at' => null, 'updated_by' => null, 'updated_at' => null],
            ['module' => 'staff_archive',                   'is_enabled' => false, 'retention_days' => 365, 'warn_days_before' => 7, 'last_cleared_at' => null, 'updated_by' => null, 'updated_at' => null],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('archive_settings');
    }
};
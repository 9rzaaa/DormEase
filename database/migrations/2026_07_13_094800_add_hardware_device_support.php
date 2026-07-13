<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hardware_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_name');
            $table->string('device_type')->default('rfid');
            $table->string('location')->nullable();
            $table->integer('floor')->nullable();
            $table->string('device_token', 64)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_ping_at')->nullable();
            $table->string('firmware_version')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        Schema::table('tenant_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('device_id')->nullable()->after('logged_by');
            $table->string('hardware_device_type')->nullable()->after('device_id');
            $table->json('raw_payload')->nullable()->after('hardware_device_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hardware_devices');
        Schema::table('tenant_logs', function (Blueprint $table) {
            $table->dropColumn(['device_id', 'hardware_device_type', 'raw_payload']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archived_emergency_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_id');
            $table->string('archive_type', 20);
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('tenant_name')->nullable();
            $table->string('room_number', 20)->nullable();
            $table->boolean('is_panic_alert')->default(false);
            $table->string('emergency_type')->nullable();
            $table->string('urgency_level', 20)->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('status', 30)->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('reported_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('archived_at')->useCurrent();

            $table->index(['archive_type', 'archived_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_emergency_reports');
    }
};

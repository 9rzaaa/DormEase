<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergency_reports', function (Blueprint $table) {
            $table->increments('report_id');
            $table->unsignedInteger('tenant_id')->nullable();
            $table->boolean('is_panic_alert')->default(false);
            $table->string('emergency_type')->nullable();
            $table->string('input_type')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('reported_at')->nullable();
            $table->timestamp('resolved_at')->nullable();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_reports');
    }
};
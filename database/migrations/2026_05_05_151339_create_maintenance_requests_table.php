<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->increments('request_id');
            $table->unsignedInteger('tenant_id')->nullable();
            $table->string('input_type')->nullable();
            $table->string('issue_type')->nullable();
            $table->text('description')->nullable();
            $table->string('urgency_level')->nullable();
            $table->string('status')->nullable();
            $table->string('assigned_to')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('resolved_at')->nullable();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
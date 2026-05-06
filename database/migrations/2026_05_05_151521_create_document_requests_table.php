<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->increments('doc_request_id');
            $table->unsignedInteger('tenant_id')->nullable();
            $table->string('document_type')->nullable();
            $table->text('purpose')->nullable();
            $table->string('delivery_type')->nullable();
            $table->date('date_needed')->nullable();
            $table->string('status')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
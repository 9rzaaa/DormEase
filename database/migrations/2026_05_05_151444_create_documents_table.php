<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('document_id');
            $table->unsignedInteger('uploaded_by')->nullable();
            $table->unsignedInteger('tenant_id')->nullable();
            $table->string('title')->nullable();
            $table->string('document_type')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_size')->nullable();
            $table->timestamp('date_posted')->nullable();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->nullOnDelete();
            $table->foreign('uploaded_by')->references('staff_id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
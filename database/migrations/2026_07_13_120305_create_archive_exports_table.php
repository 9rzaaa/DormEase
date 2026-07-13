<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archive_exports', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->string('s3_key');
            $table->string('file_name');
            $table->unsignedInteger('record_count');
            $table->timestamp('date_from')->nullable();
            $table->timestamp('date_to')->nullable();
            $table->unsignedBigInteger('exported_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archive_exports');
    }
};
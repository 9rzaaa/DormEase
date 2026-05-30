<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archive_docus', function (Blueprint $table) {
            $table->id('archive_id');
            $table->string('archivable_type');
            $table->unsignedBigInteger('original_id');
            $table->unsignedBigInteger('archived_by')->nullable();
            $table->timestamp('archived_at')->useCurrent();
            $table->json('data');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archive_docus');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->increments('announcement_id');
            $table->unsignedInteger('posted_by')->nullable();
            $table->string('title');
            $table->text('content');
            $table->string('priority')->nullable();
            $table->string('status')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->foreign('posted_by')
                  ->references('staff_id')
                  ->on('staff')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
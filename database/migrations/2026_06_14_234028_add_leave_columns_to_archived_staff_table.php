<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_archive', function (Blueprint $table) {
        $table->boolean('is_on_leave')->default(false);
        $table->date('leave_start')->nullable();
        $table->date('leave_end')->nullable();
        $table->string('leave_note', 255)->nullable();
    });
    }

    public function down(): void
    {
        Schema::table('staff_archive', function (Blueprint $table) {
            $table->dropColumn(['is_on_leave', 'leave_start', 'leave_end', 'leave_note']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_attendance', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->unsignedBigInteger('staff_id');
            $table->string('staff_name');
            $table->string('role')->nullable();
            $table->string('shift_schedule')->nullable();
            $table->timestamp('login_at');
            $table->timestamp('logout_at')->nullable();
            $table->string('duty_status')->default('off_duty');
            $table->foreign('staff_id')->references('staff_id')->on('staff')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_attendance');
    }
};

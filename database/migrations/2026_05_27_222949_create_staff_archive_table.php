<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_archive', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_staff_id')->nullable();
            $table->string('account_id', 20)->nullable();
            $table->string('staff_code', 20)->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 255)->nullable();
            $table->string('role', 50)->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('shift_schedule', 50)->nullable();
            $table->string('duty_status', 50)->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('archived_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_archive');
    }
};
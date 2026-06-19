<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_emergency_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->string('emergency_type');
            $table->string('urgency_level')->nullable();
            $table->foreignId('added_by_staff_id')->nullable()->constrained('staff', 'staff_id')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_emergency_keywords');
    }
};
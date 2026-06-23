<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_maintenance_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->string('issue_type');
            $table->string('urgency_level')->nullable();
            $table->unsignedBigInteger('added_by_staff_id')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('custom_maintenance_keywords');
    }
};
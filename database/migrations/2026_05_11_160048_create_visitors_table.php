<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id('visitor_id');

            $table->string('visitor_name');
            $table->string('contact_no')->nullable();
            $table->string('purpose')->nullable();
            $table->string('id_type')->nullable();

            $table->date('date_of_visit')->nullable();

            $table->timestamp('arrival_time')->nullable();
            $table->timestamp('departure_time')->nullable();

            $table->string('status')->default('pending');

            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('water_rates', function (Blueprint $table) {
            $table->integer('rate_id')->autoIncrement();
            $table->decimal('rate_per_m3', 10, 2);
            $table->date('effective_month');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('water_rates');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('water_rates', function (Blueprint $table) {
            $table->increments('rate_id');
            $table->unsignedInteger('set_by')->nullable();
            $table->decimal('rate_per_m3', 8, 2);
            $table->date('effective_month');
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('set_by')
                  ->references('staff_id')
                  ->on('staff')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('water_rates');
    }
};
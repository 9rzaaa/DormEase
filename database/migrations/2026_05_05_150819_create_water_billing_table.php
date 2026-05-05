<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('water_billing', function (Blueprint $table) {
            $table->increments('billing_id');
            $table->unsignedInteger('tenant_id')->nullable();
            $table->unsignedInteger('rate_id')->nullable();
            $table->unsignedInteger('inputted_by')->nullable();
            $table->date('billing_month')->nullable();
            $table->tinyInteger('floor')->nullable();
            $table->decimal('floor_consumption_m3', 10, 4)->nullable();
            $table->decimal('prev_reading', 10, 4)->nullable();
            $table->decimal('curr_reading', 10, 4)->nullable();
            $table->decimal('total_floor_bill', 10, 2)->nullable();
            $table->integer('rooms_sharing')->nullable();
            $table->integer('occupants_in_room')->nullable();
            $table->decimal('room_share', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->date('due_date')->nullable();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->nullOnDelete();
            $table->foreign('rate_id')->references('rate_id')->on('water_rates')->nullOnDelete();
            $table->foreign('inputted_by')->references('staff_id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('water_billing');
    }
};
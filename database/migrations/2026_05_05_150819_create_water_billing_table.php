<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('water_billing', function (Blueprint $table) {

            // ERD: billing_id PK (int)
            $table->integer('billing_id')->autoIncrement();

            // ERD: tenant_id FK (int) → tenants.tenant_id
            $table->unsignedInteger('tenant_id');
            $table->foreign('tenant_id')
                ->references('tenant_id')
                ->on('tenants')
                ->onDelete('cascade');

            // ERD: rate_id FK (int) → water_rates.rate_id
            $table->unsignedInteger('rate_id')->nullable();
            $table->foreign('rate_id')
                ->references('rate_id')
                ->on('water_rates')
                ->onDelete('set null');

            // ERD: inputted_by FK (int) → staff.staff_id
            $table->unsignedInteger('inputted_by')->nullable();
            $table->foreign('inputted_by')
                ->references('staff_id')
                ->on('staff')
                ->onDelete('set null');

            // ERD: billing_month (date)
            $table->date('billing_month');

            // ERD: floor (tinyint)
            $table->tinyInteger('floor')->nullable();

            // ERD: floor_consumption_m3 (decimal)
            $table->decimal('floor_consumption_m3', 10, 2)->default(0);

            // ERD: prev_reading (decimal)
            $table->decimal('prev_reading', 10, 2)->default(0);

            // ERD: curr_reading (decimal)
            $table->decimal('curr_reading', 10, 2)->default(0);

            // ERD: total_floor_bill (decimal)
            $table->decimal('total_floor_bill', 10, 2)->default(0);

            // ERD: rooms_sharing (int)
            $table->integer('rooms_sharing')->default(1);

            // ERD: occupants_in_room (int)
            $table->integer('occupants_in_room')->default(1);

            // ERD: room_share (decimal)
            $table->decimal('room_share', 10, 2)->default(0);

            // ERD: payment_status (varchar)
            $table->string('payment_status')->default('unpaid');

            // ERD: due_date (date)
            $table->date('due_date')->nullable();
        });

        Schema::table('water_billing', function (Blueprint $table) {
            // Used in every floor+month query (log, updateFull, index)
            $table->index(['floor', 'billing_month'], 'idx_floor_month');

            // Used in index() to filter by month
            $table->index('billing_month', 'idx_billing_month');

            // Used in keyBy('tenant_id') lookups
            $table->index('tenant_id', 'idx_tenant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('water_billing');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->unsignedInteger('billing_id')->nullable();
            $table->unsignedInteger('tenant_id')->nullable();
            $table->unsignedInteger('confirmed_by')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->string('reference_number')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('status')->nullable();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->nullOnDelete();
            $table->foreign('confirmed_by')->references('staff_id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
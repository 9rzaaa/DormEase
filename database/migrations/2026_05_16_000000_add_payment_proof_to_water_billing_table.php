<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('water_billing', function (Blueprint $table) {
            if (!Schema::hasColumn('water_billing', 'proof_of_payment')) {
                $table->string('proof_of_payment')->nullable()->after('payment_status');
            }

            if (!Schema::hasColumn('water_billing', 'payment_reference_code')) {
                $table->string('payment_reference_code')->nullable()->after('proof_of_payment');
            }

            if (!Schema::hasColumn('water_billing', 'payment_submitted_at')) {
                $table->timestamp('payment_submitted_at')->nullable()->after('payment_reference_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('water_billing', function (Blueprint $table) {
            if (Schema::hasColumn('water_billing', 'payment_submitted_at')) {
                $table->dropColumn('payment_submitted_at');
            }

            if (Schema::hasColumn('water_billing', 'payment_reference_code')) {
                $table->dropColumn('payment_reference_code');
            }

            if (Schema::hasColumn('water_billing', 'proof_of_payment')) {
                $table->dropColumn('proof_of_payment');
            }
        });
    }
};

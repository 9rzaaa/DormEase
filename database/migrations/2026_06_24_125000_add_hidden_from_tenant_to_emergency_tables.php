<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('emergency_reports', function (Blueprint $table) {
            $table->boolean('hidden_from_tenant')->default(false);
        });

        Schema::table('archived_emergency_reports', function (Blueprint $table) {
            $table->boolean('hidden_from_tenant')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emergency_reports', function (Blueprint $table) {
            $table->dropColumn('hidden_from_tenant');
        });

        Schema::table('archived_emergency_reports', function (Blueprint $table) {
            $table->dropColumn('hidden_from_tenant');
        });
    }
};

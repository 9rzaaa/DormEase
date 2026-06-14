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
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->boolean('hidden_from_tenant')->default(false);
        });

        Schema::table('archived_maintenance_requests', function (Blueprint $table) {
            $table->boolean('hidden_from_tenant')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->dropColumn('hidden_from_tenant');
        });

        Schema::table('archived_maintenance_requests', function (Blueprint $table) {
            $table->dropColumn('hidden_from_tenant');
        });
    }
};

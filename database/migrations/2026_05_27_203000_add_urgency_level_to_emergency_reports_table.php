<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emergency_reports', function (Blueprint $table) {
            if (! Schema::hasColumn('emergency_reports', 'urgency_level')) {
                $table->string('urgency_level')->nullable()->after('emergency_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('emergency_reports', function (Blueprint $table) {
            if (Schema::hasColumn('emergency_reports', 'urgency_level')) {
                $table->dropColumn('urgency_level');
            }
        });
    }
};

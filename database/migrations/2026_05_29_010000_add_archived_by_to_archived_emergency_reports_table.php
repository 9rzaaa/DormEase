<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('archived_emergency_reports', function (Blueprint $table) {
            if (! Schema::hasColumn('archived_emergency_reports', 'archived_by_staff_id')) {
                $table->unsignedBigInteger('archived_by_staff_id')->nullable()->after('archive_type');
            }

            if (! Schema::hasColumn('archived_emergency_reports', 'archived_by_name')) {
                $table->string('archived_by_name')->nullable()->after('archived_by_staff_id');
            }

            if (! Schema::hasColumn('archived_emergency_reports', 'archived_by_role')) {
                $table->string('archived_by_role', 50)->nullable()->after('archived_by_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('archived_emergency_reports', function (Blueprint $table) {
            if (Schema::hasColumn('archived_emergency_reports', 'archived_by_role')) {
                $table->dropColumn('archived_by_role');
            }

            if (Schema::hasColumn('archived_emergency_reports', 'archived_by_name')) {
                $table->dropColumn('archived_by_name');
            }

            if (Schema::hasColumn('archived_emergency_reports', 'archived_by_staff_id')) {
                $table->dropColumn('archived_by_staff_id');
            }
        });
    }
};

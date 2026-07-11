<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            if (! Schema::hasColumn('staff', 'staff_address')) {
                $table->string('staff_address', 500)->nullable()->after('contact_number');
            }

            if (! Schema::hasColumn('staff', 'valid_id_path')) {
                $table->string('valid_id_path')->nullable()->after('staff_address');
            }
        });

        Schema::table('staff_archive', function (Blueprint $table) {
            if (! Schema::hasColumn('staff_archive', 'staff_address')) {
                $table->string('staff_address', 500)->nullable()->after('contact_number');
            }

            if (! Schema::hasColumn('staff_archive', 'valid_id_path')) {
                $table->string('valid_id_path')->nullable()->after('staff_address');
            }

            if (! Schema::hasColumn('staff_archive', 'profile_picture')) {
                $table->longText('profile_picture')->nullable()->after('valid_id_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('staff_archive', function (Blueprint $table) {
            if (Schema::hasColumn('staff_archive', 'profile_picture')) {
                $table->dropColumn('profile_picture');
            }

            if (Schema::hasColumn('staff_archive', 'valid_id_path')) {
                $table->dropColumn('valid_id_path');
            }

            if (Schema::hasColumn('staff_archive', 'staff_address')) {
                $table->dropColumn('staff_address');
            }
        });

        Schema::table('staff', function (Blueprint $table) {
            if (Schema::hasColumn('staff', 'valid_id_path')) {
                $table->dropColumn('valid_id_path');
            }

            if (Schema::hasColumn('staff', 'staff_address')) {
                $table->dropColumn('staff_address');
            }
        });
    }
};

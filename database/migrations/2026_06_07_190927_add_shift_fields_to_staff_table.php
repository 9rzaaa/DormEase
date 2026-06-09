<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->time('shift_start')->nullable()->after('shift_schedule');
            $table->time('shift_end')->nullable()->after('shift_start');
            $table->timestamp('last_login_at')->nullable()->after('shift_end');
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['shift_start', 'shift_end', 'last_login_at']);
        });
    }
};

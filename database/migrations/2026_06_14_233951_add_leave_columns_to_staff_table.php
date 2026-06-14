<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->boolean('is_on_leave')->default(false)->after('duty_status');
            $table->date('leave_start')->nullable()->after('is_on_leave');
            $table->date('leave_end')->nullable()->after('leave_start');
            $table->string('leave_note', 255)->nullable()->after('leave_end');
        });

        DB::table('staff')->where('duty_status', 'on_leave')->update([
            'duty_status' => 'off_duty',
            'is_on_leave' => true,
        ]);
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['is_on_leave', 'leave_start', 'leave_end', 'leave_note']);
        });
    }
};
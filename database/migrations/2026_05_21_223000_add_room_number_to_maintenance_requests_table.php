<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('maintenance_requests', 'room_number')) {
                $table->string('room_number')->nullable()->after('tenant_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            if (Schema::hasColumn('maintenance_requests', 'room_number')) {
                $table->dropColumn('room_number');
            }
        });
    }
};

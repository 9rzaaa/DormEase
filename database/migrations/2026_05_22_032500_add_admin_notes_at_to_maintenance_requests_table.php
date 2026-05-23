<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('maintenance_requests', 'admin_notes_at')) {
                $table->timestamp('admin_notes_at')->nullable()->after('admin_notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            if (Schema::hasColumn('maintenance_requests', 'admin_notes_at')) {
                $table->dropColumn('admin_notes_at');
            }
        });
    }
};

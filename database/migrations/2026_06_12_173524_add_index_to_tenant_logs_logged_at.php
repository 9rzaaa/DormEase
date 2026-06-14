<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToTenantLogsLoggedAt extends Migration
{
    public function up(): void
    {
        Schema::table('tenant_logs', function (Blueprint $table) {
            $table->index('logged_at');
            $table->index('tenant_id');
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::table('tenant_logs', function (Blueprint $table) {
            $table->dropIndex(['logged_at']);
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['action']);
        });
    }
}
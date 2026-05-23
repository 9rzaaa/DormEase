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
    Schema::table('document_requests', function (Blueprint $table) {
        if (!Schema::hasColumn('document_requests', 'attachment')) {
            $table->string('attachment')->nullable()->after('date_needed');
        }
        if (!Schema::hasColumn('document_requests', 'fulfilled_file')) {
            $table->string('fulfilled_file')->nullable()->after('admin_remarks');
        }
    });
}

public function down(): void
{
    Schema::table('document_requests', function (Blueprint $table) {
        $table->dropColumn(array_filter([
            Schema::hasColumn('document_requests', 'attachment')    ? 'attachment'     : null,
            Schema::hasColumn('document_requests', 'fulfilled_file') ? 'fulfilled_file' : null,
        ]));
    });
}
};

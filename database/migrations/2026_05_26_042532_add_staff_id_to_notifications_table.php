<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
    {
        public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedInteger('staff_id')->nullable()->after('tenant_id');
            $table->foreign('staff_id')->references('staff_id')->on('staff')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');
        });
    }
};

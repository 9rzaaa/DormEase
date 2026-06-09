<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->date('estimated_move_in_date')->nullable()->after('move_in_date');
            $table->text('reservation_notes')->nullable()->after('estimated_move_in_date');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['estimated_move_in_date', 'reservation_notes']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRejectionReasonToVisitorLogsTable extends Migration
{
    public function up()
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->string('rejection_reason', 255)->nullable()->after('cancel_reason');
        });
    }

    public function down()
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });
    }
}
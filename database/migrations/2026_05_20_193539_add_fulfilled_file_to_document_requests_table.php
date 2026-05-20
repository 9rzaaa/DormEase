<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
        {
            Schema::table('document_requests', function (Blueprint $table) {
                $table->string('fulfilled_file')->nullable()->after('admin_remarks');
            });
        }

        public function down()
        {
            Schema::table('document_requests', function (Blueprint $table) {
                $table->dropColumn('fulfilled_file');
            });
        }
};

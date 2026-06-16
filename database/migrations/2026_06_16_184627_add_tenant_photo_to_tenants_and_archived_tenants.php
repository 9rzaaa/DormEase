<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTenantPhotoToTenantsAndArchivedTenants extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('tenant_photo')->nullable()->after('profile_photo');
        });

        Schema::table('archived_tenants', function (Blueprint $table) {
            $table->string('tenant_photo')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('tenant_photo');
        });

        Schema::table('archived_tenants', function (Blueprint $table) {
            $table->dropColumn('tenant_photo');
        });
    }
}
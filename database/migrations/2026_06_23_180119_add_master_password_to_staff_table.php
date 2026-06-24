<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('master_password')->nullable()->after('password_hash');
            $table->string('recovery_code')->nullable()->after('master_password');
        });

        Staff::whereIn('role', ['admin', 'secretary'])->each(function ($staff) {
            $staff->updateQuietly([
                'master_password' => Hash::make('DormEase@2025'),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['master_password', 'recovery_code']);
        });
    }
};
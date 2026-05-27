<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('archived_tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_id');
            $table->string('archive_type');
            $table->string('account_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('room_number', 20)->nullable();
            $table->unsignedTinyInteger('floor')->nullable();
            $table->string('stay_type', 50)->nullable();
            $table->date('move_in_date')->nullable();
            $table->date('move_out_date')->nullable();
            $table->string('status', 30)->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->index('archive_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_tenants');
    }
};
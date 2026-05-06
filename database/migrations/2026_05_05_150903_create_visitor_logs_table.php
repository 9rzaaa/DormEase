<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->increments('visitor_id');
            $table->unsignedInteger('tenant_id')->nullable();
            $table->unsignedInteger('confirmed_by')->nullable();
            $table->string('visitor_name')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('purpose')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_photo')->nullable();
            $table->date('date_of_visit')->nullable();
            $table->time('time_of_visit')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->timestamp('departure_time')->nullable();
            $table->string('status')->nullable();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->nullOnDelete();
            $table->foreign('confirmed_by')->references('staff_id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
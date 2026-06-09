<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number', 10)->unique();
            $table->integer('floor');
            $table->integer('capacity');
            $table->string('stay_type', 30);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
};

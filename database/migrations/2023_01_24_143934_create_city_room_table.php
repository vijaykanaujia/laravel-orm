<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_room', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('room_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::connection('sqlite')->create('city_room', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('room_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_room');
        Schema::connection('sqlite')->dropIfExists('city_room');
    }
};

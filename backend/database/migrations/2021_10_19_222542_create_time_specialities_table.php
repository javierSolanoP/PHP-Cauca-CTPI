<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_specialities', function (Blueprint $table) {
            $table->id('id_time_speciality');
            $table->unsignedBigInteger('time_id');
            $table->unsignedBigInteger('speciality_id');
            $table->foreign('time_id')->references('id_time')->on('times')->onDelete('cascade');
            $table->foreign('speciality_id')->references('id_speciality')->on('specialities')->onDelete('cascade');
            $table->integer('number_of_hours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_specialities');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssigmentTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigment_times', function (Blueprint $table) {
            $table->id('id_history_time');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('time_speciality_id');
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('time_speciality_id')->references('id_time_speciality')->on('time_specialities')->onDelete('cascade');
            $table->string('url_pdf');
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
        Schema::dropIfExists('assigment_times');
    }
}

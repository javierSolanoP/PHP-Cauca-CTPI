<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNurseSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_specialities', function (Blueprint $table) {
            $table->id('id_nurse_speciality');
            $table->unsignedBigInteger('nurse_id');
            $table->unsignedBigInteger('speciality_id');
            $table->foreign('nurse_id')->references('id_nurse')->on('nurses')->onDelete('cascade');
            $table->foreign('speciality_id')->references('id_speciality')->on('specialities')->onDelete('cascade');
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
        Schema::dropIfExists('nurse_specialities');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_specialities', function (Blueprint $table) {
            $table->id('id_professional_speciality');
            $table->unsignedBigInteger('professional_id');
            $table->unsignedBigInteger('speciality_id');
            $table->foreign('professional_id')->references('id_professional')->on('professionals')->onDelete('cascade');
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
        Schema::dropIfExists('professional_specialities');
    }
}

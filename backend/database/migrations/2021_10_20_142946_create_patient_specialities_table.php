<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_specialities', function (Blueprint $table) {
            $table->id('id_patient_speciality');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('speciality_id');
            $table->foreign('patient_id')->references('id_patient')->on('patients')->onDelete('cascade');
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
        Schema::dropIfExists('patient_specialities');
    }
}

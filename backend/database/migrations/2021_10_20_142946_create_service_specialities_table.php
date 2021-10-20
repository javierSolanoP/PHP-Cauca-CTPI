<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_specialities', function (Blueprint $table) {
            $table->id('id_service_speciality');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('speciality_id');
            $table->foreign('service_id')->references('id_service')->on('services')->onDelete('cascade');
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
        Schema::dropIfExists('service_specialities');
    }
}

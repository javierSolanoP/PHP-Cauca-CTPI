<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_times', function (Blueprint $table) {
            $table->id('id_assignment_time');
            $table->unsignedBigInteger('time_id');
            $table->unsignedBigInteger('shift_id');
            $table->foreign('time_id')->references('id_time')->on('times')->onDelete('cascade');
            $table->foreign('shift_id')->references('id_shift')->on('shifts')->onDelete('cascade');
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
        Schema::dropIfExists('assignment_times');
    }
}

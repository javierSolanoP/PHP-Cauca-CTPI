<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_roles', function (Blueprint $table) {
            $table->id('id_module_role');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('module_id');
            $table->foreign('role_id')->references('id_role')->on('roles')->onDelete('cascade');
            $table->foreign('module_id')->references('id_module')->on('modules')->onDelete('cascade');
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
        Schema::dropIfExists('module_roles');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id('id_module');
            $table->string('module', 100);
            $table->timestamps();
        });

        Schema::table('modules', function (Blueprint $table) {
            DB::insert("insert into modules (module) values ('shift_module')");
            DB::insert("insert into modules (module) values ('professional_module')");
            DB::insert("insert into modules (module) values ('admin_module')");
            DB::insert("insert into modules (module) values ('public_module')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}

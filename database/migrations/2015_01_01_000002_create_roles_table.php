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
        /*
         * create_permission_tables -ben van
         */
        //Schema::create('roles', function (Blueprint $table) {
        //    $table->increments('id');
        //    $table->string('name')->index('roles_name_unique');
        //    $table->string('display_name')->nullable();
        //    $table->string('description')->nullable();
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('roles');
    }
};

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
        Schema::create('hq_settings', function (Blueprint $table) {
            $table->increments('id')->comment('Rekord azonosító');
            $table->string('key')->default('')->comment('Kulcs');
            $table->string('value')->default('')->comment('Érték');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hq_settings');
    }
};

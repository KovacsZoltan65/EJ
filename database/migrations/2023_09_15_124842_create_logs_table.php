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
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id')->comment('Rekord azonosító');
            $table->unsignedInteger('user_id')->comment('Felhasználó azonosító');
            $table->unsignedInteger('subdomain_id')->comment('Aldomain azonosító');
            $table->tinyInteger('level')->default(1)->comment('A felhasználói művelet sikeressége: 0 - sikertelen, 1 - sikeres');
            $table->string('what', 255);
            $table->string('with', 255);
            
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
        Schema::dropIfExists('logs');
    }
};

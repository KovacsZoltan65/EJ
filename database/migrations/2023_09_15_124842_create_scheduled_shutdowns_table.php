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
        Schema::create('scheduled_shutdowns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subdomain_id')->index('subdomain_id');
            $table->dateTime('datetime')->nullable()->default('1000-01-01 00:00:00');
            $table->integer('duration');
            $table->integer('user_id');
            $table->string('notes');
            $table->tinyInteger('executed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_shutdowns');
    }
};

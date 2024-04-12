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
        Schema::create('version_information_email_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->text('subdomain')->comment('példány');
            $table->tinyInteger('external_admin')->default(0)->comment('külső adminisztrátor');
            $table->tinyInteger('internal_admin')->default(0)->comment('belső adminisztrátor');
            $table->tinyInteger('papik')->default(0)->comment('papik');
            $table->tinyInteger('valid_counter')->default(0)->comment('érvényesség számláló');
            $table->tinyInteger('send_email')->default(1)->comment('kap email-t =1');
            $table->tinyInteger('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('version_information_email_addresses');
    }
};

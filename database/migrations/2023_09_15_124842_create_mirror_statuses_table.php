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
        Schema::create('mirror_statuses', function (Blueprint $table) {
            $table->increments('id')->comment('Rekord azonosító');
            $table->unsignedInteger('mirror_subdomain_id')->index('mirror_subdomain');
            $table->unsignedInteger('mirrored_subdomain_id')->nullable()->index('mirrored_subdomain');
            
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
        Schema::dropIfExists('mirror_statuses');
    }
};

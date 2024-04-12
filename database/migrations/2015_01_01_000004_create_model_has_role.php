<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
         * create_permission_tables -ben van
         */
        //Schema::create('table_model_has_role', function (Blueprint $table) {
        //    $table->bigInteger('role_id')->comment('Role rekord azonosító');
        //    $table->string('model_type')->comment('Model típusa');
        //    $table->bigInteger('model_id')->comment('Model rekord azonosító');
        //});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('table_model_has_role');
    }
};

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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('Rekord azonosító');
            $table->string('name')->comment('Felhasználó neve');
            $table->string('email')->unique()->comment('Felhasználó emali címe');
            $table->timestamp('email_verified_at')->nullable()->comment('Email ellenőrizve ekkor');
            $table->string('password')->comment('Jelszó');
            $table->string('language', 5)->default('hu')->comment('Nyelv');
            $table->rememberToken()->comment('Emlékeztető');
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

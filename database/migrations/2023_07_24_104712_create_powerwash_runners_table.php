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
        Schema::create('powerwash_runners', function (Blueprint $table) {
            $table->id();
            $table->char('userId', 8);
            $table->string('name', 255);
            $table->string('country', 255);
            $table->char('countryCode', 2);
            $table->char('colorFrom', 7);
            $table->char('colorTo', 7);
            $table->string('pronouns', 255);
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
        Schema::dropIfExists('powerwash_runners');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYtvideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ytvideos')) {
            Schema::create('ytvideos', function (Blueprint $table) {
                $table->increments('id');
                $table->char('sid', 11);
                $table->string('title', 255);
                $table->string('thumbnail', 255);
                $table->integer('date');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ytvideos');
    }
}

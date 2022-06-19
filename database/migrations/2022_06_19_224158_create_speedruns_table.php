<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeedrunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('speedruns')) {
            Schema::create('speedruns', function (Blueprint $table) {
                $table->increments('id');
                $table->char('sid', 8);
                $table->string('game', 255);
                $table->string('game_link', 255);
                $table->string('category', 255);
                $table->string('category_link', 255);
                $table->date('date');
                $table->float('time');
                $table->string('image', 255);
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
        Schema::dropIfExists('speedruns');
    }
}

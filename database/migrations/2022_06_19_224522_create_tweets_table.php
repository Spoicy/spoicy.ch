<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tweets')) {
            Schema::create('tweets', function (Blueprint $table) {
                $table->increments('id');
                $table->char('sid', 19);
                $table->string('text', 255);
                $table->string('link', 255);
                $table->string('media', 255)->default(null);
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
        Schema::dropIfExists('tweets');
    }
}

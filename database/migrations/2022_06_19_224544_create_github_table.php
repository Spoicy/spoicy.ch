<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGithubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('github')) {
            Schema::create('github', function (Blueprint $table) {
                $table->increments('id');
                $table->char('sid', 11);
                $table->string('title', 255);
                $table->string('link', 255);
                $table->string('author', 255);
                $table->string('type', 255);
                $table->text('entrydata');
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
        Schema::dropIfExists('github');
    }
}

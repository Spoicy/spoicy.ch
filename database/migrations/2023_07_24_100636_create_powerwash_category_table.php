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
        Schema::create('powerwash_categories', function (Blueprint $table) {
            $table->id();
            $table->char('levelId', 8);
            $table->char('subcatId', 8);
            $table->char('varId', 8);
            $table->enum('type', ['Vehicle', 'Location']);
            $table->string('name', 255);
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
        Schema::dropIfExists('powerwash_categories');
    }
};

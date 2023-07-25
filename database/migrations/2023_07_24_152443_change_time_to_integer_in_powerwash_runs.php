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
        Schema::table('powerwash_runs', function (Blueprint $table) {
            $table->dropColumn('time');
            
        });
        Schema::table('powerwash_runs', function (Blueprint $table) {
            $table->integer('time')->after('runnerId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('powerwash_runs', function (Blueprint $table) {
            $table->dropColumn('time');
            $table->decimal('time', 10, 3)->after('runnerId');
        });
    }
};

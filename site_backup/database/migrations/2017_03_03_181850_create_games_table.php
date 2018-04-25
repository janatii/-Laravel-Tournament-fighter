<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('subdomain')->unique();
            $table->unsignedInteger('time_per_round');
            $table->unsignedInteger('order');
            $table->unsignedInteger('platform_id');
            $table->unsignedInteger('network_id');
            $table->timestamps();
            
            $table->foreign('platform_id')
                  ->references('id')
                  ->on('platforms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsGamemodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps_gamemodes', function (Blueprint $table) {
            $table->unsignedInteger('map_id');
            $table->unsignedInteger('gamemode_id');
            $table->timestamps();
            
            $table->primary(['map_id', 'gamemode_id']);
            
            $table->foreign('map_id')
                ->references('id')
                ->on('maps')
                ->onDelete('restrict');
            
            $table->foreign('gamemode_id')
                ->references('id')
                ->on('gamemodes')
                ->onDelete('restrict');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maps_gamemodes');
    }
}

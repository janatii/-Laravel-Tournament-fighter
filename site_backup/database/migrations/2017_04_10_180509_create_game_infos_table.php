<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_infos', function (Blueprint $table) {
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('score');
            $table->unsignedInteger('win')->default(0);
            $table->unsignedInteger('lost')->default(0);
            $table->timestamps();
            
            $table->primary(['game_id', 'user_id']);
            
            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->onDelete('restrict');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('game_infos');
    }
}

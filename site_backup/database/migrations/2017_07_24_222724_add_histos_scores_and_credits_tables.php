<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHistosScoresAndCreditsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histos_scores', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('team_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('score');
            $table->integer('diff');
            $table->unsignedInteger('match_id')->nullable();
            $table->timestamps();
            
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('restrict');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            
            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->onDelete('restrict');
            
            $table->foreign('match_id')
                ->references('id')
                ->on('matches')
                ->onDelete('restrict');
        });
        
        Schema::create('histos_credits', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('credits');
            $table->integer('diff');
            $table->unsignedInteger('match_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            
            $table->foreign('match_id')
                ->references('id')
                ->on('matches')
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
        Schema::dropIfExists('histos_credits');
        Schema::dropIfExists('histos_scores');
    }
}

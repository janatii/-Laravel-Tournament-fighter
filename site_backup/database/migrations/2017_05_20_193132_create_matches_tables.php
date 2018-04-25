<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('squads', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('manager_id');
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('match_id');
            $table->timestamps();
            
            $table->foreign('manager_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('restrict');
        });
        
        Schema::create('squads_members', function (Blueprint $table) {
            $table->unsignedInteger('squad_id');
            $table->unsignedInteger('user_id');
            $table->boolean('confirmed');
            $table->timestamps();
            
            $table->primary(['squad_id', 'user_id']);
            
            $table->foreign('squad_id')
                ->references('id')
                ->on('squads')
                ->onDelete('cascade');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
        });
        
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['FRIENDLY', 'RANKED', 'WAGER']);
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('full_gamemode_id')->nullable();
            $table->integer('bo');
            $table->integer('vs');
            $table->integer('filter_score_min')->nullable();
            $table->integer('filter_score_max')->nullable();
            $table->integer('bet')->nullable();
            
            $table->boolean('premium');
            $table->boolean('wait_referee');
            $table->enum('status', ['ABORTED', 'WAIT_JOIN', 'WAIT_CONFIRM', 'IN_PROGRESS', 'FINISH']);
            
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('squad1_id')->nullable();
            $table->unsignedInteger('squad2_id')->nullable();
            $table->unsignedInteger('win_squad_id')->nullable();
            
            $table->timestamps();
            
            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->onDelete('restrict');
            
            $table->foreign('full_gamemode_id')
                ->references('id')
                ->on('gamemodes')
                ->onDelete('restrict');
            
            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            
            $table->foreign('squad1_id')
                ->references('id')
                ->on('squads')
                ->onDelete('set null');
            
            $table->foreign('squad2_id')
                ->references('id')
                ->on('squads')
                ->onDelete('set null');
            
            $table->foreign('win_squad_id')
                ->references('id')
                ->on('squads')
                ->onDelete('set null');
        });
        
        Schema::create('rounds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('match_id');
            $table->unsignedInteger('map_id');
            $table->unsignedInteger('gamemode_id');
            $table->unsignedInteger('win_squad_sent_by_squad1_id')->nullable();
            $table->unsignedInteger('win_squad_sent_by_squad2_id')->nullable();
            $table->unsignedInteger('win_squad_sent_by_referee_id')->nullable();
            $table->unsignedInteger('referee_id')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();
            
            $table->foreign('match_id')
                ->references('id')
                ->on('matches')
                ->onDelete('cascade');
            
            $table->foreign('map_id')
                ->references('id')
                ->on('maps')
                ->onDelete('restrict');
            
            $table->foreign('gamemode_id')
                ->references('id')
                ->on('gamemodes')
                ->onDelete('restrict');
            
            $table->foreign('win_squad_sent_by_squad1_id')
                ->references('id')
                ->on('squads')
                ->onDelete('restrict');
            
            $table->foreign('win_squad_sent_by_squad2_id')
                ->references('id')
                ->on('squads')
                ->onDelete('restrict');
            
            $table->foreign('win_squad_sent_by_referee_id')
                ->references('id')
                ->on('squads')
                ->onDelete('restrict');
            
            $table->foreign('referee_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
        });
        
        Schema::table('squads', function (Blueprint $table) {
            $table->foreign('match_id')
                ->references('id')
                ->on('matches')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('squads', function(Blueprint $table) {
            $table->dropForeign('squads_match_id_foreign');
            $table->dropColumn('match_id');
        });
        Schema::dropIfExists('rounds');
        Schema::dropIfExists('matches');
        Schema::dropIfExists('squads_members');
        Schema::dropIfExists('squads');
    }
}

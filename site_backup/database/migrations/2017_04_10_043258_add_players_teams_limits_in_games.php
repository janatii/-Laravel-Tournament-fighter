<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlayersTeamsLimitsInGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function(Blueprint $table) {
            $table->unsignedInteger('max_players_per_team');
            $table->unsignedInteger('max_teams_per_player');
            $table->unsignedInteger('max_teams_per_player_premium');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function(Blueprint $table) {
            $table->dropColumn('max_teams_per_player_premium');
            $table->dropColumn('max_teams_per_player');
            $table->dropColumn('max_players_per_team');
        });
    }
}

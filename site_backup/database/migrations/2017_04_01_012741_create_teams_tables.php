<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('country')->nullable();
            $table->string('website')->nullable();
            $table->unsignedInteger('score');
            $table->unsignedInteger('win')->default(0);
            $table->unsignedInteger('lost')->default(0);
            $table->boolean('recruiting')->default(1);
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('owner_id');
            $table->timestamps();
            
            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->onDelete('restrict');
            
            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
        });
        
        Schema::create('team_member', function (Blueprint $table) {
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('user_id');
            $table->enum('role', ['PLAYER', 'MANAGER'])->default('PLAYER');
            $table->timestamps();
            
            $table->primary(['team_id', 'user_id']);
            
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('restrict');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
        });
        
        Schema::create('team_candidate', function (Blueprint $table) {
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            
            $table->primary(['team_id', 'user_id']);
            
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('restrict');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
        });
        
        Schema::create('team_banished', function (Blueprint $table) {
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            
            $table->primary(['team_id', 'user_id']);
            
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('restrict');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
        });
        
        Schema::create('network_team', function (Blueprint $table) {
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('network_id');
            $table->string('identifier');
            $table->timestamps();
            
            $table->primary(['team_id', 'network_id']);
            
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('restrict');
            
            $table->foreign('network_id')
                ->references('id')
                ->on('networks')
                ->onDelete('restrict');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('active_team_id')->nullable()->after('locale');
            
            $table->foreign('active_team_id')
                  ->references('id')
                  ->on('teams')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_active_team_id_foreign');
            $table->dropColumn('active_team_id');
        });
        Schema::dropIfExists('network_team');
        Schema::dropIfExists('team_banished');
        Schema::dropIfExists('team_candidate');
        Schema::dropIfExists('team_member');
        Schema::dropIfExists('teams');
    }
}

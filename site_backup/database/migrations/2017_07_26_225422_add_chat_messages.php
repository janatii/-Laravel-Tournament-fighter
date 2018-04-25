<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChatMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('message');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('squad_id')->nullable();
            $table->unsignedInteger('match_id');
            $table->boolean('is_staff');
            $table->boolean('is_event');
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            
            $table->foreign('squad_id')
                ->references('id')
                ->on('squads')
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
        Schema::dropIfExists('chat_messages');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
        
        Schema::create('network_user', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('network_id');
            $table->string('identifier');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('network_id')
                ->references('id')
                ->on('networks')
                ->onDelete('cascade');
            
            $table->primary(['user_id', 'network_id']);
            
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
        Schema::dropIfExists('network_user');
        Schema::dropIfExists('networks');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAskCancelToMatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->unsignedInteger('ask_cancel_squad_id')->nullable()->after('wait_referee');
            $table->boolean('ask_cancel_accepted')->nullable()->after('ask_cancel_squad_id');
            $table->unsignedInteger('cancel_confirm_user_id')->nullable()->after('ask_cancel_accepted');
            
            $table->foreign('ask_cancel_squad_id')
                ->references('id')
                ->on('squads')
                ->onDelete('restrict');
            
            $table->foreign('cancel_confirm_user_id')
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
        Schema::table('matches', function (Blueprint $table) {
            $table->dropForeign('matches_cancel_confirm_user_id_foreign');
            $table->dropColumn('cancel_confirm_user_id');
            
            $table->dropForeign('matches_ask_cancel_squad_id_foreign');
            $table->dropColumn('ask_cancel_squad_id');
            
            $table->dropColumn('ask_cancel_accepted');
        });
    }
}

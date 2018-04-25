<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->text('description')->nullable()->after('birthdate');
            $table->string('gender')->nullable()->after('description');
            $table->string('country')->nullable()->after('gender');
            $table->string('website')->nullable()->after('country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('gender');
            $table->dropColumn('country');
            $table->dropColumn('website');
        });
    }
}

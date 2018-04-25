<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = config('laravel-permission.table_names');

        Schema::create($config['roles'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('is_staff');
            $table->timestamps();
        });

        Schema::create($config['permissions'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create($config['user_has_permissions'], function (Blueprint $table) use ($config) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('permission_id');

            $table->foreign('user_id')
                ->references('id')
                ->on($config['users'])
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($config['permissions'])
                ->onDelete('cascade');

            $table->primary(['user_id', 'permission_id']);

            $table->timestamps();
        });

        Schema::create($config['user_has_roles'], function (Blueprint $table) use ($config) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id');

            $table->foreign('role_id')
                ->references('id')
                ->on($config['roles'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($config['users'])
                ->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);

            $table->timestamps();
        });

        Schema::create($config['role_has_permissions'], function (Blueprint $table) use ($config) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($config['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($config['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);

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
        $config = config('laravel-permission.table_names');

        Schema::dropIfExists($config['role_has_permissions']);
        Schema::dropIfExists($config['user_has_roles']);
        Schema::dropIfExists($config['user_has_permissions']);
        Schema::dropIfExists($config['roles']);
        Schema::dropIfExists($config['permissions']);
    }
}

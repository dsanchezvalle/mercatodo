<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('is_admin', 'role_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->change();
            $table->foreign('role_id')->references('id')->on('roles');
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
            $table->dropForeign('users_role_id_foreign');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_is', 'is_admin');
            $table->string('is_admin')->default('0')->change();
        });
    }
}

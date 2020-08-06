<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'role_user';

    /**
     * Run the migrations.
     * @table role_user
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id');
            $table->foreignId('role_id');
            $table->foreignId('user_id');

            $table->index(["user_id"], 'fk_roles_has_users_users1_idx');

            $table->index(["role_id"], 'fk_roles_has_users_roles1_idx');


            $table->foreign('role_id', 'fk_roles_has_users_roles1_idx')
                ->references('id')->on('roles')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_id', 'fk_roles_has_users_users1_idx')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}

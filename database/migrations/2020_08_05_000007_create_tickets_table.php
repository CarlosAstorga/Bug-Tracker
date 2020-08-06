<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'tickets';

    /**
     * Run the migrations.
     * @table tickets
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id');
            $table->string('title', 50);
            $table->string('description', 100);
            $table->foreignId('submitter_id');
            $table->foreignId('priority_id')->nullable()->default('3');
            $table->foreignId('status_id')->nullable()->default('1');
            $table->foreignId('category_id');
            $table->foreignId('project_id')->nullable()->default(null);
            $table->foreignId('developer_id')->nullable()->default(null);

            $table->index(["priority_id"], 'fk_tickets_priorities1_idx');

            $table->index(["developer_id"], 'fk_tickets_users1_idx');

            $table->index(["category_id"], 'fk_tickets_categories1_idx');

            $table->index(["project_id"], 'fk_tickets_projects1_idx');

            $table->index(["status_id"], 'fk_tickets_status1_idx');
            $table->nullableTimestamps();


            $table->foreign('status_id', 'fk_tickets_status1_idx')
                ->references('id')->on('status')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('category_id', 'fk_tickets_categories1_idx')
                ->references('id')->on('categories')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('priority_id', 'fk_tickets_priorities1_idx')
                ->references('id')->on('priorities')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('project_id', 'fk_tickets_projects1_idx')
                ->references('id')->on('projects')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('developer_id', 'fk_tickets_users1_idx')
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

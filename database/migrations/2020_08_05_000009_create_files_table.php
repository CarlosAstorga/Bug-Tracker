<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'files';

    /**
     * Run the migrations.
     * @table files
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id');
            $table->string('file', 100);
            $table->foreignId('uploader_id');
            $table->string('notes', 100)->nullable()->default(null);
            $table->foreignId('ticket_id');

            $table->index(["ticket_id"], 'fk_files_tickets1_idx');
            $table->nullableTimestamps();


            $table->foreign('ticket_id', 'fk_files_tickets1_idx')
                ->references('id')->on('tickets')
                ->onDelete('no action')
                ->onUpdate('no action');
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

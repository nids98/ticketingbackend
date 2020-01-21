<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAndTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_and_tasks', function (Blueprint $table) {
            $table->bigInteger('task_id')->primary();
            $table->integer('emp_id');
            $table->string('status');
            $table->foreign('emp_id')
            ->references('emp_id')->on('employees')
            ->onDelete('cascade');
            // $table->foreign('task_id')
            // ->references('task_id')->on('tasks')
            // ->onDelete('cascade');
        });
 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_and_tasks');
    }
}

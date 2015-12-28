<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('tasks', function  (Blueprint $table) {
                $table->increments('id');
				$table->integer('userID')->unsigned();
                $table->string('name');
				$table->boolean('done');
				$table->dateTime('duedate')->nullable();
				$table->nullableTimestamps();				
				$table->softDeletes();	
				$table->foreign('userID')
      				->references('id')->on('users')
      				->onDelete('cascade');
				$table->index(['userID', 'done']);	
        	});
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks'); 
    }
}

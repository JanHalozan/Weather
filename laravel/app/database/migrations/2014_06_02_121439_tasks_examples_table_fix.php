<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TasksExamplesTableFix extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tasks_examples', function($table)
        {
            $table->increments('id');
        });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('tasks_examples', 'id'))
        {
            Schema::table('tasks_examples', function($table)
            {
                $table->dropColumn('id');
            });
        }
	}   
}

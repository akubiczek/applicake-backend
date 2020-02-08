<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessageTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('message_templates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('subject', 191)->default('');
			$table->text('body', 65535);
			$table->integer('type')->default(0);
			$table->integer('stage_id')->nullable();
			$table->integer('recruitment_id')->unsigned();
			$table->unique(['recruitment_id','stage_id'], 'recruitment_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('message_templates');
	}

}

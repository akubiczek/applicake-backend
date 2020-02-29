<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 191)->default('');
			$table->integer('recruitment_id')->unsigned()->index('recruitment_id_idx');
			$table->string('key', 8)->default('')->unique('key');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sources');
	}

}

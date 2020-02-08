<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCandidatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('candidates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('first_name', 191)->default('');
			$table->string('last_name', 191)->default('');
			$table->string('email', 191)->nullable();
			$table->string('phone_number', 40)->nullable();
			$table->boolean('future_agreement')->default(0);
			$table->string('path_to_cv', 191);
			$table->integer('source_id')->unsigned();
			$table->integer('recruitment_id')->unsigned()->index('recruitment_id');
			$table->dateTime('seen_at')->nullable();
			$table->integer('stage_id')->unsigned()->default(1);
			$table->integer('rate')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('candidates');
	}

}

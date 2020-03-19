<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCandidatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('candidates', function(Blueprint $table)
		{
			$table->foreign('recruitment_id', 'candidates_ibfk_1')->references('id')->on('recruitments')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('candidates', function(Blueprint $table)
		{
			$table->dropForeign('candidates_ibfk_1');
		});
	}

}

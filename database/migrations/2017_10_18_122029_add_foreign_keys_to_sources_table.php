<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sources', function(Blueprint $table)
		{
			$table->foreign('recruitment_id', 'sources_ibfk_1')->references('id')->on('recruitments')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sources', function(Blueprint $table)
		{
			$table->dropForeign('sources_ibfk_1');
		});
	}

}

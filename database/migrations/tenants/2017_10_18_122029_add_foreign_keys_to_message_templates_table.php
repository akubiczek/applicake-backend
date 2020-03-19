<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMessageTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('message_templates', function(Blueprint $table)
		{
			$table->foreign('recruitment_id', 'message_templates_ibfk_1')->references('id')->on('recruitments')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('message_templates', function(Blueprint $table)
		{
			$table->dropForeign('message_templates_ibfk_1');
		});
	}

}

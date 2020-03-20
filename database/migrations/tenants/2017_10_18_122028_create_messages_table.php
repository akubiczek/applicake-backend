<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
            $table->id('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('type')->default(1);
            $table->integer('candidate_id')->unsigned()->index('candidate_id');
            $table->string('subject', 191)->nullable()->default('');
            $table->text('body', 65535);
            $table->dateTime('scheduled_at')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('messages');
	}

}

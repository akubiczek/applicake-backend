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
            $table->id('id');
            $table->timestamps();
            $table->string('subject', 191)->default('');
            $table->text('body', 65535);
            $table->integer('type')->default(0);
            $table->integer('stage_id')->nullable();
            $table->foreignId('recruitment_id')->constrained()->onDelete('cascade');
            $table->unique(['recruitment_id', 'stage_id'], 'recruitment_stage_idx');
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

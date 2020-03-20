<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notes', function(Blueprint $table)
		{
            $table->id('id');
            $table->timestamps();
            $table->softDeletes();
            $table->text('body', 65535);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notes');
	}

}

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
            $table->id('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 191)->default('');
            $table->foreignId('recruitment_id')->constrained()->onDelete('cascade');
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

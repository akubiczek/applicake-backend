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
            $table->id('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 191)->default('');
            $table->string('email', 191)->nullable();
            $table->string('phone_number', 40)->nullable();
            $table->boolean('future_agreement')->default(0);
            $table->string('path_to_cv', 191);
            $table->integer('source_id')->unsigned()->nullable();
            $table->foreignId('recruitment_id')->constrained()->onDelete('cascade')->index('recruitment_id');
            $table->integer('source_recruitment_id')->unsigned()->nullable()->index('source_recruitment_id');
            $table->dateTime('seen_at')->nullable();
            $table->integer('stage_id')->unsigned()->default(1);
            $table->integer('rate')->nullable();
            $table->json('custom_fields')->nullable();
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

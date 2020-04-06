<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePredefinedMessagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predefined_messages', function (Blueprint $table) {
            $table->id('id');
            $table->timestamps();
            $table->foreignId('recruitment_id')->constrained()->onDelete('cascade');
            $table->integer('from_stage_id')->nullable();
            $table->integer('to_stage_id')->nullable();
            $table->string('subject', 191)->default('');
            $table->text('body', 65535);
            $table->integer('type')->default(0);
            $table->unique(['recruitment_id', 'from_stage_id', 'to_stage_id'], 'recruitment_stage_idx');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
    {
        Schema::drop('predefined_messages');
    }

}

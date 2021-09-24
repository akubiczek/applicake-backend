<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStageMessageTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stage_message_templates', function (Blueprint $table) {
            $table->id('id');
            $table->timestamps();
            $table->string('subject', 191)->default('');
            $table->text('body', 65535);
            $table->integer('type')->default(0);
            $table->integer('stage_id')->nullable()->unique('recruitment_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stage_message_templates');
    }
}

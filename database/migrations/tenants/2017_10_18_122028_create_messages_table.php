<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('type')->default(1);
            $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
            $table->string('to', 191);
            $table->string('from', 191);
            $table->string('reply_to', 191)->nullable();
            $table->string('cc', 191)->nullable();
            $table->string('subject', 191)->nullable()->default('');
            $table->text('body', 65535);
            $table->dateTime('scheduled_for')->nullable();
            $table->dateTime('sent_at')->nullable();
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

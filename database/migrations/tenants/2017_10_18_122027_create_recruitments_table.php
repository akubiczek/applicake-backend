<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecruitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 191)->default('');
            $table->string('job_title', 191)->default('');
            $table->string('notification_email', 191)->nullable();
            $table->boolean('is_draft')->default(true);
            $table->integer('state')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recruitments');
    }
}

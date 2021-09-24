<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id('id');
            $table->timestamps();
            $table->foreignId('recruitment_id')->constrained()->onDelete('cascade');
            $table->string('name', 191)->default('');
            $table->string('action_name', 191)->default('');
            $table->boolean('has_appointment')->default(false);
            $table->boolean('is_quick_link')->default(false);
            $table->integer('order')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stages');
    }
}

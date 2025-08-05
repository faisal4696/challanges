<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilestonsRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestons_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('mileston_id');
            $table->foreign('mileston_id')->references('id')->on('milestons')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('milestons_comment_id');
            $table->foreign('milestons_comment_id')->references('id')->on('milestons_comments')->onDelete('cascade')->onUpdate('cascade');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milestons_replies');
    }
}

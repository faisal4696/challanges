<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallangesRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challanges_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('challange_id');
            $table->foreign('challange_id')->references('id')->on('challanges')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('challanges_comment_id');
            $table->foreign('challanges_comment_id')->references('id')->on('challanges_comments')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('challanges_replies');
    }
}

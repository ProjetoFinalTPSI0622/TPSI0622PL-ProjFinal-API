<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_comment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comments_id');
            $table->unsignedBigInteger('attachments_id');
            $table->timestamps();

            $table->foreign('comments_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('attachments_id')->references('id')->on('attachments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachment_comment');
    }
}

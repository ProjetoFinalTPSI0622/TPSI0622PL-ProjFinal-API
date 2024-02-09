<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_ticket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tickets_id');
            $table->unsignedBigInteger('attachments_id');
            $table->timestamps();

            $table->foreign('tickets_id')->references('id')->on('tickets')->onDelete('cascade');
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
        Schema::dropIfExists('attachment_ticket');
    }
}

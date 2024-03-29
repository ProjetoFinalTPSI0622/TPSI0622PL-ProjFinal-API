<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('createdby')->nullable();
            $table->unsignedBigInteger('assignedto')->nullable();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('priority');
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('location');
            $table->dateTime('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('createdby')->references('id')->on('users');
            $table->foreign('assignedto')->references('id')->on('users');

            $table->foreign('status')->references('id')->on('statuses');
            $table->foreign('priority')->references('id')->on('priorities');
            $table->foreign('category')->references('id')->on('categories');
            $table->foreign('location')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}

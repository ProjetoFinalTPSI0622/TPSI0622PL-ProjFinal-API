<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('class')->nullable();
            $table->integer('nif');
            $table->date('birthday_date');
            $table->foreignId('gender_id')->nullable()->references('id')->on('genders')->onDelete('cascade')->onUpdate('cascade');
            $table->string('profile_picture_path');
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();



            $table->foreignId('country_id')->nullable()->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_infos');
    }
}

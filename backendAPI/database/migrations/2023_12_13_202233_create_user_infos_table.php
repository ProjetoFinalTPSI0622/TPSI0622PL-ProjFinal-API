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
            $table->id()->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('normalized_name');
            $table->int('nif');
            $table->date('birthday_date');
            $table->foreignId('gender_id')->references('id')->on('genders')->onDelete('cascade')->onUpdate('cascade');
            $table->string('profile_picture_path');
            $table->int('phone_number');
            $table->string('address');
            $table->foreignId('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('flights', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('skype')->unique()->nullable();
            $table->string('twiter')->unique()->nullable();
            $table->string('linkedin')->unique()->nullable();
            $table->string('facebook')->unique()->nullable();
            $table->boolean('activated')->default(0);
            $table->integer('user_id');
            $table->string('user_name')->unique();
            $table->string('full_name');
            $table->string('password');
            $table->rememberToken();
            $table->string('other');
            $table->text('about')->nullable();
            $table->text('location')->nullable();
            $table->text('skills')->nullable();
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
        Schema::dropIfExists('users');
    }
}

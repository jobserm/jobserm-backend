<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->date('birthdate')->nullable();
            $table->enum('role', ['ADMIN', 'USER'])
                ->default('USER');
            $table->string('phone', 20);
            $table->text('address')->nullable();
            $table->string('facebook')->nullable();
            $table->string('line')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->text('about_me')->nullable();
            $table->text('skill')->nullable();
            $table->boolean('activation')->default(true);
            $table->boolean('is_publish')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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

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
            $table->string('first_name');
            $table->string('last_name');

            $table->string('email')->unique();
            $table->string('phone_no')->unique();
            $table->string('city');
            $table->string('interest');
            $table->date('date_of_birth');
            $table->string('education_level');
            $table->boolean('is_active')->default(0);
            $table->boolean('is_subscribe')->default(0);
            $table->string('profile_picture')->unique();

            $table->foreignId('mentor_id');


            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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

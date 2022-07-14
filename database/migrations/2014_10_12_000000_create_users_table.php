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
            $table->string('city')->nullable();
            $table->string('interest')->nullable();
            $table->date('date_of_birth');
           // $table->string('education_level');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_subscribe')->default(0);
            //when user register for the first time they have to verify their phone no
            $table->string('otp');
            $table->string('profile_picture')->nullable();
            $table->foreignId('mentor_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('education_level_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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

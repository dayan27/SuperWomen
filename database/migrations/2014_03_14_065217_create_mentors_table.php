<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_no')->unique();
            $table->string('password');
            $table->text('biography')->nullable();
            // $table->foreignId('field_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('contact_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_active')->default(0);
            $table->string('profile_picture')->nullable();
            $table->boolean('is_verified');
            $table->string('verification_token');

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
        Schema::dropIfExists('mentors');
    }
}

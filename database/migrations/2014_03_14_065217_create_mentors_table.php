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
            $table->string('email')->nullable()->unique();
            $table->string('phone_number')->unique();
            $table->string('password')->nullable();
            $table->text('bio')->nullable();
            $table->date('date_of_birth');
            $table->string('location');
            
             $table->foreignId('field_id');
            // $table->foreignId('contact_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_active')->default(0);
            $table->string('profile_picture')->nullable();
            $table->boolean('is_accepted');
            $table->boolean('is_verified');
            $table->string('verification_code')->nullable();

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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_models', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("content");
            $table->text("intro");

            $table->integer("share")->default(0);
            $table->integer("like")->default(0);
            $table->integer("view")->default(0);
            $table->string("video")->nullable();
            $table->string('audio_path');

            // $table->date('posted_date');
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('time_take_to_read');
            $table->boolean('is_verified')->default(0);
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
        Schema::dropIfExists('role_models');
    }
}

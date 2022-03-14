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
            $table->text('title');
            $table->text('content');
            $table->integer("like");
            $table->integer("view");
            $table->integer("share");
            $table->string("video");
            $table->date('posted_date');
            $table->foreignId('content_writer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('time_take_to_read');


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

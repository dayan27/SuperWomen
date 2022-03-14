<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->String("title");
            $table->String("content");
            $table->integer("share");
            $table->integer("like");
            $table->integer("view");
            $table->date("posted_date");
            $table->integer("time_take_to_read");
            $table->foreignId('content_writer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();








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
        Schema::dropIfExists('blogs');
    }
}

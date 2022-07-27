<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_replays', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('blog_comment_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
           // $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
           // $table->foreignId('content_writer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            //why not using username only
            $table->string("replied_user");

            $table->date('replied_date');
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
        Schema::dropIfExists('blog_replays');
    }
}

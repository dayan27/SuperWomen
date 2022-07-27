<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleModelReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_model_replays', function (Blueprint $table) {
            $table->id();
            $table->text("content");
            $table->foreignId('role_model_comment_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('role_model_replays');
    }
}

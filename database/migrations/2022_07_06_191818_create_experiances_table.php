<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiances', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('organization');
            $table->date('from');
            $table->date('to');
            $table->boolean('is_current')->default(0);
            $table->foreignId('mentor_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();



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
        Schema::dropIfExists('experiances');
    }
}

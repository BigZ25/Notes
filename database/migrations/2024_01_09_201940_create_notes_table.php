<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->unsignedMediumInteger('color');
            $table->unsignedInteger('pos_x');
            $table->unsignedInteger('pos_y');
            $table->unsignedInteger('pos_z');
            $table->unsignedInteger('width');
            $table->unsignedInteger('height');
            $table->softDeletes();
            $table->timestamps();
            $table->userstamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}

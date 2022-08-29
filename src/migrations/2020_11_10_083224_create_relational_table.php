<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relational', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id');
            $table->foreignId('chapter_id');
            // $table->foreignId('class_id');
            // $table->foreignId('sub_chapter_id');
            $table->foreignId('problem_set_id');
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
        Schema::dropIfExists('relational');
    }
}

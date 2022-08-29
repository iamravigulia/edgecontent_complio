<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormatTypeProblemSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('format_type_problem_set', function (Blueprint $table) {
            $table->id();
            $table->foreignId('problem_set_id')->comment = 'id from problem set table';
            $table->foreignId('format_type_id')->comment = 'id from format type table';
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
        Schema::dropIfExists('format_type_problem_set');
    }
}

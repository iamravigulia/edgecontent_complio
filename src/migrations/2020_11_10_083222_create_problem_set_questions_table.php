<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemSetQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problem_set_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('problem_set_id')->comment = 'id from problem sets table';
            $table->foreignId('question_id')->comment = 'id of question';
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('problem_set_questions');
    }
}

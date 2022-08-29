<?php

namespace edgewizz\Edgecontent\Controllers;
use App\Http\Controllers\Controller;
use Edgewizz\Edgecontent\Models\DifficultyLevel;
use Edgewizz\Edgecontent\Models\FormatType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FormatController extends Controller
{
    public function store(Request $request){
        $format = new FormatType();
        $format->name = $request->name;
        $format->question_table_name = $request->question_table_name;
        $format->answer_table_name = $request->answer_table_name;
        $format->save();
        return back();
    }
    public function edit(Request $request, $id){
        $format = FormatType::findOrFail($id);
        $format->name = $request->name;
        $format->question_table_name = $request->question_table_name;
        $format->answer_table_name = $request->answer_table_name;
        $format->save();
        return back();
    }
    public function delete($id){
        $format = FormatType::findOrFail($id);
        $format->delete();
        return back();
    }

    public function seeder(){
        // ['name' => 'Flight 10']
        DB::table('format_types')->truncate();
        $f = FormatType::create(['name' => 'CMA', 'slug' => 'cma', 'question_table_name' => 'fmt_cma_ques', 'answer_table_name' => 'fmt_cma_ans']);
        $f = FormatType::create(['name' => 'Dad', 'slug' => 'dad', 'question_table_name' => 'fmt_dad_ques', 'answer_table_name' => 'fmt_dad_ans']);
        $f = FormatType::create(['name' => 'Draw', 'slug' => 'draw', 'question_table_name' => 'fmt_draw_ques', 'answer_table_name' => 'fmt_draw_ans']);
        $f = FormatType::create(['name' => 'fillup', 'slug' => 'fillup', 'question_table_name' => 'fmt_fillup_ques', 'answer_table_name' => 'fmt_fillup_ans']);
        $f = FormatType::create(['name' => 'Listen the Audio & Choose the letters and make a sentence', 'slug' => 'lamas', 'question_table_name' => 'fmt_lamas_ques', 'answer_table_name' => 'fmt_lamas_ans']);
        $f = FormatType::create(['name' => 'Listen the Audio & Choose the letters and make a word', 'slug' => 'lamaw', 'question_table_name' => 'fmt_lamaw_ques', 'answer_table_name' => 'fmt_lamaw_ans']);
        $f = FormatType::create(['name' => 'Listen to Audio; record the Audio', 'slug' => 'lara', 'question_table_name' => 'fmt_lara_ques']);
        $f = FormatType::create(['name' => 'lartram', 'slug' => 'lartram', 'question_table_name' => 'fmt_lartrm_ques', 'answer_table_name' => 'fmt_lartrm_ans']);
        $f = FormatType::create(['name' => 'Listen to Audio - read the meaning as text - sing/speak along', 'slug' => 'lasa', 'question_table_name' => 'fmt_lasa_ques']);
        $f = FormatType::create(['name' => 'laws', 'slug' => 'laws', 'question_table_name' => 'fmt_laws_ques']);
        $f = FormatType::create(['name' => 'map', 'slug' => 'map', 'question_table_name' => 'fmt_map_ques']);
        $f = FormatType::create(['name' => 'marew', 'slug' => 'marew', 'question_table_name' => 'fmt_marew_ques', 'answer_table_name' => 'fmt_marew_ans']);
        $f = FormatType::create(['name' => 'Match the pairs', 'slug' => 'mtp', 'question_table_name' => 'fmt_matchthepairs_ques', 'answer_table_name' => 'fmt_matchthepairs_ans']);
        $f = FormatType::create(['name' => 'MCQ', 'slug' => 'mcq', 'question_table_name' => 'fmt_mcq_ques', 'answer_table_name' => 'fmt_mcq_ans']);
        $f = FormatType::create(['name' => 'MCQ with Audio in options', 'slug' => 'mcqa', 'question_table_name' => 'fmt_mcqa_ques', 'answer_table_name' => 'fmt_mcqa_ans']);
        $f = FormatType::create(['name' => 'MCQ with Picture in options', 'slug' => 'mcqanpt', 'question_table_name' => 'fmt_mcqanpt_ques', 'answer_table_name' => 'fmt_mcqanpt_ans']);
        $f = FormatType::create(['name' => 'mcqp', 'slug' => 'mcqp', 'question_table_name' => 'fmt_mcqp_ques', 'answer_table_name' => 'fmt_mcqp_ans']);
        $f = FormatType::create(['name' => 'mcqpa', 'slug' => 'mcqpa', 'question_table_name' => 'fmt_mcqpa_ques', 'answer_table_name' => 'fmt_mcqpa_ans']);
        $f = FormatType::create(['name' => 'MCQ picture in question and audio in options', 'slug' => 'mcqpa2', 'question_table_name' => 'fmt_mcqpa2_ques', 'answer_table_name' => 'fmt_mcqpa2_ans']);
        $f = FormatType::create(['name' => 'mcqpan', 'slug' => 'mcqpan', 'question_table_name' => 'fmt_mcqpan_ques', 'answer_table_name' => 'fmt_mcqpan_ans']);
        $f = FormatType::create(['name' => 'mcqpc', 'slug' => 'mcqpc', 'question_table_name' => 'fmt_mcqpc_ques', 'answer_table_name' => 'fmt_mcqpc_ans']);
        $f = FormatType::create(['name' => 'Make a sentence ', 'slug' => 'mof', 'question_table_name' => 'fmt_mof_ques', 'answer_table_name' => 'fmt_mof_ans']);
        $f = FormatType::create(['name' => 'rew', 'slug' => 'rew', 'question_table_name' => 'fmt_rew_ques']);
        $f = FormatType::create(['name' => 'Read the Sentence ; record the Audio', 'slug' => 'rswa', 'question_table_name' => 'fmt_rswa_ques', 'answer_table_name' => 'fmt_rswa_ans']);
        $f = FormatType::create(['name' => 'rtrm', 'slug' => 'rtrm', 'question_table_name' => 'fmt_rtrm_ques', 'answer_table_name' => 'fmt_rtrm_ans']);
        $f = FormatType::create(['name' => 'Read the word, record the Audio', 'slug' => 'rwra', 'question_table_name' => 'fmt_rwra_ques', 'answer_table_name' => 'fmt_rwra_ans']);
        $f = FormatType::create(['name' => 'spchar', 'slug' => 'spchar', 'question_table_name' => 'fmt_spchar']);
        $f = FormatType::create(['name' => 'True and False', 'slug' => 'tnf', 'question_table_name' => 'fmt_tnf_ques', 'answer_table_name' => 'fmt_tnf_ans']);
        $f = FormatType::create(['name' => 'Make a word - Unjumble Words', 'slug' => 'unw', 'question_table_name' => 'fmt_unjumble_words_ques', 'answer_table_name' => 'fmt_unjumble_words_ans']);
        $f = FormatType::create(['name' => 'Unjumble Words Picture', 'slug' => 'unwp', 'question_table_name' => 'fmt_unjumble_words_picture_ques', 'answer_table_name' => 'fmt_unjumble_words_picture_ans']);
        DB::table('difficulty_levels')->truncate();
        $d = DifficultyLevel::create(['name' => 'Easy', 'score' => 10]);
        $d = DifficultyLevel::create(['name' => 'Medium', 'score' => 15]);
        $d = DifficultyLevel::create(['name' => 'Hard', 'score' => 20]);
        return 'Done';
    }
}
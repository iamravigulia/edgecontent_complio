<?php

namespace edgewizz\Edgecontent\Controllers;
use App\Http\Controllers\Controller;
use Edgewizz\Edgecontent\Models\FormatType;
use Edgewizz\Edgecontent\Models\ProblemSet;
use Edgewizz\Edgecontent\Models\ProblemSetFormat;
use Edgewizz\Edgecontent\Models\ProblemSetQues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\FuncCall;

class ProblemSetController extends Controller
{
    public function store(Request $request){
        $problemSet = new ProblemSet();
        $problemSet->max_limit = $request->max_ques;
        $problemSet->save();
        foreach($request->formats as $format){
            $pro_format = new ProblemSetFormat();
            $pro_format->problem_set_id = $problemSet->id;
            $pro_format->format_type_id = $format;
            $pro_format->save();
        }
        DB::table('relational')->insert([
            'chapter_id' => $request->pb_chapter_id,
            'problem_set_id' => $problemSet->id
        ]);
        return back();
        /* $problemSet = new ProblemSet();
        $problemSet->save();
        foreach($request->questions as $que){
            $problemSetQue = new ProblemSetQues();
            $problemSetQue->question_id = $que;
            $problemSetQue->format_type_id = $request->format_type;
            $problemSetQue->problem_set_id = $problemSet->id;
            $problemSetQue->save();
        }
        return back(); */
    }

    public function addMore($id, Request $request){
        $problemSet = ProblemSet::findOrFail($id);
        dd($request);
        foreach($request->add_more_questions as $que){
            $problemSetQue = new ProblemSetQues();
            $problemSetQue->question_id = $que;
            $problemSetQue->format_type_id = $request->format_type;
            $problemSetQue->problem_set_id = $problemSet->id;
            $problemSetQue->save();
        }
        return back();
    }

    public function delete($id){
        $problemSet = ProblemSet::findorFail($id);
        $pSetQues = ProblemSetQues::where('problem_set_id', $problemSet->id)->get();
        foreach($pSetQues as $que){
            $que->delete();
        }
        $prob_Formats = ProblemSetFormat::where('problem_set_id', $problemSet->id)->get();
        foreach($prob_Formats as $format){
            $format->delete();
        }
        $problemSet->delete();
        DB::table('relational')->where('problem_set_id', $problemSet->id)->delete();
        return back();
        // $problemSet = ProblemSet::findOrFail($id);
        // $pSetQues = ProblemSetQues::where('problem_set_id', $problemSet->id)->get();
        // foreach($pSetQues as $que){
        //     $que->delete();
        // }
        // $problemSet->delete();
        // return back();
    }
    public function toggleActive($id){
        $pSetQues = ProblemSetQues::where('id', $id)->first();
        if($pSetQues->active == 1){
            $pSetQues->active = 0;
        }else{
            $pSetQues->active = 1;
        }
        $pSetQues->save();
        return back();
    }
    public function change_problem_set($id, Request $request){
        // dd($id);
        $pSetQues = ProblemSetQues::where('id', $id)->firstOrFail();
        $pSetQues->problem_set_id = $request->other_problem_set;
        $pSetQues->save();
        // dd($pSetQues);
        return back();
    }
    public function change_problem_set_multi(Request $request){
        $move_multiple_box = $request->move_multiple_box;
        $multiBox = explode(",",$move_multiple_box);
        foreach($multiBox as $mox){
            $pSetQues = ProblemSetQues::where('id', $mox)->firstOrFail();
            $pSetQues->problem_set_id = $request->other_problem_set;
            $pSetQues->save();
        }
        // dd($pSetQues);
        return back();
    }

    public function edit($id, Request $request){
        $problemSet = ProblemSet::findOrFail($id);
        $problemSet->max_limit = $request->max_ques;
        $problemSet->formats()->sync($request->formats);
        $problemSet->save();
        $relation = DB::table('relational')->where('problem_set_id', $problemSet->id)->update(['chapter_id' => $request->pb_chapter_id]);

        // $checked_formats = ProblemSetFormat::where('problem_set_id', $problemSet->id)->pluck('format_type_id')->toArray();
        // dd($problemSet->formats);
        // foreach($request->formats as $format){
        //     $pro_format = new ProblemSetFormat();
        //     $pro_format->problem_set_id = $problemSet->id;
        //     $pro_format->format_type_id = $format;
        //     $pro_format->save();
        // }
        return back();
    }

    public function getQuestions($id){
        $format = FormatType::findOrFail($id);
        if (Schema::hasTable($format->question_table_name)) {
            $q_table = DB::table($format->question_table_name)->get();
        }else{
            $q_table = 'table is not available';
        }        
        $data = [];
        for($i = 0; $i < $q_table->count(); $i++){
            $data[$i] = [];
            array_push($data[$i], $q_table[$i]);
            $anss = DB::table('fmt_unjumble_words_ans')->where('question_id', $q_table[$i]->id)->get();
            array_push($data[$i], $anss);
        }
        return response()->json(
            $q_table
        );
    }

    public function getTopics(Request $request){
        $level_id = $request->level_id;
        $topics = DB::table('edw_prechapters')->where('level_id', $level_id)->where('active', 1)->get()->toJson();
        return $topics;
    }

    public function getSelectedChapters(Request $request){
        $relationz = DB::table('relational')->pluck('chapter_id')->all();
        $other_problem_sets = DB::table('problem_sets')->where('problem_sets.active', 1)->where('problem_sets.id', '!=', $request->topic_id)
            ->join('relational', 'relational.problem_set_id', 'problem_sets.id')
            ->join('edw_chapter', 'edw_chapter.id', 'relational.chapter_id')
            ->where('edw_chapter.chapt_level_id', $request->topic_id)
            ->select('edw_chapter.chapt_name', 'problem_sets.id')
            ->get()->toJson();
        return $other_problem_sets;
    }

    public function getChapters(Request $request){
        $topic_id = $request->topic_id;
        $relationz = DB::table('relational')->pluck('chapter_id')->all();
        $chapters = DB::table('edw_chapter')
            ->where('edw_chapter.chapt_level_id', $topic_id)
            ->where('edw_chapter.active', 1)
            ->whereNotIn('edw_chapter.id', $relationz)
            ->select('edw_chapter.id', 'edw_chapter.chapt_name')
            ->get()->toJson();
        return $chapters;
    }

    public function getChapters_without_topic(Request $request){
        $level_id = $request->level_id;
        $relationz = DB::table('relational')->pluck('chapter_id')->all();
        $chapters = DB::table('edw_chapter')
            ->where('edw_chapter.chapt_level_id', $level_id)
            ->where('edw_chapter.active', 1)
            ->whereNotIn('edw_chapter.id', $relationz)
            ->select('edw_chapter.id', 'edw_chapter.chapt_name')
            ->get()->toJson();
        return $chapters;
    }

    public function getSelectedChapterss_without_topic(Request $request){
        $relationz = DB::table('relational')->pluck('chapter_id')->all();
        $other_problem_sets = DB::table('problem_sets')->where('problem_sets.active', 1)
            ->join('relational', 'relational.problem_set_id', 'problem_sets.id')
            ->join('edw_chapter', 'edw_chapter.id', 'relational.chapter_id')
            ->where('edw_chapter.chapt_level_id', $request->level_id)
            ->select('edw_chapter.chapt_name', 'problem_sets.id')
            ->get()->toJson();
        return $other_problem_sets;
    }

    public function removeoption($que_id, $option_id){
        
        $problem_set_questions = DB::table('problem_set_questions')->where('id', $que_id)->first();
        $queTable = DB::table('format_types')->where('id', $problem_set_questions->format_type_id)->first();
        $option = DB::table($queTable->answer_table_name)->where('id', $option_id)->delete();
        // return Redirect::back()->withErrors(['password' => ['Invalid Username or Password']]);
        // Session::flash('message', "Special message goes here");
        return redirect()->back()->with('success', 'your message,here');   
        return back()->withErrors('success', 'Option Removed');
    }

    public function sequencePage($id)
    {
        $que = DB::table('problem_set_questions')->where('id', $id)->where('active', 1)->first();
        
        $fm = DB::table('format_types')
            ->where('id', $que->format_type_id)
            ->select('id', 'name', 'slug', 'question_table_name', 'answer_table_name')
            ->first();
            
        $question = DB::table($fm->question_table_name)->where('id', $que->question_id)->first();
       
        $answers = DB::table($fm->answer_table_name)->where('question_id',$question->id)->get();
        
        return view('practices.sequence_option', ['question' => $question,'answers' => $answers,'tname' => $fm->answer_table_name]);
    }

    public function sequencePageSort(Request $request)
    {
        // Log::info('post data'.json_encode($request->all()));
        $table_name =DB::table($request->tname)->get();
        foreach ($table_name as $tn) {
            foreach ($request->order as $order) {
                if ($order['id'] == $tn->id) {
                    DB::table($request->tname)
                        ->where('id',$order['id'])
                        ->update(['sequence' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => 200]);
    }
}
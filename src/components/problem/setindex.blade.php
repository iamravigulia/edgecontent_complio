<style>
    table {
        background: #fff;
        width: 100%;
        border: 0;
    }
    th {
        padding: 10px 5px;
        text-align: left;
        border: 1px solid rgba(206, 206, 206, 0.789);
    }
    td {
        border: 1px solid rgba(206, 206, 206, 0.789);
        padding: 5px;
    }
    tr:nth-child(odd) {
        background: rgb(242, 242, 242);
    }
    .fmt_fpm_date{
        font-size: 12px;
    }
    .fmt_fpm_addMore{
        font-size:12px;
        background: rgb(0, 189, 28);
        color:#fff;
        padding: 1px 4px;
        display: inline;
        border: none;
        border-radius: 4px;
    }
    .fmt_fpm_edit{
        font-size:12px;
        background: rgb(0, 98, 189);
        color:#fff;
        padding: 1px 4px;
        display: inline;
        border: none;
        border-radius: 4px;
    }
    .fmt_fpm_delete{
        font-size:12px;
        background: rgb(189, 13, 0);
        color:#fff;
        padding: 1px 4px;
        display: inline;
        border: none;
        border-radius: 4px;
    }
    #fmt_problem_set2_index_length{
        
    }
    #fmt_problem_set2_index_wrapper{
        display: block;
    }
    .removeOption{
        display:inline-block; border-radius:15px; height:20px; padding:0 4px; color:#fff; background:#000;
    }
    .removeOption:hover{
        color:#fff; background:red;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">


<button id="btnSelectedRows" style="background:rgb(0, 149, 182); color:rgb(242, 242, 242); border-radius:4px; padding: 2px 8px; margin: 4px 0;">
    Move Multiple
</button>
@if (isset($success) && $success)
    {{$success}}
@endif
<table class="cell-border" id="fmt_problem_set2_index" style="width:100%">
<thead>
    <th></th>
    <th>#</th>
    <th>Question</th>
    <th>Answers</th>
    <th>Active</th>
    <th>Created/Updated</th>
    <th>Actions</th>
</thead>
<tbody>
    @php


        $pb22 = DB::table('problem_sets')->where('id', $set)->first();
        $ques22 = DB::table('problem_set_questions')->where('problem_set_id', $pb22->id)->where('active', 1)->get();
        $other_problem_sets = DB::table('problem_sets')->where('problem_sets.active', 1)->where('problem_sets.id', '!=', $pb22->id)
        ->join('relational', 'relational.problem_set_id', 'problem_sets.id')
        ->join('edw_chapter', 'edw_chapter.id', 'relational.chapter_id')
        ->select('edw_chapter.chapt_name', 'problem_sets.id')
        ->get();
        $levelx =  DB::table('edw_level')->where('edw_level.active', 1)->get();
    @endphp
    @foreach ($ques22 as $que)
    <tr>
        <td></td>
        <td>{{$que->id}}</td>
        <td>
            @php 
            $fm = DB::table('format_types')
            ->where('id', $que->format_type_id)
            ->select('id', 'name', 'slug', 'question_table_name', 'answer_table_name')
            ->first() @endphp
            <div class="w-full">
                <div style="margin:2px; display:inline-block; font-size:12px; padding:2px 4px; background:#707070; border-radius:4px; color:#fff">{{$fm->name}}</div>
                @php $question = DB::table($fm->question_table_name)->where('id', $que->question_id)->first(); @endphp
                {{-- {{$fm->question_table_name}}
                {{$que->question_id}} --}}
                @if($question)
                @if (isset($question->media_id))
                    @php $media = DB::table('media')->where('id', $question->media_id)->select('id', 'url')->first(); @endphp
                    @if (strpos($media->url, '.mp3'))
                        <b>Question as English Audio:</b>
                        <div>{{$question->question ?? $question->question_title ?? ' '}}</div>
                        <audio controls="controls" src="{{url('/')}}/storage/{{$media->url}}"></audio>
                        {{-- spanish --}}
                        @if (isset($question->media_id_es))
                            @php $media_es = DB::table('media')->where('id', $question->media_id_es)->select('id', 'url')->first(); @endphp
                            @if (strpos($media_es->url, '.mp3'))
                            <b>Question as Spanish Audio:</b>
                            <audio controls="controls" src="{{url('/')}}/storage/{{$media_es->url}}"></audio>
                            @endif
                        @endif
                        {{-- end of spanish --}}
                    @else
                        <b>Question as Image:</b>
                        <div>{{$question->question ?? $question->question_title ?? ' '}}</div>
                        <img style="width:50px; height:auto;" src="{{url('/')}}/storage/{{$media->url}}" alt="">
                    @endif
                @elseif($fm->question_table_name == 'fmt_mc2pq_ques' || $fm->question_table_name == 'fmt_mc4pq_ques')
                    <div class="block"><b>Question:</b> {{$question->question ?? $question->question_title ?? 'n/a'}}</div>
                    @php $media1 = DB::table('media')->where('id', $question->media1_id)->select('id', 'url')->first(); @endphp
                    @php $media2 = DB::table('media')->where('id', $question->media2_id)->select('id', 'url')->first(); @endphp
                    @if($media1)
                        @if ($fm->question_table_name == 'fmt_mc4pq_ques')
                            <b>media title1:</b>{{$question->media_title1}} <br>
                        @endif
                        <img style="width:50px; height:auto;" src="{{url('/')}}/storage/{{$media1->url}}" alt="">
                    @endif
                    @if($media2)
                        @if ($fm->question_table_name == 'fmt_mc4pq_ques')
                            <b>media title2:</b>{{$question->media_title2}} <br>
                        @endif
                        <img style="width:50px; height:auto;" src="{{url('/')}}/storage/{{$media2->url}}" alt="">
                    @endif
                    @if ($fm->question_table_name == 'fmt_mc4pq_ques')
                        @php $media3 = DB::table('media')->where('id', $question->media3_id)->select('id', 'url')->first(); @endphp
                        @php $media4 = DB::table('media')->where('id', $question->media4_id)->select('id', 'url')->first(); @endphp
                        @if($media3)
                            @if ($fm->question_table_name == 'fmt_mc4pq_ques')
                                <b>media title3:</b>{{$question->media_title3}} <br>
                            @endif
                            <img style="width:50px; height:auto;" src="{{url('/')}}/storage/{{$media3->url}}" alt="">
                        @endif
                        @if($media4)
                            @if ($fm->question_table_name == 'fmt_mc4pq_ques')
                                <b>media title4:</b>{{$question->media_title4}} <br>
                            @endif
                            <img style="width:50px; height:auto;" src="{{url('/')}}/storage/{{$media4->url}}" alt="">
                        @endif
                    @endif
                @elseif($fm->question_table_name == 'fmt_map_ques' || $fm->question_table_name == 'fmt_rew_ques')
                @php $arr_q = explode (",", $question->question); @endphp
                    @foreach ($arr_q as $aq)
                        @if ($aq == $question->error)
                        <span style="color:rgb(187, 2, 2); text-decoration:underline;">{{$aq}}</span>
                        @else 
                        {{$aq}}
                        @endif
                    @endforeach
                @elseif($fm->question_table_name == 'fmt_ltl_ques')
                @php $baseUrl    = app('url')->asset('storage/'); @endphp
                    <div><b>Letter: </b>{{$question->letter}}</div>
                    @isset($question->letter_image_media_id)
                        @php $l_i_m = DB::table('media')->where('id', $question->letter_image_media_id)->select('id', 'url')->first(); @endphp
                    <div><img style="width:50px;" src="{{$baseUrl}}/{{$l_i_m->url}}" alt=""></div>
                    @endisset
                    @isset($question->letter_audio_media_id)
                        @php $l_i_a = DB::table('media')->where('id', $question->letter_audio_media_id)->select('id', 'url')->first(); @endphp
                        <div><audio src="{{$baseUrl}}/{{$l_i_a->url}}" controls>
                            Your browser does not support the audio element.
                            </audio>
                        </div>
                    @endisset
                    <div><b>Letter Transliteration: </b>{{$question->letter_trans}}</div>
                    <div><b>Word: </b>{{$question->word}}</div>
                    {{-- <div><img style="width:50px;" src="{{$baseUrl}}/{{$q__media->first()->word_image}}" alt=""></div>
                    <div><audio src="{{$baseUrl}}/{{$q__media->first()->word_audio}}" controls>
                        Your browser does not support the audio element.
                        </audio>
                    </div> --}}

                    @isset($question->word_image_media_id)
                        @php $w_i_m = DB::table('media')->where('id', $question->word_image_media_id)->select('id', 'url')->first(); @endphp
                    <div><img style="width:50px;" src="{{$baseUrl}}/{{$w_i_m->url}}" alt=""></div>
                    @endisset
                    @isset($question->word_audio_media_id)
                        @php $w_i_a = DB::table('media')->where('id', $question->word_audio_media_id)->select('id', 'url')->first(); @endphp
                        <div><audio src="{{$baseUrl}}/{{$w_i_a->url}}" controls>
                            Your browser does not support the audio element.
                            </audio>
                        </div>
                    @endisset

                    <div><b>Word Transliteration: </b>{{$question->word_trans}}</div>
                    <div><b>meaning: </b>{{$question->meaning}}</div>
                    <div><b>info: </b>{{$question->info}}</div>
                @elseif($fm->question_table_name == 'fmt_ltw_ques')
                @php $baseUrl    = app('url')->asset('storage/'); @endphp
                    <div><b>word: </b>{{$question->word}}</div>
                    @isset($question->word_image_media_id)
                        @php $l_i_m = DB::table('media')->where('id', $question->word_image_media_id)->select('id', 'url')->first(); @endphp
                    <div><img style="width:50px;" src="{{$baseUrl}}/{{$l_i_m->url}}" alt=""></div>
                    @endisset
                    @isset($question->word_audio_media_id)
                        @php $l_i_a = DB::table('media')->where('id', $question->word_audio_media_id)->select('id', 'url')->first(); @endphp
                        <div><audio src="{{$baseUrl}}/{{$l_i_a->url}}" controls>
                            Your browser does not support the audio element.
                            </audio>
                        </div>
                    @endisset
                    <div><b>word Transliteration: </b>{{$question->word_trans}}</div>
                    <div><b>word meaning: </b>{{$question->word_meaning}}</div>
                    {{-- word --}}
                    <div style="margin:10px;">
                        <div><b>word_1:             </b>{{$question->word_1}}</div>
                        <div><b>word_1_eng:         </b>{{$question->word_1_eng}}</div>
                        <div><b>word_1_eng_mean:    </b>{{$question->word_1_eng_mean}}</div>
                        <div><b>word_2:             </b>{{$question->word_2}}</div>
                        <div><b>word_2_eng:         </b>{{$question->word_2_eng}}</div>
                        <div><b>word_2_eng_mean:    </b>{{$question->word_2_eng_mean}}</div>
                    </div>
                    <div style="margin:10px;">
                        <div><b>sentence:           </b>{{$question->sentence}}</div>
                        @isset($question->sentence_audio_media_id)
                            @php $s__i_a = DB::table('media')->where('id', $question->sentence_audio_media_id)->select('id', 'url')->first(); @endphp
                            <div><audio src="{{$baseUrl}}/{{$s__i_a->url}}" controls>
                                Your browser does not support the audio element.
                                </audio>
                            </div>
                        @endisset
                    </div>
                    <div style="margin:10px;">
                        <div><b>gender_1:             </b>{{$question->gender_1}}</div>
                        <div><b>gender_2:             </b>{{$question->gender_2}}</div>
                        <div><b>gender_3:             </b>{{$question->gender_3}}</div>
                        <div><b>r_word_1:             </b>{{$question->r_word_1}}</div>
                        <div><b>r_word_2:             </b>{{$question->r_word_2}}</div>
                        <div><b>r_word_3:             </b>{{$question->r_word_3}}</div>
                    </div>
                @else
                    <div class="block"><b>Question:</b> {{$question->question ?? $question->question_title ?? 'n/a'}}</div>
                @endif
                @else 
                    <div>Question id is not right</div>
                @endif
            </div>
        </td>
        <td>
            @if($fm->answer_table_name == 'fmt_unjumble_words_ans' || $fm->answer_table_name == 'fmt_mof_ans' || $fm->answer_table_name == 'fmt_mawr_ans' || $fm->answer_table_name == 'fmt_lamas_ans' || $fm->answer_table_name == 'fmt_lamaw_ans')
                @php $answers = DB::table($fm->answer_table_name)->where('question_id', $que->question_id)->orderBy('sequence')->get(); @endphp
                @foreach ($answers as $answer)
                    <li>{{$answer->answer ?? 'n/a'}} <a href="{{route('fmt.edgecontent.removeoption', 
                        ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a></li>
                @endforeach
                @if($fm->answer_table_name == 'fmt_mof_ans')
                <div style="color:blue;">
                    <b>Answer: </b>
                    @foreach ($answers as $answer)
                        {{$answer->answer}} <a href="{{route('fmt.edgecontent.removeoption', 
                        ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a>
                    @endforeach
                </div>
                @elseif($fm->answer_table_name == 'fmt_unjumble_words_ans')
                <div style="color:rgb(0, 149, 182);">
                    <b>Answer: </b>
                    @foreach ($answers as $answer){{$answer->answer}} <a href="{{route('fmt.edgecontent.removeoption', 
                    ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a>@endforeach
                </div>
                @endif
            @elseif($fm->answer_table_name == 'fmt_mcq_ans' || $fm->answer_table_name == 'fmt_fillmcq_ans' || $fm->answer_table_name == 'fmt_mcqt_ans' || $fm->answer_table_name == 'fmt_mcqpc_ans' || $fm->answer_table_name == 'fmt_fillup_ans' || $fm->answer_table_name == 'fmt_mcqp_ans' || $fm->answer_table_name == 'fmt_mcaq_ans' || $fm->answer_table_name == 'fmt_mc2pq_ans' || $fm->answer_table_name == 'fmt_mc4pq_ans' || $fm->answer_table_name == 'fmt_tnf_ans' || $fm->answer_table_name == 'fmt_dad_ans' || $fm->answer_table_name == 'fmt_cma_ans' || $fm->answer_table_name == 'fmt_gridtnf_ans')
                @php $answers = DB::table($fm->answer_table_name)->where('question_id', $que->question_id)->orderBy('sequence')->get(); @endphp
                @foreach ($answers as $answer)
                    <li @if($answer->arrange == 1) style="color:blue;" @endif >{{$answer->answer ?? 'n/a'}} <a href="{{route('fmt.edgecontent.removeoption', 
                    ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a></li>
                @endforeach 
            @elseif($fm->question_table_name == 'fmt_lartrm_ques')
                @php $answer = DB::table($fm->answer_table_name)->where('question_id', $que->question_id)->first(); @endphp                
                <li style="color:blue;">{{$answer->answer ?? 'n/a'}} <a href="{{route('fmt.edgecontent.removeoption', 
                    ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a></li>
            @elseif($fm->question_table_name == 'fmt_map_ques')
                <li style="color:blue;">{{$question->error ?? 'n/a'}} <a href="{{route('fmt.edgecontent.removeoption', 
                    ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a></li>
            @elseif($fm->question_table_name == 'fmt_rew_ques')
                <li style="color:blue;">{{$question->correct ?? 'n/a'}} <a href="{{route('fmt.edgecontent.removeoption', 
                    ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a></li>
            @elseif($fm->answer_table_name == 'fmt_matchthepairs_ans')
                @php $fmt_mtp_ans = DB::table($fm->answer_table_name)->where('question_id', $que->question_id)->orderBy('sequence')->get() @endphp
                <table style="width: 100%;">
                    @foreach ($fmt_mtp_ans as $ans)
                    @if ($ans->match_id)
                        <tr style="width:50%; float:left;">
                            <td>{{$ans->answer}}</td>
                        </tr>
                        @else
                        <tr style="width:50%;">
                            <td>{{$ans->answer}}</td>
                        </tr>
                    @endif

                    @endforeach
                </table>
            @elseif($fm->answer_table_name == 'fmt_mtpp_pic')
                @php $fmt_mtpp_pic = DB::table($fm->answer_table_name)->where('question_id', $que->question_id)->orderBy('sequence')->get() @endphp
                <table style="width: 100%;">
                    @foreach ($fmt_mtpp_pic as $ans)
                    @if($ans->media_id)
                    @php $media = DB::table('media')->where('id', $ans->media_id)->select('id','url')->first(); @endphp
                    @php $text = DB::table('fmt_mtpp_text')->where('pic_id', $ans->id)->select('text')->first(); @endphp
                    <tr>
                        <td>
                            <img src="{{url('/')}}/storage/{{$media->url}}" style="width:40px; height:30px; margin-left:10px; object-fit:cover;">
                        </td>
                        <td>{{$text->text}}</td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            @elseif($fm->answer_table_name == 'fmt_mcqpa2_ans' || $fm->answer_table_name == 'fmt_mcqpan_ans')
                @php $answers = DB::table($fm->answer_table_name)->where('question_id', $que->question_id)->orderBy('sequence')->get(); @endphp
                @foreach ($answers as $answer)
                    <li style="display: flex; margin:5px 0; @if($answer->arrange == 1) border-left:4px solid blue; @endif">
                        <span @if($answer->arrange == 1) style="color:blue;" @endif>{{$answer->answer}}</span>
                        <div>
                            @php $image = DB::table('media')->where('id', $answer->media_id)->select('id', 'url')->first(); @endphp
                            @if($image)
                            <img src="{{url('/')}}/storage/{{$image->url}}" style="width:40px; height:30px; margin-left:10px; object-fit:cover;"></li>
                            @endif
                        </div>
                        <a href="{{route('fmt.edgecontent.removeoption', 
                        ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a>
                    </li>
                @endforeach 
            @elseif($fm->answer_table_name == 'fmt_mcqa_ans')
                @php $answers = DB::table($fm->answer_table_name)->where('question_id', $que->question_id)->orderBy('sequence')->get(); @endphp
                @foreach ($answers as $answer)
                    <li style="margin:10px 0; border:1px solid #000; padding: 10px 4px; @if($answer->arrange == 1) border-left:4px solid blue; @endif">
                        <span @if($answer->arrange == 1) style="color:blue;" @endif>{{$answer->answer}}</span>
                        <div style="">
                            @php $audio = DB::table('media')->where('id', $answer->media_id)->select('id', 'url')->first(); @endphp
                            @php $audio_es = DB::table('media')->where('id', $answer->media_id_es)->select('id', 'url')->first(); @endphp
                            @if($audio)
                            <small>English Audio</small>
                            <audio controls="controls" src="{{url('/')}}/storage/{{$audio->url}}"></audio>
                            @endif
                            @if($audio_es)
                            <small>Spanish Audio</small>
                            <audio controls="controls" src="{{url('/')}}/storage/{{$audio_es->url}}"></audio>
                            @endif
                            <a href="{{route('fmt.edgecontent.removeoption', 
                            ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a>
                        </div>
                    </li>
                @endforeach 
            @elseif($fm->answer_table_name == 'fmt_mcqanpt_ans')
                @php $answers = DB::table($fm->answer_table_name)->where('question_id', $que->question_id)->orderBy('sequence')->get(); @endphp
                @foreach ($answers as $answer)
                    <li style="display: flex; margin:5px 0; @if($answer->arrange == 1) border-left:4px solid blue; @endif">
                        <span @if($answer->arrange == 1) style="color:blue;" @endif>{{$answer->answer}}</span>
                        <div>
                            @php $img = DB::table('media')->where('id', $answer->media_id)->select('id', 'url')->first() @endphp
                            @if($img)
                            <img style="width:20px; width:20px;" src="{{url('/')}}/storage/{{$img->url}}" alt="">
                            @endif
                        </div>
                        <a href="{{route('fmt.edgecontent.removeoption', 
                        ['que_id'=>$que->id,'option_id'=>$answer->id])}}" class="removeOption" title="Delete this option">x</a>
                    </li>
                @endforeach 
            @endif
        </td>
        <td style="text-align: center;">
            {{$que->active}}
        </td>
        <td>
            <div class="fmt_fpm_date">
                <span>Created:</span>
                {{date('d-n-Y, g:i a',strtotime($que->created_at))}}
            </div>
            <div class="fmt_fpm_date">
                <span>Updated:</span>
                {{date('d-n-Y, g:i a',strtotime($que->updated_at))}}
            </div>
        </td>
        <td>
            @if ($fm->question_table_name == 'fmt_mcq_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMCQ({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcq.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mcqp_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMCQP({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcqpc.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_fillmcq_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalFILLMCQ({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcqpc.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mcaq_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMCAQ({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcqpc.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mc2pq_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMC2PQ({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcqpc.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mcqpc_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMCQPC({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcqpc.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mcqpa2_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMCQPA2({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcqpa2.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mcqpan_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMCQPAN({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcqpan.active', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_tnf_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalTnF({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.tnf.active', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_gridtnf_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalGRIDTNF({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.tnf.active', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mcqa_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMCQA({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcqa.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_dad_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalDAD({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.dad.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mof_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMOF({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mof.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_matchthepairs_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMTP({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mof.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mtpp_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMTPP({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mof.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_unjumble_words_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalUNW({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.unw.inactive', $que->question_id)}}">Delete</a> --}}
            {{-- @elseif($fm->question_table_name == 'fmt_unjumble_words_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalFILL({{$que->question_id}})">Edit</a>
                <a class="fmt_fpm_delete" href="{{route('fmt.unw.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_fillup_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalFILL({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.fillup.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_map_ques')
                {{-- <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMAP({{$que->question_id}})">Edit</a> --}}
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.map.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_rew_ques')
                {{-- <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMAP({{$que->question_id}})">Edit</a> --}}
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.rew.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_lasa_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalLASA({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.lasa.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_laws_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalLAWS({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.laws.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_lamas_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalLAMAS({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.lamas.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_lamaw_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalLAMAW({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.laws.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_rswa_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalRSWA({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.rswa.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_rwra_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalRWRA({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.rwra.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_lara_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalLARA({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.lara.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_lartrm_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalLARTRM({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.lartrm.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mcqanpt_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMCQANPT({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.mcqanpt.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_cma_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalCMA({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.cma.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_ltl_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalLTL({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.cma.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_ltw_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalLTW({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.cma.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mawr_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMAWR({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.cma.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mcqt_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMCQT({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.cma.inactive', $que->question_id)}}">Delete</a> --}}
            @elseif($fm->question_table_name == 'fmt_mawra_ques')
                <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalMAWRA({{$que->question_id}})">Edit</a>
                {{-- <a class="fmt_fpm_delete" href="{{route('fmt.cma.inactive', $que->question_id)}}">Delete</a> --}}
            @endif
            
            @if($que->active == 1)
                <a style="padding:1px 4px; font-size:12px; border-radius:4px; color:#fff; background:rgb(174, 0, 0);" href="{{route('fmt.edgecontent.psq.toggle', $que->id)}}">inactive</a>
            @else
                <a style="padding:1px 4px; font-size:12px; border-radius:4px; color:#fff; background:rgb(0, 187, 16);" href="{{route('fmt.edgecontent.psq.toggle', $que->id)}}">active</a>
            @endif
            <a href="javascript:void(0);" onclick="modal_moveFormat({{$que->id}})" style="padding:1px 4px; font-size:12px; border-radius:4px; color:#fff; background:rgb(171, 0, 187);">move</a>
            <a href="javascript:void(0);" onclick="modal_previewFormat({{$que->id}})"style="padding:1px 4px; font-size:12px; border-radius:4px; color:#fff; background:rgb(250, 205, 26);" >preview</a>

            <a href="{{route('sequenceoption', $que->id)}}" style="padding:1px 4px; font-size:12px; border-radius:4px; color:#fff; background:rgb(6, 111, 130);" >sequence</a>

        </td>
    </tr>
        @php
            $newQrray = array(
                'id' => $que->id,
                'other_problem_sets' => $other_problem_sets,
                'levelx' => $levelx
            );
        @endphp
        <x-problem.move_set :newQrray="$newQrray"/>
        @if ($fm->question_table_name === 'fmt_mcq_ques')
            <x-mcq.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mcqp_ques')
            <x-mcqp.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_fillmcq_ques')
            <x-fillmcq.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mcaq_ques')
            <x-mcaq.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mc2pq_ques')
            <x-mc2pq.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mc4pq_ques')
            <x-mc4pq.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mcqpc_ques')
            {{-- <x-mcqpc.edit :message="$que->question_id"/> --}}
        @elseif($fm->question_table_name === 'fmt_mcqpa2_ques')
            <x-mcqpa2.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mcqpan_ques')
            {{-- <x-mcqpan.edit :message="$que->question_id"/> --}}
        @elseif($fm->question_table_name === 'fmt_tnf_ques')
            <x-tnf.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_gridtnf_ques')
            <x-gridtnf.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mcqa_ques')
            <x-mcqa.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_dad_ques')
            {{-- <x-dad.edit :message="$que->question_id"/> --}}
        @elseif($fm->question_table_name === 'fmt_mof_ques')
            <x-mof.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_matchthepairs_ques')
            {{-- <x-mtp.edit :message="$que->question_id"/> --}}
        @elseif($fm->question_table_name === 'fmt_mtpp_ques')
            <x-mtpp.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_unjumble_words_ques')
            <x-unw.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_fillup_ques')
            {{-- <x-fillup.edit :message="$que->question_id"/> --}}
        @elseif($fm->question_table_name === 'fmt_map_ques')
            {{-- <x-map.edit :message="$que->question_id"/> --}}
        @elseif($fm->question_table_name === 'fmt_lasa_ques')
            <x-lasa.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_laws_ques')
            {{-- <x-laws.edit :message="$que->question_id"/> --}}
        @elseif($fm->question_table_name === 'fmt_lamas_ques')
            <x-lamas.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_lamaw_ques')
            <x-lamaw.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_rswa_ques')
            <x-rswa.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_rwra_ques')
            <x-rwra.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_lara_ques')
            <x-lara.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_lartrm_ques')
            {{-- <x-lartrm.edit :message="$que->question_id"/> --}}
        @elseif($fm->question_table_name === 'fmt_mcqanpt_ques')
            <x-mcqanpt.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_cma_ques')
            {{-- <x-cma.edit :message="$que->question_id"/> --}}
        @elseif($fm->question_table_name === 'fmt_ltl_ques')
            <x-ltl.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_ltw_ques')
            <x-ltw.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mawr_ques')
            <x-mawr.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mcqt_ques')
            <x-mcqt.edit :message="$que->question_id"/>
        @elseif($fm->question_table_name === 'fmt_mawra_ques')
            <x-mawra.edit :message="$que->question_id"/>
        @endif
        
    @endforeach
</tbody>
</table>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
<script>
function modal_moveFormat($id){
    var modal = document.getElementById('modal_moveFormat'+$id);
    modal.classList.remove('hidden');
}


function closemodal_moveFormat($id){
    var modal = document.getElementById('modal_moveFormat'+$id);
    modal.classList.add('hidden');
}
function modalMCQT($id){
    var modal = document.getElementById('modalMCQT'+$id);
    modal.classList.remove("hidden");
}
function closeModalMCQT($id){
    var modal = document.getElementById('modalMCQT'+$id);
    modal.classList.add("hidden");
}
function modalMAWR($id){
    var modal = document.getElementById('modalMAWR'+$id);
    modal.classList.remove("hidden");
}
function closeModalMAWR($id){
    var modal = document.getElementById('modalMAWR'+$id);
    modal.classList.add("hidden");
}
function modalMAWRA($id){
    var modal = document.getElementById('modalMAWRA'+$id);
    modal.classList.remove("hidden");
}
function closeModalMAWRA($id){
    var modal = document.getElementById('modalMAWRA'+$id);
    modal.classList.add("hidden");
}

function modalLTL($id){
    var modal = document.getElementById('modalLTL'+$id);
    modal.classList.remove("hidden");
}
function closeModalLTL($id){
    var modal = document.getElementById('modalLTL'+$id);
    modal.classList.add("hidden");
}
function modalLTW($id){
    var modal = document.getElementById('modalLTW'+$id);
    modal.classList.remove("hidden");
}
function closeModalLTW($id){
    var modal = document.getElementById('modalLTW'+$id);
    modal.classList.add("hidden");
}
function modalCMA($id){
    var modal = document.getElementById('modalCMA'+$id);
    modal.classList.remove("hidden");
}
function closeModalCMA($id){
    var modal = document.getElementById('modalCMA'+$id);
    modal.classList.add("hidden");
}
function modalMCQANPT($id){
    var modal = document.getElementById('modalMCQANPT'+$id);
    modal.classList.remove("hidden");
}
function closeModalMCQANPT($id){
    var modal = document.getElementById('modalMCQANPT'+$id);
    modal.classList.add("hidden");
}
function modalLARTRM($id){
    var modal = document.getElementById('modalLARTRM'+$id);
    modal.classList.remove("hidden");
}
function closeModalLARTRM($id){
    var modal = document.getElementById('modalLARTRM'+$id);
    modal.classList.add("hidden");
}
function modalLARA($id){
    var modal = document.getElementById('modalLARA'+$id);
    modal.classList.remove("hidden");
}
function closeModalLARA($id){
    var modal = document.getElementById('modalLARA'+$id);
    modal.classList.add("hidden");
}
function modalRWRA($id){
    var modal = document.getElementById('modalRWRA'+$id);
    modal.classList.remove("hidden");
}
function closeModalRWRA($id){
    var modal = document.getElementById('modalRWRA'+$id);
    modal.classList.add("hidden");
}
function modalRSWA($id){
    var modal = document.getElementById('modalRSWA'+$id);
    modal.classList.remove("hidden");
}
function closeModalRSWA($id){
    var modal = document.getElementById('modalRSWA'+$id);
    modal.classList.add("hidden");
}
function modalLAMAS($id){
    var modal = document.getElementById('modalLAMAS'+$id);
    modal.classList.remove("hidden");
}
function closeModalLAMAS($id){
    var modal = document.getElementById('modalLAMAS'+$id);
    modal.classList.add("hidden");
}
function modalLAMAW($id){
    var modal = document.getElementById('modalLAMAW'+$id);
    modal.classList.remove("hidden");
}
function closeModalLAMAW($id){
    var modal = document.getElementById('modalLAMAW'+$id);
    modal.classList.add("hidden");
}
function modalLASA($id){
    var modal = document.getElementById('modalLASA'+$id);
    modal.classList.remove("hidden");
}
function closeModalLASA($id){
    var modal = document.getElementById('modalLASA'+$id);
    modal.classList.add("hidden");
}
function modalLAWS($id){
    var modal = document.getElementById('modalLAWS'+$id);
    modal.classList.remove("hidden");
}
function closeModalLAWS($id){
    var modal = document.getElementById('modalLAWS'+$id);
    modal.classList.add("hidden");
}

function modalMAP($id){
    var modal = document.getElementById('modalMAP'+$id);
    modal.classList.remove("hidden");
}
function closeModalMAP($id){
    var modal = document.getElementById('modalMAP'+$id);
    modal.classList.add("hidden");
}

function modalFILL($id){
    var modal = document.getElementById('modalFILL'+$id);
    modal.classList.remove("hidden");
}
function closeModalFILL($id){
    var modal = document.getElementById('modalFILL'+$id);
    modal.classList.add("hidden");
}
function modalFILLMCQ($id){
    var modal = document.getElementById('modalFILLMCQ'+$id);
    modal.classList.remove("hidden");
}
function closeModalFILLMCQ($id){
    var modal = document.getElementById('modalFILLMCQ'+$id);
    modal.classList.add("hidden");
}
function modalUNW($id){
    var modal = document.getElementById('modalUNW'+$id);
    modal.classList.remove("hidden");
}
function closeModalUNW($id){
    var modal = document.getElementById('modalUNW'+$id);
    modal.classList.add("hidden");
}
function modalMTP($id){
    var modal = document.getElementById('modalMTP'+$id);
    modal.classList.remove("hidden");
}
function closeModalMTP($id){
    var modal = document.getElementById('modalMTP'+$id);
    modal.classList.add("hidden");
}
function modalMTPP($id){
    var modal = document.getElementById('modalMTPP'+$id);
    modal.classList.remove("hidden");
}
function closeModalMTPP($id){
    var modal = document.getElementById('modalMTPP'+$id);
    modal.classList.add("hidden");
}

function modalDAD($id){
    var modal = document.getElementById('modalDAD'+$id);
    modal.classList.remove("hidden");
}
function closeModalDAD($id){
    var modal = document.getElementById('modalDAD'+$id);
    modal.classList.add("hidden");
}
function modalMOF($id){
    var modal = document.getElementById('modalMOF'+$id);
    modal.classList.remove("hidden");
}
function closemodalMOF($id){
    var modal = document.getElementById('modalMOF'+$id);
    modal.classList.add("hidden");
}
function modalMCQA($id){
    var modal = document.getElementById('modalMCQA'+$id);
    modal.classList.remove("hidden");
}
function closemodalMCQA($id){
    var modal = document.getElementById('modalMCQA'+$id);
    modal.classList.add("hidden");
}

function modalTnF($id){
    var modal = document.getElementById('modalTnF'+$id);
    modal.classList.remove("hidden");
}
function closemodalTnF($id){
    var modal = document.getElementById('modalTnF'+$id);
    modal.classList.add("hidden");
}
function modalGRIDTNF($id){
    var modal = document.getElementById('modalGRIDTNF'+$id);
    modal.classList.remove("hidden");
}
function closeModalGRIDTNF($id){
    var modal = document.getElementById('modalGRIDTNF'+$id);
    modal.classList.add("hidden");
}

function modalMCQPAN($id){
    var modal = document.getElementById('modalMCQPAN'+$id);
    modal.classList.remove("hidden");
}
function closeModalMCQPAN($id){
    var modal = document.getElementById('modalMCQPAN'+$id);
    modal.classList.add("hidden");
}

function modalMCQ($id){
    var modal = document.getElementById('modalMCQ'+$id);
    modal.classList.remove("hidden");
}
function closeModalMCQ($id){
    var modal = document.getElementById('modalMCQ'+$id);
    modal.classList.add("hidden");
}

function modalMCQP($id){
    var modal = document.getElementById('modalMCQP'+$id);
    modal.classList.remove("hidden");
}
function closemodalMCQP($id){
    var modal = document.getElementById('modalMCQP'+$id);
    modal.classList.add("hidden");
}

function modalMCAQ($id){
    var modal = document.getElementById('modalMCAQ'+$id);
    modal.classList.remove("hidden");
}
function closemodalMCAQ($id){
    var modal = document.getElementById('modalMCAQ'+$id);
    modal.classList.add("hidden");
}

function modalMC2PQ($id){
    var modal = document.getElementById('modalMC2PQ'+$id);
    modal.classList.remove("hidden");
}
function closemodalMC2PQ($id){
    var modal = document.getElementById('modalMC2PQ'+$id);
    modal.classList.add("hidden");
}

function modalMCQPC($id){
    var modal = document.getElementById('modalMCQPC'+$id);
    modal.classList.remove("hidden");
}
function closeModalMCQPC($id){
    var modal = document.getElementById('modalMCQPC'+$id);
    modal.classList.add("hidden");
}

function modalMCQPA2($id){
    var modal = document.getElementById('modalMCQPA2'+$id);
    modal.classList.remove("hidden");
}
function closemodalMCQPA2($id){
    var modal = document.getElementById('modalMCQPA2'+$id);
    modal.classList.add("hidden");
}
</script>
@isset($newQrray)
<div class="modal fade" id="move_ques" tabindex="-1" role="dialog" style="left: unset;" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{route('fmt.edgecontent.psq.change_problem_set_multi')}}" method="post">
                    @csrf
                    <div class="form-control" hidden>
                        <textarea name="move_multiple_box" id="move_multiple_box" cols="30" rows="1"></textarea>
                        <input name="this_problem_set" type="text" value="{{$newQrray['id']}}">
                    </div>
                    <div class="w-full p-2">
                        <div class="w-full text-xs text-gray-800">Select Level</div>
                        <select name="multi_level_id" id="multi_level_id" class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-800 rounded-lg" required>
                            <option disabled selected>Select Level</option>
                            @foreach ($newQrray['levelx'] as $level)
                            <option value="{{$level->id}}">{{$level->level_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- //levels --}}
                    {{-- chapters --}}
                    <div class="w-full p-2">
                        <div class="w-full text-xs text-gray-800">Select Chapter</div>
                        <select name="other_problem_set" id="multi_chapter_id" class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-800 rounded-lg" required>
                            
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $('#multi_level_id').on('change', function() {        
        $.ajax({
            url: "{{ route('fmt.edgecontent.select.getSelectedChapterss_without_topic') }}",
            type: "post",
            data: {
                level_id: $('[name=multi_level_id]').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var chapters = JSON.parse(response);
                console.log(response);
                var chapters_length = Object.keys( chapters ).length;
                if(chapters_length > 0){
                    var options = '<option disabled selected>Select Chapter</option>';
                    for (var i = 0; i < chapters_length; i++) {
                        options += '<option value="' + chapters[i].id + '">' + chapters[i].chapt_name + '</option>';
                    }
                }else{
                    var options = '<option disabled selected>No Chapters found in this topic </option>';
                }
                $("#multi_chapter_id").html(options);
            }
        });
    });
</script>
@endisset

<div class="modal fade" id="previewFormatModal" tabindex="-1" role="dialog" aria-labelledby="previewFormatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="previewFormatModalLabel">Question Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body abc">
          ...
        </div>
        <div class="modal-footer">
            {{-- <small class="text-danger">Blue Colorrd option is Correct Option</small> --}}
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.22/r-2.2.6/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script>
var table = $('#fmt_problem_set2_index').DataTable( {
    paging: true,
    columnDefs: [ {
        orderable: false,
        className: 'select-checkbox',
        targets:   0
    } ],
    select: {
        style:    'os',
        selector: 'td:first-child'
    },
    order: [[ 1, 'asc' ]]
});
$('#btnSelectedRows').on('click', function() {
    var selectedBox = [];
    $.each(table.rows('.selected').nodes(), function(i, item) {
        selectedBox.push(item.children[1].outerText);        
    });
    if(selectedBox.length <= 0){
        return alert('select atleast one question');
    }
    var selectedBox_string = selectedBox.toString();
    $('#move_multiple_box').html(selectedBox_string);
    $('#move_ques').modal('show');
});

function modal_previewFormat($id){
    var baseurl="{{url('/')}}";
    $.ajax({
        url:baseurl+'/preview-option/'+$id,
        method:'get',
        success:function(params) {
            $('.abc').html(params);
            $('#previewFormatModal').modal('show');
        },
    });
    
}



</script>



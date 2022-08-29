<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<div class="border border-gray-400 rounded-xl m-8 p-8 bg-white">
    <form action="{{route('fmt.edgecontent.problem_set.create')}}" method="post" class="fmt_box">
        @csrf
        <div class="text-xl">Add a Problem Set</div>
        <div class="flex flex-wrap -mx-4 my-4">{{-- flex-wrap --}}
            <div class="w-full px-4 my-2">
                <div class="flex flex-wrap -px-4">
                    {{-- levels --}}
                    <div class="w-full p-2">
                        <div class="w-full text-xs text-gray-800">Select Level</div>
                        @php
                        $levelx = DB::table('edw_level')->where('edw_level.active', 1)->get();
                        @endphp
                        <select name="level_id" id="level_id" class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-600 rounded-lg" required>
                            <option disabled selected>Select Level</option>
                            @foreach ($levelx as $level)
                            <option value="{{$level->id}}">{{$level->level_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- //levels --}}
                    {{-- chapters --}}
                    {{-- <div class="w-full p-2">
                        <div class="w-full text-xs text-gray-800">Select Topic</div>
                        <select name="topic_id" id="topic_id" class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-600 rounded-lg" required>
                            
                        </select>
                    </div> --}}
                    {{-- //chapters --}}
                    {{-- chapters --}}
                    <div class="w-full p-2">
                        <div class="w-full text-xs text-gray-800">Select Chapter</div>
                        <select name="pb_chapter_id" id="chapter_id" class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-600 rounded-lg" required>
                            
                        </select>
                    </div>
                    {{-- //chapters --}}
                    {{-- subchapters --}}
                    {{-- <div class="w-full p-2">
                        <div class="w-full text-xs text-gray-800">Select Chapter</div>
                        @php
                        $chaptersss = DB::table('edw_chapter')->where('edw_chapter.active', 1)->get();
                        $relationz = DB::table('relational')->pluck('chapter_id')->all();
                        @endphp
                        <select name="pb_chapter_id"
                            class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-600 rounded-lg" required>
                            <option disabled>Select Chapter</option>
                            @foreach ($chaptersss as $chapter)
                            @if(!in_array($chapter->id, $relationz))
                            <option value="{{$chapter->id}}">{{$chapter->chapt_name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- //subchapters --}}
                </div>
            </div>
            <div class="w-full px-4">{{-- w-full --}}
                <div class="my-4">
                    <span class="bg-white px-2 -pt-2 mx-2 text-xs z-10">Format Type</span>
                    @php $fmts = DB::table('format_types')->get(); @endphp
                    <div class="border flex flex-wrap rounded-lg">
                        @foreach ($fmts as $fmt)
                        <div class="m-2 text-sm flex">
                            <input class="w-4 h-4" type="checkbox" name="formats[]" value="{{$fmt->id}}">
                            <label for="formats" class="ml-2">{{$fmt->name}} ({{$fmt->slug}})</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>{{-- //w-full --}}
            <div class="w-full px-4">{{-- w-full --}}
                {{-- <div class="my-4">
                    <span class="absolute bottom-1 bg-white px-2 -pt-2 mx-2 text-xs z-10">Maximum Questions</span>
                    <input name="max_ques" id="max_ques" class="relative my-2 px-4 py-1 border border-gray-500 rounded-lg w-full" placeholder="maximum questions">
                </div> --}}
            </div>{{-- //w-1/3 --}}
        </div>{{-- //flex-wrap --}}
        <button class="my-2 py-1 px-2 bg-blue-600 text-white rounded-lg" type="submit">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
{{-- <script>
    $('#level_id').on('change', function() {
        getTopics();
    });
    function getTopics(){
        $.ajax({
            url: "{{ route('fmt.edgecontent.select.getTopics') }}",
            type: "post",
            data: {
                level_id: $('[name=level_id]').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var topics = JSON.parse(response);
                var topics_length = Object.keys( topics ).length;
                if(topics_length > 0){
                    var options = '<option disabled selected>Select Topic</option>';
                    for (var i = 0; i < topics_length; i++) {
                        options += '<option value="' + topics[i].id + '">' + topics[i].name + '</option>';
                    }
                }else{
                    var options = '<option disabled selected>No Topics found in this level </option>';
                }
                $("#topic_id").html(options);
            }
        });
    }
    $('#topic_id').on('change', function() {
        getChapters();
    });
    function getChapters(){
        $.ajax({
            url: "{{ route('fmt.edgecontent.select.getChapters') }}",
            type: "post",
            data: {
                topic_id: $('[name=topic_id]').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var chapters = JSON.parse(response);
                var chapters_length = Object.keys( chapters ).length;
                if(chapters_length > 0){
                    var options = '<option disabled selected>Select Chapter</option>';
                    for (var i = 0; i < chapters_length; i++) {
                        options += '<option value="' + chapters[i].id + '">' + chapters[i].chapt_name + '</option>';
                    }
                }else{
                    var options = '<option disabled selected>No Chapters found in this topic </option>';
                }
                $("#chapter_id").html(options);
            }
        });
    }
</script>
 --}}


 <script>
    $('#level_id').on('change', function() {
        getChapters();
    });
    function getChapters(){
        $.ajax({
            url: "{{ route('fmt.edgecontent.select.getChapters_without_topic') }}",
            type: "post",
            data: {
                level_id: $('[name=level_id]').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var chapters = JSON.parse(response);
                var chapters_length = Object.keys( chapters ).length;
                if(chapters_length > 0){
                    var options = '<option disabled selected>Select Chapter</option>';
                    for (var i = 0; i < chapters_length; i++) {
                        options += '<option value="' + chapters[i].id + '">' + chapters[i].chapt_name + '</option>';
                    }
                }else{
                    var options = '<option disabled selected>No Chapters found in this topic </option>';
                }
                $("#chapter_id").html(options);
            }
        });
    }
</script>

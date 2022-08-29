<!--
  Tailwind UI components require Tailwind CSS v1.8 and the @tailwindcss/ui plugin.
  Read the documentation to get started: https://tailwindui.com/documentation
-->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="modal_moveFormat{{$newQrray['id']}}">
    <div class="flex items-end justify-center min-h-screen px-4 pb-20 text-center sm:block sm:p-0">
        <!--
        Background overlay, show/hide based on modal state.
        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
        <!--
        Modal panel, show/hide based on modal state.
        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative -mx-8" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <a onclick="closemodal_moveFormat({{$newQrray['id']}})" style="z-index: 99999999999999999; color:#000;" class="p-2 w-8 h-8 z-50" href="javascript:void(0);">x</a>
            <div class="bg-white px-4 pt-2 pb-4 sm:p-6 sm:pb-4">
                <form action="{{route('fmt.edgecontent.psq.change_problem_set', $newQrray['id'])}}" method="post" class="fmt_box">
                    @if ($errors ?? '')
                        <div class="my-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    @csrf
                    <div class="text-xl">Move Problem Set</div>
                    {{-- w-full --}}
                    {{-- <div class="w-full px-4">
                        <div class="my-4">
                            <span class="bg-white px-2 -pt-2 mx-2 text-xs z-10">Select Other Problem Set</span>
                            <select name="other_problem_set" id="">
                                @foreach ($newQrray['other_problem_sets'] as $pst)
                                    <option value="{{$pst->id}}">{{$pst->id}}) {{$pst->chapt_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    {{-- //w-full --}}
                    {{-- levels --}}
                    <div class="w-full p-2">
                        <div class="w-full text-xs text-gray-800">Select Level</div>
                        <select name="level_id{{$newQrray['id']}}" id="level_id{{$newQrray['id']}}" class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-800 rounded-lg" required>
                            <option disabled selected>Select Level</option>
                            @foreach ($newQrray['levelx'] as $level)
                            <option value="{{$level->id}}">{{$level->level_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- //levels --}}
                    {{-- chapters --}}
                   {{--  <div class="w-full p-2">
                        <div class="w-full text-xs text-gray-800">Select Topic</div>
                        <select name="topic_id{{$newQrray['id']}}" id="topic_id{{$newQrray['id']}}" class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-800 rounded-lg" required>
                            
                        </select>
                    </div> --}}
                    {{-- //chapters --}}
                    {{-- chapters --}}
                    <div class="w-full p-2">
                        <div class="w-full text-xs text-gray-800">Select Chapter</div>
                        <select name="other_problem_set" id="chapter_id{{$newQrray['id']}}" class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-800 rounded-lg" required>
                            
                        </select>
                    </div>
                    {{-- //chapters --}}
                    <button class="my-2 py-1 px-2 bg-blue-600 text-white rounded-lg" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    $('#level_id{{$newQrray['id']}}').on('change', function() {
        $.ajax({
            url: "{{ route('fmt.edgecontent.select.getTopics') }}",
            type: "post",
            data: {
                level_id: $('[name=level_id{{$newQrray['id']}}]').val()
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
                $("#topic_id{{$newQrray['id']}}").html(options);
            }
        });
    });
    $('#topic_id{{$newQrray['id']}}').on('change', function() {
        $.ajax({
            url: "{{ route('fmt.edgecontent.select.getSelectedChapters') }}",
            type: "post",
            data: {
                this_pb: {{$newQrray['id']}},
                topic_id: $('[name=topic_id{{$newQrray['id']}}]').val()
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
                $("#chapter_id{{$newQrray['id']}}").html(options);
            }
        });
    });
</script>
 --}}

 <script>
    $('#level_id{{$newQrray['id']}}').on('change', function() {
        $.ajax({
            url: "{{ route('fmt.edgecontent.select.getSelectedChapterss_without_topic') }}",
            type: "post",
            data: {
                level_id: $('[name=level_id{{$newQrray['id']}}]').val()
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
                $("#chapter_id{{$newQrray['id']}}").html(options);
            }
        });
    });
</script>

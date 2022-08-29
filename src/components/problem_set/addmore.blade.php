<!--
  Tailwind UI components require Tailwind CSS v1.8 and the @tailwindcss/ui plugin.
  Read the documentation to get started: https://tailwindui.com/documentation
-->
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
@php $que = DB::table('problem_sets')->where('id', $message)->first(); @endphp
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="modalAddMore{{$que->id}}">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
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
            <a onclick="closeModalAddMore({{$message}})" class="p-2 bg-white w-8 h-8 bg-gray-600 text-white rounded-full absolute right-0 -top-10 -mr-2 -mt-2 z-40" href="javascript:void(0);">x</a>
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <form action="{{route('fmt.edgecontent.problem_set.addmore', $que->id)}}" method="post" class="fmt_box">
                    @if ($errors ?? '')
                        <div class="my-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    @csrf
                    <div class="text-xl">Edit Fillup Question {{$message}}</div>
                    <div class="flex flex-wrap -mx-4 my-4">{{-- flex-wrap --}}
                        <div class="w-full px-4">{{-- w-full --}}
                            <div class="my-4">
                                <span class="absolute bottom-1 bg-white px-2 -pt-2 mx-2 text-xs z-10">Format Type</span>
                                @php $fmts = DB::table('format_types')->get(); @endphp 
                                <select name="format_type_add" id="format_type_add{{strtotime($que->created_at) . '_' . $message}}" class="relative my-2 px-4 py-1 border border-gray-500 rounded-lg w-full" placeholder="Test" required>
                                    @foreach ($fmts as $fmt)
                                        <option value="{{$fmt->id}}">{{$fmt->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>{{-- //w-full --}}
                        <div class="w-full px-4">{{-- w-full --}}
                            <div class="my-4">
                                <span class="bg-white mx-2 text-xs z-10">Answer Table Name</span>
                                <div class="relative my-1 px-4 py-1 border border-gray-500 rounded-lg w-full h-48 overflow-y-scroll" id="question_ids_addMore{{strtotime($que->created_at) . '_' . $message}}">
                                </div>
                            </div>
                        </div>{{-- //w-1/3 --}}
                    </div>{{-- //flex-wrap --}}
                    <button class="my-2 py-1 px-2 bg-blue-600 text-white rounded-lg" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var fmt_no = '<?php echo strtotime($que->created_at) . '_' . $message; ?>';
    // console.log(fmt_no);
    var format_type_add = document.getElementById('format_type_add'+fmt_no);
    // var question_ids = document.getElementById('question_ids');
    format_type_add.addEventListener('change', getQuestions);
    function getQuestions(){
        console.log(format_type_add.value);
        var base_url = "{{ URL::to('/') }}";
        var send_url = base_url+'/fmt/edgecontent/getQuestions/'+format_type_add.value;
        let xhr = new XMLHttpRequest();
        xhr.open('GET', send_url, true);
        xhr.onload = function(){
            // console.log(this.responseText);
            var list = document.querySelector('#question_ids_addMore'+fmt_no);
            var subs = JSON.parse(this.responseText);
            // console.log(subs);
            var output = '';
            if(subs.length > 0){
                // output += '<option>Select a Topic</option>';
                for(var i in subs){
                    // console.log(i);
                    output += '<div class="border-b my-2 text-sm border-gray-300 flex">';
                    output += '<input class="w-4 h-4" type="checkbox" name="add_more_questions[]" value="' + subs[i].id +'">';
                    if(subs[i].question){
                        output += '<div class="ml-2" for="'+ subs[i].id +'"><b>Question:</b>"'+ subs[i].question +'"</div>';
                    }else{
                        output += '<div class="ml-2">media</div>';
                    }
                    output += '</div>';
                    // output += '<option value="'+ subs[i].id +'">'+ subs[i].question + '</option>';
                }
            } else{
                output += '<option> -- No Questions Found --</option>';
            }
            list.innerHTML = output;
        }
        xhr.send();
    }
</script>
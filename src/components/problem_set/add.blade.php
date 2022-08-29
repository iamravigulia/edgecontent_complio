<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<div class="border border-gray-400 rounded-xl m-8 p-8 bg-white">
    <form action="{{route('fmt.edgecontent.problem_set.addmore', $message)}}" method="post" class="fmt_box">
        @csrf
        <div class="text-xl">Add Questions to Problem Set</div>
        <div class="flex flex-wrap -mx-4 my-4">{{-- flex-wrap --}}
            <div class="w-full px-4">{{-- w-full --}}
                <div class="my-4">
                    <span class="absolute bottom-1 bg-white px-2 -pt-2 mx-2 text-xs z-10">Format Type</span>
                    @php $fmts = DB::table('format_types')->get(); @endphp 
                    <select name="format_type" id="format_type" class="relative my-2 px-4 py-1 border border-gray-500 rounded-lg w-full" placeholder="Test" required>
                        <option disabled selected hidden>Select Format Type</option>
                        @foreach ($fmts as $fmt)
                            <option value="{{$fmt->id}}">{{$fmt->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>{{-- //w-full --}}
            <div class="w-full px-4">{{-- w-full --}}
                <div class="my-4">
                    <span class="bg-white px-2 mx-2 text-xs z-10">Answer Table Name</span>
                    <div class="relative my-1 px-2 py-1 border border-gray-500 rounded-lg w-full h-48 overflow-y-scroll" id="question_ids">
                        
                    </div>
                </div>
            </div>{{-- //w-1/3 --}}
        </div>{{-- //flex-wrap --}}
        <button class="my-2 py-1 px-2 bg-blue-600 text-white rounded-lg" type="submit">Submit</button>
    </form>
</div>
<script>
    var format_type = document.getElementById('format_type');
    // var question_ids = document.getElementById('question_ids');
    format_type.addEventListener('change', getQuestions);
    function getQuestions(){
        console.log(format_type.value);
        var base_url = "{{ URL::to('/') }}";
        var send_url = base_url+'/fmt/edgecontent/getQuestions/'+format_type.value;
        let xhr = new XMLHttpRequest();
        xhr.open('GET', send_url, true);
        xhr.onload = function(){
            // console.log(this.responseText);
            var list = document.querySelector('#question_ids');
            var subs = JSON.parse(this.responseText);
            // console.log(subs);
            var output = '';
            if(subs.length > 0){
                // output += '<option>Select a Topic</option>';
                for(var i in subs){
                    // console.log(i);
                    output += '<div class="border-b my-2 text-sm border-gray-300 flex">';
                    output += '<input class="w-4 h-4" type="checkbox" name="questions[]" value="' + subs[i].id +'">';
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
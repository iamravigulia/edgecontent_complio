<!--
  Tailwind UI components require Tailwind CSS v1.8 and the @tailwindcss/ui plugin.
  Read the documentation to get started: https://tailwindui.com/documentation
-->
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
@php $que = DB::table('problem_sets')->where('id', $message)->first(); @endphp
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="modalCMA{{$que->id}}">
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
            <a onclick="closeModalCMA({{$message}})" style="z-index: 99999999999999999;" class="p-2 bg-white w-8 h-8 bg-gray-600 text-white rounded-full absolute right-0 -top-10 -mr-2 -mt-2 z-50" href="javascript:void(0);">x</a>
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <form action="{{route('fmt.edgecontent.problem_set.edit', $que->id)}}" method="post" class="fmt_box">
                    @if ($errors ?? '')
                        <div class="my-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    @csrf
                    <div class="text-xl">Edit Problem Set {{$message}}</div>
                    <div class="w-full px-4">{{-- w-full --}}
                        <div class="my-4">
                            <span class="bg-white px-2 -pt-2 mx-2 text-xs z-10">Format Type</span>
                            @php $fmts = DB::table('format_types')->get(); @endphp
                            @php $checked_fmts = DB::table('format_type_problem_set')->where('problem_set_id', $que->id)->pluck('format_type_id')->toArray(); @endphp
                            <div class="border rounded-lg">
                                @foreach ($fmts as $fmt)
                                <div class="m-2 text-sm flex">
                                    <input class="w-4 h-4" type="checkbox" name="formats[]" @if(in_array($fmt->id, $checked_fmts)) checked @endif value="{{$fmt->id}}">
                                    <label for="formats" class="ml-2">{{$fmt->name}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>{{-- //w-full --}}
                    <div class="w-full px-4">
                        <div class="my-4">
                            <span class="bg-white px-2 -pt-2 mx-2 text-xs z-10">Edit Chapter</span>
                            @php $chapters_x = DB::table('edw_chapter')->where('edw_chapter.active', 1)->get();
                            $relationz = DB::table('relational')->pluck('chapter_id')->all();
                            $myrel = DB::table('relational')->where('problem_set_id', $que->id)->first();
                            $mychapter = DB::table('edw_chapter')->where('id', $myrel->chapter_id)->first();
                            @endphp
                            <select name="pb_chapter_id" class="w-full text-sm text-gray-600 py-2 px-1 border border-gray-600 rounded-lg" required>
                                @if($mychapter)
                                <option selected value="{{$mychapter->id}}">{{$mychapter->chapt_name}}</option>
                                @endif
                                @foreach ($chapters_x as $chapterxx)
                                    @if(!in_array($chapterxx->id, $relationz))
                                    <option value="{{$chapterxx->id}}">{{$chapterxx->chapt_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="w-full px-4">{{-- w-full --}}
                        <div class="my-4">
                            <span class="absolute bottom-1 bg-white px-2 -pt-2 mx-2 text-xs z-10">Maximum Questions</span>
                            <input name="max_ques" id="max_ques" value="{{$que->max_limit}}" class="relative my-2 px-4 py-1 border border-gray-500 rounded-lg w-full" placeholder="maximum questions">
                        </div>
                    </div>{{-- //w-1/3 --}}
                    <button class="my-2 py-1 px-2 bg-blue-600 text-white rounded-lg" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

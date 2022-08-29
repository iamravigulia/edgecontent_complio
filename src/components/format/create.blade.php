<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<div class="border border-gray-400 rounded-xl m-8 p-8 bg-white">
    <form action="{{route('fmt.edgecontent.format.create')}}" method="post" class="fmt_box">
        @csrf
        <div class="text-xl">Add Format Type</div>
        <div class="flex flex-wrap -mx-4 my-4">{{-- flex-wrap --}}
            <div class="w-1/3 px-4">{{-- w-1/3 --}}
                <div class="my-4">
                    <span class="absolute bottom-1 bg-white px-2 -pt-2 mx-2 text-xs z-10">Name</span>
                    <input name="name" id="name" class="relative my-2 px-4 py-1 border border-gray-500 rounded-lg w-full" placeholder="Name" required>
               </div>
            </div>{{-- //w-1/3 --}}
            <div class="w-1/3 px-4">{{-- w-1/3 --}}
                <div class="my-4">
                    <span class="absolute bottom-1 bg-white px-2 -pt-2 mx-2 text-xs z-10">Question Table Name</span>
                    @php $tables = DB::select("SHOW TABLES"); $tb_name = "Tables_in_".env('DB_DATABASE'); @endphp
                    <select name="question_table_name" id="" class="relative my-2 px-4 py-1 border border-gray-500 rounded-lg w-full" placeholder="Test" required>
                        <option disabled selected hidden>Select Table</option>
                        @foreach ($tables as $key)
                            <option value="{{$key->$tb_name}}">{{$key->$tb_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>{{-- //w-1/3 --}}
            <div class="w-1/3 px-4">{{-- w-1/3 --}}
                <div class="my-4">
                    <span class="absolute bottom-1 bg-white px-2 -pt-2 mx-2 text-xs z-10">Answer Table Name</span>
                    @php $tables = DB::select("SHOW TABLES"); $tb_name = "Tables_in_".env('DB_DATABASE'); @endphp
                    <select name="answer_table_name" id="" class="relative my-2 px-4 py-1 border border-gray-500 rounded-lg w-full" placeholder="Test" required>
                        <option disabled selected hidden>Select Table</option>
                        @foreach ($tables as $key)
                            <option value="{{$key->$tb_name}}">{{$key->$tb_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>{{-- //w-1/3 --}}
        </div>{{-- //flex-wrap --}}
        <button class="my-2 py-1 px-2 bg-blue-600 text-white rounded-lg" type="submit">Submit</button>
    </form>
</div>

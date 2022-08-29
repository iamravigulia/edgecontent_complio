{{-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
@php $fmt = DB::table('format_types')->where('id', $message)->first(); @endphp
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="modalCMA{{$fmt->id}}">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full sm:w-full relative -mx-4" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <a onclick="closeModalCMA({{$message}})" class="p-2 bg-white w-8 h-8 bg-gray-600 text-white rounded-full absolute right-0 -top-10 -mr-2 -mt-2 z-40" href="javascript:void(0);">x</a>
            <div class="bg-white">
                @if($fmt->name == 'Fillupmulti')
                <x-fillupmulti.open :pbs72="$problemset" :fmt72="$fmt->id"/>
                @elseif($fmt->name == 'Unjumble Words')
                <x-unw.open :pbs72="$problemset" :fmt72="$fmt->id"/>
                @endif
            </div>
        </div>
    </div>
</div> --}}

@if($fmt->name == 'Fillupmulti')
<x-fillupmulti.open :pbs72="$problemset" :fmt72="$fmt->id"/>
@elseif($fmt->name == 'Unjumble Words')
<x-unw.open :pbs72="$problemset" :fmt72="$fmt->id"/>
@endif
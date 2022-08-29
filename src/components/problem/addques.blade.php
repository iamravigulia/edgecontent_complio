<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<div class="border border-gray-400 rounded-xl m-8 p-8 bg-white">
    {{-- <form action="{{route('fmt.edgecontent.problem_set.create', $message)}}" method="post" class="fmt_box"> --}}
    @csrf
    <div class="text-xl">Add Questions to Problem Set</div>
    <div class="mx-4 my-4">{{-- flex-wrap --}}
        {{-- @foreach ($problemset->formats as $format)
                <x-problem.format :problemset="$problemset->id" :message="$format->id" />
            @endforeach --}}
        <select class="my-2 shadow-lg px-2 py-1 border border-gray-400 rounded-lg text-center" name="format" id="formatSelect">
            <option selected disabled>Select Format</option>
            @foreach ($problemset->formats as $format)
            <option value="{{$format->question_table_name}}">({{$format->slug}}) {{$format->name}}</option>
            @endforeach
        </select>
        {{-- <div class="block text-4xl">{{$format->id}}</div> --}}
    </div>{{-- //flex-wrap --}}
    {{-- @php $tables = DB::select("SHOW TABLES"); $tb_name = "Tables_in_".env('DB_DATABASE'); @endphp --}}
    @php $tables = DB::table('format_types')->select('question_table_name as tb_name')->get(); @endphp
    <div id="formatBox" class="my-2 w-full">
        @foreach ($tables as $key)
        {{-- {{$key->tb_name}} --}}
        @if ($key->tb_name == 'fmt_mof_ques')
            @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mof_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_mof_ques" hidden>
                    <x-mof.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_fillup_ques')
            @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_fillup_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_fillup_ques" hidden>
                    {{-- <x-fillup.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_matchthepairs_ques')
            @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_matchthepairs_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_matchthepairs_ques" hidden>
                    {{-- <x-mtp.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mtpp_ques')
            @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mtpp_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_mtpp_ques" hidden>
                    <x-mtpp.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_picmatch_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_picmatch_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_picmatch_ques" hidden>
                    {{-- <x-picmatch.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_lamas_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_lamas_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_lamas_ques" hidden>
                    <x-lamas.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_lamaw_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_lamaw_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_lamaw_ques" hidden>
                    <x-lamaw.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_ltl_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_ltl_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_ltl_ques" hidden>
                <x-ltl.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_ltw_ques')
            @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_ltw_ques')->first(); @endphp
                @if ($formatGot)
                <div id="fmt_ltw_ques" hidden>
                    <x-ltw.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
                </div>
                @endif
        @elseif ($key->tb_name == 'fmt_mawr_ques')
            @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mawr_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_mawr_ques" hidden>
                <x-mawr.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
        @endif
        @elseif ($key->tb_name == 'fmt_rswa_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_rswa_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_rswa_ques" hidden>
            <x-rswa.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_rwra_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_rwra_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_rwra_ques" hidden>
            <x-rwra.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_lara_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_lara_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_lara_ques" hidden>
            <x-lara.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_laws_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_laws_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_laws_ques" hidden>
            {{-- <x-laws.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_lasa_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_lasa_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_lasa_ques" hidden>
            <x-lasa.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_rtrm_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_rtrm_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_rtrm_ques" hidden>
            {{-- <x-rtrm.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_lartrm_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_lartrm_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_lartrm_ques" hidden>
            {{-- <x-lartrm.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_map_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_map_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_map_ques" hidden>
            {{-- <x-map.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_mcq_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcq_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_mcq_ques" hidden>
            <x-mcq.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_fillmcq_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_fillmcq_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_fillmcq_ques" hidden>
            <x-fillmcq.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_mcqp_ques')
            @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcqp_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_mcqp_ques" hidden>
                    <x-mcqp.open :pbs72="$problemset->id" :fmt72="$formatGot->id"/>
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mcaq_ques')
            @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcaq_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_mcaq_ques" hidden>
                    <x-mcaq.open :pbs72="$problemset->id" :fmt72="$formatGot->id"/>
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mc2pq_ques')
            @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mc2pq_ques')->first(); @endphp
            @if ($formatGot)
                <div id="fmt_mc2pq_ques" hidden>
                    <x-mc2pq.open :pbs72="$problemset->id" :fmt72="$formatGot->id"/>
                </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mcqpa_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcqpa_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_mcqpa_ques" hidden>
                {{-- <x-mcqpa.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mcqpa2_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcqpa2_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_mcqpa2_ques" hidden>
                <x-mcqpa2.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mcqa_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcqa_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_mcqa_ques" hidden>
                <x-mcqa.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mcqpan_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcqpan_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_mcqpan_ques" hidden>
                {{-- <x-mcqpan.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_tnf_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_tnf_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_tnf_ques" hidden>
                <x-tnf.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mcqpc_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcqpc_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_mcqpc_ques" hidden>
            {{-- <x-mcqpc.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_mcqanpt_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcqanpt_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_mcqanpt_ques" hidden>
            <x-mcqanpt.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_cma_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_cma_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_cma_ques" hidden>
            {{-- <x-cma.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_dad_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_dad_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_dad_ques" hidden>
            {{-- <x-dad.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_rew_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_rew_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_rew_ques" hidden>
            {{-- <x-rew.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_marew_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_marew_ques')->first(); @endphp
        @if ($formatGot)
        <div id="fmt_marew_ques" hidden>
            {{-- <x-marew.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
        </div>
        @endif
        @elseif ($key->tb_name == 'fmt_fillupmulti_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_fillupmulti_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_fillupmulti_ques" hidden>
                {{-- <x-fillupmulti.open :pbs72="$problemset->id" :fmt72="$formatGot->id" /> --}}
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_unjumble_words_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_unjumble_words_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_unjumble_words_ques" hidden>
                <x-unw.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mcqt_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mcqt_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_mcqt_ques" hidden>
                <x-mcqt.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_mawra_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mawra_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_mawra_ques" hidden>
                <x-mawra.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
            @endif
        @elseif ($key->tb_name == 'fmt_gridtnf_ques')
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_gridtnf_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_gridtnf_ques" hidden>
                <x-gridtnf.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
            @endif
        @php $formatGot = DB::table('format_types')->where('question_table_name', 'fmt_mc4pq_ques')->first(); @endphp
            @if ($formatGot)
            <div id="fmt_mc4pq_ques" hidden>
                <x-mc4pq.open :pbs72="$problemset->id" :fmt72="$formatGot->id" />
            </div>
            @endif
        @endif        
        @endforeach
    </div>
    {{-- <button class="my-2 py-1 px-2 bg-blue-600 text-white rounded-lg" type="submit">Submit</button> --}}
    </form>
</div>
<script>
    var formatBox = document.getElementById('formatBox');
    var formatSelect = document.getElementById('formatSelect');
    formatSelect.addEventListener('change', funformat);

    function funformat() {
        var allFormats = ['fmt_mof_ques', 'fmt_fillup_ques', 'fmt_matchthepairs_ques', 'fmt_mtpp_ques', 'fmt_picmatch_ques',
            'fmt_lamas_ques', 'fmt_lamaw_ques', 'fmt_rswa_ques', 'fmt_rwra_ques', 'fmt_lara_ques', 'fmt_laws_ques',
            'fmt_lasa_ques', 'fmt_rtrm_ques', 'fmt_lartrm_ques', 'fmt_map_ques', 'fmt_mcq_ques', 'fmt_mcqp_ques', 'fmt_mcaq_ques', 'fmt_mc2pq_ques', 'fmt_mcqa_ques',
            'fmt_mcqpa_ques', 'fmt_mcqpa2_ques', 'fmt_mcqa_ques', 'fmt_mcqpan_ques', 'fmt_tnf_ques',
            'fmt_mcqpc_ques', 'fmt_mcqanpt_ques', 'fmt_cma_ques', 'fmt_dad_ques', 'fmt_rew_ques', 'fmt_marew_ques',
            'fmt_fillupmulti_ques', 'fmt_unjumble_words_ques', 'fmt_ltl_ques', 'fmt_ltw_ques', 'fmt_mawr_ques', 'fmt_mcqt_ques', 'fmt_mawra_ques', 'fmt_gridtnf_ques', 'fmt_fillmcq_ques', 'fmt_mc4pq_ques'
        ];
        for (var i = 0; i < allFormats.length; i++) {
            if (formatSelect.value == allFormats[i]) {
                var x = document.getElementById(allFormats[i]);
                if(x){
                    x.removeAttribute('hidden');
                }
            } else {
                var x = document.getElementById(allFormats[i]);
                if(x){
                    x.setAttribute('hidden', true);
                }
            }
        }
    }
    funformat();
    // // // // //
    function modalCMA($id) {
        var modal = document.getElementById('modalCMA' + $id);
        modal.classList.remove("hidden");
    }

    function closeModalCMA($id) {
        var modal = document.getElementById('modalCMA' + $id);
        modal.classList.add("hidden");
    }

</script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.22/r-2.2.6/datatables.min.js">
</script>
<script>
    $('#fmt_problem_set_index').dataTable({
        "paging": true
    });
</script>

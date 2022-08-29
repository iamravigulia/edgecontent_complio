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
    #fmt_problem_set_index_length{
        
    }
    #fmt_problem_set_index_wrapper{
        display: block;
    }
     .modal.admin-popup {background-color: transparent;width: 100% !important;height: 100%;max-width: none;left: 0 !important;top: 0 !important;transform: none !important;}

</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<!-- Reject model start -->  

    <div class="modal admin-popup fade slide-up disable-scroll" id="modalReject" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog ">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <h5 class="text-center">Archieve Chapters</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                    class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="rejectform" method="post">
                            @csrf
                        <div class="row p-t-20">    
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">  
                                                 <label for="ChapterLevelId" class="control-label">Level Wise Chapter List</label>
                                                    <div class="form-group">
                                                       <select name="ChapterLevelId" id="ChapterLevelId" type="text" class="form-control courses" data-parsley-maxlength="55"
                                                            data-parsley-minlength="2" maxlength="55" placeholder="Enter  Id"
                                                            autofocus="autofocus" {{-- value="{{$chapter->chapt_level_id}}" --}}  required>
                                                            {{-- @php 
                                                            $this_level = DB::table('edw_prechapters')
                                                                ->where('edw_prechapters.id', $chapter->chapt_level_id)
                                                                ->join('edw_level', 'edw_level.id', 'edw_prechapters.level_id')
                                                                ->select('edw_prechapters.id', 'edw_prechapters.name', 'edw_level.level_name')
                                                                ->first();
                                                            @endphp --}}
                                                            {{-- <option name="ChapterLevelId" id="ChapterLevelId" value="{{$this_level->id}}">{{$this_level->level_name}} : {{$this_level->name}}</option> --}}
                                                            @php 
                                                            $levels = DB::table('edw_level')
                                                            ->join('edw_chapter', 'edw_chapter.chapt_level_id', 'edw_level.id')
                                                            ->where('edw_level.active', 1)
                                                            ->where('edw_chapter.active', 1)
                                                            ->select('edw_chapter.id', 'edw_level.level_name','edw_chapter.chapt_name')
                                                            ->get();
                                                             @endphp
                                                             
                                                            @foreach ($levels as $level)
                                                                {{-- @if ($level->id != $this_level->id) --}}
                                                                <option name="ChapterLevelId" id="ChapterLevelId" value="{{$level->id}}">{{$level->level_name}} : {{ $level->chapt_name }}</option>
                                                                {{-- @endif --}}
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                        Please provide a valid Topic Id.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger btn-block m-t-5 rejected">Archieve Chapter
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end -->
<table class="cell-border" id="fmt_problem_set_index" style="width:100%">
<thead>
    <th>#</th>
    <th>Formats</th>
    <th>Level</th>
    {{-- <th>Topic</th> --}}
    <th>Chapter</th>
    <th>No of Questions</th>
    <th>Created/Updated</th>
    <th>Actions</th>
</thead>
<tbody>
    @php
        $pbs = DB::table('problem_sets')->where('problem_sets.active', 1)->where('edw_chapter.active', 1)
        ->join('format_type_problem_set', 'format_type_problem_set.problem_set_id', '=', 'problem_sets.id')
        ->join('format_types', 'format_types.id', '=', 'format_type_problem_set.format_type_id')
        ->join('relational', 'relational.problem_set_id', '=', 'problem_sets.id')
        ->join('edw_chapter', 'edw_chapter.id', '=', 'relational.chapter_id')
        // ->join('edw_prechapters', 'edw_prechapters.id', '=', 'edw_chapter.chapt_level_id')
        ->join('edw_level', 'edw_level.id', '=', 'edw_chapter.chapt_level_id')
        
        ->select(
            'problem_sets.id', 

            'format_type_problem_set.format_type_id', 
            
            'format_types.name', 
            'format_types.question_table_name', 
            'format_types.answer_table_name', 

            'relational.chapter_id',

            'edw_chapter.chapt_name',
            'edw_level.level_name',
            // 'edw_prechapters.name as topic_name',

            'problem_sets.created_at', 
            'problem_sets.updated_at', 
            )
        ->get();
        $prbx = $pbs->groupBy('id');
        $prbx->all();
        // dd($prbx);
    @endphp
    @foreach ($prbx as $pb)
    <tr>
        <td>{{$pb->first()->id}}</td>
        <td>
            @foreach ($pb as $format)
            <div style="margin:2px; display:inline-block; font-size:12px; padding:2px 4px; background:#707070; border-radius:4px; color:#fff">{{$format->name}}</div>
            @endforeach
        </td>
        <td>{{$pb->first()->level_name ?? 'not_available'}}</td>
        {{-- <td>{{$pb->first()->topic_name ?? 'not_available'}}</td> --}}
        <td>{{$pb->first()->chapt_name ?? 'not_available'}}</td>
        <td>
            @php $ques = DB::table('problem_set_questions')->where('problem_set_id', $pb->first()->id)->where('active', 1)->get() @endphp
            {{$ques->count()}}
        </td>
        <td>
            <div class="fmt_fpm_date">
                <span>Created:</span>
                {{date('d-n-Y, g:i a',strtotime($pb->first()->created_at))}}
            </div>
            <div class="fmt_fpm_date">
                <span>Updated:</span>
                {{date('d-n-Y, g:i a',strtotime($pb->first()->updated_at))}}
            </div>
        </td>
        <td>
            <a style="background: rgb(9, 88, 206); color:#fff; border-radius:4px; font-size:12px; padding:0 2px;" target="_blank" href="{{route('problem.addques', $pb->first()->id)}}">Add</a>
            @can('admin')
            <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalCMA({{$pb->first()->id}})">Edit</a>
            <a class="fmt_fpm_delete" href="{{route('fmt.edgecontent.problem_set.delete', $pb->first()->id)}}">Delete</a>
            @endcan
            <a style="background: rgb(19, 206, 9); color:#fff; border-radius:4px; font-size:12px; padding:0 2px;" target="_blank" href="{{route('problem.view', $pb->first()->id)}}">View</a>
            {{-- <a style="background: rgb(19, 206, 9); color:#fff; border-radius:4px; font-size:12px; padding:0 2px;" target="_blank" href="{{route('problem.view', $pb->first()->id)}}">Archieve</a> --}}
             <button type="button" style="background: rgb(19, 206, 9); color:yellow; border-radius:4px; font-size:12px; padding:0 2px;" class="reject" data-target="#modalReject" data-toggle="modal" data-uid='{{ $pb->first()->chapter_id }}'>Archieve</button>&nbsp;&nbsp;';
        </td>
    </tr>
    <x-problem.edit :message="$pb->first()->id"/>
    @endforeach
</tbody>
</table>
<script>
function modalCMA($id){
    var modal = document.getElementById('modalCMA'+$id);
    modal.classList.remove("hidden");
}
function closeModalCMA($id){
    var modal = document.getElementById('modalCMA'+$id);
    modal.classList.add("hidden");
}
</script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.22/r-2.2.6/datatables.min.js"></script>
<script>
    $(function() {

        $(document).on("click", ".reject", function () {

                var $this = $(this);

                var $uid = $this.attr("data-uid");
                // console.log($uid);

                $(".rejected").attr("data-uid", $uid);

            });

        $("#rejectform").submit(function (e) {
            
            e.preventDefault();
            swal({
                    html: '<i class="fa fa-spinner fa-spin mb-3" style="font-size:24px"></i>',
                    title: "Please wait, processing...",
                    showConfirmButton: true,
                })
            
            var id = $('.rejected').attr("data-uid");
                // console.log($id);

            var link_id = $("#ChapterLevelId").val();

            $.ajax({

                url: "{{ url('dashboard/chapterArchieve') }}/" + id,
                type: "get",
                data: {
    
                       'link_id': link_id
    
                },
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    /*if(response.status == 1)
                    {*/
                        swal({
                              title: "Success!",
                              type: "success",
                        })
                        .then(() => {

                            $("#modalReject").modal("hide");
                            location.reload(); 
                        });

                    // }
                    
                }

            });

        });

    });
$('#fmt_problem_set_index').dataTable( {
    "paging": true
});
</script>

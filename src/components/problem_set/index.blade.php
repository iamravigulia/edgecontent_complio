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
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<table class="cell-border" id="fmt_problem_set_index" style="width:100%">
<thead>
    <th>#</th>
    <th>No of Questions</th>
    <th>Created/Updated</th>
    <th>Actions</th>
</thead>
<tbody>
    @php
        $pbs = DB::table('problem_sets')->get();
    @endphp
    @foreach ($pbs as $pb)
    <tr>
        <td>{{$pb->id}}</td>
        <td>
            @php $ques = DB::table('problem_set_questions')->where('problem_set_id', $pb->id)->get() @endphp
            {{$ques->count()}}
        </td>
        <td>
            <div class="fmt_fpm_date">
                <span>Created:</span>
                {{date('d-n-Y, g:i a',strtotime($pb->created_at))}}
            </div>
            <div class="fmt_fpm_date">
                <span>Updated:</span>
                {{date('d-n-Y, g:i a',strtotime($pb->updated_at))}}
            </div>
        </td>
        <td>
            <a class="fmt_fpm_addMore" href="javascript:void(0);" onclick="modalAddMore({{$pb->id}})">addMore</a>
            <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalCMA({{$pb->id}})">Edit</a>
            <a class="fmt_fpm_delete" href="{{route('fmt.edgecontent.problem_set.delete', $pb->id)}}">Delete</a>
        </td>
    </tr>
    <x-problem_set.addmore :message="$pb->id"/>
    @endforeach
</tbody>
</table>
<script>
function modalAddMore($id){
    var modal = document.getElementById('modalAddMore'+$id);
    modal.classList.remove("hidden");
}
function closeModalAddMore($id){
    var modal = document.getElementById('modalAddMore'+$id);
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
</script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.22/r-2.2.6/datatables.min.js"></script>
<script>
$('#fmt_problem_set_index').dataTable( {
    "paging": true
});
</script>
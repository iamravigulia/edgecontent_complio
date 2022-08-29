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
    #fmt_question_format_index_length{
        
    }
    #fmt_question_format_index_wrapper{
        display: block;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<table class="cell-border" id="fmt_question_format_index" style="width:100%">
<thead>
    <th>#</th>
    <th>Name</th>
    <th>Question Table Name</th>
    <th>Answer Table Name</th>
    <th>Created/Updated</th>
    <th>Actions</th>
</thead>
<tbody>
    @php
        $fmts = DB::table('format_types')->get();
    @endphp
    @foreach ($fmts as $fmt)
    <tr>
        <td>{{$fmt->id}}</td>
        <td>
            {{$fmt->name}}
        </td>
        <td>
            {{$fmt->question_table_name}}
        </td>
        <td>
            {{$fmt->answer_table_name}}
        </td>
        <td>
            <div class="fmt_fpm_date">
                <span>Created:</span>
                {{date('d-n-Y, g:i a',strtotime($fmt->created_at))}}
            </div>
            <div class="fmt_fpm_date">
                <span>Updated:</span>
                {{date('d-n-Y, g:i a',strtotime($fmt->updated_at))}}
            </div>
        </td>
        <td>
            <a class="fmt_fpm_edit" href="javascript:void(0);" onclick="modalCMA({{$fmt->id}})">Edit</a>
            <a class="fmt_fpm_delete" href="{{route('fmt.edgecontent.format.delete', $fmt->id)}}">Delete</a>
        </td>
    </tr>
    <x-format.edit :message="$fmt->id"/>
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
$('#fmt_question_format_index').dataTable( {
    "paging": true
});
</script>
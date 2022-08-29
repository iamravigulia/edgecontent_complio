@php
    $que = DB::table('problem_set_questions')->where('id', $id)->where('active', 1)->first();
        
        $fm = DB::table('format_types')
            ->where('id', $que->format_type_id)
            ->select('id', 'name', 'slug', 'question_table_name', 'answer_table_name')
            ->first();
        $tname = $fm->answer_table_name;
        $question = DB::table($fm->question_table_name)->where('id', $que->question_id)->first();
       
        $answers = DB::table($fm->answer_table_name)->where('question_id',$question->id)->get();
@endphp

<!DOCTYPE html>
<html>

<head>
    <title>Sequence Change</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <div class="row mt-5" style="width: 100%;">
        <div class="col-md-10 offset-md-1">
            <h3 class="text-center mb-4">Question - {{ $question->question }}</h3>
            <table id="table" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="30px">#</th>
                        <th>Title</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody id="tablecontents">
                   @if($answers)
                    @foreach ($answers as $answer)
                    <tr class="row1" data-id="{{ $answer->id }}" table-name="{{$tname}}">
                        <td class="pl-3"><i class="fa fa-sort"></i></td>
                        <td>{{$answer->answer}}</td>
                        <td>{{$answer->created_at}}</td>
                    </tr>
                    @endforeach
                    <input type="text" id="table_name1" value="{{ $tname }}" style="display: none"/>
                   @endif
                </tbody>
            </table>
            <hr>
            
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#table").DataTable();

            $("#tablecontents").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {
                var tb_name = document.getElementById('table_name1').value;
                var order = [];
                var token = $('meta[name="csrf-token"]').attr('content');
                $('tr.row1').each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });
                
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('post-sortable') }}",
                    data: {
                        order: order,
                        tname:tb_name,
                        _token: token
                    },
                    success: function(response) {
                        if (response.status == "200") {
                            swal("Sequence updated successfully!", "success");
                            console.log(response);
                        } else {
                            swal("Snap!", "Sequence not updated ", "error");
                            console.log(response);
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
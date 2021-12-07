<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        
    </head>
    <body style="padding-top:60px">
        <div class="container">
            <div class="card">
               
                <div class="card-header">
                    Task List
                </div>
                <div class="card-block">
                        <br>
                        <div class="form-group col-12">
                            <button type="submit" class="btn btn-primary btn-create">Create</button>
                        </div>
                        <table class="table" id="task_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Task</th>
                                    <th class="text-center">Date To</th>
                                    <th class="text-center">Date From</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                </div>
                
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.3.js"></script>
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                var table = $('#task_table').DataTable({
                    processing:true,
                    serverSide:true,
                    length:10,
                    ajax:"{{ route('list') }}",
                    columns:[
                        {data:'task_name',name:'task_name'},
                        {data:'date_from',name:'date_from'},
                        {data:'date_to',name:'date_to'},
                        {data:'status',name:'status'},
                        {
                            data:'action',
                            name:'action',
                            orderable:true,
                            searchable:true
                        },
                    ]
                })
            });
            });
            $('.btn-create').click(function(){
                window.location.href = "{{ route('task.create')}}";
            });
            
        </script>
    </body>
</html>
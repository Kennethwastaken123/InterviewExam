<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        
    </head>
    <body style="padding-top:60px">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Create Task
                    <a href="{{ route('task.index') }}" class="btn btn-primary btn-success" style="float:right;">< Back</a>
                </div>
                <div class="card-block">
                    <form role="form" method="POST" action="{{ route('task.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group col-4">
                            <label class="form-control-label">Task</label>
                            <input type="text" class="form-control" id="task_name" name="task_name" value="{{ old('task_name')}}">
                            @if($errors->has('task_name'))
                                <span class="help-block" style="color:red;">{{ $errors->first('task_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-4">
                            <label class="form-control-label">Date To</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" value="{{ old('date_to')}}">
                            @if($errors->has('date_to'))
                                <span class="help-block" style="color:red;">{{ $errors->first('date_to') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-4">
                            <label class="form-control-label">Date From</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" value="{{ old('date_from')}}">
                            @if($errors->has('date_from'))
                                <span class="help-block" style="color:red;">{{ $errors->first('date_from') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-12">
                            <label class="form-control-label">Task Description</label>
                            <textarea class="form-control" id="task_description" name="task_description">{{ old('task_description')}}</textarea>
                            @if($errors->has('task_description'))
                                <span class="help-block" style="color:red;">{{ $errors->first('task_description') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
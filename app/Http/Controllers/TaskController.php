<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use DataTables;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view('task.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.add');

    }

    public function list()
    {
        $data = DB::table('task')->where('status','!=',3)->get();
     
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('status',function($task){
            return ($task->status == 0?'Not Yet Done':'Done');
        })
        ->editColumn('date_to',function($task){
            return date('d-m-Y', strtotime($task->date_to));
        })
        ->editColumn('date_from',function($task){
            return date('d-m-Y', strtotime($task->date_from));
        })
        ->addColumn('action',function($task){
            return '<a href="'.route("task.edit",$task->id).'" class="btn btn-primary btn-success"><span class="glyphicon glyphicon-edit"></span></a> <form action="' . route("task.delete",$task->id). '" method="POST">
            '.csrf_field().'
            '.method_field("PUT").'
            <button type="submit" class="btn btn-primary btn-danger"
                onclick="return confirm(\'Are You Sure Want to Delete?\')"><span class="glyphicon glyphicon-trash"></span></a>
            </form>';
        })
        ->make(true);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_name' =>'required',
            'date_to' =>'required',
            'date_from' =>'required',
            'task_description' =>'required',
        ]);
        $taskData = $request->input();
        $task = new Task;
        
        $task->task_name = $taskData['task_name'];
        $task->date_to =$taskData['date_to'];
        $task->date_from =$taskData['date_from'];
        $task->task_description = $taskData['task_description'];
        $task->status = 0;
        $task->save();
        return view('task.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::where('id',$id)->first();
        return view('task.edit',['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'task_name' =>'required',
            'date_to' =>'required',
            'date_from' =>'required',
            'task_description' =>'required'
        ]);
        $taskData = $request->input();
        $status = 0;
        if($request->has('status')){
            $status = 1;
        }
        $task = Task::where('id', $id)
        ->update([
           'task_name' => $taskData['task_name'],
           'date_to' => $taskData['date_to'],
           'date_from' => $taskData['date_from'],
           'task_description' => $taskData['task_description'],
           'status' => $status,
        ]);
        return view('task.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    public function delete($id)
    {
    
        $task = Task::where('id', $id)
        ->update([
           'status' => 3,
        ]);
        return view('task.list');
    }
}

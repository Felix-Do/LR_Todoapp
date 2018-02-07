<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\TaskCreateRequest;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('duedate', 'asc')->paginate(5);
        return view('pages.tasks.index')->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->input('name')) || empty($request->input('duedate'))) {
            return \Redirect::action('User\TasksController@create');
        }

        // create new Task
        $task = new Task;
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->duedate = $request->input('duedate');
        $task->status = $request->input('status');
        if (empty($request->input('status'))) {
            $task->status = 0;
        }
        $task->label = $request->input('label');
        if (empty($request->input('label'))) {
            $task->label = 0;
        }
        $task->save();

        return \Redirect::action('User\TasksController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // trying to destroy a task always goes here for some reason
        // so this function will be used for deleting tasks instead
        $task = Task::find($id);
        $task->delete();
        // $task = Task::find($id);
        // return view('pages.tasks.show')->with('task', $task);
        return redirect(action('User\TasksController@index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('pages.tasks.edit')->with('task', $task);
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

        // check if updating or deleting
        if ( $request->input('actionBtn') == "delete" ) {
            // delete this task
            return redirect(action('User\TasksController@destroy', $id));
        }

        if (empty($request->input('name')) || empty($request->input('duedate'))) {
            return \Redirect::action('User\TasksController@edit', $id);
        }
        
        $task = Task::find($id);
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->duedate = $request->input('duedate');
        $task->status = $request->input('status');
        if (empty($request->input('status'))) {
            $task->status = 0;
        }
        $task->label = $request->input('label');
        if (empty($request->input('label'))) {
            $task->label = 0;
        }
        $task->save();

        return \Redirect::action('User\TasksController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $task = Task::find($id);
        // $task->delete();
        // Task::destroy($id);
        return \Redirect::action('User\TasksController@index');
    }
}

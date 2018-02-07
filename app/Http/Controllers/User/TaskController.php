<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\UserServiceInterface;
use App\Http\Requests\TaskCreateRequest;
use App\Repositories\TaskTemplateRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Services\ProjectServiceInterface;
use App\Services\ShiftServiceInterface;
use App\Services\TaskServiceInterface;

class TaskController extends Controller
{
    /** @var \App\Services\UserServiceInterface UserService */
    protected $userService;
    /** @var TaskServiceInterface $taskService */
    protected $taskService;

    public function __construct(
        UserServiceInterface $userService
        // , TaskServiceInterface $taskService
    ) {
        $this->userService = $userService;
        // $this->taskService            = $taskService;
    }
    
    // /** @var TaskRepositoryInterface $taskRepository */
    // protected $taskRepository;
    // /** @var ProjectServiceInterface $projectService */
    // protected $projectService;
    // /** @var TaskTemplateRepositoryInterface $taskTemplateRepository */
    // protected $taskTemplateRepository;
    // /** @var ShiftServiceInterface $shiftServices */
    // protected $shiftService;

    // public function __construct(
    //     // ProjectServiceInterface $projectService,
    //     // TaskTemplateRepositoryInterface $taskTemplateRepository,
    //     // ShiftServiceInterface $shiftService,
    //     // TaskRepositoryInterface $taskRepository
    // ) {
    //     // $this->projectService         = $projectService;
    //     // $this->taskTemplateRepository = $taskTemplateRepository;
    //     // $this->shiftService           = $shiftService;
    //     // $this->taskRepository         = $taskRepository;
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->userService->getUser();
        $all_tasks = Task::orderBy('duedate', 'asc')->paginate(5);
        $tasks = array();
        foreach ($all_tasks as $task) {
            if ($task->user_id == $user->id) {
                array_push($tasks, $task);
            }
        }
        $data = [
            'tasks' => $tasks,
            'user' => $user
        ];
        return view('pages.user.tasks.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // create a temp Task to pass to the Create page
        // this Task will have a temp "Untitled Task" name
        // and a non-blank duedate attempted to be set to today (currently failing)
        $task = new Task;
        $task->name = "Untitled Task";
        $task->duedate = date('Y/m/d');
        $user = $this->userService->getUser();
        $data = [
            'task' => $task,
            'user' => $user
        ];
        return view('pages.user.tasks.create')->with('data', $data);
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
            // create a temp Task to pass back to the Create page
            // (should this not be here and somewhere else instead?)
            $task = new Task;
            $task->name = $request->input('name');
            $task->description = $request->input('description');
            $task->duedate = $request->input('duedate');
            $task->status = $request->input('status');
            $task->label = $request->input('label');
            if (empty($request->input('status'))) $task->status = 0;
            if (empty($request->input('label'))) $task->label = 0;
            $user = $this->userService->getUser();
            $data = [
                'task' => $task,
                'user' => $user
            ];
            return view('pages.user.tasks.create')->with('data', $data);
        }

        $user = $this->userService->getUser();
        // create new Task
        $task = new Task;
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->duedate = $request->input('duedate');
        $task->status = $request->input('status');
        $task->label = $request->input('label');
        $task->user_id = $user->id;
        if (empty($request->input('status'))) $task->status = 0;
        if (empty($request->input('label'))) $task->label = 0;
        $task->save();

        return \Redirect::action('User\TaskController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // redirect to index (nothing to show)
        return \Redirect::action('User\TaskController@index');
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
        $user = $this->userService->getUser();
        // redirect to index page if the user has no rights
        if ($task->user_id !== $user->id) {
            return \Redirect::action('User\TaskController@index');
        }
        $data = [
            'task' => $task,
            'user' => $user
        ];
        return view('pages.user.tasks.edit')->with('data', $data);
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
            return \Redirect::action('User\TaskController@destroy', ['id' => $id]);
        }

        if (empty($request->input('name')) || empty($request->input('duedate'))) {
            // field is empty, go back to edit page with the original values
            return \Redirect::action('User\TaskController@edit', $id);
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

        return \Redirect::action('User\TaskController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $task = Task::find($id);
        $user = $this->userService->getUser();
        // redirect to index page if the user has no rights
        if ($task->user_id !== $user->id) {
            return \Redirect::action('User\TaskController@index');
        }
        $task->delete();
        // Task::destroy($id);
        return \Redirect::action('User\TaskController@index');
    }
}

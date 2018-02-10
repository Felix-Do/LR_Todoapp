<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\UserServiceInterface;
use App\Http\Requests\TaskCreateRequest;
use App\Services\TaskServiceInterface;
use App\Repositories\TaskRepositoryInterface;
// use App\Repositories\TaskTemplateRepositoryInterface;
// use App\Services\ProjectServiceInterface;
// use App\Services\ShiftServiceInterface;

class TaskController extends Controller
{
    /** @var \App\Services\UserServiceInterface UserService */
    protected $userService;
    /** @var TaskServiceInterface $taskService */
    protected $taskService;
    /** @var TaskRepositoryInterface $taskRepository */
    protected $taskRepository;
    
    // /** @var ProjectServiceInterface $projectService */
    // protected $projectService;
    // /** @var TaskTemplateRepositoryInterface $taskTemplateRepository */
    // protected $taskTemplateRepository;
    // /** @var ShiftServiceInterface $shiftServices */
    // protected $shiftService;

    public function __construct(
        UserServiceInterface $userService
        , TaskServiceInterface $taskService
        , TaskRepositoryInterface $taskRepository
        // , TaskTemplateRepositoryInterface $taskTemplateRepository
        // , ProjectServiceInterface $projectService
        // , ShiftServiceInterface $shiftService
    ) {
        $this->userService            = $userService;
        $this->taskService            = $taskService;
        $this->taskRepository         = $taskRepository;
        // $this->taskTemplateRepository = $taskTemplateRepository;
        // $this->projectService         = $projectService;
        // $this->shiftService           = $shiftService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $this->userService->getUser_hidePassword();
        if(empty($user)) {
            return redirect(action('User\AuthController@getSignIn'));
        }
        $this->taskService->setFilterSort_request($request->all());
        $tasks = $this->taskService->getTasks($user->id);
        return view('pages.user.tasks.index', [
            'tasks' => $tasks,
            'user' => $user,
            'sort' => $this->taskService->getSort(),
            'filter' => $this->taskService->getFilter()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = $this->userService->getUser_hidePassword();
        if(empty($user)) {
            return redirect(action('User\TaskController@index'));
        }
        // create a temp Task to pass to the Create page
        $task = $this->taskService->newTask_param();
        return view('pages.user.tasks.create', [
            'task' => $task,
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->userService->getUser_hidePassword();
        if(empty($user)) {
            return redirect(action('User\AuthController@getSignIn'));
        }
        if (empty($request->input('name')) || empty($request->input('duedate'))) {
            // inputs are no good
            // create a temp Task to pass back to the Create page
            $task = $this->taskService->newTask($request->all(), $user->id);
            return view('pages.user.tasks.create', [
                'task' => $task,
                'user' => $user
            ]);
        }

        $task = $this->taskService->storeTask($request->all(), $user->id);

        return redirect(action('User\TaskController@index'));
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
        return redirect(action('User\TaskController@index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userService->getUser_hidePassword();
        $task = $this->taskService->getTask($id, $user->id);
        // redirect to index page if the user has no rights or task does not exist
        if ($task->user_id !== $user->id || empty($task)) {
            return \Redirect::action('User\TaskController@index');
        }
        return view('pages.user.tasks.edit', [
            'task' => $task,
            'user' => $user
        ]);
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
        $user = $this->userService->getUser_hidePassword();
        $task = $this->taskService->updateTask($request,$id,$user->id);
        if (empty($task)) {
            // a required field is empty, go back to edit page with the original values
            return \Redirect::action('User\TaskController@edit', $id);
        }

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
        $user = $this->userService->getUser_hidePassword();
        $this->taskService->deleteTask($id, $user->id);
        return \Redirect::action('User\TaskController@index');
    }
    
    // public function sort_filter(Request $request) {
    //     if ($request->input('filter') != '') {
    //         // return $request->input('filter');
    //     }
    //     return redirect(action('User\TaskController@index'));
    // }
}

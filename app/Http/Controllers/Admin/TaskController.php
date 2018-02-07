<?PHP

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use App\Http\Requests\Admin\TaskRequest;
use LaravelRocket\Foundation\Http\Requests\PaginationRequest;

class TaskController extends Controller
{

    /** @var  \App\Repositories\TaskRepositoryInterface */
    protected $taskRepository;


    public function __construct(
        TaskRepositoryInterface $taskRepository
    )
    {
        $this->taskRepository = $taskRepository;
    }

    /**
    * Display a listing of the resource.
    *
    * @param    \LaravelRocket\Foundation\Http\Requests\PaginationRequest $request
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function index(PaginationRequest $request)
    {
        $offset = $request->offset();
        $limit = $request->limit();
        $count = $this->taskRepository->count();
        $tasks = $this->taskRepository->get('id', 'desc', $offset, $limit);

        return view('pages.admin.tasks.index', [
            'models'  => $tasks,
            'count'   => $count,
            'offset'  => $offset,
            'limit'   => $limit,
            'baseUrl' => action('Admin\TaskController@index'),
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function create()
    {
        return view('pages.admin.tasks.edit', [
            'isNew'     => true,
            'task' => $this->taskRepository->getBlankModel(),
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param    $request
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function store(TaskRequest $request)
    {
        $input = $request->only([
            'user_id',
            'name',
            'description',
            'duedate',
            'status',
            'label',
        ]);

        $task = $this->taskRepository->create($input);

        if (empty( $task )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\TaskController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
    * Display the specified resource.
    *
    * @param    int $id
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function show($id)
    {
        $task = $this->taskRepository->find($id);
        if (empty( $task )) {
            abort(404);
        }

        return view('pages.admin.tasks.edit', [
            'isNew' => false,
            'task' => $task,
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param    int $id
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function edit($id)
    {
        return redirect()->action('Admin\TaskController@show', [$id]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param    int $id
    * @param            $request
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function update($id, TaskRequest $request)
    {
        $task = $this->taskRepository->find($id);
        if (empty( $task )) {
            abort(404);
        }

        $input = $request->only([
            'user_id',
            'name',
            'description',
            'duedate',
            'status',
            'label',
        ]);
        $this->taskRepository->update($task, $input);

        return redirect()->action('Admin\TaskController@show', [$id])
            ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param    int $id
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function destroy($id)
    {
        $task = $this->taskRepository->find($id);
        if (empty( $task )) {
            abort(404);
        }
        $this->taskRepository->delete($task);

        return redirect()->action('Admin\TaskController@index')
            ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}

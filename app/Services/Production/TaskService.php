<?PHP

namespace App\Services\Production;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use App\Services\TaskServiceInterface;
use LaravelRocket\Foundation\Services\Production\BaseService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class TaskService extends  BaseService  implements TaskServiceInterface
{
    /** @var  \App\Repositories\TaskRepositoryInterface */
    protected $taskRepository;

    public function __construct(
        TaskRepositoryInterface $taskRepository
    ) {
        $this->taskRepository = $taskRepository;
    }

    public function getModel() {
        return new Task;
    }

    public function getTasks($user_id=-1,$perPageCount=-1,$sortBy='duedate',$sortDir='asc') {
        
        $perPageCountMax = 10;
        if ($perPageCount < 1 || $perPageCount > $perPageCountMax) {
            $perPageCount = $perPageCountMax;
        }

        // get the tasks and sort them
        $tasks = Task::orderBy('duedate', 'asc')->paginate($perPageCount);
        if ($user_id >= 0) {
            $tasks = Task::orderBy('duedate', 'asc')
                ->where('user_id', $user_id)
                ->paginate($perPageCount);
        }
        if (Schema::hasTable('tasks')) {
            if (Schema::hasColumn('tasks', $sortBy)) {
                if ($sortDir=='asc' || $sortDir=='desc') {
                    $tasks = Task::orderBy($sortBy, $sortDir)->paginate($perPageCount);
                    if ($user_id >= 0) {
                        $tasks = Task::orderBy($sortBy, $sortDir)
                            ->where('user_id', $user_id)
                            ->paginate($perPageCount);
                    }
                }
            }
        }
        
        return $tasks;
    }

    public function getTask($id=-1,$user_id=-1) {
        $task = Task::find($id);
        if ($task->user_id !== $user_id && $user_id >= 0) return "";
        return $task;
    }

    public function modifyTask_param(
        $task,
        $user_id=0,
        $name="Untitled Task",
        $description="",
        $duedate="current_date",
        $status=0,
        $label=0
    ) {
        if (empty($task)) return "";
        $task->user_id = $user_id;
        $task->user_id = $user_id;
        $task->name = $name;
        $task->description = $description;
        $task->duedate = $duedate;
        if ($task->duedate == "current_date") {
            $task->duedate = date('Y/m/d');
        }
        $task->status = $status;
        $task->label = $label;
        return $task;
    }

    public function modifyTask($task, $user_id, $request) {
        $name = $request['name'];
        $description = $request['description'];
        $duedate = $request['duedate'];
        $status = $request['status'];
        $label = $request['label'];
        if (empty($request['status'])) $status = 0;
        if (empty($request['label'])) $label = 0;
        return $this->modifyTask_param($task,$user_id,$name,$description,$duedate,$status,$label);
    }
    
    public function newTask_param(
        $user_id=0,
        $name="Untitled Task",
        $description="",
        $duedate="current_date",
        $status=0,
        $label=0
    ) {
        $task = $this->getModel();
        return $this->modifyTask_param($task,$user_id,$name,$description,$duedate,$status,$label);
    }
    
    public function newTask($request,$user_id=0) {
        $task = $this->getModel();
        return $this->modifyTask($task,$user_id,$request);
    }

    public function storeTask($request,$user_id=0) {
        $task = $this->newTask($request,$user_id);
        $task->save();
        return $task;
    }

    public function updateTask($request,$id,$user_id=0) {
        $task = $this->getTask($id,$user_id);
        if (empty($task)) return "";
        $task = $this->modifyTask($task, $user_id, $request);
        if (empty($task->name) || empty($task->duedate)) return "";
        $task->save();
        return $task;
    }

    public function deleteTask($id,$user_id=0) {
        $task = $this->getTask($id,$user_id);
        if (empty($task)) return "";
        $task->delete();
        return "";
    }
}

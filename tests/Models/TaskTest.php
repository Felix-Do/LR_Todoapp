<?PHP

namespace Tests\Models;

use App\Models\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var    \App\Models\Task $task */
        $task = new Task();
        $this->assertNotNull($task);
    }

    public function testStoreNew()
    {
        /** @var    \App\Models\Task $task */
        $taskModel = new Task();

        $taskData = factory(Task::class)->make();
        foreach( $taskData->toFillableArray() as $key => $value ) {
            $taskModel->$key = $value;
        }
        $taskModel->save();

        $this->assertNotNull(Task::find($taskModel->id));
    }

}

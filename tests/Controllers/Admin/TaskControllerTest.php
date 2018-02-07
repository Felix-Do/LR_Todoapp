<?PHP

namespace Tests\Controllers\Admin;

use Tests\TestCase;

class TaskControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var    \App\Http\Controllers\Admin\TaskController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\TaskController::class);
        $this->assertNotNull($controller);
    }

    public function setUp()
    {
        parent::setUp();
        $authUser = factory(\App\Models\AdminUser::class)->create();
        $authUserRole = factory(\App\Models\AdminUserRole::class)->create([
            'admin_user_id' => $authUser->id,
            'role' => \App\Models\AdminUserRole::ROLE_SUPER_USER,
        ]);
        $this->be($authUser, 'admins');
    }

    public function testGetList()
    {
        $response = $this->action('GET', 'Admin\TaskController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\TaskController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $task = factory(\App\Models\Task::class)->make();
        $this->action('POST', 'Admin\TaskController@store', [
                '_token' => csrf_token(),
            ] + $task->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $task = factory(\App\Models\Task::class)->create();
        $this->action('GET', 'Admin\TaskController@show', [$task->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $task = factory(\App\Models\Task::class)->create();

        $testData = str_random(10);
        $id = $task->id;

        $task->name = $testData;

        $this->action('PUT', 'Admin\TaskController@update', [$id], [
                '_token' => csrf_token(),
            ] + $task->toArray());
        $this->assertResponseStatus(302);

        $newTask = \App\Models\Task::find($id);
        $this->assertEquals($testData, $newTask->name);
    }

    public function testDeleteModel()
    {
        $task = factory(\App\Models\Task::class)->create();

        $id = $task->id;

        $this->action('DELETE', 'Admin\TaskController@destroy', [$id], [
            '_token' => csrf_token(),
        ]);
        $this->assertResponseStatus(302);

        $checkTask = \App\Models\Task::find($id);
        $this->assertNull($checkTask);
    }

}

<?PHP

namespace Tests\Controllers\Admin;

use Tests\TestCase;

class BranchControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var    \App\Http\Controllers\Admin\BranchController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\BranchController::class);
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
        $response = $this->action('GET', 'Admin\BranchController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\BranchController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $branch = factory(\App\Models\Branch::class)->make();
        $this->action('POST', 'Admin\BranchController@store', [
                '_token' => csrf_token(),
            ] + $branch->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $branch = factory(\App\Models\Branch::class)->create();
        $this->action('GET', 'Admin\BranchController@show', [$branch->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $branch = factory(\App\Models\Branch::class)->create();

        $testData = str_random(10);
        $id = $branch->id;

        $branch->name = $testData;

        $this->action('PUT', 'Admin\BranchController@update', [$id], [
                '_token' => csrf_token(),
            ] + $branch->toArray());
        $this->assertResponseStatus(302);

        $newBranch = \App\Models\Branch::find($id);
        $this->assertEquals($testData, $newBranch->name);
    }

    public function testDeleteModel()
    {
        $branch = factory(\App\Models\Branch::class)->create();

        $id = $branch->id;

        $this->action('DELETE', 'Admin\BranchController@destroy', [$id], [
            '_token' => csrf_token(),
        ]);
        $this->assertResponseStatus(302);

        $checkBranch = \App\Models\Branch::find($id);
        $this->assertNull($checkBranch);
    }

}

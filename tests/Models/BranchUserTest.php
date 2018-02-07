<?PHP

namespace Tests\Models;

use App\Models\BranchUser;
use Tests\TestCase;

class BranchUserTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var    \App\Models\BranchUser $branchUser */
        $branchUser = new BranchUser();
        $this->assertNotNull($branchUser);
    }

    public function testStoreNew()
    {
        /** @var    \App\Models\BranchUser $branchUser */
        $branchUserModel = new BranchUser();

        $branchUserData = factory(BranchUser::class)->make();
        foreach( $branchUserData->toFillableArray() as $key => $value ) {
            $branchUserModel->$key = $value;
        }
        $branchUserModel->save();

        $this->assertNotNull(BranchUser::find($branchUserModel->id));
    }

}

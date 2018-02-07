<?PHP

namespace Tests\Services;

use Tests\TestCase;

class TaskServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var    \App\Services\TaskServiceInterface $service */
        $service = \App::make(\App\Services\TaskServiceInterface::class);
        $this->assertNotNull($service);
    }

}

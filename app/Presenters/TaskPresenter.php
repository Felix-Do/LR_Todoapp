<?PHP

namespace App\Presenters;

use LaravelRocket\Foundation\Presenters\BasePresenter;

/**
 *
 * @property  \App\Models\Task $entity
 * @property  int $id
 * @property  string $name
 * @property  string $description
 * @property  mixed $duedate
 * @property  int $status
 * @property  int $label
 * @property  \Carbon\Carbon $created_at
 * @property  \Carbon\Carbon $updated_at
 */

class TaskPresenter extends BasePresenter
{

    protected $multilingualFields = [
    ];

    protected $imageFields = [
    ];


}

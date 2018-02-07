<?PHP

namespace App\Presenters;

use LaravelRocket\Foundation\Presenters\BasePresenter;

/**
 *
 * @property  \App\Models\Task $entity
 * @property  int $id
 * @property  int $user_id
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

    public function statusName($value=0) {
        if ($value == 1) return "In Progress";
        else if ($value == 2) return "Finished";
        else return "Not Started";
    }

    public function labelName($value=0) {
        if ($value == 0) return "No Label";
        else return "Label ".$value;
    }
}

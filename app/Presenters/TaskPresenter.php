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

    public function statusName($value=-1) {
        // $value == -1 means get the current status of this row
        if ($value == -1) $value = $this->status;
        if ($value == 1) return "In Progress";
        else if ($value == 2) return "Finished";
        else return "Not Started";
    }

    public function statusCheck($value=-1) {
        if ($this->status == $value) return "checked";
        else return "";
    }

    public function statusCount() {
        return 3;
    }

    public function labelName($value=-1) {
        // $value == -1 means get the current label of this row
        if ($value == -1) $value = $this->label;
        if ($value == 0) return "No_Label";
        else return "Label_".$value;
    }

    public function labelCheck($value=-1) {
        if ($this->label == $value) return "checked";
        else return "";
    }

    public function labelCount() {
        return 6;
    }
}

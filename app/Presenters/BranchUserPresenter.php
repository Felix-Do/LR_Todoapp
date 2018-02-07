<?PHP

namespace App\Presenters;

use LaravelRocket\Foundation\Presenters\BasePresenter;

/**
 *
 * @property  \App\Models\BranchUser $entity
 * @property  int $id
 * @property  int $user_id
 * @property  int $branch_id
 * @property  \Carbon\Carbon $created_at
 * @property  \Carbon\Carbon $updated_at
 */

class BranchUserPresenter extends BasePresenter
{

    protected $multilingualFields = [
    ];

    protected $imageFields = [
    ];

    public function user()
    {
        $model = $this->entity->user;
        if (!$model) {
            $model      = new \App\Models\User();
        }
        return $model;
    }

}

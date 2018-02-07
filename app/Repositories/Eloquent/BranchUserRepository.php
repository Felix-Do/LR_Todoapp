<?PHP

namespace App\Repositories\Eloquent;

use LaravelRocket\Foundation\Repositories\Eloquent\RelationModelRepository;
use App\Repositories\BranchUserRepositoryInterface;
use App\Models\BranchUser;

class BranchUserRepository extends RelationModelRepository implements BranchUserRepositoryInterface
{

    public function getBlankModel()
    {
        return new BranchUser();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    protected function buildQueryByFilter($query, $filter)
    {

        return parent::buildQueryByFilter($query, $filter);
    }

}

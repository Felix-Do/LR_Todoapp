<?PHP

namespace App\Repositories;

use LaravelRocket\Foundation\Repositories\SingleKeyModelRepositoryInterface;
/**
 *
 * @method  \App\Models\BranchUser[] getEmptyList()
 * @method  \App\Models\BranchUser[]|\Traversable|array all($order = null, $direction = null)
 * @method  \App\Models\BranchUser[]|\Traversable|array get($order, $direction, $offset, $limit)
 * @method  \App\Models\BranchUser create($value)
 * @method  \App\Models\BranchUser find($id)
 * @method  \App\Models\BranchUser[]|\Traversable|array allByIds($ids, $order = null, $direction = null, $reorder = false)
 * @method  \App\Models\BranchUser[]|\Traversable|array getByIds($ids, $order = null, $direction = null, $offset = null, $limit = null);
 * @method  \App\Models\BranchUser update($model, $input)
 * @method  \App\Models\BranchUser save($model);
 * @method  \App\Models\BranchUser firstByFilter($filter);
 * @method  \App\Models\BranchUser[]|\Traversable|array getByFilter($filter,$order = null, $direction = null, $offset = null, $limit = null);
 * @method  \App\Models\BranchUser[]|\Traversable|array allByFilter($filter,$order = null, $direction = null);
 */

interface BranchUserRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @return  \App\Models\BranchUser
     */
    public function getBlankModel();
}

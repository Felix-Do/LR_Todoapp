<?PHP

namespace App\Repositories;

use LaravelRocket\Foundation\Repositories\SingleKeyModelRepositoryInterface;
/**
 *
 * @method  \App\Models\Branch[] getEmptyList()
 * @method  \App\Models\Branch[]|\Traversable|array all($order = null, $direction = null)
 * @method  \App\Models\Branch[]|\Traversable|array get($order, $direction, $offset, $limit)
 * @method  \App\Models\Branch create($value)
 * @method  \App\Models\Branch find($id)
 * @method  \App\Models\Branch[]|\Traversable|array allByIds($ids, $order = null, $direction = null, $reorder = false)
 * @method  \App\Models\Branch[]|\Traversable|array getByIds($ids, $order = null, $direction = null, $offset = null, $limit = null);
 * @method  \App\Models\Branch update($model, $input)
 * @method  \App\Models\Branch save($model);
 * @method  \App\Models\Branch firstByFilter($filter);
 * @method  \App\Models\Branch[]|\Traversable|array getByFilter($filter,$order = null, $direction = null, $offset = null, $limit = null);
 * @method  \App\Models\Branch[]|\Traversable|array allByFilter($filter,$order = null, $direction = null);
 */

interface BranchRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @return  \App\Models\Branch
     */
    public function getBlankModel();
}

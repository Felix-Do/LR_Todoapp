<?PHP

namespace App\Repositories;

use LaravelRocket\Foundation\Repositories\SingleKeyModelRepositoryInterface;
/**
 *
 * @method  \App\Models\Task[] getEmptyList()
 * @method  \App\Models\Task[]|\Traversable|array all($order = null, $direction = null)
 * @method  \App\Models\Task[]|\Traversable|array get($order, $direction, $offset, $limit)
 * @method  \App\Models\Task create($value)
 * @method  \App\Models\Task find($id)
 * @method  \App\Models\Task[]|\Traversable|array allByIds($ids, $order = null, $direction = null, $reorder = false)
 * @method  \App\Models\Task[]|\Traversable|array getByIds($ids, $order = null, $direction = null, $offset = null, $limit = null);
 * @method  \App\Models\Task update($model, $input)
 * @method  \App\Models\Task save($model);
 * @method  \App\Models\Task firstByFilter($filter);
 * @method  \App\Models\Task[]|\Traversable|array getByFilter($filter,$order = null, $direction = null, $offset = null, $limit = null);
 * @method  \App\Models\Task[]|\Traversable|array allByFilter($filter,$order = null, $direction = null);
 */

interface TaskRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @return  \App\Models\Task
     */
    public function getBlankModel();
}

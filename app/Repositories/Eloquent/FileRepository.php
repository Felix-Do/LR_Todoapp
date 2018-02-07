<?PHP

namespace App\Repositories\Eloquent;

use LaravelRocket\Foundation\Repositories\Eloquent\SingleKeyModelRepository;
use App\Repositories\FileRepositoryInterface;
use App\Models\File;

class FileRepository extends SingleKeyModelRepository implements FileRepositoryInterface
{

    public function getBlankModel()
    {
        return new File();
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
        if (array_key_exists('query', $filter)) {
            $searchWord = array_get($filter, 'query');
            if (!empty($searchWord)) {
                $query = $query->where(function ($q) use ($searchWord) {
                    $q->where('original_file_name', 'LIKE', '%'.$searchWord.'%')
                ;
                });
                unset($filter['query']);
            }
        }

        return parent::buildQueryByFilter($query, $filter);
    }

}

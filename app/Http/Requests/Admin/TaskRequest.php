<?PHP

namespace App\Http\Requests\Admin;

use LaravelRocket\Foundation\Http\Requests\Request;
use App\Repositories\TaskRepositoryInterface;

class TaskRequest extends Request
{

    /** @var  \App\Repositories\TaskRepositoryInterface */
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        parent::__construct();
        $this->taskRepository = $taskRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return $this->taskRepository->rules();
    }

    public function messages()
    {
        return $this->taskRepository->messages();
    }

}

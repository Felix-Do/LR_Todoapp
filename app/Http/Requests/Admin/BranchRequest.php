<?PHP

namespace App\Http\Requests\Admin;

use LaravelRocket\Foundation\Http\Requests\Request;
use App\Repositories\BranchRepositoryInterface;

class BranchRequest extends Request
{

    /** @var  \App\Repositories\BranchRepositoryInterface */
    protected $branchRepository;

    public function __construct(BranchRepositoryInterface $branchRepository)
    {
        parent::__construct();
        $this->branchRepository = $branchRepository;
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
        return $this->branchRepository->rules();
    }

    public function messages()
    {
        return $this->branchRepository->messages();
    }

}

<?PHP

namespace App\Http\Requests\Admin;

use LaravelRocket\Foundation\Http\Requests\Request;
use App\Repositories\BranchUserRepositoryInterface;

class BranchUserRequest extends Request
{

    /** @var  \App\Repositories\BranchUserRepositoryInterface */
    protected $branchUserRepository;

    public function __construct(BranchUserRepositoryInterface $branchUserRepository)
    {
        parent::__construct();
        $this->branchUserRepository = $branchUserRepository;
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
        return $this->branchUserRepository->rules();
    }

    public function messages()
    {
        return $this->branchUserRepository->messages();
    }

}

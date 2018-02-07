<?PHP

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\BranchUserRepositoryInterface;
use App\Models\BranchUser;
use App\Http\Requests\Admin\BranchUserRequest;
use LaravelRocket\Foundation\Http\Requests\PaginationRequest;

class BranchUserController extends Controller
{

    /** @var  \App\Repositories\BranchUserRepositoryInterface */
    protected $branchUserRepository;


    public function __construct(
        BranchUserRepositoryInterface $branchUserRepository
    )
    {
        $this->branchUserRepository = $branchUserRepository;
    }

    /**
    * Display a listing of the resource.
    *
    * @param    \LaravelRocket\Foundation\Http\Requests\PaginationRequest $request
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function index(PaginationRequest $request)
    {
        $offset = $request->offset();
        $limit = $request->limit();
        $count = $this->branchUserRepository->count();
        $branchUsers = $this->branchUserRepository->get('id', 'desc', $offset, $limit);

        return view('pages.admin.branch-users.index', [
            'models'  => $branchUsers,
            'count'   => $count,
            'offset'  => $offset,
            'limit'   => $limit,
            'baseUrl' => action('Admin\BranchUserController@index'),
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function create()
    {
        return view('pages.admin.branch-users.edit', [
            'isNew'     => true,
            'branchUser' => $this->branchUserRepository->getBlankModel(),
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param    $request
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function store(BranchUserRequest $request)
    {
        $input = $request->only([
            'user_id',
            'branch_id',
        ]);

        $branchUser = $this->branchUserRepository->create($input);

        if (empty( $branchUser )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\BranchUserController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
    * Display the specified resource.
    *
    * @param    int $id
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function show($id)
    {
        $branchUser = $this->branchUserRepository->find($id);
        if (empty( $branchUser )) {
            abort(404);
        }

        return view('pages.admin.branch-users.edit', [
            'isNew' => false,
            'branchUser' => $branchUser,
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param    int $id
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function edit($id)
    {
        return redirect()->action('Admin\BranchUserController@show', [$id]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param    int $id
    * @param            $request
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function update($id, BranchUserRequest $request)
    {
        $branchUser = $this->branchUserRepository->find($id);
        if (empty( $branchUser )) {
            abort(404);
        }

        $input = $request->only([
            'user_id',
            'branch_id',
        ]);
        $this->branchUserRepository->update($branchUser, $input);

        return redirect()->action('Admin\BranchUserController@show', [$id])
            ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param    int $id
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function destroy($id)
    {
        $branchUser = $this->branchUserRepository->find($id);
        if (empty( $branchUser )) {
            abort(404);
        }
        $this->branchUserRepository->delete($branchUser);

        return redirect()->action('Admin\BranchUserController@index')
            ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}

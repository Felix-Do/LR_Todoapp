<?PHP

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\BranchRepositoryInterface;
use App\Models\Branch;
use App\Http\Requests\Admin\BranchRequest;
use LaravelRocket\Foundation\Http\Requests\PaginationRequest;

class BranchController extends Controller
{

    /** @var  \App\Repositories\BranchRepositoryInterface */
    protected $branchRepository;


    public function __construct(
        BranchRepositoryInterface $branchRepository
    )
    {
        $this->branchRepository = $branchRepository;
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
        $count = $this->branchRepository->count();
        $branches = $this->branchRepository->get('id', 'desc', $offset, $limit);

        return view('pages.admin.branches.index', [
            'models'  => $branches,
            'count'   => $count,
            'offset'  => $offset,
            'limit'   => $limit,
            'baseUrl' => action('Admin\BranchController@index'),
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function create()
    {
        return view('pages.admin.branches.edit', [
            'isNew'     => true,
            'branch' => $this->branchRepository->getBlankModel(),
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param    $request
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function store(BranchRequest $request)
    {
        $input = $request->only([
            'name',
            'country_code',
        ]);

        $branch = $this->branchRepository->create($input);

        if (empty( $branch )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\BranchController@index')
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
        $branch = $this->branchRepository->find($id);
        if (empty( $branch )) {
            abort(404);
        }

        return view('pages.admin.branches.edit', [
            'isNew' => false,
            'branch' => $branch,
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
        return redirect()->action('Admin\BranchController@show', [$id]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param    int $id
    * @param            $request
    * @return  \Response|\Illuminate\Http\RedirectResponse
    */
    public function update($id, BranchRequest $request)
    {
        $branch = $this->branchRepository->find($id);
        if (empty( $branch )) {
            abort(404);
        }

        $input = $request->only([
            'name',
            'country_code',
        ]);
        $this->branchRepository->update($branch, $input);

        return redirect()->action('Admin\BranchController@show', [$id])
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
        $branch = $this->branchRepository->find($id);
        if (empty( $branch )) {
            abort(404);
        }
        $this->branchRepository->delete($branch);

        return redirect()->action('Admin\BranchController@index')
            ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}

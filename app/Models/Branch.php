<?PHP

namespace App\Models;

use LaravelRocket\Foundation\Models\Base;

/**
 * App\Models\Branch.
 *
 * @method \App\Presenters\BranchPresenter present()
 *
 */

class Branch extends Base
{



    /**
     * The database table used by the model.
     *
     * @var  string
     */
    protected $table = 'branches';

    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $fillable = [
        'name',
        'country_code',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var  array
     */
    protected $hidden = [];

    protected $dates  = [
    ];

    protected $presenter = \App\Presenters\BranchPresenter::class;

    // Relations
    public function branchUsers()
    {
        return $this->hasMany(\App\Models\BranchUser::class, 'branch_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\BranchUser::class, 'branch_users', 'user_id', 'branch_id');
    }


    // Utility Functions

}

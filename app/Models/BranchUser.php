<?PHP

namespace App\Models;

use LaravelRocket\Foundation\Models\Base;

/**
 * App\Models\BranchUser.
 *
 * @method \App\Presenters\BranchUserPresenter present()
 *
 */

class BranchUser extends Base
{



    /**
     * The database table used by the model.
     *
     * @var  string
     */
    protected $table = 'branch_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $fillable = [
        'user_id',
        'branch_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var  array
     */
    protected $hidden = [];

    protected $dates  = [
    ];

    protected $presenter = \App\Presenters\BranchUserPresenter::class;

    // Relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id', 'id');
    }


    // Utility Functions

}

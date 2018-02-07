<?PHP

namespace App\Models;

use LaravelRocket\Foundation\Models\Base;

/**
 * App\Models\Task.
 *
 * @method \App\Presenters\TaskPresenter present()
 *
 */

class Task extends Base
{



    /**
     * The database table used by the model.
     *
     * @var  string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'duedate',
        'status',
        'label',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var  array
     */
    protected $hidden = [];

    protected $dates  = [
    ];

    protected $presenter = \App\Presenters\TaskPresenter::class;

    // Relations

    // Utility Functions

}

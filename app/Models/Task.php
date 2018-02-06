<?php

// namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    public $primaryKey = 'id';
    public $timestamps = true;
}

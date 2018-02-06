<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Table Name
    protected $table = 'tasks';
    // Primary Key
    public $primaryKey = 'id';
    // Time Stamp
    public $timestamps = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievements';
    public $primaryKey = 'ach_id';
    public $timestamps = true;
}

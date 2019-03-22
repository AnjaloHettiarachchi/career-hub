<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DegreeProgram extends Model
{
    protected $table = 'degree_programs';
    public $primaryKey = 'deg_id';
    public $timestamps = true;
}

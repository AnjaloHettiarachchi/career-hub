<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';
    public $primaryKey = 'skill_id';
    public $timestamps = true;
}

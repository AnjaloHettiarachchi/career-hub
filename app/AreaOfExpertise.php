<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaOfExpertise extends Model
{
    protected $table = 'areas_of_expertise';
    public $primaryKey = 'aoe_id';
    public $timestamps = true;
}

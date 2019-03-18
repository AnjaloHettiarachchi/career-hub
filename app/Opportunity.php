<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected $table = 'opportunities';
    public $primaryKey = 'op_id';
    public $timestamps = true;
}

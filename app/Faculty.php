<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string fac_short_name
 * @property string fac_name
 * @property mixed fac_id
 */
class Faculty extends Model
{
    protected $table = 'faculties';
    public $primaryKey = 'fac_id';
    public $timestamps = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string uni_short_code
 * @property string uni_title
 * @property mixed uni_id
 */
class University extends Model
{
    protected $table = 'universities';
    public $primaryKey = 'uni_id';
    public $timestamps = true;
}

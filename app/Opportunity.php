<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string op_banner
 * @property mixed op_title
 * @property mixed op_desc
 * @property mixed com_id
 * @property mixed op_id
 */
class Opportunity extends Model
{
    protected $table = 'opportunities';
    public $primaryKey = 'op_id';
    public $timestamps = true;
}

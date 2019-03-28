<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string ach_image
 * @property mixed ach_title
 * @property mixed ach_desc
 * @property mixed stu_id
 * @property mixed ach_id
 */
class Achievement extends Model
{
    protected $table = 'achievements';
    public $primaryKey = 'ach_id';
    public $timestamps = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string stu_avatar
 * @property mixed stu_prov_id
 * @property mixed stu_full_name
 * @property mixed stu_bio
 * @property mixed stu_con_num
 * @property mixed stu_email
 * @property mixed deg_id
 * @property mixed sit_id
 * @property mixed stu_user_id
 */
class Student extends Model
{
    protected $table = 'students';
    public $primaryKey = 'stu_id';
    public $timestamps = true;
}

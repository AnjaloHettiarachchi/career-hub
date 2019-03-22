<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class StudentIdType extends Model
{
    protected $table = 'student_id_types';
    public $primaryKey = 'sit_id';
    public $timestamps = true;
}

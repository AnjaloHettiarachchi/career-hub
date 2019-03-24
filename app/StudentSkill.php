<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property mixed stu_id
 * @property mixed skill_id
 * @property mixed stu_skill_level
 */
class StudentSkill extends Model
{
    protected $table = 'student_skills';
    public $timestamps = true;

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('stu_id', '=', $this->getAttribute('stu_id'))
            ->where('skill_id', '=', $this->getAttribute('skill_id'));
        return $query;
    }
}

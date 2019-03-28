<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AchievementSkill extends Model
{
    protected $table = 'achievement_skills';
    public $timestamps = true;

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('ach_id', '=', $this->getAttribute('ach_id'))
            ->where('skill_id', '=', $this->getAttribute('skill_id'));
        return $query;
    }
}

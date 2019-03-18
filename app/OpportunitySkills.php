<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OpportunitySkills extends Model
{
    protected $table = 'opportunity_skills';
    public $timestamps = true;

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('op_id', '=', $this->getAttribute('op_id'))
            ->where('skill_id', '=', $this->getAttribute('skill_id'));
        return $query;
    }
}

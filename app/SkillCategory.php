<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    protected $table = 'skill_categories';
    public $primaryKey = 'skill_cat_id';
    public $timestamps = true;
}

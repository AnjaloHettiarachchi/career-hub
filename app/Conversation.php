<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';
    public $timestamps = true;

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('stu_id', '=', $this->getAttribute('stu_id'))
            ->where('com_id', '=', $this->getAttribute('com_id'));
        return $query;
    }
}

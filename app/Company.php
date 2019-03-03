<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    public $primaryKey = 'com_id';
    public $timestamps = true;
}

<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed admin_password
 */
class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    public $primaryKey = 'admin_id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_name', 'admin_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'admin_password', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->admin_password;
    }

}

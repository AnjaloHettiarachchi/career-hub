<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed com_user_password
 */
class CompanyUser extends Authenticatable
{

    use Notifiable;

    protected $table = 'company_users';
    public $primaryKey = 'com_user_id';
    public $timestamps = true;

    protected $fillable = [
        'com_user_name', 'com_user_password',
    ];

    protected $hidden = [
        'com_user_password', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->com_user_password;
    }

}

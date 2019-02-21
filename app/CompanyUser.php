<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed company_user_password
 */
class CompanyUser extends Authenticatable
{

    use Notifiable;

    //Table
    public $primaryKey = 'company_user_id';
    //Primary Key
    public $timestamps = true;
    //Timestamps
    protected $table = 'company_users';
    protected $fillable = [
        'company_user_name', 'company_user_password',
    ];

    protected $hidden = [
        'company_user_password', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->company_user_password;
    }

}

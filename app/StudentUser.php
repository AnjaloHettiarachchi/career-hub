<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed stu_user_id
 * @property mixed stu_user_name
 */
class StudentUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'student_users';
    public $primaryKey = 'stu_user_id';
    public $timestamps = true;

    protected $fillable = [
        'stu_user_name'
    ];

    protected $hidden = [
        'remember_token'
    ];

    public function getAuthIdentifier()
    {
        return $this->stu_user_id;
    }

}

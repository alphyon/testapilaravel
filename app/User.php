<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const USER_VERIFY = '1';
    const USER_NOT_VERIFY = '0';
    const USER_ADMINISTRATOR = 'true';
    const USER_NOT_ADMINISTRATOR = 'false';

  protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    public function isVerify()
    {
      return $this->verified == User::USER_VERIFY;
    }

    public function isAdministrator()
    {
      return $this->admin == User::USER_ADMINISTRATOR;
    }

    public static function generateVarificationToken()
    {
      return str_random(40);
    }
}

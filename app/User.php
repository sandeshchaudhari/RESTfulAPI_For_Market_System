<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    const VERIFIED_USER='1';
    const UNVERIFIED_USER="0";
    const ADMIN_USER="true";
    const REGULAR_USER="false";
    protected $table='users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',

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
    //Checking if user is admin
    public function isAdmin(){
        return $this->admin==User::ADMIN_USER;
    }
    //Checking if user is verified
    public function isVerified(){
        return $this->verified=User::VERIFIED_USER;
    }
    //generating verification code
    public static function generateVerificationCode(){
        return str_random(40);
    }

}
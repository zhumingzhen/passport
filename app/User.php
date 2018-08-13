<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $column = 'mobile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'mobile', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 通过 phone 查找没有在禁用状态下的用户：
    public function findForPassport($username)
    {
//        return \App\User::normal()
//            ->where('phone', $username)
//            ->first();
        return $this->where($this->column, $username)
            ->first();
    }

    public function username($column){
        $this->column = $column;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: zhumingzhen
 * Email: z@it.me
 * Date: 2018/8/8
 * Time: 11:35
 */

namespace App\Repositories;

use App\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create([
            'username' => $data['mobile'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
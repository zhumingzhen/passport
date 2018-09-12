<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvite extends Model
{
    protected $fillable = ['user_id', 'invite_id','activity','ip'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    protected $table = 'wechat';

    protected $fillable = ['user_id','unionld','openid','nickname','sex','language','city','province','country','avatar'];
}

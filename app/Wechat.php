<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    protected $fillable = ['user_id','openid','nickname','sex','language','city','province','country','avatar'];
}

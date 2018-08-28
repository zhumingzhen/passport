<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenterSexcDetail extends Model
{
    protected $appends = ['description'];

    protected $fillable = ['user_id', 'sexc', 'continuous', 'gain'];

    public function getDescriptionAttribute()
    {
        $description = "签到";
        return  $description;
    }

    public function getContinuousAttribute($value)
    {
        $continuous = "每日签到";
        if ($value == 2){
            $continuous = "连续签到7天";
        }
        return  $continuous;
    }
}

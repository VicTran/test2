<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calendar extends Model
{
    protected $fillable = [
    	'date','status','user_id','countweek'
    ];

    protected $dates = ['date'];


    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function timekeeipng()
    {
    	return $this->hasMany('App\timekeeipng');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class timekeeping extends Model
{
    protected $fillable = [
    	'status','description','user_id','calendar_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function calendar()
    {
        return $this->belongsTo('App\calendar');
    }


}

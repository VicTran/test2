<?php

namespace App;

use App\Http\AuthTraits\OwnsRecord;
use App\Traits\HasModelTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    use OwnsRecord;
    use HasModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phonenumber','verified','email_token','is_admin','status_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function verified()
    {
        $this->verified = 1;
        $this->email_token = null;
        $this->save();
    }

    public function profile()
    {
       return  $this->hasOne('App\Profile');
    }

    public function calendar()
    {
       return  $this->hasMany('App\calendar');
    }

    public function timekeeping()
    {
       return  $this->hasMany('App\timekeeping');
    }

    //admin 

    public function isAdmin()
    {
        return Auth::user()->is_admin == 1;
    }

    public function showAdminStatusOf($user)
    {
        return $user->is_admin ? 'Yes' : 'No';
    }

    public function isActiveStatus()
    {
        return Auth::user()->status_id == 1;
    }

    /**
     * @param $user
     * @param Request $request
     */
    public function updateUser($user, Request $request)
    {
        // dd($user->email);
        $user->update(['name'  => $request->name,
                        'is_admin' => $request->is_admin,
        ]);
    }

}

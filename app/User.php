<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function post(){//one to one relationship
      return $this->hasOne('App\Post'); //second parameter is user id in post table and third parameter is id of post table
    }//default user_id and id.

    public function posts(){
      return $this->hasMany('App\Post'); //one to many relationship
    }
    public function roles(){
      //    return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    return $this->belongsToMany('App\Role');
    }
}

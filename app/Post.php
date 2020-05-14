<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    //
    use SoftDeletes;
    protected $data=['deleted_at'];
    protected $fillable=[
      'title',
      'content'
    ];
    public function user(){
      return $this->belongsTo('App\User'); //one to one
    }
    public function photos(){
      return $this->morphMany('App\Photos', 'imageable');//Polymorphism one to Many
    }
    public function tags(){
      return $this->morphToMany('App\Tag', 'taggable');//Polymorphism many to many
    }
}

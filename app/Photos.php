<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    //
    protected $fillable=[
      'title',
      'content'
    ];
    public function imageable(){
      return $this->morphTo();//Polymorphism one to many
    }
}

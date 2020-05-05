<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    //
    public function imageable(){
      return $this->morphTo();
    }
}

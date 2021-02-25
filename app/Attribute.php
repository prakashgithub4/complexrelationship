<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    //
    public function categeryattribute(){
        return $this->belongsTo(Categoryattributes::class);
    }
   
}

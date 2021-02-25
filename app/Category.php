<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function category(){
        return $this->belongsTo(Product::class);
    }
    public function categoryattribute(){
        return $this->belongsTo(Categoryattributes::class,'category_id','id');
    }
  
   
}

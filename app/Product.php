<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function categories(){
        return $this->hasMany(Category::class,'id')->select(['id','name']);
    }
    public function categoryattribute(){
        return $this->belongsTo(Categoryattributes::class);
    }
    public function attribute(){
        return $this->hasMany(Categoryattributes::class,'category_id')->with('attributenames');
    }
    
}

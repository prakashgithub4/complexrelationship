<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoryattributes extends Model
{
    protected $table ="categoryattributes";
    public function category(){
        return $this->hasMany(Category::class,'id');
    }
    public function attributenames(){
        return $this->hasMany(Attribute::class,'id');
    }

}

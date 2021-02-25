<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    //
    public function productlist(){
        $products =Product::select('id','name')->with(['categories','attribute'])->get();
        return response()->json([$products]);
    }
}

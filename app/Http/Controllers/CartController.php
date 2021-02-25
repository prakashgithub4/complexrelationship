<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo "hello"; die;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        echo "hello"; die;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required',
            'device_token' => 'required',
           
           

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, "message" => "error", "error" => $validator->errors(), 'data' => []], 200);
        }
        $carts =Cart::where('product_id',$request->product_id)->where('user_id',$request->user_id)->first();
        if(empty($carts)){
           $addcat = new Cart();
           $addcat->product_id=$request->product_id;
           $addcat->quantity=$request->quantity;
           $addcat->user_id=$request->user_id;
           $addcat->device_token=$request->device_token;
           $addcat->save();
           return response()->json(['status' => true, "message" => "error", "error" =>[], 'data' =>$addcat], 200);
        }else{
            $carts->quantity=$request->quantity+1;
            $carts->save();
            return response()->json(['status' => true, "message" => "error", "error" =>[], 'data' =>$carts], 200);


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        echo "hello"; die;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        echo "hello"; die;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        echo "hello"; die;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        echo "hello"; die;

    }
}

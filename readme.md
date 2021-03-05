  public function productdetails(Request $request)
    {
        try {
            $result_array = array();
            $validator = Validator::make($request->all(), [
                //'page_no' => 'required',
                'product_id' => 'required'
            ]);
            if ($validator->fails()) {
                $errors = customerrors($validator->errors());
                return response()->json(['status' => false, 'error' => $errors, 'data' => [], "code" => 200], 200);
            }
            $iscart = 0;
            $iswishlist = 0;
            $istrusted = 0;
            $products = Product::select('products.id','products.user_id', 'products.name', 'products.colors', 'products.description', 'products.category_id', 'products.brand_id', 'products.photos', 'products.thumbnail_img', 'products.video_provider', 'products.video_link', 'products.tags', 'products.unit_price', 'products.purchase_price', 'attribute','products.choice_options','products.shipping_type','products.shipping_cost')
                ->where('id', '=', $request->product_id)
                ->first();
               if(!empty($products->id)){
                $sellerinfo =\App\User::select('users.name','sellers.id as seller_id','users.email')
                                      ->leftjoin('sellers','users.id','=','sellers.user_id')
                                      ->where('users.id',$products->user_id)
                                      ->first();
             
          
            $result_array['products'] = ['id' => $products->id, 'name' => $products->name, 'color' => json_decode($products->colors, JSON_UNESCAPED_SLASHES), 'category_id' => $products->category_id, 'barnd' => $products->brand_id, 'productImage' => empty($products->thumbnail_img) ? [] : [uploaded_asset($products->thumbnail_img)], 'video_provider' => $products->video_provider, 'video_link' => $products->video_link, 'price' => home_base_price($products->id), 'home_discounted_base_price' => home_discounted_base_price($products->id), 'isCart' => $products->isCart, 'isWishlist' => $products->iswishlist, 'istrusted' => $products->istrusted,'shipping_status'=>($products->shipping_cost ==0)?"free":$products->shipping_cost, 'rating' => 4.2, 'total_reviews' => 860];
            $checkspecification = Product::select('products.id', 'products.name', 'products.colors', 'products.description', 'products.category_id', 'products.brand_id', 'products.photos', 'products.thumbnail_img', 'products.video_provider', 'products.video_link', 'products.tags', 'products.unit_price', 'products.purchase_price', 'attribute')
                ->where('id', '=', $request->product_id)
                ->count();
            if ($checkspecification > 0) {
                $result_array['specification'] = Productattribute::select('*')
                    ->join('categoryspecifications', 'categoryspecifications.id', '=', 'productattributes.categoryspecification_id')
                    ->where('productattributes.product_id', $request->product_id)
                    ->get();
            } else {
                $result_array['specification'] = [];
            }

            $result_array['sellerinfo']=($sellerinfo->seller_id ==null )?[]:$sellerinfo;
           $item_array =[];
           $color_array =[];
          $verients = \App\ProductStock::select("product_stocks.id as stock_id",'product_stocks.color','product_stocks.color_name','product_stocks.product_id','product_stocks.variant','product_stocks.sku','product_stocks.price','product_stocks.qty','products.colors','products.choice_options')
                                  ->join('products','products.id','=','product_stocks.product_id')
                                  ->groupBy('products.choice_options')
                                  ->where('products.id',$request->product_id)->first();
                                 
          $result_array['verients']=[];
         
                $choose = json_decode($verients->choice_options);

     
                $dlt_array=array();
                $color_content = [];
                foreach($choose as $key=>$attrbuts){
                    $attribute = \App\Attribute::select('name','id')->where('id',$attrbuts->attribute_id)->first();
                  

                   foreach($attrbuts->values as $val)
                   {

                    $color_array=[
                        'title'=>$val,
                        'details'=>''
                    ];

                    array_push($dlt_array,$color_array);

                   }
                    
  
                    if(!empty($verients->color)){
                        $color_content=[
                            'name'=>$verients->color_name,
                            'color'=>$verients->color
                        ];
                        
                    }
                   
                    $item_array['attributes'][] = [
                        'verientName' => $attribute->name,
                        'verientValue' =>$dlt_array,
                        'colors'=>$color_content
                    ];
                  
                    $dlt_array=array();
                }
                

           // if(!empty($veri->variant)){
                $result_array['verients'][]=[
                    'stock_id'=>$verients->stock_id,
                    'product_id'=>$verients->product_id,
                    'variant'=>$verients->variant,
                    'sku'=>$verients->sku,
                    'price'=>$verients->price,
                    'attributes'=>(empty($item_array['attributes']))?[]:$item_array['attributes']
                    
                ];
           // }
            
          
         
         
       
          
            
            
            $result_array['related'] =  Product::select('id', 'name', 'thumbnail_img', 'category_id', 'colors')
                ->where('category_id', $products->category_id)
                ->where('id', '!=', $request->product_id)->get();
        
            return response()->json([
                "status" => true,
                'error' => [],
                'message' => 'product details fetch successfully',
                'data' =>  $result_array
            ]);
               }else{
                return response()->json([
                    "status" => false,
                    'error' => [],
                    'message' => 'product id not found',
                    'data' =>  []
                ]);
               }
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'error' => ['error'], 'message' => $ex->getMessage(), 'data' => []]);
        }
    }

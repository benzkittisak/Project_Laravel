<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductControllerAPI extends Controller
{
   public function product_list($category_id = null)
   {
       if($category_id){
           $products = Product::where('category_id' , $category_id)->get();
       }
       else {
           $products = Product::all();
       }
       
       return response()->json([
           'ok' => true,
           'products' => $products
       ]);
   }

   public function product_search(Request $request)
   {
       $search = $request->search;

       if($search){
            $products = Product::where('name','like','%'.$search.'%')->get();
       } else {
           $products = Product::all();
       }

       return response()->json([
        'ok' => true,
        'products' => $products
        ]); 

   }

}

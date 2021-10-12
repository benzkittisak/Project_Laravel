<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //
    public function viewCart()
    {
        
        $cart_items = Session::get('cart_items');
        if(!$cart_items){
            $cart_items = [];
        }
        return view('/cart/index' , compact('cart_items'));
    }

    public function addToCart($id)
    {
        $product = Product::find($id);
        $cart_items = Session::get('cart_items');
        if(is_null($cart_items)){
            $cart_items = [];
        }

        $qty = 0;
        if(array_key_exists($product->id , $cart_items)){
            $qty = $cart_items[$product->id]['qty'];
        }

        $cart_items[$product['id']] = [
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product->name,
            'price' => $product->price,
            'image_url' => $product->image_url,
            'qty' => $qty +1,
        ];

        Session::put('cart_items' , $cart_items);
        return redirect('cart/view');
    }

public function updateCart($id , $qty)
    {
        $cart_items = Session::get('cart_items');
        $cart_items[$id]['qty'] = $qty;
        Session::put('cart_items' , $cart_items);

        return redirect('cart/view');

    }

    public function deleteCart($id){
        $cart_items = Session::get('cart_items');
        unset($cart_items[$id]);
        Session::put('cart_items',$cart_items);
        return redirect('cart/view');
    }

    public function checkout()
    {
        $cart_items = Session::get('cart_items');
        return view('/cart/checkout',compact('cart_items'));
    }
    public function complete(Request $request)
    {
        $cart_items = Session::get('cart_items');
        $cust_name = $request->cust_name;
        $cust_email = $request->cust_email;
        $po_no = 'PO'.date('Ymd');
        $po_date = date('Y-m-d H:i:s');
        $amount = 0;

        foreach ($cart_items as $item) {
            $amount += $item['price'] * $item['qty'];
        }

        return view('/cart/complete' , compact('cart_items' , 'cust_name' , 'cust_email' , 'po_no' ,'po_date' ,'amount'));
    }
}

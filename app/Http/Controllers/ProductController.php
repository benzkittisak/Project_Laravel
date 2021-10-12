<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    // rp = result per page
    // result per page
    var $rpp = 10;
    //
    public function __constructrp() {
        $this->rpp = Config::get('app.result_per_page');
    }

    public function index()
    {
        $products = Product::paginate($this->rpp);
        return view('product/index' , compact('products'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        if($query){
            $products = Product::where('code','like','%'.$query.'%')
            ->orWhere('name' , 'like' , '%'.$query.'%')
            ->paginate($this->rpp);
        } else {
            $products = Product::paginate($this->rpp);
        }

        return view('product/index', compact('products'));
    }

    public function edit($id = null)
    {
       
        $categories = Category::pluck('name','id')->prepend('เลือกรายการ','');
        if($id){
            $product = Product::find($id);
            return view('product.edit')
            ->with('categories' , $categories)
            ->with('product' , $product);
        } else {
            return view('product/add')
            ->with('categories' , $categories);
        }
       
    }

    public function update(Request $request)
      {

          // กำหนดกฏการตรวจสอบ
        $rules = array(
            'code' => 'required',
            'name'=>'required',
            'category_id'=>'required|numeric',
            'price'=>'numeric',
            'stock_qty'=>'numeric'
        );
        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน',
            'numeric' => 'กรุณากรอกข้อมูล :attribute ให้เป็นตัวเลข'
        );
        $temp = array(
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock_qty' => $request->stock_qty,
        );

        // เอาไว้ใช้อ้างอิงว่าอันนี้มันสินค้าอันไหนนะอันนี้
        $id = $request->id;
        
        $validator = Validator::make($temp , $rules , $messages);

        if($validator -> fails()){
            return redirect('product/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
       
        // อันนี้จะเริ่มทำการบันทึกข้อมูลที่รับมาเข้าฐานแหละ
        $product = Product::find($id);
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock_qty = $request->stock_qty;

        if($request->hasFile('image')){
            $f = $request->file('image');
            $upload_to = 'upload/images';
            
            //get path
            $relative_path = $upload_to.'/'.$f->getClientOriginalName();
            $absolute_path = public_path().'/'.$upload_to;     
            
            //upload file
            $f->move($absolute_path,$f->getClientOriginalName());
            
            // resize image
            // Image::make(public_path().'/'.$relative_path)->resize(250,250)->save();
            $product->image_url = $relative_path;
        }
         $product->save();
 
        return redirect('product')
        ->with('ok',true)
        ->with('msg','บันทึกข้อมูลเรียบร้อยแล้ว');
      }

   public function insert(Request $request)
   {
        $rules = array(
            'code' => 'required',
            'name'=>'required',
            'category_id'=>'required|numeric',
            'price'=>'numeric',
            'stock_qty'=>'numeric'
        );
        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน',
            'numeric' => 'กรุณากรอกข้อมูล :attribute ให้เป็นตัวเลข'
        );
        $temp = array(
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock_qty' => $request->stock_qty,
        );

        // เอาไว้ใช้อ้างอิงว่าอันนี้มันสินค้าอันไหนนะอันนี้
        $id = $request->id;
        
        $validator = Validator::make($temp , $rules , $messages);

        if($validator -> fails()){
            return redirect('product/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }

        $product = new Product();
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock_qty = $request->stock_qty;

        if($request->hasFile('image')){
            $f = $request->file('image');
            $upload_to = 'upload/images';
            
            //get path
            $relative_path = $upload_to.'/'.$f->getClientOriginalName();
            $absolute_path = public_path().'/'.$upload_to;     
            
            //upload file
            $f->move($absolute_path,$f->getClientOriginalName());
            
            // resize image
            // Image::make(public_path().'/'.$relative_path)->resize(250,250)->save();
            $product->image_url = $relative_path;
        
        }
       
       $product->save();
       
       return redirect('product')
       ->with('ok',true)
       ->with('msg','เพิ่มข้อมูลสำเร็จ');
   }

   public function remove($id)
   {
       Product::find($id)->delete();
       return redirect('product')
       ->with('ok',true)
       ->with('msg','ลบข้อมูลสำเร็จ');
   }
     
}

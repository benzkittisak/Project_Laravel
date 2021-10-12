<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    var $rpp = 10;
    //
    public function index()
    {
        $categories = Category::all();
        return view('category/index' , compact('categories'));
    }

   
    public function edit($id = null)
    {
        if($id){
            $category = Category::find($id);
            return view('category/edit')
            ->with('category' , $category);
        } else {
            return view('category/add');
        }
       
    }

    public function update(Request $request)
      {

        $id = $request->id;

        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return redirect('category')
        ->with('ok',true)
        ->with('msg','บันทึกข้อมูลเรียบร้อยแล้ว');
      }

   public function insert(Request $request)
   {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
       return redirect('category')
       ->with('ok',true)
       ->with('msg','เพิ่มข้อมูลสำเร็จ');
   }

   public function remove($id)
   {
        Category::find($id)->delete();
        return redirect('category')
        ->with('ok',true)
        ->with('msg','ลบข้อมูลสำเร็จ');
   }
}

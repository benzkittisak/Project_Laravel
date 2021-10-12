<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryControllerAPI extends Controller
{
    //
    public function categories_list()
    {
        $categories = Category::all();
        return response()->json([
            'ok' => true,
            'categories' => $categories
        ]);
    }
}

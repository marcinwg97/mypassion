<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        return response()->json(Category::with('children')->where('parent_id', NULL)->get()->toArray());
    }
    public function details($id, $name) {
        return response()->json(Category::where('id', $id)->where('name', $name)->first()->toArray());
    }


}

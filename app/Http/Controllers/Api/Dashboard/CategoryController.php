<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return response()->json(Category::paginate(6)->toArray());

    }
    public function edit($id) {
        return response()->json(Category::where('id', $id)->first()->toArray());
    }

    public function getAllPostsByCategory($id) {
        return response()->json(Post::where('category_id', $id)->with('category')->orderBy('date', 'desc')->get()->toArray());
    }

    public function update(Request $request, $id) {
        $category = Category::where('id', $id)->first();
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'message' => 'Kategoria została wyedytowana.'
        ]);
    }

    public function store(Request $request) {
        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'message' => 'Nowa kategoria została stworzona.'
        ]);
    }

    public function destroy($id) {
        $category = Category::where('id', $id)->first();
        $category->delete();
        $posts = Post::where('category_id', $id)->get();
        foreach($posts as $post) {
            $post->delete();
        }

        return response()->json([
            'message' => 'Kategoria została usunięta.'
        ]);
    }

    }

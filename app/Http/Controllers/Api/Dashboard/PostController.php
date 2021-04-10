<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Auth;
class PostController extends Controller
{
    public function index() {
        return response()->json(Post::with(['category', 'user'])->where('user_id', Auth::user()->id)->paginate(5)->toArray());
    }

    public function edit($id) {
        return response()->json(Post::where('id', $id)->first()->toArray());
    }

    public function update(Request $request, $id) {
        $post = Post::where('id', $id)->first();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->description_short = $request->description_short;
        $post->seo_keywords = $request->seo_keywords;
        $post->is_active = $request->is_active == true ? 1 : 0;
        $post->save();

        return response()->json([
            'message' => 'Post został zaktualizowany'
        ]);
    }

        public function store(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->date = date('Y-m-d');
        $post->description = $request->description;
        $post->description_short = $request->description_short;
        $post->seo_keywords = $request->seo_keywords;
        $post->is_active = 1;
        $post->user_id = Auth::user()->id;
        $post->category_id = $request->category_id;
        $post->save();

        return response()->json([
            'message' => 'Nowy post został dodany'
        ]);
    }

    public function destroy($id) {
        $post = Post::where('id', $id)->first();
        $post->delete();

        return response()->json([
            'message' => 'Post został usunięy'
        ]);
    }
}

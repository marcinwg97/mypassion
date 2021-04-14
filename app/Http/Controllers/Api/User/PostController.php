<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use DB;
use App\Models\User;
use App\Models\PostFavorite;
use App\Models\UserFavorite;
use Auth;

class PostController extends Controller
{
    public function getPostsFavorite() {
        $posts = PostFavorite::where('user_id', Auth::user()->id)->get();
        $p = array();
        foreach($posts as $post) {
            $p[] = $post->id;
        }
        return response()->json(Post::whereIn('id', $p)->with('user')->paginate(5)->toArray());
    }
    
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

    public function destroy($id) {
        $post = Post::where('id', $id)->first();
        $post->delete();

        return response()->json([
            'message' => 'Post został usunięy'
        ]);
    }
}

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
}

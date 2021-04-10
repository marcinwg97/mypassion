<?php

namespace App\Http\Controllers\Api;

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
    public function index($id) {
        return response()->json(Post::where('category_id', $id)->with(['category', 'user'])->orderBy('id', 'desc')->paginate(5)->toArray());
    }
    public function getPostOnMainPage() {
        $users = UserFavorite::where('user_id', Auth::user()->id)->get();
        $u = array();
        foreach($users as $user) {
            $u[] = $user->favorite_user_id;
        }
        return response()->json(Post::whereIn('user_id', $u)->with(['category', 'user'])->orderBy('id', 'desc')->paginate(5)->toArray());
    }
    public function details(Request $request) {
        return response()->json(Post::where('id', $request->id)->where('title', $request->title)->first()->toArray());
    }
    public function addPostToFavorite(Request $request) {

        $post_favorite = new PostFavorite;
        $post_favorite->post_id = $request->post_id;
        $post_favorite->user_id = Auth::user()->id;
        $post_favorite->save();

        return response()->json([
            'message' => 'Polubiłeś dany post'
        ]);
    }

    public function VerifyPostFavorite($id) {
        $post_favorite = PostFavorite::where('post_id', $id)->where('user_id', Auth::user()->id)->first();
        if($post_favorite) {
            return 1; 
        }
    }

    public function removePostFromFavorite(Request $request) {
        $post_favorite = PostFavorite::where('post_id', $request->post_id)->where('user_id', Auth::user()->id)->first();
        $post_favorite->delete(); 

        return 1; 
    }
}

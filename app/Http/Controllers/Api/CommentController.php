<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use DB;
use App\Models\PostComment;
use Auth;

class CommentController extends Controller
{
    public function index($id) {
        return response()->json(PostComment::where('post_id', $id)->with('user')->get()->toArray());
    }
    public function store(Request $request) {

        $post_comment = new PostComment;
        $post_comment->contents = $request->contents;
        $post_comment->post_id = $request->post_id;
        $post_comment->user_id = Auth::user()->id;
        $post_comment->date = new \DateTime();
        $post_comment->save();

        return response()->json([
            'message' => 'Dodałeś nowy komentarz'
        ]);
    }

    public function deleteComment($id) {
        $post_comment = PostComment::where('id', $id)->first(); 
        $post_comment->delete(); 

        return response()->json([
            'message' => 'Komentarz został usunięty'
        ]);
    }

}

<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use DB;

class UserController extends Controller
{
    public function getDetails() {
        return response()->json(['success' => Auth::user()]);
    }

    public function details($id) {
        return response()->json(User::where('id', $id)->first()->toArray());
    }

    public function postsByUser($id) {
        return response()->json(Post::where('user_id', $id)->with(['category', 'user'])->get()->toArray());
    }
}


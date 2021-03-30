<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\UserFavorite;
use DB;
use Auth;

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

    public function addUserToFavorite(Request $request) {

        $user_favorite = new UserFavorite;
        $user_favorite->favorite_user_id = $request->favorite_user_id;
        $user_favorite->user_id = Auth::user()->id;
        $user_favorite->save();

        return response()->json([
            'message' => 'Polubiłeś danego użytkownika'
        ]);
    }

    public function VerifyUserFavorite($id) {
        $user_favorite = UserFavorite::where('favorite_user_id', $id)->where('user_id', Auth::user()->id)->first();
        if($user_favorite) {
            return 1; 
        }
    }

    public function removeUserFromFavorite(Request $request) {
        $user_favorite = UserFavorite::where('favorite_user_id', $request->favorite_user_id)->where('user_id', Auth::user()->id)->first();
        $user_favorite->delete(); 

        return 1; 
    }
}


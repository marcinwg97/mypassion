<?php
namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\UserFavorite;
use DB;
use Auth;

class UserController extends Controller
{
    public function index() {
        return response()->json(User::where('id', Auth::user()->id)->first()->toArray());
    }
    public function update(Request $request) {
        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $request->name;
        $user->biography = $request->biography;
      //  $user->profile_img = $request->profile_img;
        $user->facebook_link = $request->facebook_link; 
        $user->instagram_link  = $request->instagram_link;
        $user->twitter_link  = $request->twitter_link;
        $user->save();

        return response()->json([
            'message' => 'Dane zostały zaktualizowane'
        ]);
    }
    public function getUsersFavorite() {
        $users = UserFavorite::where('user_id', Auth::user()->id)->get();
        $u = array();
        foreach($users as $user) {
            $u[] = $user->id;
        }
        return response()->json(User::whereIn('id', $u)->paginate(5)->toArray());
    }
}


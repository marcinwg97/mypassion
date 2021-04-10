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
    public function getUsersFavorite() {
        $users = UserFavorite::where('user_id', Auth::user()->id)->get();
        $u = array();
        foreach($users as $user) {
            $u[] = $user->id;
        }
        return response()->json(User::whereIn('id', $u)->paginate(5)->toArray());
    }
}


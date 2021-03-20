<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getDetails() {
        return response()->json(['success' => Auth::user()]);
    }

    public function index() {
        return response()->json(User::paginate(5)->toArray());
    }

    /*  public function listWithoutPagination() {
        return response()->json(User::get()->toArray());
    } */

    public function details($id) {
        return response()->json(User::where('id', $id)->first()->toArray());
    }

    public function update(Request $request, $id) {
        $user = User::where('id', $id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Użytkownik został wyedytowany.'
        ]);
    }

    public function store(Request $request) {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Nowy użytkownik został stworzony.'
        ]);
    }

    public function destroy($id) {
        $user = User::where('id', $id)->first();
        $user->delete();

        return response()->json([
            'message' => 'Użytkownik został usunięty.'
        ]);
    }
}

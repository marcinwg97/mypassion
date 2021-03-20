<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class FormContactController extends Controller
{
    public function index() {
        return response()->json(Message::paginate(6)->toArray());
    }

    public function details($id) {
        return response()->json(Message::where('id', $id)->first()->toArray());
    }

    public function update(Request $request, $id) {
        $message = Message::where('id', $id)->first();
        $message->email = $request->email;
        $message->title = $request->title;
        $message->contents = $request->contents;
        $message->save();

        return response()->json([
            'message' => 'Wiadomość została wyedytowana'
        ]);
    }

    public function destroy($id) {
        $message = Message::where('id', $id)->first();
        $message->delete();

        return response()->json([
            'message' => 'Wiadomość została usunięta'
        ]);
    }
}

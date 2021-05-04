<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Auth;

class ChatController extends Controller
{
    public function messages()
    {
    return response()->json(Message::get()->toArray()); 
    }

    public function send_message(Request $request)
    {
        $email = Auth::user()->email;
        $message = new Message;
        $message->contents = $request->contents;
        $message->email = $email;

        $message->save();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use Auth;

class ChatOneToOneController extends Controller
{
    public function index()
    {
        return response()->json(User::where('id','!=', auth()->id())->get()->toArray()); 
    }

    public function send_message(Request $request)
    {
        $message = $request->message;
        $to_user = $request->to_user;

        $chat = new Chat;
        $chat->message=$message;
        $chat->from_user=auth()->id();
        $chat->to_user=$to_user;
        $chat->status = 1;

        $chat->save();
    }

    public function show_messages(Request $request)
    {
        $from_user = $request->from_user;
        return response()->json(Chat::where('from_user', '=', $from_user)->where('to_user', '=', auth()->id())->get()->toArray());

    }

    public function show_sent_messages(Request $request)
    {
        $from_user = $request->from_user;
        return response()->json(Chat::where('from_user', '=', auth()->id())->where('to_user', '=', $from_user)->get()->toArray());
    }

    public function count_messages()
    {
        return response()->json(Chat::where('status', '=', 1)->get()->toArray());
    }

    public function unread_messages(Request $request)
    {
        $to_user = $request->to_user;

        return response()->json(Chat::where('from_user', '=', $to_user)->update(['status'=>0])->get()->toArray());
    }
}

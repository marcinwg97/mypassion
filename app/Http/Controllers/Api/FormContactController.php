<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Mail;
use App\Mail\FormContact;

class FormContactController extends Controller
{
    public function store(Request $request) {
        $message = new Message;
        $message->email = $request->email;
        $message->title = $request->title;
        $message->contents = $request->contents;
        $message->save();

        try {
            Mail::to(env('MAIL_USERNAME'))->send(new FormContact($message));
        } catch (Exception $e) { }

        return response()->json([
            'message' => 'Wiadomość została wysłana'
        ]);
    }
}

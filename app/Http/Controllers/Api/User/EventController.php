<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventMember;
use Auth;
class EventController extends Controller
{

    public function getEventWhereMember() {
        $users = EventMember::where('user_id', Auth::user()->id)->get();
        $u = array();
        foreach($users as $user) {
            $u[] = $user->event_id;
        }
        return response()->json(Event::with(['category', 'user'])->whereIn('id', $e)->paginate(5)->toArray());
    }

    public function deleteEventWhereMember($id) {
        $event_member = EventMember::where('id', $id)->first();
        $event_member->delete();

        return response()->json([
            'message' => 'Wydarzenie zostało usunięte'
        ]);
    }
}

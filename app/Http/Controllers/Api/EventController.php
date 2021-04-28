<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventMember;
use DB;
use App\Models\User;
use Auth;

class EventController extends Controller
{
    public function index($id) {
        return response()->json(Event::where('category_id', $id)->with(['category', 'user'])->paginate(10)->toArray());
    }

    public function events() {
        return response()->json(Event::with(['category', 'user'])->paginate(10)->toArray());
    }

    public function details(Request $request) {
        return response()->json(Event::where('id', $request->id)->where('title', $request->title)->first()->toArray());
    }

    public function addUserToEvent(Request $request) {

        $event_user = new EventMember;
        $event_user->event_id = $request->event_id;
        $event_user->user_id = Auth::user()->id;
        $event_user->save();

        return response()->json([
            'message' => 'Zostałeś dodany do wydarzenia'
        ]);
    }

    public function addEvent(Request $request) {

        $event = new Event;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->user_id = Auth::user()->id;
        $event->category_id = $request->category_id;
        $event->save();

        return response()->json([
            'message' => 'Dodano nowe wydarzenie'
        ]);
    }

    public function VerifyUserInEvent($id) {
        $event_user = EventMember::where('event_id', $id)->where('user_id', Auth::user()->id)->first();
        if($event_user) {
            return 1;
        }
    }

    public function removeUserFromEvent(Request $request) {
        $event_user = EventMember::where('event_id', $request->event_id)->where('user_id', Auth::user()->id)->first();
        $event_user->delete();

        return 1;
    }
}

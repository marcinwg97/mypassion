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
        return response()->json(Event::with(['category', 'user'])->whereIn('id', $u)->paginate(5)->toArray());
    }

    public function deleteEventWhereMember($id) {
        $event_member = EventMember::where('id', $id)->first();
        $event_member->delete();

        return response()->json([
            'message' => 'Wydarzenie zostało usunięte'
        ]);
    }

    public function index() {
        return response()->json(Event::with(['category', 'user'])->where('user_id', Auth::user()->id)->paginate(5)->toArray());
    }

    public function edit($id) {
        return response()->json(Event::where('id', $id)->first()->toArray());
    }

    public function update(Request $request, $id) {
        $event = Event::where('id', $id)->first();
        $event->title = $request->title;
        $event->date = $request->date;
        $event->description = $request->description;
        $event->place = $request->place;
        $event->save();

        return response()->json([
            'message' => 'Wydarzenie zostało zaktualizowane'
        ]);
    }

    public function destroy($id) {
        $post = Event::where('id', $id)->first();
        $post->delete();

        return response()->json([
            'message' => 'Wydarzenie zostało usunięte'
        ]);
    }
}

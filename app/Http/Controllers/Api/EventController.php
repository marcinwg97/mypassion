<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use DB;
use App\Models\User;
use Auth;

class EventController extends Controller
{
    public function index($id) {
        return response()->json(Event::where('category_id', $id)->with(['category', 'user'])->paginate(5)->toArray());
    }
    public function details(Request $request) {
        return response()->json(Event::where('id', $request->id)->where('title', $request->title)->first()->toArray());
    }
}

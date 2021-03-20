<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StaticSite;

class StaticSiteController extends Controller
{
    public function index() {
        return response()->json(StaticSite::get()->toArray());
    }

    public function details($id) {
        return response()->json(StaticSite::where('id', $id)->first()->toArray());
    }

    public function mission() {
        return response()->json(StaticSite::where('name', 'Misja')->first()->toArray());
    }
    public function aboutUs() {
        return response()->json(StaticSite::where('name', 'O nas')->first()->toArray());
    }

}

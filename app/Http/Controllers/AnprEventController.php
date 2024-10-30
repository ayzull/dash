<?php

namespace App\Http\Controllers;

use App\Models\AnprEvent;
use Illuminate\Http\Request;

class AnprEventController extends Controller
{
    public function index(Request $request)
    {
        $events = AnprEvent::orderBy('event_time', 'desc')->paginate(2);
        return view('cctv/stream', compact('events'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\UserEvent;

class EventController extends Controller
{
    public function index()
    {
    	$events=Event::orderBy('created_at','desc')->paginate(10);
    	return view('event.index',compact('events'));
    }

    public function markAsRead()
    {
    	$event_id=request('event_id');

    	UserEvent::where('user_id',auth()->id())->where('event_id',$event_id)
    	->delete();
    	return response()->json(['message'=>'deleted'],200);
    }

    public function allAsRead()
    {
    	UserEvent::where('user_id',auth()->id())->delete();
    	return back();
    }
}

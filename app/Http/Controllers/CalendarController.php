<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
class CalendarController extends Controller
{
	public function index()
    {
        $tasks = Task::orderBy('created_at','DESC')->get();

    	return view('layout.calendar',compact('tasks'));
    }

}
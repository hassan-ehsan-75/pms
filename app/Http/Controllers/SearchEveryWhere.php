<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Project;
use App\News;
use App\Discussion;
use App\DiscussionComment;
use App\Task;
use App\ToDo;
use App\Announcement;
use App\Job;

class SearchEveryWhere extends Controller
{
	public function search()
	{
		$search_query=request('search_query');
		
		if(empty($search_query))
			return back();

		$projects=Project::where('title','LIKE','%'.$search_query.'%')
		->orWhere('description','LIKE','%'.$search_query.'%')->limit(5)->get();

		$useres=User::where('user_name','LIKE','%'.$search_query.'%')
		->orWhere('skills','LIKE','%'.$search_query.'%')
		->orWhere('about','LIKE','%'.$search_query.'%')
		->orWhere('location','LIKE','%'.$search_query.'%')
		->limit(5)->get();

		$tasks=Task::where('content','LIKE','%'.$search_query.'%')->limit(5)
		->get();

		$todos=ToDo::where('description','LIKE','%'.$search_query.'%')->limit(5)
		->get();

		$news=News::where('title','LIKE','%'.$search_query.'%')
		->orWhere('content','LIKE','%'.$search_query.'%')
		->limit(5)->get();

		$discussions=Discussion::where('title','LIKE','%'.$search_query.'%')
		->orWhere('content','LIKE','%'.$search_query.'%')
		->limit(5)->get();

		return view('layout.search',compact('projects','useres','tasks','todos','news','discussions'))->with('search_query',$search_query);
	}
}
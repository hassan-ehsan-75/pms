<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Title;
class TitleController extends Controller
{
	public function create()
	{
		return view('title.create');
	}
	public function store()
	{
		$this->validate(request(),[
			'title_name'=>'required'
		]);
		Title::create([
			'title_name'=>request('title_name')
			]);
		session()->flash('message','title created successfully');

		return redirect()->route('title.index');
	}


	public function edit($id)
	{
		$title=Title::find($id);
		return view('title.edit',compact('title'));
	}

	public function update($id)
	{
		$this->validate(request(),[
			'title_name'=>'required'
		]);
		Title::find($id)->update(['title_name'=>request('title_name')]);
		session()->flash('message','title updated succssefully');
		return redirect()->route('title.index');
	}

	public function index()
	{
		$titles=Title::orderBy('created_at','desc')->paginate(10);
		return view('title.index',compact('titles'));
	}

	public function delete($id)
	{
		Title::find($id)->delete();
		session()->flash('message','title deleted successfully');
		return back();
	}
}

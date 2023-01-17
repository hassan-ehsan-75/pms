<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Announcement;
use \App\Discussion;

use App\Event;
use App\UserEvent;
use App\User;
class AnnouncementController extends Controller
{
    public function show($id)
    {
         if(!Announcement::find($id)){
            abort(404);
        }
        $announcement = Announcement::find($id);
        $discussions = Discussion::all()->where('type','announcement')->where('link_id',$id);
        return view('announcement.show',compact(['announcement','discussions']));
    }
    public function index()
    {
        $announcements=Announcement::orderBy('created_at','desc')->paginate(10);
        return view('announcement.index',compact('announcements'));	
    }
    public function create()
    {
    	return view('announcement.create');
    }
    public function store()
    {

        $this->validate(request(),[
            'title'=>'required',
            'content'=>'required']);

    	$announcement=Announcement::create([
            'user_id'=>auth()->id(),
            'title'=>request('title'), 
            'content'=>request('content')
            ]);
        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created',
            'content_type'=>'Announcement',
            'title'=> request('title'), 
            'link_id'=>'announcement/show/'.$announcement->id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    

        }
     session()->flash('message','Announcement created successfully');
        return redirect()->route('announcement.index');

    }
     public function edit($id)
    {
        if(!Announcement::find($id)){
            abort(404);
        }
        $announcement=Announcement::find($id);
        return view('announcement.edit',compact('announcement'));
    }
    public function update($id)
    {   
        if(!Announcement::find($id)){
            abort(404);
        }
        $this->validate(request(),[
            'title'=>'required',
            'content'=>'required'
        ]);
        Announcement::find($id)->update([
            'title'=>request('title'), 
            'content'=>request('content')
        ]);
        session()->flash('message','Announcement updated successfully');
        return redirect()->route('announcement.index');
    }
    public function delete($id)
    {
        if(!Announcement::find($id)){
            abort(404);
        }
        Announcement::find($id)->delete();
        Discussion::where('type','announcement')->where('link_id',$id)->delete();
        session()->flash('message','announcement deleted successfully');
        return back();
    }

     public function discuss($id){

        $type = 'announcement';
        $link_id = $id; 
        return view('discussion.create',compact(['type','link_id']));

    }

}

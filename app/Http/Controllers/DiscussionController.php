<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Session;
use App\Discussion;
use App\DiscussionComment;
use App\User;
use App\Event;
use App\UserEvent;

class DiscussionController extends Controller
{
    public function index()
    {
        $discussions = Discussion::orderBy('created_at','DESC')->paginate(10);

    	return view('discussion.index',compact('discussions'));
    }

    public function listDiscussions($type,$id)
    {

      $discussions = Discussion::where('type',$type)->where('link_id',$id)->orderBy('created_at','DESC')->get();

    return view('discussion.index',compact('discussions'));
    }
    public function create()
    {
        $link_id = Session()->get( 'link_id' );
        $type =  Session()->get( 'type' );
    	return view('discussion.create',compact('link_id','type'));
    }
    public function store()
    {

        $this->validate(request(),[
            'title'=>'required',
            'content'=>'required|max:2024',
            'type'=>'required',
            'link_id'=>'required'
        ]);

        $discussion = Discussion::create([
        'user_id'=>auth()->user()->id,
        'title'=>request('title'),
        'content'=>request('content'),
        'type'=>request('type'),
        'link_id'=>request('link_id')
            ]);
        $title=substr($discussion->title,0,20);
        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created',
            'content_type'=>'Discussion',
            'title'=> $title, 
            'link_id'=>'discussion/show/'.$discussion->id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    

        }
        return redirect()->route(request('type').'.show',request('link_id'));
    }

    public function delete($id){
        if(!Discussion::find($id)){
            abort(404);
        }

        $discussion= Discussion::find($id);
        $type = $discussion->type;
        $link_id= $discussion->link_id;
        $comments = DiscussionComment::where('discussion_id',$id);
        foreach ($comments as $comment) {
            $comment->delete();
        }
        $discussion->delete();

        session()->flash('message','discussion deleted successfully');

        return redirect()->route($type.'.show',$link_id);
    }

    public function edit($id){
        if(!Discussion::find($id)){
            abort(404);
        }

        $discussion = Discussion::find($id);
        $link_id = $discussion->link_id;
        $type = $discussion->type;
            
        if(!($discussion->user_id ==auth()->user()->id || auth()->user()->hasPermission('Admin')|| auth()->user()->hasPermission('Manger')))
            abort(403);

        return view('discussion.edit',compact('discussion','link_id','type'));
    }

    public function update($id){
        if(!Discussion::find($id)){
            abort(404);
        }
        $discussion = Discussion::find($id);

        if(($discussion->user==auth()->user()))
            abort(403);

        $this->validate(request(),[
           'title'=>'required',
            'content'=>'required',
            'type'=>'required',
            'link_id'=>'required'
            ]);

        $discussion->title = request('title');
        $discussion->content  = request('content');
        $discussion->save();

        $title=substr($discussion->title,0,20);
        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'updated ',
            'content_type'=>'Discussion',
            'title'=> $title, 
            'link_id'=>'discussion/show/'.$discussion->id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);
        }    
        session()->flash('message','discussion edited successfully');

        return redirect()->route('discussion.show',$id);

    }

    public function show($id){
            if(!Discussion::find($id)){
            abort(404);
        }

        $discussion = Discussion::find($id);
        $comments = DiscussionComment::all()->where('discussion_id',$id);


        return view('discussion.show',compact(['discussion','comments']));

    }
}

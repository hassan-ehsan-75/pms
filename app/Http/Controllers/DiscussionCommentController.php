<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DiscussionComment;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Event;
use App\UserEvent;

class DiscussionCommentController extends Controller
{
    //
    public function index()
    {
    	//
    }
    public function create()
    {
    	//
    }
    public function store()
    {

    	$this->validate(request(),[
            'content' => 'required|max:255'
            ]);

         $comment = DiscussionComment::create([
            'user_id'=>auth()->id(),
            'content' =>Input::get('content'),
            'discussion_id' => Input::get('discussion_id')
            ]);
         $title=substr($comment->content,0,20).'...';
         //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'commented ',
            'content_type'=>'Discussion',
            'title'=> $title, 
            'link_id'=>'discussion/show/'.$comment->discussion_id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    

        }
        return redirect()->back();
    }
    public function delete($id){
        $comment = DiscussionComment::find($id);
        $comment->delete();
        return redirect()->back();
    }

    public function update($id){

        $this->validate(request(),[
            'content' => 'required|max:255'
            ]);

        $comment=DiscussionComment::find($id)->update([
            'content' => request('content')

            ]);

        $title=substr($comment,0,20);
        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'updated a comment ',
            'content_type'=>'Discussion',
            'title'=> $title, 
            'link_id'=>'discussion/show/'.$comment->discussion_id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    

        }
        return redirect()->back();

    }

}

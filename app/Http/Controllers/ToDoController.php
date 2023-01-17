<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ToDo;
use App\Task;
use \App\Discussion;
use App\User;
use App\Event;
use App\UserEvent;

class ToDoController extends Controller
{

	 public function __constructor()
    {
        $this->middleware('user');
    }

    public function index($id)
    {
        if($id == 'all'){
        $schedueltodos = ToDo::orderBy('created_at','desc')->paginate(10);
        return view('todo.index',compact('schedueltodos'));
        }elseif(ToDo::all()->where('task_id',$id)->count() != 0) {
        $schedueltodos = ToDo::where('task_id',$id)
        ->orderBy('created_at','desc')->paginate(10);
    	return view('todo.index',compact('schedueltodos'));
        }elseif($id == 'user_todo') {
        $schedueltodos = ToDo::where('assigned_to',auth()->user()->id)
        ->orderBy('created_at','desc')->paginate(10);
        return view('todo.index',compact('schedueltodos'));
        }else abort(404);
    }
    public function create($id)
    {   
        if(!Task::find($id)){
            abort(404);
        }

        $task_id = $id;
    	return view('todo.create',compact('task_id'));
    }
    public function store($task_id)
    
    {
    	$this->validate(request(),[
            'description' =>'required',
            'status'=>'required',
            'assigned_to' =>'required'
            ]);

    		$todo=ToDo::create([
    			'user_id'=>auth()->id(),
                'task_id'=>$task_id,
    			'description'=>request('description'),
				'status'=>request('status'),
    			'assigned_to' =>request('assigned_to'),

    			
    			]);
            $task_title=substr(Task::find($task_id)->content,0,10).'...';
            
             $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created',
            'content_type'=>'task',
            'title' => 'on task '.$task_title,
            'link_id'=> 'todo/show/'.$todo->id
                    ]);
        //broadcast the event
        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
            //here we creaet an event for each user in the db
            //don't woory this will be deleted as soon as they are seen
            UserEvent::create([
                'user_id'=>$user->id,
                'event_id'=>$event->id
            ]);
            //and that's it :)
        }

    		 session()->flash('message','TODO created successfully');
		
    		return redirect()->route('task.show',$task_id);

    }

    public function edit($id){
          if(!ToDo::find($id)){
            abort(404);
        }
    	$todo = ToDo::find($id);
    	return view('todo.edit',compact('todo'));
    }
    public function update($id){

         if(!ToDo::find($id)){
            abort(404);
        }
    	  $this->validate(request(),[
            'description'=>'required',
            'status'=>'required',
            'assigned_to' =>'required'
        ]);



    	$todo=ToDo::find($id);
    	$todo->status=request('status');
    	$todo->description=request('description');
    	$todo->assigned_to=request('assigned_to');
        $todo->updated_by = auth()->user()->full_name;
    	$todo->save();

        $event_title=substr($todo->description,0,20).'...';
           $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'updated',
            'content_type'=>'todo',
            'title' => $event_title,
            'link_id'=> 'todo/show/'.$todo->id
                    ]);
        //broadcast the event
        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
            //here we creaet an event for each user in the db
            //don't woory this will be deleted as soon as they are seen
            UserEvent::create([
                'user_id'=>$user->id,
                'event_id'=>$event->id
            ]);
            //and that's it :)
        }
    	session()->flash('message','TODO edited successfully');

    	return redirect()->route('todo.show',$id);
    }

      public function delete($id)
    {
          if(!ToDo::find($id)){
            abort(404);
        }
    	$todo=ToDo::find($id);
        $discussions = Discussion::where('type','todo')->where('link_id',$id)->get(); 
        foreach ($discussions as $discussion) {
              $comments =DiscussionComment::where('discussion_id',$discussion->id)->delete();
        }
     
   
        $discussions = Discussion::where('type','todo')->where('link_id',$id)->delete();
    	$task_id = $todo->task->id ;

        $event_title=substr($todo->description,0,10).'...';
           $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'delted',
            'content_type'=>'todo',
            'title' => $event_title,
            'link_id'=> 'task/show/'.$task_id
                    ]);
        //broadcast the event
        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
            //here we creaet an event for each user in the db
            //don't woory this will be deleted as soon as they are seen
            UserEvent::create([
                'user_id'=>$user->id,
                'event_id'=>$event->id
            ]);
            //and that's it :)
        }
    	$todo->delete();

    	session()->flash('message','todo deleted successfully');
    	
    	return redirect()->route('todo.index',$task_id);
    }

    public function show($id){
         if(!ToDo::find($id)){
            abort(404);
        }

        $todo=ToDo::find($id);
        $discussions = Discussion::where('link_id',$id)->where('type','todo')->orderBy('created_at','desc')->get();
        return view('todo.show',compact(['todo','discussions']));

    }

    public function discuss($id){

        $type = 'todo';
        $link_id = $id; 
        return view('discussion.create',compact(['type','link_id']));

    }

    public function apiChangeStatus()
    {
        $todo_id=request('todo_id');
        $status=request('status');
        $todo=ToDo::find($todo_id);
        if(!empty($todo))
        {
             $todo->status=$status;
             $todo->updated_by = auth()->user()->full_name;

             $todo->save(); 
             $event_title=substr($todo->description,0,20).'...';
           $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'updated',
            'content_type'=>'todo',
            'title' => $event_title,
            'link_id'=> 'todo/show/'.$todo->id
                    ]);
        //broadcast the event
        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
            //here we creaet an event for each user in the db
            //don't woory this will be deleted as soon as they are seen
            UserEvent::create([
                'user_id'=>$user->id,
                'event_id'=>$event->id
            ]);
            //and that's it :)
        }

             return response()->json(['message'=>'updated'],200);
        }
        else

        {
            return response()->json(['message'=>'failed'],200);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Discussion;
use App\Project;
use App\DiscussionComment;
use \App\ToDo;
use App\Event;
use App\UserEvent;
use App\User;

class TaskController extends Controller
{
     public function create($id)
    {
        if(!Project::find($id)){
            abort(404);
        }
        $project_id = $id;
        return view('task.create',compact('project_id'));
    }
    public function store()
    {

        $this->validate(request(),[
            'content'=>'required',
            'priority'=>'required',
            'deadline'=>'required'
        ]);

        $task=Task::create([
        'user_id'=>auth()->id(),
        'project_id'=>request('project_id'),
        'content'=>request('content'),
        'deadline'=>request('deadline'),
        'priority'=>request('priority')
            ]);
        $project_title=Project::find(request('project_id'))->title;
        //store the new event
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created',
            'content_type'=>'task ',
            'title' => 'on project '.$project_title ,
            'link_id'=> 'task/show/'.$task->id
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
         session()->flash('message','task created successfully');

        return redirect()->route('project.show',request('project_id'));
    }
    public function index($id)
    {
       

         if ($id == 'all' ) {
     $tasks=Task::orderBy('created_at','desc')->paginate(10);
        return view('task.index',compact('tasks'));
    }

      
     if(!Project::find($id)){
            abort(404);
        }

        $project=Project::find($id);
        $tasks = $project->tasks;
        return view('task.index',compact('tasks'));
    }
    //edit and update the task
    public function edit($id)
    {
        if(!Task::find($id)){
            abort(404);
        }
        $task=Task::find($id);
        return view('task.edit',compact('task'));
    }
    public function update($id)
    {
        if(!Task::find($id)){
            abort(404);
        }
          $this->validate(request(),[
            'content'=>'required',
             'priority'=>'required',
            'deadline'=>'required'
        ]);



        $task=Task::find($id);
        $task->content =request('content');
        $task->deadline =request('deadline');
        $task->priority =request('priority');
        $task->save();
        $project_title=$task->project->title;
        //store the new event
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'updated',
            'content_type'=>'task',
            'title' => 'on project '.$project_title,
            'link_id'=> 'task/show/'.$task->id
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
        }
            //and that's it :)
        session()->flash('message','task edited successfully');

        return redirect()->route('task.show',$id);
    }
    //delete the task
    public function delete($id)
    {
        if(!Task::find($id)){
            abort(404);
        }

        $task=Task::find($id);

        $discussions = Discussion::where('type','task')->where('link_id',$id)->get();
        foreach ($discussions as $discussion) {
              $comments =DiscussionComment::where('discussion_id',$discussion->id)->delete();
        }


        $discussions = Discussion::where('type','task')->where('link_id',$id)->delete();

        ToDo::where('task_id',$id)->delete();

        
        $project_title=$task->project->title;
        //store the new event
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'deleted',
            'content_type'=>'task',
            'title' => 'on project '.$project_title,
            'link_id'=> 'task/index'
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
        $task->delete();
        session()->flash('message','task deleted successfully');

        if (count(Task::where('project_id',$id)->get())) {
          return redirect()->route('task.index',$id);
        } else  return redirect()->route('task.index',$task->project_id);
    }

    public function show($id){

        if(!Task::find($id)){
            abort(404);
        }
        
        $task=Task::find($id);
        $discussions = Discussion::where('link_id',$id)->where('type','task')->orderBy('created_at','desc')->get();
        return view('task.show',compact(['task','discussions']));

    }

    public function discuss($id){

        $type = 'task';
        $link_id = $id;
        return view('discussion.create',compact(['type','link_id']));

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use \App\Project;
use \App\Discussion;
use \App\DiscussionComment;
use \App\ToDo;
use \App\Task;
use \App\Attachment;
use \App\User;
use App\Event;
use App\UserEvent;


class ProjectController extends Controller
{
   
	//create and store the new project
    public function create()
    {
    	return view('project.create');
    }
    public function store()
    {

    	$this->validate(request(),[
            'title'=>'required',
            'description'=>'required',
            'image_url'=>'max:2048|mimetypes:image/jpeg,image/png',
            'phase'=>'required'
         ]);
        $project=Project::create([
                'user_id'=>auth()->id(),
                'title'=>request('title'), 
                'status'=>request('status'),
                'attachment_id'=>0,
                'description'=>request('description'),
                'phase'=>request('phase')
                    ]);
        if(!empty(request('image_url')))
        {
            $images_path='cdn';
            $projectPhoto=request()->file('image_url');
            $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($projectPhoto->getClientOriginalName())));
            $ext = pathinfo($target_file, PATHINFO_EXTENSION);
            $target_file=hash('sha256',$target_file).'.'.$ext;

            $projectPhoto->move($images_path,$target_file);
            
            $image_url=$images_path.'/'.$target_file;
            
            $attachment=Attachment::create([
            'attachment_url'=>$image_url
                ]);

            $project->attachment_id=$attachment->id;

            $project->save();
        }


        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created ',
            'content_type'=>'project',
            'title'=> $project->title, 
            'link_id'=>'project/show/'.$project->id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    
        }
    	 session()->flash('message','project created successfully');

    	return redirect()->route('project.show',Project::orderBy('created_at','desc')->first()->id);
    }
    public function index()
    {
    	$projects=Project::orderBy('created_at','desc')->paginate(10);
    	return view('project.index',compact('projects'));
    }
    //edit and update the project
    public function edit($id)
    {
        if(!Project::find($id)){
            abort(404);
        }
    	$project=Project::find($id);
    	return view('project.edit',compact('project'));
    }

    public function update($id)
    {
        if(!Project::find($id)){
            abort(404);
        }
    	  $this->validate(request(),[
            'title'=>'required',
            'description'=>'required',
            'image_url'=>'max:2048|mimetypes:image/jpeg,image/png',
            'phase'=>'required'
        ]);
          $project=Project::find($id);
		  
		   $project->fill([
            'title'=>request('title'),
            'description'=>request('description'),
            'status'=>request('status'),
            'phase'=>request('phase')
        ]);
        $project->save();
		
		
         if(!empty(request('image_url'))) {
            $images_path='cdn';
            $projectPhoto=request()->file('image_url');
            $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($projectPhoto->getClientOriginalName())));
           $ext = pathinfo($target_file, PATHINFO_EXTENSION);
            $target_file=hash('sha256',$target_file).'.'.$ext;

            $projectPhoto->move($images_path,$target_file);
            
            $image_url=$images_path.'/'.$target_file;
        

        
     
		$attachment=Attachment::find($project->attachment_id);
        if($attachment)
        {
             //$attachment=Attachment::find($project->attachment_id);
            //delete it 
            File::delete($attachment->attachment_url);
            //update with new image
            $attachment->attachment_url=$image_url;
            $attachment->save();
        }
        else
        {
            //no previous image
            $attachment=Attachment::create([
                'attachment_url'=>$image_url
            ]);
            $project->fill([
                'attachment_id'=>$attachment->id
                ]);
            $project->save();
        }
    }elseif(empty(request('image_url')) && empty(request('current_image'))){
                    $attachment = Attachment::find($project->attachment_id);
                    if ($attachment) {
                        File::delete($attachment->attachment_url);
                        $attachment->delete();
                    }
                    
                
            }
       

        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'updated ',
            'content_type'=>'project',
            'title'=>request('title'), 
            'link_id'=>'project/index'
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    
        }
    	session()->flash('message','project edited successfully');

    	return redirect()->route('project.show',$id);
    }
    //delete the project
    public function delete($id)
    {
        if(!Project::find($id)){
            abort(404);
        }

        $project=Project::find($id);
         
         if(!empty($project->attachment))
        {
            File::delete($project->attachment->attachment_url);
            Attachment::where('id',$project->attachment->attachment_id)->delete();
        }
         
        $discussions = Discussion::where('type','project')->where('link_id',$id)->get(); 
        foreach ($discussions as $discussion) {
              $comments =DiscussionComment::where('discussion_id',$discussion->id)->delete();
        }
     
        $tasks = Task::where('project_id',$id)->get();
        foreach ($tasks as $task) {
            ToDo::where('task_id',$task->id)->delete();
        }

        $tasks=Task::where('project_id',$id)->delete();
        $discussions= Discussion::where('type','project')->where('link_id',$id)->delete();

             
        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'deleted ',
            'content_type'=>'project',
            'title'=> $project->title, 
            'link_id'=>'project/index'
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    
        }

        $project->delete();

        session()->flash('message','project deleted successfully');
    	
        return redirect()->route('project.index');
    	
    }

    public function show($id){
        if(!Project::find($id)){
            abort(404);
        }
        
        $project=Project::find($id);
        
        $discussions = Discussion::where('link_id',$id)->where('type','project')->orderBy('created_at','desc')->get();

        $todosCount=0;
        $doneTodos=0;$postPoned=0;$onGoing=0;$notStarted=0;

        foreach ($project->tasks as $task) {
                
                $doneTodos+=Todo::where('task_id',$task->id)
                ->where('status','DONE')->count();
                $onGoing+=Todo::where('task_id',$task->id)
                ->where('status','ONGOING')->count();
                $notStarted+=Todo::where('task_id',$task->id)
                ->where('status','NOT_STARTED')->count();
                $postPoned+=Todo::where('task_id',$task->id)
                ->where('status','POSTPONED')->count();
        }
/*        $todosCount=$doneTodos+$onGoing+$notStarted+$postPoned;
        
        if ($doneTodos>0) 
        $doneTodos=round($todosCount/$doneTodos, 2);
        if($onGoing>0)
        $onGoing=round($todosCount/$onGoing, 2);
        if($notStarted>0)
        $notStarted=round($todosCount/$notStarted, 2);
        if($postPoned>0)
        $postPoned=round($todosCount/$postPoned, 2);*/
        
        return view('project.show',compact(['project','discussions']))
        ->with(['doneTodos'=>$doneTodos,'onGoing'=>$onGoing,'notStarted'=>$notStarted,'postPoned'=>$postPoned]);

    }

    public function discuss($id){

        $type = 'project';
        $link_id = $id; 
        return view('discussion.create',compact(['type','link_id']));

    }
}

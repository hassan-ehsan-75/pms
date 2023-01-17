<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Job;
use App\Discussion;
use App\DiscussionComment;
use App\Attachment;
use App\User;
use App\Event;
use App\UserEvent;

class JobController extends Controller
{
  
    public function index()
    {
    	   $jobs=Job::orderBy('created_at','desc')->paginate(10);
        return view('job.index',compact('jobs'));

    }
    public function create()
    {
    	return view('job.create'); 
    }
    public function store()
    {
        $this->validate(request(),[
            'title'=>'required',
            'content'=>'required',
            'status' =>'required',
            'image_url'=>'max:2048|mimetypes:image/jpeg,image/png,image/jpj'
         ]);
             $job=Job::create([
            'user_id'=>auth()->user()->id,
            'title'=>request('title'),
            'status'=>request('status'),
            'content'=>request('content'), 
            'attachment_id'=>0
                ]);
        if(!empty(request('image_url')))
        {
            $images_path='cdn';
            $jobPhoto=request()->file('image_url');
            $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($jobPhoto->getClientOriginalName())));
           $ext = pathinfo($target_file, PATHINFO_EXTENSION);
            $target_file=hash('sha256',$target_file).'.'.$ext;

            $jobPhoto->move($images_path,$target_file);
            
            $image_url=$images_path.'/'.$target_file;
            
            $attachment=Attachment::create([
                'attachment_url'=>$image_url
                ]);
            $job->attachment_id=$attachment->id;
            $job->save();
            }
        
          $title=substr($job->content,0,20);
        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created ',
            'content_type'=>'job',
            'title'=> $title, 
            'link_id'=>'job/show/'.$job->id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    
        }
        session()->flash('message','job create successfully');
        return redirect()->route('job.show',$job->id);
    }

    public function edit($id)
    {
        if(!Job::find($id)){
            abort(404);
        }
        $job=Job::find($id);
        return view('job.edit',compact('job'));
    }
    public function update($id)
    {
        if(!Job::find($id)){
            abort(404);
        }
        $this->validate(request(),[
            'title'=>'required',
            'content'=>'required',
            'status'=>'required',
            'image_url'=>'max:2048|mimetypes:image/jpeg,image/png'
        ]);
          
            $job=Job::find($id);
            $job->fill([
                'title'=>request('title'),
                'status'=>request('status'), 
                'content'=>request('content')
            ]);

            $job->save();
          
          if(!empty(request('image_url'))){
                $images_path='cdn';
                $jobPhoto=request()->file('image_url');
                $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($jobPhoto->getClientOriginalName())));
				$ext = pathinfo($target_file, PATHINFO_EXTENSION);
				$target_file=hash('sha256',$target_file).'.'.$ext;

                $jobPhoto->move($images_path,$target_file);
            
                $image_url=$images_path.'/'.$target_file;
                
                  //delete previous image if found
                if($job->attachment){
					$attachment=Attachment::find($job->attachment_id);
					//delete file
                    File::delete($attachment->attachment_url);
					//create new update the attachment url
                    $attachment->attachment_url=$image_url;
                    $attachment->save();
                }else{
					//it has no image create and save the new attachment in database
					$attachment=Attachment::create(['attachment_url'=>$image_url]);
					$job->attachment_id=$attachment->id;
					$job->save();
				}
                $title=substr($job->content,0,20);
        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'updated ',
            'content_type'=>'job',
            'title'=> $title, 
            'link_id'=>'job/show/'.$job->id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);
        }    
        }
				
               
                
            
		/*  //do nothing if the attachment is empty	
			elseif (empty(request('image_url'))) {
         
		 $attachment=Attachment::find($news->attachment_id);

        if(!empty($attachment))
        {
            //there is a previous image
            //delete it 
            File::delete($attachment->attachment_url);
            //update with new image
           Attachment::find($news->attachment_id)->delete();
             
           
        }
    } */

        session()->flash('message','job updated successfully');
        return redirect()->route('job.show',$id);

    }

    public function show($id)
    {
        if(!Job::find($id)){
            abort(404);
        }
        $job=Job::find($id);
        $discussions = Discussion::where('type','job')->where('link_id',$id)->orderBy('created_at','desc')->get();
        return view('job.show',compact(['job','discussions']));    
    }
    public function delete($id)
    {   
        if(!Job::find($id)){
            abort(404);
        }
        $discussions = Discussion::where('type','job')->where('link_id',$id)->get();
        foreach ($discussions as $discussion) {
          $comment = DiscussionComment::where('discussion_id',$discussion->id)->delete();
        
        }
       $discussions = Discussion::where('type','job')->where('link_id',$id)->delete();

         if(!empty(Job::find($id)->attachment))
        {
            File::delete(job::find($id)->attachment->attachment_url);
			Attachment::where('id',Job::find($id)->attachment->attachment_id)->delete();
        }
         
       Job::find($id)->delete();

        session()->flash('message','job deleted successfully');
        return redirect()->route('job.index');
    }


    public function discuss($id){

        $type = 'job';
        $link_id = $id; 
        return view('discussion.create',compact(['type','link_id']));

    }

}

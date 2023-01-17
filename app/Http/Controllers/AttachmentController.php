<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\User;
use \App\Attachment;
use Illuminate\Support\Facades\File;
use App\Event;
use App\UserEvent;

class AttachmentController extends Controller
{
    public function index()
    {
    	$attachments = Attachment::whereNotNull('title')->get();
        return view('attachment.index',compact('attachments'));
    }
    public function create()
    {
    return view('attachment.create');
    }
	
	


    public function store()
    {
    	 $rules=[
            'attachment'=>'required',
            'title'=>'required',
            'extension'=>'required'


        ];

         $attachment_path='cdn';
        $attachment=request()->file('attachment');
            $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($attachment->getClientOriginalName())));
			$ext = pathinfo($target_file, PATHINFO_EXTENSION);
            $target_file=hash('sha256',$target_file).'.'.$ext;

            $attachment->move($attachment_path,$target_file);
            
            $attachment_url=$attachment_path.'/'.$target_file;

           
            
            $attachment=Attachment::create([
            'attachment_url'=>$attachment_url,
            'title'=> request('title'),
            'extension'=>request('extension'),
            'user_id' => auth()->user()->id
            ]);
             //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created',
            'content_type'=>'Attachment',
            'title'=> request('title'), 
            'link_id'=>'user/profile/'.auth()->id()
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    

        }
        
        return redirect()->route('attachment.index');
    }

    public function delete($id){
        if(!Attachment::find($id)){
            abort(404);
        }
        $attachment = Attachment::find($id);
            //there is a pervvious image 
            File::delete($attachment->attachment_url);
            Attachment::find($id)->delete();
            return redirect()->route('attachment.index');

    }


    public function changePic($user_id)
    {
       
        $rules=[
            'profile_image'=>'max:2048|mimetypes:image/jpeg,image/png'
        ];
        $custom_error_message=['mimetypes'=>'the uploaded file must be an image'];
        $this->validate(request(),$rules,$custom_error_message);
        //if no file was uploades
        if(request('profile_image')==null)
            return back();

       
        
        $images_path='cdn';
        $profilePhoto=request()->file('profile_image');
            $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($profilePhoto->getClientOriginalName())));

            $target_file=hash('sha256',$target_file);

            $profilePhoto->move($images_path,$target_file);
            
            $image_url=$images_path.'/'.$target_file;

            $attachment=Attachment::where('user_id',auth()->user()->id)->whereNull('title')->first();
        if(!empty($attachment))
        {
            //there is a pervvious image 
            File::delete($attachment->attachment_url);
            $attachment->attachment_url=$image_url;
            $attachment->save();
             
        }
        else
        {
            //no previous image whre defined so crreate one and linked to the user
            $attachment=Attachment::create([
            'attachment_url'=>$image_url,
            'user_id' => auth()->user()->id
            ]);
            //then update that user accordignally
            //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'updated',
            'content_type'=>'Announcement',
            'title'=> 'profile picture', 
            'link_id'=>'user/profile/'.auth()->id()
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
        return redirect()->back();
    }
}

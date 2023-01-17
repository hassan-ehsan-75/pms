<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\News;
use App\Discussion;
use App\DiscussionComment;
use App\Attachment;
use App\User;
use App\Event;
use App\UserEvent;

class NewsController extends Controller
{
   
    public function index()
    {
    	   $newss=News::orderBy('created_at','desc')->paginate(10);
        return view('news.index',compact('newss'));

    }
    public function create()
    {
    	return view('news.create'); 
    }
    public function store()
    {
        $this->validate(request(),[
            'title'=>'required',
            'content'=>'required',
            'status'=>'required',
            'image_url'=>'max:2048|mimetypes:image/jpeg,image/png,image/jpj'
         ]);
             $news=News::create([
            'user_id'=>auth()->user()->id,
            'title'=>request('title'),
            'content'=>request('content'), 
            'attachment_id'=>0,
            'status'=>request('status')
                ]);
        if(!empty(request('image_url')))
        {
            $images_path='cdn';
            $newsPhoto=request()->file('image_url');
            $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($newsPhoto->getClientOriginalName())));
           $ext = pathinfo($target_file, PATHINFO_EXTENSION);
            $target_file=hash('sha256',$target_file).'.'.$ext;

            $newsPhoto->move($images_path,$target_file);
            
            $image_url=$images_path.'/'.$target_file;
            
            $attachment=Attachment::create([
                'attachment_url'=>$image_url
                ]);
            $news->attachment_id=$attachment->id;
            $news->save();

            $title=substr($news->content,0,20);
        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created ',
            'content_type'=>'news',
            'title'=> $title, 
            'link_id'=>'news/show/'.$news->id
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
        
        session()->flash('message','news create successfully');
        return redirect()->route('news.index');
    }

    public function edit($id)
    {
        if(!News::find($id)){
            abort(404);
        }
        $news=News::find($id);
        return view('news.edit',compact('news'));
    }
    public function update($id)
    {
        if(!News::find($id)){
            abort(404);
        }

        $this->validate(request(),[
            'title'=>'required',
            'content'=>'required',
            'status'=>'required',
            'image_url'=>'max:2048|mimetypes:image/jpeg,image/png'
        ]);
          
            $news=News::find($id);
            $news->fill([
                'title'=>request('title'), 
                'content'=>request('content'), 
                'status'=>request('status'), 
            ]);

            $news->save();
          
          if(!empty(request('image_url'))){
                $images_path='cdn';
                $newsPhoto=request()->file('image_url');
                $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($newsPhoto->getClientOriginalName())));
				$ext = pathinfo($target_file, PATHINFO_EXTENSION);
				$target_file=hash('sha256',$target_file).'.'.$ext;

                $newsPhoto->move($images_path,$target_file);
            
                $image_url=$images_path.'/'.$target_file;
                
                  //delete previous image if found
                if($news->attachment){
					$attachment=Attachment::find($news->attachment_id);
					//delete file
                    File::delete($attachment->attachment_url);
					//create new update the attachment url
                    $attachment->attachment_url=$image_url;
                    $attachment->save();
                }else{
					//it has no image create and save the new attachment in database
					$attachment=Attachment::create(['attachment_url'=>$image_url]);
					$news->attachment_id=$attachment->id;
					$news->save();

           
				}
				
               
                
            }elseif(empty(request('image_url')) && empty(request('current_image'))){
                    $attachment = Attachment::find($news->attachment_id);
                    if ($attachment) {
                        File::delete($attachment->attachment_url);
                        $attachment->delete();
                    }
                    
                         $title=substr($news->content,0,20);
        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created ',
            'content_type'=>'news',
            'title'=> $title, 
            'link_id'=>'news/show/'.$news->id
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

        session()->flash('message','news updated successfully');
        return redirect()->route('news.show',$id);

    }

    public function show($id)
    {
        if(!News::find($id)){
            abort(404);
        }
        
        $news=News::find($id);
        $discussions = Discussion::where('type','news')->where('link_id',$id)->orderBy('created_at','desc')->get();
        return view('news.show',compact(['news','discussions']));    
    }
    public function delete($id)
    {   
        $discussions = Discussion::where('type','news')->where('link_id',$id)->get();
        foreach ($discussions as $discussion) {
          $comment = DiscussionComment::where('discussion_id',$discussion->id)->delete();
        
        }
       $discussions = Discussion::where('type','news')->where('link_id',$id)->delete();

         if(!empty(News::find($id)->attachment))
        {
            File::delete(News::find($id)->attachment->attachment_url);
			Attachment::where('id',News::find($id)->attachment->attachment_id)->delete();
        }
         
       News::find($id)->delete();

        session()->flash('message','news deleted successfully');
        return redirect()->route('news.index');
    }


    public function discuss($id){

        $type = 'news';
        $link_id = $id; 
        return view('discussion.create',compact(['type','link_id']));

    }

}

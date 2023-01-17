<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use \App\User;
use \App\UserTitle;
use \App\Attachment;
use \App\UserPermission;
use \App\Project;
use \App\Task;
use \App\ToDo;
use \App\Discussion;
use \App\DiscussionComment;
use \App\News;
use \App\Announcement;
use App\Event;
use App\UserEvent;

class UserController extends Controller
{
   
    public function loginForm()
    {
        
        if(auth()->check() || auth()->viaRemember())
            return redirect()->route('dashboard');
        return view('login-form');
    }
    public function login()
    {
        $this->validate(request(),[
            'user_name'=>'required',
            'password'=>'required'
            ]);
        $remember=request('remember');
        $boll_remember=empty($remember)? false:true;
    	$user=['user_name'=>request('user_name'),'password'=>request('password'),'activated'=>1];
    	$user_with_email = ['email'=>request('user_name'),'password'=>request('password'),'activated'=>1];
    	if(auth()->attempt($user,$boll_remember) || auth()->attempt($user_with_email,$boll_remember))
    	{
            //else just let him in
    		auth()->login(auth()->user(),$boll_remember);
            return redirect()->route('dashboard');
    	}
    	else
    	{
    		//log in failed
    		return redirect()->back()->withErrors(['message'=>'It is wrong credintals,Or you are not ativated yet!!']);
    	}
    }
    public function dashboard()
    {
        
    	return view('user.dashboard');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store()
    {
        //just for validation
        $rules=[
                'user_name'=>'required',
                'full_name'=>'required',
                'password'=>'required|min:8',
                'profile_image'=>'max:2048|mimetypes:image/jpeg,image/png',
                'email'=>'required|unique:users',
                'permission'=>'required',
                'title'=>'required'
             ];
        $custom_error_message=['mimetypes'=>'the uploaded file for profile image  must be an image'];
        $this->validate(request(),$rules,$custom_error_message);
        //done validation
          $activated=empty(request('activated'))? 0:1;
        $user=User::create([
            'user_id'=>auth()->user()->id,
            'user_name'=>request('user_name'), 
            'full_name'=>request('full_name'),
            'email'=>request('email'), 
            'password'=>Hash::make(request('password')), 
            'other'=>'', 
            'activated'=>$activated, 
            'facebook'=>request('facebook'), 
            'phone'=>request('phone'), 
            'skype'=>request('skype'), 
            'twiter'=>request('twiter'), 
            'linkedin'=>request('linkedin'), 
            'skills'=>request('skills'),
            'location'=>request('location'),
            'about'=>request('about'),
            'token'=> $this->newUserToken(request('username'),request('password'))
            ]);
        $images_path='cdn';
        //check if no picture was chossen
        if(request('profile_image')!=null)
        {
            $profilePhoto=request()->file('profile_image');
            $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($profilePhoto->getClientOriginalName())));

            $ext = pathinfo($target_file, PATHINFO_EXTENSION);
            $target_file=hash('sha256',$target_file).'.'.$ext;

            $profilePhoto->move($images_path,$target_file);
            
            $image_url=$images_path.'/'.$target_file;

            
        
        
      
        //check again to see if we need to create attachment
       $attachment=Attachment::create([
            'user_id'=>$user->id,
            'attachment_url'=>$image_url
            ]);
}
        UserTitle::create([
            'user_id'=>$user->id,
            'title_id'=>request('title')
            ]);
        UserPermission::create([
            'user_id'=>$user->id,
            'permission_id'=>request('permission')
        ]);


        //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'created ',
            'content_type'=>'user',
            'title'=> $user->user_name, 
            'link_id'=>'user/profile/'.$user->id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    
        }
        session()->flash('message','new user created succesfully');
        return redirect()->route('user.profile',['id'=>$user->id]);
    }
    public function index()
    {
        $users=User::all()->whereNotIn('id',[2])->where('activated',1);
        return view('user.index',compact('users'));
    }
    public function profile($id)
    {
        if(!User::find($id)){
            abort(404);
        }
        $user=User::find($id);
        $discussions = Discussion::where('user_id',$id)->orderBy('created_at','desc')->get();
        return view('user.profile',compact('user','discussions'));
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login-form');
    }
    public function edit($id)
    {
         if(!User::find($id)){
            abort(404);
        }
        $user=User::find($id);
            return view('user.edit',compact('user'));

    }
    public function update($id)
    {
         if(!User::find($id)){
            abort(404);
        }
        $this->validate(request(), [
            'user_name'=>'required',
            'full_name'=>'required',
            'email'=>'required',
            'title'=>'required',
            'permission'=>'required',
            'profile_image'=>'max:2048|mimetypes:image/jpeg,image/png',
                    ]);
        $user=User::find($id);

        $activated=empty(request('activated'))? 0:1;

        $user->fill([
            'user_name'=>request('user_name'),
            'full_name'=>request('full_name'), 
            'email'=>request('email'),
            'activated'=>$activated,
            'facebook'=>request('facebook'),
            'phone'=>request('phone'),
            'linkedin'=>request('linkedin'),
            'skype'=>request('skype'), 
            'twiter'=>request('twiter') ,
            'skills'=>request('skills'),
            'location'=>request('location'),
            'about'=>request('about')
        ]);

        if(!empty(request('password')))
        {
            $user->password=Hash::make(request('password'));
        
        }
        if(!empty(request('profile_image')))
        {
            $images_path='cdn';
            $profilePhoto=request()->file('profile_image');
            $target_file = str_replace(' ', '',strtolower(date('YmdHis'). basename($profilePhoto->getClientOriginalName())));
            $ext = pathinfo($target_file, PATHINFO_EXTENSION);
            $target_file=hash('sha256',$target_file).'.'.$ext;

            $profilePhoto->move($images_path,$target_file);
            
            $image_url=$images_path.'/'.$target_file;
            $attachment=Attachment::where('user_id',$user->id)->whereNull('title')->first();

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
            'user_id'=>$user->id,
            'attachment_url'=>$image_url
            ]);
           
        }
        }elseif (empty(request('image_url')) && empty(request('current_image')) ) {
         $attachment=Attachment::where('user_id',$user->id)->whereNull('title')->first();

        if(!empty($attachment))
        {
            //there is a previous image
            //delete it 
            File::delete($attachment->attachment_url);
            //update with new image
           Attachment::where('user_id',$user->id)->whereNull('title')->delete();
             
           
        }

       
    }
        

        UserPermission::where('user_id',$id)->update([
            'permission_id'=>request('permission')
        ]);
        UserTitle::where('user_id',$id)->update([
            'title_id'=>request('title')
        ]);
        $user->save();

         //create a new event in the database
        $event=Event::create([
            'user_id'=>auth()->id(),
            'type'=>'updated ',
            'content_type'=>'user',
            'title'=> $user->user_name, 
            'link_id'=>'user/profile/'.$user->id
        ]);

        $users=User::whereNotIn('id',[1,2,auth()->id()])->get();

        foreach ($users as $user) {
        //store an event for each user to notify
        UserEvent::create([
            'user_id'=>$user->id,
            'event_id'=>$event->id,
        ]);    
        }
        
        session()->flash('message','user edited successfully');
        return redirect()->route('user.profile',$id);
    }
    public function delete($id)
    {
         if(!User::find($id)){
            abort(404);
        }
        $user =User::find($id)->update(['activated'=>0]);

         if(!empty($user->attachment))
        {
            File::delete($user->attachment->attachment_url);
        }

        Project::where('user_id',$id)->update([
            'user_id' => 2]);
        Task::where('user_id',$id)->update([
            'user_id' => 2]);
        ToDo::where('user_id',$id)->update([
            'user_id' => 2]);
        News::where('user_id',$id)->update([
            'user_id' => 2]);
        Discussion::where('user_id',$id)->update([
            'user_id' => 2]);
        DiscussionComment::where('user_id',$id)->update([
            'user_id' => 2]);
        Announcement::where('user_id',$id)->update([
            'user_id' => 2]);
        session()->flash('message','user deactivated succesfully');
        return redirect()->route('user.index');
    }
    public function changePassword($id)
    {
    	 $this->validate(request(), [
            'password'=>'required',
            'new_password'=>'required|min:8',
            'comfirm_password'=>'required|same:new_password',
           
                    ]);

        
        $user=User::find($id);

        if(Hash::check(request('password'),$user->password))
        {
            $user->password=Hash::make(request('new_password'));
            $user->save();

            session()->flash('message','password changed successfully');
            
            return back();
        }else{
            session()->flash('message','the old password is wrong');
        return back();
    }
    }

    public function addInfo($id){
         if(!User::find($id)){
            abort(404);
        }
        $user = User::find($id);
        return view('user.addinfo',compact('user'));
    }

    public function storeInfo($id){
         if(!User::find($id)){
            abort(404);
        }

        $user= User::find($id);
         $user->fill([
            'facebook'=>request('facebook'),
            'phone'=>request('phone'),
            'linkedin'=>request('linkedin'),
            'skype'=>request('skype'), 
            'twiter'=>request('twiter') ,
            'skills'=>request('skills'),
            'location'=>request('location'),
            'about'=>request('about')
        ]);
         $user->save();
          session()->flash('message','youe info has been added successfully');
        return redirect()->route('user.profile',$id);

    }


     public  function newUserToken($username,$password){
    
    
    $salt  = bin2hex(openssl_random_pseudo_bytes(64));
    $secret_iv = substr(hash('sha256', $salt), 0, 16);
    
    $password = hash('sha256', $password);
    $encrypt_method = "AES-256-CBC";
    

    $token = openssl_encrypt($username.$salt, $encrypt_method, $password, 0, $secret_iv);
    $token = $username.'-'.$token;

    $token=hash('sha256', $token);
    return $token;
}


    
}

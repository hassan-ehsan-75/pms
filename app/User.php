<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','user_name', 'creator_id','password','full_name','other','email','phone','skype',
        'twiter','linkedin','facebook','activated',
        'permission_id','skills','about','location','token'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * database relations
     * 
     */
    //for the creator and the created users 
    public function creator()
    {
        return $this->BelongsTo(User::class,'user_id');
    }
    public function getCreator()
    {
        return $this->creator->user_name;
    }
    public function createdUsers()
    {
        return $this->hasMany(User::class);
    }
    //attachment realtion and a method to get the url directly
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
    public function getAttachment()
    {
        if(Attachment::where('user_id',$this->id)->whereNull('title')->count() != 0)
        return Attachment::where('user_id',$this->id)->whereNull('title')->first()->attachment_url;
        else
            return asset('dist/img/boxed-bg.png');
    }
    //for the user title
    public function userTitle()
    {
        return $this->hasOne(UserTitle::class);
    }
    public function getTitle()
    {
        if($this->userTitle==null)
            return ' ';
        return $this->userTitle->title->title_name;
    }
    //calling this will get all the permissions no need for another method
    public function userPermission()
    {
        return $this->hasone(UserPermission::class);
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function scheduleToDos()
    {
        return $this->hasMany(ScheduleTodo::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
    public function userTests()
    {
        return $this->hasMany(UserTest::class);
    }
    public function testSubmissions()
    {
        return $this->hasMany(TestSubmission::class);
    }
    public function announcement()
    {
        return $this->hasMany(Announcement::class);
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }
    public function discussionComments()
    {
        return $this->hasMany(DiscussionComment::class);
    }
     //for the remember me 
    public function getRememberToken()
    {   
    return $this->remember_token;
    }

    public function setRememberToken($value)
    {
    $this->remember_token = $value;
    }   

    public function getRememberTokenName()
    {
    return 'remember_token';
    }
     public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function hasPermission($permission)
    {
        if($this->userPermission->permission->permission_name==$permission)
            return true;
        else
            return false;
    }

     public function getPermission()
    {
        return $this->userPermission->permission->permission_name;
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function userEvent()
    {
        return $this->hasMany(UserEvent::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $fillable=['user_id','title','status','attachment_id','description','phase'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



     public function getCreator()
    {
    	return $this->user->user_name;
    }

     public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('created_at','desc');
    }

    public function hasTasks(){
        if(Task::where('Project_id',$this->id)->count() == 0)
            return false;
       return true;
    }

    public function discussions()
    {

    	return $this->hasMany(Discussion::class,'link_id')->where('type','project');
    }

     public function todos()
    {
        return $this->hasMany(ToDo::class);;
    }
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
    public function getAttachment()
    {
        if($this->attachment!=null)
        return $this->attachment->attachment_url;
        else
            return asset('dist/img/boxed-bg.png');
    }



}

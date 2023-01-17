<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{

    protected $fillable = ['user_id','title','content','type','link_id'];


	public function user()
    {
        return $this->belongsTo(User::class);
    }    //

   	public function project()
    {
        return $this->belongsTo(Project::class,'link_id');
    }    //
    	public function todo()
    {
        return $this->belongsTo(ToDo::class,'link_id');
    }    //
        public function task()
    {
        return $this->belongsTo(Task::class,'link_id');
    }    //

     public function news()
    {
        return $this->belongsTo(News::class,'link_id');
    }    //

        public function job()
    {
        return $this->belongsTo(Job::class,'link_id');
    }    //

    public function announcement(){
        return $this->belongsTo(Announcement::class,'link_id');
    }

    public function discussionComments(){

        return $this->hasMany(DiscussionComment::class,'discussion_id');
    }

    public function getComments(){
        return $this->discussionComments;
    }

  
}

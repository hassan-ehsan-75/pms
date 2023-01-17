<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
	protected $fillable=['user_id','attachment_url','title','extension'];
	public function user()
	    {
	    	return $this->belongsTo(User::class);
	    } 
	      public function project()
	      {
	      	return $this->hasOne(Project::class);
	      }
	      public function news()
	      {
	      	return $this->hasOne(News::class);
	      }

	      public function job(){
	      	return $this->hasOne(Job::class);
	      }
}

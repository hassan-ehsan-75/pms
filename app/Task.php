<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable=['user_id','project_id','content'];
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function todo(){
        return $this->hasMany(ToDo::class)->orderBy('created_at','desc');
    }      

    public function discussions()
    {

    	return $this->hasMany(Discussion::class,'link_id')->where('type','task');
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{

    protected $fillable= ['user_id','task_id','description','assigned_to','updated_by','scheduel_id','status'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    public function task()
    {
    	return $this->belongsTo(Task::class);
    }


    public function discussion()
    {

    	return $this->hasMany(Discussion::class,'link_id')->where('type','todo');
    }
}

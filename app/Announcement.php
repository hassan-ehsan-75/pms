<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
	protected $fillable=['user_id','title','content'];
	public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCreator()
    {
    	return $this->user->user_name;
    }
    public function discussions()
    {
    	return $this->hasMany(Discussion::class,'link_id')->where('type','announcement');
    }
}

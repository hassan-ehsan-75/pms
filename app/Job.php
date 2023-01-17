<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $fillable = ['user_id','title','status','content','attachment_id'];

    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function attachment(){
    	return $this->belongsTo(Attachment::class);
    }

    public function getAttachment(){
    	 if($this->attachment!=null)
        return $this->attachment->attachment_url;
        else
            return asset('dist/img/boxed-bg.png');
    }

    public function discussions(){
    	return $this->hasMany(Discussion::class ,'link_id')->where('type','job');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

	protected $fillable=['user_id','title','content','attachment_id','status'];
	
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

        return $this->hasMany(Discussion::class,'link_id')->where('type','news');
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

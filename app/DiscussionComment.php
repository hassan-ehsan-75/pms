<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscussionComment extends Model
{

protected $fillable = ['user_id','content','discussion_id'];

	public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function discussion()
        {
        	return $this->belongsTo(Discussion::class);
        }    

         public function news()
        {
        	return $this->belongsTo(News::class);
        }    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTitle extends Model
{
	protected $fillable=['user_id','title_id'];	
	
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function title()
    {
    	return $this->belongsTo(Title::class);
    }
}

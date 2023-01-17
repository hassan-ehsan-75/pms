<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable=['user_id','type','title','content_type','link_id'];
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function userEvent()
    {
    	return $this->hasMany(UserEvent::class);
    }
}
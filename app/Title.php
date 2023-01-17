<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
	protected $fillable=['title_name'];
    public function users()
    {
    	return $this->hasMany(User::class);
    }
    public function titles()
    {
    	return $this->hasMany(UserTitle::class);
    }
}

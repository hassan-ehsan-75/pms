<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $fillable=['permission_name'];
	public function user()
	    {
	    	return $this->belongsTo(User::class);
	    }    //
}

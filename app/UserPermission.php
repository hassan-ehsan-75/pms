<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
	protected $fillable=['user_id','permission_id'];
	
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function permission()
    {
    	return $this->belongsTo(Permission::class);
    }
}

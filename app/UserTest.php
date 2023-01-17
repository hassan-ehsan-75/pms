<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function test()
    {
       	return $this->belongsTo(Test::class);
    }
}

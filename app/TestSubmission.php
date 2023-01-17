<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestSubmission extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function test()
    {
    	return $this->belongsTo(Test::class);
    }
    public function attachment()
    {
    	return $this->belongsTo(Attachment::class);
    }
    
}

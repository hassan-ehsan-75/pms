<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiToken;
class ApiTokenController extends Controller
{
    public function index()
    {
    	$tokens=ApiToken::orderBy('created_at','desc')->paginate(10);
    	return view('apiToken.index',compact('tokens'));
    }
    public function create()
    {
    	return view('apiToken.create');
    }

     public function edit($id)
    {   
        $token = ApiToken::find($id);
        return view('apiToken.edit',compact('token'));
    }

     public function update($id)
    {   
        $token = ApiToken::find($id);
        $this->validate(request(),[
            'type'=>'required'
        ]);
         $token->type=request('type');
         $token->save();
         session()->flash('message','new Api tokens updated successfully');
        return redirect()->route('apiToken.index');
    }



    public function store()
    {
    	$this->validate(request(),[
    		'platform'=>'required',
    		'secret_key'=>'required',
            'type'=>'required'
    	]);
    	$platform=request('platform');
    	$secret_key=request('secret_key');
        $type=request('type');
    	ApiToken::newToken($platform,$secret_key,$type);

    	session()->flash('message','new Api tokens created successfully');
    	return redirect()->route('apiToken.index');
    }
    public function delete($id)
    {
    	ApiToken::find($id)->delete();
    	session()->flash('message','token deleted');
    	return redirect()->route('apiToken.index');
    }
}

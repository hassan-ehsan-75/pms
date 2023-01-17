<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Permission;

class PermissionController extends Controller
{
    
    public function index()
    {
    	$permissions=Permission::all();
    	return view('permission.index',compact('permissions'));
    }
    public function create()
    {
    	return view('permission.create');
    }
    public function store()
    {
        $this->validate(request(),[
            'permission_name'=>'required'
        ]);
    	Permission::create([
    		'permission_name'=>request('permission_name')
    		]);
        session()->flash('message','permission created successfully');
    	return redirect()->route('permission.index');
    }
    public function edit($id)
    {
        $permission=Permission::find($id);
        return view('permission.edit',compact('permission'));

    }
    public function update($id)
    {
        $this->validate(request(),[
            'permission_name'=>'required'
        ]);
        $permission=Permission::find($id);
        $permission->permission_name=request('permission_name');
        $permission->save();
        session()->flash('message','permission edited successfully');
        return redirect()->route('permission.index');
    }
    public function delete($id)
    {
        Permission::find($id)->delete();
        session()->flash('message','permission deleted successfully');
        return redirect()->route('permission.index');
    }
}

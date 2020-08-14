<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\vehicle_lockers;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class VehicleLockerController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//  get tables and compact
	public function index()
	{   
        return view('locker.add');    
	}

	//store vehicaltypes
	public function store()
	{
	 	$locker = Input::get('locker');
		$count = DB::table('vehicle_lockers')->where('name','=',$locker)->count();
		if ($count==0)
		{
			$lockername= new vehicle_lockers;
			$lockername->name = $locker;
			$lockername -> save();
			return redirect('/locker/list')->with('message','Successfully Submitted');
	 	}
	 	else
		{
			 
	 	 	return redirect('/locker/add')->with('message','Duplicate data');
	 	} 	 
	}

	//vehicaltype list
	public function list()
	{
        $lockers= DB::table('vehicle_lockers')->orderBy('id','DESC')->get()->toArray();
	 	return view('locker.list',compact('lockers'));
	}

	//vehicaltype delete
	public function destory($id)
	{
        $locker = DB::table('vehicle_lockers')->where('id','=',$id)->delete();
		
        return redirect('/locker/list')->with('message','Successfully Deleted');
	}

	//vehicaltype edit form
	public function edit($id)
	{
        $editid=$id;
        $locker = DB::table('vehicle_lockers')->where('id','=',$id)->first();
		return view('locker.edit',compact('locker','editid'));
	}

	//vehicaltype update
	public function update($id)
	{
		$locker=Input::get('vehicaltype');
	 	$count = DB::table('vehicle_lockers')->where([['name','=',$locker],['id','!=',$id]])->count();
		if ($count==0)
		{
			$lockername= vehicle_lockers::find($id);
			$lockername->name=$locker;
			$lockername->save();
			return redirect('locker/list')->with('message','Successfully Updated');
	   }
	   else
	   {
			return redirect('locker/list/edit/'.$id)->with('message','Duplicate Data');;
	   }
	}
}
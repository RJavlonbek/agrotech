<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\tbl_fuel_types;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class FuelTypeController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//  get tables and compact
	public function index()
	{   
        return view('fuel.add');    
	}

	//store vehicaltypes
	public function store()
	{
	 	$fuel = Input::get('fuel');
		$count = DB::table('tbl_fuel_types')->where('name','=',$fuel)->count();
		if ($count==0)
		{
			$fuelname= new tbl_fuel_types;
			$fuelname->name = $fuel;
			$fuelname -> save();
			return redirect('/fuel/list')->with('message','Successfully Submitted');
	 	}
	 	else
		{
			 
	 	 	return redirect('/fuel/add')->with('message','Duplicate data');
	 	} 	 
	}

	//vehicaltype list
	public function list()
	{
        $fuels= DB::table('tbl_fuel_types')->orderBy('id','DESC')->get()->toArray();
	 	return view('fuel.list',compact('fuels'));
	}

	//vehicaltype delete
	public function destory($id)
	{
        $fuel = DB::table('tbl_fuel_types')->where('id','=',$id)->delete();
		
        return redirect('/fuel/list')->with('message','Successfully Deleted');
	}

	//vehicaltype edit form
	public function edit($id)
	{
        $editid=$id;
        $fuel = DB::table('tbl_fuel_types')->where('id','=',$id)->first();
		return view('fuel.edit',compact('fuel','editid'));
	}

	//vehicaltype update
	public function update($id)
	{
		$fuel=Input::get('fuel');
	 	$count = DB::table('tbl_fuel_types')->where([['name','=',$fuel],['id','!=',$id]])->count();
		if ($count==0)
		{
			$fuelname= tbl_fuel_types::find($id);
			$fuelname->name=$fuel;
			$fuelname->save();
			return redirect('fuel/list')->with('message','Successfully Updated');
	   }
	   else
	   {
			return redirect('fuel/list/edit/'.$id)->with('message','Duplicate Data');;
	   }
	}
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\inspection_types;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class InspectionController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//  get tables and compact
	public function index()
	{   
        return view('inspection.add');    
	}

	//store vehicaltypes
	public function store()
	{
	 	$inspection = Input::get('type');
		$count = DB::table('inspection_types')->where('name','=',$inspection)->count();
		if ($count==0)
		{
			$inspectionname= new inspection_types;
			$inspectionname->name = $inspection;
			$inspectionname -> save();
			return redirect('/inspection/list')->with('message','Successfully Submitted');
	 	}
	 	else
		{
			 
	 	 	return redirect('/inspection/add')->with('message','Duplicate data');
	 	} 	 
	}

	//vehicaltype list
	public function list()
	{
        $inspections= DB::table('inspection_types')->orderBy('id','DESC')->get()->toArray();
	 	return view('inspection.list',compact('inspections'));
	}

	//vehicaltype delete
	public function destory($id)
	{
        $fuel = DB::table('inspection_types')->where('id','=',$id)->delete();
		
        return redirect('/fuel/list')->with('message','Successfully Deleted');
	}

	//vehicaltype edit form
	public function edit($id)
	{
        $editid=$id;
        $fuel = DB::table('inspection_types')->where('id','=',$id)->first();
		return view('inspection.edit',compact('fuel','editid'));
	}

	//vehicaltype update
	public function update($id)
	{
		$fuel=Input::get('fuel');
	 	$count = DB::table('inspection_types')->where([['name','=',$fuel],['id','!=',$id]])->count();
		if ($count==0)
		{
			$fuelname= inspection_types::find($id);
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
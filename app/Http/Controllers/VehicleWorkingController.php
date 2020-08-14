<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_vehicle_types;
use App\tbl_vehicle_brands;
use App\vehicle_works_fors;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class VehicleWorkingController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }

	// vehiclebrand add form
	public function index(){   
		$types = DB::table('tbl_vehicle_types')->get()->toArray();
        return view('workingtype.add', compact('types'));    
	}
    
	// vehiclebrand list
    public function list(){
		$workingtypes=DB::table('vehicle_works_fors')->orderBy('id','DESC')->get()->toArray();
     	return view('workingtype.list', compact('workingtypes'));
    }
     
	// vehiclebrand store
    public function store(){
      	$workingtype=Input::get('workingtype');
      	$type = Input::get('type');
        $count = DB::table('vehicle_works_fors')->where('name','=',$workingtype)->count();
		if ($count==0){
			$working = new vehicle_works_fors;
			$working->name = $workingtype;
			$working->type_id = $type;
			$working->save();
			return redirect('workingtype/list')->with('message','Successfully Submitted');
        }else{
			return redirect('workingtype/add')->with('message','Duplicate Data');
        }
    }
	 
	// vehiclebrand delete
	public function destory($id)
	{
	  	$workingtype = DB::table('vehicle_works_fors')->where('id','=',$id)->delete();
	  	return redirect('workingtype/list')->with('message','Successfully Deleted');
	}

	// vehiclebrand edit form
	public function edit($id)
	{
		$editid=$id;
	  	$working=DB::table('vehicle_works_fors')->where('id','=',$id)->first();
	  	$types = DB::table('tbl_vehicle_types')->get()->toArray();
	  	return view('workingtype.edit',compact('working', 'editid', 'types'));
	}

	// vehiclebrand update
	public function update($id)
	{
      	$working=Input::get('working');
      	$type = Input::get('type');
        $count = DB::table('vehicle_works_fors')->where('name','=',$working)->count();
		$workingtype =vehicle_works_fors::find($id);
		$workingtype->name = $working;
		$workingtype->type_id = $type;
		$workingtype->save();
		return redirect('workingtype/list')->with('message','Successfully Updated'); 
	}
	public function typeworksearch()
	{
		$id = Input::get('id');
		$brand = DB::table('tbl_vehicle_brands')->where('id', '=', $id)->get()->first();
		$typeid = $brand->vehicle_id;
		$type = DB::table('tbl_vehicle_types')->where('id', '=', $typeid)->get()->first();
		$working = DB::table('vehicle_works_fors')->where('id', '=', $brand->working_type_id)->get()->first();
		$data = array('type' => $type->vehicle_type, 'type_id' => $type->id, 'working' => $working->name, 'working_id' => $working->id);
		echo json_encode($data);
	}
}
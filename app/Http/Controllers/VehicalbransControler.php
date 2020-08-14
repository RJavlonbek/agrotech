<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_vehicle_types;
use App\tbl_vehicle_brands;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class VehicalbransControler extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }

	// vehiclebrand add form
	public function index(){  
		$types = DB::table('tbl_vehicle_types')->get()->toArray(); 
		$vehicaltypes=DB::table('tbl_vehicle_types')->get()->toArray();
        return view('vehiclebrand.add',compact('vehicaltypes', 'types'));    
	}
    
	// vehiclebrand list
    public function listvehicalbrand(){
		$vehicalbrand=DB::table('tbl_vehicle_brands')->orderBy('id','DESC')->get()->toArray();
     	return view('vehiclebrand.list',compact('vehicalbrand'));
    }
     
	// vehiclebrand store
    public function store(){
		$vehiacal_id=Input::get('type_id');
      	$vehical_brand=Input::get('vehicalbrand');
      	$working_id = Input::get('working_id');
      	$enginesize = Input::get('enginesize');
        $count = DB::table('tbl_vehicle_brands')->where([['vehicle_id','=',$vehiacal_id],['vehicle_brand','=',$vehical_brand]])->count();
		if ($count==0){
			$vehicalbrands = new tbl_vehicle_brands;
			$vehicalbrands->vehicle_id=$vehiacal_id;
			$vehicalbrands->vehicle_brand=$vehical_brand;
			$vehicalbrands->working_type_id = $working_id;
			$vehicalbrands->enginesize = $enginesize;
			$vehicalbrands->save();
			return redirect('vehiclebrand/list')->with('message','Successfully Submitted');
        }else{
			return redirect('vehiclebrand/add')->with('message','Duplicate Data');
        }
    }
	 
	// vehiclebrand delete
	public function destory($id)
	{
	  	$vehicalbrands = DB::table('tbl_vehicle_brands')->where('id','=',$id)->delete();
	  	// $tbl_vehicles = DB::table('tbl_vehicles')->where('vehiclebrand_id','=',$id)->delete();
	  	return redirect('vehiclebrand/list')->with('message','Successfully Deleted');
	}

	// vehiclebrand edit form
	public function editbrand($id)
	{
		$editid=$id;
	  	$vehicaltypes=DB::table('tbl_vehicle_types')->get()->toArray();
	  	$vehicalbrands=DB::table('tbl_vehicle_brands')->where('id','=',$id)->first();
	  	$working = DB::table('vehicle_works_fors')->get()->toArray();
	  	return view('vehiclebrand/edit',compact('vehicalbrands','vehicaltypes','editid','working'));
	}

	// vehiclebrand update
	public function brandupdate($id)
	{
	 	$vehicletype_id=Input::get('vehicletype');
      	$vehical_brand=Input::get('vehicalbrand');
      	$vehicle_work = Input::get('working_id');
      	$enginesize = Input::get('enginesize');
        $count = DB::table('tbl_vehicle_brands')->where([['vehicle_id','=',$vehicletype_id],['vehicle_brand','=',$vehical_brand],['id','!=',$id]])->count();
		if ($count==0)
		{
			$vehicalbrands =tbl_vehicle_brands::find($id);
			$vehicalbrands->vehicle_id=$vehicletype_id;
			$vehicalbrands->working_type_id = $vehicle_work;
			$vehicalbrands->vehicle_brand=$vehical_brand;
			$vehicalbrands->enginesize = $enginesize;
			$vehicalbrands->save();
			return redirect('vehiclebrand/list')->with('message','Successfully Updated');
        }
        else
        {    
        	 return redirect('vehiclebrand/list/edit/'.$id)->with('message','Duplicate Data');
        }     
	}
	public function typeworksearch()
	{
		$id = Input::get('brand');
		$brand = DB::table('tbl_vehicle_brands')->where('id', '=', $id)->get()->first();
		$type = DB::table('tbl_vehicle_types')->where('id', '=', $brand->vehicle_id)->get()->first();
		$working = DB::table('vehicle_works_fors')->where('id', '=', $brand->working_type_id)->get()->first();
		$data = array(
			'type' => $type->vehicle_type, 
			'type_id' => $type->id, 
			'working' => $working->name, 
			'working_id' => $working->id, 
			'enginesize' => $brand->enginesize, 
			'brand' => $brand->vehicle_brand
		);
		echo json_encode($data);
	}
}
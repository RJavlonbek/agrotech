<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_vehicle_types;
use App\tbl_vehicle_brands;
use App\vehicle_works_fors;
use App\vehicle_factories;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class VehicleFactoryController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }

	// vehiclebrand add form
	public function index(){   
        return view('factory.add');    
	}
    
	// vehiclebrand list
    public function list(){
		$factories=DB::table('vehicle_factories')->orderBy('id','DESC')->get()->toArray();
     	return view('factory.list', compact('factories'));
    }
     
	// vehiclebrand store
    public function store(){
      	$factory=Input::get('factory');
        $count = DB::table('vehicle_factories')->where('name','=',$factory)->count();
		if ($count==0){
			$factoryname = new vehicle_factories;
			$factoryname->name = $factory;
			$factoryname->save();
			return redirect('factory/list')->with('message','Successfully Submitted');
        }else{
			return redirect('factory/add')->with('message','Duplicate Data');
        }
    }
	 
	// vehiclebrand delete
	public function destory($id)
	{
	  	$factory = DB::table('vehicle_factories')->where('id','=',$id)->delete();
	  	return redirect('factory/list')->with('message','Successfully Deleted');
	}

	// vehiclebrand edit form
	public function edit($id)
	{
		$editid=$id;
	  	$factory=DB::table('vehicle_factories')->where('id','=',$id)->first();
	  	return view('factory.edit',compact('factory', 'editid'));
	}

	// vehiclebrand update
	public function update($id)
	{
      	$factory=Input::get('factory');
        $count = DB::table('vehicle_factories')->where('name','=',$factory)->count();
		if ($count==0)
		{
			$factoryname =vehicle_factories::find($id);
			$factoryname->name = $factory;
			$factoryname->save();
			return redirect('factory/list')->with('message','Successfully Updated');
        }
        else
        {    
        	 return redirect('factory/list/edit/'.$id)->with('message','Duplicate Data');
        }     
	}
}
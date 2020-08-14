<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_cities;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class CitiesController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }

	// vehiclebrand add form
	public function index(){   
		$regions = DB::table('tbl_states')->where('country_id', '=', 234)->get()->toArray();
        return view('cities.add', compact('regions'));    
	}
    
	// vehiclebrand list
    public function list(){
		$cities=DB::table('tbl_countries')->
		select('tbl_cities.name as district', 'tbl_states.name as region', 'tbl_cities.id')->
		where('tbl_countries.id', '=', 234)->
		join('tbl_states', 'tbl_countries.id', '=', 'tbl_states.country_id')->
		join('tbl_cities', 'tbl_states.id', '=', 'tbl_cities.state_id')->
		get()->toArray();
     	return view('cities.list', compact('cities'));
    }
     
	// vehiclebrand store
    public function store(){
      	$city=Input::get('city');
      	$region = Input::get('region');
        $count = DB::table('tbl_cities')->where('name','=',$city)->count();
		if ($count==0){
			$cityname = new tbl_cities;
			$cityname->name = $city;
			$cityname->state_id = $region;
			$cityname->save();
			return redirect('cities/list')->with('message','Successfully Submitted');
        }else{
			return redirect('cities/add')->with('message','Duplicate Data');
        }
        echo $region;
    }
	 
	// vehiclebrand delete
	public function destory($id)
	{
	  	$factory = DB::table('tbl_cities')->where('id','=',$id)->delete();
	  	return redirect('cities/list')->with('message','Successfully Deleted');
	}

	// vehiclebrand edit form
	public function edit($id)
	{
		$editid=$id;
	  	$city=DB::table('tbl_cities')->where('id','=',$id)->get()->first();
	  	$regions = DB::table('tbl_states')->where('country_id','=',234)->get()->toArray();
	  	return view('cities.edit',compact('city', 'editid', 'regions'));
	}

	// vehiclebrand update
	public function update($id)
	{
      	$city=Input::get('city');
      	$region = Input::get('region');
		$cityname = tbl_cities::find($id);
		$cityname->name = $city;
		$cityname->state_id = $region;
		$cityname->save();
		return redirect('cities/list')->with('message','Successfully Updated');    
	}
}
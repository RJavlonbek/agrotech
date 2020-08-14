<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_states;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class StatesController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }

	// vehiclebrand add form
	public function index(){   
		$title='Viloyat qo\'shish';
        return view('states.add', compact('title'));    
	}
    
	// vehiclebrand list
    public function list(){
    	$title='Viloyatlar';
		$states=DB::table('tbl_states')->orderBy('name')->get()->toArray();
     	return view('states.list', compact('states'));
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
	  	$state=DB::table('tbl_states')->where('id','=',$id)->get()->first();
	  	return view('states.edit',compact('state', 'editid'));
	}

	// vehiclebrand update
	public function update($id)
	{
		$state = tbl_states::find($id);
		$state->name = Input::get('state');
		$state->code = Input::get('code');
		$state->series = Input::get('series');
		$state->save();
		return redirect('states/list')->with('message','Successfully Updated');    
	}
}
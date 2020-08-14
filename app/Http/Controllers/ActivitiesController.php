<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class ActivitiesController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//  get tables and compact
	public function index()
	{   
		$activities = DB::table('tbl_activities')->
			select(
				'users.name as username',
				'users.lastname as userlastname',
				'users.role',
				'users.id as user_id',
				'customers.id as owner_id',
				'customers.name as ownername',
				'customers.lastname as ownerlastname',
				'customers.middlename',
				'customers.type as ownertype',
				'tbl_vehicles.id as vehicle_id',
				'tbl_vehicle_types.vehicle_type as typename',
				'tbl_vehicle_brands.vehicle_brand as brandname',
				'tbl_cities.name as districtname',
				'tbl_cities.id as city_id',
				'tbl_states.name as regionname',
				'tbl_activities.action_id',
				'tbl_activities.time as action_time',
				'tbl_activities.action_type as type',
				'tbl_activities.action',
				'tbl_activities.id',
				'tbl_activities.created_at',
				'tbl_activities.ip_adress'

			)->
			leftjoin('users', 'users.id', '=', 'tbl_activities.user_id')->
			leftjoin('customers', 'customers.id', '=', 'tbl_activities.owner_id')->
			leftjoin('tbl_vehicles', 'tbl_vehicles.id', '=', 'tbl_activities.vehicle_id')->
			leftjoin('tbl_vehicle_types', 'tbl_vehicle_types.id', '=', 'tbl_vehicles.vehicletype_id')->
			leftjoin('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
			leftjoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_activities.city_id')->
			leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id')->
		orderBy('id', 'desc')->latest()->paginate(50);
        return view('activelog.list', compact('activities'));    
	}
}
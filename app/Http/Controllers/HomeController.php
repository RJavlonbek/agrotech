<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\tbl_jobcard_details;
use App\tbl_vehicles;
use App\tbl_business_hours;
use App\Http\Requests;
use DB;
use Auth;
use Mail;
use Illuminate\Mail\Mailer;
use App\tbl_mail_notifications;
use DateTime;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Config;

class homecontroller extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    public function dashboard(){



		//timezone in run
		$user = DB::table('users')->where('id','=', Auth::user()->id)->first();
		$timezone=$user->timezone;
		
		config(['app.timezone' => $timezone]);
	
		
		$userid=$user->id;
		// $meddate = date('Y-m-d', strtotime('-365 days', strtotime(date('Y-m-d'))));
		// $vehicles = DB::table('tbl_vehicles')->get()->toArray();
		// foreach ($vehicles as $vehicle) {
		// 	$med = DB::table('vehicle_inspections')->where('vehicle_id', '=', $vehicle->id)->orderBy('id', 'desc')->get()->first();
		// 	$vehicle->medid=null;
		// 	if(!empty($med))
		// 	{
		// 		if($med->date<$meddate){
		// 			$vehicle->medid = $med->id;
		// 		}
		// 	}
		// }

		//return 'dashboard1';


		// $technical_pass = DB::table('technical_passports')->
		// 	select(
		// 		'technical_passports.id',
		// 		'technical_passports.given_date as date',
		// 		'technical_passports.series as tpseries',
		// 		'technical_passports.number as tpnumber',
		// 		'customers.type as ownertype',
		// 		'customers.id as owner_id',
		// 		'customers.name as ownername',
		// 		'customers.lastname as ownerlastname',
		// 		'customers.middlename',
		// 		'tbl_vehicle_brands.vehicle_brand as brandname',
		// 		'tbl_vehicle_types.vehicle_type as typename',
		// 		'technical_passports.total_amount',
		// 		'transport_numbers.code as tnscode',
		// 		'transport_numbers.series as tnsseries',
		// 		'transport_numbers.number as tnsnumber'
		// 	)->
		// 	join('customers', 'customers.id', '=', 'technical_passports.owner_id')->
		// 	join('tbl_vehicles', 'tbl_vehicles.id', '=', 'technical_passports.vehicle_id')->
		// 	join('transport_numbers', function($join){
		// 		$join->on('transport_numbers.vehicle_id', '=', 'tbl_vehicles.id')
		// 			->where('transport_numbers.status', '=', 'active');
		// 	})->
		// 	leftjoin('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
		// 	leftjoin('tbl_vehicle_types', 'tbl_vehicle_types.id', '=', 'tbl_vehicles.vehicletype_id')->
		// 	leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		// 	leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		// 	if($user->role != 'admin'){
		// 		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		// 		if(!empty($position)){
		// 			if($position->position == 'district'){
		// 				$i = 0;
		// 				$technical_pass = $technical_pass->where(function($query) use($user){
		// 					foreach (explode(',', $user->city_id) as $city) {
		// 						$query->orWhere('tbl_cities.id', '=', $city);
		// 					}
		// 				});
		// 			}elseif($position->position == 'country'){
		// 				$i = 0;
		// 				$technical_pass = $technical_pass->where(function($query) use($user){
		// 					foreach(explode(',', $user->state_id) as $state){
		// 						$query->orWhere('tbl_states.id','=',$state);
		// 					}
		// 				});
		// 			}elseif($position->position == 'region'){
		// 				$i = 0;
		// 				$technical_pass = $technical_pass->where(function($query) use($user){
		// 					$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
		// 					foreach ($cities as $city) {
		// 						$query->orWhere('tbl_cities.id', '=', $city->id);
		// 					}
		// 				});
		// 			}
		// 		}
		// 	}
		// $technical_pass = $technical_pass->orderBy('technical_passports.id', 'DESC')->skip(0)->take(10)->get()->toArray();

		$technicalPassports = getTechnicalPassports($user, 10);

		//return 'dashboard test 2';

		// $technical_cer = DB::table('vehicle_certificates')->
		// 	select(
		// 		'vehicle_certificates.id',
		// 		'vehicle_certificates.given_date as date',
		// 		'vehicle_certificates.series as tpseries',
		// 		'vehicle_certificates.number as tpnumber',
		// 		'customers.type as ownertype',
		// 		'customers.id as owner_id',
		// 		'customers.name as ownername',
		// 		'customers.lastname as ownerlastname',
		// 		'customers.middlename',
		// 		'tbl_vehicle_brands.vehicle_brand as brandname',
		// 		'tbl_vehicle_types.vehicle_type as typename',
		// 		'vehicle_certificates.total_amount',
		// 		'transport_numbers.code as tnscode',
		// 		'transport_numbers.series as tnsseries',
		// 		'transport_numbers.number as tnsnumber'
		// 	)->
		// 	join('customers', 'customers.id', '=', 'vehicle_certificates.owner_id')->
		// 	join('tbl_vehicles', 'tbl_vehicles.id', '=', 'vehicle_certificates.vehicle_id')->
		// 	join('transport_numbers', function($join){
		// 		$join->on('transport_numbers.vehicle_id', '=', 'tbl_vehicles.id')->
		// 		where('transport_numbers.status', '=', 'active');
		// 	})->
		// 	leftjoin('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
		// 	leftjoin('tbl_vehicle_types', 'tbl_vehicle_types.id', '=', 'tbl_vehicles.vehicletype_id')->
		// 	leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		// 	leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		// 	$user=Auth::User();
		// 	if($user->role != 'admin'){
		// 		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		// 		if(!empty($position)){
		// 			if($position->position == 'district'){
		// 				$i = 0;
		// 				$technical_cer = $technical_cer->where(function($query) use($user){
		// 					foreach (explode(',', $user->city_id) as $city) {
		// 						$query->orWhere('tbl_cities.id', '=', $city);
		// 					}
		// 				});
		// 			}elseif($position->position == 'country'){
		// 				$i = 0;
		// 				$technical_cer = $technical_cer->where(function($query) use($user){
		// 					foreach(explode(',', $user->state_id) as $state){
		// 						$query->orWhere('tbl_states.id','=',$state);
		// 					}
		// 				});
		// 			}elseif($position->position == 'region'){
		// 				$i = 0;
		// 				$technical_cer = $technical_cer->where(function($query) use($user){
		// 					$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
		// 					foreach ($cities as $city) {
		// 						$query->orWhere('tbl_cities.id', '=', $city->id);
		// 					}
		// 				});
		// 			}
		// 		}
		// 	}
		// $technical_cer = $technical_cer->orderBy('vehicle_certificates.id', 'desc')->skip(0)->take(10)->get()->toArray();

		$technical_cer = getCertificates($user, 10);

		//return 'dashboard test 3';

		$transport_num = DB::table('transport_numbers')->
			select(
				'transport_numbers.id',
				'transport_numbers.given_date as date',
				'customers.type as ownertype',
				'customers.id as owner_id',
				'customers.name as ownername',
				'customers.lastname as ownerlastname',
				'customers.middlename',
				'tbl_vehicle_brands.vehicle_brand as brandname',
				'tbl_vehicle_types.vehicle_type as typename',
				'transport_numbers.total_amount',
				'transport_numbers.code as tnscode',
				'transport_numbers.series as tnsseries',
				'transport_numbers.number as tnsnumber'
			)->
			join('customers', 'customers.id', '=', 'transport_numbers.owner_id')->
			join('tbl_vehicles', 'tbl_vehicles.id', '=', 'transport_numbers.vehicle_id')->
			join('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
			join('tbl_vehicle_types', 'tbl_vehicle_types.id', '=', 'tbl_vehicles.vehicletype_id')->
			leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
			leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
			$user=Auth::User();
			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$i = 0;
						$transport_num = $transport_num->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$transport_num = $transport_num->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$transport_num = $transport_num->where(function($query) use($user){
							$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('tbl_cities.id', '=', $city->id);
							}
						});
					}
				}
			}
		$transport_num = $transport_num->where('transport_numbers.status', '=', 'active')->orderBy('transport_numbers.id', 'desc')->skip(0)->take(10)->get()->toArray();


		$technical_med = DB::table('vehicle_inspections')->
			select(
				'vehicle_inspections.id',
				'vehicle_inspections.date',
				'vehicle_inspections.talonno as talon',
				'customers.type as ownertype',
				'customers.id as owner_id',
				'customers.name as ownername',
				'customers.lastname as ownerlastname',
				'customers.middlename',
				'tbl_vehicle_brands.vehicle_brand as brandname',
				'tbl_vehicle_types.vehicle_type as typename',
				'vehicle_inspections.total_amount',
				'transport_numbers.code as tnscode',
				'transport_numbers.series as tnsseries',
				'transport_numbers.number as tnsnumber'
			)->
			join('customers', 'customers.id', '=', 'vehicle_inspections.owner_id')->
			join('tbl_vehicles', 'tbl_vehicles.id', '=', 'vehicle_inspections.vehicle_id')->
			join('transport_numbers', function($join){
				$join->on('transport_numbers.vehicle_id', '=', 'tbl_vehicles.id')->
				where('transport_numbers.status', '=', 'active');
			})->
			leftjoin('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
			leftjoin('tbl_vehicle_types', 'tbl_vehicle_types.id', '=', 'tbl_vehicles.vehicletype_id')->
			leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
			leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
			$user=Auth::User();
			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$i = 0;
						$technical_med = $technical_med->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$technical_med = $technical_med->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$technical_med = $technical_med->where(function($query) use($user){
							$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('tbl_cities.id', '=', $city->id);
							}
						});
					}
				}
			}
		$technical_med = $technical_med->orderBy('vehicle_inspections.id', 'desc')->skip(0)->take(10)->get()->toArray();

		$vehicle_reg = DB::table('vehicle_registrations')->
			select(
				'vehicle_registrations.id',
				'vehicle_registrations.date',
				'customers.type as ownertype',
				'customers.id as owner_id',
				'customers.name as ownername',
				'customers.lastname as ownerlastname',
				'customers.middlename',
				'tbl_vehicle_brands.vehicle_brand as brandname',
				'tbl_vehicle_types.vehicle_type as typename',
				'vehicle_registrations.total_amount',
				'transport_numbers.code as tnscode',
				'transport_numbers.series as tnsseries',
				'transport_numbers.number as tnsnumber',
				'tbl_cities.name as cityname',
				'tbl_states.name as regionname'
			)->
			join('customers', 'customers.id', '=', 'vehicle_registrations.owner_id')->
			join('tbl_vehicles', 'tbl_vehicles.id', '=', 'vehicle_registrations.vehicle_id')->
			join('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
			join('tbl_vehicle_types', 'tbl_vehicle_types.id', '=', 'tbl_vehicles.vehicletype_id')->
			leftjoin('transport_numbers', function($join){
				$join->on('transport_numbers.vehicle_id', '=', 'tbl_vehicles.id')->
				where('transport_numbers.status', '=', 'active');
			})->
			leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
			leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
			$user=Auth::User();
			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$i = 0;
						$vehicle_reg = $vehicle_reg->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$vehicle_reg = $vehicle_reg->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$vehicle_reg = $vehicle_reg->where(function($query) use($user){
							$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('tbl_cities.id', '=', $city->id);
							}
						});
					}
				}
			}
			$vehicle_reg = $vehicle_reg->where('vehicle_registrations.action', '=', 'regged')->orderBy('vehicle_registrations.id', 'desc')->skip(0)->take(10)->get()->toArray();

		$driver_lic = getDriverLicenses($user, 10);


		$meddate = date('Y-m-d', strtotime('-365 days'));
		$medlist = DB::table('vehicle_inspections')
			->select(
				'customers.name as ownername', 
				'customers.lastname as ownerlastname', 
				'customers.middlename', 'customers.type as ownertype', 
				'tbl_vehicle_brands.vehicle_brand as brandname', 
				'vehicle_inspections.date as passeddate', 
				'tbl_vehicle_types.vehicle_type as typename', 
				'tbl_vehicles.id as vehicle_id', 
				'customers.id as owner_id', 
				'customers.city_id', 
				'vehicle_inspections.id'

			)->
			join('tbl_vehicles', 'vehicle_inspections.vehicle_id', '=', 'tbl_vehicles.id')->
			join('customers', 'vehicle_inspections.owner_id', '=', 'customers.id')->
			join('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
			join('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
			leftjoin('tbl_cities','tbl_cities.id','=','customers.city_id')->
			leftjoin('tbl_states','tbl_states.id','=','tbl_cities.state_id');

			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$i = 0;
						$medlist = $medlist->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$medlist = $medlist->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$medlist = $medlist->where(function($query) use($user){
							$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('tbl_cities.id', '=', $city->id);
							}
						});
					}
				}
			}
		$medlist = $medlist->where('vehicle_inspections.condition', '=', 'active')
			->whereDate('vehicle_inspections.date', '<', $meddate)
			->where([['vehicle_inspections.status', '=', 'pass'], ['tbl_vehicles.status', '=', 'regged']])
			->skip(0)->take(10)->get()->toArray();

		$registrationNotifications=getRegistrationNotifications();

		$count_veh = DB::table('tbl_vehicles')->
			join('customers', 'customers.id', '=', 'tbl_vehicles.owner_id')->
			where('tbl_vehicles.status', '=', 'regged');
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$count_veh = $count_veh->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('customers.city_id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$count_veh = $count_veh->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$cities = DB::table('tbl_cities')->where('state_id', '=', $state)->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('customers.city_id','=',$city->id);
							}
							
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$count_veh = $count_veh->where(function($query) use($user){
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							$query->orWhere('customers.city_id', '=', $city->id);
						}
					});
				}
			}
		}
		$count_veh = $count_veh->count();

		$owner_ph = DB::table('customers')->where('type', '=', 'physical');
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$owner_ph = $owner_ph->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('customers.city_id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$owner_ph = $owner_ph->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$cities = DB::table('tbl_cities')->where('state_id', '=', $state)->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('customers.city_id','=',$city->id);
							}
							
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$owner_ph = $owner_ph->where(function($query) use($user){
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							$query->orWhere('customers.city_id', '=', $city->id);
						}
					});
				}
			}
		}
		$owner_ph = $owner_ph->count();

		$owner_le = DB::table('customers')->where('type', '=', 'legal');
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$owner_le = $owner_le->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('customers.city_id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$owner_le = $owner_le->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$cities = DB::table('tbl_cities')->where('state_id', '=', $state)->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('customers.city_id','=',$city->id);
							}
							
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$owner_le = $owner_le->where(function($query) use($user){
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							$query->orWhere('customers.city_id', '=', $city->id);
						}
					});
				}
			}
		}
		$owner_le = $owner_le->count();

		$owners_c = $owner_le + $owner_ph;

		$staffs=DB::table('users')->where('id', '!=', $user->id);
			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$i = 0;
						foreach (explode(',', $user->city_id) as $city) {
							if($i == 0){
								$staffs = $staffs->where('city_id', '=', intval($city));
							}else{
								$staffs = $staffs->orWhere('city_id', '=', intval($city));
							}
							
							$i++;
						}
					}elseif($position->position == 'country'){
						$i = 0;
						foreach (explode(',', $user->state_id) as $state) {
							$cities = DB::table('tbl_cities')->where('state_id', '=', intval($state))->get()->toArray();
							foreach ($cities as $city) {
								if($i == 0){
									$staffs = $staffs->where('city_id', '=', intval($city->id));
								}else{
									$staffs = $staffs->orWhere('city_id', '=', intval($city->id));
								}
								
								$i++;
							}
							
						}
					}elseif($position->position == 'region'){
						$i = 0;
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							if($i == 0){
								$staffs = $staffs->where('city_id', '=', intval($city->id));
							}else{
								$staffs = $staffs->orWhere('city_id', '=', intval($city->id));
							}
							
							$i++;
						}
					}
				}
			}
		$staffs = $staffs->count();
		$supplier_c = DB::table('tbl_suppliers')->count();
	
		

        return view('dashboard.dashboard',compact(
         	'staffs',
         	'registrationNotifications', 
         	'medlist', 
         	'meddate', 
         	'vehicles', 
         	'technicalPassports', 
         	'technical_cer', 
         	'transport_num', 
         	'technical_med', 
         	'vehicle_reg', 
         	'driver_lic', 
         	'count_veh',
         	'owner_le',
         	'owner_ph',
         	'owners_c',
         	'supplier_c'
        ));
		 
    }




    public function medlist(){
    	$user = DB::table('users')->where('id','=', Auth::user()->id)->first();
    	$title = "Texnik ko'rik muddati tugagan texnikalar";
    	$meddate = date('Y-m-d', strtotime('-365 days'));
		$medlist = DB::table('vehicle_inspections')
			->select(
				'customers.name as ownername', 
				'customers.lastname as ownerlastname', 
				'customers.middlename', 'customers.type as ownertype', 
				'tbl_vehicle_brands.vehicle_brand as brandname', 
				'vehicle_inspections.date as passeddate', 
				'tbl_vehicle_types.vehicle_type as typename', 
				'tbl_vehicles.id as vehicle_id', 
				'customers.id as owner_id', 
				'customers.city_id', 
				'vehicle_inspections.id',
				'vehicle_inspections.created_at'

			)->
			join('tbl_vehicles', 'vehicle_inspections.vehicle_id', '=', 'tbl_vehicles.id')->
			join('customers', 'vehicle_inspections.owner_id', '=', 'customers.id')->
			join('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
			join('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
			leftjoin('tbl_cities','tbl_cities.id','=','customers.city_id')->
			leftjoin('tbl_states','tbl_states.id','=','tbl_cities.state_id');

			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$i = 0;
						$medlist = $medlist->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$medlist = $medlist->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$medlist = $medlist->where(function($query) use($user){
							$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('tbl_cities.id', '=', $city->id);
							}
						});
					}
				}
			}
		$medlist = $medlist->where('vehicle_inspections.condition', '=', 'active')
			->whereDate('vehicle_inspections.date', '<', $meddate)
			->where([['vehicle_inspections.status', '=', 'pass'], ['tbl_vehicles.status', '=', 'regged']])
			->latest()->paginate(50);
			return view('notification.medlist', compact('medlist', 'title'));
    }

    public function reglist(){
    	$user = DB::table('users')->where('id','=', Auth::user()->id)->first();
    	$title = "Ro'yxatdan o'tish muddati tugagan texnikalar";
		$reglist=DB::table('vehicle_registrations')
			->join('tbl_vehicles','tbl_vehicles.id','=','vehicle_registrations.vehicle_id')
			->join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicles.vehicletype_id')
			->join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')
			->join('customers','customers.id','=','vehicle_registrations.owner_id')
			->join('tbl_cities','tbl_cities.id','=','customers.city_id')
			->join('tbl_states','tbl_states.id','=','tbl_cities.state_id')
			->where('vehicle_registrations.action','=','unregged')
			->where('tbl_vehicles.status','=','unregged')
			->whereDate('vehicle_registrations.date','<',date('Y-m-d',strtotime('-10 days')))
			->select(
				'vehicle_registrations.*',
				'tbl_vehicles.modelyear',
				'tbl_vehicle_types.vehicle_type as vehicle_type',
				'tbl_vehicle_brands.vehicle_brand as vehicle_brand',
				'customers.name as owner_name',
				'customers.lastname as owner_lastname',
				'customers.middlename as owner_middlename',
				'customers.id_number',
				'customers.inn',
				'customers.city_id',
				'tbl_cities.name as city',
				'tbl_states.name as state'
			)->orderBy('vehicle_registrations.date')
			->latest()->paginate(50);
			return view('notification.reglist', compact('reglist', 'title'));
    }


	//free service modal
    public function openmodel()
    {
		$serviceid = Input::get('open_id');
		
		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
			
		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->get()->toArray();
		
		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();
		
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
		  $service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
		  $service_taxes='';
		}
		$discount = $service_tax->discount;
		
		$logo = DB::table('tbl_settings')->first();
		
		$html = view('dashboard.freeservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);
		
	}

	//paid service modal
    public function closemodel()
    {
		$serviceid = Input::get('open_id');
		
		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
		
		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->where('chargeable','=',1)
												  ->get()->toArray();
		
		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get();
		
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes="";
		}
		$discount = $service_tax->discount;
		$logo = DB::table('tbl_settings')->first();
		
		
		$html = view('dashboard.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','service_taxes','discount'))->render();
		return response()->json(['success' => true, 'html' => $html]);
		
	}
	
	//repeat service modal
    public function upmodel()
    {
		$serviceid = Input::get('open_id');
		
		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
			
		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->get()->toArray();
		
		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();
		
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes="";
		}
		$discount = $service_tax->discount;
		
		$logo = DB::table('tbl_settings')->first();
		
		
		$html = view('dashboard.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);
		
	}	
}

<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use App\tbl_vehicle_types;

use App\Http\Requests;

use DB;
use Auth;
use Illuminate\Support\Facades\Input;



class VehicleReportController extends Controller{

	public function __construct(){
        $this->middleware('auth');
    }

	//  get tables and compact

	public function exist(){   
		$state=Input::get('state');
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}elseif($position->position == 'district'){
		    $states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		//$states = DB::table('tbl_states')->where('country_id', '=', 234)->orderBy('name')->get()->toArray();
		
		$title='Mavjud texnika - hisobot';
		
		if($state){
			$state=DB::table('tbl_states')->where('id','=',$state)->first();
		}

		if($state){
			
			if($user->role == 'admin'){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'district'){
				$city_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->city_id) as $city) {
					$city_ar[$i] = intval($city);
					$i++;
				}
			    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
			} 

			$stateVehicleCount=[];  // array of numbers, count of all vehicles in one city

			$vehicleTypes=DB::table('tbl_vehicle_types')
				->get()->toArray();
			foreach($vehicleTypes as $type){
				$workingTypes=DB::table('vehicle_works_fors')
					->where('type_id','=',$type->id)
					->get()->toArray();

				$brandsCount=0;

				foreach($workingTypes as $wTKey=>$workingType){
					$brands=DB::table('tbl_vehicle_brands')
						->where('working_type_id','=',$workingType->id)
						->get()->toArray();

					$workingTypeVehicleCount=[];  // count for working type
					foreach($brands as $key => $brand){
						$brandHasVehicle=false;
						$brandVehicleCount=[];
						for($i=0; $i<count($cities); $i++){
							$vehicles=DB::table('tbl_vehicles')
								->join('customers','customers.id','=','tbl_vehicles.owner_id')
								->where('customers.city_id','=',$cities[$i]->id)
								->where('tbl_vehicles.vehiclebrand_id','=',$brand->id)
								->where('tbl_vehicles.status','=','regged')
								->count();
							$brandVehicleCount[$i]=$vehicles;

							//check if brand has any vehicle
							if(!$brandHasVehicle && $vehicles){
								$brandHasVehicle=true;
							}

							//counting vehicles for working type
							if(!isset($workingTypeVehicleCount[$i])){
								$workingTypeVehicleCount[]=$vehicles;
							}else{
								$workingTypeVehicleCount[$i]+=$vehicles;
							}

							//counting vehicles for whole city
							if(!isset($stateVehicleCount[$i])){
								$stateVehicleCount[]=$vehicles;
							}else{
								$stateVehicleCount[$i]+=$vehicles;
							}
						}

						$brand->vehicle_count=$brandVehicleCount;

						// if there is no vehicle of this brand, i will remove this brand from result
						if(!$brandHasVehicle){
							unset($brands[$key]);
						}
					}
					$brandsCount+=count($brands);
					$workingType->vehicle_brands=$brands;
					$workingType->vehicle_count=$workingTypeVehicleCount;

					// if there is no vehicle of this working type, i will remove this working type from result
					if(!count($brands)){
						unset($workingTypes[$wTKey]);
					}
				}

				$type->brands_count=$brandsCount;
				$type->working_types=$workingTypes;
			}
		}else{

		}
        return view('report.exist', compact('states','state','vehicleTypes','cities','stateVehicleCount','title', 'user', 'position', 'state_ar'));
	}

	public function ownership(){
		$form=Input::get('form');
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		$state='';
		$city='';
		$message='';
		if($form && $form=='state'){
			$state=Input::get('state');
			
			if($user->role == 'admin'){
				$states = DB::table('tbl_states')->where('country_id', '=', 234)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$state_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->state_id) as $stat) {
					$state_ar[$i] = intval($stat);
					$i++;
				}
				$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
			}
			$title='Viloyat mulkchiligi - hisobot';

			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
			}
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			if($user->role == 'admin'){
				$cities=DB::table('tbl_cities')->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$stat_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->state_id) as $stat) {
					$stat_ar[$i] = intval($stat);
					$i++;
				}
				$cities=DB::table('tbl_cities')->whereIn('state_id', $stat_ar)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$cities=DB::table('tbl_cities')->where('state_id','=', intval($user->state_id))->orderBy('name')->get()->toArray();
			}elseif($position->position == 'district'){
				$city_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->city_id) as $city) {
					$city_ar[$i] = intval($city);
					$i++;
				}
			    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
			}
			$title='Tuman / Shahar mulkchiligi - hisobot';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
			}
		}
		
		if($state || $city){
			$categories=DB::table('customer_categories')->orderBy('name')->get()->toArray();
			$totalVehicleCount=[];  // array of numbers, count of all vehicles of one category
			$vehicleTypes=DB::table('tbl_vehicle_types')
				->get()->toArray();
			foreach($vehicleTypes as $type){
				$workingTypes=DB::table('vehicle_works_fors')
					->where('type_id','=',$type->id)
					->get()->toArray();

				$brandsCount=0;

				foreach($workingTypes as $wTKey=>$workingType){
					$brands=DB::table('tbl_vehicle_brands')
						->where('working_type_id','=',$workingType->id)
						->whereExists(function($query) use($state, $city){
							$query->select('*')
								->from('tbl_vehicles')
								->join('customers','customers.id','=','tbl_vehicles.owner_id')
								->whereRaw('tbl_vehicles.vehiclebrand_id = tbl_vehicle_brands.id');

							if($state){
								$query->join('tbl_cities','tbl_cities.id','=','customers.city_id')
									->whereRaw('tbl_cities.state_id = '.$state->id);
							}elseif($city){
								$query->whereRaw('customers.city_id = '.$city->id);
							}
						})->get()->toArray();

					$workingTypeVehicleCount=[];  // count for working type
					foreach($brands as $key=>$brand){
						$brandVehicleCount=[];  // array of numbers, count of vehicles of one brand
						$vehicles=DB::table('customer_categories')
							->leftJoin('tbl_vehicles',function($join) use($brand, $state, $city){
								$join->on('tbl_vehicles.category','=','customer_categories.id')
									->join('customers','customers.id','=','tbl_vehicles.owner_id')
									->where('tbl_vehicles.vehiclebrand_id','=',$brand->id)
									->where('tbl_vehicles.status','=','regged');

								if($state){
									$join->join('tbl_cities','tbl_cities.id','=','customers.city_id')
										->where('tbl_cities.state_id','=',$state->id);
								}elseif($city){
									$join->where('customers.city_id','=',$city->id);
								}
							});

						$vehicles=$vehicles->groupBy('customer_categories.id')
							->orderBy('customer_categories.name')
							->select(DB::raw('count(tbl_vehicles.id) as count'),'customer_categories.name')
							->get()->toArray();

						// if(count($vehicles) !== count($totalVehicleCount)){
						// 	$message.='-----------';
						// 	foreach($vehicles as $asd){
						// 		$message.=$asd->name.',';
						// 	}
						// 	$message.=count($vehicles);
						// }

						for($i=0; $i<count($vehicles); $i++){

							$c=$vehicles[$i]->count;
							if(!isset($c)){
								$c=0;
							}

							$brandVehicleCount[]=$c;

							//counting vehicles for working type
							if(!isset($workingTypeVehicleCount[$i])){
								$workingTypeVehicleCount[]=$c;
							}else{
								$workingTypeVehicleCount[$i]+=$c;
							}

							//counting vehicles for whole category
							if(!isset($totalVehicleCount[$i])){
								$totalVehicleCount[]=$c;
							}else{
								$totalVehicleCount[$i]+=$c;
							}
						}

						$brand->vehicle_count=$brandVehicleCount;

					}
					$brandsCount+=count($brands);
					$workingType->vehicle_brands=$brands;
					$workingType->vehicle_count=$workingTypeVehicleCount;

					// if there is no vehicle of this working type, i will remove this working type from result
					if(!count($brands)){
						unset($workingTypes[$wTKey]);
					}
				}
				$type->brands_count=$brandsCount;
				$type->working_types=$workingTypes;
			}
		}else{

		}
	
        return view('report.ownership', compact('states','state','cities','city','form','vehicleTypes','categories','totalVehicleCount','title','vehicles','message'));
	}

	public function vehicle_age(){
		$title='Texnika yoshi - hisobot';
		$form=Input::get('form');
		$state='';
		$city='';
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($form && $form=='state'){
			$state=Input::get('state');
			
			if($user->role == 'admin'){
				$states = DB::table('tbl_states')->where('country_id', '=', 234)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$state_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->state_id) as $stat) {
					$state_ar[$i] = intval($stat);
					$i++;
				}
				$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
			}
			$title='Texnika yoshi - viloyat';

			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
				$title='Texnika yoshi - '.$state->name;
			}	
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			if($user->role == 'admin'){
				$cities=DB::table('tbl_cities')->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$stat_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->state_id) as $stat) {
					$stat_ar[$i] = intval($stat);
					$i++;
				}
				$cities=DB::table('tbl_cities')->whereIn('state_id', $stat_ar)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$cities=DB::table('tbl_cities')->where('state_id','=', intval($user->state_id))->orderBy('name')->get()->toArray();
			}elseif($position->position == 'district'){
				$city_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->city_id) as $city) {
					$city_ar[$i] = intval($city);
					$i++;
				}
			    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
			} 
			$title='Texnika yoshi - tuman/shahar';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
				$title='Texnika yoshi - '.$city->name;
			}
		}

		if($state || $city){
			$categories=DB::table('customer_categories')->orderBy('name')->get()->toArray();
			$totalVehicleCount=[0,0,0,0,0,0,0,0,0,0,0];  // array of numbers, count of all vehicles of one column
			$columns=11;
			$vehicleTypes=DB::table('tbl_vehicle_types')
				->get()->toArray();
			foreach($vehicleTypes as $type){
				$workingTypes=DB::table('vehicle_works_fors')
					->where('type_id','=',$type->id)
					->get()->toArray();

				$brandsCount=0;

				foreach($workingTypes as $wTKey=>$workingType){
					$brands=DB::table('tbl_vehicle_brands')
						->where('working_type_id','=',$workingType->id)
						->get()->toArray();

					$workingTypeVehicleCount=[];  // count for working type
					foreach($brands as $key=>$brand){
						$brandHasVehicle=false;
						$brandNumbers=[];  // array of numbers, for each column of the report
						$vehicles=DB::table('tbl_vehicles')
							->join('customers','customers.id','=','tbl_vehicles.owner_id')
							->where('tbl_vehicles.vehiclebrand_id','=',$brand->id)
							->where('tbl_vehicles.status','=','regged');

						if($state){
							$vehicles=$vehicles->join('tbl_cities','tbl_cities.id','=','customers.city_id')
								->where('tbl_cities.state_id','=',$state->id)
								->orWhere('tbl_cities.state_id',null);
						}elseif($city){
							$vehicles=$vehicles->where('customers.city_id','=',$city->id)
								->orWhere('customers.city_id',null);
						}
	
						$vehicles=$vehicles->select('tbl_vehicles.modelyear')
							->get()->toArray();

						if(count($vehicles)){
							$brandNumbers[0]=count($vehicles); // all vehicles of one brand
							$brandNumbers[1]=count(array_filter($vehicles,'filterVehiclesFirstColumn')); // count of vehicles, being used for 1-5 years
							$brandNumbers[2]=$brandNumbers[0]?round(100*$brandNumbers[1]/$brandNumbers[0],2):0; // percent of vehicles, being used for 1-5 years
							$brandNumbers[3]=count(array_filter($vehicles,'filterVehiclesSecondColumn')); // count of vehicles, produced in current year
							$brandNumbers[4]=$brandNumbers[0]?round(100*$brandNumbers[3]/$brandNumbers[0],2):0; // percent of vehicles, produced in current year
							$brandNumbers[5]=count(array_filter($vehicles,'filterVehiclesThirdColumn')); // count of vehicles, being used for 6-10 years
							$brandNumbers[6]=$brandNumbers[0]?round(100*$brandNumbers[5]/$brandNumbers[0],2):0; // percent of vehicles, being used for 6-10 years
							$brandNumbers[7]=count(array_filter($vehicles,'filterVehiclesFourthColumn')); // count of vehicles, being used for 11-15 years
							$brandNumbers[8]=$brandNumbers[0]?round(100*$brandNumbers[7]/$brandNumbers[0],2):0; // percent of vehicles, being used for 11-15 years
							$brandNumbers[9]=count(array_filter($vehicles,'filterVehiclesFifthColumn')); // count of vehicles, being used for 16-20 years
							$brandNumbers[10]=$brandNumbers[0]?round(100*$brandNumbers[9]/$brandNumbers[0],2):0; // percent of vehicles, being used for 16-20 years

							
							for($i=0; $i<count($brandNumbers); $i++){
								$c=$brandNumbers[$i];

								//counting vehicles for working type
								if(!isset($workingTypeVehicleCount[$i])){
									$workingTypeVehicleCount[]=$c;
								}else{
									$workingTypeVehicleCount[$i]+=$c;
								}

								//counting vehicles for whole category
								if(!isset($totalVehicleCount[$i])){
									$totalVehicleCount[]=$c;
								}else{
									$totalVehicleCount[$i]+=$c;
								}
							}
							$brand->vehicle_count=$brandNumbers;
						}else{
							// if there is no vehicle of this brand, i will remove this brand from result
							unset($brands[$key]);
						}
					}

					if(count($brands)){
						// adjucting percent values for counts of vehicle working type
						$workingTypeVehicleCount[2]=(isset($workingTypeVehicleCount[0]) && $workingTypeVehicleCount[0])?round(100*$workingTypeVehicleCount[1]/$workingTypeVehicleCount[0] , 2):0;
						$workingTypeVehicleCount[4]=(isset($workingTypeVehicleCount[0]) && $workingTypeVehicleCount[0])?round(100*$workingTypeVehicleCount[3]/$workingTypeVehicleCount[0] , 2):0;
						$workingTypeVehicleCount[6]=(isset($workingTypeVehicleCount[0]) && $workingTypeVehicleCount[0])?round(100*$workingTypeVehicleCount[5]/$workingTypeVehicleCount[0] , 2):0;
						$workingTypeVehicleCount[8]=(isset($workingTypeVehicleCount[0]) && $workingTypeVehicleCount[0])?round(100*$workingTypeVehicleCount[7]/$workingTypeVehicleCount[0] , 2):0;
						$workingTypeVehicleCount[10]=(isset($workingTypeVehicleCount[0]) && $workingTypeVehicleCount[0])?round(100*$workingTypeVehicleCount[9]/$workingTypeVehicleCount[0] , 2):0;

						$brandsCount+=count($brands);
						$workingType->vehicle_brands=$brands;
						$workingType->vehicle_count=$workingTypeVehicleCount;
					}else{
						// i'm gonna remove working type from result, if there is no vehicle of this working type
						unset($workingTypes[$wTKey]);
					}
				}
				$type->brands_count=$brandsCount;
				$type->working_types=$workingTypes;
			}

			// adjucting percent values for total counts 
			$totalVehicleCount[2]=(isset($totalVehicleCount[0]) && $totalVehicleCount[0]) ? round(100*$totalVehicleCount[1]/$totalVehicleCount[0] , 2):0;
			$totalVehicleCount[4]=(isset($totalVehicleCount[0]) && $totalVehicleCount[0]) ? round(100*$totalVehicleCount[3]/$totalVehicleCount[0] , 2):0;
			$totalVehicleCount[6]=(isset($totalVehicleCount[0]) && $totalVehicleCount[0]) ? round(100*$totalVehicleCount[5]/$totalVehicleCount[0] , 2):0;
			$totalVehicleCount[8]=(isset($totalVehicleCount[0]) && $totalVehicleCount[0]) ? round(100*$totalVehicleCount[7]/$totalVehicleCount[0] , 2):0;
			$totalVehicleCount[10]=(isset($totalVehicleCount[0]) && $totalVehicleCount[0]) ? round(100*$totalVehicleCount[9]/$totalVehicleCount[0] , 2):0;
		}else{

		}
		



        return view('report.vehicle-age', compact('states','state','cities','city','form','vehicleTypes','totalVehicleCount', 'categories','title','vehicles'));
	}

	public function vehicle_registration(){
		$title='Ro\'yxatga olish - hisobot';
		$form=Input::get('form');
		$state='';
		$city='';
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($form && $form=='state'){
			$state=Input::get('state');
			
			if($user->role == 'admin'){
				$states = DB::table('tbl_states')->where('country_id', '=', 234)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$state_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->state_id) as $stat) {
					$state_ar[$i] = intval($stat);
					$i++;
				}
				$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
			}
			$title='Ro\'yxatdan o\'tgan o\'tmagan - viloyat';

			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
				$title='Ro\'yxatdan o\'tgan o\'tmagan - '.$state->name;
			}

		}elseif($form && $form=='city'){
			$city=Input::get('city');
			if($user->role == 'admin'){
				$cities=DB::table('tbl_cities')->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$stat_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->state_id) as $stat) {
					$stat_ar[$i] = intval($stat);
					$i++;
				}
				$cities=DB::table('tbl_cities')->whereIn('state_id', $stat_ar)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$cities=DB::table('tbl_cities')->where('state_id','=', intval($user->state_id))->orderBy('name')->get()->toArray();
			}elseif($position->position == 'district'){
				$city_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->city_id) as $city) {
					$city_ar[$i] = intval($city);
					$i++;
				}
			    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
			} 
			$title='Texnika yoshi - tuman/shahar';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
				$title='Ro\'yxatdan o\'tgan o\'tmagan - '.$city->name;
			}
		}

		if($state || $city){
			$categories=DB::table('customer_categories')->orderBy('name')->get()->toArray();
			$totalVehicleCount=[];  // array of numbers, count of all vehicles of one column
			$columns=11;
			$vehicleTypes=DB::table('tbl_vehicle_types')
				->get()->toArray();
			foreach($vehicleTypes as $type){
				$workingTypes=DB::table('vehicle_works_fors')
					->where('type_id','=',$type->id)
					->get()->toArray();

				$brandsCount=0;

				foreach($workingTypes as $wTKey=>$workingType){
					$brands=DB::table('tbl_vehicle_brands')
						->where('working_type_id','=',$workingType->id)
						->get()->toArray();

					$workingTypeVehicleCount=[];  // count for working type
					foreach($brands as $key=>$brand){

						$brandNumbers=[];  // array of numbers, for each column of the report
						$vehicles=DB::table('tbl_vehicles')
							->leftJoin('customers','customers.id','=','tbl_vehicles.owner_id')
							->where('tbl_vehicles.vehiclebrand_id','=',$brand->id);

						if($state){
							$vehicles=$vehicles->leftJoin('tbl_cities','tbl_cities.id','=','customers.city_id')
								->where(function($query) use($state){
									$query->where('tbl_cities.state_id','=',$state->id)
										->orWhere('customers.id',null);
								});
						}elseif($city){
							$vehicles=$vehicles->where(function($query) use($city){
								$query->where('customers.city_id','=',$city->id)
									->orWhere('customers.id',null);
							});
						}
							
						$vehicles=$vehicles->select(
							'tbl_vehicles.id',
							'tbl_vehicles.type',
							'tbl_vehicles.status',
							'tbl_vehicles.condition'
						)->get()->toArray();

						if(count($vehicles)){
							$reggedVehicles=array_filter($vehicles,'filterRegisteredVehicles');
							$unreggedVehicles=array_filter($vehicles,'filterUnregisteredVehicles');

							$brandNumbers[0]=count($vehicles); // all vehicles of one brand
							$brandNumbers[1]=count($reggedVehicles); // count of registered vehicles
							$brandNumbers[2]=count(array_filter($reggedVehicles,'filterValidVehicles')); // count of registered valid vehicles
							$brandNumbers[3]=$brandNumbers[1]-$brandNumbers[2]; // count of registered invalid vehicles
							$brandNumbers[4]=count($unreggedVehicles); // count of unregistered vehicles
							$brandNumbers[5]=count(array_filter($unreggedVehicles,'filterValidVehicles')); // count of unregistered valid vehicles
							$brandNumbers[6]=$brandNumbers[4]-$brandNumbers[5]; // count of unregistered invalid vehicles
							$brandNumbers[7]=$brandNumbers[6];
							$brandNumbers[8]=0;

							for($i=0; $i<count($brandNumbers); $i++){
								$c=$brandNumbers[$i];

								//counting vehicles for working type
								if(!isset($workingTypeVehicleCount[$i])){
									$workingTypeVehicleCount[]=$c;
								}else{
									$workingTypeVehicleCount[$i]+=$c;
								}

								//counting vehicles for whole category
								if(!isset($totalVehicleCount[$i])){
									$totalVehicleCount[]=$c;
								}else{
									$totalVehicleCount[$i]+=$c;
								}
							}
							$brand->vehicle_count=$brandNumbers;
						}else{
							unset($brands[$key]);
						}

						
					}

					if(count($brands)){
						$brandsCount+=count($brands);
						$workingType->vehicle_brands=$brands;
						$workingType->vehicle_count=$workingTypeVehicleCount;
					}else{
						unset($workingTypes[$wTKey]);
					}
				}
				$type->brands_count=$brandsCount;
				$type->working_types=$workingTypes;
			}
		}else{

		}

        return view('report.vehicle-registration', compact('states','state','cities','city','form','vehicleTypes','categories','totalVehicleCount','title','vehicles'));
	}

	public function new_vehicle(){
		$form=Input::get('form');
		$state='';
		$city='';
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($form && $form=='state'){
			$state=Input::get('state');
			if($user->role == 'admin'){
				$states = DB::table('tbl_states')->where('country_id', '=', 234)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$state_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->state_id) as $stat) {
					$state_ar[$i] = intval($stat);
					$i++;
				}
				$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
			}
			$title='Yangi texnika viloyat - hisobot';

			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
			}
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			if($user->role == 'admin'){
				$cities=DB::table('tbl_cities')->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$stat_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->state_id) as $stat) {
					$stat_ar[$i] = intval($stat);
					$i++;
				}
				$cities=DB::table('tbl_cities')->whereIn('state_id', $stat_ar)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$cities=DB::table('tbl_cities')->where('state_id','=', intval($user->state_id))->orderBy('name')->get()->toArray();
			}elseif($position->position == 'district'){
				$city_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->city_id) as $city) {
					$city_ar[$i] = intval($city);
					$i++;
				}
			    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
			}
			$title='Yangi texnika Tuman / Shahar - hisobot';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
			}
		}

		$message='';
		
		if($state || $city){
			$categories=DB::table('customer_categories')->orderBy('name')->get()->toArray();
			$totalVehicleCount=[];  // array of numbers, count of all vehicles of one category
			$vehicleTypes=DB::table('tbl_vehicle_types')
				->get()->toArray();
			foreach($vehicleTypes as $vTKey=>$type){
				$workingTypes=DB::table('vehicle_works_fors')
					->where('type_id','=',$type->id)
					->get()->toArray();

				$brandsCount=0;

				foreach($workingTypes as $wTKey=>$workingType){
					$brands=DB::table('tbl_vehicle_brands')
						->where('working_type_id','=',$workingType->id)
						->whereExists(function($query) use($state, $city){
							$query->select('*')
								->from('tbl_vehicles')
								->join('customers','customers.id','=','tbl_vehicles.owner_id')
								->whereRaw('tbl_vehicles.vehiclebrand_id = tbl_vehicle_brands.id')
								->where('tbl_vehicles.modelyear','=',date('Y'));

							if($state){
								$query=$query->join('tbl_cities','tbl_cities.id','=','customers.city_id')
									->whereRaw('tbl_cities.state_id = '.$state->id);
							}elseif($city){
								$query->whereRaw('customers.city_id = '.$city->id);
							}
						})->get()->toArray();

					$workingTypeVehicleCount=[];  // count for working type
					foreach($brands as $key=>$brand){
						$brandVehicleCount=[];  // array of numbers, count of vehicles of one brand
						$vehicles=DB::table('customer_categories')
							->leftJoin('tbl_vehicles',function($join) use($brand, $state, $city){
								$join->on('tbl_vehicles.category','=','customer_categories.id')
									->join('customers','customers.id','=','tbl_vehicles.owner_id')
									->where('tbl_vehicles.vehiclebrand_id','=',$brand->id)
									->where('tbl_vehicles.status','=','regged')
									->where('tbl_vehicles.modelyear','=',date('Y'));

								if($state){
									$join->join('tbl_cities','tbl_cities.id','=','customers.city_id')
										->where('tbl_cities.state_id','=',$state->id);
								}elseif($city){
									$join->where('customers.city_id','=',$city->id);
								}
							});
	
						$vehicles=$vehicles->groupBy('customer_categories.id')
							->orderBy('customer_categories.name')
							->select(DB::raw('count(tbl_vehicles.id) as count'))
							->get()
							->toArray();

						for($i=0; $i<count($vehicles); $i++){
							$c=$vehicles[$i]->count;
							if(!isset($c)){
								$c=0;
							}

							$brandVehicleCount[]=$c;

							//counting vehicles for working type
							if(!isset($workingTypeVehicleCount[$i])){
								$workingTypeVehicleCount[]=$c;
							}else{
								$workingTypeVehicleCount[$i]+=$c;
							}

							//counting vehicles for whole category
							if(!isset($totalVehicleCount[$i])){
								$totalVehicleCount[]=$c;
							}else{
								$totalVehicleCount[$i]+=$c;
							}
						}

						$brand->vehicle_count=$brandVehicleCount;
						unset($vehicles);
					}
					$brandsCount+=count($brands);
					$workingType->vehicle_brands=$brands;
					$workingType->vehicle_count=$workingTypeVehicleCount;

					// if there is no vehicle of this working type, i will remove this working type from result
					if(!count($brands)){
						unset($workingTypes[$wTKey]);
					}
				}
				$type->brands_count=$brandsCount;
				$type->working_types=$workingTypes;

				// if there is no working type of this vehicle type, it should be removed
				if(!count($workingTypes)){
					unset($vehicleTypes[$vTKey]);
				}
			}
		}else{

		}

        return view('report.new-vehicle', compact('states','state','cities','city','form','vehicleTypes','categories','totalVehicleCount','title','vehicles','message'));
	}

	public function exist_by_category(){   
		$state=Input::get('state');
		$category=Input::get('category');
		$categories=DB::table('customer_categories')->orderBy('name')->get()->toArray();
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		$title='Mavjud texnika, kategoriya bo\'yicha - hisobot';
		
		if($state){
			$state=DB::table('tbl_states')->where('id','=',$state)->first();
		}

		if($category){
			$category=DB::table('customer_categories')->where('id',$category)->first();
			$title=$category->name.' mavjud texnika - hisobot';
		}

		if($state && $category){
			$title=$category->name.' '.$state->name.' mavjud texnika - hisobot';
			if($user->role == 'admin'){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'district'){
				$city_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->city_id) as $city) {
					$city_ar[$i] = intval($city);
					$i++;
				}
			    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
			}

			$stateVehicleCount=[];  // array of numbers, count of all vehicles in one city

			$vehicleTypes=DB::table('tbl_vehicle_types')
				->get()->toArray();
			foreach($vehicleTypes as $type){
				$workingTypes=DB::table('vehicle_works_fors')
					->where('type_id','=',$type->id)
					->get()->toArray();

				$brandsCount=0;

				foreach($workingTypes as $wTKey=>$workingType){
					$brands=DB::table('tbl_vehicle_brands')
						->where('working_type_id','=',$workingType->id)
						->get()->toArray();

					$workingTypeVehicleCount=[];  // count for working type
					foreach($brands as $key=>$brand){
						$brandHasVehicle=false;
						$brandVehicleCount=[];
						for($i=0; $i<count($cities); $i++){
							$vehicles=DB::table('tbl_vehicles')
								->join('customers','customers.id','=','tbl_vehicles.owner_id')
								->where('customers.city_id','=',$cities[$i]->id)
								->where('tbl_vehicles.vehiclebrand_id','=',$brand->id)
								->where('tbl_vehicles.category','=',$category->id)
								->count();
							$brandVehicleCount[$i]=$vehicles;

							//counting vehicles for working type
							if(!isset($workingTypeVehicleCount[$i])){
								$workingTypeVehicleCount[]=$vehicles;
							}else{
								$workingTypeVehicleCount[$i]+=$vehicles;
							}

							//counting vehicles for whole city
							if(!isset($stateVehicleCount[$i])){
								$stateVehicleCount[]=$vehicles;
							}else{
								$stateVehicleCount[$i]+=$vehicles;
							}

							//check if brand has any vehicle
							if(!$brandHasVehicle && $vehicles){
								$brandHasVehicle=true;
							}
						}
						$brand->vehicle_count=$brandVehicleCount;

						// if there is no vehicle of this brand, i will remove this brand from result
						if(!$brandHasVehicle){
							unset($brands[$key]);
						}
					}
					$brandsCount+=count($brands);
					$workingType->vehicle_brands=$brands;
					$workingType->vehicle_count=$workingTypeVehicleCount;

					// if there is no vehicle of this working type, i will remove this working type from result
					if(!count($brands)){
						unset($workingTypes[$wTKey]);
					}
				}

				$type->brands_count=$brandsCount;
				$type->working_types=$workingTypes;
			}
		}else{

		}
		



        return view('report.exist-by-category', compact('states','categories','state','category','vehicleTypes','cities','stateVehicleCount','title'));
	}

	public function income_technical_inspections(){
		$form=Input::get('form');
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		$from=Input::get('from') ? Input::get('from') : date('d-m-Y',strtotime('first day of this month'));
		$till=Input::get('till') ? Input::get('till') : date('d-m-Y');
		$fromTime=join('-',array_reverse(explode('-',$from)));
		$tillTime=join('-',array_reverse(explode('-',$till)));
		$state='';
		$city='';
		if($form && $form=='state'){
			$state=Input::get('state');
			$title='To\'lovlar viloyat - hisobot';
			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
				if($user->role == 'admin'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'country'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'region'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'district'){
					$city_ar = array(); 
					$i = 0;
					foreach (explode(',', $user->city_id) as $city) {
						$city_ar[$i] = intval($city);
						$i++;
					}
				    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
				}
				$title='Texnik ko\'rik to\'lovlar - '.$state->name;
			}
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			$title='To\'lovlar Tuman / Shahar - hisobot';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
			}
		}
		
		if($state || $city){
			if(count($cities)){
				foreach($cities as $ci){
					$numbers=[];

					$lastMonthInspections=DB::table('vehicle_inspections')
						->join('customers','customers.id','vehicle_inspections.owner_id')
						->select(
							DB::raw('count(vehicle_inspections.id) as count'),
							DB::raw('sum(vehicle_inspections.total_amount) as sum')
						)
						//->whereDate('vehicle_inspections.date','>=',date('Y-m-d',strtotime('first day of this month')))
						->whereDate('vehicle_inspections.date','>=',$fromTime)
						->whereDate('vehicle_inspections.date','<=',$tillTime)
						->where('customers.city_id','=',$ci->id)
						->first();

					$lastMonthsVehicleInspections=DB::table('vehicle_inspections')
						->join('customers','customers.id','vehicle_inspections.owner_id')
						->select(
							DB::raw('count(vehicle_inspections.id) as count'),
							DB::raw('sum(vehicle_inspections.total_amount) as sum')
						)->join('tbl_vehicles',function($join){
							$join->on('tbl_vehicles.id','=','vehicle_inspections.vehicle_id')
								->where('tbl_vehicles.type','=','vehicle');
						})
						//->whereDate('vehicle_inspections.date','>=',date('Y-m-d',strtotime('first day of this month')))
						->whereDate('vehicle_inspections.date','>=',$fromTime)
						->whereDate('vehicle_inspections.date','<=',$tillTime)
						->where('customers.city_id','=',$ci->id)
						->first();

					$lastYearInspections=DB::table('vehicle_inspections')
						->join('customers','customers.id','vehicle_inspections.owner_id')
						->select(
							DB::raw('count(vehicle_inspections.id) as count'),
							DB::raw('sum(vehicle_inspections.total_amount) as sum')
						)->whereDate('vehicle_inspections.date','>=',date('Y-01-01'))
						->where('customers.city_id','=',$ci->id)->first();


					$lastYearVehicleInspections=DB::table('vehicle_inspections')
						->join('customers','customers.id','vehicle_inspections.owner_id')
						->select(
							DB::raw('count(vehicle_inspections.id) as count'),
							DB::raw('sum(vehicle_inspections.total_amount) as sum')
						)->join('tbl_vehicles',function($join){
							$join->on('tbl_vehicles.id','=','vehicle_inspections.vehicle_id')
								->where('tbl_vehicles.type','=','vehicle');
						})->whereDate('vehicle_inspections.date','>=',date('Y-01-01'))
						->where('customers.city_id','=',$ci->id)
						->first();

					$numbers[0]=$lastMonthInspections->count;
					$numbers[1]=numberFormat($lastMonthInspections->sum,'million',4);
					$numbers[2]=$lastMonthsVehicleInspections->count;
					$numbers[3]=numberFormat($lastMonthsVehicleInspections->sum,'million',4);
					$numbers[4]=$lastMonthInspections->count - $lastMonthsVehicleInspections->count;
					$numbers[5]=numberFormat($lastMonthInspections->sum - $lastMonthsVehicleInspections->sum,'million',4);
					$numbers[6]=$lastYearInspections->count;
					$numbers[7]=numberFormat($lastYearInspections->sum,'million',4);
					$numbers[8]=$lastYearVehicleInspections->count;
					$numbers[9]=numberFormat($lastYearVehicleInspections->sum,'million',4);
					$numbers[10]=$lastYearInspections->count - $lastYearVehicleInspections->count;
					$numbers[11]=numberFormat($lastYearInspections->sum - $lastYearVehicleInspections->sum,'million',4);
					$ci->numbers=$numbers;
				}
				
			}elseif($city){

			}
		}else{

		}
		return view('report.income.technical-inspections',compact('states','state','city','cities','form','title','from','till'));
	}

	public function income_technical_passports(){
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		$form=Input::get('form');
		$from=Input::get('from') ? Input::get('from') : date('d-m-Y',strtotime('first day of this month'));
		$till=Input::get('till') ? Input::get('till') : date('d-m-Y');
		$fromTime=join('-',array_reverse(explode('-',$from)));
		$tillTime=join('-',array_reverse(explode('-',$till)));
		$state='';
		$city='';
		if($form && $form=='state'){
			$state=Input::get('state');
			$title='To\'lovlar viloyat - hisobot';
			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
				if($user->role == 'admin'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'country'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'region'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'district'){
					$city_ar = array(); 
					$i = 0;
					foreach (explode(',', $user->city_id) as $city) {
						$city_ar[$i] = intval($city);
						$i++;
					}
				    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
				}
				$title='Texnik pasport to\'lovlar - '.$state->name;
			}
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			$title='To\'lovlar Tuman / Shahar - hisobot';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
			}
		}
		
		if($state || $city){
			if(count($cities)){
				foreach($cities as $ci){
					$numbers=[];
					$lastMonthLegalPassports=DB::table('technical_passports')
						->join('customers','customers.id','technical_passports.owner_id')
						//->whereDate('technical_passports.given_date','>=',date('Y-m-d',strtotime('first day of this month')))
						->whereDate('technical_passports.given_date','>=',$fromTime)
						->whereDate('technical_passports.given_date','<=',$tillTime)
						->where('customers.type','=','legal')
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(technical_passports.id) as count'),
							DB::raw('sum(technical_passports.total_amount) as sum'),
							'technical_passports.action'
						)->groupBy('technical_passports.action')
						->orderBy('technical_passports.action')->get()->toArray();

					$lastMonthPhysicalPassports=DB::table('technical_passports')
						->join('customers','customers.id','technical_passports.owner_id')
						//->whereDate('technical_passports.given_date','>=',date('Y-m-d',strtotime('first day of this month')))
						->whereDate('technical_passports.given_date','>=',$fromTime)
						->whereDate('technical_passports.given_date','<=',$tillTime)
						->where('customers.type','=','physical')
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(technical_passports.id) as count'),
							DB::raw('sum(technical_passports.total_amount) as sum'),
							'technical_passports.action'
						)->groupBy('technical_passports.action')
						->orderBy('technical_passports.action')->get()->toArray();

					$lastYearLegalPassports=DB::table('technical_passports')
						->join('customers','customers.id','technical_passports.owner_id')
						->whereDate('technical_passports.given_date','>=',date('Y-01-01'))
						->where('customers.type','=','legal')
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(technical_passports.id) as count'),
							DB::raw('sum(technical_passports.total_amount) as sum'),
							'technical_passports.action'
						)->groupBy('technical_passports.action')
						->orderBy('technical_passports.action')->get()->toArray();

					$lastYearPhysicalPassports=DB::table('technical_passports')
						->join('customers','customers.id','technical_passports.owner_id')
						->whereDate('technical_passports.given_date','>=',date('Y-01-01'))
						->where('customers.type','=','physical')
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(technical_passports.id) as count'),
							DB::raw('sum(technical_passports.total_amount) as sum'),
							'technical_passports.action'
						)->groupBy('technical_passports.action')
						->orderBy('technical_passports.action')->get()->toArray();


					if(count($lastMonthLegalPassports)==2){
						$numbers[0]=$lastMonthLegalPassports[0]->count+$lastMonthLegalPassports[1]->count;
						$numbers[1]=$lastMonthLegalPassports[0]->sum+$lastMonthLegalPassports[1]->sum;
						$numbers[2]=$lastMonthLegalPassports[1]->count;
						$numbers[3]=$lastMonthLegalPassports[1]->sum;
					}elseif(isset($lastMonthLegalPassports[0]) && $lastMonthLegalPassports[0]->action=='give'){
						$numbers[0]=$lastMonthLegalPassports[0]->count;
						$numbers[1]=$lastMonthLegalPassports[0]->sum;
						$numbers[2]=0;
						$numbers[3]=0;
					}else{
						$numbers[0]=isset($lastMonthLegalPassports[0])?$lastMonthLegalPassports[0]->count:0;
						$numbers[1]=isset($lastMonthLegalPassports[0])?$lastMonthLegalPassports[0]->sum:0;
						$numbers[2]=isset($lastMonthLegalPassports[0])?$lastMonthLegalPassports[0]->count:0;
						$numbers[3]=isset($lastMonthLegalPassports[0])?$lastMonthLegalPassports[0]->sum:0;
					}
					
					if(count($lastYearLegalPassports)==2){
						$numbers[4]=$lastYearLegalPassports[0]->count+$lastYearLegalPassports[1]->count;
						$numbers[5]=$lastYearLegalPassports[0]->sum+$lastYearLegalPassports[1]->sum;
						$numbers[6]=$lastYearLegalPassports[1]->count;
						$numbers[7]=$lastYearLegalPassports[1]->sum;
					}elseif(isset($lastYearLegalPassports[0]) && $lastYearLegalPassports[0]->action=='give'){
						$numbers[4]=$lastYearLegalPassports[0]->count;
						$numbers[5]=$lastYearLegalPassports[0]->sum;
						$numbers[6]=0;
						$numbers[7]=0;
					}else{
						$numbers[4]=isset($lastYearLegalPassports[0])?$lastYearLegalPassports[0]->count:0;
						$numbers[5]=isset($lastYearLegalPassports[0])?$lastYearLegalPassports[0]->sum:0;
						$numbers[6]=isset($lastYearLegalPassports[0])?$lastYearLegalPassports[0]->count:0;
						$numbers[7]=isset($lastYearLegalPassports[0])?$lastYearLegalPassports[0]->sum:0;
					}
					
					if(count($lastMonthPhysicalPassports)==2){
						$numbers[8]= $lastMonthPhysicalPassports[0]->count+$lastMonthPhysicalPassports[1]->count;
						$numbers[9]= $lastMonthPhysicalPassports[0]->sum+$lastMonthPhysicalPassports[1]->sum;
						$numbers[10]=$lastMonthPhysicalPassports[1]->count;
						$numbers[11]=$lastMonthPhysicalPassports[1]->sum;
					}elseif(isset($lastMonthPhysicalPassports[0]) && $lastMonthPhysicalPassports[0]->action=='give'){
						$numbers[8]= $lastMonthPhysicalPassports[0]->count;
						$numbers[9]= $lastMonthPhysicalPassports[0]->sum;
						$numbers[10]=0;
						$numbers[11]=0;
					}else{
						$numbers[8]= isset($lastMonthPhysicalPassports[0])?$lastMonthPhysicalPassports[0]->count:0;
						$numbers[9]= isset($lastMonthPhysicalPassports[0])?$lastMonthPhysicalPassports[0]->sum:0;
						$numbers[10]=isset($lastMonthPhysicalPassports[0])?$lastMonthPhysicalPassports[0]->count:0;
						$numbers[11]=isset($lastMonthPhysicalPassports[0])?$lastMonthPhysicalPassports[0]->sum:0;
					}

					if(count($lastYearPhysicalPassports)==2){
						$numbers[12]=$lastYearPhysicalPassports[0]->count+$lastYearPhysicalPassports[1]->count;
						$numbers[13]=$lastYearPhysicalPassports[0]->sum+$lastYearPhysicalPassports[1]->sum;
						$numbers[14]=$lastYearPhysicalPassports[1]->count;
						$numbers[15]=$lastYearPhysicalPassports[1]->sum;
					}elseif(isset($lastYearPhysicalPassports[0]) && $lastYearPhysicalPassports[0]->action=='give'){
						$numbers[12]=$lastYearPhysicalPassports[0]->count;
						$numbers[13]=$lastYearPhysicalPassports[0]->sum;
						$numbers[14]=0;
						$numbers[15]=0;
					}else{
						$numbers[12]=isset($lastYearPhysicalPassports[0])?$lastYearPhysicalPassports[0]->count:0;
						$numbers[13]=isset($lastYearPhysicalPassports[0])?$lastYearPhysicalPassports[0]->sum:0;
						$numbers[14]=isset($lastYearPhysicalPassports[0])?$lastYearPhysicalPassports[0]->count:0;
						$numbers[15]=isset($lastYearPhysicalPassports[0])?$lastYearPhysicalPassports[0]->sum:0;
					}
					
					$numbers[1]=numberFormat($numbers[1],'million',4);
					$numbers[3]=numberFormat($numbers[3],'million',4);
					$numbers[5]=numberFormat($numbers[5],'million',4);
					$numbers[7]=numberFormat($numbers[7],'million',4);	
					$numbers[9]=numberFormat($numbers[9],'million',4);
					$numbers[11]=numberFormat($numbers[11],'million',4);
					$numbers[13]=numberFormat($numbers[13],'million',4);
					$numbers[15]=numberFormat($numbers[15],'million',4);			

					$ci->numbers=$numbers;
				}
				
			}elseif($city){

			}
		}else{

		}
		return view('report.income.technical-passports',compact('states','state','city','cities','form','title','from','till'));
	}

	public function income_transport_numbers(){
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}elseif($position->position == 'district'){
		    $states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		$form=Input::get('form');
		$from=Input::get('from') ? Input::get('from') : date('d-m-Y',strtotime('first day of this month'));
		$till=Input::get('till') ? Input::get('till') : date('d-m-Y');
		$fromTime=join('-',array_reverse(explode('-',$from)));
		$tillTime=join('-',array_reverse(explode('-',$till)));
		$type=Input::get('type');
		$numberTypes=explode(',',$type);
		$state='';
		$city='';
		if($form && $form=='state'){
			$state=Input::get('state');
			$title='To\'lovlar viloyat - hisobot';
			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
				if($user->role == 'admin'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'country'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'region'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'district'){
					$city_ar = array(); 
					$i = 0;
					foreach (explode(',', $user->city_id) as $city) {
						$city_ar[$i] = intval($city);
						$i++;
					}
				    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
				}
				$title='Davlat raqami to\'lovlar - '.$state->name;
			}
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			$title='To\'lovlar Tuman / Shahar - hisobot';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
			}
		}
		
		if($state || $city){
			if(count($cities)){
				foreach($cities as $ci){
					$numbers=[];
					$numberIndex=-1;

					foreach($numberTypes as $numberType){
						$lastMonthNumbers=DB::table('transport_numbers')
							->join('customers','customers.id','transport_numbers.owner_id')
							//->whereDate('transport_numbers.given_date','>=',date('Y-m-d',strtotime('first day of this month')))
							->whereDate('transport_numbers.given_date','>=',$fromTime)
							->whereDate('transport_numbers.given_date','<=',$tillTime)
							->where('customers.city_id','=',$ci->id)
							->where('transport_numbers.state_id','=',$state->id)
							->where('transport_numbers.type','=',$numberType)
							->select(
								DB::raw('count(transport_numbers.id) as count'),
								DB::raw('sum(transport_numbers.total_amount) as sum'),
								'transport_numbers.action'
							)->groupBy('transport_numbers.action')
							->orderBy('transport_numbers.action')->get()->toArray();

						$lastYearNumbers=DB::table('transport_numbers')
							->join('customers','customers.id','transport_numbers.owner_id')
							->whereDate('transport_numbers.given_date','>=',date('Y-01-01'))
							->where('customers.city_id','=',$ci->id)
							->where('transport_numbers.state_id','=',$state->id)
							->where('transport_numbers.type','=',$numberType)
							->select(
								DB::raw('count(transport_numbers.id) as count'),
								DB::raw('sum(transport_numbers.total_amount) as sum'),
								'transport_numbers.action'
							)->groupBy('transport_numbers.action')
							->orderBy('transport_numbers.action')->get()->toArray();

						$numbers[++$numberIndex]=(isset($lastMonthNumbers[0])?$lastMonthNumbers[0]->count:0) + (isset($lastMonthNumbers[1])?$lastMonthNumbers[1]->count:0);
						$numbers[++$numberIndex]=numberFormat((isset($lastMonthNumbers[0])?$lastMonthNumbers[0]->sum:0) + (isset($lastMonthNumbers[1])?$lastMonthNumbers[1]->sum:0),'million',4);
						$numbers[++$numberIndex]=(isset($lastMonthNumbers[0]) && $lastMonthNumbers[0]->action=='recover') ? $lastMonthNumbers[0]->count : (isset($lastMonthNumbers[1])?$lastMonthNumbers[1]->count:0);
						$numbers[++$numberIndex]=numberFormat((isset($lastMonthNumbers[0]) && $lastMonthNumbers[0]->action=='recover') ? $lastMonthNumbers[0]->sum : (isset($lastMonthNumbers[1])?$lastMonthNumbers[1]->sum:0),'million',4);
						$numbers[++$numberIndex]=(isset($lastYearNumbers[0])?$lastYearNumbers[0]->count:0) + (isset($lastYearNumbers[1])?$lastYearNumbers[1]->count:0);
						$numbers[++$numberIndex]=numberFormat((isset($lastYearNumbers[0])?$lastYearNumbers[0]->sum:0) + (isset($lastYearNumbers[1])?$lastYearNumbers[1]->sum:0),'million',4);
						$numbers[++$numberIndex]=(isset($lastYearNumbers[0]) && $lastYearNumbers[0]->action=='recover') ? $lastYearNumbers[0]->count : (isset($lastYearNumbers[1])?$lastYearNumbers[1]->count:0);
						$numbers[++$numberIndex]=numberFormat((isset($lastYearNumbers[0]) && $lastYearNumbers[0]->action=='recover') ? $lastYearNumbers[0]->sum : (isset($lastYearNumbers[1])?$lastYearNumbers[1]->sum:0),'million',4);

						$numbers[++$numberIndex]=0; // qoldiq
					}
					
					$ci->numbers=$numbers;
				}
				
			}elseif($city){

			}
		}else{
		}
		return view('report.income.transport-numbers',compact('states','state','city','cities','form','title','type','from','till'));
	}

	public function income_driver_exams(){
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}elseif($position->position == 'district'){
		    $states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		$form=Input::get('form');
		$from=Input::get('from') ? Input::get('from') : date('d-m-Y',strtotime('first day of this month'));
		$till=Input::get('till') ? Input::get('till') : date('d-m-Y');
		$fromTime=join('-',array_reverse(explode('-',$from)));
		$tillTime=join('-',array_reverse(explode('-',$till)));
		$state='';
		$city='';
		if($form && $form=='state'){
			$state=Input::get('state');
			$title='To\'lovlar imtihonlar viloyat - hisobot';
			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
				if($user->role == 'admin'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'country'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'region'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'district'){
					$city_ar = array(); 
					$i = 0;
					foreach (explode(',', $user->city_id) as $city) {
						$city_ar[$i] = intval($city);
						$i++;
					}
				    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
				}
				$title='Davlat raqami to\'lovlar - '.$state->name;
			}
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			$title='To\'lovlar Tuman / Shahar - hisobot';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
			}
		}
		
		if($state || $city){
			if(count($cities)){
				foreach($cities as $ci){
					$numbers=[0,0,0,0,0,0,0,0,0,0,0,0];
					$lastMonthExams=DB::table('driver_exams')
						->join('customers','customers.id','driver_exams.owner_id')
						//->whereDate('driver_exams.given_date','>=',date('Y-m-d',strtotime('first day of this month')))
						->whereDate('driver_exams.given_date','>=',$fromTime)
						->whereDate('driver_exams.given_date','<=',$tillTime)
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(driver_exams.id) as count'),
							DB::raw('sum(driver_exams.total_amount) as sum'),
							'driver_exams.type'
						)->groupBy('driver_exams.type')
						->orderBy('driver_exams.type')->get()->toArray();

					$lastYearExams=DB::table('driver_exams')
						->join('customers','customers.id','driver_exams.owner_id')
						->whereDate('driver_exams.given_date','>=',date('Y-01-01'))
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(driver_exams.id) as count'),
							DB::raw('sum(driver_exams.total_amount) as sum'),
							'driver_exams.type'
						)->groupBy('driver_exams.type')
						->orderBy('driver_exams.type')->get()->toArray();

					foreach($lastMonthExams as $lastMonthExam){
						if($lastMonthExam->type==1){
							$numbers[0]=$lastMonthExam->count;
							$numbers[1]=$lastMonthExam->sum;
						}elseif($lastMonthExam->type==2){
							$numbers[4]=$lastMonthExam->count;
							$numbers[5]=$lastMonthExam->sum;
						}elseif($lastMonthExam->type==3){
							$numbers[8]=$lastMonthExam->count;
							$numbers[9]=$lastMonthExam->sum;
						}
					}

					foreach($lastYearExams as $lastYearExam){
						if($lastYearExam->type==1){
							$numbers[2]=$lastYearExam->count;
							$numbers[3]=$lastYearExam->sum;
						}elseif($lastYearExam->type==2){
							$numbers[6]=$lastYearExam->count;
							$numbers[7]=$lastYearExam->sum;
						}elseif($lastYearExam->type==3){
							$numbers[10]=$lastYearExam->count;
							$numbers[11]=$lastYearExam->sum;
						}
					}
					
					$numbers[1]= numberFormat($numbers[1],'million',4);
					$numbers[3]= numberFormat($numbers[3],'million',4);
					$numbers[5]= numberFormat($numbers[5],'million',4);
					$numbers[7]= numberFormat($numbers[7],'million',4);	
					$numbers[9]= numberFormat($numbers[9],'million',4);
					$numbers[11]=numberFormat($numbers[11],'million',4);

					$ci->numbers=$numbers;
				}
				
			}elseif($city){

			}
		}else{
		}
		return view('report.income.driver-exams',compact('states','state','city','cities','form','title','from','till'));
	}

	public function income_certificates(){
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}elseif($position->position == 'district'){
		    $states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		$form=Input::get('form');
		$from=Input::get('from') ? Input::get('from') : date('d-m-Y',strtotime('first day of this month'));
		$till=Input::get('till') ? Input::get('till') : date('d-m-Y');
		$fromTime=join('-',array_reverse(explode('-',$from)));
		$tillTime=join('-',array_reverse(explode('-',$till)));
		$state='';
		$city='';
		if($form && $form=='state'){
			$state=Input::get('state');
			$title='To\'lovlar viloyat - hisobot';
			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
				if($user->role == 'admin'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'country'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'region'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'district'){
					$city_ar = array(); 
					$i = 0;
					foreach (explode(',', $user->city_id) as $city) {
						$city_ar[$i] = intval($city);
						$i++;
					}
				    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
				}
				$title='Texnik guvohnomalar to\'lovlar - '.$state->name;
			}
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			$title='To\'lovlar Tuman / Shahar - hisobot';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
			}
		}
		
		if($state || $city){
			if(count($cities)){
				foreach($cities as $ci){
					$numbers=[];

					$lastMonthCertificates=DB::table('vehicle_certificates')
						->join('customers','customers.id','vehicle_certificates.owner_id')
						//->whereDate('vehicle_certificates.given_date','>=',date('Y-m-d',strtotime('first day of this month')))
						->whereDate('vehicle_certificates.given_date','>=',$fromTime)
						->whereDate('vehicle_certificates.given_date','<=',$tillTime)
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(vehicle_certificates.id) as count'),
							DB::raw('sum(vehicle_certificates.total_amount) as sum'),
							'vehicle_certificates.action'
						)->groupBy('vehicle_certificates.action')
						->orderBy('vehicle_certificates.action')->get()->toArray();

					$lastYearCertificates=DB::table('vehicle_certificates')
						->join('customers','customers.id','vehicle_certificates.owner_id')
						->whereDate('vehicle_certificates.given_date','>=',date('Y-01-01'))
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(vehicle_certificates.id) as count'),
							DB::raw('sum(vehicle_certificates.total_amount) as sum'),
							'vehicle_certificates.action'
						)->groupBy('vehicle_certificates.action')
						->orderBy('vehicle_certificates.action')->get()->toArray();

					$numbers[0]=(isset($lastMonthCertificates[0])?$lastMonthCertificates[0]->count:0) + (isset($lastMonthCertificates[1])?$lastMonthCertificates[1]->count:0);
					$numbers[1]=numberFormat((isset($lastMonthCertificates[0])?$lastMonthCertificates[0]->sum:0) + (isset($lastMonthCertificates[1])?$lastMonthCertificates[1]->sum:0),'million',4);
					$numbers[2]=(isset($lastMonthCertificates[0]) && $lastMonthCertificates[0]->action=='recover') ? $lastMonthCertificates[0]->count : (isset($lastMonthCertificates[1])?$lastMonthCertificates[1]->count:0);
					$numbers[3]=numberFormat((isset($lastMonthCertificates[0]) && $lastMonthCertificates[0]->action=='recover') ? $lastMonthCertificates[0]->sum : (isset($lastMonthCertificates[1])?$lastMonthCertificates[1]->sum:0),'million',4);
					$numbers[4]=(isset($lastYearCertificates[0])?$lastYearCertificates[0]->count:0) + (isset($lastYearCertificates[1])?$lastYearCertificates[1]->count:0);
					$numbers[5]=numberFormat((isset($lastYearCertificates[0])?$lastYearCertificates[0]->sum:0) + (isset($lastYearCertificates[1])?$lastYearCertificates[1]->sum:0),'million',4);
					$numbers[6]=(isset($lastYearCertificates[0]) && $lastYearCertificates[0]->action=='recover') ? $lastYearCertificates[0]->count : (isset($lastYearCertificates[1])?$lastYearCertificates[1]->count:0);
					$numbers[7]=numberFormat((isset($lastYearCertificates[0]) && $lastYearCertificates[0]->action=='recover') ? $lastYearCertificates[0]->sum : (isset($lastYearCertificates[1])?$lastYearCertificates[1]->sum:0),'million',4);

					//$numbers[]=0; // qoldiq
					
					$ci->numbers=$numbers;
				}
				
			}elseif($city){

			}
		}else{
		}
		return view('report.income.certificates',compact('states','state','city','cities','form','title','type','from','till'));
	}

	public function income_tm1_certificates(){
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}elseif($position->position == 'district'){
		    $states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		$form=Input::get('form');
		$from=Input::get('from') ? Input::get('from') : date('d-m-Y',strtotime('first day of this month'));
		$till=Input::get('till') ? Input::get('till') : date('d-m-Y');
		$fromTime=join('-',array_reverse(explode('-',$from)));
		$tillTime=join('-',array_reverse(explode('-',$till)));
		$state='';
		$city='';
		if($form && $form=='state'){
			$state=Input::get('state');
			$title='To\'lovlar viloyat - hisobot';
			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
				if($user->role == 'admin'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'country'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'region'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'district'){
					$city_ar = array(); 
					$i = 0;
					foreach (explode(',', $user->city_id) as $city) {
						$city_ar[$i] = intval($city);
						$i++;
					}
				    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
				}
				$title='Texnik guvohnomalar to\'lovlar - '.$state->name;
			}
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			$title='To\'lovlar Tuman / Shahar - hisobot';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
			}
		}
		
		if($state || $city){
			if(count($cities)){
				foreach($cities as $ci){
					$numbers=[];

					$lastMonthCertificates=DB::table('tbl_tms')
						->join('users','users.id','=','tbl_tms.user_id')
						->where('users.city_id','=',$ci->id)
						->whereDate('tbl_tms.date','>=',$fromTime)
						->whereDate('tbl_tms.date','<=',$tillTime)
						->select(
							DB::raw('count(tbl_tms.id) as count'),
							DB::raw('sum(tbl_tms.payment) as sum')
						)->get()->toArray();

					$lastYearCertificates=DB::table('tbl_tms')
						->join('users','users.id','=','tbl_tms.user_id')
						->where('users.city_id','=',$ci->id)
						->whereDate('tbl_tms.date','>=',date('Y-01-01'))
						->select(
							DB::raw('count(tbl_tms.id) as count'),
							DB::raw('sum(tbl_tms.payment) as sum')
						)->get()->toArray();

					$numbers[0]=isset($lastMonthCertificates[0])?$lastMonthCertificates[0]->count:0;
					$numbers[1]=numberFormat((isset($lastMonthCertificates[0])?$lastMonthCertificates[0]->sum:0),'million',4);
					$numbers[2]=isset($lastYearCertificates[0])?$lastYearCertificates[0]->count:0;
					$numbers[3]=numberFormat((isset($lastYearCertificates[0])?$lastYearCertificates[0]->sum:0),'million',4);

					$ci->numbers=$numbers;
					
					// $ci->count=$numbers;
				}
				
			}elseif($city){

			}
		}else{
		}
		return view('report.income.tm-1',compact('states','state','city','cities','form','title','type','from','till'));
	}

	public function income_registrations(){
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}elseif($position->position == 'district'){
		    $states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		$action=Input::get('action');
		$from=Input::get('from') ? Input::get('from') : date('d-m-Y',strtotime('first day of this month'));
		$till=Input::get('till') ? Input::get('till') : date('d-m-Y');
		$fromTime=join('-',array_reverse(explode('-',$from)));
		$tillTime=join('-',array_reverse(explode('-',$till)));
		$state='';
		$city='';

		$state=Input::get('state');
		$title='To\'lovlar viloyat - hisobot';
		if($state){
			$state=DB::table('tbl_states')->where('id','=',$state)->first();
			if($user->role == 'admin'){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'country'){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'region'){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
			}elseif($position->position == 'district'){
				$city_ar = array(); 
				$i = 0;
				foreach (explode(',', $user->city_id) as $c) {
					$city_ar[$i] = intval($c);
					$i++;
				}
			    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
			}
			$title='Texnik guvohnomalar to\'lovlar - '.$state->name;
		}
		
		if($state && $action){
			if(count($cities)){
				foreach($cities as $ci){
					$numbers=[0,0,0,0,0,0];

					$registrations=DB::table('vehicle_registrations')
						->join('users','users.id','=','vehicle_registrations.user_id')
						->join('tbl_vehicles','tbl_vehicles.id','=','vehicle_registrations.vehicle_id')
						->join('customers', 'customers.id', '=', 'vehicle_registrations.owner_id')
						->where(function($q) use($ci, $state){
							$q->where('users.city_id','=',$ci->id)
								->orWhere('customers.city_id', '=', $ci->id);
						})->where('vehicle_registrations.action','=',$action)
						->whereDate('vehicle_registrations.date','>=',$fromTime)
						->whereDate('vehicle_registrations.date','<=',$tillTime)
						->select(
							DB::raw('count(vehicle_registrations.id) as count'),
							DB::raw('sum(vehicle_registrations.total_amount) as sum'),
							'tbl_vehicles.type'
						)->groupBy('tbl_vehicles.type')
						->orderBy('tbl_vehicles.type')
						->get()->toArray();

					foreach($registrations as $regByType){
						if($regByType->type=='agregat'){
							$numbers[0]=$regByType->count;
							$numbers[1]=numberFormat($regByType->sum,'million',4);
						}elseif($regByType->type=='tirkama'){
							$numbers[2]=$regByType->count;
							$numbers[3]=numberFormat($regByType->sum,'million',4);
						}elseif($regByType->type=='vehicle'){
							$numbers[4]=$regByType->count;
							$numbers[5]=numberFormat($regByType->sum,'million',4);
						}
					}

					$ci->numbers=$numbers;
					// $ci->count=$numbers;
				}
				
			}
		}
		return view('report.income.registrations',compact('states','state','city','cities','action','title','type','from','till','registrations'));
	}

	public function income_driver_licenses(){
		$user = Auth::user();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		if($user->role == 'admin'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->get()->toArray();
		}elseif($position->position == 'country'){
			$state_ar = array(); 
			$i = 0;
			foreach (explode(',', $user->state_id) as $stat) {
				$state_ar[$i] = intval($stat);
				$i++;
			}
			$states = DB::table('tbl_states')->whereIn('id', $state_ar)->orderBy('name')->get()->toArray();
		}elseif($position->position == 'region'){
			$states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}elseif($position->position == 'district'){
		    $states = DB::table('tbl_states')->where('id', '=', intval($user->state_id))->orderBy('name')->get()->toArray();
		}
		$form=Input::get('form');
		$from=Input::get('from') ? Input::get('from') : date('d-m-Y',strtotime('first day of this month'));
		$till=Input::get('till') ? Input::get('till') : date('d-m-Y');
		$fromTime=join('-',array_reverse(explode('-',$from)));
		$tillTime=join('-',array_reverse(explode('-',$till)));
		$state='';
		$city='';
		if($form && $form=='state'){
			$state=Input::get('state');
			$title='To\'lovlar viloyat - hisobot';
			if($state){
				$state=DB::table('tbl_states')->where('id','=',$state)->first();
				if($user->role == 'admin'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'country'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'region'){
					$cities=DB::table('tbl_cities')->where('state_id','=',$state->id)->orderBy('name')->get()->toArray();
				}elseif($position->position == 'district'){
					$city_ar = array(); 
					$i = 0;
					foreach (explode(',', $user->city_id) as $city) {
						$city_ar[$i] = intval($city);
						$i++;
					}
				    $cities=DB::table('tbl_cities')->whereIn('id', $city_ar)->orderBy('name')->get()->toArray();
				}
				$title='Traktorchi-mashinist guvohnomasi to\'lovlar - '.$state->name;
			}
		}elseif($form && $form=='city'){
			$city=Input::get('city');
			$title='To\'lovlar Tuman / Shahar - hisobot';

			if($city){
				$city=DB::table('tbl_cities')->where('id',$city)->first();
			}
		}
		
		if($state || $city){
			if(count($cities)){
				foreach($cities as $ci){
					$numbers=[];

					$lastMonthCertificates=DB::table('driver_licences')
						->join('customers','customers.id','driver_licences.owner_id')
						//->whereDate('driver_licences.given_date','>=',date('Y-m-d',strtotime('first day of this month')))
						->whereDate('driver_licences.given_date','>=',$fromTime)
						->whereDate('driver_licences.given_date','<=',$tillTime)
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(driver_licences.id) as count'),
							DB::raw('sum(driver_licences.total_amount) as sum'),
							'driver_licences.action'
						)->groupBy('driver_licences.action')
						->orderBy('driver_licences.action')->get()->toArray();

					$lastYearCertificates=DB::table('driver_licences')
						->join('customers','customers.id','driver_licences.owner_id')
						->whereDate('driver_licences.given_date','>=',date('Y-01-01'))
						->where('customers.city_id','=',$ci->id)
						->select(
							DB::raw('count(driver_licences.id) as count'),
							DB::raw('sum(driver_licences.total_amount) as sum'),
							'driver_licences.action'
						)->groupBy('driver_licences.action')
						->orderBy('driver_licences.action')->get()->toArray();

					$numbers[0]=(isset($lastMonthCertificates[0])?$lastMonthCertificates[0]->count:0) + (isset($lastMonthCertificates[1])?$lastMonthCertificates[1]->count:0);
					$numbers[1]=numberFormat((isset($lastMonthCertificates[0])?$lastMonthCertificates[0]->sum:0) + (isset($lastMonthCertificates[1])?$lastMonthCertificates[1]->sum:0),'million',4);
					$numbers[2]=(isset($lastMonthCertificates[0]) && $lastMonthCertificates[0]->action=='recover') ? $lastMonthCertificates[0]->count : (isset($lastMonthCertificates[1])?$lastMonthCertificates[1]->count:0);
					$numbers[3]=numberFormat((isset($lastMonthCertificates[0]) && $lastMonthCertificates[0]->action=='recover') ? $lastMonthCertificates[0]->sum : (isset($lastMonthCertificates[1])?$lastMonthCertificates[1]->sum:0),'million',4);
					$numbers[4]=(isset($lastYearCertificates[0])?$lastYearCertificates[0]->count:0) + (isset($lastYearCertificates[1])?$lastYearCertificates[1]->count:0);
					$numbers[5]=numberFormat((isset($lastYearCertificates[0])?$lastYearCertificates[0]->sum:0) + (isset($lastYearCertificates[1])?$lastYearCertificates[1]->sum:0),'million',4);
					$numbers[6]=(isset($lastYearCertificates[0]) && $lastYearCertificates[0]->action=='recover') ? $lastYearCertificates[0]->count : (isset($lastYearCertificates[1])?$lastYearCertificates[1]->count:0);
					$numbers[7]=numberFormat((isset($lastYearCertificates[0]) && $lastYearCertificates[0]->action=='recover') ? $lastYearCertificates[0]->sum : (isset($lastYearCertificates[1])?$lastYearCertificates[1]->sum:0),'million',4);

					//$numbers[]=0; // qoldiq
					
					$ci->numbers=$numbers;
				}
				
			}elseif($city){

			}
		}else{
		}
		return view('report.income.driver-licenses',compact('states','state','city','cities','form','title','type','from','till'));
	}

	public function income_latest(){
		$currentUser=Auth::user();
		$currentRole=DB::table('tbl_accessrights')->where('id','=',$currentUser->role)->first();
		$currentPosition=$currentRole ? $currentRole->position : null;
		$state=Input::get('state');
		$city=Input::get('city');
		$from=Input::get('from') ? Input::get('from') : date('d-m-Y',strtotime('first day of this month'));
		$till=Input::get('till') ? Input::get('till') : date('d-m-Y');
		$user=Input::get('user');

		$title='So\'ngi tushumlar';

		if($currentUser->role=='admin' || $currentRole->position == 'country'){
			$states = DB::table('tbl_states')->where('country_id', '=', 234)->orderBy('name')->get()->toArray();

			if($state=='all'){
				$cities=$cities=DB::table('tbl_cities')->get()->toArray();
			}elseif($state){
				$cities=DB::table('tbl_cities')->where('state_id','=',$state)->get()->toArray();
			}
		}elseif($currentRole->position=='region'){
			$state = str_replace(',','',$currentUser->state_id);
			$cities=DB::table('tbl_cities')->where('state_id','=',$state)->get()->toArray();
		}elseif($currentRole->position=='district'){
			$state = str_replace(',','',$currentUser->state_id);
			// if(empty($city)){
			// 	$city=$currentUser->city_id;
			// }
			$cities=DB::table('tbl_cities')->where('state_id','=',$state)->whereIn('id',explode(',',$currentUser->city_id))->orderBy('name')->get()->toArray();
		}
		
		$paymentServices=[
			['table'=>'technical_passports','date'=>'given_date'],
			['table'=>'vehicle_inspections','date'=>'date'],
			['table'=>'vehicle_certificates','date'=>'given_date'],
			['table'=>'driver_licences','date'=>'given_date'],
			['table'=>'driver_exams','date'=>'given_date'],
			['table'=>'transport_numbers','date'=>'given_date'],
			['table'=>'vehicle_registrations','date'=>'date'],
			['table'=>'tbl_tms','date'=>'date']
		];
		$payments=[];

		foreach($paymentServices as $service){
			$query=null;
			$query=DB::table($service['table'])
				->join('users','users.id','=',$service['table'].'.user_id')
				->join('customers','customers.id','=',$service['table'].'.owner_id');

			if($city && $city!=='all'){
				$query=$query->where(function($query) use($city){
					$query->whereRaw('FIND_IN_SET(?,users.city_id)',[$city]);
						//->orWhere('users.city_id','=',0);
				});
				//$query=$query->where('users.id','=',$currentUser->id);
			}elseif($state && $state!=='all'){
				$query=$query->whereRaw('FIND_IN_SET(?,users.state_id)',[$state]);
			}

			if($user){
				$query=$query->where('users.id','=',$user);
			}

			if($from || $till){
				$fromTime=join('-',array_reverse(explode('-',$from)));
				$tillTime=join('-',array_reverse(explode('-',$till)));

				if($fromTime){
					$query=$query->whereDate($service['table'].'.'.$service['date'],'>=',$fromTime);
				}
				
				if($tillTime){
					$query=$query->whereDate($service['table'].'.'.$service['date'],'<=',$tillTime);
				}
				
			}
			
			$query=$query->select(
				$service['table'].'.*',
				$service['table'].'.'.$service['date'].' as date',
				'users.name as username',
				'users.lastname as user_lastname',
				'users.city_id as city_id',
				'users.state_id as state_id', 
				'customers.city_id as customer_city_id',
				'customers.name as owner_name',
				'customers.middlename as owner_middlename',
				'customers.lastname as owner_lastname'
			)->get()->toArray();

			foreach($query as $payment){
				$paymentType=$service['table'];
				$link='';

				if($service['table']=='technical_passports'){
					if($payment->action=='give'){
						$paymentType='Texnik pasport berilgan';
					}elseif($payment->action=='recover'){
						$paymentType='Texnik pasport qayta tiklangan';
					}
					$link='/vehicle/technical-passport/preview?id='.$payment->id.'&details=true';
				}elseif($service['table']=='vehicle_inspections'){
					$paymentType='Texnik ko\'rik';
					$link='/technical-inspections/preview?id='.$payment->id;
				}elseif($service['table']=='vehicle_certificates'){
					if($payment->action=='give'){
						$paymentType='Texnik guvohnoma berilgan';
					}elseif($payment->action=='recover'){
						$paymentType='Texnik guvohnoma qayta tiklangan';
					}
					$link='/certificate/preview?id='.$payment->id.'&details=true';
				}elseif($service['table']=='driver_licences'){
					if($payment->action=='give'){
						$paymentType='Traktorchi-mashinist guvohnomasi berilgan';
					}elseif($payment->action=='recover'){
						$paymentType='Traktorchi-mashinist guvohnomasi qayta tiklangan';
					}elseif($payment->action=='update'){
						$paymentType='Traktorchi-mashinist guvohnomasi yangilangan';
					}
					$link='/driver-licence/preview?id='.$payment->id.'&details=true';
				}elseif($service['table']=='driver_exams'){
					$paymentType='Haydovchilik imtihoni';
					$link='/driver-exam/list/preview?id='.$payment->id;
				}elseif($service['table']=='transport_numbers'){
					if($payment->action=='give'){
						$paymentType='Davlat raqami belgisi berilgan';
					}elseif($payment->action=='recover'){
						$paymentType='Davlat raqami belgisi qayta tiklangan';
					}
					$link='/vehicle/transport-number/preview?id='.$payment->id.'&details=true';
				}elseif($service['table']=='vehicle_registrations'){
					if($payment->action=='regged'){
						$paymentType='Texnika ro\'yxatga qo\'yilgan';
					}elseif($payment->action=='unregged'){
						$paymentType="Texnika ro'yxatdan chiqarilgan";
					}
					$link='/vehicle/list/view/'.$payment->vehicle_id.'/'.getCurrentOwnerCityId($payment->vehicle_id);
				}elseif($service['table']=='tbl_tms'){
					$paymentType='TM-1 ma\'lumotnoma berilgan';
					$link='/vehicle/list/view/'.$payment->vehicle_id.'/'.getCurrentOwnerCityId($payment->vehicle_id);
				}

				if(isset($payment->vehicle_id)){
					$vehicle=getVehicle($payment->vehicle_id);
					if(!empty($vehicle)){
						$payment->vehicle=$vehicle->vehicle_type.' - '.$vehicle->vehicle_brand;
						$payment->customer_city_id=$vehicle->city_id;
					}
				}

				$payment->payment_type=$paymentType;
				$payment->link=$link;

				$payments[]=$payment;
			}
		}

		//sorting payments array by date
		usort($payments,'compareIncomeEntries');

		return view('report.income.latest',compact('title','payments','from','till','user','state','city','states','cities','currentPosition','currentUser'));
	}

	public function generate_full_report(){
		$filename='report.csv';
		$currentUser=Auth::user();
		$currentRole=DB::table('tbl_accessrights')->where('id','=',$currentUser->role)->first();
		$currentPosition=$currentRole ? $currentRole->position : null;

		$now = gmdate("D, d M Y H:i:s");
	    // header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    // header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    // header("Last-Modified: {$now} GMT");

	    // // force download  
	    // header("Content-Type: application/force-download");
	    // header("Content-Type: application/octet-stream");
	    // header("Content-Type: application/download");

	    // // disposition / encoding on response body
	    //header("Content-Disposition: attachment;filename={$filename}");
	    // header("Content-Transfer-Encoding: binary");
		$states = DB::table('tbl_states')->orderBy('tbl_states.name')->get()->toArray();
		$count = 0;
		$stateId = Input::get('state');

	    if($stateId){
	    	$fieldsToSelect = [
	    		'tbl_vehicles.*',
	    		'tbl_vehicle_types.vehicle_type as name',
	    		'tbl_vehicle_brands.vehicle_brand as brand',
	    		'customers.name as owner_name',
	    		'customers.middlename as owner_middlename',
	    		'customers.lastname as owner_lastname',
	    		'customers.inn',
	    		'customers.address',
	    		'ownership_forms.name as ownership_form',
	    		'tbl_cities.name as city',
	    		'tbl_colors.color',
	    		'vehicle_factories.name as factory',
	    		'transport_numbers.code as n_code',
	    		'transport_numbers.number as n_number',
	    		'transport_numbers.series as n_series',
	    		'transport_numbers.type as n_type',
	    		'transport_numbers.given_date as n_date',
	    		'vehicle_registrations.date as reg_date',
	    		'vehicle_certificates.given_date as cert_date',
	    		'vehicle_certificates.series as cert_series',
	    		'vehicle_certificates.number as cert_number',
	    		'technical_passports.given_date as passport_date',
	    		'technical_passports.series as passport_series',
	    		'technical_passports.number as passport_number',
	    		'lock.date as lock_date',
	    		'lock.order_number as lock_number',
	    		'unlock.date as unlock_date',
	    		'unlock.order_number as unlock_number'
	    	];

	    	$vehicles=DB::table('tbl_vehicles')
	    		->join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicles.vehicletype_id')
	    		->join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')
	    		->leftJoin('vehicle_factories', 'vehicle_factories.id', '=', 'tbl_vehicles.factory_id')
	    		->leftJoin('tbl_colors', 'tbl_colors.id', '=', 'tbl_vehicles.color_id')
	    		->leftJoin('transport_numbers', function($join){
	    			$join->on('transport_numbers.vehicle_id', '=', 'tbl_vehicles.id')
	    				->where('transport_numbers.status','=','active');
	    		})
	    		->join('customers',function($join){
	    			$join->on('customers.id','=','tbl_vehicles.owner_id')
	    				->join('ownership_forms', 'ownership_forms.id', '=', 'customers.form')
	    				->join('tbl_cities','tbl_cities.id','=','customers.city_id');
	    		})
	    		->join('vehicle_registrations', function($join){
	    			$join->on('vehicle_registrations.vehicle_id', '=', 'tbl_vehicles.id')
	    				->where('vehicle_registrations.status', '=', 'active');
	    		})
	    		->leftJoin('vehicle_certificates', function($join){
	    			$join->on('vehicle_certificates.vehicle_id', '=', 'tbl_vehicles.id')
	    				->where('vehicle_certificates.status', '=', 'active');
	    		})
	    		->leftJoin('technical_passports', function($join){
	    			$join->on('technical_passports.vehicle_id', '=', 'tbl_vehicles.id')
	    				->where('technical_passports.status', '=', 'active');
	    		})
	    		->leftJoin('vehicle_prohibitions AS lock', function($join){
	    			$join->on('lock.vehicle_id', '=', 'tbl_vehicles.id')
	    				->where('lock.action', '=', 'lock');
	    		})
	    		->leftJoin('vehicle_prohibitions AS unlock', function($join){
	    			$join->on('unlock.vehicle_id', '=', 'tbl_vehicles.id')
	    				->where('unlock.action', '=', 'unlock');
	    		});


	    	$vehicles = $vehicles
	    		->where('tbl_cities.state_id', '=', $stateId)
	    		->where('tbl_vehicles.status','=','regged');
	    	
	    	$vehicles = $vehicles->select($fieldsToSelect)->get()->toArray();

	    	foreach($vehicles as $vehicle){
	    		// $lastRegistration=getLastRegistration($vehicle);
	    		// $lastRegistration=[];
	    		// $vehicle->reg_date=$lastRegistration ? $lastRegistration->date : '';

	    		// if($vehicle->type=='agregat'){
	    		// 	$certificate=getActiveCertificate($vehicle->id);
	    		// 	if(!empty($certificate)){
	    		// 		$vehicle->cert_date=$certificate->given_date;
	    		// 		$vehicle->cert_series=$certificate->series;
	    		// 		$vehicle->cert_number=$certificate->number;
	    		// 	}
	    		// }else{
	    		// 	$techPassport=getActiveTechPassport($vehicle->id);
	    		// 	if(!empty($techPassport)){
	    		// 		$vehicle->passport_date=$techPassport->given_date;
	    		// 		$vehicle->passport_series=$techPassport->series;
	    		// 		$vehicle->passport_number=$techPassport->number;
	    		// 	}
	    		// }

	    		// prohibition
	    		// $vehicle->lock_status='';
	    		// $vehicle->lock_date='';
	    		// $vehicle->lock_number='';
	    		// $lastProhibitionLock=getLastProhibition($vehicle, 'lock');
	    		// if(!empty($lastProhibitionLock)){
	    		// 	$vehicle->lock_status='Taqiqqa olindi';
	    		// 	$vehicle->lock_date=$lastProhibitionLock->date;
	    		// 	$vehicle->lock_number=$lastProhibitionLock->order_number;
	    		// }

	    		// $vehicle->unlock_status='';
	    		// $vehicle->unlock_date='';
	    		// $vehicle->unlock_number='';
	    		// $lastProhibitionUnlock=getLastProhibition($vehicle, 'unlock');
	    		// if(!empty($lastProhibitionUnlock)){
	    		// 	$vehicle->unlock_status='Taqiqdan yechildi';
	    		// 	$vehicle->unlock_date=$lastProhibitionUnlock->date;
	    		// 	$vehicle->unlock_number=$lastProhibitionUnlock->order_number;
	    		// }

	    		// prohibition by court
	    		$vehicle->court_lock_letter_no='';
	    		$vehicle->court_lock_letter_date='';
	    		$vehicle->court_lock_order_no='';
	    		$vehicle->court_lock_order_date='';
	    		// if(!empty($lastProhibitionLock) && $lastProhibitionLock->locker_id==1){  // 1 is id of 'Sud ijrochilari'
	    		// 	$vehicle->court_lock_letter_no=$lastProhibitionLock->letter_number;
	    		// 	$vehicle->court_lock_letter_date=$lastProhibitionLock->letter_date;
	    		// 	$vehicle->court_lock_order_no=$lastProhibitionLock->order_number;
	    		// 	$vehicle->court_lock_order_date=$lastProhibitionLock->order_date;
	    		// }

	    			$vehicle->lock_status = ($vehicle->lock_date && $vehicle->lock_number) ? 'Taqiqqa olindi' : '';
	    			$vehicle->unlock_status = ($vehicle->unlock_date && $vehicle->unlock_number) ? 'Taqiqdan yechildi' : '';
	    	}

	    	$count = count($vehicles);
	    }

		

		// ob_start();
		// $df = fopen("php://output", 'w');
		// fputcsv($df, array_keys(reset($array)));
		// $array=['a','b','c'];
	    // foreach ($vehicles as $row) {
	        //fputcsv($df, $array);
	    // }
	    // fclose($df);
	    // echo ob_get_clean();
	    // die();
	    return  view('report.full-report',compact('states', 'vehicles', 'stateId', 'count'));
	}

	public function view(){
		$state = Input::get('state');
		return $state;
	}

}
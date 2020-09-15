<?php

//use Illuminate\Http;
use Illuminate\Http\Request;
use App\DxaRequest;
use App\MibRequest;
use App\Customer;
use App\tbl_vehicles;
use App\tbl_cities;
use App\tbl_states;
use App\vehicle_certificates;
use App\vehicle_prohibitions;
use App\TechnicalPassport;
use App\TransportNumber;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request){
    return $request->user();
});

Route::get('/', function(){
	return json_encode(['message'=>'You are requesting API server of Agrotech system']);
});

Route::post('/get_info', function(Request $request){
	header("Content-Type: application/json");
	$requestorIp = $_SERVER['REMOTE_ADDR'];
	//try {
		// METHOD 1

		$errorMessages = [];

		$application_id=$request->application_id;
		$def_no=$request->def_no;
		$entity_tin=$request->tin;
		$pnfl=$request->pnfl;
		$entity_name=$request->entity_name;
		$entity_opf_id=$request->entity_opf_id;
		$entity_registration_number=$request->entity_registration_number;
		$entity_registration_date=$request->entity_registration_date;
		$lik_basis=$request->lik_basis;
		$lik_begin_date=$request->lik_begin_date;
		$concl_num=$request->concl_num;
		$concl_date=$request->concl_date;
		$conclusion_file_url=$request->conclusion_file_url;
		$center_name=$request->center_name;
		$name_employee=$request->name_employee;
		$lik_inn=$request->lik_inn;
		$lik_tel=$request->lik_tel;
		$lik_fio=$request->lik_fio;
		$lik_pinfl=$request->lik_pinfl;
		$lik_passport_sn=$request->lik_passport_sn;
		$lik_passport_num=$request->lik_passport_num;
		$lik_country=$request->lik_country;

		// FIELDS OF OTHER METHODS
		$method_type = $request->method_type;


		// fields that can come with different name in different methods, in that case a am going to take what comes
		if($request->entity_tin){
			$entity_tin = $request->entity_tin;
		}
		if($request->basis){
			$lik_basis = $request->basis;
		}
		if($request->date){
			$lik_begin_date = $request->date;
		}
		if($request->file_url){
			$conclusion_file_url = $request->file_url;
		}
		if($request->lik_tin){
			$lik_inn = $request->lik_tin;
		}
		if($request->opf_id){
			$entity_opf_id = $request->opf_id;
		}

		// Detecting method
		if(!$method_type){
			// 1 or 5
			if($lik_inn){
				$method=1;
			}else{
				$method=5;
			}
		}else{
			if($lik_inn){
				// method 2 || 3 || 4
				if($method_type==1) $method=2;
				if($method_type==2) $method=3;
				if($method_type==3) $method=1; // this is actually 4th method, due to that they are nearly the same, the first method will respond
			}else{
				if($method_type==1) $method=6; // this should be 6 here
				if($method_type==2) $method=7; // this should be 7 here
				if($method_type==3) $method=8; // this should be 8 here
			}
		}

		// validating required fields
		$validationFailedResponse = [
			'result_code'=>2,
			'result_message'=>'Kerakli punktlar to\'ldirilmagan',
			'ip' => $requestorIp
		];

		if($method==5){
			if(!($application_id && $entity_tin && $entity_name && $center_name && $name_employee)){
				return response()->json($validationFailedResponse);
			}
		}elseif($method==6 || $method==7 || $method==8){
			if(!($application_id && $entity_tin && $entity_name)){
				return response()->json($validationFailedResponse);
			}
		}else{
			if(!($application_id && $entity_tin && $entity_name && $center_name && $name_employee && $lik_fio && $lik_inn && $lik_passport_sn && $lik_passport_num)){
				return response()->json($validationFailedResponse);
			}
		}
		
		// PREPARE entity registration date
		if($entity_registration_date){
			$ar = explode('.', $entity_registration_date);
			if(count($ar)==3){
				$entity_registration_date = $ar[2].'-'.$ar[1].'-'.$ar[0];
			}else{
				$errorMessages[]= "'entity_registration_date' maydonchasida xato formatdagi ma'lumot: ".$entity_registration_date;
			}
		}

		$req = new DxaRequest;

		$req->method = $method;
		$req->application_id = $application_id;
		$req->def_no = $def_no;
		$req->method_type = $method_type;
		$req->entity_inn = $entity_tin;
		$req->pnfl=$pnfl;
		$req->entity_name=$entity_name;
		$req->entity_opf_id=$entity_opf_id;
		$req->entity_registration_number=$entity_registration_number;
		$req->entity_registration_date = $entity_registration_date;
		$req->basis = $lik_basis;
		$req->begin_date = $lik_begin_date;
		$req->concl_num = $concl_num;
		$req->concl_date = $concl_date;
		$req->concl_file_url = $conclusion_file_url;
		$req->center_name = $center_name;
		$req->name_employee = $name_employee;
		$req->lik_inn = $lik_inn;
		$req->lik_tel = $lik_tel;
		$req->lik_fio = $lik_fio;
		$req->lik_pinfl = $lik_pinfl;
		$req->lik_passport_sn = $lik_passport_sn;
		$req->lik_passport_num = $lik_passport_num;
		$req->lik_country = $lik_country;

		$req->recieved_at = date('Y-m-d H:i:s');
		$req->status = 0; // recieved
		$req->requestor_ip = $requestorIp;

		if($method==1){
			$result = 0;
			$message = "Likvidatsiya jarayoni to'g'risida xabarnoma qabul qilindi, javobni kuting";

			$response = [
				'application_id' => $application_id,
				'name' => $entity_name,
				'inn' => $entity_tin,
				'address' => '',
				'objects' => []
			];

			// automatic finding
			$customer = Customer::where('inn', '=', $entity_tin)->first();
			if(!empty($customer)){
				$city = tbl_cities::where('id', '=', $customer->city_id)->first();
				$state = tbl_states::where('id', '=', $city->state_id)->first();

				$transports=tbl_vehicles::join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicles.vehicletype_id')
					->join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')
					->leftJoin('transport_numbers',function($join){
						$join->on('transport_numbers.vehicle_id','=','tbl_vehicles.id')
						->where('transport_numbers.status','=','active');
					})->where('tbl_vehicles.owner_id',$customer->id)
					->groupBy('tbl_vehicles.id')
					->select(
						'tbl_vehicles.*',
						'tbl_vehicles.type as main_type',
						'tbl_vehicle_types.vehicle_type as type',
						'tbl_vehicle_brands.vehicle_brand as model',
						'transport_numbers.series as series',
						'transport_numbers.number as number',
						'transport_numbers.code as code'
					)->get();
				foreach($transports as $transport){
					if($transport->main_type=='agregat'){
						$certificate=vehicle_certificates::where('vehicle_id','=',$transport->id)
							->where('owner_id','=',$transport->owner_id)
							->where('status','=','active')
							->first();
						$transport->passport_series=$certificate?$certificate->series:'';
						$transport->passport_number=$certificate?$certificate->number:'';
						$transport->pass_note = $certificate?$certificate->note:'';
					}else{
						$passport=TechnicalPassport::where('vehicle_id','=',$transport->id)
							->where('owner_id','=',$transport->owner_id)
							->where('status','=','active')
							->first();
						$transport->passport_series=empty($passport)?'':$passport->series;
						$transport->passport_number=empty($passport)?'':$passport->number;
						$transport->pass_note = empty($passport)?'':$passport->note;
					}



					$object = [
						'number' => $transport->code.' '.$transport->series.$transport->number,
						'model' => $transport->model,
						'p_series' => $transport->passport_series.$transport->passport_number,
						'p_given_date' => $passport ? date('d.m.Y', strtotime($passport->given_date)) : 'berilmagan',
						'p_given_by' => $state->name.' '.$city->name,
						'produced_year' => $transport->modelyear,
						'type' => $transport->type,
						'chassis_no' => $transport->chassis_no,
						'engine_no' => $transport->engineno,
						'note' => empty($transport->pass_note)?'XXX':$transport->pass_note,
						'prohibition'=>[
							'pr_status' => 'taqiqqa olinmagan',
							'pr_date' => '',
							'pr_by' => ''
						]
					];

					$response['objects'][] = $object;
				}
			}

			$req->response = json_encode($response, JSON_UNESCAPED_UNICODE);
		}elseif($method == 2){
			// cancel request
			$requestToCancel = DxaRequest::where('entity_inn', '=', $req->entity_inn)
				->where('method', '=', 1)->first();

			if(!empty($requestToCancel)){
				$requestToCancel->status = 3;
				if($requestToCancel->save()){
					$result = 0;
					$message = "Likvidatsiya jarayonini to'xtatish bajarildi";
				}else{
					$result = -1;
					$message = "Likvidatsiya jarayonini to'xtatish bajarilmadi";
				}
			}else{
				$result = -1;
				$message = "Likvidatsiya jarayonini to'xtatish bajarilmadi: Kiritilgan ma'lumotlar bilan likvidatsiya qilish to'g'risida xabarnoma topilmadi, qaytadan urinib ko'ring";
			}

			$req->status = 4; // finished
		}elseif($method == 3){
			// change likvidator
			$requestToUpdate = DxaRequest::where('entity_inn', '=', $req->entity_inn)
				->where('method', '=', 1)
				->where('status','!=', 4) // it has to be unfinished
				->first();

			if(!empty($requestToUpdate)){
				$requestToUpdate->center_name = $center_name;
				$requestToUpdate->name_employee = $name_employee;
				$requestToUpdate->lik_inn = $lik_inn;
				$requestToUpdate->lik_tel = $lik_tel;
				$requestToUpdate->lik_fio = $lik_fio;
				$requestToUpdate->lik_pinfl = $lik_pinfl;
				$requestToUpdate->lik_passport_sn = $lik_passport_sn;
				$requestToUpdate->lik_passport_num = $lik_passport_num;
				$requestToUpdate->lik_country = $lik_country;

				if($requestToUpdate->save()){
					$result = 0;
					$message = "Likvidatorni o'zgartirish bajarildi";
				}else{
					$result = -1;
					$message = "Likvidatorni o'zgartirish bajarilmadi";
				}
			}else{
				$result = -1;
				$message = "Likvidatorni o'zgartirish bajarilmadi: Kiritilgan ma'lumotlar bilan likvidatsiya qilish to'g'risida xabarnoma topilmadi, qaytadan urinib ko'ring";
			}

			$req->status = 4; // finished
		}elseif($method == 5){
			// finish liquidation
			$requestToUpdate = DxaRequest::where('entity_inn', '=', $req->entity_inn)
				->where('method', '=', 1)
				->whereIn('status', [2, 4]) // it has to be sent or finished <- ?
				->first();

			if(!empty($requestToUpdate)){
				$requestToUpdate->status = 4;

				// do other stuffs, that should be done when liquidation has ended
				// change status of particular customer, to 'liquidated'
				Customer::where('inn', '=', $entity_tin)->update(['status'=>2]);

				if($requestToUpdate->save()){
					$result = 0;
					$message = "Likvidatsiya jarayoni yakunlanganligi tasdiqlandi";
				}else{
					$result = -1;
					$message = "Likvidatsiya jarayonini yakunlash bajarilmadi: Xatolik";
				}
			}else{
				$result = -1;
				$message = "Likvidatsiya jarayonini yakunlash bajarilmadi: Kiritilgan ma'lumotlar bilan likvidatsiya qilish to'g'risida xabarnoma topilmadi, qaytadan urinib ko'ring";
			}

			$req->status = 4; // finished
		}elseif($method == 6){
			// change status of subject to 'inactive'
			$requestToUpdate = DxaRequest::where('entity_inn', '=', $req->entity_inn)
				->where('method', '=', 1)
				->whereIn('status', [2, 4]) // it has to be sent or finished <- ?
				->first();

			if(!empty($requestToUpdate)){
				$requestToUpdate->status = 4;

				// do other stuffs, that should be done when subject moved to "inactive" status
				// change status of particular customer, to 'inactive'
				$s2 = Customer::where('inn', '=', $entity_tin)->update(['status'=>0]);

				$s1 = $requestToUpdate->save();

				if($s1 && $s2){
					$result = 0;
					$message = "Tadbirkorlik subyekti harakatsiz rejimga o'tkazildi";
				}else{
					$result = -1;
					$message = "Tadbirkorlik subyektini harakatsiz rejimga o'tkazish bajarilmadi: Xatolik";
				}

				$req->center_name = $requestToUpdate->center_name;
			}else{
				$result = -1;
				$message = "Tadbirkorlik subyektini harakatsiz rejimga o'tkazish bajarilmadi: Berilgan STIR bilan tadbirkorlik subyekti topilmadi, qaytadan urinib ko'ring";
			}

			$req->status = 4; // finished
		}elseif($method == 7){
			// recover status of subject to 'active'
			$requestToUpdate = DxaRequest::where('entity_inn', '=', $req->entity_inn)
				->where('method', '=', 1)
				->whereIn('status', [2, 4]) // it has to be sent or finished <- ?
				->first();

			// do other stuffs, that should be done when subject moved to "inactive" status
			// change status of particular customer, to 'inactive'
			$s1 = Customer::where('inn', '=', $entity_tin)->update(['status'=>1]);

			if($s1){
				$result = 0;
				$message = "Tadbirkorlik subyekti aktiv holatga qaytarildi";
			}else{
				$result = -1;
				$message = "Tadbirkorlik subyekti aktiv holatga qaytarilmadi: Berilgan STIR bilan tadbirkorlik subyekti topilmadi, qaytadan urinib ko'ring";
			}

			$req->center_name = $requestToUpdate ? $requestToUpdate->center_name : '';

			$req->status = 4; // finished
		}elseif($method == 8){
			// remove subject from registers

			// do other stuffs, that should be done when subject to be removed from register
			// change status of particular customer, to 'removed'
			$s1 = Customer::where('inn', '=', $entity_tin)->update(['status'=>3]);

			if($s1){
				$result = 0;
				$message = "Tadbirkorlik subyekti ro'yxatdan o'chirilganligi tasdiqlandi";
			}else{
				$result = -1;
				$message = "Tadbirkorlik subyekti ro'yxatdan o'chirilganligi tasdiqlanmadi: Berilgan STIR bilan tadbirkorlik subyekti topilmadi, qaytadan urinib ko'ring";
			}

			$req->status = 4; // finished
		}else{
			return response()->json([
				'result_code' => -1,
				'result_message' => 'Method not found'
			]);
		}

		$autoResponse=[
			'result_code' => $result,
			'result_message' => $message
		];

		$req->auto_response = json_encode($autoResponse);

		// if error response was sent
		if($result == -1){
			$req->status = 5;
		}

		$s = $req->save();
		
		return response()->json($autoResponse);
	// } catch (Exception $e) {
	// 	return json_encode([
	// 		'result_code' => -1,
	// 		'result_message' => $e
	// 	]);
	// }

	
	//return print_r($request);
	//return json_encode($request->application_id);
});

// WEB-SERVICES FOR MIB

// METHOD 1: Getting information about properties of a particular owner
Route::post('/mib/get_info', function(Request $request){
	header("Content-Type: application/json");
	$requestorIp = $_SERVER['REMOTE_ADDR'];

	$inn=$request->inn_debtor;
	$pinfl=$request->pinfl_debtor;
	$customer_name=$request->fio_debtor;
	$customer_passport_sn = trim($request->passport_sn);
	$customer_passport_num = trim($request->passport_num);
	$property_number = $request->property_number;
	$card_number = $request->card_number;


	// validating required fields
	$validationFailedResponse = [
		'result_code'=>43,
		'result_message'=>'Kerakli punktlar to\'ldirilmagan'
	];

	if(!(($customer_passport_sn && $customer_passport_num) || $pinfl || $inn)){
		return response()->json($validationFailedResponse);
	}

	$req = new MibRequest;

	$req->method = 1;
	$req->inn_debtor = $inn;
	$req->pinfl_debtor = $pinfl;
	$req->fio_debtor = $customer_name;
	$req->passport_sn = $customer_passport_sn;
	$req->passport_num = $customer_passport_num;
	$req->property_number = $property_number;
	$req->card_number = $card_number;

	$req->created_at = date('Y-m-d H:i:s');
	$req->status = 0; // accepted
	$req->requestor_ip = $requestorIp;

	$message = "xabarnoma qabul qilindi";

	// automatic finding
	$customer = Customer::where('status', '=', 1);
	
	if($inn){
		$customer = $customer->where('inn', '=', $inn);
	}
	if($customer_passport_sn && $customer_passport_num){
		$customer = $customer->where('passport_series', '=', $customer_passport_sn)->where('passport_number', '=', $customer_passport_num);
	}
	if($pinfl){
		$customer = $customer->where('id_number', '=', $pinfl);
	}
	
	$customer = $customer->join('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')
		->join('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id')
		->select(
			'customers.*',
			'tbl_cities.name as city',
			'tbl_states.name as state'
		)->first();

	if(empty($customer)){
		$response = [
			'result_code' => 43,
			'result_message' => 'Berilgan ma\'lumotlar bilan mulk egasi topilmadi'
		];
		$req->status = 2; // error
	} else {
		$response = [
			'result_code' => 0,
			'result_message' => $message,
			'debtor_address' => $customer->state . ', ' . $customer->city . ', ' . $customer->address
		];

		if($customer->type == 'legal'){
			$response['debtor_inn'] = $customer->inn;
			$response['debtor_name'] = $customer->name;
		}else if($customer->type == 'physical'){
			$response['passport_sn'] = $customer->passport_series;
			$response['passport_num'] = $customer->passport_number;
			$response['fio_debtor'] = trim($customer->lastname . ' ' . $customer->name . ' ' . $customer->middlename);
			$response['pinfl_debtor'] = $customer->id_number;
		}

		$transports=tbl_vehicles::where('status', '=', 'regged')
			->join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')
			->join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicle_brands.vehicle_id')
			->where('tbl_vehicles.owner_id',$customer->id)
			->groupBy('tbl_vehicles.id')
			->select(
				'tbl_vehicles.*',
				'tbl_vehicles.type as main_type',
				'tbl_vehicle_types.vehicle_type as type',
				'tbl_vehicle_brands.vehicle_brand as model'
			)->get();

		$response['property_info'] = [];
		foreach($transports as $transport){
			// primary info
			$property = [
				'property_name' => $transport->type,
				'property_model' => $transport->model,
 				'property_produced_year' => $transport->modelyear,
				'property_chassis_num' => $transport->chassis_no,
				'property_engine_num' => $transport->engineno,
				'property_note' => "",
				'ban' => []
			];


			// DOCS
			// Davlat raqami belgisi
			$number = TransportNumber::where('vehicle_id', '=', $transport->id)
				->where('status', '=', 'active')
				->first();
			$property['property_number'] = empty($number) ? '-' : ($number->code.' '.$number->series.$number->number);

			// Texnika hujjati (tex-pasport|guvohnoma)
			if($transport->main_type=='agregat'){
				$certificate=vehicle_certificates::where('vehicle_id','=',$transport->id)
					->join('users', 'users.id', '=', 'vehicle_certificates.user_id')
					->where('owner_id','=',$transport->owner_id)
					->where('status','=','active')
					->select(
						'vehicle_certificates.*',
						'users.branch_name'
					)->first();
				$property['property_pass_sn'] = $certificate ? $certificate->series : '';
				$property['property_pass_num'] = $certificate?$certificate->number:'';
				$property['property_pass_date'] = $certificate ? date('Y-d-m', strtotime($certificate->given_date)) : '';
				$property['property_pass_give'] = ($certificate && $certificate->branch_name) ? $certificate->branch_name : $customer->state . ', ' . $customer->city;
			} else {
				$passport=TechnicalPassport::where('vehicle_id','=',$transport->id)
					->join('users', 'users.id', '=', 'technical_passports.user_id')
					->where('owner_id','=',$transport->owner_id)
					->where('status','=','active')
					->select(
						'technical_passports.*',
						'users.branch_name'
					)->first();
				$property['property_pass_sn'] = $passport ? $passport->series : '';
				$property['property_pass_num'] = $passport?$passport->number:'';
				$property['property_pass_date'] = $passport ? date('Y-d-m', strtotime($passport->given_date)) : '';
				$property['property_pass_give'] = ($passport && $passport->branch_name) ? $passport->branch_name : ($customer->state . ', ' . $customer->city);
			}

			// ban
			$bans = vehicle_prohibitions::where('action', '=', 'lock')
				->where('status', '=', 'active')
				->where('vehicle_id', '=', $transport->id)
				->where('owner_id', '=', $customer->id)
				->join('vehicle_lockers', 'vehicle_lockers.id', '=', 'vehicle_prohibitions.locker_id')
				->select(
					'vehicle_prohibitions.*',
					'vehicle_lockers.name as locker'
				)->get();

			foreach($bans as $ban){
				$banBy = $ban->locker;
				if($ban->locker_id == 9){
					$banRequest = MibRequest::where('method', '=', 2)
						->where('doc_number', '=', $ban->order_number)
						->where('status', '=', 1) // success
						->first();
					if(!empty($banRequest)){
						$banBy = $banRequest->branch_name . ", " . $banRequest->inspector_fio;
					}
				}
				$property['ban'][] = [
					'ban_id' => $ban->id,
					'ban_date' => date('Y-d-m', strtotime($ban->date)),
					'ban_by' => $banBy,
					'ban_info' => "Ijro ish raqami: " . $ban->order_number . "; Ijro ish sanasi: " . date('Y-d-m', strtotime($ban->order_date))
				];
			}

			$response['property_info'][] = $property;
		}
	}
	$req->status = 1;
	$req->response = json_encode($response, JSON_UNESCAPED_UNICODE);

	$s = $req->save();
	if(!$s){
		return response()->json([
			'result_code' => 2,
			'result_message' => 'So\'rovnomani qabul qilishda tizim xatoligi'
		]);
	}
	
	return response()->json($response);
});

// METHOD 2: Request to Lock property of a particular owner
Route::post('/mib/lock', function(Request $request){
	header("Content-Type: application/json");
	$requestorIp = $_SERVER['REMOTE_ADDR'];

	$doc_number = $request->doc_number;
	$doc_outgoing_date = $request->doc_outgoing_date;
	$branch_name = $request->branch_name;
	$inspector_fio = $request->inspector_fio;
	$property_pass_info = $request->property_pass_info ? trim($request->property_pass_info) : "";
	$property_pass_num = $request->property_pass_num ? trim($request->property_pass_num) : "";
	$property_number = $request->property_number;
	$card_number = $request->card_number;

	// validating
	$validationFailedResponse = [
		'result_code'=>43,
		'result_message'=>'Kerakli punktlar to\'ldirilmagan'
	];
	$dateValidationFailedResponse = [
		'result_code' => 43,
		'result_message' => 'Sana formati noto\'g\'ri kiritilgan'
	];

	// PREPARE doc date
	$ar = explode('-', $doc_outgoing_date);
	if($doc_outgoing_date && count($ar)==3){
		$doc_outgoing_date = $ar[0].'-'.$ar[2].'-'.$ar[1];
	}else {
		return response()->json($dateValidationFailedResponse);
	}

	if(!($doc_number && $branch_name && ($property_number || ($property_pass_info && $property_pass_num)) && $inspector_fio)){
		return response()->json($validationFailedResponse);
	}

	// checking existance of prohibition entity with given doc number
	$request = vehicle_prohibitions::where('action', '=', 'lock')
		->where('locker_id', '=', 9)
		->where('order_number', '=', $doc_number)
		->first();
	if(!empty($request)){
		$existanceFailedResponse = [
			'result_code' => 3,
			'result_message' => 'Bu hujjat bilan taqiq o\'rnatilgan. Taqiq ID: ' . $request->id
		];
		return response()->json($existanceFailedResponse);
	}

	$req = new MibRequest;

	$req->method = 2;
	$req->doc_number = $doc_number;
	$req->doc_outgoing_date = $doc_outgoing_date;
	$req->branch_name = $branch_name;
	$req->inspector_fio = $inspector_fio;
	$req->property_pass_info = $property_pass_info;
	$req->property_pass_num = $property_pass_num;
	$req->property_number = $property_number;
	$req->card_number = $card_number;

	$req->created_at = date('Y-m-d H:i:s');
	$req->status = 0; // accepted
	$req->requestor_ip = $requestorIp;

	$message = "Mulk taqiqqa olindi";

	// finding property
	$product = tbl_vehicles::where('status', '=', 'regged');

	if($property_pass_info && $property_pass_num){
		$doc = TechnicalPassport::where('status', '=', 'active')
			->where('series', '=', $property_pass_info)
			->where('number', '=', $property_pass_num)
			->first();
		if(empty($doc)){
			$doc = vehicle_certificates::where('status', '=', 'active')
				->where('series', '=', $property_pass_info)
				->where('number', '=', $property_pass_num)
				->first();
		}
	}
	
	if(empty($doc) && $property_number){
		$doc = TransportNumber::where('status', '=', 'active')
			->where(DB::raw("CONCAT(UPPER(transport_numbers.code), UPPER(transport_numbers.series),  UPPER(transport_numbers.number))"), '=', $property_number)
			->first();
	}

	if(empty($doc)){
		$response = [
			'result_code' => 43,
			'result_message' => 'Berilgan ma\'lumotlar bilan mulk egasi topilmadi'
		];
		$req->status = 2; // error
	} else {
		// creating ban
		$ban = new vehicle_prohibitions;
		$ban->owner_id = $doc->owner_id;
		$ban->vehicle_id = $doc->vehicle_id;
		$ban->locker_id = 9; // MIB
		$ban->date = date('Y-m-d');
		$ban->action = 'lock';
		$ban->status = 'active';
		$ban->order_number = $doc_number;
		$ban->order_date = $doc_outgoing_date;
		$ban->letter_number = $doc_number;
		$ban->letter_date = $doc_outgoing_date;
		$ban->created_at = date('Y-m-d H:i:s');

		$saveBan = $ban->save();

		$updateVehicle = tbl_vehicles::where('id', '=', $doc->vehicle_id)->update([
			'lock_status'=>'lock',
			'updated_at'=>date('Y-m-d H:i:s')
		]);

		if($saveBan && $updateVehicle){
			$response = [
				'ban_id' => $ban->id,
				'result_code' => 0,
				'result_message' => $message
			];
		}else{
			$response = [
				'result_code' => 2,
				'result_message' => "Taqiqqa olishda tizim xatoligi"
			];
		}
	}

	$req->status = 1; // finished
	$req->response = json_encode($response, JSON_UNESCAPED_UNICODE);

	$s = $req->save();
	if(!$s){
		return response()->json([
			'result_code' => 2,
			'result_message' => 'So\'rovnomani qabul qilishda tizim xatoligi'
		]);
	}
	
	return response()->json($response);
});

// METHOD 3: Request to unLock property of a particular owner
Route::post('/mib/unlock', function(Request $request){
	header("Content-Type: application/json");
	$requestorIp = $_SERVER['REMOTE_ADDR'];

	$ban_id = $request->ban_id;
	$doc_number = $request->doc_number;
	$doc_outgoing_date = $request->doc_outgoing_date;
	$branch_name = $request->branch_name;
	$inspector_fio = $request->inspector_fio;

	// validating required fields
	$validationFailedResponse = [
		'result_code'=>43,
		'result_message'=>'Kerakli punktlar to\'ldirilmagan'
	];

	// PREPARE doc date
	if($doc_outgoing_date){
		$ar = explode('-', $doc_outgoing_date);
		if(count($ar)==3){
			$doc_outgoing_date = $ar[0].'-'.$ar[2].'-'.$ar[1];
		}
	}

	if(!($ban_id && $branch_name && $inspector_fio)){
		return response()->json($validationFailedResponse);
	}

	$req = new MibRequest;

	$req->method = 3;
	$req->ban_id = $ban_id;
	$req->doc_number = $doc_number;
	$req->doc_outgoing_date = $doc_outgoing_date;
	$req->branch_name = $branch_name;
	$req->inspector_fio = $inspector_fio;

	$req->created_at = date('Y-m-d H:i:s');
	$req->status = 0; // accepted
	$req->requestor_ip = $requestorIp;

	$message = "Mulk taqiqdan yechildi";

	// finding product
	$product = tbl_vehicles::where('status', '=', 'regged');

	$ban = vehicle_prohibitions::where('action', '=', 'lock')
		->where('id', '=', $ban_id)
		->where('locker_id', '=', 9)
		->first();

	if(empty($ban)){
		$response = [
			'result_code' => 43,
			'result_message' => 'Berilgan id bilan taqiqqa olish ma\'lumotlari topilmadi'
		];
		$req->status = 2; // error
	} else {
		// updating old lock entity
		$ban->status = 'inactive';
		$ban->save();

		// creating new unlock entity
		$unBan = new vehicle_prohibitions;
		$unBan->owner_id = $ban->owner_id;
		$unBan->vehicle_id = $ban->vehicle_id;
		$unBan->locker_id = 9; // MIB
		$unBan->date = date('Y-m-d');
		$unBan->action = 'unlock';
		$unBan->status = 'active';
		$unBan->order_number = $doc_number;
		$unBan->order_date = $doc_outgoing_date;
		$unBan->letter_number = $doc_number;
		$unBan->letter_date = $doc_outgoing_date;
		$unBan->created_at = date('Y-m-d H:i:s');

		$saveUnBan = $unBan->save();

		// updating vehicle
		// finding active lock entities
		$vehicleProhibitions = vehicle_prohibitions::where('status', '=', 'active')
			->where('action', '=', 'lock')
			->get();

		// if not any found, we are unlocking vehicle 
		if(empty($vehicleProhibitions)){
			$updateVehicle = tbl_vehicles::where('id', '=', $doc->vehicle_id)->update([
				'lock_status'=>'unlock',
				'updated_at'=>date('Y-m-d H:i:s')
			]);
		}
		

		if($saveUnBan){
			$response = [
				'ban_id' => $ban->id,
				'result_code' => 0,
				'result_message' => $message
			];
		}else{
			$response = [
				'result_code' => 2,
				'result_message' => "Taqiqdan chiqarishda tizim xatoligi"
			];
		}
	}

	$req->status = 1; // finished
	$req->response = json_encode($response, JSON_UNESCAPED_UNICODE);

	$s = $req->save();
	if(!$s){
		return response()->json([
			'result_code' => 2,
			'result_message' => 'So\'rovnomani qabul qilishda tizim xatoligi'
		]);
	}
	
	return response()->json($response);
});

Route::get('/password/bcrypt', function (Request $request){
	return bcrypt($request->password);
});
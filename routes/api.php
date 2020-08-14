<?php

//use Illuminate\Http;
use Illuminate\Http\Request;
use App\DxaRequest;
use App\Customer;
use App\tbl_vehicles;
use App\tbl_cities;
use App\tbl_states;
use App\vehicle_certificates;
use App\TechnicalPassport;

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

Route::get('/password/bcrypt', function (Request $request){
	return bcrypt($request->password);
});
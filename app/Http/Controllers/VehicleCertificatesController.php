<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\tbl_vehicle_types;
use App\tbl_vehicle_brands;
use App\tbl_fuel_types;
use App\tbl_model_names;
use App\tbl_colors;
use App\tbl_vehicles;
use App\tbl_vehicle_discription_records;
use App\tbl_vehicle_images;
use App\tbl_vehicle_colors;
use App\vehicle_factories;
use App\vehicle_works_fors;
use App\vehicle_lockers;
use App\vehicle_prohibitions;
use App\vehicle_certificates;
use App\vehicle_inspections;
use App\vehicle_registrations;
use App\TransportNumber;
use App\TechnicalPassport;
use App\tbl_payment_types;
use App\tbl_activities;
use App\Http\Requests;

use DB;

use URL;

use Auth;

use DateTime;

use Illuminate\Support\Facades\Input;



/**

 * 

 */

class VehicleCertificatesController extends Controller

{
	function __construct()
	{
		$this->middleware('auth');
	}
	public function list()
	{
	 	$certificates = DB::table('vehicle_certificates')->
	 	select('customers.name as ownername', 'tbl_vehicle_types.vehicle_type as typename', 'vehicle_certificates.id', 'vehicle_certificates.status', 'vehicle_certificates.given_date as givendate', 'vehicle_certificates.series', 'vehicle_certificates.number')->
	 	join('tbl_vehicles', 'vehicle_certificates.vehicle_id', '=', 'tbl_vehicles.id')->
	 	join('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
		join('customers', 'tbl_vehicles.owner_id', '=', 'customers.id')->
	 	get()->toArray();
	 	return view('certificate.list', compact('certificates'));
	}
	public function index()
	{
	 	$title="Texnik guvohnoma berish";
	 	$doc='certificate';
	 	$seriesNumber=generateSeriesNumber('vehicle_certificates');
	 	$payment_r = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_cer'], ['code', '=', 'rec']])->get()->toArray();
		$payment_n = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_cer'], ['code', '=', 'new']])->get()->first();
		$min = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
	 	$vehicle_id=Input::get('vehicle_id');
	 	$documents=DB::table('documents')->where('service','=','certificate')->orderBy('name')->get()->toArray();
	 	if($vehicle_id){
	 		$vehicle=DB::table('tbl_vehicles')->where('id','=',$vehicle_id)->first();
	 		$customer=DB::table('customers')
	 			->join('ownership_forms','ownership_forms.id','=','customers.form')
	 			->where('customers.id',$vehicle->owner_id)
	 			->select('customers.*','ownership_forms.name as ownership_form')
	 			->first();
	 	}

	 	return view('technical-passport.form', compact('title','doc','seriesNumber','vehicle','customer', 'min', 'payment_n', 'payment_r','documents'));

	}

	public function addstore(Request $request)
	{
	 	$owner = Input::get('owner_id');
	 	$vehicle = Input::get('vehicle_id');
	 	$action = Input::get('action');
	 	$series = Input::get('series');
	 	$number = Input::get('number');
	 	$totalpayment = Input::get('totalpayment');
	 	$paymentdate = Input::get('paymentdate');
	 	$givendate = Input::get('givendate');
	 	$paidamount = Input::get('paidamount');
	 	$orderno = Input::get('orderno');
	 	$discount = Input::get('discount');
	 	if (($totalpayment-$paidamount-$discount)>0) {
	 		$paymentstatus = 'partial';
	 	}elseif($paidamount==0){
	 		$paymentstatus = 'due';
	 	}else{
	 		$paymentstatus = 'paid';
	 	}
	 	$certificate = new vehicle_certificates;
	 	$certificate->vehicle_id = $vehicle;
	 	$certificate->status = $action;
	 	$certificate->doc=Input::get('source-doc');
	 	$certificate->series = $series;
	 	$certificate->number = $number;
	 	$certificate->total_amount = $totalpayment;
	 	$certificate->payment_date = $paymentdate;
	 	$certificate->given_date = $givendate;
	 	$certificate->paid_amount = $paidamount;
	 	$certificate->orderno = $orderno;
	 	$certificate->payment_status = $paymentstatus;
	 	$certificate->discount = $discount;
	 	$certificate->save();
	 	return redirect('/certificate/list')->with('message','Successfully Submitted');
	}



	public function edit($id)
	{
		$certificate = DB::table('vehicle_certificates')->where('id', '=', $id)->get()->first();
		$owner = DB::table('customers')->where('id', '=', $certificate->owner_id)->get()->first();
		$vehicle = DB::table('tbl_vehicles')->where('id', '=', $certificate->vehicle_id)->get()->first();
		$type = DB::table('tbl_vehicle_types')->where('id', '=', $vehicle->vehicletype_id)->get()->first();
		return view('certificate.edit', compact('certificate', 'owner', 'vehicle', 'type'));
	}



	public function update($id)
	{
		$owner = Input::get('owner_id');
	 	$vehicle = Input::get('vehicle_id');
	 	$action = Input::get('action');
	 	$series = Input::get('series');
	 	$number = Input::get('number');
	 	$totalpayment = Input::get('totalpayment');
	 	$paymentdate = Input::get('paymentdate');

	 	$givendate = Input::get('givendate');

	 	$paidamount = Input::get('paidamount');

	 	$orderno = Input::get('orderno');

	 	$discount = Input::get('discount');

	 	if (($totalpayment-$paidamount-$discount)>0) {

	 		$paymentstatus = 'partial';

	 	}elseif($paidamount==0){

	 		$paymentstatus = 'due';

	 	}else{

	 		$paymentstatus = 'paid';

	 	}



	 	$certificate = vehicle_certificates::find($id);

	 	$certificate->vehicle_id = $vehicle;

	 	$certificate->status = $action;

	 	$certificate->series = $series;

	 	$certificate->number = $number;

	 	$certificate->total_amount = $totalpayment;

	 	$certificate->payment_date = $paymentdate;

	 	$certificate->given_date = $givendate;

	 	$certificate->paid_amount = $paidamount;

	 	$certificate->orderno = $orderno;

	 	$certificate->payment_status = $paymentstatus;

	 	$certificate->discount = $discount;

	 	$certificate->save();

	 	return redirect('/certificate/list')->with('message','Successfully Updated');

	}



	public function delete($id)
	{

		DB::table('vehicle_certificates')->where('id', '=', $id);

		return redirect('/certificate/list')->with('message','Successfully Deleted');

	}



	public function lockedit($id)
	{

	 	$lock = DB::table('vehicle_prohibitions')->where('id', '=', $id)->get()->first();

	 	$vehicle = DB::table('tbl_vehicles')->where('tbl_vehicles.id', '=', $lock->vehicle_id)->get()->first();

		$owner = DB::table('customers')->where('id', '=', $vehicle->owner_id)->get()->first();

		$type = DB::table('tbl_vehicle_types')->where('id', '=', $vehicle->vehicletype_id)->get()->first();

		$lockers = DB::table('vehicle_lockers')->get()->toArray();

		return view('vehicle.lockedit', compact('owner', 'vehicle', 'lock', 'type', 'lockers'));

	}

	public function lockupdate($id)
	{

	 	$vehicle_id = Input::get('vehicle_id');

		$letterdate = Input::get('letterdate');

		$letterno = date('Y-m-d', strtotime(Input::get('letterno')));

		$orderdate = date('Y-m-d', strtotime(Input::get('orderdate')));

		$orderno = Input::get('orderno');

		$action = Input::get('action');

		$locker = Input::get('locker');

		$date = date('Y-m-d', strtotime(Input::get('date')));

		$lock = vehicle_prohibitions::find($id);

		$lock->vehicle_id = $vehicle_id;

		$lock->action = $action;

		$lock->order_number = $orderno;

		$lock->letter_number = $letterno;

		$lock->letter_date = $letterdate;

		$lock->order_date = $orderdate;

		$lock->locker_id = $locker;

		$lock->date = $date;

		$lock->save();



		return redirect('/vehicle/vehicle_lock')->with('message','Successfully Updated');

	}

	public function lockdelete($id)
	{

     	DB::table('vehicle_prohibitions')->where('id','=',$id)->delete();

     	return redirect('/vehicle/vehicle_lock')->with('message','Successfully Deleted');

	}

	public function medlist()
	{
		$from=Input::get('from');
		$till=Input::get('till');
		$meds = DB::table('vehicle_inspections')->
		select(
			'customers.name as ownername', 
			'customers.lastname as ownerlastname', 
			'customers.middlename', 
			'customers.type as ownertype',
			'customers.id as owner_id', 
			'tbl_vehicle_types.vehicle_type as typename', 
			'vehicle_inspections.id', 
			'vehicle_inspections.status', 
			'vehicle_inspections.date as givendate', 
			'vehicle_inspections.talonno', 
			'vehicle_inspections.created_at',
			'tbl_vehicle_brands.vehicle_brand as brandname', 
			'transport_numbers.series', 
			'transport_numbers.number', 
			'transport_numbers.code', 
			'transport_numbers.status as tns', 
			'vehicle_inspections.total_amount',
			'tbl_payment_types.name as inspection_type',
			'tbl_vehicles.type as vehicle'
		)->
	 	join('tbl_vehicles', 'vehicle_inspections.vehicle_id', '=', 'tbl_vehicles.id')->
	 	join('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
	 	join('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
	 	leftjoin('transport_numbers', function($join){
			$join->on('tbl_vehicles.id', '=', 'transport_numbers.vehicle_id')->
			where('transport_numbers.status', '=', 'active');
		})->
		join('customers', 'tbl_vehicles.owner_id', '=', 'customers.id')->
		join('tbl_payment_types','tbl_payment_types.id','=','vehicle_inspections.type')->
		leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$meds = $meds->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$meds = $meds->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$meds = $meds->where(function($query) use($user){
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							$query->orWhere('tbl_cities.id', '=', $city->id);
						}
					});
				}
			}
		}
		$meds = $meds->where('vehicle_inspections.condition', '=', 'active')->orderBy('vehicle_inspections.id', 'desc');

		if($from && $till){
			$fromTime=join('-',array_reverse(explode('-',$from)));
			$tillTime=join('-',array_reverse(explode('-',$till)));
			$timeField='vehicle_inspections.date';
			$meds=$meds->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}

		$meds=$meds->latest()->paginate(50);

	 	$datetime1 = new DateTime(date('d-m-Y'));

	 	foreach ($meds as $med) {

	 		$datetime2 = new DateTime(date('d-m-Y', strtotime($med->givendate)));

	 		$interval = $datetime1->diff($datetime2);

	 		$med->diff = $interval->format('%a');

	 	}

	 	$title = "Texnik korik";

		return view('certificate.medlist', compact('meds', 'title','from','till'));

	}

	public function technical_inspection_preview(){
		$title="Texnik ko'rik";
		$inspectionId=Input::get('id');
		if($inspectionId){
			$transportNumber=DB::table('vehicle_inspections')
				->join('tbl_vehicles','tbl_vehicles.id','=','vehicle_inspections.vehicle_id')
				->join('vehicle_works_fors','vehicle_works_fors.id','=','tbl_vehicles.working_for_id')
				->leftJoin('tbl_fuel_types','tbl_fuel_types.id','=','tbl_vehicles.fuel_id')
				->join('customers','customers.id','=','vehicle_inspections.owner_id')
				->join('tbl_cities','tbl_cities.id','=','customers.city_id')
				->join('tbl_states','tbl_states.id','=','tbl_cities.state_id')
				->where('vehicle_inspections.id','=',$inspectionId)
				->select(
					'vehicle_inspections.*',
					'tbl_vehicles.modelyear',
					'tbl_vehicles.corpusno',
					'tbl_vehicles.chassisno',
					'tbl_vehicles.engineno',
					'tbl_vehicles.condition',
					'tbl_vehicles.factory_number',
					'tbl_vehicles.vehicletype_id',
					'tbl_vehicles.vehiclebrand_id',
					'tbl_vehicles.color_id',
					'vehicle_works_fors.name as working_type',
					'tbl_fuel_types.name as fuel_type',
					'customers.name as owner_name',
					'customers.lastname as owner_lastname',
					'customers.middlename as owner_middlename',
					'customers.id_number',
					'customers.inn',
					'customers.address',
					'customers.type as owner_type',
					'customers.passport_series',
					'customers.passport_number',
					'tbl_cities.name as city',
					'tbl_states.name as state'
				)->first();

			$transportNumber->vehicle_type=getVehicleType($transportNumber->vehicletype_id);
			$transportNumber->vehicle_brand=getVehicleBrands($transportNumber->vehiclebrand_id);
			$transportNumber->color=getVehicleColor($transportNumber->color_id);
			$transportNumber->inspection_type=getPaymentType($transportNumber->type);
			$activeTransportNumber=getActiveTransportNumber($transportNumber->vehicle_id);
			$transportNumber->code=$activeTransportNumber?$activeTransportNumber->code:'';
			$transportNumber->series=$activeTransportNumber?$activeTransportNumber->series:'';
			$transportNumber->number=$activeTransportNumber?$activeTransportNumber->number:'';

			$view='certificate.technical-inspection-preview';

			return view($view,compact('transportNumber','title','transportNumberId','print','details'));
		}else{
			return 'no-id-provided';
		}
	}

	public function medadd()
	{
		$title = "Texnik ko'rik";
		if (Input::get('vehicle_id')) {
			$id = Input::get('vehicle_id');
			$vehicle = DB::table('tbl_vehicles')->where('id', '=', $id)->get()->first();
			$v_number = DB::table('transport_numbers')->where([['vehicle_id', '=', $vehicle->id],['status', '=', 'active']])->orderBy('id', 'desc')->get()->first();
			$v_brand = DB::table('tbl_vehicle_brands')->where('id', '=', $vehicle->vehiclebrand_id)->get()->first();
			$owner = DB::table('customers')->where('id', '=', $vehicle->owner_id)->get()->first();
			$type = DB::table('tbl_vehicle_types')->where('id', '=', $vehicle->vehicletype_id)->get()->first();
		}
		$payments = DB::table('tbl_payment_types')->where('category', '=', 'vehicle_med')->get()->toArray();
		$min = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
		return view('certificate.medadd', compact('title', 'vehicle', 'owner', 'type', 'v_number', 'v_brand', 'payments', 'min'));

	}

	public function medstore(Request $request)
	{
		$user = Auth::user();
		$owner_id = Input::get('owner_id');
		$vehicle_id = Input::get('vehicle_id');
		$status = Input::get('status');
		$date = date('Y-m-d', strtotime(Input::get('givendate')));
		$talonno = Input::get('talonnumber');
		$type = Input::get('med_type'); 
		$payment = DB::table('tbl_payment_types')->where('id', '=', $type)->get()->first();
		$min = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
		$totalpayment = $min->payment*($payment->payment/100);
		if ($status == 'pass') {
			$condition = 'active';
			$oldmed = DB::table('vehicle_inspections')->where('vehicle_id', '=', $vehicle_id)->orderBy('id', 'desc')->get()->first();
			if(!empty($oldmed)){
				$newmed = vehicle_inspections::find($oldmed->id);
				$newmed->condition = 'inactive';
				$newmed->save();
			}
		}else{
			$condition = 'inactive';
		}
		$owner = DB::table('customers')->where('id', '=', $owner_id)->get()->first();
		$med = new vehicle_inspections;
		$med->owner_id = $owner_id;
		$med->vehicle_id = $vehicle_id;
		$med->status = $status;
		$med->total_amount = $totalpayment;
		$med->date = $date;
		$med->type = $type;
		$med->talonno = $talonno;
		$med->condition = $condition;
		$med->user_id = Auth::user()->id;
		$med->save();
		$action_id = DB::table('vehicle_inspections')->orderBy('id', 'desc')->first();
		$active = new tbl_activities;
		$active->ip_adress = $_SERVER['REMOTE_ADDR'];
		$active->owner_id = $owner_id;
		$active->user_id = $user->id;
		$active->city_id = $owner->city_id;
		$active->vehicle_id = $vehicle_id;
		$active->action_id = $action_id->id;
		$active->action_type = 'vehicle_med';
		$active->action = "Texnik ko'rikdan o'tkazildi";
		$active->time = date('Y-m-d H:i:s');
		$active->save();
		return redirect('/certificate/medlist')->with('message', 'Successfully Submitted');

	}



	public  function mededit($id)
	{
		$med = DB::table('vehicle_inspections')->where('id', '=', $id)->get()->first();
		$owner = DB::table('customers')->where('id', '=', $med->owner_id)->get()->first();
		$vehicle = DB::table('tbl_vehicles')->where('id', '=', $med->vehicle_id)->get()->first();
		$type = DB::table('tbl_vehicle_types')->where('id', '=', $vehicle->vehicletype_id)->get()->first();
		return view('certificate.mededit', compact('med', 'owner', 'vehicle', 'type'));
	}

	public function medupdate($id)
	{
		$owner_id = Input::get('owner_id');
		$vehicle_id = Input::get('vehicle_id');
		$status = Input::get('status');
		$totalpayment = Input::get('totalpayment');
		$date = date('Y-m-d', strtotime(Input::get('givendate')));
		$talonno = Input::get('talonnumber');
		$med = vehicle_inspections::find($id);
		$med->owner_id = $owner_id;
		$med->vehicle_id = $vehicle_id;
		$med->status = $status;
		$med->total_amount = $totalpayment;
		$med->date = $date;
		$med->talonno = $talonno;
		$med->save();
		return redirect('/certificate/medlist')->with('message', 'Successfully Updated');

	}



	public function meddelete($id)
	{
		DB::table('vehicle_inspections')->where('id', '=', $id)->delete();
		return redirect('/certificate/medlist')->with('message','Successfully Deleted');
	}

	public function reglist()
	{
		$title = "Ro'yxatdan chiqarilgan texnikalar";
		$from=Input::get('from');
		$till=Input::get('till');
		$registrations = DB::table('vehicle_registrations')->
		select(
			'vehicle_registrations.*', 
			'customers.name as ownername', 
			'customers.type as ownertype', 
			'customers.lastname as ownerlastname', 
			'customers.middlename',
			'customers.city_id',
			'tbl_vehicle_types.vehicle_type as typename', 
			'tbl_vehicles.engineno', 'vehicle_registrations.date',
			'tbl_vehicle_brands.vehicle_brand as brandname')->
		join('tbl_vehicles', 'tbl_vehicles.id', '=', 'vehicle_registrations.vehicle_id')->
		join('tbl_vehicle_types', 'tbl_vehicle_types.id', '=', 'tbl_vehicles.vehicletype_id')->
		join('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
		join('customers', 'customers.id', '=','vehicle_registrations.owner_id')->
		leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$registrations = $registrations->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', intval($city));
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$registrations = $registrations->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$registrations = $registrations->where(function($query) use($user){
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							$query->orWhere('tbl_cities.id', '=', $city->id);
						}
					});
				}
			}
		}

		if($from && $till){
			$fromTime=join('-',array_reverse(explode('-',$from)));
			$tillTime=join('-',array_reverse(explode('-',$till)));
			$timeField='vehicle_registrations.date';
			$registrations=$registrations->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}
		$registrations = $registrations->where([['vehicle_registrations.action', '=', 'unregged'], ['vehicle_registrations.outof', '=', '0'], ['vehicle_registrations.unfit', '=', '0'], ['vehicle_registrations.status', '=', 'active']])
			->where('tbl_vehicles.status', '=', 'unregged')
			->groupBy('vehicle_registrations.vehicle_id')
			->orderBy('vehicle_registrations.date', 'desc')
			->latest()->paginate(50);


		return view('registration.list', compact('registrations', 'title','from','till'));

	}

	public function reglistoutof()
	{
		$from=Input::get('from');
		$till=Input::get('till');
		$registrations = DB::table('vehicle_registrations')->orderBy('id', 'desc')->
		select(
			'customers.city_id', 
			'vehicle_registrations.vehicle_id', 
			'vehicle_registrations.action',
			'vehicle_registrations.owner_id', 
			'customers.name as ownername', 
			'customers.type as ownertype', 
			'customers.lastname as ownerlastname', 
			'customers.middlename', 
			'tbl_vehicle_types.vehicle_type as typename', 
			'tbl_vehicle_brands.vehicle_brand as brandname',
			'tbl_vehicles.engineno',
			'vehicle_registrations.created_at',
			'vehicle_registrations.date', 
			'vehicle_registrations.id', 
			'vehicle_registrations.status', 
			'vehicle_registrations.outof', 
			'vehicle_registrations.unfit'
		)->
		join('tbl_vehicles', 'tbl_vehicles.id', '=', 'vehicle_registrations.vehicle_id')->
		join('customers', 'customers.id', '=', 'vehicle_registrations.owner_id')->
		join('tbl_vehicle_types', 'tbl_vehicle_types.id', '=', 'tbl_vehicles.vehicletype_id')->
		join('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
		where([['tbl_vehicles.status', '=', 'unregged'], ['vehicle_registrations.outof', '=', 1]])->
		orWhere([['vehicle_registrations.unfit', '=', 1],['tbl_vehicles.status', '=', 'unregged']]);
		if($from && $till){
			$fromTime=join('-',array_reverse(explode('-',$from)));
			$tillTime=join('-',array_reverse(explode('-',$till)));
			$timeField='vehicle_registrations.date';
			$registrations=$registrations->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}
		$registrations=$registrations->latest()->paginate(50);
		return view('registration.listoutof', compact('registrations','from','till'));
	}

	public function regadd()
	{
		$type = Input::get('type');
		if($type=='unregged')
		{
			$vehicle_id = Input::get('vehicle_id');
			$payment = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'rec']])->get()->first();
			$min = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
			$vehicle = DB::table('tbl_vehicles')->
			select('tbl_vehicles.id as vehicle_id', 'tbl_vehicle_types.vehicle_type', 'tbl_vehicles.engineno')->
			leftjoin('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
			where('tbl_vehicles.id', '=', $vehicle_id)->get()->first();
			if(Input::get('vehicle_id')){
				$owner = DB::table('customers')->where('id', '=', $vehicle->owner_id)->get()->first();
			}
			return view('registration.sub', compact('vehicle', 'payment', 'min', 'owner'));
		}else if($type=='regged'){
			$payment_a = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'new'], ['key_payment', '=', 'agregat']])->get()->first();
			$payment_v = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'new'], ['key_payment', '=', 'vehicle']])->get()->first();
			$payment_t = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'new'], ['key_payment', '=', 'tirkama']])->get()->first();
			$min = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
			$owner_id = Input::get('owner_id');
			$owner = DB::table('customers')->where('id', '=', $owner_id)->get()->first();
			$vehicle_id = Input::get('vehicle_id');
			$categories = DB::table('customer_categories')->get()->toArray();
			$colors = DB::table('tbl_colors')->get()->toArray();
			$suppliers = DB::table('tbl_suppliers')->get()->toArray();
			$fuels = DB::table('tbl_fuel_types')->get()->toArray();
			$documents=DB::table('documents')->where('service','=','registration')->orderBy('documents.name')->get()->toArray();
			$vehicle = DB::table('tbl_vehicles')->
			select('tbl_vehicles.id as vehicle_id', 'tbl_vehicle_types.vehicle_type as typename', 'tbl_vehicles.engineno', 'tbl_vehicle_brands.vehicle_brand as brandname', 'tbl_vehicles.type as vehicletype')->
			leftjoin('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
			leftjoin('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
			where('tbl_vehicles.id', '=', $vehicle_id)->get()->first();
			return view('registration.add', compact('vehicle', 'categories', 'colors', 'suppliers', 'fuels', 'payment_v', 'payment_a', 'min', 'payment_t', 'owner','documents'));
		}

		

	}

	public function regstore()
	{
		$user = Auth::user();
		$owner = Input::get('owner_id');
		$ownername = DB::table('customers')->where('id', '=', $owner)->get()->first();
		$vehicle = Input::get('vehicle_id');
		$date = date('Y-m-d', strtotime(Input::get('regdate')));
		$totalamount = Input::get('totalamount');
		$note = Input::get('note');
		$action = Input::get('action');
		$outof = Input::get('outof');
		$unfit = Input::get('unfit');
		if ($action == 'regged') {
			$outof = 0;
			$unfit = 0;
		}
		$reg = new vehicle_registrations;
		$reg->action = $action;
		$reg->note = $note;
		$reg->date = $date;
		$reg->owner_id = $owner;
		$reg->vehicle_id = $vehicle;
		$reg->total_amount = $totalamount;
		$reg->status = 'active';
		$reg->city_id = $ownername->city_id;
		$reg->outof = $outof;
		$reg->unfit = $unfit;
		$reg->doc=Input::get('doc');
		$reg->doc_note=Input::get('doc-note');
		$reg->user_id = $user->id;
		$reg->save();
		$last_id = DB::table('vehicle_registrations')->orderBy('id','desc')->first();
		if ($action=='unregged') {
			$reg = DB::table('vehicle_registrations')->where([['vehicle_id', '=', $vehicle], ['status', '=', 'active'], ['action', '=', 'regged']])->get()->first();
			if(!empty($reg)){
				$oldreg = vehicle_registrations::find($reg->id);
				$oldreg->status = 'inactive';
				$oldreg->save();
			}
			
			if ($unfit == 1) {
				$tech = tbl_vehicles::find($vehicle);
				$tech->owner_id = NULL;
				$tech->status = 'unregged';
				$tech->condition = 'unfit';
				$tech->save();
			}else{
				$tech = tbl_vehicles::find($vehicle);
				$tech->owner_id = NULL;
				$tech->status = 'unregged';
				$tech->save();
			}
			$number = DB::table('transport_numbers')->where('vehicle_id', '=', $vehicle)->orderBy('id', 'desc')->get()->first();
			$v_passport = DB::table('technical_passports')->where('vehicle_id', '=', $vehicle)->orderBy('id', 'desc')->get()->first();
			$v_certificate = DB::table('vehicle_certificates')->where('vehicle_id', '=', $vehicle)->orderBy('id', 'desc')->get()->first();
			if(!empty($number)){
				$new_num = TransportNumber::find($number->id);
				$new_num->status = 'inactive';
				$new_num->save();
			}
			if (!empty($v_passport)) {
				$new_pass = TechnicalPassport::find($v_passport->id);
				$new_pass->status = 'inactive';
				$new_pass->save();
			}
			if (!empty($v_certificate)) {
				$new_pass = vehicle_certificates::find($v_certificate->id);
				$new_pass->status = 'inactive';
				$new_pass->save();
			}
			$owner = DB::table('customers')->where('id', '=', $owner)->get()->first();
			$active = new tbl_activities;
			$active->ip_adress = $_SERVER['REMOTE_ADDR'];
			$active->owner_id = $owner->id;
			$active->user_id = $user->id;
			$active->city_id = $owner->city_id;
			$active->vehicle_id = $vehicle;
			$active->action_id = $last_id->id;
			$active->action_type = 'vehicle_reg';
			$active->action = "Texnika ro'yxatdan chiqarildi";
			$active->time = date('Y-m-d H:i:s');
			$active->save();

		}elseif($action=='regged'){
			$tech = tbl_vehicles::find($vehicle);
			$tech->status = $action;
			$tech->owner_id = $owner;
			$tech->save();
			$reg = DB::table('vehicle_registrations')->where([['vehicle_id', '=', $vehicle], ['status', '=', 'active'], ['action', '=', 'unregged']])->get()->first();
			$oldreg = vehicle_registrations::find($reg->id);
			$oldreg->status = 'inactive';
			$oldreg->save();
			$owner = DB::table('customers')->where('id', '=', $owner)->get()->first();
			$active = new tbl_activities;
			$active->ip_adress = $_SERVER['REMOTE_ADDR'];
			$active->owner_id = $owner->id;
			$active->user_id = $user->id;
			$active->city_id = $owner->city_id;
			$active->vehicle_id = $vehicle;
			$active->action_id = $last_id->id;
			$active->action_type = 'vehicle_reg';
			$active->action = "Texnika ro'yxatga olindi";
			$active->time = date('Y-m-d H:i:s');
			$active->save();
		}
		echo $vehicle; 
	}

	public function regdelete($id)
	{

		DB::table('vehicle_registrations')->where('id', '=', $id)->delete();

		return redirect('/certificate/reglist')->with('message','Successfully Deleted');

	}

	public function regback($id)
	{

		$oldreg = DB::table('vehicle_registrations')->where('id', '=', $id)->get()->first();

		if ($oldreg->action == 'unregged') {

			if ($oldreg->unfit == 1) {
				$oldveh = tbl_vehicles::find($oldreg->vehicle_id);
				$oldveh->owner_id = $oldreg->owner_id;
				$oldveh->status = 'regged';
				$oldveh->condition = 'fit';
				$oldveh->save();

			}else{

				$oldveh = tbl_vehicles::find($oldreg->vehicle_id);
				$oldveh->owner_id = $oldreg->owner_id;
				$oldveh->status = 'regged';
				$oldveh->save();

			}
			$number = DB::table('transport_numbers')->where('vehicle_id', '=', $oldreg->vehicle_id)->orderBy('id', 'desc')->get()->first();
			$v_passport = DB::table('technical_passports')->where('vehicle_id', '=', $oldreg->vehicle_id)->orderBy('id', 'desc')->get()->first();
			if(!empty($number)){
				$new_num = TransportNumber::find($number->id);
				$new_num->status = 'active';
				$new_num->save();
			}
			if (!empty($v_passport)){
				$new_pass = TechnicalPassport::find($v_passport->id);
				$new_pass->status = 'active';
				$new_pass->save();

			}

		}elseif($oldreg->action == 'regged'){
			$tech = tbl_vehicles::find($vehicle);
			$tech->owner_id = NULL;
			$tech->status = 'unregged';
			$tech->save();
		}

		$reg = vehicle_registrations::find($id);
		$reg->status = 'cencelled';
		$reg->save();
		$lastreg = DB::table('vehicle_registrations')->where([['vehicle_id', '=', $oldreg->vehicle_id], ['status', '=', 'inactive']])->orderBy('id', 'desc')->get()->first();
		if(!empty($lastreg)){
			$action = vehicle_registrations::find($lastreg->id);
			$action->status = 'inactive';
			$action->save();

		}

		echo "Bekor qilindi";

		

	}

	public function searchvehiclereg()
	{

		$type = Input::get('type');
		$vehicle = Input::get('search');

		if ($type=='regged') {

			$vehicles = DB::table('tbl_vehicles')->
			select('tbl_vehicles.id', 'tbl_vehicle_types.vehicle_type as typename', 'tbl_vehicles.engineno', 'tbl_vehicle_brands.vehicle_brand as name', 'tbl_vehicles.type')->
			leftjoin('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
			leftjoin('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
			leftjoin('vehicle_registrations', function($join){
				$join->on('vehicle_registrations.vehicle_id', '=', 'tbl_vehicles.id')->
				where([['vehicle_registrations.unfit', '=', 0], ['vehicle_registrations.outof', '=', 0], ['vehicle_registrations.action', '=', 'unregged']]);
			})->
			where([['vehicle_registrations.status', '=', 'active'],['tbl_vehicles.status', '=', 'unregged'],['tbl_vehicles.chassisno', 'like', '%'.$vehicle.'%']])->
			orWhere([['vehicle_registrations.status', '=', 'active'],['tbl_vehicles.status', '=', 'unregged'],['tbl_vehicles.corpusno', 'like', '%'.$vehicle.'%']])->
			orWhere([['vehicle_registrations.status', '=', 'active'],['tbl_vehicles.status', '=', 'unregged'],['tbl_vehicles.engineno', 'like', '%'.$vehicle.'%']])->
			orWhere([['vehicle_registrations.status', '=', 'active'],['tbl_vehicles.status', '=', 'unregged'],['tbl_vehicles.factory_number', 'like', '%'.$vehicle.'%']])->
			skip(0)->take(8)->groupBy('vehicle_registrations.vehicle_id')->get()->toArray();

		}

		

		if (!empty($vehicles)) {
			echo json_encode($vehicles);
		}else{
			echo 'Nothing to show';
		}

		

	}



	public function checkengineno()
	{
		$type = Input::get('type');
		$brand = Input::get('brand');
		if ($type == 'engine') {
			$engineno = Input::get('engineno');
			if(Input::get('edit')){
				$count = DB::table('tbl_vehicles')->
				where('tbl_vehicles.vehiclebrand_id', '=', $brand)->
				where([['engineno', '=', $engineno],['id', '!=', Input::get('edit')]])->count();
			}else{
				$count = DB::table('tbl_vehicles')->where('engineno', '=', $engineno)->count();
			}
			if ($count>0) {
				$vehicle = DB::table('tbl_vehicles')->where('engineno', '=', $engineno)->get()->first();
				$owner = DB::table('customers')->where('id', '=', $vehicle->owner_id)->get()->first();
				$brand = DB::table('tbl_vehicle_brands')->where('id', '=', $vehicle->vehiclebrand_id)->get()->first();
				$data = array('owner_id' => $owner->id, 'vehicle_id' => $vehicle->id, 'ownername' => $owner->name, 'vehiclename' => $brand->vehicle_brand, 'type' => 'exist', 'city_id' => $owner->city_id);
				echo json_encode($data);
			}else{
				$data = 'no';
				echo json_encode($data);
			}
		}elseif ($type == 'chasic') {
			$chasicno = Input::get('chasicno');
			if(Input::get('edit')){
				$count = DB::table('tbl_vehicles')
					->where('tbl_vehicles.vehiclebrand_id', '=', $brand)
					->where([['chassisno', '=', $chasicno],['id', '!=', Input::get('edit')]])->count();
			}else{
				$count = DB::table('tbl_vehicles')
					->where('tbl_vehicles.vehiclebrand_id', '=', $brand)
					->where('chassisno', '=', $chasicno)->count();
			}
			if ($count>0) {
				$vehicle = DB::table('tbl_vehicles')->where('chassisno', '=', $chasicno)->orderBy('id', 'desc')->get()->first();
				$owner = DB::table("customers")->where('id', '=', $vehicle->owner_id)->get()->first();
				$brand = DB::table('tbl_vehicle_brands')->where('id', '=', $vehicle->vehiclebrand_id)->get()->first();
				$data = array('owner_id' => $owner->id, 'vehicle_id' => $vehicle->id, 'ownername' => $owner->name, 'vehiclename' => $brand->vehicle_brand, 'type' => 'exist', 'city_id' => $owner->city_id);
				echo json_encode($data);
			}else{
				$data = 'no';
				echo json_encode($data);
			}
		}elseif ($type == 'corpus') {
			$corpusno = Input::get('corpusno');
			if(Input::get('edit')){
				$count = DB::table('tbl_vehicles')
					->where('tbl_vehicles.vehiclebrand_id', '=', $brand)
					->where([['corpusno', '=', $corpusno],['id', '!=', Input::get('edit')]])->count();
			}else{
				$count = DB::table('tbl_vehicles')
					->where('tbl_vehicles.vehiclebrand_id', '=', $brand)
					->where('corpusno', '=', $corpusno)->count();
			}
			if ($count>0) {
				$vehicle = DB::table('tbl_vehicles')->where('corpusno', '=', $corpusno)->orderBy('id', 'desc')->get()->first();
				$owner = DB::table("customers")->where('id', '=', $vehicle->owner_id)->get()->first();
				$brand = DB::table('tbl_vehicle_brands')->where('id', '=', $vehicle->vehiclebrand_id)->get()->first();
				$data = array('owner_id' => $owner->id, 'vehicle_id' => $vehicle->id, 'ownername' => $owner->name, 'vehiclename' => $brand->vehicle_brand, 'type' => 'exist', 'city_id' => $owner->city_id);
				echo json_encode($data);
			}else{
				$data = 'no';
				echo json_encode($data);
			}
		}
	}
	public function checklising(){
		$vehicle = Input::get('vehicle');
		$data = DB::table('tbl_vehicles')->where('id', '=', $vehicle)->get()->first();
		if($data->lising == 1){
			echo "yes";
		}else{
			echo "no";
		}
	}



}
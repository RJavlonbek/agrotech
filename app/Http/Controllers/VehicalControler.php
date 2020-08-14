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
use App\vehicle_registrations;
use App\tbl_activities;
use App\tbl_tm;
use App\Http\Requests;
use PDO;
use DB;
use URL;
use auth;
use Illuminate\Support\Facades\Input;



class VehicalControler extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	//vehicle description
    public function decription()
    {
     	return view ('vehicle.description');
    }

	public function index()
	{
		$owner_id = Input::get('owner_id');
 	    $payment_a = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'new'], ['key_payment', '=', 'agregat']])->get()->first();
		$payment_v = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'new'], ['key_payment', '=', 'vehicle']])->get()->first();
		$min = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
		$vehicle_id = Input::get('vehicle_id');
		$categories = DB::table('customer_categories')->get()->toArray();
		$colors = DB::table('tbl_colors')->get()->toArray();
		$suppliers = DB::table('tbl_suppliers')->get()->toArray();
		$fuels = DB::table('tbl_fuel_types')->get()->toArray();
		$documents=DB::table('documents')->where('service','=','registration')->orderBy('documents.name')->get()->toArray();
		$vehicle = DB::table('tbl_vehicles')->
		select('tbl_vehicles.id as vehicle_id', 'tbl_vehicle_types.vehicle_type as typename', 'tbl_vehicles.engineno', 'tbl_vehicle_brands.vehicle_brand as brandname')->
		leftjoin('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
		leftjoin('tbl_vehicle_brands', 'tbl_vehicle_brands.id', '=', 'tbl_vehicles.vehiclebrand_id')->
		where('tbl_vehicles.id', '=', $vehicle_id)->get()->first();
		$owner = DB::table('customers')->where('id', '=', $owner_id)->get()->first();
		return view ('registration.add',compact('vehical_type','vehical_brand','fuel_type','color','model_name','owner_names','factory_names', 'working_types', 'categories', 'owner', 'colors', 'fuels', 'suppliers', 'min', 'payment_v', 'payment_a', 'vehicle'));    

	}
	public function owner_search_name()
	{
		$ownername=Input::get('search');
		if($ownername!='') {
			$owners = DB::table('customers')->
			select('customers.id','customers.name', 'customers.lastname', 'customers.middlename');
			$user=Auth::User();
			$owners = $owners->where(function($query) use($ownername){
			$query->where('customers.lastname', 'like', '%'.$ownername.'%')->
				orWhere('customers.name', 'like', '%'.$ownername.'%')->
				orWhere('customers.passport_number', 'like', '%'.$ownername.'%')->
				orWhere('customers.id_number', 'like', '%'.$ownername.'%')->
				orWhere('customers.inn', 'like', '%'.$ownername.'%');
			});
			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$owners = $owners->where(function($query) use($user, $ownername){
							foreach (explode(',', $user->city_id) as $city) {
								$query->where('customers.city_id', '=', intval($city))->
								orWhere('customers.city_id', '=', intval($city))->
								orWhere('customers.city_id', '=', intval($city))->
								orWhere('customers.city_id', '=', intval($city))->
								orWhere('customers.city_id', '=', intval($city));
							}
						});
					}elseif($position->position == 'country'){
						$owners = $owners->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$cities = DB::table('tbl_cities')->where('state_id', '=', $state)->get()->toArray();
								foreach ($cities as $city) {
									$query->where('customers.city_id', '=', intval($city->id))->
									orWhere('customers.city_id', '=', intval($city->id))->
									orWhere('customers.city_id', '=', intval($city->id))->
									orWhere('customers.city_id', '=', intval($city->id))->
									orWhere('customers.city_id', '=', intval($city->id));
								}
								
							}
						});
					}elseif($position->position == 'region'){
						$owners = $owners->where(function($query) use($user){
							$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
							foreach ($cities as $city) {
								$query->where('customers.city_id', '=', intval($city->id))->
								orWhere('customers.city_id', '=', intval($city->id))->
								orWhere('customers.city_id', '=', intval($city->id))->
								orWhere('customers.city_id', '=', intval($city->id))->
								orWhere('customers.city_id', '=', intval($city->id));
							}
						});
					}
				}
			}
			$owners = $owners->take(15)->get()->toArray();

			if(!empty($owners)) {
				echo json_encode($owners);
			}else{
				echo 'Nothing to show';
			}

		}

	}
	public function factory_search_name()
	{
		$factoryname=Input::get('search');
		if ($factoryname!='') {
			$factories = DB::table('vehicle_factories')->select('id','name')->where('name', 'like', '%'.$factoryname.'%')->get()->toArray();
			if (!empty($factories)) {
				echo json_encode($factories);
			}else{
				echo 'Nothing to show';
			}

		}

	}

	public function brand_search_name()
	{

		$brandname=Input::get('search');

		if ($brandname!='') {

			$brands = DB::table('tbl_vehicle_brands')->select('id','vehicle_brand as name')->where('vehicle_brand', 'like', '%'.$brandname.'%')->get()->toArray();

			if (!empty($brands)) {

				echo json_encode($brands);

			}else{

				echo 'Nothing to show';

			}

		}

	}

	public function type_search_name()
	{

		$typename=Input::get('search');

			$types = DB::table('tbl_vehicle_types')->select('id','vehicle_type as name')->where('vehicle_type', 'like', '%'.$typename.'%')->get()->toArray();

			if (!empty($types)) {

				echo json_encode($types);

			}else{

				echo 'Nothing to show';

			}

	}

	public function working_search_name()
	{

		$workingname=Input::get('search');

			$working = DB::table('vehicle_works_fors')->select('id','name')->where('name', 'like', '%'.$workingname.'%')->get()->toArray();

			if (!empty($working)) {

				echo json_encode($working);

			}else{

				echo 'Nothing to show';

			}

	}



	public function factoryadd()
	{

		$factoryname = Input::get('factory_name');
		$count = DB::table('vehicle_factories')->where('name','=',$factoryname)->count();
		if ($count==0) {
			$vehiclefactory = new vehicle_factories;
			$vehiclefactory->name = $factoryname;
			$vehiclefactory->save();
			echo $vehiclefactory->id;
		}else{
			return "01";
		}
	}

	

	//  Add vehical type

	public function vehicaltypeadd(Request $request)
	{		
		$vehical_type=Input::get('vehical_type');
		$count = DB::table('tbl_vehicle_types')->where('vehicle_type','=',$vehical_type)->count();
		if ($count==0)
		{
			$vehicaltype = new tbl_vehicle_types;
			$vehicaltype->vehicle_type = $vehical_type;
			$vehicaltype->save();
			 echo $vehicaltype->id;		
		}
		else
		{
			return "01";
		}

	}

	

	// Add vehical brand
	public function vehicalbrandadd()
	{
        $vehical_id= Input::get('vehical_id');
		$vehical_brand1= Input::get('vehical_brand');	
		$working_id = Input::get('working_id');	
		$count = DB::table('tbl_vehicle_brands')->where([['vehicle_id','=',$vehical_id],['vehicle_brand','=',$vehical_brand1]])->count();
		if( $count == 0)
		{
			$vehical_brand= new tbl_vehicle_brands;
			$vehical_brand->vehicle_id=$vehical_id;
			$vehical_brand->vehicle_brand = $vehical_brand1;
			$vehical_brand->working_type_id = $working_id;
			$vehical_brand->save(); 
			echo $vehical_brand->id;
		}
		else
		{
			return "01";

		}

	}



	// Add Vehicle Model

	public function add_vehicle_model()
	{
		$model_name = Input::get('model_name');		
		$count = DB::table('tbl_model_names')->where('model_name','=',$model_name)->count();		
		if($count == 0)
		{
			$tbl_model_names = new tbl_model_names;
			$tbl_model_names->model_name = $model_name;
			$tbl_model_names->save();
			return $tbl_model_names->id;
		}
		else
		{
			return "01";
		}
	}

	

   	// Vehical type two brand select

	public function vehicaltype()
	{
		$id = Input::get('vehical_id');
		$vehical_brand = DB::table('tbl_vehicle_brands')->where('vehicle_id','=',$id)->get()->toArray();
		if(!empty($vehical_brand))
		{
			foreach($vehical_brand as $vehical_brands)
			{ ?>
				<option value="<?php echo  $vehical_brands->id; ?>"  class="brand_of_type"><?php echo $vehical_brands->vehicle_brand; ?></option>
			<?php } 
		}	

	}



	public function factorydelete()
	{
		$id = Input::get('factoryid');
		DB::table('vehicle_factories')->where('id', '=', $id)->delete();
	}

	

	// Vehical type Delete



   	public function deletevehicaltype()
	{
		$id = Input::get('vtypeid');
		DB::table('tbl_vehicle_types')->where('id','=',$id)->delete();			
		DB::table('tbl_vehicle_brands')->where('vehicle_id','=',$id)->delete();			

	}

	 

	// Vehical brand Delete

    public function deletevehicalbrand()
    {	

		$id = Input::get('vbrandid');

     	DB::table('tbl_vehicle_brands')->where('id','=',$id)->delete();

    }



    // Fual type Delete

    public function fueltypedelete()
    {  	

       	$id= Input::get('fueltypeid');

       	$fuel=DB::table('tbl_fuel_types')->where('id','=',$id)->delete();

       	// $tbl_vehicles=DB::table('tbl_vehicles')->where('fuel_id','=',$id)->delete();	

    }

	   

	// Vehical Model Name Delete

	public function delete_vehi_model()
	{	

		$id = Input::get('mod_del_id');

		tbl_model_names::destroy($id);	

	}

	   

	// Vehical save

	public function vehicalstore(Request $request)
	{
		$vehicle_type=Input::get('type_id');
		$chasicno=Input::get('chasicno');
		$vehiclebrand=Input::get('brand_id');
		$modelyear=Input::get('modelyear');
		$factoryname=Input::get('factory_id');
		$condition = Input::get('condition');
		$vehicle_work = Input::get('working_id');
		$factory_number = Input::get('factory_number');
		$category = Input::get('category');
		$corpusno = Input::get('corpusno');
		$engineno=Input::get('engineno');
		$ownername=Input::get('owner_id');
		$fuel = Input::get('fuel');
		$color = Input::get('color');
		$weight = Input::get('weight');
		$weight_full = Input::get('weight_full');
		$supplier = Input::get('supplier');
		$lising = Input::get('lising_id');
		$type = Input::get('vehicle_type_id');
		$enginesize = Input::get('enginesize');
		$date = Input::get('date');
		$total_amount = Input::get('totalamount');
		$owner = DB::table('customers')->where('id', '=', $ownername)->get()->first();
		$doc = Input::get('doc');
		$doc_note = Input::get('doc-note');

		// 	  PDO connection

		// $host = 'localhost';

		// $databasename = 'mis_agrotech';

		// $d_user_name = 'mis_agrotech';

		// $db_password = 'q&B&J!vW-~0d';

		// $conn = new PDO("mysql:host=$host;dbname=$databasename;port=3306", "$d_user_name", "$db_password");

		// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



		// $sql="CREATE TABLE IF NOT EXISTS tbl_vehicle_".$owner->city_id." (

		// 	  `id` int(11) NOT NULL AUTO_INCREMENT,

		// 	  `owner_id` int(11) DEFAULT NULL,

		// 	  `category` int(11) DEFAULT NULL,

		// 	  `working_for_id` int(11) DEFAULT NULL,

		// 	  `factory_id` int(11) DEFAULT NULL,

		// 	  `factory_number` varchar(255) DEFAULT NULL,

		// 	  `vehicletype_id` int(11) DEFAULT NULL,

		// 	  `vehiclebrand_id` int(11) DEFAULT NULL,

		// 	  `modelyear` varchar(255) DEFAULT NULL,

		// 	  `condition` varchar(255) DEFAULT NULL,

		// 	  `chassisno` varchar(255) DEFAULT NULL,

		// 	  `engineno` varchar(255) DEFAULT NULL,

		// 	  `corpusno` varchar(255) DEFAULT NULL,

		// 	  `enginesize` varchar(255) DEFAULT NULL,

		// 	  `fuel_id` int(11) DEFAULT NULL,

		// 	  `color_id` int(11) DEFAULT NULL,

		// 	  `type` varchar(255) DEFAULT NULL,

		// 	  `weight_full` varchar(255) DEFAULT NULL,

		// 	  `weight` varchar(255) DEFAULT NULL,

		// 	  `supplier_id` int(11) DEFAULT NULL,

		// 	  `lising` int(11) DEFAULT NULL,

		// 	  `created_at` timestamp NULL DEFAULT NULL,

		// 	  `updated_at` timestamp NULL DEFAULT NULL,

		// 	  PRIMARY KEY (`id`)

		// 	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";

		// $data=$conn->exec($sql);

		// $insert = "INSERT INTO tbl_vehicle_".$owner->city_id." (`owner_id`, `category`, `working_for_id`, `factory_id`, `factory_number`, `vehicletype_id`, `vehiclebrand_id`, `modelyear`, `condition`, `chassisno`, `engineno`, `corpusno`, `enginesize`, `fuel_id`, `color_id`, `type`, `weight_full`, `weight`, `supplier_id`, `lising`) VALUES 

		// ('$ownername', '$category', '$vehicle_work', '$factoryname', '$factory_number', '$vehicle_type', '$vehiclebrand', '$modelyear', '$condition', '$chasicno', '$engineno', '$corpusno', '$enginesize', '$fuel', '$color', '$type', '$weight_full', '$weight', '$supplier', '$lising')";

		// $dataIn = $conn->exec($insert);





		$vehicle = new tbl_vehicles;
        $vehicle->category = $category;
        $vehicle->vehicletype_id = $vehicle_type;
		$vehicle->chassisno = $chasicno;
		$vehicle->vehiclebrand_id = $vehiclebrand;
		$vehicle->modelyear  = $modelyear;
		$vehicle->owner_id  = $ownername;
		$vehicle->factory_id = $factoryname;
		$vehicle->engineno  = $engineno;
		$vehicle->corpusno  = $corpusno;
		$vehicle->factory_number = $factory_number;
		$vehicle->condition = $condition;
		$vehicle->working_for_id = $vehicle_work;
		$vehicle->fuel_id = $fuel;
		$vehicle->color_id = $color;
		$vehicle->weight_full = $weight_full;
		$vehicle->weight = $weight;
		$vehicle->supplier_id = $supplier;
		$vehicle->lising = $lising;
		$vehicle->enginesize = $enginesize;
		$vehicle->type = $type;
		$vehicle->save();
		$last_id = DB::table('tbl_vehicles')->orderBy('id','desc')->first();
		$payment = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'new']])->get()->first();
		$min_p = DB::table('tbl_payment_types')->where('id', '=', 2)->get()->first();
		$user = Auth::user();
		$reg = new vehicle_registrations;
		$reg->action = 'regged';
		$reg->note = 'Yangi texnika';
        $reg->doc = $doc;
		$reg->doc_note = $doc_note;
		$reg->date = date('Y-m-d', strtotime($date));
		$reg->owner_id = $ownername;
		$reg->vehicle_id = $last_id->id;
		if($doc == 10){
			$reg->total_amount = 0;
		}else{
			$reg->total_amount = $total_amount;
		}
		$reg->status = 'active';
		$reg->city_id = $owner->city_id;
		$reg->user_id = $user->id;
		$reg->save();
		
		$owner = DB::table('customers')->where('id', '=', $ownername)->get()->first();
		$active = new tbl_activities;
		$active->ip_adress = $_SERVER['REMOTE_ADDR'];
		$active->owner_id = $owner->id;
		$active->user_id = $user->id;
		$active->city_id = $owner->city_id;
		$active->vehicle_id = $last_id->id;
		$active->action_id = $last_id->id;
		$active->action_type = 'vehicle_reg';
		$active->action = "Texnika ro'yhatdan o'tkazildi";
		$active->time = date('Y-m-d H:i:s');
		$active->save();


        echo $last_id->id;

	}

	

	//vehical list

	public function vehicallist()
	{    
		$from=Input::get('from');
		$till=Input::get('till');
	  	
	    $vehical=DB::table('tbl_vehicles')->
		select(
		  	'tbl_vehicles.id',
		  	'tbl_vehicles.created_at', 
		  	'tbl_vehicles.type', 
		  	'tbl_vehicles.status', 
		  	'customers.name as ownername', 
		  	'customers.lastname as ownerlastname', 
		  	'customers.middlename', 
		  	'tbl_vehicle_brands.vehicle_brand as brandname', 
		  	'tbl_vehicle_types.vehicle_type as typename', 
		  	'vehicle_works_fors.name as workname', 
		  	'tbl_vehicles.condition', 
		  	'transport_numbers.series', 
		  	'transport_numbers.number', 
		  	'customers.city_id', 
		  	'transport_numbers.status as tns', 
		  	'tbl_vehicles.lising', 
		  	'transport_numbers.code', 
		  	'customers.type as ownertype',
		  	'customers.id as owner_id'
		)->
		join('customers', 'tbl_vehicles.owner_id', '=', 'customers.id')->
		leftjoin('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
		leftjoin('tbl_vehicle_types', 'tbl_vehicle_brands.vehicle_id', '=', 'tbl_vehicle_types.id')->
		leftjoin('vehicle_works_fors', 'tbl_vehicles.working_for_id', '=', 'vehicle_works_fors.id')->
		leftjoin('transport_numbers', function($join){
			$join->on('tbl_vehicles.id', '=', 'transport_numbers.vehicle_id')->
			where('transport_numbers.status', '=', 'active');
		})->
		where('tbl_vehicles.status', '=', 'regged');
		if(!empty(Input::get('s'))){
			$search = Input::get('s');
			$vehical = $vehical->where(function($query) use ($search){
				$query->where('tbl_vehicles.engineno', 'like', '%'.$search.'%')->
				orWhere('tbl_vehicles.corpusno', 'like', '%'.$search.'%')->
				orWhere('tbl_vehicles.chassisno', 'like', '%'.$search.'%')->
				orWhere(DB::raw("CONCAT(UPPER(customers.lastname), ' ', UPPER(customers.name), ' ', UPPER(customers.middlename))"), 'like', '%'.$search.'%')->
				orWhere(DB::raw("CONCAT(UPPER(transport_numbers.code), ' ', UPPER(transport_numbers.series), ' ', UPPER(transport_numbers.number))"), 'like', '%'.$search.'%')->
				orWhere('tbl_vehicle_brands.vehicle_brand', 'like', '%'.$search.'%')->
				orWhere('tbl_vehicle_types.vehicle_type', 'like', '%'.$search.'%')->
				orWhere('customers.inn', 'like', '%'.$search.'%')->
				orWhere(DB::raw("CONCAT(UPPER(transport_numbers.code), ' ', UPPER(transport_numbers.number), UPPER(transport_numbers.series))"), 'like', '%'.$search.'%');
				
			});
			
		}
		if(!empty(Input::get('type')))
		{
			$type = Input::get('type');
			$vehical = $vehical->where('customers.type', '=', $type);
		}else{
			$type = 'all';
		}	
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$vehical = $vehical->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('customers.city_id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$vehical = $vehical->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$cities = DB::table('tbl_cities')->where('state_id', '=', $state)->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('customers.city_id','=',$city->id);
							}
							
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$vehical = $vehical->where(function($query) use($user){
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							$query->orWhere('customers.city_id', '=', $city->id);
						}
					});
				}
			}
		}
		if($from && $till){
			$fromTime=join('-',array_reverse(explode('-',$from)));
			$tillTime=join('-',array_reverse(explode('-',$till)));
			$lastRegRecord=DB::table('vehicle_registrations')
				->where('action','=','regged')
				->whereDate('date','>=',$fromTime)
				->whereDate('date','<=',$tillTime)
				->orderBy('date','DESC')
				->first();
			if(empty($lastRegRecord)){
				unset($vehical[$key]);
			}
		}
		$vehical = $vehical->latest()->paginate(50);
		if(!empty(Input::get('s'))){
			$s = Input::get('s');
			$vehical->appends(['s' => $s]);
		}
			//$image=DB::table('tbl_vehicle_images')->get();
		foreach ($vehical as $key=>$vehicle) {
			$lock = DB::table('vehicle_prohibitions')->where('vehicle_id', '=', $vehicle->id)->latest()->first();
			$vehicle->tps = 'inactive';
			if($vehicle->type == 'vehicle' || $vehicle->type == 'tirkama'){
				$tech_p = DB::table('technical_passports')->where('vehicle_id', '=', $vehicle->id)->latest()->first();
				if(!empty($tech_p)){
					$vehicle->tps = $tech_p->status;
					$vehicle->pass = $tech_p->series;
					$vehicle->pasn = $tech_p->number;
				}
			}elseif($vehicle->type == 'agregat'){
				$tech_p = DB::table('vehicle_certificates')->where('vehicle_id', '=', $vehicle->id)->latest()->get()->first();
				if(!empty($tech_p)){
					$vehicle->tps = $tech_p->status;
					$vehicle->pass = $tech_p->series;
					$vehicle->pasn = $tech_p->number;
				}
			}
			$vehicle->lock = null;
			if(!empty($lock))
			{
				if ($lock == 'lock') {
					$vehicle->lock = true;
				}
			}
			
		}
		return view('vehicle.list',compact('vehical','vehical_type','image', 'type','from','till', 'search'));
	}

	

	// Vehical  Delete

    public function destory($id, $city_id)	

	{

		$vehical = DB::table('tbl_vehicles')->where('id','=',$id)->delete();

        return redirect('vehicle/list')->with('message','Successfully Deleted');

	}	



    // Vehical  Edit

    public function editvehical($id, $city_id)
	{  

		$editid=$id;
		$title = "Tenikani o'zgartirish";
	    $vehical_type = DB::table('tbl_vehicle_types')->get()->toArray();
	    $vehical_brand = DB::table('tbl_vehicle_brands')->get()->toArray();
	    $vehicle_color = DB::table('tbl_colors')->get()->toArray();
	    $vehicle_supplier = DB::table('tbl_suppliers')->get()->toArray();
		$factory_names = DB::table('vehicle_factories')->get()->toArray();
		$working_types = DB::table('vehicle_works_fors')->get()->toArray();
	    $vehicaledit=DB::table('tbl_vehicles')->where('id', '=', $id)->get()->first();
        $owner = DB::table('customers')->where('id', '=', $vehicaledit->owner_id)->get()->first();
        $brand = DB::table('tbl_vehicle_brands')->where('id', '=', $vehicaledit->vehiclebrand_id)->get()->first();
        $type = DB::table('tbl_vehicle_types')->where('id', '=', $brand->vehicle_id)->get()->first();
        
        $factory = DB::table('vehicle_factories')->where('id', '=', $vehicaledit->factory_id)->get()->first();
        $working = DB::table('vehicle_works_fors')->where('id', '=', $brand->working_type_id)->get()->first();	
        $categories = DB::table('customer_categories')->get()->toArray();
        $fuel_type = DB::table('tbl_fuel_types')->get()->toArray();
		return view ('vehicle.edit',compact('vehicaledit','vehical_type','vehical_brand','editid','owner','type','brand', 'factory', 'working', 'factory_names', 'working_types', 'categories', 'vehicle_color', 'vehicle_supplier', 'title', 'fuel_type'));

	 }	

	 

    // vehical Update

	public function updatevehical($id, $city_id, Request $request)
	{
	  $this->validate($request, [  
         'price' => 'numeric',
	      ]);
        $vehicle_type=Input::get('type_id');
		$chasicno=Input::get('chasicno');
		$vehiclebrand=Input::get('brand_id');
		$modelyear=Input::get('modelyear');
		$ownername=Input::get('owner_id');
		$factoryname=Input::get('factory_id');
		$corpusno = Input::get('corpusno');
		$condition = Input::get('condition');
		$vehicle_work = Input::get('working_id');
		$factory_number = Input::get('factory_number');
		$category = Input::get('category');
		$engineno=Input::get('engineno');
		$fuel = Input::get('fuel');
		$color = Input::get('color');
		$weight = Input::get('weight');
		$weight_full = Input::get('weight_full');
		$supplier = Input::get('supplier');
		$lising = Input::get('lising_id');
		$type = Input::get('vehicle_type_id');
		$enginesize = Input::get('enginesize');

        $vehicle = tbl_vehicles::find($id);
        $vehicle->category = $category;
        $vehicle->vehicletype_id= $vehicle_type;
		$vehicle->chassisno = $chasicno;
		$vehicle->vehiclebrand_id = $vehiclebrand;
		$vehicle->modelyear  = $modelyear;
		$vehicle->owner_id  = $ownername;
		$vehicle->factory_id = $factoryname;
		$vehicle->engineno  = $engineno;
		$vehicle->corpusno  = $corpusno;
		$vehicle->factory_number = $factory_number;
		$vehicle->condition = $condition;
		$vehicle->working_for_id = $vehicle_work;
		$vehicle->fuel_id = $fuel;
		$vehicle->color_id = $color;
		$vehicle->weight_full = $weight_full;
		$vehicle->weight = $weight;
		$vehicle->supplier_id = $supplier;
		$vehicle->lising = $lising;
		$vehicle->enginesize = $enginesize;
		$vehicle->type = $type;
		$vehicle-> save();
		$user = Auth::user();
		$owner = DB::table('customers')->where('id', '=', $ownername)->get()->first();
		$active = new tbl_activities;
		$active->ip_adress = $_SERVER['REMOTE_ADDR'];
		$active->owner_id = $owner->id;
		$active->user_id = $user->id;
		$active->city_id = $owner->city_id;
		$active->vehicle_id = $id;
		$active->action_id = $id;
		$active->action_type = 'vehicle_edit';
		$active->action = "Texnika o'zgartrildi";
		$active->time = date('Y-m-d H:i:s');
		$active->save();

		echo $id;

	 }



	//vehicle show

	public function vehicalshow($id, $city_id)
	{
		$view_id = $id;
	 	$vehicle=DB::table('tbl_vehicles')->where('id','=',$view_id)->get()->first();
	 	if ($vehicle->owner_id == 0) {
	 		$owner = null;
	 	}else{
	 		$owner = DB::table('customers')->where('id', '=', $vehicle->owner_id)->get()->first();
	 	}
	 	$v_number = DB::table('transport_numbers')->where([['vehicle_id', '=', $view_id],['status', '=', 'active']])->orderBy('id', 'desc')->get()->first();
	 	$v_brand = DB::table('tbl_vehicle_brands')->where('id', '=', $vehicle->vehiclebrand_id)->get()->first();
	 	$v_type = DB::table('tbl_vehicle_types')->where('id', '=', $v_brand->vehicle_id)->get()->first();
	 	$v_working = DB::table('vehicle_works_fors')->where('id', '=', $v_brand->working_type_id)->get()->first();
	 	$v_factory = DB::table('vehicle_factories')->where('id', '=', $vehicle->factory_id)->get()->first();
	 	if ($vehicle->type == 'vehicle') {
	 		$v_fuel = DB::table('tbl_fuel_types')->where('id', '=', $vehicle->fuel_id)->get()->first();
	 	}else{
	 		$v_fuel = null;
	 	}
	 	if ($vehicle->type == 'vehicle') {
	 		$v_color = DB::table('tbl_colors')->where('id', '=', $vehicle->color_id)->get()->first();
	 	}else{
	 		$v_color = null;
	 	}
	 	if (!empty($owner)) {
	 		$v_city = DB::table('tbl_cities')->where('id', '=', $owner->city_id)->get()->first();
	 	}else{
	 		$v_city = null;
	 	}
	 	if (!empty($v_city)) {
	 		$v_region = DB::table('tbl_states')->where('id', '=', $v_city->state_id)->get()->first();
	 	}else{
	 		$v_region = null;
	 	}
	 	if($vehicle->type == 'vehicle' || $vehicle->type == 'tirkama')
	 	{
	 		$vehicle_c = DB::table('technical_passports')->where([['vehicle_id', '=', $view_id],['status', '=', 'active']])->orderBy('id', 'desc')->get()->first();
	 	}else{
	 		$vehicle_c = DB::table('vehicle_certificates')->where('vehicle_id', '=', $view_id)->orderBy('id', 'desc')->get()->first();
	 	}
	 	$v_registration = DB::table('vehicle_registrations')->
	 		select('vehicle_registrations.*', 'tbl_states.name as regionname', 'tbl_cities.name as districtname', 'customers.name as ownername', 'customers.lastname as ownerlastname', 'customers.type as ownertype', 'customers.middlename as ownermiddlename')->
	 		leftjoin('customers', 'vehicle_registrations.owner_id', '=', 'customers.id')->
	 		leftjoin('tbl_cities', 'customers.city_id', '=', 'tbl_cities.id')->
	 		leftjoin('tbl_states', 'tbl_cities.state_id', '=', 'tbl_states.id')->
	 		where('vehicle_id', '=', $view_id)->latest()->get()->toArray();
	 	$v_inspection = DB::table('vehicle_inspections')->
	 		select('customers.name as ownername', 'customers.lastname as ownerlastname', 'customers.type as ownertype', 'vehicle_inspections.*', 'customers.middlename as ownermiddlename')->
	 		leftjoin('customers', 'vehicle_inspections.owner_id', '=', 'customers.id')->
	 		where('vehicle_id', '=', $view_id)->latest()->get()->toArray();
	 	$v_prohibition = DB::table('vehicle_prohibitions')->
	 		select('vehicle_prohibitions.*', 'customers.name as ownername', 'customers.lastname as ownerlastname', 'customers.type as ownertype', 'tbl_states.name as regionname', 'tbl_cities.name as districname', 'vehicle_lockers.name as lockername', 'vehicle_prohibitions.order_number as orderno', 'customers.middlename as ownermiddlename')->
	 		leftjoin('customers', 'vehicle_prohibitions.owner_id', '=', 'customers.id')->

	 		leftjoin('vehicle_lockers', 'vehicle_prohibitions.locker_id', '=', 'vehicle_lockers.id')->

	 		leftjoin('tbl_cities', 'customers.city_id', '=', 'tbl_cities.id')->

	 		leftjoin('tbl_states', 'tbl_cities.state_id', '=', 'tbl_states.id')->

	 	where('vehicle_id', '=', $view_id)->latest()->get()->toArray();
	 	$v_numbers = DB::table('transport_numbers')->
	 		select('customers.name as ownername', 'customers.lastname as ownerlastname', 'customers.type as ownertype', 'transport_numbers.*', 'customers.middlename as ownermiddlename')->
	 		leftjoin('customers', 'transport_numbers.owner_id', '=', 'customers.id')->
	 	where('vehicle_id', '=', $view_id)->latest()->get()->toArray();
	 	$vehicle_tm = DB::table('tbl_tms')->where('vehicle_id', '=', $view_id)->orderBy('id', 'desc')->get()->toArray();
	 	if($vehicle->type == 'vehicle')
	 	{
	 		$v_certificate = DB::table('technical_passports')->
		 		select(
		 			'customers.name as ownername', 
		 			'customers.lastname as ownerlastname', 
		 			'customers.type as ownertype', 
		 			'technical_passports.*'
		 		)->
		 		leftjoin('customers', 'technical_passports.owner_id', '=', 'customers.id', 'customers.middlename as ownermiddlename')->
		 		where('vehicle_id', '=', $view_id)->latest()->get()->toArray();
	 	}else{
	 		$v_certificate = DB::table('vehicle_certificates')->
		 		select(
		 			'customers.name as ownername', 
		 			'customers.lastname as ownerlastname', 
		 			'customers.type as ownertype', 
		 			'vehicle_certificates.*', 
		 			'customers.middlename as ownermiddlename'
		 		)->
		 		leftjoin('customers', 'vehicle_certificates.owner_id', '=', 'customers.id')->
		 		where('vehicle_id', '=', $view_id)->latest()->get()->toArray();
	 	}
	 	return view('vehicle.view', 
	 		compact(
		 		'vehicle',
		 		'owner',
		 		'view_id', 
		 		'v_type', 
		 		'v_brand', 
		 		'v_number', 
		 		'v_factory', 
		 		'v_working', 
		 		'v_city', 
		 		'v_region', 
		 		'v_registration', 
		 		'v_inspection', 
		 		'v_prohibition', 
		 		'v_certificate', 
		 		'v_numbers', 
		 		'vehicle_c', 
		 		'v_fuel', 
		 		'v_color',
		 		'vehicle_tm'
	 		)
	 	);
	}
	//get images

	

	//delete images

	public function deleteImages()

	{

		$id=Input::get('delete_image');

		$image=DB::table('tbl_vehicle_images')->where('id','=',$id)->delete();

	}

	public function vehiclelock()
	{
		$from=Input::get('from');
		$till=Input::get('till');
		$vehicles = DB::table('vehicle_prohibitions')
			->select(
				'vehicle_prohibitions.id', 
				'vehicle_lockers.name',
				'customers.name as ownername', 
				'customers.id as owner_id', 
				'customers.lastname as ownerlastname', 
				'customers.middlename', 
				'customers.type as ownertype', 
				'vehicle_prohibitions.letter_date', 
				'tbl_vehicle_types.vehicle_type as typename', 
				'vehicle_prohibitions.vehicle_id', 
				'tbl_vehicle_brands.vehicle_brand as brandname', 
				'transport_numbers.series', 
				'transport_numbers.number', 
				'transport_numbers.code', 
				'transport_numbers.status as tns', 
				'tbl_vehicles.type as vehicle'
			)->
			where('vehicle_prohibitions.action', '=', 'lock')->
			join('vehicle_lockers', 'vehicle_prohibitions.locker_id', '=', 'vehicle_lockers.id')->
			join('tbl_vehicles', function($join){
				$join->on('tbl_vehicles.id', '=', 'vehicle_prohibitions.vehicle_id')->
				where('tbl_vehicles.lock_status', '=', 'lock');
			})->
			join('customers', 'tbl_vehicles.owner_id', '=', 'customers.id')->
			join('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
			join('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
			leftjoin('transport_numbers', function($join){
				$join->on('tbl_vehicles.id', '=', 'transport_numbers.vehicle_id')->
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
						$vehicles = $vehicles->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$vehicles = $vehicles->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$vehicles = $vehicles->where(function($query) use($user){
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
			$timeField='vehicle_prohibitions.date';
			$vehicles=$vehicles->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}
		$s = Input::get('s');
		$vehicles=$vehicles->orderBy('id', 'desc')->paginate(50);
		if($s){
			$passports->appends(['s' => $s]);
		}

		return view('vehicle.locklist', compact('vehicles','from','till'));

	}

	public function addlock()
	{
		$lockers = DB::table('vehicle_lockers')->get()->toArray();
		return view('vehicle.addlock', compact('lockers'));

	}



	public function unlock($id){
		$view_id = $id;
		$title = "Taqiqdan chiqarish";
		$lock = DB::table('vehicle_prohibitions')->where('id', '=', $view_id)->get()->first();
		$locker = DB::table('vehicle_lockers')->where('id', '=', $lock->locker_id)->get()->first();
		$owner = DB::table('customers')->where('id', '=', $lock->owner_id)->get()->first();
		$vehicle = DB::table('tbl_vehicles')->where('id', '=', $lock->vehicle_id)->get()->first();
		$v_number = DB::table('transport_numbers')->where([['vehicle_id', '=', $vehicle->id],['status', '=', 'active']])->orderBy('id', 'desc')->get()->first();
	 	$v_type = DB::table('tbl_vehicle_types')->where('id', '=', $vehicle->vehicletype_id)->get()->first();
	 	$v_brand = DB::table('tbl_vehicle_brands')->where('id', '=', $vehicle->vehiclebrand_id)->get()->first();
		return view('vehicle.addlock', compact('title', 'lock', 'locker', 'owner', 'vehicle', 'v_number', 'v_type', 'v_brand', 'view_id'));
	}

	public function searchvehiclelock()
	{
		$type = Input::get('type');
		if($type == 'unlock'){
			$type = 'lock';
		}elseif($type == 'lock'){
			$type = 'unlock';
		}else{
			$type = 'unlock';
		}
		$owner_id = Input::get('id');
		$vehicles = DB::table('tbl_vehicles')->
		select('tbl_vehicles.id', 'tbl_vehicle_types.vehicle_type', 'tbl_vehicles.engineno', 'tbl_vehicle_brands.vehicle_brand', 'transport_numbers.code', 'transport_numbers.series', 'transport_numbers.number')->
		leftjoin('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
		leftjoin('tbl_vehicle_types', 'tbl_vehicle_brands.vehicle_id', '=', 'tbl_vehicle_types.id')->
		leftjoin('transport_numbers', function($join){
			$join->on('tbl_vehicles.id', '=', 'transport_numbers.vehicle_id')->
			where('transport_numbers.status', '=', 'active');
		});
		if(Input::get('type')){
			$vehicles = $vehicles->where([['tbl_vehicles.owner_id', '=', $owner_id],['tbl_vehicles.lock_status', '=', $type]])->get()->toArray();
		}else{
			$vehicles = $vehicles->where('tbl_vehicles.owner_id', '=', $owner_id)->get()->toArray();
		}
		
		$text = '';
		$i = 0;
		foreach ($vehicles as $vehicle) {
			if($i == 0){
				$text .= '<option value> Texnikani tanlang</option>';
			}
			$text .= '<option value='.$vehicle->id.'>'.$vehicle->vehicle_brand.'-'.$vehicle->vehicle_type.' '.$vehicle->code.' '.$vehicle->series.' '.$vehicle->number.'</option>';
		}
		echo $text;
	}

	public function work_for_delete()
	{
		$id = Input::get('vworkid');
		DB::table('vehicle_works_fors')->where('id', '=', $id)->delete();
	}
	public function working_add()
	{
		$workingname = Input::get('vehical_working');
		$count = DB::table('vehicle_works_fors')->where('name','=',$workingname)->count();
		if ($count==0) {
			$vehicleworking = new vehicle_works_fors;
			$vehicleworking-> name = $workingname;
			$vehicleworking->save();
			echo $vehicleworking->id;
		}else{
			return "01";
		}

	}

	public function locker_add()
	{
		$lockername = Input::get('locker');
		$count = DB::table('vehicle_lockers')->where('name','=',$lockername)->count();
		if ($count==0) {
			$lock = new vehicle_lockers;
			$lock->name = $lockername;
			$lock->save();
			echo $lock->id;
		}else{
			return "01";
		}
	}

	public function locker_delete()
	{

		$id = Input::get('vlockerid');

     	DB::table('vehicle_lockers')->where('id','=',$id)->delete();

     	echo $id;

	}

	public function lock_store(Request $request)
	{
		$user = Auth::user();
		$owner_id = Input::get('owner_id');
		$vehicle_id = Input::get('vehicle_id');
		$letterdate = date('Y-m-d', strtotime(Input::get('letterdate')));
		$letterno = Input::get('letterno');
		$orderdate = date('Y-m-d', strtotime(Input::get('orderdate')));
		$orderno = Input::get('orderno');
		$action = Input::get('action');
		$locker = Input::get('locker');
		$date = date('Y-m-d', strtotime(Input::get('date')));
		$lock = new vehicle_prohibitions;
		$lock->owner_id = $owner_id;
		$lock->vehicle_id = $vehicle_id;
		$lock->action = $action;
		$lock->order_number = $orderno;
		$lock->letter_number = $letterno;
		$lock->letter_date = $letterdate;
		$lock->order_date = $orderdate;
		$lock->locker_id = $locker;
		$lock->user_id = $user->id;
		$lock->date = $date;
		$lock->save();
		if($action == 'unlock'){
			$oldone = Input::get('oldone');
			$l_oldone = vehicle_prohibitions::find($oldone);
			$l_oldone->status = 'inactive';
			$l_oldone->save();
			$l_v = DB::table('vehicle_prohibitions')->where([['status', '=', 'active'], ['action', '=', 'lock'], ['vehicle_id', '=', $vehicle_id]])->count();
			if ($l_v == 0 ) {
				$vehicle = tbl_vehicles::find($vehicle_id);
				$vehicle->lock_status = $action;
				$vehicle->save();
			}
		}else{
			$vehicle = tbl_vehicles::find($vehicle_id);
			$vehicle->lock_status = $action;
			$vehicle->save();
		}
		$owner = DB::table('customers')->where('id', '=', $owner_id)->get()->first();
		$last_id = DB::table('vehicle_prohibitions')->orderBy('id','desc')->first();
		$active = new tbl_activities;
		$active->ip_adress = $_SERVER['REMOTE_ADDR'];
		$active->owner_id = $owner->id;
		$active->user_id = $user->id;
		$active->city_id = $owner->city_id;
		$active->vehicle_id = $vehicle_id;
		$active->action_id = $last_id->id;
		$active->action_type = 'vehicle_lock';
		if ($action == 'unlock') {
			$active->action = "Texnika taqiqdan chiqarildi";
		}elseif($action == 'lock'){
			$active->action = "Texnika taqiqqa olindi";
		}
		$active->time = date('Y-m-d H:i:s');
		$active->save();
		return redirect('/vehicle/lock')->with('message','Successfully Submitted')->with('last_id', $date);
	}
	public function checktype(){
		$vehicle = Input::get('id');
		$type = DB::table('tbl_vehicles')->where('id', '=', $vehicle)->get()->first();
		echo $type->type;
	}
	public function tm_formsubmit(){
		$payment = Input::get('payment');
		$owner = Input::get('o_id');
		$vehicle = Input::get('v_id');
		$date = date('Y-m-d');
		$number = Input::get('number');
		$tmform = new tbl_tm;
		$tmform->vehicle_id = $vehicle;
		$tmform->owner_id = $owner;
		$tmform->payment = $payment;
		$tmform->date = $date;
		$tmform->number = $number;
		$tmform->user_id = Auth::user()->id;
		$tmform->save();
		$last_id = DB::table('tbl_tms')->orderBy('id', 'desc')->get()->first();
		$owner = DB::table('customers')->where('id', '=', $owner)->get()->first();
		$active = new tbl_activities;
		$active->ip_adress = $_SERVER['REMOTE_ADDR'];
		$active->vehicle_id = $vehicle;
		$active->owner_id = $owner->id;
		$active->user_id = Auth::user()->id;
		$active->action_type = 'vehicle_tm';
		$active->action_id = $last_id->id;
		$active->action = "Texnika egasiga TM-1 ma'lumotnoma berildi";
		$active->city_id = $owner->id;
		$active->time = date('Y-m-d H:i:s');
		$active->save();
		
		echo $last_id->id;
	}
	public function checkfactory(){
		$num = Input::get('num');
		$type = Input::get('type');
		$brand = Input::get('brand');
		$check = DB::table('tbl_vehicles')
			->where('factory_number', '=', $num)
			->where('vehiclebrand_id', '=', $brand)->count();
		if($check>0){
			$check = DB::table('tbl_vehicles')->where([['factory_number', '=', $num], ['vehicletype_id', '=', $type], ['vehiclebrand_id', '=', $brand]])->get()->first();
			$owner = DB::table('customers')->where('id', '=', $check->owner_id)->get()->first();
			$brand = DB::table('tbl_vehicle_brands')->where('id', '=', $check->vehiclebrand_id)->get()->first();
			$data = array('owner_id' => $check->owner_id, 'vehicle_id' => $check->id, 'ownername' => $owner->name, 'vehiclename' => $brand->vehicle_brand, 'type' => 'exist', 'city_id' => $owner->city_id);
			echo json_encode($data);
		}else{
			$data = 'no';
			echo json_encode($data);
		}

	}
	public function tm_list(){
		$title = "TM-1 Ma'lumotnoma";
		$from=Input::get('from');
		$till=Input::get('till');
		$vehicles = DB::table('tbl_tms')
			->select(
				'tbl_tms.id',
				'tbl_tms.date',
				'customers.id as owner_id',
				'customers.type as ownertype',
				'customers.name as ownername',
				'customers.lastname as ownerlastname',
				'customers.middlename',
				'customers.city_id',
				'tbl_vehicle_types.vehicle_type as typename',
				'tbl_vehicle_brands.vehicle_brand as brandname',
				'tbl_vehicles.id as vehicle_id',
				'tbl_vehicles.type as vehicle',
				'transport_numbers.status as tns',
				'transport_numbers.code', 
				'transport_numbers.series',
				'transport_numbers.number'

			)->
			join('tbl_vehicles', 'tbl_vehicles.id', '=', 'tbl_tms.vehicle_id')->
			join('customers', 'tbl_vehicles.owner_id', '=', 'customers.id')->
			join('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
			join('tbl_vehicle_types', 'tbl_vehicle_brands.vehicle_id', '=', 'tbl_vehicle_types.id')->
			leftjoin('transport_numbers', function($join){
				$join->on('tbl_vehicles.id', '=', 'transport_numbers.vehicle_id')->
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
						$vehicles = $vehicles->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$vehicles = $vehicles->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$vehicles = $vehicles->where(function($query) use($user){
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
			$timeField='tbl_tms.date';
			$vehicles=$vehicles->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}

		$vehicles=$vehicles->orderBy('id', 'desc')->get()->toArray();

		return view('vehicle.tm-list', compact('vehicles','from','till'));
	}



}
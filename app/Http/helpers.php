<?php
// Get getRegistrationNo
if (!function_exists('getRegistrationNo')) {
	function getRegistrationNo($id){
	    $tbl_sales=DB::table('tbl_sales')->where('vehicle_id','=',$id)->first();
		if(!empty($tbl_sales)){
			$registration_no=$tbl_sales->registration_no;
			return $registration_no;
		}
		else{
			$tbl_vehicles=DB::table('tbl_vehicles')->where('id','=',$id)->first();
			$regno=$tbl_vehicles->registration_no;
			if(!empty($regno)){
				return $regno;
			}else{
				return '';
			}
		}
	}
}

// Get getProductcode

if (!function_exists('getProductcode')) {

	function getProductcode($id)

	{

	     $product=DB::table('tbl_products')->where('id','=',$id)->first();

		if(!empty($product))

		{

			$code=$product->product_no;

			return $code;

		}

		else

		{

			return '';

		}

	}

}

// Get getCellProduct

if (!function_exists('getTotalProduct')) {

	function getTotalProduct($id,$s_date,$e_date)

	{

		if($s_date == '' && $e_date == '')

		{

			$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')

			->where('product_id','=',$id)

			->get()->toArray();

		}

		else

		{

			$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')

			->whereBetween('date', [$s_date, $e_date])

			->where('product_id','=',$id)

			->get()->toArray();

		   

			

		}

		

		$stocktotal=0;

		if(!empty($totalstock))

		{

			foreach($totalstock as $totalstocks)

			{

					$total_stock=$totalstocks->qty;

					$stocktotal += $total_stock;

			}

			 

			 return $stocktotal;

				

		}

		else

		{

			return 0;

		}

	}

}

// Get getCellProduct

if (!function_exists('getCellProduct')) {

	function getCellProduct($id,$s_date,$e_date)

	{

		if($s_date == '' && $e_date == '')

		{

			$cellstock=DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')

			->where('product_id','=',$id)

			->get()->toArray();

			

		}

		else

		{

			$cellstock=DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')

			->whereBetween('service_date', [$s_date, $e_date])

			->where('product_id','=',$id)

			->get()->toArray();

		}

		$celltotal=0;

		if(!empty($cellstock))

		{

			foreach($cellstock as $cellstocks)

			{

				$cell_stock=$cellstocks->quantity;

				$celltotal += $cell_stock;		

			}

			 return $celltotal;

		}

		else

		{

			return 0;

		}

	}

}

// Get getStockProduct

if (!function_exists('getStockProduct')) {

	function getStockProduct($id,$s_date,$e_date)

	{

		if($s_date == '' && $e_date == '')

		{

			$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')

			->where('product_id','=',$id)

			->get()->toArray();

			

			$cellstock=DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')

			->where('product_id','=',$id)

			->get()->toArray();

		}

		else

		{

			$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')

			->whereBetween('date', [$s_date, $e_date])

			->where('product_id','=',$id)

			->get()->toArray();

		   

			$cellstock=DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')

			->whereBetween('service_date', [$s_date, $e_date])

			->where('product_id','=',$id)

			->get()->toArray();

			

		}

		

		$stocktotal=0;

		if(!empty($totalstock))

		{

			foreach($totalstock as $totalstocks)

			{

					$total_stock=$totalstocks->qty;

					$stocktotal += $total_stock;

			}

			 

			$currenttotal = $stocktotal;

				

		}

		else

		{

			$currenttotal= 0;

		}

		

		$celltotal=0;

		if(!empty($cellstock))

		{

			foreach($cellstock as $cellstocks)

			{

				$cell_stock=$cellstocks->quantity;

				$celltotal += $cell_stock;		

			}

			 $totalcellcurrent=$celltotal;

		}

		else

		{

			$totalcellcurrent = 0;

		}

		

		$finalcurrenttotal = $currenttotal - $totalcellcurrent;

		return $finalcurrenttotal;

			

		

	}

}



// Get getStockProduct

if (!function_exists('getTotalStock')) {

	function getTotalStock($id)

	{

		$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')

			->where('product_id','=',$id)

			->get()->toArray();

		$stocktotal=0;

		if(!empty($totalstock))

		{

			foreach($totalstock as $totalstocks)

			{

					$total_stock=$totalstocks->qty;

					$stocktotal += $total_stock;

			}

			 

			 $total= $stocktotal;

				

		}

		else

		{

			$total= $stocktotal;

		}

		$cellstock=DB::table('tbl_service_pros')->where('product_id','=',$id)

			->get()->toArray();

		$celltotal=0;

		if(!empty($cellstock))

		{

			foreach($cellstock as $cellstocks)

			{

				$cell_stock=$cellstocks->quantity;

				$celltotal += $cell_stock;		

			}

			 $totalcellcurrent=$celltotal;

		}

		else

		{

			$totalcellcurrent=$celltotal;

		}

		

		$totalcurrentstock = $total - $totalcellcurrent;

		return $totalcurrentstock;

	}

}

function getCurrentOwnerCityId($vehicleId){
	$customer=DB::table('tbl_vehicles')
		->join('customers','customers.id','=','tbl_vehicles.owner_id')
		->where('tbl_vehicles.id','=',$vehicleId)
		->select('customers.city_id')
		->first();
	return $customer ? $customer->city_id : '';
}

// Get getEmployeeservice

if (!function_exists('getEmployeeservice')) {

	function getEmployeeservice($id,$salesid,$nowmonthdate,$nowmonthdate1)

	{

		// $tbl_services=DB::select("SELECT * FROM `tbl_services` WHERE `sales_id` = '$salesid' AND `assign_to` = '$id' AND `done_status` LIKE '2' AND `customer_id` = 6 AND (service_date BETWEEN '" . $nowmonthdate . "' AND  '" . $nowmonthdate1 . "')");

		

		$tbl_services= DB::select("SELECT * FROM tbl_services where (done_status=2) and (assign_to='$id') and (sales_id='$salesid') and(service_date BETWEEN '" . $nowmonthdate . "' AND  '" . $nowmonthdate1 . "')");

		

			

			if(!empty($tbl_services))

			{

				foreach($tbl_services as $tbl_services)

				{

					$assign_to=$tbl_services->assign_to;

					$admin=DB::table('users')->where('id','=',$assign_to)->first();

					$dd=$admin->id;

					return $dd;

				}

			}

			else

			{

				return '';

			}

	}

}

// Get model name in sales module



if (!function_exists('getModelName')) {

	function getModelName($id)

	{

			$tbl_vehicles = DB::table('tbl_vehicles')->where('id','=',$id)->first();

			

			

			

			if(!empty($tbl_vehicles))

			{

				$modelname	 = $tbl_vehicles->modelname;

				return $modelname;

			}

			else

			{

				return '';

			}

	}

}



// Get Unit  name in jobcardproccess module



if (!function_exists('getUnitName')) {

	function getUnitName($id)

	{

			$tbl_product_units = DB::table('tbl_product_units')->where('id','=',$id)->first();

			

			

			

			if(!empty($tbl_product_units))

			{

				$name	 = $tbl_product_units->name;

				return $name;

			}

			else

			{

				return '';

			}

	}

}

// Get invoice number from tbl_invoices

if (!function_exists('getInvoiceNumber')) {

	function getInvoiceNumber($id)

	{

		$data = DB::table('tbl_invoices')->where([['sales_service_id',$id],['job_card','NOT LIKE','J%'],['type',1]])->first();

		

		if(!empty($data))

		{

			$invoice = $data->invoice_number;

			return $invoice;

		}

		else

		{

			return "No data";

		}

	}

}







// Select Product 

if (!function_exists('getSelectedProduct')) {

	function getSelectedProduct($id,$pro_id)

	{	

		

		$data  = DB::table('tbl_service_pros')->where([['service_id','=',$id],['product_id','=',$pro_id]])->first();

		

		if(!empty($data))

		{

			$p_id = $data->product_id;

			return $p_id;

		}	

	}

}

// Get Sum Of Income 

if (!function_exists('getSumOfIncome')) {

	function getSumOfIncome($id)

	{	

		

		$data  = DB::table('tbl_income_history_records')->where('tbl_income_id','=',$id)->SUM('income_amount');

		

		return $data;	

		

	}

}





// Get Sum Of Expense 

if (!function_exists('getSumOfExpense')) {

	function getSumOfExpense($id)

	{	

		

		$data  = DB::table('tbl_expenses_history_records')->where('tbl_expenses_id','=',$id)->SUM('expense_amount');

		

		return $data;	

		

	}

}

// Get Invoice Status 

if (!function_exists('getInvoiceStatus')) {

	function getInvoiceStatus($jobcard)

	{	

		

		$data  = DB::table('tbl_invoices')->where('job_card','=',$jobcard)->first();

		

		if(!empty($data))

		{

			return "Yes";

		}

		else

		{

			return "No";

		}

		

	}

}

// Get status of processed jobcard for gatepass

if (!function_exists('getJobcardStatus')) {

	function getJobcardStatus($jobcard)

	{	

		

		$data  = DB::table('tbl_gatepasses')->where('jobcard_id','=',$jobcard)->first();

		

		if(!empty($data))

		{

			$jbno = $data->ser_pro_status;

		    return $jbno;

		}

		

	}

}



// Get status for checked observation points

if (!function_exists('getCheckedStatus')) {

	function getCheckedStatus($id,$ids)

	{	

		

		//var_dump($id,$ids);

		//$data  = DB::table('tbl_service_observation_points')->where([['observation_points_id','=',$id],['services_id','=',$ids]])->first();

		$data  = DB::table('tbl_service_observation_points')

					->join('tbl_service_pros','tbl_service_observation_points.id','=','tbl_service_pros.tbl_service_observation_points_id')

					->where([['tbl_service_observation_points.observation_points_id','=',$id],['tbl_service_observation_points.services_id','=',$ids],['tbl_service_pros.type','=',0]])->first();

		

		if(!empty($data))

		{

			$review = $data->review;

			

			if($review == 1)

			{

				return 'checked' ;

			}

			else

			{

				return '';

			}	 

		}	

	}

}





// Get observation points



if (!function_exists('getObservationPoint')) {

	function getObservationPoint($id)

	{	

		

		$data  = DB::table('tbl_points')->where('id','=',$id)->first();

		

		if(!empty($data))

		{

			$name = $data->checkout_point;

			 return $name;

		}

		

	}

}



// Get subcategory of the main checkpoints



if (!function_exists('getCheckPointSubCategory')) {

	function getCheckPointSubCategory($id,$vid)

	{	

		

		$data  = DB::table('tbl_points')->where([['checkout_subpoints','=',$id],['vehicle_id','=',$vid]])->get()->toArray();

		

		if(!empty($data))

		{

			return $data;

		}	

	}

}





// Get checkpoints of main category



if (!function_exists('getCheckPoint')) {

	function getCheckPoint($id)

	{	

		$categorypoint = array();

		$categorypoint = DB::table('tbl_points')->where('checkout_subpoints','=',$id)->get()->toArray();

		if(!empty($categorypoint))

		{

			return $categorypoint;

		}

		else

		{

			return $categorypoint;

		}

		

	}

}



// GET value if Gatepass already created



if (!function_exists('getAlreadypasss')) {

	function getAlreadypasss($job_no)

	{	

		

		$jobno = DB::table('tbl_gatepasses')->where('jobcard_id',$job_no)->count();

		if($jobno > 0)

		{

			return 1;

		}

		else

		{

			return 0;

		}

		

	}

}





// Get City Name In Customer,Employee,supplier module

if (!function_exists('getCityName')) {
	function getCityName($id)
	{	
		$city = DB::table('tbl_cities')->where('id','=',$id)->first();
		if(!empty($city))
		{
			$city_name = $city->name;
			return $city_name;
		}elseif($id=='0'){
			return 'Toshkent shahri';
		}else{
			return $id;
		}
	}
}

if (!function_exists('getCityNameus')) {
	function getCityNameus($id)
	{	
		$user = DB::table('users')->where('id', '=', $id)->get()->first();
		$cityname = '';
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			
			if(!empty($position)){
				if($position->position == 'district'){
					foreach (explode(',', $user->city_id) as $city) {
						$city = DB::table('tbl_cities')->where('id','=', intval($city))->first();
						if (!empty($city)) {
							$cityname .= $city->name.', ';
						}
					}
				}elseif($position->position == 'region'){
					foreach (explode(',', $user->city_id) as $city) {
						$city = DB::table('tbl_cities')->where('id', '=', intval($city))->first();
						if (!empty($city)) { 
							$cityname .= $city->name.', ';
						}
					}
				}
			}
		}
		return $cityname;
	}
}
if (!function_exists('getStateNameus')) {

	function getStateNameus($id)
	{	

		$user = DB::table('users')->where('id', '=', $id)->get()->first();
		$statename = '';
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			
			if(!empty($position)){
				if($position->position == 'district'){
					$state = DB::table('tbl_states')->where('id', '=', $user->state_id)->get()->first();
					$statename =  $state->name.', ';
					
				}elseif($position->position == 'region'){
					$state = DB::table('tbl_states')->where('id', '=', $user->state_id)->get()->first();
					$statename =  $state->name.', ';
				}elseif($position->position == 'country'){
					$i = 0;
					foreach (explode(',', $user->state_id) as $state) {
						$state = DB::table('tbl_states')->where('id','=', intval($state))->first();
						if ($i == 0) {
							$statename .= $state->name.', ';
						}else{
							$statename .= $state->name.', ';
						}
						$i++;
					}
				}
			}
		}
		return $statename;
	}

}



// Get State Name In Customer,Employee,supplier module

if (!function_exists('getStateName')) {

	function getStateName($id)

	{	

		

		$state = DB::table('tbl_states')->where('id','=',$id)->first();

		

		if(!empty($state))

		{

			$state_name = $state->name;

			return $state_name;

		}

		

	}

}



// Get Country Name In Customer,Employee,supplier module

if (!function_exists('getCountryName')) {

	function getCountryName($id)

	{	

		

		$country = DB::table('tbl_countries')->where('id','=',$id)->first();

		

		if(!empty($country))

		{

			$country_name = $country->name;

			return $country_name;

		}

		

	}

}



// Get Product Name In Producttype module

if (!function_exists('getProductName')) {

	function getProductName($id)

	{	

		

		$product_tpye = DB::table('tbl_product_types')->where('id','=',$id)->first();

		

		if(!empty($product_tpye))

		{

			$product_name = $product_tpye->type;

			

			return $product_name;

		}

		

	}

}



// Get Product Name In getproducttyid module

if (!function_exists('getproducttyid')) {

	function getproducttyid($id)

	{	

		

		$product_tpye = DB::table('tbl_products')->where('id','=',$id)->first();

		

		if(!empty($product_tpye))

		{

			$product_type_id = $product_tpye->product_type_id;

			

			return $product_type_id;

		}

		

	}

}



// Get Product Name In Product module

if (!function_exists('getProduct')) {

	function getProduct($id)

	{	

		

		$product = DB::table('tbl_products')->where('id','=',$id)->first();

		

		if(!empty($product))

		{

			$productname = $product->name;

			return $productname;

		}

		

	}

}

// Get Supplier Name In Product module

if (!function_exists('getSupplierName')) {

	function getSupplierName($id)

	{	

		

		$users = DB::table('users')->where([['id','=',$id],['role','=','Supplier']])->first();

		

		if(!empty($users))

		{

			$supplier_name = $users->name;

			return $supplier_name;

		}

		

	}

}



// Get Company Name In Product module

if (!function_exists('getCompanyName')) {

	function getCompanyName($id)

	{	

		

		$users = DB::table('users')->where([['id','=',$id],['role','=','Supplier']])->first();

		

		if(!empty($users))

		{

			$display_name = $users->display_name;

			return $display_name;

		}

		

	}

}



// Get Product List Name In Supplier module

if (!function_exists('getProductList')) {

	function getProductList($id)

	{	

		

		$tbl_products = DB::table('tbl_products')->where('supplier_id','=',$id)->get()->toArray();

		

		if(!empty($tbl_products))

		{

			 $supplier_id = array();

			 foreach($tbl_products as $tbl_productss)

			 { 

				 $supplier_id[] = $tbl_productss->name;

			 }

			$name = implode(', ',$supplier_id);

			

			return $name;

		}

		else

		{

			return '';

		}

		

	}

}





// Get Color Name In Product module

if (!function_exists('getColor')) {

	function getColor($id)

	{	

		

		$color = DB::table('tbl_colors')->where('id','=',$id)->first();

		

		if(!empty($color))

		{

			$color_name = $color->color;

			return $color_name;

		}

		

	}

}

function getOwnershipForm($ownershipFormId){
	$oForm=DB::table('ownership_forms')->where('id','=',$ownershipFormId)->first();
	return $oForm ? $oForm->name : '';
}

function getDocumentName($documentId){
	$doc=DB::table('documents')->where('id','=',$documentId)->first();
	return $doc ? $doc->name : '';
}


// Get RTl value for all module

if (!function_exists('getValue')) {

	function getValue()

	{	

		$id = Auth::user()->id;

		$rtls = DB::table('users')->where('id',$id)->first();

		

		if(!empty($rtls))

		{

			$direction_name = $rtls->gst_no;

			

			return $direction_name;

		}

		

	}

}



// Get Vehicle Name value In Rto managament module



if (!function_exists('getVehicleName')) {

	function getVehicleName($id)

	{	

		

		$vehicles  = DB::table('tbl_vehicles')->where('id','=',$id)->first();

		

		if(!empty($vehicles))

		{

			$vehicle_name = $vehicles->modelname;

			

			return $vehicle_name;

		}

		

	}

}









if (!function_exists('Getvehiclecheckpoint')) {

	function Getvehiclecheckpoint($id)

	{	

		

		$vehicles  = DB::table('tbl_checkout_categories')->where('vehicle_id','=',$id)->get()->toArray();

		

		if(!empty($vehicles))

		{

			return $vehicles;

		}else

		{

			return array();

		}

		

	}

}



// Get Vehicle type value In vehicle brand module



if (!function_exists('getVehicleBrand')) {

	function getVehicleBrand($id)

	{	

		

		$vehiclebrand  = DB::table('tbl_vehicle_types')->where('id','=',$id)->first();

		

		if(!empty($vehiclebrand))

		{

			$vehicle_brand = $vehiclebrand->vehicle_type;

			

			return $vehicle_brand;

		}

		

	}

}





//getVehicleDescription



if (!function_exists('getVehicleDescription')) {

	function getVehicleDescription($id)

	{	

		

		$VehicalDescription  = DB::table('tbl_vehicles')->where('id','=',$id)->first();

		

		if(!empty($VehicalDescription))

		{

			$VehicalDescriptions = $VehicalDescription->modelname;

			

			return $VehicalDescriptions;

		}

		

	}

}



//Customer Name in View of Sales module

if (!function_exists('getServiceId')) {

	function getServiceId()

	{	

		

		$data  = DB::table('tbl_services')->orderBy('id','DESC')->first();

		

		if(!empty($data))

		{

			$id = $data->id;

			

			return $id;

		}

		

	}

}



//Get customer full name

if (!function_exists('getCustomerName')) {

	function getCustomerName($id)

	{	

		

		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();

		

		if(!empty($customer))

		{

			$customer_name = $customer->name;

			$customer_lname = $customer->lastname;

			return $customer_name.' '.$customer_lname;

		}

		

	}

}



//get Employee full name

if (!function_exists('getAssignedName')) {

	function getAssignedName($id)

	{	

		

		$assigned  = DB::table('users')->where([['id','=',$id],['role','=','employee']])->first();

		

		if(!empty($assigned))

		{

			$assi_name = $assigned->name;

			$assi_lname = $assigned->lastname;

			

			return $assi_name.' '.$assi_lname;

		}

		

	}

}





//Customer Address in View of Sales module

if (!function_exists('getCustomerAddress')) {

	function getCustomerAddress($id)

	{	

		

		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();

		

		if(!empty($customer))

		{

			$customer_address = $customer->address;

			

			return $customer_address;

		}

		

	}

}



//Customer city in View of Sales module

if (!function_exists('getCustomerCity')) {

	function getCustomerCity($id)

	{	

		

		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();

		

		if(!empty($customer))

		{

			$customer_city = getCityName($customer->city_id);

			

			return $customer_city;

		}

		

	}

}

//Customer state in View of Sales module

if (!function_exists('getCustomerState')) {

	function getCustomerState($id)

	{	

		

		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();

		

		if(!empty($customer))

		{

			$customer_state = getStateName($customer->state_id);

			

			return $customer_state;

		}

		

	}

}

//Customer state in View of Sales module

if (!function_exists('getCustomerCountry')) {

	function getCustomerCountry($id)

	{	

		

		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();

		

		if(!empty($customer))

		{

			$customer_country = getCountryName($customer->country_id);

			

			return $customer_country;

		}

		

	}

}



//Customer Mobile in View of Sales module

if (!function_exists('getCustomerMobile')) {

	function getCustomerMobile($id)

	{	

		

		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();

		

		if(!empty($customer))

		{

			$customer_mobile = $customer->mobile_no;

			

			return $customer_mobile;

		}

		

	}

}

//Customer Email in View of Sales module

if (!function_exists('getCustomerEmail')) {

	function getCustomerEmail($id)

	{	

		

		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();

		

		if(!empty($customer))

		{

			$customer_email = $customer->email;

			

			return $customer_email;

		}

		

	}

}

// Get VehicleType Name In Vehicle module
if (!function_exists('getVehicleType')) {

	function getVehicleType($id)

	{	
		$vehical_type = DB::table('tbl_vehicle_types')->where('id','=',$id)->first();

		

		if(!empty($vehical_type))

		{

			$vehical_type_name = $vehical_type->vehicle_type;

			return $vehical_type_name;

		}
	}

}
//Vehicle Color in View of Sales module

if (!function_exists('getVehicleColor')) {

	function getVehicleColor($id)

	{	

		

		$color  = DB::table('tbl_colors')->where('id','=',$id)->first();

		

		if(!empty($color))

		{

			$color_name = $color->color;

			

			return $color_name;

		}

		

	}
}

//Vehicle Color in View of Sales module

if (!function_exists('getPaymentType')) {

	function getPaymentType($id){	
		$color  = DB::table('tbl_payment_types')->where('id','=',$id)->first();
		if(!empty($color)){
			$color_name = $color->name;

			return $color_name;
		}

	}
}
		//Total Amount in View of Sales module
if (!function_exists('getTotalAmonut')) {
	function getTotalAmonut($tax,$name,$amount){	


		$tax  = DB::table('tbl_sales_taxes')->where([['tax_name','=',$name],['tax','=',$tax]])->first();

		$tax_rate = $tax->tax;

		$total_price = ($tax_rate * $amount)/100;

		return $total_price;

		

	}
}





//Total Amount of rto  in View of Sales module

if (!function_exists('getTotalRto')) {

	function getTotalRto($id)

	{	

		

		$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$id)->first();

		$r_tax = $rto->registration_tax;

		$no_plate = $rto->number_plate_charge;

		$road_tax = $rto->muncipal_road_tax;

		

		$total_rto_charges = $r_tax+$no_plate+$road_tax;

		return $total_rto_charges;

		

	}

}





//Get Observation Type Name in Observation Point List Module

if (!function_exists('getObservationTypeName')) {

	function getObservationTypeName($id)

	{	

		

		$o_type = DB::table('tbl_observation_types')->where('id','=',$id)->first();

		

		if(!empty($o_type))

		{

			$type_name = $o_type->type;

			

		

			return $type_name;

		}

		

	}

}



//Fuel type  in View of vehicle  module

if (!function_exists('getFuelType')) {

	function getFuelType($id)

	{	

		

		$fueal_type  = DB::table('tbl_fuel_types')->where('id','=',$id)->first();

		

		if(!empty($fueal_type))

		{

			$fuel_type_name = $fueal_type->fuel_type;

			

			return $fuel_type_name;

		}

		

	}

}



//Vehicle Brand  in View of vehicle module

if (!function_exists('getVehicleBrands')) {

	function getVehicleBrands($id)

	{	

		

		$vehi_brand = DB::table('tbl_vehicle_brands')->where('id','=',$id)->first();

		

		if(!empty($vehi_brand))

		{

			$vehicalbrand = $vehi_brand->vehicle_brand;

			

			return $vehicalbrand;

		}

		

	}

}

//Get Color Name in View of vehicle module

if (!function_exists('getColorName')) {

	function getColorName($id)

	{	

		

		$color = DB::table('tbl_colors')->where('id','=',$id)->first();

		if(!empty($color))

		{

		$color_name = $color->color;



		return $color_name;

		}

    }

}





//getcolourcode 



if (!function_exists('getColourCode')) {

	function getColourCode($id)

	{	

		$colourname = getColorName($id);

		switch ($colourname) {

		    case "red":

		        return "#ff0000";

		        break;

		    case "blue":

		        return "#0000FF";

		        break;

		    case "green":

		        echo "#008000";

		        break;

		    case "Black ":

		        return "#000000";

		        break;

		    case "Brown ":

		        return "#A52A2A";

		        break;

		    case "Grey ":

		        echo "##808080";

		        break;

		     case "Pink ":

		        return "##FFC0CB";

		        break;

		    case "Purple ":

		        return "##800080";

		        break;

		    case "Yellow ":

		        echo "###FFFF00";

		        break;



		    default:

		        echo "#696969";

         }

		

    }

}



//Get Checked Value In Jobcard Detail

if (!function_exists('getCheckvalue')) {

	function getCheckvalue($services_id,$observation_points_id)

	{	

		

		$getdata = DB::table('tbl_service_observation_points')->where([['services_id','=',$services_id],['observation_points_id','=',$observation_points_id]])->count();

		if($getdata>0)

		{

			return 'checked';

		}else

		{

			return '';

		}

	}

}



//Get Checked Value In Jobcard Detail

if (!function_exists('getCheckReview')) {

	function getCheckReview($services_id,$observation_points_id)

	{	

		

		$getdata = DB::table('tbl_service_observation_points')->where([['services_id','=',$services_id],['observation_points_id','=',$observation_points_id]])->first();

		

		if(!empty($getdata))

		{

			$review = $getdata->review;

			return $review;

		}

	}

}



// get vehicle first image

if (!function_exists('getVehicleImage')) {

	function getVehicleImage($id)

	{	

		

		$vehicleimage = DB::table('tbl_vehicle_images')->where('vehicle_id','=',$id)->first();

		if(!empty($vehicleimage))

		{

			$vehiclefisrtimage =	$vehicleimage->image;

			return $vehiclefisrtimage;

		}else{

			$vehiclefisrtimage ='avtar.png';

			return $vehiclefisrtimage;

		}

	}

}





//Get AssigineTo  Value In Service(module) List  Detail

if (!function_exists('getAssignTo')) {

	function getAssignTo($id)

	{	

		

		$AssignTo  = DB::table('users')->where('id','=',$id)->first();

		

		if(!empty($AssignTo))

		{

			$AssignTo_name = $AssignTo->name;

			

			return $AssignTo_name;

		}

		

	}

}



//Set the logo of get pass invoice

if (!function_exists('getLogoInvoice')) {

	function getLogoInvoice()

	{	

		

		$logo = DB::table('tbl_settings')->first();

		$logo_img = $logo->logo_image;



		return $logo_img;

	}

}



//Set the Coupan no in Service List

if (!function_exists('getAllCoupon')) {

	function getAllCoupon($cid,$vid)

	{	

		

		$all_coupan = DB::table('tbl_services')->where([['customer_id','=',$cid],['vehicle_id','=',$vid],['job_no','like','C%']])->get()->toArray();

		

		return $all_coupan;

	}

}



//Set the Used Coupon no in Service List

if (!function_exists('getUsedCoupon')) {

	function getUsedCoupon($cid,$vid,$cupanno)

	{	

		

		$used_coupon = DB::table('tbl_jobcard_details')->where([['customer_id','=',$cid],['vehicle_id','=',$vid],['coupan_no','=',$cupanno]])->first();

		

		if(!empty($used_coupon))

		{

			

			$done_status = $used_coupon->done_status;

			return  $done_status;

		}

		

		

	}

}



// Get A Access Rights Setting  In User Side PAge for all Module

if (!function_exists('getAccessStatusUser')) {

	function getAccessStatusUser($menu_name,$id)

	{	

		

	// 	$user = DB::table('users')->where('id','=',$id)->first();

		

	// 	$userrole = $user->role;

		

	// 	if($userrole == 'admin')
	// 	{

	// 		return 'yes';

	// 	}else{

	// 	  	if($userrole == 'Customer'){			  

	// 			$acess = DB::table('tbl_accessrights')->where('menu_name','=',$menu_name)->first();
	// 			$customers = $acess->customers;
	// 			if($customers == 1)
	// 			{
	// 				return 'yes';
	// 			}elseif($customers == 0)
	// 			{
	// 				return 'no';
	// 			}
	// 	 	}elseif($userrole == 'employee')

	// 	  	{			  

	// 			$acess = DB::table('tbl_accessrights')->where('menu_name','=',$menu_name)->first();

	// 			$employee = $acess->employee;

	// 			if($employee == 1)

	// 			{

	// 				return 'yes';

					

	// 			}elseif($employee == 0)

	// 			{

	// 				return 'no';

	// 			}

	// 	  	}elseif($userrole == 'supportstaff')

	// 	  {			  

	// 		$acess = DB::table('tbl_accessrights')->where('menu_name','=',$menu_name)->first();

	// 		$support_staff = $acess->support_staff;

	// 		if($support_staff == 1)

	// 		{

	// 			return 'yes';

				

	// 		}elseif($support_staff == 0)

	// 		{

	// 			return 'no';

	// 		}

	// 	  }

	// 	  elseif($userrole == 'accountant')

	// 	  {			  

	// 		$acess = DB::table('tbl_accessrights')->where('menu_name','=',$menu_name)->first();

	// 		$accountant = $acess->accountant;

	// 		if($accountant == 1)

	// 		{

	// 			return 'yes';

				

	// 		}elseif($accountant == 0)

	// 		{

	// 			return 'no';

	// 		}

	// 	  }	

	// }
		return 'yes';

}

}



// Get active Admin list in data list

if (!function_exists('getActiveAdmin')) {

	function getActiveAdmin($id)

	{	

		

		// $data  = DB::table('users')->where('id','=',$id)->first();

		

		// if(!empty($data))

		// {

		// 	$userrole = $data->role;

		// 	if($userrole == 'admin')

		// 	{

				

		// 		return "yes";

				

		// 	}

		// 	else

		// 	{	

		// 		return "no";

		// 	}

		// }
		return 'yes';

	}

}

// Get active Customer list in data list

if (!function_exists('getActiveCustomer')) {

	function getActiveCustomer($id)
	{	
		// $data  = DB::table('users')->where('id','=',$id)->first();
		// if(!empty($data))
		// {
		// 	$userrole = $data->role;

		// 	if($userrole == 'admin' || $userrole == 'supportstaff' || $userrole == 'accountant')
		// 	{
		// 		return "yes";

				

		// 	}

		// 	else

		// 	{	

		// 		return "no";

		// 	}

		// }
		return 'yes';

	}

  }



 // Get active Employee list in data list

if (!function_exists('getActiveEmployee')) {

	function getActiveEmployee($id)

	{	

		

		// $data  = DB::table('users')->where('id','=',$id)->first();

		

		// if(!empty($data))

		// {

		// 	$userrole = $data->role;

		// 	if($userrole == 'employee')

		// 	{

				

		// 		return "yes";

		// 	}

		// 	else

		// 	{

				

		// 		return "no";

		// 	}

		// }
		return 'yes';

	}

  }

  

  // Get active Admin list in data list

if (!function_exists('getCustomersactive')) {

	function getCustomersactive($id)

	{	

		

		// $data  = DB::table('users')->where('id','=',$id)->first();
		// if(!empty($data))

		// {

		// 	$userrole = $data->role;

		// 	if($userrole == 'Customer')

		// 	{

				

		// 		return "yes";

				

		// 	}

		// 	else

		// 	{	

		// 		return "no";

		// 	}

		// }
		return 'yes';

	}

  }

  

// Get active jobcard list in Customer data list

if (!function_exists('getCustomerJobcard')) {

	function getCustomerJobcard($id)

	{	

		

		$service=DB::table('tbl_services')->where([['customer_id','=',$id],['job_no','like','J%']])->get()->toArray();

	

		if(!empty($service))

		{  

	       return "yes";

		}

		else

		{



			return "no";

		}

			

	}

  }





// Get Login Customer in Sales data list



if (!function_exists('getCustomerSales')) {

	function getCustomerSales($id)

	{	

		

		$sales=DB::table('tbl_sales')->where('customer_id','=',$id)->get()->toArray();

	

		if(!empty($sales))

		{  

	       return "yes";

		}

		else

		{



			return "no";

		}

			

	}

  }

  

// Get active Service list in Customer data list

if (!function_exists('getCustomerService')) {

	function getCustomerService($id)

	{	

		

		$service=DB::table('tbl_services')->where([['customer_id','=',$id],['job_no','like','J%']])->get()->toArray();

	

		if(!empty($service))

		{  

	       return "yes";

		}

		else

		{



			return "no";

		}

			

	}

  }



// Get active Customer list in data list

if (!function_exists('getCustomerList')) {

	function getCustomerList($id)

	{	

		

		$data  = DB::table('users')->where('id','=',$id)->first();

		

		if(!empty($data))

		{

			$userrole = $data->role;

			if($userrole == 'Customer'  )

			{

				$service=DB::table('tbl_services')->where([['customer_id','=',$id],['job_no','like','J%'],['done_status','=',1]])->get()->toArray();

				if(!empty($service))

				{  

				   return "yes";

				}

				else

				{



					return "no";

				}

			

			}

			else

			{

				return "no";

			}

		}

	}

  }



 

  // Count Number of service in dashboard

if (!function_exists('getNumberOfService')) {

	function getNumberOfService($id)

	{	

		$y = date("Y");

		$m = date("m");

		

		$d = $id;

		

		$datess = "$y/$m/$d";

		

		$data = DB::table('tbl_services')->where('done_status','!=',2)->whereDate('service_date','=',$datess)->count();

		

		return $data;

	}

  }



  

  

  // Current  stock 

if (!function_exists('getCurrentStock')) {

	function getCurrentStock($p_id)

	{	

		$stockproduct=DB::table('tbl_service_pros')->where('product_id','=',$p_id)->get()->toArray();

			$selltotal=0;

			foreach($stockproduct as $stockproducts)

			{

				$qty=$stockproducts->quantity;

				$selltotal +=$qty;

			}

			

			$allstock=DB::table('tbl_purchase_history_records')->where('product_id','=',$p_id)->get()->toArray();

			$alltotal=0;

			foreach($allstock as $allstocks)

			{

				$qtys=$allstocks->qty;

				$alltotal +=$qtys;

			}

			

			$currentstock=$alltotal - $selltotal;

			return $currentstock;

	}

  }



// Get logo system in app blade



if (!function_exists('getLogoSystem')) {

	function getLogoSystem()

	{	

		

		$logo = DB::table('tbl_settings')->first();

		$logo_image=$logo->logo_image;

			return $logo_image;

		

	}

}



// Get  system name in app blade



if (!function_exists('getNameSystem')) {

	function getNameSystem()

	{	

		

		$system_name = DB::table('tbl_settings')->first();

		$system_name=$system_name->system_name;

			return $system_name;

		

	}

}

// Get date format in all project

if (!function_exists('getDateFormat')) {

	function getDateFormat()

	{	

		

		$dateformat=DB::table('tbl_settings')->first();

		

		if(!empty($dateformat))

		{

			$dateformate= $dateformat->date_format;

			return $dateformate;

			// if($dateformate == 'm-d-Y')

			// {

				// $dateformats= "mm-dd-yyyy";

				// return $dateformats;

			// }

			// elseif($dateformate == 'Y-m-d')

			// {

				// $dateformats= "yyyy-mm-dd";

				// return $dateformats;

			// }

			// elseif($dateformate == 'd-m-Y')

			// {

				// $dateformats= "dd-mm-yyyy";

				// return $dateformats;

			// }

			// elseif($dateformate == 'M-d-Y')

			// {

				// $dateformats= "M-dd-yyyy";

				// return $dateformats;

			// }

			

		}	

		

	}

}





// Get date format in datepicker

if (!function_exists('getDatepicker')) {

	function getDatepicker()

	{	

		$dateformat=DB::table('tbl_settings')->first();

		$dateformate= $dateformat->date_format;

		if(!empty($dateformate))

		{

			if($dateformate == 'm-d-Y')

			{

				$dateformats= "mm-dd-yyyy";

				return $dateformats;

			}

			elseif($dateformate == 'Y-m-d')

			{

				$dateformats= "yyyy-mm-dd";

				return $dateformats;

			}

			elseif($dateformate == 'd-m-Y')

			{

				$dateformats= "dd-mm-yyyy";

				return $dateformats;

			}

			elseif($dateformate == 'M-d-Y')

			{

				$dateformats= "MM-dd-yyyy";

				return $dateformats;

			}

			

		}	

	}

}



// Get date format in Datetimepicker

if (!function_exists('getDatetimepicker')) {

	function getDatetimepicker()

	{	

		

		$dateformate= getDateFormat();

		if(!empty($dateformate))

		{

			if($dateformate == 'm-d-Y')

			{

				$dateformats= "mm-dd-yyyy hh:ii:ss";

				return $dateformats;

			}

			elseif($dateformate == 'Y-m-d')

			{

				$dateformats= "yyyy-mm-dd  hh:ii:ss";

				return $dateformats;

			}

			elseif($dateformate == 'd-m-Y')

			{

				$dateformats= "dd-mm-yyyy hh:ii:ss";

				return $dateformats;

			}

			elseif($dateformate == 'M-d-Y')

			{

				$dateformats= "M-dd-yyyy hh:ii:ss";

				return $dateformats;

			}

			

		}	

	}

}

// Get Day Name in View Of general_setting 

if (!function_exists('getDayName')) {

	function getDayName($id)

	{	

		

		switch ($id) {

		    case "1":

		        return "Monday";

		        break;

		    case "2":

		        return "Tuesday";

		        break;

		    case "3":

		        echo "Wednesday";

		        break;

		    case "4":

		        return "Thursday";

		        break;

		    case "5":

		        return "Friday";

		        break;

		    case "6":

		        echo "Saturday";

		        break;

		     case "7":

		        return "Sunday";

		        break;

		   



		    default:

		        echo "Sunday";

         }

		

    }

}



// Get from open hours time in View Of general_setting 

if (!function_exists('getOpenHours')) {

	function getOpenHours($id)

	{	

		$tbl_hours=DB::table('tbl_business_hours')->where('from','=',$id)->first();

		$pm = $tbl_hours->from;

			if($pm >=12)

			{ 

				if($pm == 12)

				{

					$pmfinal=$pm;

					$final=$pmfinal.''.":00 PM";

					 return $final;

				}

				else

				{

					$pmfinal=$pm-12;

					$final=$pmfinal.''.":00 PM";

					return $final;

				}

			}

			else

			{

				if($pm == 0)

				{

					$pmfinal=$pm +12;

					$final=$pmfinal.''.":00 AM";

					return $final;

				}

				else

				{

					$pmfinal=$pm;

					$final=$pmfinal.''.":00 AM";

					return $final;

				}

			}

	}

}



// Get close hours time in View Of general_setting 

if (!function_exists('getCloseHours')) {

	function getCloseHours($id)

	{	

		$tbl_hours=DB::table('tbl_business_hours')->where('to','=',$id)->first();

		$am = $tbl_hours->to;

			if($am >=12)

			{ 

				if($am == 12)

				{

					$pmfinal=$am;

					$final=$pmfinal.''.":00 PM";

					return $final;

				}

				else

				{

					$pmfinal=$am-12;

					$final=$pmfinal.''.":00 PM";

					return $final;

				}

			}

			else

			{

				if($am == 0)

				{

					$pmfinal=$am +12;

					$final=$pmfinal.''.":00 AM";

					return $final;

				}

				else

				{

					$pmfinal=$am;

					$final=$pmfinal.''.":00 AM";

					return $final;

				}

			}

	}

}



//Get data  value in custom field



if (!function_exists('getCustomData')) {

	function getCustomData($tbl_custom,$userid)

	{

	   $userdata=DB::table('users')->where('id','=',$userid)->first();

	   

	   $jsonn=$userdata->custom_field;

	   

		$jsonns = json_decode($jsonn);

		if(!empty($jsonns))

		{

			foreach ($jsonns as $key=>$value)

			{

					$ids = $value->id;

					$value1 = $value->value;

					

					

					if($tbl_custom == $ids)

					 {

						return $value1;

					 }

					

			}

		}

	} 

		

	}



// Get Currency symbols in all module



if (!function_exists('getCurrencySymbols')) {

	function getCurrencySymbols()

	{	

		

		$setting = DB::table('tbl_settings')->first();

		$id=$setting->currancy;

		

		$currancy= DB::table('currencies')->where('id','=',$id)->first();

		

		if(!empty($currancy))

		{

			$symbol = $currancy->symbol;

			 return $symbol;

		}

		

	}

}





// Get current stock in stock  module



if (!function_exists('getStockCurrent')) {

	function getStockCurrent($id)

	{	

		

		$product = DB::table('tbl_stock_records')->where('product_id','=',$id)->first();

		$stock=$product->no_of_stoke;

		

		$cellstock=DB::table('tbl_service_pros')->where('product_id','=',$id)->get()->toArray();

		$celltotal=0;

		foreach($cellstock as $cellstocks)

		{

			$cell_stock=$cellstocks->quantity;

			$celltotal += $cell_stock;		

		}

	

		if(!empty($product))

		{

			$finalstock= $stock - $celltotal;

			 return $finalstock;

		}

		

	}

}



// Get  languagechange

if (!function_exists('getLanguageChange')) {

	function getLanguageChange()

	{	

		

		$userid=Auth::User()->id;

		$data=DB::table('users')->where('id','=',$userid)->first();

		$language=$data->language;

		

		if(!empty($language))

		{

			if($language == 'en')

			{

				$language= "English";

				return $language;

			}

			elseif($language == 'de')

			{

				$language= "Spanish";

				return $language;

			}

			elseif($language == 'gr')

			{

				$language= "Greek";

				return $language;

			}

			elseif($language == 'ar')

			{

				$language= "Arabic";

				return $language;

			}

			elseif($language == 'ger')

			{

				$language= "German";

				return $language;

			}

			elseif($language == 'pt')

			{

				$language= "Portuguese";

				return $language;

			}

			elseif($language == 'fr')

			{

				$language= "french";

				return $language;

			}

			elseif($language == 'it')

			{

				$language= "Italian";

				return $language;

			}

			elseif($language == 'sv')

			{

				$language= "Swedish";

				return $language;

			}

			elseif($language == 'dt')

			{

				$language= "Dutch";

				return $language;

			}

			elseif($language == 'hi')

			{

				$language= "Hindi";

				return $language;

			}

			elseif($language == 'zhcn')

			{

				$language= "Chinese";

				return $language;

			}

		}	

	}

}



// Get Payment Method  in all module



if (!function_exists('GetPaymentMethod')) {

	function GetPaymentMethod($id)

	{	

		

		$tbl_payments = DB::table('tbl_payments')->where('id','=',$id)->first();

		

		if(!empty($tbl_payments))

		{

			$payment=$tbl_payments->payment;

			 return $payment;

		}

		else{

			if($id =='')

			{

				$payment='';

			     return $payment;

			}

			else

			{

				$payment='stripe';

				 return $payment;

			}

		}

		

	}

}



// Get Unit  name in Stock module



if (!function_exists('getUnitMeasurement')) {

	function getUnitMeasurement($id)

	{

		

		$tbl_products = DB::table('tbl_products')->where('id','=',$id)->get()->toArray();

		

		if(!empty($tbl_products))

		{

			 $unit = array();

			 foreach($tbl_products as $tbl_productss)

			 { 

				 $unit[] = $tbl_productss->unit;

			 }

			 

			$tbl_product_units = DB::table('tbl_product_units')->where('id','=',$unit)->first();

			if(!empty($tbl_product_units))

			{

				$name= $tbl_product_units->name;

				

				return $name;

			}

			else

			{

				return '';

			}

		}

		else

		{

			return '';

		}

	}

	}

			

// Get  purchase date

if (!function_exists('getPurchaseDate')) {

	function getPurchaseDate($id)

	{	

		

		$tbl_purchases = DB::table('tbl_purchases')->where('id','=',$id)->first();

		

		if(!empty($tbl_purchases))

		{

			$date = $tbl_purchases->date;

			return $date;

		}

		

	}

}	



// Get PurchaseSupplier

if (!function_exists('getPurchaseSupplier')) {

	function getPurchaseSupplier($id)

	{	

		

		$tbl_purchases = DB::table('tbl_purchases')->where('id','=',$id)->first();

		

		if(!empty($tbl_purchases))

		{

			$supplier_id = $tbl_purchases->supplier_id;

			return $supplier_id;

		}

		

	}

}



// Get  purchase date

if (!function_exists('getPurchaseCode')) {

	function getPurchaseCode($id)

	{	

		

		$tbl_purchases = DB::table('tbl_purchases')->where('id','=',$id)->first();

		

		if(!empty($tbl_purchases))

		{

			$purchase_no = $tbl_purchases->purchase_no;

			return $purchase_no;

		}

		

	}

}



// Gerenarate series number

if(!function_exists('generateSeriesNumber')){

	function generateSeriesNumber($table, $state=''){

		$result=app()->make('stdClass');

		if($table=='vehicle_certificates'){
			$seriesPrefix='UZ-';
			$seriesLength=2;
			$numberLength=6;
			$initialSeries=$seriesPrefix.'AA';
			$initialNumber='000001';
			$lastItem=DB::table($table)
				->where('doc', '!=', 30) // MAVJUD BAZADAN ELEKTRON BAZAGA O"TKAZISH
				->latest()->first();
			if(!empty($lastItem)){
				$s=$initialSeries;
				$s=str_replace($seriesPrefix,'',$s);
				

				// preparing number, considering error lines
				$errorLines=['052913', '052912', '049743', '031234', '073175', '073174', '039488', '000318', '000317', '074883', '075264', '075263', '016330', '074916', '027497', '002621', '043045', '001812', '037244', '000417', '011530', '000394', '043330', '003257', '005515', '005514', '056916', '056915'];
				$n=$lastItem->number;
				if($n=='052913'){ $n = '000026'; } // that's where generating number started working wrong 
				do{
					$n=intval($n);
					$n++;
					$n=(string)($n);
					$digits=strlen($n);
					for($i=$numberLength;$i>$digits;$i--){
						$n='0'.$n;
					}
				} while(in_array($n, $errorLines));
				
				$result->series=$seriesPrefix.$s;
				$result->number=$n;
			}else{
				$result->series=$initialSeries;
				$result->number=$initialNumber;
			}
		}

		if($table=='technical_passports'){
			$seriesPrefix='UZ-';
			$seriesLength=2;
			$numberLength=6;
			$initialSeries=$seriesPrefix.'AA';
			$initialNumber='000001';
			$lastItem=DB::table('technical_passports')
				->where('doc', '!=', 18) // MAVJUD BAZADAN ELEKTRON BAZAGA O"TKAZISH
				->whereNotIn('technical_passports.number', ['008682', '008683', '008684']) // WE HAVE THESE CASES WRONG IN DATABASE. SO WE ARE SKIPPING THIS NUMBERS
				->latest()->first();
			if(!empty($lastItem)){
				$s=$initialSeries;
				$s=str_replace($seriesPrefix,'',$s);
				$n=intval($lastItem->number);
				if($n==8681){ $n=8684; } // SKIPPING USED NUMBERS (BECAUSE OF ERROR)
				$n++;
				$n=(string)($n);
				$digits=strlen($n);
				for($i=$numberLength;$i>$digits;$i--){
					$n='0'.$n;
				}
				$result->series=$seriesPrefix.$s;
				$result->number=$n;
			}else{
				$result->series=$initialSeries;
				$result->number=$initialNumber;
			}
		}

		if($table=='driver_licences' && $state){
			$seriesPrefix='UZ-';
			$seriesLength=2;
			$numberLength=6;
			$initialSeries=$seriesPrefix.'AA';
			$initialNumber='000001';
			$lastItem=DB::table($table)->latest()->first();
			if(!empty($lastItem)){
				$s=$initialSeries;
				$s=str_replace($seriesPrefix,'',$s);
				$n=intval($lastItem->number);
				$n++;
				$n=(string)($n);
				$digits=strlen($n);
				for($i=$numberLength;$i>$digits;$i--){
					$n='0'.$n;
				}
				$result->series=$seriesPrefix.$s;
				$result->number=$n;
			}else{
				$result->series=$initialSeries;
				$result->number=$initialNumber;
			}


			$state=DB::table('tbl_states')->where('id','=',$state)->first();

			$series=$state->series;
			$result->local_series=$series;

			$initialNumber='000001';
			$numberLength=6;

			$lastItem=DB::table($table)
				//->join('users','users.id','=',$table.'.user_id')
				//->whereRaw('FIND_IN_SET(?,users.state_id)',[$state->id])
				->where('driver_licences.local_series', '=',  $state->series)
				->select($table.'.*')
				->latest()->first();

			if(!empty($lastItem)){
				$n=intval($lastItem->local_number);
				$n++;
				$n=(string)($n);
				$digits=strlen($n);
				for($i=$numberLength;$i>$digits;$i--){
					$n='0'.$n;
				}
				
				$result->local_number=$n;
			}else{
				$result->local_number=$initialNumber;
			}
		}
		return $result;
	}
}

if(!function_exists('getRegistrationNotifications')){
	function getRegistrationNotifications(){
		$registrations=DB::table('vehicle_registrations')
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
			->skip(0)->take(10)->get()->toArray();

		return $registrations;
	}
}

function check_inn($inn){
	if($inn){
		$customer=DB::table('customers')
			->where('inn','=',$inn)
			->where('filial_of', '=', 0)
			->first();
	}
	
	if(!empty($customer)){
		return json_encode([
			'exist'=>true,
			'owner'=>$customer
		]);
	}else{
		return json_encode(['exist'=>false]);
	}
}

// checking personal identification number for existance, while creating new owner
function check_id_number($id){
	if($id){
		$customer=DB::table('customers')
			->where('id_number','=',$id)
			->first();
	}
	
	if(!empty($customer)){
		return json_encode([
			'exist'=>true,
			'owner'=>$customer
		]);
	}else{
		return json_encode(['exist'=>false]);
	}
}


// texnika yoshi - hisobot
function filterVehiclesFirstColumn($vehicle){  // [2015-2019]
	if(!empty($vehicle->modelyear) && (int)$vehicle->modelyear > (int)date('Y')-5){
		return true;
	}else{
		return false;
	}
}
function filterVehiclesSecondColumn($vehicle){
	if(!empty($vehicle->modelyear) && (int)$vehicle->modelyear == (int)date('Y')){
		return true;
	}else{
		return false;
	}
}
function filterVehiclesThirdColumn($vehicle){ // [2010-2014]  6-10 yil
	$m=(int)$vehicle->modelyear;
	$y=(int)date('Y');
	if(!empty($vehicle->modelyear) && $m <= $y-5 && $m > $y-10){
		return true;
	}else{
		return false;
	}
}
function filterVehiclesFourthColumn($vehicle){ // [2005-2009]  11-15 yil
	$m=(int)$vehicle->modelyear;
	$y=(int)date('Y');
	if(!empty($vehicle->modelyear) && $m <= $y-10 && $m > $y-15){
		return true;
	}else{
		return false;
	}
}
function filterVehiclesFifthColumn($vehicle){ // [2000-2004]  16-20 yil
	$m=(int)$vehicle->modelyear;
	$y=(int)date('Y');
	if(!empty($vehicle->modelyear) && $m <= $y-15 && $m > $y-20){
		return true;
	}else{
		return false;
	}
}

// ro'yxatdan o'tgan o'tmagan - hisobot
function filterRegisteredVehicles($vehicle){
	if($vehicle->status=='regged'){
		return true;
	}else{
		return false;
	}
}
function filterUnregisteredVehicles($vehicle){
	if($vehicle->status=='unregged'){
		return true;
	}else{
		return false;
	}
}
function filterValidVehicles($vehicle){
	if($vehicle->condition=='fit'){
		return true;
	}else{
		return false;
	}
}
function getUnreggedVehicleDocument($vehicle){
	if($vehicle->type=='vehicle'){
		$table='technical_passports';
	}elseif($vehicle->type=='agregat'){
		$table='vehicle_certificates';
	}
	if(isset($table)){
		$document=DB::table($table)
			->join('vehicle_registrations',function($join){
				$join->on('vehicle_registrations.vehicle_id','=',$table.'.vehicle_id')
					->on('vehicle_registrations.owner_id','=',$table.'.owner_id');
			})->where('vehicle_registrations.action','=','unregged')
			->where($table.'.status','=','inactive')
			->where($table.'.vehicle_id','=',$vehicle->id)
			->latest()->first();
		return $document;
	}
	return false;
}
function filterVehiclesWithDocument($vehicle){
	$document=getUnreggedVehicleDocument($vehicle);
	if(!empty($document) && $document->series && $document->number){
		return true;
	}else{
		return false;
	}
}

function getTransportNumberByPassport($tP){
	if(!$tP) return;
	$transport_number=DB::table('transport_numbers')
		->where('transport_numbers.vehicle_id','=',$tP->vehicle_id)
		->where('transport_numbers.owner_id','=',$tP->owner_id)
		->whereDate('transport_numbers.given_date','<=',$tP->given_date)
		->orderBy('transport_numbers.given_date','DESC')
		->first();
	return $transport_number;
}

function getActiveTransportNumber($vehicleId){
	$transport_number=DB::table('transport_numbers')->where('vehicle_id','=',$vehicleId)->where('status','=','active')->first();
	return $transport_number;
}

// get tr. number that was active before tr. was unregged
function getLastActiveTransportNumber($vehicleId){
	$transport_number=DB::table('transport_numbers')->where('vehicle_id','=',$vehicleId)->where('status','=','inactive')->latest()->first();
	if(!empty($transport_number)){
		return json_encode($transport_number);
	}else{
		return json_encode(['result'=>'not-found']);
	}
}

function getActiveTechPassport($vehicleId){
	$tPassport=DB::table('technical_passports')
		->where('vehicle_id','=',$vehicleId)
		->where('technical_passports.status','=','active')
		->first();
	return $tPassport;
}

function getActiveCertificate($vehicleId){
	$tPassport=DB::table('vehicle_certificates')
		->where('vehicle_id','=',$vehicleId)
		->where('vehicle_certificates.status','=','active')
		->first();
	return $tPassport;
}

function getActiveProhibition($vehicleId){
	$prohibition=DB::table('vehicle_prohibitions')
		->where('vehicle_id','=',$vehicleId)
		->where('vehicle_prohibitions.status','=','active')
		->first();
	return $prohibition;
}

function getLastRegistration($vehicle){
	return DB::table('vehicle_registrations')
		->where('vehicle_registrations.vehicle_id','=',$vehicle->id)
		->where('vehicle_registrations.owner_id','=',$vehicle->owner_id)
		->orderBy('vehicle_registrations.date','DESC')
		->first();
}

function getLastProhibition($vehicle, $action='lock'){
	return DB::table('vehicle_prohibitions')
		->where('vehicle_prohibitions.vehicle_id', '=', $vehicle->id)
		->where('vehicle_prohibitions.owner_id', '=', $vehicle->owner_id)
		->where('vehicle_prohibitions.action', '=', $action)
		->orderBy('vehicle_prohibitions.date', 'DESC')
		->first();
}

function compareIncomeEntries($a,$b){
	$aDate=strtotime($a->date);
	$bDate=strtotime($b->date);
	if($aDate==$bDate){
		$aDate=strtotime($a->created_at);
		$bDate=strtotime($b->created_at);
		if($aDate==$bDate){
			return 0;
		}else{
			return ($aDate > $bDate) ? -1 : 1;
		}
	}else{
		return ($aDate > $bDate) ? -1 : 1;
	}
}

function getVehicle($vehicleId){
	$vehicle=DB::table('tbl_vehicles')
		->join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicles.vehicletype_id')
		->join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')
		->leftJoin('customers','customers.id','=','tbl_vehicles.owner_id')
		->where('tbl_vehicles.id','=',$vehicleId)
		->first();

	return $vehicle;
}

function numberFormat($number,$format='',$precision=2){
	if($format=='million'){
		return round($number/1000000 , $precision);
	}
}

// Check access has no/yes

if (!function_exists('CheckAccessUser')) {

	function CheckAccessUser($keyname, $id , $action)
	{
		$user  = DB::table('users')->where('id','=',$id)->get()->first();
		if(!empty($user))
		{
			if($user->role == 'admin'){
				return "yes";
			}else{
				$userrole = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($userrole)){
					$useraction = DB::table('tbl_roles')->where([['role_id', '=', $userrole->id], ['key_name', '=', $keyname]])->get()->first();
					if(!empty($useraction)){
						if($action == 'read'){
							if($useraction->read == '1'){
								return 'yes';
							}else{
								return 'no';
							}
						}elseif($action == 'create'){
							if($useraction->create == '1'){
								return 'yes';
							}else{
								return 'no';
							}
						}elseif($action == 'edit'){
							if($useraction->edit == '1'){
								return 'yes';
							}else{
								return 'no';
							}
						}elseif($action == 'delete'){
							if($useraction->delete == '1'){
								return 'yes';
							}else{
								return 'no';
							}
						}else{
							return 'no';
						}
					}else{
						return 'no';
					}
				
				}else{
					return 'no';
				}
				
			}
		}else{
			return 'no';
		}

	}

}

if (!function_exists('CheckAdmin')) {

	function CheckAdmin($id)
	{
		$user  = DB::table('users')->where('id','=',$id)->get()->first();
		if(!empty($user))
		{
			if($user->role == 'admin'){
				return "yes";
			}else{
				return "no";
				
			}
		}else{
			return 'no';
		}

	}

}
if (!function_exists('CheckPosition')) {

	function CheckPosition($id)
	{
		$user  = DB::table('users')->where('id','=',$id)->get()->first();
		if(!empty($user))
		{
			if($user->role == 'admin'){
				return "admin";
			}else{
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				return $position->name;
			}
		}else{
			return 'no';
		}

	}

}
if (!function_exists('getPosition')) {

	function getPosition($id)
	{
		$user  = DB::table('users')->where('id','=',$id)->get()->first();
		if(!empty($user))
		{
			if($user->role == 'admin'){
				return "admin";
			}else{
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				return $position->position;
			}
		}else{
			return 'no';
		}

	}

}

// getting service name for documents
function getServiceName($service){
	if($service=='registration'){
		return 'Texnikani ro\'yxatga qo\'yish';
	}elseif($service=='driver-license'){
		return 'Traktorchi-mashinist guvohnomasi berish';
	}elseif($service=='technical-passport'){
		return 'Texnik pasport berish';
	}elseif($service=='number'){
		return 'Davlat raqami belgisi berish';
	}elseif($service=='certificate'){
		return 'Texnik guvohnoma berish';
	}
}

// FUNCTIONS FOR DASHBOARD PAGE
function getTechnicalPassports($user, $limit = null, $from = null, $till = null){
	$passports=DB::table('technical_passports')->
		join('customers','customers.id','=','technical_passports.owner_id')->
		join('tbl_vehicles','tbl_vehicles.id','=','technical_passports.vehicle_id')->
		join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicles.vehicletype_id')->
		join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')->
		leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$passports = $passports->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$passports = $passports->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$passports = $passports->where(function($query) use($user){
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
		$timeField='technical_passports.given_date';
		$passports=$passports->whereDate($timeField,'>=',$fromTime)
			->whereDate($timeField,'<=',$tillTime);
	}


	$passports=$passports->select(
			'technical_passports.*',
			'customers.name as owner_name',
			'customers.middlename as owner_middlename',
			'customers.lastname as owner_lastname',
			'customers.city_id',
			'tbl_vehicle_types.vehicle_type as vehicle_type',
			'tbl_vehicle_brands.vehicle_brand as vehicle_brand'
		//)->orderBy('technical_passports.number','DESC')
		)->latest();

	if($limit){
		$passports = $passports->paginate($limit);
	}else{
		$passports = $passports->get();
	}

	foreach($passports as $tP){
		$transport_number=getTransportNumberByPassport($tP);
		if($transport_number){
			$tP->number_code=$transport_number->code;
			$tP->number_series=$transport_number->series;
			$tP->number_number=$transport_number->number;
		}else{
			$tP->number_code='';
			$tP->number_series='';
			$tP->number_number='';
		}
	}

	return $passports;
}

function getCertificates($user, $limit = null, $from = null, $till = null){
	$certificates=DB::table('vehicle_certificates')->
		join('customers','customers.id','=','vehicle_certificates.owner_id')->
		join('tbl_vehicles','tbl_vehicles.id','=','vehicle_certificates.vehicle_id')->
		join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicles.vehicletype_id')->
		join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')->
		leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$certificates = $certificates->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$certificates = $certificates->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$certificates = $certificates->where(function($query) use($user){
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
		$timeField='vehicle_certificates.given_date';
		$certificates=$certificates->whereDate($timeField,'>=',$fromTime)
			->whereDate($timeField,'<=',$tillTime);
	}


	$certificates=$certificates->select(
		'vehicle_certificates.*',
		'customers.name as owner_name',
		'customers.middlename as owner_middlename',
		'customers.lastname as owner_lastname',
		'customers.city_id',
		'tbl_vehicle_types.vehicle_type as vehicle_type',
		'tbl_vehicle_brands.vehicle_brand as vehicle_brand'
	)->latest();

	if($limit){
		$certificates = $certificates->paginate($limit);
	}else{
		$certificates = $certificates->get();
	}

	return $certificates;
}

function getDriverLicenses($user, $limit=null, $from = null, $till = null){
	$driverLicences=DB::table('driver_licences')->
		join('customers','customers.id','=','driver_licences.owner_id')->
		leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$driverLicences = $driverLicences->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$driverLicences = $driverLicences->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$driverLicences = $driverLicences->where(function($query) use($user){
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
			$timeField='driver_licences.given_date';
			$driverLicences=$driverLicences->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}

		$driverLicences=$driverLicences->select(
			'driver_licences.*',
			'customers.lastname',
			'customers.name',
			'customers.middlename',
			'customers.id_number',
			'customers.inn',
			'driver_licences.type as licence_type',
			'tbl_cities.name as city',
			'tbl_states.name as state'
		)->orderBy('driver_licences.number','DESC');
		if($limit){
			$driverLicences = $driverLicences->skip(0)->take($limit)->get()->toArray();
		}else{
			$driverLicences = $driverLicences->get()->toArray();
		}
		

	return $driverLicences;
}



?>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\tbl_payment_types;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class PaymentController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//  get tables and compact
	public function index()
	{   
		$title = "To'lov sozlamalar";
        return view('payment.add', compact('title'));    
	}

	//store vehicaltypes
	public function store()
	{
	 	$name = Input::get('name');
	 	$category = Input::get('category');
	 	$payment = Input::get('payment');
		$count = DB::table('tbl_payment_types')->where([['name','=',$name],['category', '=', $category]])->count();
		if ($count==0)
		{
			$paymentname = new tbl_payment_types;
			$paymentname->name = $name;
			$paymentname->category = $category;
			$paymentname->payment = $payment;
			$paymentname-> save();
			return redirect('/payment/list')->with('message','Successfully Submitted');
	 	}
	 	else
		{
			 
	 	 	return redirect('/payment/add')->with('message','Duplicate data');
	 	} 	 
	}

	//vehicaltype list
	public function list()
	{
		$title = "To'lov sozlamalar";
        $payments= DB::table('tbl_payment_types')->where('category', '!=', 'min')->orderBy('category','DESC')->get()->toArray();
        $min_p = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
 	 	return view('payment.list',compact('payments', 'title', 'min_p'));
	}

	//vehicaltype delete
	public function destory($id)
	{
        $payment = DB::table('tbl_payment_types')->where('id','=',$id)->delete();
		
        return redirect('/payment/list')->with('message','Successfully Deleted');
	}

	//vehicaltype edit form
	public function edit($id)
	{
		$title = "Tahrirlash";
        $editid=$id;
        $min_p = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
        $payment = DB::table('tbl_payment_types')->where('id','=',$id)->first();
		return view('payment.edit',compact('payment','editid', 'payment', 'title', 'min'));
	}

	//vehicaltype update
	public function update($id)
	{		
		$name=Input::get('name');
		$category = Input::get('category');
		$payment = Input::get('payment');
				$paymentname= tbl_payment_types::find($id);
				$paymentname->payment = $payment;
				$paymentname->name = $name;
				$paymentname->save();
				return redirect('payment/list')->with('message','Successfully Updated');
	 	
	}

	public function technical_pass()
	{
		$type = Input::get('type');
		if($type == 'certificate'){
			$category = 'vehicle_cer';
		}elseif($type == 'passport'){
			$category = 'vehicle_pass';
		}
		$payment = Input::get('payment');
		$data = DB::table('tbl_payment_types')->where([['category', '=', $category], ['code', '=', 'rec'], ['key_payment', '=', $payment]])->get()->first();
		echo $data->payment;
	}

	public function vehicle_med(){
		$id = Input::get('type');
		$payment = DB::table('tbl_payment_types')->where('id', '=', $id)->get()->first();
		echo $payment->payment;
	}
	public function vehicle_reg(){
		$id = Input::get('id');
		$vehicle = DB::table('tbl_vehicles')->where('id', '=', $id)->get()->first();
		$min = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
		if($vehicle->type == 'vehicle'){
			$payment = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'new'], ['key_payment', '=', 'vehicle']])->get()->first();
		}elseif($vehicle->type = 'agregat'){
			$payment = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'new'], ['key_payment', '=', 'agregat']])->get()->first();
		}elseif($vehicle->type = 'tirkama'){
			$payment = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_reg'], ['code', '=', 'new'], ['key_payment', '=', 'tirkama']])->get()->first();
		}
		echo $min->payment*($payment->payment/100);
	}
	public function driver_licence(){
		$type = Input::get('type');
		$reason = Input::get('reason');
		$min = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
		if (!empty($type)) {
			$payment = DB::table('tbl_payment_types')->where([['category', '=', 'driver_lic'], ['code', '=', 'new'], ['key_payment', 'like', '%'.$type.'%']])->get()->first();
			echo $min->payment*($payment->payment/100);
		}elseif(!empty($reason)){
			$payment = DB::table('tbl_payment_types')->where([['category', '=', 'driver_lic'], ['code', '=', 'rec'], ['key_payment', '=', $reason]])->get()->first();
			echo $min->payment*($payment->payment/100);
		}
		
	}
	public function reg_out(){
		$id = Input::get('id');
		$min = DB::table('tbl_payment_types')->where('category', '=', 'min')->get()->first();
		$vehicle = DB::table('tbl_vehicles')->where('id', '=', $id)->get()->first();
		$payment = DB::table('tbl_payment_types')->where([['category', '=', 'vehicle_out'], ['key_payment', '=', $vehicle->type]])->get()->first();
		echo $min->payment*($payment->payment/100);

	}
}
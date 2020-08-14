<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\tbl_sales;
use App\tbl_services;
use App\tbl_sales_taxes;
use App\tbl_colors;
use App\tbl_vehicals;
use App\tbl_rto_taxes;
use App\Http\Requests;
use DB;
use URL;
use App\tbl_mail_notifications;
use Mail;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Input;

class Supportstaffcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//supportstaff add form
	public function supportstaffadd()
	{	
		$country = DB::table('tbl_countries')->get()->toArray();
		return view('supportstaff.add',compact('country'));
	}
	
	//supportstaff store
	public function store_supportstaff(Request $request)
	{		
		
		 $this->validate($request, [  
         'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		 'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		 'displayname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		 'email'=>'unique:users',
		 'password'=>'required|min:6',
         'mobile'=>'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
         'landlineno'=>'max:15|regex:/^[- +()]*[0-9][- +()0-9]*$/',	
		 'password_confirmation' => 'required|same:password',
		 'image' => 'image|mimes:jpg,png,jpeg',
	      ],[
			'displayname.regex' => 'Enter valid display name',
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
			'landlineno.regex' => 'Enter valid landline no',
		]);
	
		$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		$displayname=Input::get('displayname');
		$gender=Input::get('gender');
		 if(getDateFormat()== 'm-d-Y')
		{
			$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
		}
		else
		{
			$dob=date('Y-m-d',strtotime(Input::get('dob')));
		}
		$email=Input::get('email');
		$password=Input::get('password');
		$mobile=Input::get('mobile');
		$landlineno=Input::get('landlineno');
		$address=Input::get('address');
		$country=Input::get('country_id');
		$state=Input::get('state_id');
		$city=Input::get('city');
					
			$supportstaff = new User;
			$supportstaff->name=$firstname;
			$supportstaff->lastname=$lastname;
			$supportstaff->display_name=$displayname;
			$supportstaff->gender=$gender;
			$supportstaff->birth_date=$dob;
			$supportstaff->email=$email;
			$supportstaff->password=bcrypt($password);
			$supportstaff->mobile_no=$mobile;
			$supportstaff->landline_no=$landlineno;
			$supportstaff->address=$address;
			$supportstaff->country_id=$country;
			$supportstaff->state_id=$state;
			$supportstaff->city_id=$city;
			if(!empty(Input::hasFile('image')))
			{
			$file= Input::file('image');
			$filename=$file->getClientOriginalName();
			$file->move(public_path().'/supportstaff/', $file->getClientOriginalName());
			$supportstaff->image=$filename;
			}else
			{
				$supportstaff->image='avtar.png';
			}			
			$supportstaff->role="supportstaff";
			$supportstaff->language="en";
			$supportstaff->timezone="UTC";
			
			$supportstaff -> save();
			
			//email format
			$logo = DB::table('tbl_settings')->first();
			$systemname=$logo->system_name;
			$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
			if($emailformats->is_send == 0)
			{
			if($supportstaff -> save())
			{
				$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
				$mail_format = $emailformat->notification_text;		
				$mail_subjects = $emailformat->subject;		
				$mail_send_from = $emailformat->send_from;
				$search1 = array('{ system_name }');
				$replace1 = array($systemname);
				$mail_sub = str_replace($search1, $replace1, $mail_subjects);	

				$systemlink = URL::to('/');	
				$search = array('{ system_name }','{ user_name }', '{ email }', '{ Password }', '{ system_link }' );
				$replace = array($systemname, $firstname, $email, $password, $systemlink);
				
				$email_content = str_replace($search, $replace, $mail_format);
				$actual_link = $_SERVER['HTTP_HOST'];
			     $startip='0.0.0.0';
			    $endip='255.255.255.255';
				if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
				{
				
					//local format email
				
					$data=array(
					'email'=>$email,
					'mail_sub1' => $mail_sub,
					'email_content1' => $email_content,
					'emailsend' =>$mail_send_from, 
					);
					$data1 =	Mail::send('customer.customermail',$data, function ($message) use ($data){

						$message->from($data['emailsend'],'noreply');

						$message->to($data['email'])->subject($data['mail_sub1']);

					});
				}
				else
				{
					//live format email
				
					$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:'. $mail_send_from . "\r\n";
					$data = mail($email,$mail_sub,$email_content,$headers);
				}
				
				
			}	
			}			
		    return redirect('/supportstaff/list')->with('message','Successfully Submitted');
	}
	
	//supportstaff list
	public function index()
	{    
	
	    $supportstaff=DB::table('users')->where('role','=','supportstaff')->orderBy('id','DESC')->get()->toArray();
	
		return view('supportstaff.list',compact('supportstaff'));
	}
	
	//supportstaff show
	public function supportstaff_show($id)
	{	
		$viewid = $id;
	    $supportstaff=DB::table('users')->where('id','=',$id)->first();
		$service=DB::table('tbl_services')->where([['customer_id','=',$id],['done_status','=','1']])->get()->toArray();
	
		$servic=DB::table('tbl_services')->where([['customer_id','=',$id],['done_status','=','2']])->get()->toArray();
		
		$sales=DB::table('tbl_sales')->where('customer_id','=',$id)->get()->toArray();
		$taxes = DB::table('tbl_sales_taxes')->where('sales_id','=',$id)->get()->toArray();
		//$rto = DB::table('tbl_rto_taxes')->where('vehical_id','=',$v_id)->first();
		return view('supportstaff.view',compact('supportstaff','viewid','sales','service','vehicale','salese','servic'));
	}
	
	//supportstaff delete
     public function destory($id)	
	 {		  
		  $supportstaff = DB::table('users')->where('id','=',$id)->delete();		  
		  return redirect('/supportstaff/list')->with('message','Successfully Deleted');
	 }	

	 //supportstaff edit
     public function edit($id)
	 {   
	    $editid=$id;
		$country = DB::table('tbl_countries')->get()->toArray();
		$state = DB::table('tbl_states')->get()->toArray();
		$city = DB::table('tbl_cities')->get()->toArray();
		$supportstaff=DB::table('users')->where('id','=',$id)->first();
		 return view('supportstaff.update',compact('country','supportstaff','state','city','editid'));
	 }	

	//supportstaff update
    public function update($id, Request $request)
	{
		$this->validate($request, [  
        'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		'displayname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		'password'=>'nullable|min:6|max:12|regex:/(^[A-Za-z0-9]+$)+/',
        'mobile'=>'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
        'landlineno'=>'max:15|regex:/^[- +()]*[0-9][- +()0-9]*$/',
		'password_confirmation' => 'nullable|same:password',
		'image' => 'image|mimes:jpg,png,jpeg',
	      ],[
			'displayname.regex' => 'Enter valid display name',
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
			'landlineno.regex' => 'Enter valid landline no',
		]);
		   
			$usimgdtaa = DB::table('users')->where('id','=',$id)->first();
			$email = $usimgdtaa->email;
				if($email != Input::get('email'))
				{
				$this->validate($request, [
					'email' => 'required|email|unique:users'				   
				]);
				}
		   
		$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		$displayname=Input::get('displayname');
		$gender=Input::get('gender');
		if(getDateFormat()== 'm-d-Y')
		{
			$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
		}
		else
		{
			$dob=date('Y-m-d',strtotime(Input::get('dob')));
		}
		$email=Input::get('email');
		$password=(Input::get('password'));
		$mobile=Input::get('mobile');
		$landlineno=Input::get('landlineno');
		$address=Input::get('address');
		$country=Input::get('country_id');
		$state=Input::get('state_id');
		$city=Input::get('city');
		
		    $supportstaff = User::find($id);		
		    $supportstaff->name=$firstname;
			$supportstaff->lastname=$lastname;
			$supportstaff->display_name=$displayname;
			$supportstaff->gender=$gender;
			$supportstaff->birth_date=$dob;				
			$supportstaff->email=$email;		
			if(!empty($password)){
				$supportstaff->password=bcrypt($password);
			}			
			$supportstaff->mobile_no=$mobile;
			$supportstaff->landline_no=$landlineno;
			$supportstaff->address=$address;
			$supportstaff->country_id=$country;
			$supportstaff->state_id=$state;
			$supportstaff->city_id=$city;
			
			if(!empty(Input::hasFile('image')))
			{
				$file= Input::file('image');
				$filename=$file->getClientOriginalName();
				$file->move(public_path().'/supportstaff/', $file->getClientOriginalName());
				$supportstaff->image=$filename;
			}		
			$supportstaff->role="supportstaff";
			
			$supportstaff -> save();
			
			//email format
			$logo = DB::table('tbl_settings')->first();
			$systemname=$logo->system_name;
			$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
			if($emailformats->is_send == 0)
			{
			if($supportstaff -> save())
			{
				$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
				$mail_format = $emailformat->notification_text;		
				$mail_subjects = $emailformat->subject;		
				$mail_send_from = $emailformat->send_from;
				$search1 = array('{ system_name }');
				$replace1 = array($systemname);
				$mail_sub = str_replace($search1, $replace1, $mail_subjects);
				$systemlink = URL::to('/');
				$search = array('{ system_name }','{ user_name }', '{ email }', '{ Password }', '{ system_link }' );
				$replace = array($systemname, $firstname, $email, $password, $systemlink);
				
				$email_content = str_replace($search, $replace, $mail_format);
				
				$actual_link = $_SERVER['HTTP_HOST'];
			    $startip='0.0.0.0';
			    $endip='255.255.255.255';
				if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
				{
					//local format email
				
					$data=array(
					'email'=>$email,
					'mail_sub1' => $mail_sub,
					'email_content1' => $email_content,
					'emailsend' =>$mail_send_from, 
					);
					$data1 =	Mail::send('customer.customermail',$data, function ($message) use ($data){

							$message->from($data['emailsend'],'noreply');

							$message->to($data['email'])->subject($data['mail_sub1']);

						});
				}
				else
				{
					//live format email
				
					$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:'. $mail_send_from . "\r\n";
					$data = mail($email,$mail_sub,$email_content,$headers);
				}
				
				
			}		
			}
		    return redirect('/supportstaff/list')->with('message','Successfully Updated');
	}		
}
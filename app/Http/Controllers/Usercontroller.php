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

class Usercontroller extends Controller
{
	
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_users(){
    	$stateId=Input::get('stateId');
    	$cityId=Input::get('cityId');

    	$users=DB::table('users');

    	if($stateId && $stateId!=='all'){
    		$users=$users->whereRaw('FIND_IN_SET(?,state_id)',[$stateId]);
    	}

    	if($cityId && $cityId!=='all'){
    		$users=$users->whereRaw('FIND_IN_SET(?,city_id)',[$cityId]);
    	}

    	$users=$users->get()->toArray();

    	if(!empty($users)){
    		foreach($users as $user){ ?>
    			<option value="<?=$user->id;?>" <?= count($users)==1?'selected="selected"':''; ?> ><?=$user->name.' '.$user->lastname; ?></option>
    		<?php }
    	}
    }
	
	//accountant addform
	public function accountantadd()
	{	
		$country = DB::table('tbl_countries')->get()->toArray();
		return view('accountant.add',compact('country'));
	}
	
	//accountant store
	public function storeaccountant(Request $request){
		$this->validate($request, [  
        'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		'displayname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		'email'=>'unique:users',
		'password'=>'min:6',
        'mobile'=>'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
        'landlineno'=>'max:15|regex:/^[- +()]*[0-9][- +()0-9]*$/',
		'password_confirmation' => 'required|same:password',
		'image' => 'image|mimes:jpg,png,jpeg',
		'dob'=> 'required',
	      ],[
			'displayname.regex' => 'Enter valid display name',
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
			'landlineno.regex' => 'Enter valid landline no',
			'mobile.regex' => 'Enter valid mobile no',
		]);
		
		$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		$displayname=Input::get('displayname');
		$gender=Input::get('gender');
		if(getDateFormat() == 'm-d-Y')
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
		
			
		$accountant = new User;
		$accountant->name=$firstname;
		$accountant->lastname=$lastname;
		$accountant->display_name=$displayname;
		$accountant->gender=$gender;
		$accountant->birth_date=$dob;
		$accountant->email=$email;
		$accountant->password=bcrypt($password);
		$accountant->mobile_no=$mobile;
		$accountant->landline_no=$landlineno;
		$accountant->address=$address;
		$accountant->country_id=$country;
		$accountant->state_id=$state;
		$accountant->city_id=$city;
		if(!empty(Input::hasFile('image')))
		{
		$file= Input::file('image');
		$filename=$file->getClientOriginalName();
		$file->move(public_path().'/accountant/', $file->getClientOriginalName());
        $accountant->image=$filename;
		}else{
			$accountant->image='avtar.png';
		}
		
		$accountant->role="accountant";
		$accountant->timezone="UTC";
		$accountant->language="en";
		$accountant -> save();
		
		//email format
		$logo = DB::table('tbl_settings')->first();
		$systemname=$logo->system_name;
		$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
		if($emailformats->is_send == 0)
		{
		if($accountant -> save())
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
				$data1 =	Mail::send('customer.customermail',$data, function (		$message) use ($data){

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
		return redirect('/accountant/list')->with('message','Successfully Submitted');
	}
	
	//accountant list
	public function index(){    
	    $accountant=DB::table('users')->where('role','=','accountant')->orderBy('id','DESC')->get()->toArray();
		return view('accountant.list',compact('accountant'));
	}
	
	
	//accountant show
	public function usershow($id)
	{	
		$viewid = $id;
	    $user=DB::table('users')->where('id','=',$id)->first();
		return view('user.view',compact('user','title','viewid'));
	}
        
	//accountant delete
	public function destory($id)	
	 {  
		$accountant = DB::table('users')->where('id','=',$id)->delete();
		return redirect('/accountant/list')->with('message','Successfully Deleted');
	 }	

    //accountant edit
	public function accountantedit($id)
	{   
	    $editid=$id;
		$country = DB::table('tbl_countries')->get()->toArray();
		$state = DB::table('tbl_states')->get()->toArray();
		$city = DB::table('tbl_cities')->get()->toArray();
		$accountant=DB::table('users')->where('id','=',$id)->first();
		return view('accountant.update',compact('country','accountant','state','city','editid'));
	}	

	//accountant update
    public function accountantupdate($id, Request $request)
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
		'dob'=> 'required',
	      ],[
			'displayname.regex' => 'Enter valid display name',
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
			'landlineno.regex' => 'Enter valid landline no',
			'mobile.regex' => 'Enter valid mobile no',
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
		if(getDateFormat() == 'm-d-Y')
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
		
		    $accountant = User::find($id);
		    $accountant->name=$firstname;
			
			$accountant->lastname=$lastname;
			$accountant->display_name=$displayname;
			$accountant->gender=$gender;
			$accountant->birth_date=$dob;
			$accountant->email=$email;
		
			if(!empty($password)){
			$accountant->password=bcrypt($password);
			}
			
			$accountant->mobile_no=$mobile;
			$accountant->landline_no=$landlineno;
			$accountant->address=$address;
			$accountant->country_id=$country;
			$accountant->state_id=$state;
			$accountant->city_id=$city;
			
			if(!empty(Input::hasFile('image')))
			{
			$file= Input::file('image');
			$filename=$file->getClientOriginalName();
			$file->move(public_path().'/accountant/', $file->getClientOriginalName());
            $accountant->image=$filename;
			}
			
			$accountant->role="accountant";
			
			$accountant -> save();
			
			//email format
			$logo = DB::table('tbl_settings')->first();
			$systemname=$logo->system_name;
			$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
			if($emailformats->is_send == 0)
			{
			if($accountant -> save())
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
		    return redirect('/accountant/list')->with('message','Successfully Updated');
	}		
}
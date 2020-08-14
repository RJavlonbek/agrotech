<?php



namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\Http\Requests;

use DB;

use Auth;

use URL;

use App\tbl_mail_notifications;
use App\tbl_activities;

use Mail;

use Illuminate\Mail\Mailer;



class employeecontroller extends Controller

{

	public function __construct(){
        $this->middleware('auth');
    }

	

	// employee list

   public function employeelist(){
	    $user=Auth::User();
		$users = DB::table('users')->
			select(
				'users.*',
				'tbl_accessrights.name as position'
				)->
			join('tbl_accessrights', 'tbl_accessrights.id', '=', 'users.role');
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$users = $users->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('users.city_id', 'like', intval($city));
						}
					});
				}elseif($position->position == 'country'){
					$users = $users->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$cities = DB::table('tbl_cities')->where('state_id', '=', intval($state))->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('users.city_id','=',$city->id);
							}
							
						}
					});
				}elseif($position->position == 'region'){
					$users = $users->where(function($query) use($user){
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							$query->orWhere('users.city_id', '=', $city->id);
						}
					});
				}
			}
		}
		$users = $users->where('users.id', '!=', $user->id)->orderBy('id','DESC')->get()->toArray();
		return view('employee.list',compact('users'));
   }

   

   // employee addform

   public function addemployee()
   {

   		$states = DB::table('tbl_states')->get()->toArray();
   		$country = DB::table('tbl_countries')->get()->toArray();
		$roles = DB::table('tbl_accessrights')->where('status', '=', 'active')->get()->toArray();

	   return view('employee.add',compact('country', 'roles', 'states'));

   }

   

   // employee store

   	public function store(Request $request){
		$firstname=Input::get('firstname');
		$email=Input::get('email');

		$password=Input::get('password');
		$city = Input::get('city');
		$state = Input::get('state');
		$text = '';
		for ($i = 0; $i < count($city); $i++) {
			if($i == 0){
				$text .= $city[$i];
			}else{
				$text .= ','.$city[$i];
			}

		}
		$city = $text;
		$text = '';
		for ($i = 0; $i < count($state); $i++) {
			if($i == 0){
				$text .= $state[$i];
			}else{
				$text .= ','.$state[$i];
			}
		}
		$state = $text;
		if(getDateFormat() == 'm-d-Y'){
			$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
			$join_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('join_date'))));
			$leftdate=Input::get('left_date');
			if($leftdate == ''){
				$left_date="";
			}else{
				$left_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('left_date'))));
			}
		}else{
			$dob=date('Y-m-d',strtotime(Input::get('dob')));
			$join_date=date('Y-m-d',strtotime(Input::get('join_date')));
			$leftdate=Input::get('left_date');
			if($leftdate == ''){
				$left_date="";
			}
			else{
				$left_date=date('Y-m-d',strtotime(Input::get('left_date')));
			}
		}

		$user = new User;
		$user->name =$firstname;  
		$user->lastname = Input::get('lastname');
		$user->display_name = Input::get('displayname');
		$user->gender = Input::get('gender');
		$user->birth_date =join('-',array_reverse(explode('-',Input::get('dob'))));
		$user->email = $email;
	    $user->password = bcrypt($password);
		$user->mobile_no = Input::get('mobile');
		$user->landline_no = Input::get('landlineno');
		$user->address = Input::get('address');
		if(!empty(Input::hasFile('image'))){
			$file= Input::file('image');
			$filename=$file->getClientOriginalName();
			$file->move(public_path().'/employee/', $file->getClientOriginalName());
			$user->image = $filename;
		}else{
			$user->image='avtar.png';
		}
		$user->join_date = join('-',array_reverse(explode('-',Input::get('join_date'))));
		$user->left_date = $left_date;
		$user->country_id = Input::get('country_id');
		$user->state_id = $state;
		$user->city_id = $city;
		$user->role = Input::get('role');
		$user->branch_name = Input::get('branchName');
		$user->timezone="UTC";
		$user->language="en";
		$user->save();
		$last_id = DB::table('users')->orderBy('id', 'desc' )->get()->first();
		$userA = Auth::user();
		$active = new tbl_activities;
		$active->ip_adress = $_SERVER['REMOTE_ADDR'];
		$active->user_id = $userA->id;
		$active->action_id = $last_id->id;
		$active->action_type = 'user_added';
		$active->action = "Inspektor qo'shildi";
		$active->time = date('Y-m-d H:i:s');
		$active->save();

		return redirect('/employee/list')->with('message','Successfully Submitted');

	}


	public function getrole(){
		$position = Input::get('position');
		$role = DB::table('tbl_accessrights')->where('id', '=', $position)->get()->first();
		echo $role->position;
	}

	

	// employee edit

	public function edit($id)
	{
		$editid = $id;
		$title = "Xodimni o'zgartirish";
		$user = DB::table('users')->where('id','=', $editid)->get()->first();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$state = DB::table('tbl_states')->get()->toArray();
					$cities = DB::table('tbl_cities')->get()->toArray();
				}elseif($position->position == 'country'){
					$state = DB::table('tbl_states')->where(function($query) use($user){
						foreach (explode(',', $user->state_id) as $city) {
							$query->orWhere('tbl_states.id', '=', $city);
						}
					})->get()->toArray();
					$cities = DB::table('tbl_cities')->where('id', '=', $user->city_id)->get()->toArray();
				}elseif($position->position == 'region'){
					$state = DB::table('tbl_states')->where('id', '=', $user->state_id)->get()->toArray();
					$cities = DB::table('tbl_cities')->where('id', $user->city_id)->get()->toArray();
				}
			}
		}
		$country = DB::table('tbl_countries')->get()->toArray();
		
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		$roles = DB::table('tbl_accessrights')->where('status', '=', 'active')->get()->toArray();
		return view('employee.edit',compact('country','state','cities','user','editid', 'roles', 'position', 'title'));
	}

	

	// employee update

	public function update($id ,Request $request)
	{

		$firstname=Input::get('firstname');
		$email=Input::get('email');
		$password=Input::get('password');
		$city = Input::get('city');
		$state = Input::get('state');
		$text = '';
		for ($i = 0; $i < count($city); $i++) {
				$text .= $city[$i].',';
		}
		$city = $text;
		$text = '';
		for ($i = 0; $i < count($state); $i++) {
			$text .= $state[$i].',';
		}
		$state = $text;
		if(getDateFormat() == 'm-d-Y'){
			$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
			$join_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('join_date'))));
			$leftdate=Input::get('left_date');
			if($leftdate == ''){
				$left_date="";
			}else{
				$left_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('left_date'))));
			}
		}else{
			$dob=date('Y-m-d',strtotime(Input::get('dob')));
			$join_date=date('Y-m-d',strtotime(Input::get('join_date')));
			$leftdate=Input::get('left_date');
			if($leftdate == ''){
				$left_date="";
			}
			else{
				$left_date=date('Y-m-d',strtotime(Input::get('left_date')));
			}
		}
		$userold = DB::table('users')->where('id','=', $id)->get()->first();
		if($userold->role == 'admin'){
			$role = 'admin';
		}else{
			$role = Input::get('role');
		}
		$user = User::find($id);
		$user->name =$firstname;  
		$user->lastname = Input::get('lastname');
		$user->display_name = Input::get('displayname');
		$user->gender = Input::get('gender');
		$user->birth_date =join('-',array_reverse(explode('-',Input::get('dob'))));
		$user->email = $email;
	    if(!empty($password)){
			$user->password = bcrypt($password);
		}
		$user->mobile_no = Input::get('mobile');
		$user->landline_no = Input::get('landlineno');
		$user->address = Input::get('address');
		if(!empty(Input::hasFile('image'))){
			$file= Input::file('image');
			$filename=$file->getClientOriginalName();
			$file->move(public_path().'/employee/', $file->getClientOriginalName());
			$user->image = $filename;
		}
		$user->join_date = join('-',array_reverse(explode('-',Input::get('join_date'))));
		$user->left_date = $left_date;
		$user->country_id = Input::get('country_id');
		$user->state_id = $state;
		$user->city_id = $city;
		$user->role = $role;
		$user->branch_name = Input::get('branchName');
		$user->timezone="UTC";
		$user->language="en";
		$user->save();

		$userA = Auth::user();
		$active = new tbl_activities;
		$active->ip_adress = $_SERVER['REMOTE_ADDR'];
		$active->user_id = $userA->id;
		$active->action_id = $id;
		$active->action_type = 'user_edit';
		$active->action = "Inspektor O'zgartrildi";
		$active->time = date('Y-m-d H:i:s');
		$active->save();
		return redirect('/employee/list')->with('message','Successfully Updated');

	}

	// employee show

	public function showemployer($id)

	{
		$viewid = $id;
		$user = DB::table('users')->where('id','=',$id)->first();
		$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
		return view('employee.show',compact('user','viewid','position'));
	}
	public function destory($id)
	{
		$userA = Auth::user();
		$active = new tbl_activities;
		$active->ip_adress = $_SERVER['REMOTE_ADDR'];
		$active->user_id = $userA->id;
		$active->action_id = $id;
		$active->action_type = 'user_deleted';
		$active->action = "Inspektor O'chirildi";
		$active->time = date('Y-m-d H:i:s');
		$active->save();
        $user=DB::table('users')->where('id','=',$id)->delete();
        $tbl_sales=DB::table('tbl_sales')->where('assigne_to','=',$id)->delete();
        $tbl_services=DB::table('tbl_services')->where('assign_to','=',$id)->delete();

        return redirect('employee/list')->with('message','Successfully Deleted');
	}

}


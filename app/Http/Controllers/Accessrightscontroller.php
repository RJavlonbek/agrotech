<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth; 

use DB;

use App\tbl_accessrights;

use App\tbl_roles;

use App\User;

use Illuminate\Support\Facades\Input;



class Accessrightscontroller extends Controller

{

	public function __construct()

    {

        $this->middleware('auth');

    }

	

	//accessright list

	public function addposition()
	{	
		$position = new tbl_accessrights;
		$position->name = 'Lavozim nomini kiriting';
		$position->status = 'inactive';
		$position->save();
		$last = DB::table('tbl_accessrights')->orderBy('id', 'desc')->get()->first();
		$rolename = array(
			1 => array(
				'name'=>"Mulk egalari qoshish",
				'key'=>"customer_add"
			),
			2 => array(
					'name' => "Texnika qo'shish",
					'key' => "vehicle_add"
			),
			3 => array(
				'name'=>"Davlat Raqami berish",
				'key'=>"vehicle_num"
			),
			4 => array(
				'name'=>"Texnik ko'rikdan o'tkazish",
				'key'=>"vehicle_med"
			),
			5 => array(
				'name'=>"Ro'yhatga olish",
				'key'=>"vehicle_reg"
			),
			6 => array(
				'name'=>"Taqiqqa olish/chiqarish",
				'key'=>"vehicle_lock"
			),
			7 => array(
				'name'=>"Haydovchilik guvohnomasi berish",
				'key'=>"driver_lic"
			),
			8 => array(
				'name'=>"Haydovchilik imtixonlari",
				'key'=>"driver_exam"
			),
			9 => array(
				'name'=>"Texnikaga passport/guvohnoma berish",
				'key'=>"vehicle_pass"
			),
			10 => array(
				'name'=>"To'lovlar hisoboti",
				'key'=>"report_pay"
			),
			11 => array(
				'name'=>"Yangi texnika hisoboti",
				'key'=>"report_new"
			),
			12 => array(
				'name'=>"Mavjud texnika hisoboti",
				'key'=>"report_exist"
			),
			13 => array(
				'name'=>"Ro'yhatdan o'tganlar hisoboti",
				'key'=>"report_reg"
			),
			14 => array(
				'name'=>"Texnika yoshi hisoboti",
				'key'=>"report_old"
			),
			15 => array(
				'name' => "Sozlamalar",
				'key' => "setting"
			),
			16 => array(
				'name'=>"Barcha tushumlar hisoboti - Respublika",
				'key'=>'latest_income_republic'
			)

		);

		for($i = 1; $i<=count($rolename); $i++){

			$role = new tbl_roles;

			$role->name = $rolename[$i]['name'];

			$role->key_name = $rolename[$i]['key'];

			$role->role_id = $last->id;

			$role->create = 0;

			$role->read = 0;

			$role->edit = 0;

			$role->delete = 0;

			$role->save();

		}

		$roles = DB::table('tbl_roles')->where('role_id', '=', $last->id)->get()->toArray();



		

		return view('accessrights.add', compact('last', 'roles', 'rolename'));

	}

	public function storeposition(){

		$name = Input::get('position');

		$carera = Input::get('carera');

		$id = Input::get('id');

		$new_role = tbl_accessrights::find($id);

		$new_role->name = $name;

		$new_role->position = $carera;

		$new_role->status = 'active';

		$new_role->save();

		return redirect('/setting/accessrights/list')->with('message', 'Successfully Submitted');

	}

	public function edit($id){

		$position = DB::table('tbl_accessrights')->where('id', '=', $id)->get()->first();

		$roles = DB::table('tbl_roles')->where('role_id', '=', $position->id)->get()->toArray();

		return view('accessrights.edit', compact('position', 'roles'));

	}

	public function delete($id){

		DB::table('tbl_accessrights')->where('id', '=', $id)->delete();

		DB::table('tbl_roles')->where('role_id', '=', $id)->delete();

		return redirect('/setting/accessrights/list')->with('message','Successfully Deleted');

	}

    public function index()

	{	

		$accessright=DB::table('tbl_accessrights')->where('status', '=', 'active')->get()->toArray();

		return view('accessrights.accessright',compact('accessright'));

	}

	

	//accessright change_role

	public function change_role()

	{

		$type=Input::get('role_type');

		$value = Input::get('value');

		$id = intval(Input::get('role_id'));

		if($type == 'create'){

			$new = tbl_roles::find($id);

			$new->create = $value;

			$new->save();

			//DB::update("update `tbl_roles` set create=`$value` where id=`$id`");

		}elseif($type == 'edit'){

			$new = tbl_roles::find($id);

			$new->edit = $value;

			$new->save();

		}elseif($type == 'read'){

			$new = tbl_roles::find($id);

			$new->read = $value;

			$new->save();

		}elseif($type == 'delete'){

			$new = tbl_roles::find($id);

			$new->delete = $value;

			$new->save();

		}

		

	}

}


<?php



namespace App\Http\Controllers;

use App\User;
use Auth;
use App\documents;
use App\tbl_activities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;



class DocsController extends Controller{
	public function __construct(){
        $this->middleware('auth');
    }

	
	//docs list

    public function index(){	
    	$title='Asos hujjatlar';
		$color = DB::table('documents')->orderBy('id','DESC')->get()->toArray();

		return view('docs.list',compact('color','title')); 

	}

	

	//docs addform
	public function add_doc(){	
		$title='Asos hujjat qo\'shish';
		return view('docs.add',compact('title')); 
	}

	

	//docs store
	public function store(Request $request){	
		$name= Input::get('name');
		$service=Input::get('service');

		$count =DB::table('documents')->where('name','=',$name)->count();

		//if($count == 0){
			$colors = new documents;
			$colors->name=$name;
			$colors->service=$service;
			$colors->save();

			$active = new tbl_activities;
			$active->ip_adress = $_SERVER['REMOTE_ADDR'];
			$active->user_id = Auth::user()->id;
			$active->action_type = 'docs_add';
			$active->action = "Asos hujjat qo'shildi";
			$active->time = date('Y-m-d H:i:s');
			$active->save();
			return redirect('/docs/list')->with('message','Successfully Submitted');
	 	//}else{
			//return redirect('/docs/add')->with('message','Duplicate Data');
	 	//}
	}

	

	//docs delete

	public function destroy($id){
		$colors = DB::table('documents')->where('id','=',$id)->delete();
		$active = new tbl_activities;
			$active->ip_adress = $_SERVER['REMOTE_ADDR'];
			$active->user_id = Auth::user()->id;
			$active->action_type = 'docs_delete';
			$active->action = "Asos hujjat o'chirildi";
			$active->time = date('Y-m-d H:i:s');
			$active->save();
		return redirect('/docs/list')->with('message','Successfully Deleted');
	}

	

	//docs edit

	public function edit($id)

	{	
		$title='Asos hujjatni tahrirlash';
		$editid = $id;
		$colors = DB::table('documents')->where('id','=',$id)->first();
		return view('docs.edit',compact('colors','editid','title'));
	}

	

	//docs update

	public function update($id){
		$color = documents::find($id);
		$name=Input::get('name');
		$service=Input::get('service');
		$count =DB::table('documents')->where([['name','=',$name],['id','!=',$id]])->count();

		if($count == 0){
			$color->name = $name;
			$color->service=$service;
			$color->save();
			$active = new tbl_activities;
			$active->ip_adress = $_SERVER['REMOTE_ADDR'];
			$active->user_id = Auth::user()->id;
			$active->action_type = 'docs_add';
			$active->action = "Asos hujjat o'zgartrildi";
			$active->time = date('Y-m-d H:i:s');
			$active->save();
			return redirect('/docs/list')->with('message','Successfully Updated');
		}else{
			return redirect('/docs/list/edit/'.$id)->with('message','Duplicate Data');  
		}
	}

}	


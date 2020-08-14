<?php



namespace App\Http\Controllers;

use App\User;
use App\tbl_supplier;

use App\tbl_custom_fields;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\Http\Requests;

use DB;

use timezone;

class Suppliercontroller extends Controller

{	

	public function __construct()

    {

        $this->middleware('auth');

    }

	

	//supplier list

    public function supplierlist()

	{	
		$title='Texnika yetkazib beruvchilar';
		$suppliers = DB::table('tbl_suppliers')->orderBy('name')->get()->toArray();
		// $product = DB::table('tbl_products')->where('supplier_id','=',$id)->first();
		return view('supplier.list',compact('suppliers','title'));
	}

	

	//supplier add in user_tbl

	public function adddata()

	{	

		$supllier = new User;

		$supllier->name = Input::get('name');

		$supplier->save();

	}

	

	//supplier add form

	public function supplieradd()

	{	

		$country = DB::table('tbl_countries')->get()->toArray();

		$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','supplier'],['always_visable','=','yes']])->get()->toArray();

	   return view('supplier.add',compact('country','tbl_custom_fields'));

	}

	

	//supplier store

	public function storesupplier(Request $request){
		$supplier=new tbl_supplier;
		$supplier->name=Input::get('name');
		$supplier->save();	
		return redirect('/supplier/list')->with('message','Successfully Submitted');

	}

	

	//supplier show

	public function showsupplier($id)

	{	

		$viewid = $id;		

		$user = DB::table('users')->where([['role','=','Supplier'],['id','=',$id]])->first();

		$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','supplier'],['always_visable','=','yes']])->get()->toArray();

		return view('supplier.show',compact('user','viewid','tbl_custom_fields'));

	}

	

	//supplier delete

	public function destroy($id)

	{	

		$user = DB::table('tbl_suppliers')->where('id','=',$id)->delete();

		return redirect('/supplier/list')->with('message','Successfully Deleted');

	}

	

	//supplier edit

	public function edit($id)

	{	

		$editid = $id;

		$supplier=DB::table('tbl_suppliers')->where('id','=',$editid)->first();
		if($supplier){
			$title=$supplier->name.' - Tahrirlash';
			return view('supplier.edit',compact('supplier','title'));
		}else{
			return 'Yetkazib beruvchi topilmadi';
		}
	}

	

	//supplier update

	public function update(Request $request, $id)

	{
		$supplier=tbl_supplier::find($id);
		$supplier->name=Input::get('name');
		$supplier->save();
		return redirect('/supplier/list')->with('message','Successfully Updated');

	}

}	


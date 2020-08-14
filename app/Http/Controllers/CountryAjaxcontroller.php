<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\tbl_states;
use App\tbl_cities;
use Auth; 
use DB;
use \Validator;
use Illuminate\Support\Facades\Input;

class CountryAjaxcontroller extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }
	
	//get state
    public function getstate()
	{ 
			$id = Input::get('countryid');
			
			$states = DB::table('tbl_states')->where('country_id','=',$id)->get()->toArray();
			if(!empty($states))
			{
				foreach($states as $statess)
				{ ?>
				
				<option value="<?php echo  $statess->id; ?>"  class="states_of_countrys"><?php echo $statess->name; ?></option>
				
				<?php }
			}
	}
	
	//get city
	public function getcity()
	{ 
		$stateid = Input::get('stateid');
		$citie = DB::table('tbl_cities')->where('state_id','=',$stateid)->get()->toArray();
		if(!empty($citie))
		{
			foreach($citie as $cities)
			{ ?>
			
			<option value="<?php echo  $cities->id; ?>"  class="cities"><?php echo $cities->name; ?></option>
			
			<?php }
		}
	}

	public function getcitiesjson(){
		$stateid = Input::get('stateId');
		if($stateid){
			$cities = DB::table('tbl_cities')->where('state_id','=',$stateid)->get()->toArray();
			return json_encode($cities);
		}
	}

	public function edit_city(){
		$cityId=Input::get('cityId');
		$name=Input::get('name');
		DB::table('tbl_cities')->where('id','=',$cityId)->update(['name'=>$name]);
	}

	public function add_city(){
		$cityName=Input::get('city');
		$stateId=Input::get('stateId');
		
		$count = DB::table('tbl_cities')->where('name','=',$cityName)->where('state_id','=',$stateId)->count();
		
		if ($count==0){
			$city = new tbl_cities;
			$city->name = $cityName;
			$city->state_id=$stateId;
			$city->save();
			echo $city->id;		
		}
		else{
			return "01";
		}
	}

	public function getcityfromsearch(){
		$search=Input::get('search');
		$cities=DB::table('tbl_cities')
			->join('tbl_states','tbl_states.id','=','tbl_cities.state_id')
			->where('tbl_cities.name','like','%'.$search.'%')
			->where('tbl_states.country_id','=',234)
			->select('tbl_cities.*')
			->get()->toArray();
		if(!empty($cities)){
			echo json_encode($cities);
		}else{
			echo 'empty';
		}
	}

	public function update_state(){
		$stateid=Input::get('stateId');
		$state=tbl_states::find($stateid);
		$state->name=Input::get('name');
		$state->code=Input::get('code');
		$state->save();
		echo 'success';
	}
}

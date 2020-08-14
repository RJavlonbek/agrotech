<?php

namespace App\Exports;
use Illuminate\Http\Request;
use App\DriverLicence;
use App\Http\Requests;
use DateTime;
use PDO;
use DB;
use URL;
use auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class ExportVehicle implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
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
		join('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
		join('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
		join('vehicle_works_fors', 'tbl_vehicles.working_for_id', '=', 'vehicle_works_fors.id')->
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
				->where('vehicle_id','=',$vehicle->id)
				->where('action','=','regged')
				->whereDate('date','>=',$fromTime)
				->whereDate('date','<=',$tillTime)
				->orderBy('date','DESC')
				->first();
			if(empty($lastRegRecord)){
				unset($vehical[$key]);
			}
		}
		$vehical = $vehical->get()->toArray();
		
		$data_head[] = array();
		$i = 1;
		if(!empty($vehical)){
			foreach($vehical as $key => $vehicals){
				$lock = DB::table('vehicle_prohibitions')->where('vehicle_id', '=', $vehicals->id)->latest()->first();
				$vehicals->tps = 'inactive';
				if($vehicals->type == 'vehicle' || $vehicals->type == 'tirkama'){
					$tech_p = DB::table('technical_passports')->where('vehicle_id', '=', $vehicals->id)->latest()->first();
					if(!empty($tech_p)){
						$vehicals->tps = $tech_p->status;
						$vehicals->pass = $tech_p->series;
						$vehicals->pasn = $tech_p->number;
					}
				}elseif($vehicals->type == 'agregat'){
					$tech_p = DB::table('vehicle_certificates')->where('vehicle_id', '=', $vehicals->id)->latest()->get()->first();
					if(!empty($tech_p)){
						$vehicals->tps = $tech_p->status;
						$vehicals->pass = $tech_p->series;
						$vehicals->pasn = $tech_p->number;
					}
				}
				$vehicals->lock = null;
				if(!empty($lock))
				{
					if ($lock == 'lock') {
						$vehicals->lock = true;
					}
				}
				$data_head[] = array(
					'#' =>$i,
					'Rusumi' => $vehicals->brandname,
					'Turi' => $vehicals->typename,
					'Egasi' => ($vehicals->ownertype=='legal')?$vehicals->ownername:$vehicals->ownerlastname.' '.$vehicals->ownername,
					'Ishlash sohasi' => $vehicals->workname,
					'Davlat raqami' => ($vehicals->type == 'agregat')?'—':(($vehicals->tns == 'active')?$vehicals->code.' '.$vehicals->series.' '.$vehicals->number:'Davlat raqami berilmagan'),
					'Texnik pasport' => ($vehicals->tps == 'active')?$vehicals->pass.'-'.$vehicals->pasn:'Texnik passport berilmagan',
					'Qo\'shimcha' => ($vehicals->lising == '1')?'Lisingda':($vehicals->lock == null)?'':'Taqiqda',
				);
				$i++;
			}
		}
        return collect($data_head);
    }

    public function headings(): array
    {
        return [
            '#', 
            'Rusumi', 
            'Turi', 
            'Egasi', 
            'Ishlash sohasi', 
            'Davlat raqami', 
            'Texnik pasport', 
            'Qo\'shimcha',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A2:H200000')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
				]);
            },
        ];
    }
}
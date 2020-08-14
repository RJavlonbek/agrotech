<?php

namespace App\Exports;
use Illuminate\Http\Request;
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

class ExportNumbers implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
    {

    	$from=Input::get('from');
		$till=Input::get('till');
		$title="Davlat raqamlari";
		$numbers=DB::table('transport_numbers')->
			join('customers','customers.id','=','transport_numbers.owner_id')->
			join('tbl_vehicles','tbl_vehicles.id','=','transport_numbers.vehicle_id')->
			join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicles.vehicletype_id')->
			join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')->
			join('tbl_states','tbl_states.id','=','transport_numbers.state_id')->
			join('tbl_cities','tbl_cities.id','=','customers.city_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$numbers = $numbers->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$numbers = $numbers->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$numbers = $numbers->where(function($query) use($user){
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
			$timeField='transport_numbers.given_date';
			$numbers=$numbers->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}

		// search engine
		$s = Input::get('s');
		if($s){
			$numbers = $numbers->where(function($query) use($s){
				$columnsForSearch = [
					DB::raw("CONCAT(UPPER(transport_numbers.code), ' ', UPPER(transport_numbers.series), ' ', UPPER(transport_numbers.number))"),
					'tbl_vehicle_brands.vehicle_brand',
					'tbl_vehicle_types.vehicle_type',
					'tbl_states.name',
					'tbl_vehicles.engineno',
					'customers.inn',
					DB::raw("CONCAT(UPPER(customers.lastname), ' ', UPPER(customers.name), ' ', UPPER(customers.middlename))"),
					'customers.name'
				];
				foreach($columnsForSearch as $col){
					$query = $query->orWhere($col, 'like', '%'.$s.'%');
				}
			});
		}

		$numbers=$numbers->select(
			'transport_numbers.*',
			'customers.name as owner_name',
			'customers.middlename as owner_middlename',
			'customers.lastname as owner_lastname',
			'customers.city_id',
			'tbl_vehicle_types.vehicle_type as vehicle_type',
			'tbl_vehicle_brands.vehicle_brand as vehicle_brand',
			'tbl_states.name as state'
		)
		//->orderBy('driver_licences.number','DESC')->get()->toArray();
		->get()->toArray();

		$datetime1 = new DateTime(date('d-m-Y'));

	 	$data_head[] = array();
		$i = 1;

		if(!empty($numbers)){
			foreach($numbers as $number){
			
				$data_head[] = array(
					'#' =>$i,
					'Davlat raqami' => $number->code.' '.$number->series.' '.$number->number,
					'Tip' => $number->type,
					'Egasi' => $number->owner_lastname.' '.$number->owner_name.' '.$number->owner_middlename,
					'Texnika' => $number->vehicle_type.' '.$number->vehicle_brand,
					'Berilgan hudud' => $number->state,
					'Berilgan sana' => date('d.m.Y',strtotime($number->given_date)),
					'Holati' => (($number->status=='active'))?'Faol':'Faolmas',
					'To\'lov' => $number->total_amount
				);
				$i++;
			}
		}
        // return $data_head;
        return collect($data_head);
    }

    public function headings(): array
    {
        return [
            '#', 
            'Davlat raqami', 
            'Tip', 
            'Egasi', 
            'Texnika', 
            'Berilgan hudud', 
            'Berilgan sana', 
            'Holati',
            'To\'lov',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A2:H260000')->applyFromArray([
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
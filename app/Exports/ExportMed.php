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

class ExportMed implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
    {

    	$from=Input::get('from');
		$till=Input::get('till');
		$meds = DB::table('vehicle_inspections')->
		select(
			'customers.name as owner_name',
			'customers.middlename as owner_middlename',
			'customers.lastname as owner_lastname',
			'customers.type as ownertype',
			'customers.id as owner_id', 
			'tbl_vehicle_types.vehicle_type as typename', 
			'vehicle_inspections.id', 
			'vehicle_inspections.status', 
			'vehicle_inspections.date as givendate', 
			'vehicle_inspections.talonno', 
			'vehicle_inspections.created_at',
			'tbl_vehicle_brands.vehicle_brand as brandname', 
			'transport_numbers.series', 
			'transport_numbers.number', 
			'transport_numbers.code', 
			'transport_numbers.status as tns', 
			'vehicle_inspections.total_amount',
			'tbl_payment_types.name as inspection_type',
			'tbl_vehicles.type as vehicle'
		)->
	 	join('tbl_vehicles', 'vehicle_inspections.vehicle_id', '=', 'tbl_vehicles.id')->
	 	join('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
	 	join('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
	 	leftjoin('transport_numbers', function($join){
			$join->on('tbl_vehicles.id', '=', 'transport_numbers.vehicle_id')->
			where('transport_numbers.status', '=', 'active');
		})->
		join('customers', 'tbl_vehicles.owner_id', '=', 'customers.id')->
		join('tbl_payment_types','tbl_payment_types.id','=','vehicle_inspections.type')->
		leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$meds = $meds->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$meds = $meds->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$meds = $meds->where(function($query) use($user){
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							$query->orWhere('tbl_cities.id', '=', $city->id);
						}
					});
				}
			}
		}
		$meds = $meds->where('vehicle_inspections.condition', '=', 'active')->orderBy('vehicle_inspections.id', 'desc');

		if($from && $till){
			$fromTime=join('-',array_reverse(explode('-',$from)));
			$tillTime=join('-',array_reverse(explode('-',$till)));
			$timeField='vehicle_inspections.date';
			$meds=$meds->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}

		$meds=$meds->get()->toArray();
		$data_head[] = array();
		$i = 1;

		
		$datetime1 = new DateTime(date('d-m-Y'));


		if(!empty($meds)){
			foreach($meds as $med){

				$datetime2 = new DateTime(date('d-m-Y', strtotime($med->givendate)));
		 		$interval = $datetime1->diff($datetime2);
		 		$med->diff = $interval->format('%a');
			
				$data_head[] = array(
					'#' =>$i,
					'Texnik ko\'rik turi' => $med->inspection_type,
					'Egasi' => $med->owner_lastname.' '.$med->owner_name.' '.$med->owner_middlename,
					'Texnika' => $med->typename.' '.$med->brandname,
					'Davlat raqami' => ($med->vehicle == 'agregat')?'-':(($med->tns == 'active')?$med->code.' '.$med->series.' '.$med->number:'Davlat raqami berilmagan'),
					'Talon raqami' => $med->talonno,
					'To\'lov' => $med->total_amount,
					'Sana' => date('d.m.Y',strtotime($med->givendate))
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
            'Texnik ko\'rik turi',  
            'Egasi', 
            'Texnika', 
            'Davlat raqami',
            'Talon raqami', 
            'To\'lov',
            'Sana',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A2:H26000')->applyFromArray([
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
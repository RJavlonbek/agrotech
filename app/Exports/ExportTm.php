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

class ExportTm implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
    {

    	$from=Input::get('from');
		$till=Input::get('till');
		$vehicles = DB::table('tbl_tms')
			->select(
				'tbl_tms.id',
				'tbl_tms.date',
				'customers.id as owner_id',
				'customers.type as ownertype',
				'customers.name as ownername',
				'customers.lastname as ownerlastname',
				'customers.middlename',
				'customers.city_id',
				'tbl_vehicle_types.vehicle_type as typename',
				'tbl_vehicle_brands.vehicle_brand as brandname',
				'tbl_vehicles.id as vehicle_id',
				'tbl_vehicles.type as vehicle',
				'transport_numbers.status as tns',
				'transport_numbers.code', 
				'transport_numbers.series',
				'transport_numbers.number'

			)->
			join('tbl_vehicles', 'tbl_vehicles.id', '=', 'tbl_tms.vehicle_id')->
			join('customers', 'tbl_vehicles.owner_id', '=', 'customers.id')->
			join('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
			join('tbl_vehicle_types', 'tbl_vehicle_brands.vehicle_id', '=', 'tbl_vehicle_types.id')->
			leftjoin('transport_numbers', function($join){
				$join->on('tbl_vehicles.id', '=', 'transport_numbers.vehicle_id')->
				where('transport_numbers.status', '=', 'active');
			})->
			leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
			leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
			$user=Auth::User();
			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$i = 0;
						$vehicles = $vehicles->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$vehicles = $vehicles->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$vehicles = $vehicles->where(function($query) use($user){
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
			$timeField='tbl_tms.date';
			$vehicles=$vehicles->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}

		$vehicles=$vehicles->orderBy('id', 'desc')->get()->toArray();
		$data_head[] = array();
		$i = 1;

		
		$datetime1 = new DateTime(date('d-m-Y'));


		if(!empty($vehicles)){
			foreach($vehicles as $vehicle){

				
			
				$data_head[] = array(
					'#' =>$i,
					'Egasi' => ($vehicle->ownertype=='legal')?$vehicle->ownername:$vehicle->ownerlastname.' '.$vehicle->ownername,
					'Texnika' => $vehicle->typename.' ('.$vehicle->brandname.')',
					'Davlat raqami' => ($vehicle->vehicle == 'agregat')?'—':(($vehicle->tns == 'active')?$vehicle->code.' '.$vehicle->series.' '.$vehicle->number:'Davlat raqami berilmagan'),
					'Sana' => date('d.m.Y', strtotime($vehicle->date)),
					'Harakat' => 'TM-1 Ma\'lumotnoma berildi'
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
            'Egasi',  
            'Texnika', 
            'Davlat raqami',
            'Sana',
            'Harakat'
            
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A2:H10000')->applyFromArray([
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
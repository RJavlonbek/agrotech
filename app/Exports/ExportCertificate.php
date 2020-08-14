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

class ExportCertificate implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
    {

    	$from=Input::get('from');
		$till=Input::get('till');

		$title="Texnik guvohnomalar";
		$certificates=DB::table('vehicle_certificates')->
			join('customers','customers.id','=','vehicle_certificates.owner_id')->
			join('tbl_vehicles','tbl_vehicles.id','=','vehicle_certificates.vehicle_id')->
			join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicles.vehicletype_id')->
			join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')->
			leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
			leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
			$user=Auth::User();
			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$i = 0;
						$certificates = $certificates->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$certificates = $certificates->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$certificates = $certificates->where(function($query) use($user){
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
			$timeField='vehicle_certificates.given_date';
			$certificates=$certificates->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}

		// search engine
		$s = Input::get('s');
		if($s){
			$certificates = $certificates->where(function($query) use($s){
				$columnsForSearch = [
					DB::raw("CONCAT(UPPER(vehicle_certificates.series), UPPER(vehicle_certificates.number))"),
					'tbl_vehicle_brands.vehicle_brand',
					'tbl_vehicle_types.vehicle_type',
					DB::raw("CONCAT(UPPER(customers.lastname), ' ', UPPER(customers.name), ' ', UPPER(customers.middlename))"),
					'customers.name'
				];
				foreach($columnsForSearch as $col){
					$query = $query->orWhere($col, 'like', '%'.$s.'%');
				}
			});
		}


		$certificates=$certificates->select(
			'vehicle_certificates.*',
			'customers.name as owner_name',
			'customers.middlename as owner_middlename',
			'customers.lastname as owner_lastname',
			'customers.city_id',
			'tbl_vehicle_types.vehicle_type as vehicle_type',
			'tbl_vehicle_brands.vehicle_brand as vehicle_brand'
		)->get()->toArray();


	 	$data_head[] = array();
		$i = 1;
		$datetime1 = new DateTime(date('d-m-Y'));
		if(!empty($passports)){
			foreach($passports as $passport){

				$datetime2 = new DateTime(date('d-m-Y', strtotime($passport->created_at)));
		 		$interval = $datetime1->diff($datetime2);
		 		$passport->day = $interval->format('%a');
			
				$data_head[] = array(
					'#' =>$i,
					'Hujjat' => $passport->series.$passport->number,
					'Egasi' => $passport->owner_lastname.' '.$passport->owner_name.' '.$passport->owner_middlename,
					'Texnika' => $passport->vehicle_type.' '.$passport->vehicle_brand,
					'Berilgan sana' => date('d.m.Y',strtotime($passport->given_date)),
					'Holati' => (($passport->status=='active'))?'Faol':'Faolmas',
					'To\'lov' => $passport->total_amount
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
            'Hujjat',  
            'Egasi', 
            'Texnika', 
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
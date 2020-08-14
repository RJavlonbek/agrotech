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

class ExportLicence implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
    {

    	$from=Input::get('from');
		$till=Input::get('till');
		$title="Traktorchi-mashinist guvohnomalari";



		$driverLicences=DB::table('driver_licences')->
		join('customers','customers.id','=','driver_licences.owner_id')->
		leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$driverLicences = $driverLicences->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$driverLicences = $driverLicences->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$driverLicences = $driverLicences->where(function($query) use($user){
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
			$timeField='driver_licences.given_date';
			$driverLicences=$driverLicences->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}

		// search engine
		$s = Input::get('s');
		if($s){
			$driverLicences = $driverLicences->where(function($query) use($s){
				$columnsForSearch = [
					DB::raw("CONCAT(UPPER(driver_licences.series), UPPER(driver_licences.number))"),
					DB::raw("CONCAT(UPPER(customers.lastname), ' ', UPPER(customers.name), ' ', UPPER(customers.middlename))"),
					'customers.inn',
					'customers.id_number',
					'customers.name'
				];
				foreach($columnsForSearch as $col){
					$query = $query->orWhere($col, 'like', '%'.$s.'%');
				}
			});
		}

		$driverLicences=$driverLicences->select(
			'driver_licences.*',
			'customers.name',
			'customers.middlename',
			'customers.lastname',
			'customers.city_id',
			'customers.id_number',
			'customers.inn',
			'driver_licences.type as licence_type'
		)
		//->orderBy('driver_licences.number','DESC')->get()->toArray();
		->get()->toArray();

		$datetime1 = new DateTime(date('d-m-Y'));
		foreach ($driverLicences as $driver_lic) {
	 		$datetime2 = new DateTime(date('d-m-Y', strtotime($driver_lic->created_at)));
	 		$interval = $datetime1->diff($datetime2);
	 		$driver_lic->day = $interval->format('%a');
	 	}
	 	$data_head[] = array();
		$i = 1;

		if(!empty($driverLicences)){
			foreach($driverLicences as $licence){
				$types=json_decode($licence->licence_type,true);
				$givenTypes=[];
				foreach($types as $t){
					$givenTypes[]=$t['name'];
				}
				$givenTypes=implode(',',$givenTypes);

				$data_head[] = array(
					'#' =>$i,
					'Guvohnoma' => $licence->series.$licence->number,
					'Toifa' => $givenTypes,
					'Haydovchi' => $licence->lastname.' '.$licence->name.' '.$licence->middlename,
					'SHIR/STIR' => $licence->id_number?$licence->id_number:$licence->inn,
					'Given Date' => date('d.m.Y',strtotime($licence->given_date)),
					'Holati' => (($licence->status=='active'))?'Faol':'Faolmas',
					'To\'lov' => $licence->total_amount
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
            'Guvohnoma', 
            'Toifa', 
            'Haydovchi', 
            'SHIR/STIR', 
            'Given Date', 
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
                $event->sheet->getStyle('A2:H25000')->applyFromArray([
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
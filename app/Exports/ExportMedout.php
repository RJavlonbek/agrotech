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

class ExportMedout implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
    {
    	$user = DB::table('users')->where('id','=', Auth::user()->id)->first();
    	$title = "Texnik ko'rik muddati tugagan texnikalar";
    	$meddate = date('Y-m-d', strtotime('-365 days'));
		$medlist = DB::table('vehicle_inspections')
			->select(
				'customers.name as ownername', 
				'customers.lastname as ownerlastname', 
				'customers.middlename', 'customers.type as ownertype', 
				'tbl_vehicle_brands.vehicle_brand as brandname', 
				'vehicle_inspections.date as passeddate', 
				'tbl_vehicle_types.vehicle_type as typename', 
				'tbl_vehicles.id as vehicle_id', 
				'customers.id as owner_id', 
				'customers.city_id', 
				'vehicle_inspections.id',
				'vehicle_inspections.created_at'

			)->
			join('tbl_vehicles', 'vehicle_inspections.vehicle_id', '=', 'tbl_vehicles.id')->
			join('customers', 'vehicle_inspections.owner_id', '=', 'customers.id')->
			join('tbl_vehicle_brands', 'tbl_vehicles.vehiclebrand_id', '=', 'tbl_vehicle_brands.id')->
			join('tbl_vehicle_types', 'tbl_vehicles.vehicletype_id', '=', 'tbl_vehicle_types.id')->
			leftjoin('tbl_cities','tbl_cities.id','=','customers.city_id')->
			leftjoin('tbl_states','tbl_states.id','=','tbl_cities.state_id');

			if($user->role != 'admin'){
				$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
				if(!empty($position)){
					if($position->position == 'district'){
						$i = 0;
						$medlist = $medlist->where(function($query) use($user){
							foreach (explode(',', $user->city_id) as $city) {
								$query->orWhere('tbl_cities.id', '=', $city);
							}
						});
					}elseif($position->position == 'country'){
						$i = 0;
						$medlist = $medlist->where(function($query) use($user){
							foreach(explode(',', $user->state_id) as $state){
								$query->orWhere('tbl_states.id','=',$state);
							}
						});
					}elseif($position->position == 'region'){
						$i = 0;
						$medlist = $medlist->where(function($query) use($user){
							$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
							foreach ($cities as $city) {
								$query->orWhere('tbl_cities.id', '=', $city->id);
							}
						});
					}
				}
			}
		$medlist = $medlist->where('vehicle_inspections.condition', '=', 'active')
			->whereDate('vehicle_inspections.date', '<', $meddate)
			->where([['vehicle_inspections.status', '=', 'pass'], ['tbl_vehicles.status', '=', 'regged']])
		->get()->toArray();
		
		$data_head[] = array();
		$i = 1;
		if(!empty($medlist)){
			foreach($medlist as $item){
				
				$data_head[] = array(
					'#' =>$i,
					'Mulk egasi' => ($item->ownertype=='legal')?$item->ownername:$item->ownerlastname.' '.$item->ownername,
					'Texnika' => $item->typename.'-'.$item->brandname,
					'Texnik ko\'rikdan o\'tgan Sana' => date('d.m.Y',strtotime($item->passeddate))
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
            'Mulk egasi', 
            'Texnika', 
            'Texnik ko\'rikdan o\'tgan Sana'
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A2:E200000')->applyFromArray([
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
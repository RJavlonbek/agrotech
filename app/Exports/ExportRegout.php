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

class ExportRegout implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
    {
    	$user = DB::table('users')->where('id','=', Auth::user()->id)->first();
    	$title = "Ro'yxatdan o'tish muddati tugagan texnikalar";
		$reglist=DB::table('vehicle_registrations')
			->join('tbl_vehicles','tbl_vehicles.id','=','vehicle_registrations.vehicle_id')
			->join('tbl_vehicle_types','tbl_vehicle_types.id','=','tbl_vehicles.vehicletype_id')
			->join('tbl_vehicle_brands','tbl_vehicle_brands.id','=','tbl_vehicles.vehiclebrand_id')
			->join('customers','customers.id','=','vehicle_registrations.owner_id')
			->join('tbl_cities','tbl_cities.id','=','customers.city_id')
			->join('tbl_states','tbl_states.id','=','tbl_cities.state_id')
			->where('vehicle_registrations.action','=','unregged')
			->where('tbl_vehicles.status','=','unregged')
			->whereDate('vehicle_registrations.date','<',date('Y-m-d',strtotime('-10 days')))
			->select(
				'vehicle_registrations.*',
				'tbl_vehicles.modelyear',
				'tbl_vehicle_types.vehicle_type as vehicle_type',
				'tbl_vehicle_brands.vehicle_brand as vehicle_brand',
				'customers.name as owner_name',
				'customers.lastname as owner_lastname',
				'customers.middlename as owner_middlename',
				'customers.id_number',
				'customers.inn',
				'customers.city_id',
				'tbl_cities.name as city',
				'tbl_states.name as state'
			)->orderBy('vehicle_registrations.date')
			->get()->toArray();
		
		$data_head[] = array();
		$i = 1;
		if(!empty($reglist)){
			foreach($reglist as $item){
				
				$data_head[] = array(
					'#' =>$i,
					'Mulk egasi' => $item->owner_lastname.' '.$item->owner_name.' '.$item->owner_middlename,
					'Texnika' => $item->vehicle_type.' - '.$item->vehicle_brand,
					'Texnik ko\'rikdan o\'tgan Sana' => date('d.m.Y',strtotime($item->date)),
					'Address' => $item->state.', '.$item->city
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
            'Texnik ko\'rikdan o\'tgan Sana',
            'Address'
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
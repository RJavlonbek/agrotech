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

class ExportCustomer implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
    {
    	$from=Input::get('from');
		$till=Input::get('till');
		$userid=Auth::User()->id;
		$title="Texnika egalari ro'yxati";
		$customers=DB::table('customers')
			->select(
				'customers.*',
				'ownership_forms.name as ownership_form',
				'tbl_cities.name as city',
				'tbl_states.name as state'
			)
			->join('ownership_forms','ownership_forms.id','=','customers.form')
			->join('tbl_cities','tbl_cities.id','=','customers.city_id')
			->join('tbl_states','tbl_states.id','=','tbl_cities.state_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$customers = $customers->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$customers = $customers->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$customers = $customers->where(function($query) use($user){
						$cities = DB::table('tbl_cities')->where('state_id', '=', intval($user->state_id))->get()->toArray();
						foreach ($cities as $city) {
							$query->orWhere('tbl_cities.id', '=', $city->id);
						}
					});
				}
			}
		}
		if(!empty(Input::get('type'))){
			$type=Input::get('type');
			if($type=='legal'){
				$title='Yuridik shaxslar ro\'yxati';
			}elseif($type=='physical'){
				$title='Jismoniy shaxslar ro\'yxati';
			}
			$customers=$customers->where('type','=',$type);
		}
		if($from && $till){
			$fromTime=join('-',array_reverse(explode('-',$from)));
			$tillTime=join('-',array_reverse(explode('-',$till)));
			$timeField='customers.created_at';
			$customers=$customers->whereDate($timeField,'>=',$fromTime)
			->whereDate($timeField,'<=',$tillTime);
		}
		// search engine
		$s = Input::get('s');
		if($s){
			$customers = $customers->where(function($query) use($s){
				$columnsForSearch = [
					'tbl_states.name',
					'tbl_cities.name',
					DB::raw("CONCAT(UPPER(customers.lastname), ' ', UPPER(customers.name), ' ', UPPER(customers.middlename))"),
					'customers.name',
					'customers.inn'
				];
				foreach($columnsForSearch as $col){
					$query = $query->orWhere($col, 'like', '%'.$s.'%');
				}
			});
		}

		$customers=$customers
		//->orderBy('customers.id','DESC')->get()->toArray();
		->get()->toArray();
		
		$data_head[] = array();
		$i = 1;
		if(!empty($customers)){
			foreach($customers as $customer){
				
				$data_head[] = array(
					'#' =>$i,
					'Mulk egasi' => $customer->lastname.' '.$customer->name.' '.$customer->middlename.($customer->type != 'physical')?"(".$customer->ownership_form.")":"",
					'Address' => $customer->state.', '.$customer->city,
					'Telefon raqami' => $customer->mobile?$customer->mobile:'Kiritilmagan'
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
            'Address', 
            'Telefon raqami'
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
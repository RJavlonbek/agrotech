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

class ExportExam implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    public function collection()
    {

    	$from=Input::get('from');
		$till=Input::get('till');
		$title="Haydovchi  imtihonlari";

		$driverExams=DB::table('driver_exams')->
		join('customers','customers.id','=','driver_exams.owner_id')->
		join('driver_exam_types','driver_exam_types.id','=','driver_exams.type')
		->select(
			'customers.*',
			'driver_exams.*',
			'driver_exam_types.name as exam_type'
		)->
		leftjoin('tbl_cities', 'tbl_cities.id', '=', 'customers.city_id')->
		leftjoin('tbl_states', 'tbl_states.id', '=', 'tbl_cities.state_id');
		$user=Auth::User();
		if($user->role != 'admin'){
			$position = DB::table('tbl_accessrights')->where('id', '=', intval($user->role))->get()->first();
			if(!empty($position)){
				if($position->position == 'district'){
					$i = 0;
					$driverExams = $driverExams->where(function($query) use($user){
						foreach (explode(',', $user->city_id) as $city) {
							$query->orWhere('tbl_cities.id', '=', $city);
						}
					});
				}elseif($position->position == 'country'){
					$i = 0;
					$driverExams = $driverExams->where(function($query) use($user){
						foreach(explode(',', $user->state_id) as $state){
							$query->orWhere('tbl_states.id','=',$state);
						}
					});
				}elseif($position->position == 'region'){
					$i = 0;
					$driverExams = $driverExams->where(function($query) use($user){
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
			$timeField='driver_exams.given_date';
			$driverExams=$driverExams->whereDate($timeField,'>=',$fromTime)
				->whereDate($timeField,'<=',$tillTime);
		}
		$driverExams = $driverExams->orderBy('driver_exams.given_date','DESC')->
		orderBy('driver_exams.created_at','DESC')->get()->toArray();
		$data_head[] = array();
		$i = 1;

		
		$datetime1 = new DateTime(date('d-m-Y'));


		if(!empty($driverExams)){
			foreach($driverExams as $exam){

				$datetime2 = new DateTime(date('d-m-Y', strtotime($exam->created_at)));
		 		$interval = $datetime1->diff($datetime2);
		 		$exam->day = $interval->format('%a');
			
				$data_head[] = array(
					'#' =>$i,
					'Imtihon turi' => $exam->exam_type,
					'Haydovchi' => $exam->lastname.' '.$exam->name.' '.$exam->middlename,
					'SHIR/STIR' => $exam->id_number?$exam->id_number:$exam->inn,
					'Sana' => date('d.m.Y',strtotime($exam->given_date)),
					'Natija' => $exam->result?$exam->result:'---',
					'To\'lov' => $exam->total_amount
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
            'Imtihon turi',  
            'Haydovchi', 
            'SHIR/STIR',
            'Sana',
            'Natija', 
            'To\'lov'
            
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
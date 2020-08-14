@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (CheckAccessUser('report_pay', $userid, 'read')=='yes')
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/table-export.min.css') }}" />
    	<div class="section" id="report-page">
	        <div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<form action="{{ url('/report/income/driver-exams') }}" method="get">
								<input type="hidden" name="form" value="{{$form}}">
								<div class="row">
									<div class="col-md-4">
										@if(!empty($states))
											<label class="form-label">Viloyat</label>
										@elseif(!empty($cities))
											<label class="form-label">Tuman / shahar</label>
										@endif
										<select class="form-control" id="search" name="{{$form}}" required>
											@if(!empty($states))
											<option value="">Viloyat tanlang</option>
												@foreach($states as $st)
													<option value="{{ $st->id }}"
														@if( (!empty($state) && $state->id==$st->id) || count($states)==1)
															selected="selected"
														@endif
													>
														{{ $st->name }}
													</option>
												@endforeach
											@elseif(!empty($cities))
												<option value="">Tuman / shahar tanlang</option>
												@foreach($cities as $ci)
													<option value="{{$ci->id}}"
														@if(!empty($city) && $city->id==$ci->id)
															selected="selected"
														@endif
													>
														{{$ci->name}}
													</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="col-3">
										<label class="form-label" style="visibility: hidden">asd</label>
										<input class="form-control fc-datepicker from" name="from" placeholder="dd-mm-yyyy" autocomplete="off" 
											@if(!empty($from))
												value="{{$from}}"
											@endif
										/> dan
									</div>
									<div class="col-3">
										<label class="form-label" style="visibility: hidden">asd</label>
										<input class="form-control fc-datepicker till" name="till" placeholder="dd-mm-yyyy" autocomplete="off" 
											@if(!empty($till))
												value="{{$till}}"
											@endif
										/> gacha
									</div>
									<div class="col-md-2">
										<label class="form-label" style="visibility: hidden;">Label</label>
										<button type="submit" class="btn btn-success">Qidirish</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="card">
						@if(!empty($state) || !empty($city))
							<div class="card-body">
								<div class="row mb-2">
									<div class="report-header fs-16 col-8">
										@if(!empty($state))
											<span>Inspeksiyaning <b>{{$state->name}}</b>da qishloq xo'jaligi, melioratsiya va yo'l qurilish texnikalari holatini nazorat qilish bo'yicha <b>{{date('d.m.Y',strtotime($from))}}</b> dan <b>{{date('d.m.Y',strtotime($till))}}</b> gacha bajarilgan ishlar hisoboti</span>
										@elseif(!empty($city))
											<span><b>{{$city->name}}</b>da <b>imtihonlardan</b> kelib tushgan tushumlar bo'yicha <b>{{date('d.m.Y')}}</b> holatiga ma'lumot</span>
										@else
											<span>Haydovchi imtihonlari tushum - hisobot</span>
										@endif
									</div>
									<div class="col-4 text-right">
										<div class="btn btn-primary print-table-button" table="report" ><i class='fa fa-print'></i> Chop etish</div>
										<div class="btn btn-primary" id="export-excel" filename="{{$state?$state->name:$city->name}}-imtihon tushumlar {{date('d.m.Y')}}"><i class="fa fa-file-excel-o"></i> Excel ga jo'natish</div>
									</div>
								</div>
								<div class="">
									<div class="sticky-table sticky-headers sticky-ltr-cells">
										<table class="table table-bordered" id="report">
											<thead>
												<tr class="sticky-header">
													<th rowspan="4">№</th>
													<th rowspan="4">
														<span class="">Tuman nomi</span>
													</th>
													<th colspan="4">
														<span class="font-weight-bold">Yo'l harakati qoidalari bo'yicha imtihon olganligi uchun</span>
													</th>
													<th colspan="4">
														<span class="font-weight-bold">Texnikani ekspluatatsiya qilish qoidalari bo'yicha imtihon olganligi uchun</span>
													</th>
													<th colspan="4">
														<span class="font-weight-bold">Haydash ko'nikmalari qoidalari bo'yicha imtihon olganligi uchun</span>
													</th>
													<th colspan="2" style="display: none">
														<span class="font-weight-bold">Boshqa tushumlar</span>
													</th>
													<th colspan="2" style="display: none">
														<span class="font-weight-bold">Jami xizmat tushumi</span>
													</th>
												</tr>
												<tr class="sticky-header sticky-height1">
													<th class="sticky-custom" colspan="2">
														Oyda
													</th>
													<th class="sticky-custom" colspan="2">
														Yil davomida
													</th>
													<th class="sticky-custom" colspan="2">
														Oyda
													</th>
													<th class="sticky-custom" colspan="2">
														Yil davomida
													</th>
														<th class="sticky-custom" colspan="2">
														Oyda
													</th>
													<th class="sticky-custom" colspan="2">
														Yil davomida
													</th>
													<th class="sticky-custom" style="display: none">
														Oyda
													</th>
													<th class="sticky-custom" style="display: none">
														Yil davomida
													</th>
													<th class="sticky-custom" style="display: none">
														Oyda
													</th>
													<th class="sticky-custom" style="display: none">
														Yil davomida
													</th>
												</tr>
												<tr class="sticky-header sticky-height2">
													<th class="sticky-custom2" rowspan="2">
														soni, dona
													</th>
													<th class="sticky-custom2" rowspan="2">
														Summasi, mln so'm
													</th>
													<th class="sticky-custom2" rowspan="2">
														soni, dona
													</th>
													<th class="sticky-custom2" rowspan="2">
														Summasi, mln so'm
													</th>
													<th class="sticky-custom2" rowspan="2">
														soni, dona
													</th>
													<th class="sticky-custom2" rowspan="2">
														summasi, mln so'm
													</th>
													<th class="sticky-custom2" rowspan="2">
														soni, dona
													</th>
													<th class="sticky-custom2" rowspan="2">
														Summasi, mln so'm
													</th>
													<th class="sticky-custom2" rowspan="2">
														soni, dona
													</th>
													<th class="sticky-custom2" rowspan="2">
														summasi, mln so'm
													</th>
													<th class="sticky-custom2" rowspan="2">
														soni, dona
													</th>
													<th class="sticky-custom2" rowspan="2">
														Summasi, mln so'm
													</th>
													<th class="sticky-custom2" rowspan="2" style="display: none">
														soni, dona
													</th>
													<th class="sticky-custom2" rowspan="2" style="display: none">
														summasi, mln so'm
													</th>
													<th class="sticky-custom2" rowspan="2" style="display: none">
														soni, dona
													</th>
													<th class="sticky-custom2" rowspan="2" style="display: none">
														Summasi, mln so'm
													</th>
												</tr>
											</thead>
											<tbody>
												@if(!empty($cities))
													<?php 
														$count=0; 
														$totalNumbers=[];	
													?>
													@foreach($cities as $oneCity)
														<?php $count++; ?>
														<tr>
															<td>{{$count}}</td>
															<td>{{$oneCity->name}}</td>
															@foreach($oneCity->numbers as $key=>$num)
																<?php if(isset($totalNumbers[$key])){
																	$totalNumbers[$key]+=$num;
																}else{
																	$totalNumbers[$key]=$num;
																} ?>
																<td class="text-right">{{$num}}</td>
															@endforeach
														</tr>
													@endforeach
													<tr class="font-weight-bold">
														<td></td>
														<td>Jami</td>
														@foreach($totalNumbers as $total)
															<td class="text-right">{{$total}}</td>
														@endforeach
													</tr>
												@endif
											</tbody>
										</table>
									</div>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
        </div>
@else
			<div class="right_col" role="main">
				<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
		              <div class="nav toggle" style="padding-bottom:16px;">
		               <span class="titleup">&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
		              </div>
		        </div>
			</div>
@endif   
			<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>
			<!-- language change in user selected -->	
<script>
	$(document).ready(function() {
		$('select[name="city"]').select2({
		placeholder:'Tuman / shahar tanlang',
		language:{
			inputTooShort:function(){
				return 'Tuman yoki shahar nomini kiritib izlang';
			},
			searching:function(){
				return 'Izlanmoqda...';
			},
			noResults:function(){
				return "Natija topilmadi"
			}
		}
	});
	$('select[name="state"]').select2({
		placeholder: 'Viloyat tanlang',
		language:{
			inputTooShort:function(){
				return 'Viloyat nomini kiritib izlang';
			},
			searching:function(){
				return 'Izlanmoqda...';
			},
			noResults:function(){
				return "Natija topilmadi"
			}
		},
		minimumResultsForSearch:Infinity
	});
	$('#export-excel').on('click',function(e){
		exportTableToExcel('report',$(this).attr('filename'));
	});
	function exportTableToExcel(tableID, filename = ''){
	    var downloadLink;
	    filename = filename?filename+'.xls':'report.xls';
	    var dataType = 'application/vnd.ms-excel';
	    var tableSelect = document.getElementById(tableID);
	    var tableHTML = "<table border='2px'><tr>";
        for(var j = 0 ; j < tableSelect.rows.length ; j++) 
        {     
        	if(tableSelect.rows[j]){
        		tableHTML=tableHTML+tableSelect.rows[j].innerHTML+"</tr>";
        	}
        }
        tableHTML=tableHTML+"</table>";
    	tableHTML=tableHTML.replace(/<span[^>]*>|<\/span>/g, "");
    	var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    	tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    	tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    	tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    	tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    	tableHTML=tab_text+tableHTML+'</body></html>';
    	var blob=new Blob([tableHTML],{ type: "application/vnd.ms-excel" });
    	saveAs(blob, filename);
	}
    $('#datatable').DataTable( {
		responsive: true,
		sorting: false,
        "language": {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); ?>.json"
        }
    });
    $("input.from").datetimepicker({
		format: "dd-mm-yyyy",
		autoclose: 1,
		minView: 2,
		startView:'decade',
		endDate: new Date(),
	});

    $("input.till").datetimepicker({
		format: "dd-mm-yyyy",
		autoclose: 1,
		minView: 2,
		startView:'decade',
		endDate: new Date(),
	});
});
</script>
@endsection
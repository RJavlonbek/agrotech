@extends('layouts.app')

@section('content')

<!-- page content -->

<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('report_new', $userid, 'read')=='yes')
    	<div class="section">
    		{{ $message }}
	        <div class="row">
				<div class="col-md-12">

					<div class="card">									

						<div class="card-body">

							<form action="{{ url('/report/new-vehicle') }}" method="get">
								<input type="hidden" name="form" value="{{$form}}">
								<div class="row">
									<div class="col-md-6">
										@if(!empty($states))
											<label class="form-label">Viloyat</label>
										@elseif(!empty($cities))
											<label class="form-label">Tuman / shahar</label>
										@endif
										<select class="form-control" id="search" name="{{$form}}">
											@if(!empty($states))
												<option value="">Viloyat tanlang</option>
												@foreach($states as $st)
													<option value="{{ $st->id }}"
														@if(!empty($state) && $state->id==$st->id)
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

									<div class="col-md-6">

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
											<span><b>{{$state->name}}</b>da <b>{{date('Y')}}</b> yilda xarid qilingan qishloq xo'jaligi, meliorativ va yo'l qurilish texnikalarining rusumlari to'g'risida <b>{{date('d.m.Y')}}</b> holatiga ma'lumot</span>
										@elseif(!empty($city))
											<span><b>{{$city->name}}</b>da <b>{{date('Y')}}</b> yilda xarid qilingan qishloq xo'jaligi, meliorativ va yo'l qurilish texnikalarining rusumlari to'g'risida <b>{{date('d.m.Y')}}</b> holatiga ma'lumot</span>
										@else
											<span>Yangi texnika - hisobot</span>
										@endif
									</div>
									<div class="col-4 text-right">
										<div class="btn btn-primary" id="export-excel" filename="{{$state?$state->name:$city->name}}-yangi texnika {{date('d.m.Y')}}">Excel ga jo'natish</div>
										<div class="btn btn-primary print-table-button" table="report" >Chop etish</div>
									</div>
								</div>
								<div class="" style="overflow-x: scroll;">
									<table class="table table-bordered" id="report">
										<thead>
											<tr>

												<th rowspan="2">№</th>

												<th colspan="2">Texnika</th>

												@foreach($categories as $cat)
													<th rowspan="2"><span class="vert-header">{{$cat->name}}</span></th>
												@endforeach
												<th rowspan="2"><span class="vert-header">Jami</span></th>
											</tr>
											<tr>

												<td>Nomi</td>

												<td>Modeli</td>

											</tr>
										</thead>
										<tbody>
											<tr>

												<td></td>

												<td colspan="2">Jami</td>
												<?php $allVehicle=0; ?>
												@foreach($totalVehicleCount as $c)
													<?php $allVehicle+=$c; ?>
													<td class="text-right">{{$c}}</td>
												@endforeach
												<td class="text-right">{{$allVehicle}}</td>
											</tr>
											<?php $count=0; ?>
											@foreach($vehicleTypes as $type)

												@foreach($type->working_types as $working_type)
													<?php $count++; ?>
													<?php $brandsCount=count($working_type->vehicle_brands); ?>
													<tr>
														<td rowspan="{{$brandsCount+1}}">{{$count}}</td>
														<td rowspan="{{$brandsCount+1}}">{{$working_type->name}}</td>
														<td class="font-weight-bold">Jami</td>
														<?php $stateVehicleTypeCount=0; // count of vehicles by one working type through state ?>
														@if(!empty($working_type->vehicle_count))
															@foreach($working_type->vehicle_count as $c)
																<?php $stateVehicleTypeCount+=$c;?>
																<td class="font-weight-bold text-right">{{$c}}</td>
															@endforeach
														@else
															@foreach($totalVehicleCount as $i)
																<td class="text-right">-</td>
															@endforeach
														@endif
														<td class="font-weight-bold text-right">{{$stateVehicleTypeCount}}</td>
													</tr>
													@foreach($working_type->vehicle_brands as $model)
														<tr>
															<td style="white-space: nowrap;">{{$model->vehicle_brand}}</td>
															<?php $stateVehicleBrandCount=0; // count of vehicles by one model through state ?>
															@foreach($model->vehicle_count as $c)
																<?php $stateVehicleBrandCount+=$c; ?>
																<td class="text-right">{{$c}}</td>
															@endforeach
															<td class="text-right">{{$stateVehicleBrandCount}}</td>
														</tr>
													@endforeach
												@endforeach
											@endforeach
										</tbody>
									</table>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>

    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

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
		minimumResultsForSearch:Infinity,
		placeholder:'Viloyatni tanlang',
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

		}
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

			

				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 

			?>.json"

        }

    } );

} );

</script>

<!--- delete vehicaltypes -->

<script>

$('body').on('click', '.sa-warning', function() {

  

    var url =$(this).attr('url');

        swal({   

            title: "Are You Sure?",

      text: "You will not be able to recover this data afterwards!",   

            type: "warning",   

            showCancelButton: true,   

            confirmButtonColor: "#297FCA",   

            confirmButtonText: "Yes, delete!",   

            closeOnConfirm: false 

        }, function(){

      window.location.href = url;

             

        });

    }); 

 

</script>



@endsection
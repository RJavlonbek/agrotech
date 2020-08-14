@extends('layouts.app')

@section('content')
<style type="text/css">

</style>

<!-- page content -->

<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('report_exist', $userid, 'read')=='yes')
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/table-export.min.css') }}" />
	<div class="section">
        <div class="row">
			<div class="col-md-12">
				<div class="card">									
					<div class="card-body">
						<form action="{{ url('/report/exist') }}" method="get">

							<div class="row">


								<div class="col-md-6">

									<label class="form-label">Viloyat</label>

									<select class="form-control" id="search" name="state">
										<option value>viloyat</option>
										@if(!empty($states))
											@foreach($states as $st)
												<option value="{{ $st->id }}"
													@if(!empty($state) && $state->id==$st->id)
														selected="selected"
													@endif
												>
													{{ $st->name }}
												</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="col-md-6">

									<label class="form-label" style="visibility: hidden;">label</label>

									<button type="submit" class="btn btn-success">Qidirish</button>

								</div>

							</div>

						</form>

					</div>

				</div>
				@if(!empty($state))
					<div class="card">
						<div class="card-body">
							<div class="">
								<div class="row mb-2">
									<div class="report-header fs-16 col-8">
										@if(!empty($state))
											<span><b>{{$state->name}}</b> tumanlar va shahardagi mavjud qishloq xo'jaligi, meliorativ va yo'l qurilish texnikalarining rusumlari to'g'risida <b>{{date('d.m.Y')}}</b> holatiga ma'lumot</span>
										@else
											<span><i class="fe fe-life-buoy mr-1"></i>Mavjud texnika - hisobot</span>
										@endif
									</div>
									<div class="col-4 no-print text-right">
										<div class="btn btn-primary" id="export-excel" filename="{{$state->name}}-Mavjud texnika {{date('d.m.Y')}}">Excel ga jo'natish</div>
										<div class="btn btn-primary print-table-button" table="report" >Chop etish</div>
									</div>
								</div>
								<div class="sticky-table sticky-headers sticky-ltr-cells">
									<table class="table table-bordered" id="report">

										<thead>

											<tr class="sticky-header sticky-height">
												<th rowspan="2">№</th>
												<th class="" colspan="2">Texnika </th>
												@foreach($cities as $city)
													<th rowspan="2"><span class="vert-header">{{$city->name}}</span></th>
												@endforeach
												<th rowspan="2"><span class="vert-header font-weight-bold">Viloyat jami</span></th>
											</tr>
											<tr class="sticky-header">

												<td class="sticky-custom">nomi</td>

												<td class="sticky-custom">modeli</td>

											</tr>
										</thead>

										<tbody>
											

											<tr>

												<td></td>

												<td colspan="2" class="font-weight-bold">Jami</td>
												<?php $allVehicle=0; ?>
												@foreach($stateVehicleCount as $c)
													<?php $allVehicle+=$c; ?>
													<td class="font-weight-bold">{{$c}}</td>
												@endforeach
												<td class="font-weight-bold">{{$allVehicle}}</td>
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
														@foreach($working_type->vehicle_count as $c)
															<?php $stateVehicleTypeCount+=$c;?>
															<td class="font-weight-bold">{{$c}}</td>
														@endforeach
														<td class="font-weight-bold">{{$stateVehicleTypeCount}}</td>
													</tr>
													@foreach($working_type->vehicle_brands as $model)
														<tr>
															<td>{{$model->vehicle_brand}}</td>
															<?php $stateVehicleBrandCount=0; // count of vehicles by one model through state ?>
															@foreach($model->vehicle_count as $c)
																<?php $stateVehicleBrandCount+=$c; ?>
																<td>{{$c}}</td>
															@endforeach
															<td>{{$stateVehicleBrandCount}}</td>
														</tr>
													@endforeach
												@endforeach
											@endforeach

										</tbody>

									</table>
								</div>
							</div>

						</div>

					</div>
				@endif
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

	var height = parseFloat($('.sticky-height').height()) - 1;
	$('.sticky-custom').css('top', height + 'px');
	$(".sticky-height th").css('top', '-1px');

	$('select#search').select2({
		placeholder: 'Viloyat tanlang',

		minimumResultsForSearch: Infinity

	});

	//TableExport.prototype.charset = "charset=utf-8";

	$('#export-excel').on('click',function(e){
		exportTableToExcel('report',$(this).attr('filename'));
	});

	function exportTableToExcel(tableID, filename = ''){
	    var downloadLink;
	    var dataType = 'application/vnd.ms-excel';
	    var tableSelect = document.getElementById(tableID);

	    var tableHTML = "<table border='2px'><tr>";
        for(var j = 0 ; j < tableSelect.rows.length ; j++) 
        {     
            tableHTML=tableHTML+tableSelect.rows[j].innerHTML+"</tr>";
        }
        tableHTML=tableHTML+"</table>";
    	tableHTML=tableHTML.replace(/<span[^>]*>|<\/span>/g, "");
    	tableHTML=tableHTML.replace(/ /g, '%20');

    	tableHTML='<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body>'+tableHTML+'</body></html>';
	    
	    // Specify file name
	    filename = filename?filename+'.xls':'report.xls';
	    
	    // Create download link element
	    downloadLink = document.createElement("a");
	    
	    document.body.appendChild(downloadLink);
	    
	    if(navigator.msSaveOrOpenBlob){
	    	console.log('if');
	        var blob = new Blob(['\ufeff', tableHTML], {
	            type: dataType
	        });
	        navigator.msSaveOrOpenBlob( blob, filename);
	    }else{
	    	console.log('else');
	        // Create a link to the file
	        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
	    
	        // Setting the file name
	        downloadLink.download = filename;
	        
	        //triggering the function
	        downloadLink.click();
	    }
	}

	// function exportTableToExcel(tableID, filename = ''){
	//     var downloadLink;
	//     var dataType = 'application/vnd.ms-excel';
	//     var tableSelect = document.getElementById(tableID);
	//     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
	    
	//     // Specify file name
	//     filename = filename?filename+'.xls':'excel_data.xls';
	    
	//     // Create download link element
	//     downloadLink = document.createElement("a");
	    
	//     document.body.appendChild(downloadLink);
	    
	//     if(navigator.msSaveOrOpenBlob){
	//         var blob = new Blob(['\ufeff', tableHTML], {
	//             type: dataType
	//         });
	//         navigator.msSaveOrOpenBlob( blob, filename);
	//     }else{
	//         // Create a link to the file
	//         downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
	    
	//         // Setting the file name
	//         downloadLink.download = filename;
	        
	//         //triggering the function
	//         downloadLink.click();
	//     }
	// }



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
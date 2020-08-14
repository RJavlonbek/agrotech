<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="{{ URL::asset('resources/views/layouts/assets/css/tasks-style.css') }}" rel="stylesheet" />
	<style type="text/css">
		th{
			border: 1px black solid;
		}

		#full-report-table{
			visibility: hidden;
		}
	</style>
</head>
<body>
	<div class="container my-4">
		<div class="row">
			<div class="col-12 col-md-6 bg-white m-auto border rounded">
				<form class="d-flex">
					@if(isset($states))
						<select name="state" class="form-control select-state">
							<option value="" disabled="disabled" selected>Viloyat tanlang</option>
							@foreach($states as $state)
								<option 
									value="{{ $state->id }}"
									@if(isset($stateId) && $stateId==$state->id)
										selected="selected"
									@endif 
								>
									{{ $state->name }}
								</option>
							@endforeach
						</select>
					@endif
					<button type="submit" class="btn btn-primary ml-2">Hisobot</button>
				</form>
				@if($count)
					<div class="text-center my-3">
						<h4>{{$count}} ta texnika topildi...</h4>
						<p>Kutib turing...</p>
					</div>
				@endif
			</div>
		</div>
	</div>
	@if(isset($vehicles))
		<table id="full-report-table" filename="{{ date('d.m.Y') }}">
			<thead>
				<tr>
					<th>
					</th>
					<th>
					</th>
					<th>
					</th>
					<th>
					</th>
					<th>
					</th>
					<th colspan="2">
						Joylashgan
					</th>
					<th>
					</th>
					<th colspan="2">
						Qishloq xo'jaligi va meliorativ texnika				
					</th>
					<th>				
					</th>
					<th>				
					</th>
					<th colspan="5">
						Zavoddan berilgan
					</th>
					<th colspan="5">
						Davlat raqami
					</th>
					<th colspan="3">
						Texnik pasport
					</th>
					<th colspan="3">
						Qishloq xo'jaligi mashinasi guvohnomasi
					</th>
					<th colspan="2">
					</th>
					<th colspan="4">
						Qayta tiklash
					</th>
					<th colspan="3">
						Taqiqqa olindi	
					</th>
					<th colspan="3">
						Taqiqdan yechildi	
					</th>
					<th colspan="4">
						Sud ijrochilari yomonidan taqiqqa olish so'ralgan
					</th>
					<th colspan="4">
						Sud ijrochilari tomonidan taqiqdan yechilgan
					</th>
				</tr>
				<tr>
					<th>
					T.r				
					</th>
					<th>	
						Texnika egasining murojaat sanasi			
					</th>		
					<th>
						Texnika egasining nomi				
					</th>
					<th>
						Mulkchilik shakli				
					</th>
					<th>
						INN belgisi(STIR)				
					</th>
					<th>
						Tumani				
					</th>
					<th>
						Manzili				
					</th>
					<th>
						Hisobga olish holati				
					</th>
					<th>
						Nomi 				
					</th>
					<th>
						Modeli				
					</th>
					<th>
						Ishlab chiqarilgan zavod nomi				
					</th>
					<th>
						Ishlab chiqarilgan ili				
					</th>
					<th>
						Dvigatel raqami				
					</th>
					<th>
						Shassi raqami				
					</th>
					<th>
						Rangi				
					</th>
					<th>
						Boshqa belgilari				
					</th>
					<th>
						Qo'shimcha ma'lumolar				
					</th>
					<th>
						Berish sanasi				
					</th>
					<th>
						Tipi 				
					</th>
					<th>
						Hudud kodi				
					</th>
					<th>
						Seriyasi				
					</th>
					<th>
						Ro'yxatga olish soni				
					</th>
					<th>
						Berish sansai
					</th>
					<th>
						Seriyasi				
					</th>
					<th>
						Raqami				
					</th>
					<th>
						Berish sanasi				
					</th>
					<th>
						Seriyasi				
					</th>
					<th>
						Raqami				
					</th>
					<th>
						Qo'shimcha ma'lumot				
					</th>
					<th>				
					</th>
					<th>
						Davlat raqami				
					</th>
					<th>
						Davlat raqami berilgan sana				
					</th>
					<th>
						Texik pasport				
					</th>
					<th>
						Texnik pasport berilgan sana				
					</th>
					<th>
					</th>
					<th>
						Notarius tartib raqami				
					</th>
					<th>
						Sanasi				
					</th>
					<th>
					</th>
					<th>
						Notarius tartib raqami				
					</th>
					<th>
						Sanasi				
					</th>
					<th>
						Xat raqami				
					</th>
					<th>
						Xat sanasi				
					</th>
					<th>
						Kirim qilingan tartib raqami				
					</th>
					<th>
						Kirim qilingan sana				
					</th>
					<th>
						Xat raqami				
					</th>
					<th>
						Xat sanasi				
					</th>
					<th>
						Kirim qilingan tartib raqami				
					</th>
					<th>
						Kirim qilingan sana				
					</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; ?>
				@foreach($vehicles as $vehicle)
					<?php $i++; ?>
					<tr>
						<td>{{ $i }}</td>
						<td>{{ date('d.m.Y',strtotime($vehicle->reg_date)) }}</td>
						<td>{{ $vehicle->owner_name.' '.$vehicle->owner_lastname.' '.$vehicle->owner_middlename }}</td>
						<td>{{ $vehicle->ownership_form }}</td>
						<td>{{ $vehicle->inn }}</td>
						<td>{{ $vehicle->city }}</td>
						<td>{{ $vehicle->address }}</td>
						<td>Ro'yxatga olingan</td>
						<td>{{ $vehicle->name }}</td>
						<td>{{ $vehicle->brand }}</td>
						<td>{{ $vehicle->factory }}</td>
						<td>{{ $vehicle->modelyear }}</td>
						<td>{{ $vehicle->engineno ? $vehicle->engineno : 'Raqamsiz' }}</td>
						<td>{{ $vehicle->chassisno ? $vehicle->chassisno : 'Raqamsiz' }}</td>
						<td>{{ $vehicle->color }}</td>
						<td></td>
						<td></td>

						@if(isset($vehicle->n_date))
							<td>{{ date('d.m.Y',strtotime($vehicle->n_date)) }}</td>
							<td>{{ $vehicle->n_type }}</td>
							<td>{{ $vehicle->n_code }}</td>
							<td>{{ $vehicle->n_series }}</td>
							<td>{{ $vehicle->n_number }}</td>
						@else
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						@endif

						@if(isset($vehicle->passport_date))
							<td>{{ date('d.m.Y',strtotime($vehicle->passport_date)) }}</td>
							<td>{{ $vehicle->passport_series }}</td>
							<td>{{ $vehicle->passport_number }}</td>
						@else
							<td></td>
							<td></td>
							<td></td>
						@endif
						
						@if(isset($vehicle->cert_date))
							<td>{{ date('d.m.Y',strtotime($vehicle->cert_date)) }}</td>
							<td>{{ $vehicle->cert_series }}</td>
							<td>{{ $vehicle->cert_number }}</td>
						@else
							<td></td>
							<td></td>
							<td></td>
						@endif

						{{-- Qo'shimcha ma'lumot --}}
						<td></td>
						<td></td>

						{{-- Qayta tiklash --}}
						<td></td>
						<td></td>
						<td></td>
						<td></td>

						{{-- Taqiqqa olingan --}}
						<td>{{ $vehicle->lock_status }}</td>
						<td>{{ $vehicle->lock_number }}</td>
						<td>{{ $vehicle->lock_date ? date('d.m.Y', strtotime($vehicle->lock_date)) : '' }}</td>

						{{-- Taqiqdan yechilgan --}}
						<td>{{ $vehicle->unlock_status }}</td>
						<td>{{ $vehicle->unlock_number }}</td>
						<td>{{ $vehicle->unlock_date ? date('d.m.Y', strtotime($vehicle->unlock_date)) : '' }}</td>

						{{-- Sud ijrochilari tomonidan taqiqqa olish so'ralgan --}}
						<td>{{ $vehicle->court_lock_letter_no }}</td>
						<td>{{ $vehicle->court_lock_letter_date ? date('d.m.Y', strtotime($vehicle->court_lock_letter_date)) : '' }}</td>
						<td>{{ $vehicle->court_lock_order_no }}</td>
						<td>{{ $vehicle->court_lock_order_date ? date('d.m.Y', strtotime($vehicle->court_lock_order_date)) : '' }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
</body>

<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>
<script sync type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/file-saver.min.js') }}"></script>
<script sync type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/blob.min.js') }}"></script>

<script type="text/javascript">
	$(function(){
		console.log('loaded');
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
	    	tableHTML=tableHTML.replace(/<a[^>]*>|<\/a>/g, "");

	    	var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
	    	tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
	    	tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
	    	tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
	    	tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

	    	tableHTML=tab_text+tableHTML+'</body></html>';

	    	var blob=new Blob(["\ufeff", tableHTML], { type: "application/vnd.ms-excel" });
	    	saveAs(blob, filename);
		}

		if($('#full-report-table').length){
			setTimeout(()=>{
				let filename = $('select.select-state option:selected').text().trim() + '_' + $('#full-report-table').attr('filename');
				exportTableToExcel('full-report-table', filename);
				setTimeout(()=>{
					window.close();
				},1000);
			},1000);
		}
	});
</script>

</html>



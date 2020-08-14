@extends('layouts.app')

@section('content')

<!-- page content -->

	<?php $userid = Auth::user()->id; ?>

<style>

	

</style>

	@if (CheckAccessUser('vehicle_pass', $userid, 'read')=='yes')

	    <div class="section">

			<!-- PAGE-HEADER -->

			<div class="page-header">

				<ol class="breadcrumb">

					<li class="breadcrumb-item">

						<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Haydovchilik imtihonlari')}}

					</li>

				</ol>

			</div>

			@if(session('message'))

			<div class="row massage">

				<div class="col-md-12 col-sm-12">

					<div class="alert alert-success text-center">

	                 @if(session('message') == 'Successfully Submitted')

						<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>

					   @elseif(session('message')=='Successfully Updated')

					   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>

					   @elseif(session('message')=='Successfully Deleted')

					   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>

				    @endif

	                </div>

				</div>

			</div>

			@endif

			<!-- PAGE-HEADER END -->

			<div class="row">

				<div class="col-md-12">

					<div class="card">									

						<div class="card-body">

							<div class="panel panel-primary">

								<div class="tab_wrapper page-tab">

									<ul class="tab_list">

										<li class="active">

											<a href="{!! url('/driver-exam/list')!!}">

												<span class="visible-xs"></span>

												<i class="fa fa-list fa-lg">&nbsp;</i> 

												Imtihonlar ro'yxati

											</a>

										</li>

										<li>

											<a href="{!! url('/driver-exam')!!}">

												<span class="visible-xs"></span>

												<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

												Imtihon topshirish</b>

											</a>

										</li>

									</ul>

								</div>

							</div>

							<div id="list-date-filter">
								<div class="show-date btn btn-default filter-button">Vaqt bo'yicha filtrlash <i class="fa {{ ($from && $till) ? 'fa-angle-left':'fa-angle-right' }}"></i></div>
								<div class="date {{($from && $till) ? 'open':''}}">
									<form class="input-filter">
										<input class="form-control fc-datepicker from input-filter" name="from" placeholder="dd-mm-yyyy" autocomplete="off" required="required" 
											@if(!empty($from))
												value="{{$from}}"
											@endif
										/> dan
										<input class="form-control fc-datepicker till input-filter" name="till" placeholder="dd-mm-yyyy" autocomplete="off" required="required" 
											@if(!empty($till))
												value="{{$till}}"
											@endif
										/> gacha
										@if($from && $till)
											<button type="button" class="btn btn-primary filter-button" id="cancel-date-filter">Filtrni bekor qilish</button>
										@else
											<button type='submit' class="btn btn-primary  filter-button">Filtrlash</button>
										@endif
									</form>
								</div>
								<div class="float-right-buttons">
									<div class="print-table-button btn btn-primary float-right-button" table='example-1'><i class='fa fa-print'></i> Chop etish</div>
									<div class="export-exam-button btn btn-primary  mr-2 float-right-button" table='example-1' filename='Texnik pasportlar'><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>
								</div>
							</div>

							<div class="table-responsive">

								<table id="example-1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

									<thead>

										<tr>

											<th class="border-bottom-0 border-top-0">#</th>
											<th class="border-bottom-0 border-top-0">{{ trans('app.Imtihon turi') }}</th>
											<th class="border-bottom-0 border-top-0">{{ trans('app.Haydovchi') }}</th>
											<th class="border-bottom-0 border-top-0">{{ trans('app.SHIR/STIR') }}</th>

											<th class="border-bottom-0 border-top-0">Sana</th>

											<th class="border-bottom-0 border-top-0">Natija</th>
											<th class="border-bottom-0 border-top-0">To'lov</th>
											@if (CheckAdmin($userid)=='yes')
												<th class="border-bottom-0 border-top-0">{{ trans('app.Action')}}</th>
											@endif
										</tr>

									</thead>

									<tbody>

									<?php $i=1;?>

										@if(!empty($driverExams))

											@foreach($driverExams as $exam)

												<tr>

													<td>{{ $i }}</td>
													<td>
														@if (CheckAccessUser('driver_exam', $userid, 'read')=='yes')
															<a href="/driver-exam/list/preview?id={{$exam->id}}" class="text-capitalize">{{ $exam->exam_type}}</a>
														@else
															<a href="javascript:void(0)" class="text-capitalize">{{ $exam->exam_type}}</a>
														@endif
													</td>
													<td>
														@if (CheckAccessUser('customer_add', $userid, 'read')=='yes')
															<a href="/customer/list/{{$exam->owner_id}}" class="text-capitalize">{{ $exam->lastname.' '.$exam->name.' '.$exam->middlename }}</a>
														@else
															<a href="javascript:void(0)" class="text-capitalize">{{ $exam->lastname.' '.$exam->name.' '.$exam->middlename }}</a>
														@endif
													</td>
													<td>{{ $exam->id_number?$exam->id_number:$exam->inn }}</td>

													<td>{{date('d.m.Y',strtotime($exam->given_date))}} </td>

													<td>{{$exam->result?$exam->result:'---'}}</td>
													<td class="amount text-right">{{$exam->total_amount}}</td>
													@if (CheckAdmin($userid)=='yes')
														<td class="no-print"> 
															<a day="{{$exam->day}}" class="btn btn-round btn-success cancel" url="{!! url ('/driver-exam/cancel/'.$exam->id) !!}" href="">{{ trans('app.Cancel')}}</a>
												    	</td>
													@endif
												</tr>

												<?php $i++; ?>

											@endforeach

										@endif

									</tbody>

								</table>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	@else

	<div class="section" role="main">
		<div class="card">
			<div class="card-body text-center">
				<span class="titleup text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
			</div>
		</div>
	</div>

	@endif    

        <!-- /page content -->

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

<script>

$(document).ready(function() {

	$(".export-exam-button").on('click', function(){
		window.location.href = '{{URL::to('/export/driver-exam')}}';
	});

    $('#datatable').DataTable( {

		responsive: true,

        "language": {

			 "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 

			?>.json"

        }

    } );

} );

</script>

<script>



$(document).ready(function(){

	$('a.cancel').on('click', function(e) {
		e.preventDefault();
		var day = parseInt($(this).attr('day'));
	  	var url =$(this).attr('url');
	  	if(day>180){
	  		swal({   
	            title: "Ruxsat Yo'q!",
				text: "3 kundan oshgan xarakatlarni bekor qlib bo'lmaydi!",   
	            type: "warning",   
	            showCancelButton: true,   
	            confirmButtonColor: "#297FCA",   
	            confirmButtonText: "Bekor qlish imkoni yo'q!",  
	            cancelButtonText: "Orqaga qaytish", 
	        }).then((isConfirm) => {				
			}).catch((err) => {

			});
	  	}else{
	  		swal({   
	            title: "Bekor qilmoqchimisiz?",
				text: "Bu xarakatdan so'ng ma'lumotni qayta tiklash imkoni yo'q!",   
	            type: "warning",   
	            showCancelButton: true,   
	            confirmButtonColor: "#297FCA",   
	            confirmButtonText: "Xa, bekor qiling!",  
	            cancelButtonText: "Orqaga qaytish", 
	        }).then((isConfirm) => {
				window.location.href = url;					
			}).catch((err) => {

			});
	  	}
    }); 

  }); 

 

</script>



@endsection
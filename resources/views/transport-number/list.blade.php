@extends('layouts.app')

@section('content')

<!-- page content -->

<?php $userid = Auth::user()->id; ?>
<style>
</style>
		@if (CheckAccessUser('vehicle_num', $userid, 'read')=='yes')

		    <div class="section">

				@if(session('message'))

				<div class="row massage">

					<div class="col-md-12 col-sm-12 col-xs-12">

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

													<a>

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														Davlat raqamlari ro'yxati

													</a>

												</li>

												<li>

													<a href="{!! url('/vehicle/transport-number')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

														Davlat raqami berish</b>

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
										<div class="print-table-button btn btn-primary float-right-button" table='examples1'><i class='fa fa-print'></i> Chop etish</div>
										<div class="export-transport-number-button btn btn-primary  mr-2 float-right-button" table='examples1' filename='Davlat raqami belgilari'>
											<i class="fa fa-file-excel-o"></i> Excelga jo'natish
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-8"></div>
									<div class="col-4">
										<form class="d-flex">
											<input type="text" name="s" class="search-input form-control" placeholder="Qidirish" required="required" value="{{ isset($_GET['s']) ? $_GET['s'] : '' }}">
											<button type='submit' class="btn btn-primary"><i class="fa fa-search"></i></button>
										</form>
									</div>
								</div>
								<div class="table-responsive">

									<table id="examples1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

										<thead>

											<tr>
												<th class="border-bottom-0 border-top-0">#</th>
												<th class="border-bottom-0 border-top-0">Davlat raqami</th>
												<th class="border-bottom-0 border-top-0">Tip</th>
												<th class="border-bottom-0 border-top-0">Egasi</th>
												<th class="border-bottom-0 border-top-0">Texnika</th>
												<th class="border-bottom-0 border-top-0">Berilgan hudud</th>
												<th class="border-bottom-0 border-top-0">{{ trans('app.Given Date')}}</th>
												<th class="border-bottom-0 border-top-0">Holati</th>
												<th class="border-bottom-0 border-top-0">{{ trans('app.To\'lov')}}</th>
												@if (CheckAdmin($userid)=='yes')
													<th class="border-bottom-0 border-top-0">{{ trans('app.Action')}}</th>
												@endif
											</tr>
										</thead>
										<tbody>

										<?php $i=1;?>

											@if(!empty($numbers))

												@foreach($numbers as $number)

													<tr>

														<td>{{ $i }}</td>
														<td>
															@if (CheckAccessUser('vehicle_num', $userid, 'read')=='yes')
																<a href="/vehicle/transport-number/preview?id={{$number->id}}&details=true">{{ $number->code.' '.$number->series.' '.$number->number }}</a>
															@else
																<a href="javascript:void(0)">{{ $number->code.' '.$number->number.$number->series }}</a>
															@endif
														</td>
														<td>{{ $number->type }}</td>
														<td>
															@if (CheckAccessUser('customer_add', $userid, 'read')=='yes')
																<a href="/customer/list/{{$number->owner_id}}" class="text-capitalize">{{ $number->owner_lastname.' '.$number->owner_name.' '.$number->owner_middlename }}</a>
															@else
																<a href="javascript:void(0)" class="text-capitalize">{{ $number->owner_lastname.' '.$number->owner_name.' '.$number->owner_middlename }}</a>
															@endif
														</td>
														<td>
															@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')
																<a href="/vehicle/list/view/{{$number->vehicle_id}}/{{$number->city_id}}">{{$number->vehicle_type.' '.$number->vehicle_brand}}</a>
															@else
																<a href="javascript:void(0)">{{$number->vehicle_type.' '.$number->vehicle_brand}}</a>
															@endif
														</td>
														<td>{{$number->state}}</td>
														<td>{{ date('d.m.Y',strtotime($number->given_date)) }} </td>
														<td>
															@if($number->status=='active')
																<span class="text-success">Faol</span>
															@else
																<span class="text-danger">Faolmas</span>
															@endif
														</td>
														<td class="amount text-right">{{$number->total_amount}}</td>
															<?php $userid=Auth::User()->id; ?>

														@if (CheckAdmin($userid)=='yes')
															<td class="no-print"> 
																<a day="{{$number->day}}" url="{!! url ('/vehicle/transport-number/cancel/'.$number->id) !!}" class="btn btn-round btn-success cancel" href="">{{ trans('app.Cancel')}}</a>
													    	</td>
														@endif
													</tr>
													<?php $i++; ?>
												@endforeach
											@endif
										</tbody>
									</table>
									{{ $numbers->links() }}
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



$(document).ready(function(){
	$(".export-transport-number-button").on('click', function(){
		window.location.href = '{{URL::to('/export/transport-number')}}';
	});


	$('a.cancel').on('click', function(e) {
		e.preventDefault();
		var day = parseInt($(this).attr('day'));
	  	var url =$(this).attr('url');
	  	if(day>10 && false){
	  		swal({   
	            title: "Ruxsat Yo'q!",
				text: "10 kundan oshgan xarakatlarni bekor qlib bo'lmaydi!",   
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
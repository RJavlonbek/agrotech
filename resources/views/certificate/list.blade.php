@extends('layouts.app')

@section('content')

<!-- page content -->

	<?php $userid = Auth::user()->id; ?>
<style>
</style>
		@if (CheckAccessUser('vehicle_pass', $userid, 'read')=='yes')
		    <div class="section">
				@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
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

							<div class="card-body p-6">

								<div class="panel panel-primary">

									<div class="tab_wrapper page-tab">

										<ul class="tab_list">
											<li class="active">
												<a>
													<span class="visible-xs"></span>

													<i class="fa fa-list fa-lg">&nbsp;</i> 

													Texnik guvohnomalar ro'yxati

												</a>

											</li>

											<li>

												<a href="{!! url('/certificate/add')!!}">

													<span class="visible-xs"></span>

													<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

													Texnik guvohnoma berish</b>

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
										<div class="export-certificate-button btn btn-primary  mr-2 float-right-button" table='examples1' filename='Texnik guvohnomalar'><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>
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
												<th class="border-bottom-0 border-top-0">Hujjat</th>
												<th class="border-bottom-0 border-top-0">Egasi</th>
												<th class="border-bottom-0 border-top-0">Texnika</th>
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

											@if(!empty($certificates))

												@foreach($certificates as $passport)

													<tr>

														<td>{{ $i }}</td>
														<td>
															@if (CheckAccessUser('vehicle_pass', $userid, 'read')=='yes')
																<a href="/certificate/preview?id={{$passport->id}}&details=true">{{ $passport->series.$passport->number }}</a>
															@else
																<a href="javascript:void(0)">{{ $passport->series.$passport->number }}</a>
															@endif
														</td>
														<td>
															@if (CheckAccessUser('customer_add', $userid, 'read')=='yes')
																<a href="/customer/list/{{$passport->owner_id}}" class="text-capitalize">{{ $passport->owner_lastname.' '.$passport->owner_name.' '.$passport->owner_middlename }}</a>
															@else
																<a href="javascript:void(0)" class="text-capitalize">{{ $passport->owner_lastname.' '.$passport->owner_name.' '.$passport->owner_middlename }}</a>
															@endif
														</td>
														<td>
															@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')
																<a href="/vehicle/list/view/{{$passport->vehicle_id}}/{{$passport->city_id}}">{{$passport->vehicle_type.' '.$passport->vehicle_brand}}</a>
															@else
															<a href="javascript:void(0)">{{$passport->vehicle_type.' '.$passport->vehicle_brand}}</a>
															@endif
														</td>
														<td>{{ date('d.m.Y',strtotime($passport->given_date)) }} </td>
														<td>
															@if($passport->status=='active')
																<span class="text-success">Faol</span>
															@else
																<span class="text-danger">Faolmas</span>
															@endif
														</td>
														<td class="amount text-right">{{$passport->total_amount}}</td>
														@if (CheckAdmin($userid)=='yes')
															<td class="no-print"> 
																<a day="{{$passport->day}}" class="btn btn-round btn-success cancel" url="{!! url ('/certificate/cancel/'.$passport->id) !!}" href=""> {{ trans('app.Cancel')}}</a>
													    	</td>
														@endif
													</tr>
													<?php $i++; ?>
												@endforeach
											@endif
										</tbody>
									</table>
									{{ $certificates->links() }}
								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		@else

			<div class="right_col" role="main">

				<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">

		            <div class="nav toggle" style="padding-bottom:16px;">

		               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.') }}</span>

		            </div>

		        </div>

			</div>

		@endif    

        <!-- /page content -->

<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>
<script>



$(document).ready(function(){
	$(".export-certificate-button").on('click', function(){
		window.location.href = '{{URL::to('/export/certificate')}}';
	});

	$('a.cancel').on('click', function(e) {
		e.preventDefault();
		var day = parseInt($(this).attr('day'));
	  	var url =$(this).attr('url');
	  	if(day>3 && false){
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
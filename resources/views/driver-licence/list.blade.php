@extends('layouts.app')

@section('content')

<!-- page content -->

	<?php $userid = Auth::user()->id; ?>
<style>
</style>
	@if (CheckAccessUser('driver_lic', $userid, 'read')=='yes')
	    <div class="section">
			<!-- PAGE-HEADER -->
			<div class="page-header">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="#"><i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Traktorchi-mashinist guvohnomasi')}}</a>
					</li>
				</ol>
			</div>
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

												<a href="{!! url('/driver-licence/list')!!}">

													<span class="visible-xs"></span>

													<i class="fa fa-list fa-lg">&nbsp;</i> 
													Guvohnomalar ro'yxati
												</a>

											</li>

											<li>

												<a href="{!! url('/driver-licence/give')!!}">

													<span class="visible-xs"></span>

													<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

													Guvohnoma berish</b>

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
									<div class="export-licence-button btn btn-primary  mr-2 float-right-button" table='examples1' filename='Texnikalar'><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>
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
											<th class="border-bottom-0 border-top-0">{{ trans('app.Guvohnoma') }}</th>
											<th class="border-bottom-0 border-top-0">Toifa</th>
											<th class="border-bottom-0 border-top-0">{{ trans('app.Haydovchi') }}</th>
											<th class="border-bottom-0 border-top-0">{{ trans('app.SHIR/STIR') }}</th>
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

										@if(!empty($driverLicences))

											@foreach($driverLicences as $licence)

												<?php 

												$types=json_decode($licence->licence_type,true);

												$givenTypes=[];

												foreach($types as $t){

													$givenTypes[]=$t['name'];

												}

												$givenTypes=implode(',',$givenTypes);

												?>

												<tr>
													<td>{{ $i }}</td>
													<td>
														@if (CheckAccessUser('driver_lic', $userid, 'read')=='yes')
															<a href="/driver-licence/preview?id={{$licence->id}}&details=true">{{ $licence->series.$licence->number}}</a>
														@else
															<a href="javascript:void(0)">{{ $licence->series.$licence->number}}</a>
														@endif
													</td>
													<td>{{$givenTypes}}</td>
													<td>
														@if (CheckAccessUser('customer_add', $userid, 'read')=='yes')
															<a href="/customer/list/{{$licence->owner_id}}" class="text-capitalize">{{ $licence->lastname.' '.$licence->name.' '.$licence->middlename }}</a>
														@else
															<a href="javascript:void(0)" class="text-capitalize">{{ $licence->lastname.' '.$licence->name.' '.$licence->middlename }}</a>
														@endif
													</td>
													<td>{{ $licence->id_number?$licence->id_number:$licence->inn }}</td>
													<td>{{ date('d.m.Y',strtotime($licence->given_date)) }} </td>
													<td>
														@if($licence->status=='active')
															<span class="text-success">Faol</span>
														@else
															<span class="text-danger">Faolmas</span>
														@endif
													</td>
													<td class="amount text-right">{{ $licence->total_amount}}</td>
													@if (CheckAdmin($userid)=='yes')
														<td class="no-print"> 
															<a day="{{ $licence->day }}" class="btn btn-round btn-success cancel" url="{!! url ('/driver-licence/cancel/'.$licence->id) !!}"  href="">{{ trans('app.Cancel')}}</a>
												    	</td>
													@endif
												</tr>

												<?php $i++; ?>

											@endforeach

										@endif

									</tbody>

								</table>
								{{ $driverLicences->links() }}
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
	$(".export-licence-button").on('click', function(){
		window.location.href = '{{URL::to('/export/driver-licence')}}';
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
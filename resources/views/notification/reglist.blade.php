@extends('layouts.app')

@section('content')

<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')

	<div class="section">

				<!-- PAGE-HEADER -->

				<div class="page-header">

					<ol class="breadcrumb">

						<li class="breadcrumb-item">

							<i class="fe fe-life-buoy mr-1"></i>&nbsp {{$title}}

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
								<div id="list-date-filter" style="padding: 0">
									<div class="float-right-buttons">
										<div class="export-regout-button btn btn-primary  mr-2 float-right-button" table='examples1' filename='Texnikalar' style="margin: 0"><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>

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

									<table id="examples1" class="table table-bordered text-nowrap mb-0" style="margin-top:20px; width:100%;">
										<thead>
											<tr>
												<th>No</th>
												<th>Texnika egasi</th>
												<th>texnika</th>
												<th>Ro'yxatdan chiqarilgan</th>
												<th>Manzil</th>
												<th>Harakat</th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($reglist))
												<?php $i=1; ?>
												@foreach($reglist as $regNotification)
													<tr>
														<td>{{$i}}</td>
														<td>
															<a href="/customer/list/{{$regNotification->owner_id}}" target="_blank" class="text-capitalize">
																{{$regNotification->owner_lastname.' '.$regNotification->owner_name.' '.$regNotification->owner_middlename}}
															</a>
														</td>
														<td><a href="/vehicle/list/view/{{$regNotification->vehicle_id}}/{{$regNotification->city_id}}" target="_blank">{{$regNotification->vehicle_type.' - '.$regNotification->vehicle_brand}}</a></td>
														<td>{{date('d.m.Y',strtotime($regNotification->date))}}</td>
														<td class="number-font1">{{$regNotification->state.', '.$regNotification->city}}</td>
														<td><a href="/certificate/regadd?type=regged&vehicle_id={{$regNotification->vehicle_id}}" class="btn btn-danger">Ro'yxatga olish</a></td>
													</tr>
													<?php $i++ ?>
												@endforeach
											@else
												<tr><td colspan="4">Eslatmalar yo'q</td></tr>
											@endif
										</tbody>
									</table>
									@if(!empty($reglist))
										{{$reglist->links()}}
									@endif

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

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

 <!-- language change in user selected -->	

<script>

$(document).ready(function() {

	$(".export-regout-button").on('click', function(){
		window.location.href = '{{URL::to('/export/regout')}}';
	});

    $('#examples').DataTable( {

		"responsive": true,
		"paging":     false,
		"info":       false

	} );
	

	$("input[name='search_key']").keyup(function(){
		var key = $(this).val();
		if(key == ''){
			window.location.href = "/vehicle/list";
		}else{
			window.location.href = "/vehicle/list?key="+key;
		}
	})

} );

</script>

<!-- delete vehical -->

<script>

 $('body').on('click', '.sa-warning', function() {

  

    var url = $(this).attr('url');

    

        swal({   

            title: "O'chirishni istaysizmi?",

      		text: "O'chirilgan ma'lumotlar qayta tiklanmaydi!",   

            type: "warning",   

            showCancelButton: true,   

            confirmButtonColor: "#297FCA",   

            confirmButtonText: "Ha, o'chirish!",   

            closeOnConfirm: false,

            cancelButtonText: "O'chirishni bekor qilish"

        }).then((isConfirm) =>{

      window.location.href = url;

             

        });

    }); 



 

</script>



@endsection
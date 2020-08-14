@extends('layouts.app')

@section('content')

<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('vehicle_lock', $userid, 'read')=='yes')

		<div class="section">

			<!-- PAGE-HEADER -->

			<div class="page-header">

				<ol class="breadcrumb">

					<li class="breadcrumb-item">

						<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Taqiqqa olish')}}

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

			<div class="row">

				<div class="col-md-12">

					<div class="card">									

						<div class="card-body">

							<div class="panel panel-primary">

								<div class="tab_wrapper page-tab">

									<ul class="tab_list">

										<li class="active"><a href="{!! url('/vehicle/vehicle_lock')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Taqiqqa olingan texnikalar') }}</b></a></li>

											@if (CheckAccessUser('vehicle_lock', $userid, 'create')=='yes')

												<li role="presentation" class="">

													<a href="{!! url('/vehicle/lock')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>

														{{ trans('app.Taqiqqa olish') }}

													</a>

												</li>

											@else

												<li role="presentation" class="">

													<a href="javascript:void(0)"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>

														{{ trans('app.Taqiqqa olish') }}

													</a>

												</li>

											@endif	

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

										<div class="export-excel-button btn btn-primary  mr-2 float-right-button" table='example-1' filename='Taqiqqa olingan texnikalar'><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>

									</div>

								</div>

							<div class="table-responsive">

								<table id="examples1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

									<thead>

										<tr>

											<th>#</th>

											<th>Egasi</th>

											<th>{{ trans('app.Locker name') }}</th>

											<th>Texnika</th>

											<th>Davlat raqami</th>

											<th>{{ trans('app.Date')}}</th>

											<th class="border-bottom-0 border-top-0 no-print">{{ trans('app.Action')}}</th>

										</tr>

									</thead>

									<tbody>

									   <?php $i=1;?>

										@if(!empty($vehicles))

											@foreach($vehicles as $vehicle)

											<tr>

												<td>{{ $i }}</td>

												<td>

													<a class="text-capitalize" href="{!! url('/customer/list/'.$vehicle->owner_id) !!}">
														@if(CheckAccessUser('customers', $userid, 'customer_add'))
															<span class="text-capitalize">
																@if($vehicle->ownertype=='legal')
																	{{ $vehicle->ownername }}
																@elseif($vehicle->ownertype == 'physical')
																	{{ $vehicle->ownerlastname.' '.$vehicle->ownername }} 
																	@if(!empty($vehicle->middlename))
																		{{ $vehicle->middlename }}
																	@endif
																@endif
															</a>
														@else
															<a class="text-capitalize" href="javascript:void(0)">
																@if($vehicle->ownertype=='legal')
																	{{ $vehicle->ownername }}
																@elseif($vehicle->ownertype == 'physical')
																	{{ $vehicle->ownerlastname.' '.$vehicle->ownername }} 
																	@if(!empty($vehicle->middlename))
																		{{ $vehicle->middlename }}
																	@endif
																@endif
															</span>
														@endif
													</a>

												</td>

												<td>{{ $vehicle->name }}</td>

												<td>
													@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')
														<a href="{!! url('/vehicle/list/view/'.$vehicle->id) !!}">{{ $vehicle->typename.' '.$vehicle->brandname }}</a>
													@else
														<a href="javascript:void(0)">{{ $vehicle->typename.' '.$vehicle->brandname }}</a>
													@endif
												</td>

												<td>

													@if($vehicle->vehicle == 'agregat')
																—
															@else
																@if($vehicle->tns == 'active')

																	{{ $vehicle->code.' '.$vehicle->series.' '.$vehicle->number }}

																@else

																	{{ trans('app.Davlat raqami berilmagan') }}

																@endif
															@endif

												</td>

												<td>{{ date('d.m.Y', strtotime($vehicle->letter_date)) }}</td>

												<td class="no-print"> 

													@if (CheckAccessUser('vehicle_lock', $userid, 'create')=='yes')

														<a href="{!! url ('/vehicle/lock/'.$vehicle->id) !!}"> 

															<button type="button" class="btn btn-round btn-success">Taqiqdan chiqarish</button>

														</a>

													@else

														<a href="{!! url ('/vehicle/lock/'.$vehicle->id) !!}"> 

															<button type="button" class="btn btn-round btn-success">Taqiqdan chiqarish</button>

														</a>

													@endif

											    </td>

											</tr>

											<?php $i++; ?>

											@endforeach

										@endif

										

									</tbody>

								</table>
								@if(!empty($vehicles))
									{{$vehicles->links()}}
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

    $('#datatable').DataTable( {

		responsive: true,

        "language": {

			

				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 

			?>.json"

        }

    } );

} );

</script>

<!-- delete vehical -->

<script>

 $('body').on('click', '.sa-warning', function() {

  

    var url =$(this).attr('url');

    

        swal({   

            title: "O'chirishni istaysizmi?",

      text: "O'chirilgan ma'lumotlar qayta tiklanmaydi!",   

            type: "warning",   

            showCancelButton: true,   

            confirmButtonColor: "#297FCA",   

            confirmButtonText: "Ha, o'chirish!",   

            closeOnConfirm: false,

            cancelButtonText: "O'chirishni bekor qilish"

        }, function(){

      window.location.href = url;

             

        });

    }); 

 

</script>



@endsection
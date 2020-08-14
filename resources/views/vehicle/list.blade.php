@extends('layouts.app')

@section('content')

<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')

	<div class="section">

				<!-- PAGE-HEADER -->

				<div class="page-header">

					<ol class="breadcrumb">

						<li class="breadcrumb-item">

							<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Vehicle')}}

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

												<li class="{{$type=='all'?'active':''}}">

													<a href="{!! url('/vehicle/list')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														{{ trans('app.Ro\'yxat') }}

													</a>

												</li>

												<li class="{{$type=='legal'?'active':''}}">

													<a href="{!! url('/vehicle/list?type=legal')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														{{ trans('app.Yuridik shaxslar') }}

													</a>

												</li>

												<li class="{{$type=='physical'?'active':''}}">

													<a href="{!! url('/vehicle/list?type=physical')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														{{ trans('app.Jismoniy shaxslar') }}

													</a>

												</li>

												<li>

													@if (CheckAccessUser('vehicle_add', $userid, 'create')=='yes')

														<a href="{!! url('/certificate/regadd?type=regged')!!}">

															<span class="visible-xs"></span>

															<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

															{{ trans('app.Qo\'shish') }}</b>

														</a>

													@else

														<a href="javascript:void(0)">

															<span class="visible-xs"></span>

															<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

															{{ trans('app.Qo\'shish') }}</b>

														</a>

													@endif

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
										<div class="export-vehicle-button btn btn-primary  mr-2 float-right-button" table='examples1' filename='Texnikalar'><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>

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

												<th class="border-bottom-0 border-top-0">{{ trans('app.Rusumi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Turi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Turi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Texnika egasi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Ishlash sohasi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Davlat raqami')}}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Texnik passport')}}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Qo\'shimcha')}}</th>

												<th class="border-bottom-0 border-top-0 no-print">{{ trans('app.Action')}}</th>

											</tr>

										</thead>

										<tbody>

										<?php 
											if(isset($_GET['page'])){
												$i = (intval($_GET['page'])-1)*50+1;
											}else{
												$i = 1;
											}
											
										 ?>

											@if(!empty($vehical))
												@foreach($vehical as $vehicals)
													<tr>
														<td>{{ $i }}</td>
														<td>
															@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')
																<a href="{!! url('/vehicle/list/view/'.$vehicals->id.'/'.$vehicals->city_id) !!}">{{ $vehicals->brandname }}</a>
															@else
																<a href="javascript:void(0)">{{ $vehicals->brandname }}</a>
															@endif
														</td>
														<td>{{ trans('app.'.$vehicals->type) }}</td>
														<td>{{ $vehicals->typename }}</td>
														<td>
															@if(CheckAccessUser('customers', $userid, 'customer_add'))
																<a class="text-capitalize" href="{!! url('/customer/list/'.$vehicals->owner_id) !!}">
																	@if($vehicals->ownertype=='legal')
																		{{ $vehicals->ownername }}
																	@elseif($vehicals->ownertype == 'physical')
																		{{ $vehicals->ownerlastname.' '.$vehicals->ownername }} 
																		@if(!empty($vehicals->middlename))
																			{{ $vehicals->middlename }}
																		@endif
																	@endif
																</a>
															@else
																<a class="text-capitalize" href="javascript:void(0)">
																	@if($vehicals->ownertype=='legal')
																		{{ $vehicals->ownername }}
																	@elseif($vehicals->ownertype == 'physical')
																		{{ $vehicals->ownerlastname.' '.$vehicals->ownername }} 
																		@if(!empty($vehicals->middlename))
																			{{ $vehicals->middlename }}
																		@endif
																	@endif
																</a>
															@endif
														</td>

														<td>{{ $vehicals->workname }}</td>

														<td>

															@if($vehicals->type == 'agregat')
																—
															@else
																@if($vehicals->tns == 'active')

																	{{ $vehicals->code.' '.$vehicals->series.' '.$vehicals->number }}

																@else

																	{{ trans('app.Davlat raqami berilmagan') }}

																@endif
															@endif

														</td>

														<td>

															@if($vehicals->tps == 'active')

																{{ $vehicals->pass.'-'.$vehicals->pasn }}

															@else

																{{ trans('app.Texnik passport berilmagan') }}

															@endif

														</td>

														<td>

															@if($vehicals->lising == '1')

																{{ trans('app.Lisingda') }}

															@elseif($vehicals->lock)

																{{ trans('app.Taqiqda') }}

															@endif

														</td>

														<td class="no-print"> 

														<?php $userid=Auth::User()->id; ?>

														@if (CheckAccessUser('vehicle_add', $userid, 'edit')=='yes')

															<a href="{!! url ('/vehicle/list/edit/'.$vehicals->id.'/'.$vehicals->city_id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>

														@endif

													    </td>

													</tr>

													<?php $i++; ?>

												@endforeach

											@endif

										</tbody>

									</table>
									@if(!empty($vehical))
										{{$vehical->links()}}
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

	$(".export-vehicle-button").on('click', function(){
		window.location.href = '{{URL::to('/export/vehicle-list')}}';
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
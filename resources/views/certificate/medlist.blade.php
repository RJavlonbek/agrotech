@extends('layouts.app')

@section('content')

<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('vehicle_med', $userid, 'read')=='yes')

	<div class="section">

				<!-- PAGE-HEADER -->

				<div class="page-header">

					<ol class="breadcrumb">

						<li class="breadcrumb-item">

							<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Texnikani texnik ko\'rikdan o\'tkazish')}}

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

													<a href="{!! url('/certificate/medlist')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														{{ trans('app.Texnik ko\'riklar')}}

													</a>

												</li>

												<li>

													<a href="{!! url('/certificate/medadd')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

														{{ trans('app.Texnik ko\'rikdan o\'tkazish')}}</b>

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

										<div class="export-med-button btn btn-primary  mr-2 float-right-button" table='examples1' filename="Texnik ko'riklar"><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>

									</div>

								</div>

								<div class="table-responsive">

									<table id="examples1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

										<thead>

											<tr>
												<th class="border-bottom-0 border-top-0">#</th>
												<th class="border-top-0 border-bottom-0">Texnik ko'rik turi</th>
												<th class="border-bottom-0 border-top-0 text-capitalize">Egasi</th>
												<th class="border-bottom-0 border-top-0">Texnika</th>
												<th class="border-bottom-0 border-top-0">Davlat raqami</th>
												<th class="border-bottom-0 border-top-0">Talon raqami</th>
												<th class="border-bottom-0 border-top-0">To'lov</th>
												{{-- <th class="border-bottom-0 border-top-0">{{ trans('app.Condition') }}</th> --}}
												<th class="border-bottom-0 border-top-0">{{ trans('app.Date')}}</th>
											</tr>

										</thead>

										<tbody>

										<?php $i=1;?>

											@if(!empty($meds))

												@foreach($meds as $med)

													<tr>

														<td>{{ $i }}</td>
														<td>
															<a href="/technical-inspection/preview?id={{$med->id}}">{{$med->inspection_type}}</a>
														</td>
														<td>

															@if(CheckAccessUser('customers', $userid, 'customer_add'))
																<a class="text-capitalize" href="{!! url('/customer/list/'.$med->owner_id) !!}">
																	@if($med->ownertype=='legal')
																		{{ $med->ownername }}
																	@elseif($med->ownertype == 'physical')
																		{{ $med->ownerlastname.' '.$med->ownername }} 
																		@if(!empty($med->middlename))
																			{{ $med->middlename }}
																		@endif
																	@endif
																</a>
															@else
																<a class="text-capitalize" href="javascript:void(0)">
																	@if($med->ownertype=='legal')
																		{{ $med->ownername }}
																	@elseif($med->ownertype == 'physical')
																		{{ $med->ownerlastname.' '.$med->ownername }} 
																		@if(!empty($med->middlename))
																			{{ $med->middlename }}
																		@endif
																	@endif
																</a>
															@endif

															

														</td>

														<td>{{ $med->typename.' '.$med->brandname }}</td>

														<td>
															@if($med->vehicle == 'agregat')
																—
															@else
																@if($med->tns == 'active')

																	{{ $med->code.' '.$med->series.' '.$med->number }}

																@else

																	{{ trans('app.Davlat raqami berilmagan') }}

																@endif
															@endif

														</td>

														<td>

															@if(!empty($med->talonno))

																{{ $med->talonno }}

															@endif

														</td>

														<td class="amount text-right">

															@if(!empty($med->total_amount))

																{{ $med->total_amount }}

															@endif

														</td>

														{{-- <td>{{ trans('app.'.$med->status) }}</td> --}}

														<td>

															<span <?php if($med->diff>365)echo"class='text-danger'"  ?>>

																{{date('d.m.Y',strtotime($med->givendate))}} 

																@if($med->diff>365)

																	({{ $med->diff-365 }})

																@endif

															</span>

															

														</td>

													</tr>

													<?php $i++; ?>

												@endforeach

											@endif

										</tbody>

									</table>
									@if(!empty($meds))
										{{$meds->links()}}
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
	$(document).ready(function(){
		$(".export-med-button").on('click', function(){
			window.location.href = '{{URL::to('/export/med')}}';
		});
	})
 $('body').on('click', '.sa-warning', function() {

  

    var url = $(this).attr('url');

    

        swal({   

            title: "Are You Sure?",

      text: "You will not be able to recover this data afterwards!",   

            type: "warning",   

            showCancelButton: true,   

            confirmButtonColor: "#297FCA",   

            confirmButtonText: "Yes, delete!",   

            closeOnConfirm: false 

        }).then((result) => {

      		window.location.href = url;             

        });

    }); 

 

</script>



@endsection
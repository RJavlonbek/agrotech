@extends('layouts.app')
@section('content')

@if(!empty($transportNumber))
	<?php $userid = Auth::user()->id; ?>
	@if (CheckAccessUser('vehicle_num', $userid, 'read')=='yes')
		<section>
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-12 details">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="row">
										<div class="col-12 wideget-user-desc d-flex">
											<div class="user-wrap">
												<h4 class="fw-600 fs-25">
													<span><i class="fa fa-car mr-3"></i></span>Texnik ko'rik
												</h4>
											</div>
										</div>										
									</div>
									<div class="row">
										<div class="col-md-3 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">Turi:</span>
												<span class="customer-info-text">{{ $transportNumber->inspection_type }}</span>
											</div>
										</div>
										<div class="col-md-3 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">Berilgan joyi:</span>
												<span class="customer-info-text">{{ $transportNumber->state }}, {{ $transportNumber->city }}</span>
											</div>
										</div>
										<div class="col-md-3 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">Sana</span>
												<span class="customer-info-text">
													{{ date('d.m.Y',strtotime($transportNumber->date)) }}
												</span>
											</div>
										</div>

										<div class="col-md-3 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">To'lov:</span>
												<span class="customer-info-text amount">{{ $transportNumber->total_amount }}</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 wideget-user-desc d-flex">
											<div class="user-wrap">
												<h4 class="fw-600 fs-25">
													<span><i class="fa fa-car mr-3"></i></span>Texnika haqida ma'lumotlar:
												</h4>
											</div>
										</div>										
									</div>
									<div class="row">

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">Turi:</span>

												<span class="customer-info-text">{{ $transportNumber->vehicle_type }}</span>

											</div>

										</div>

										@if($transportNumber->code && $transportNumber->series && $transportNumber->number)
											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">Davlat raqami:</span>

													<span class="customer-info-text">{{ $transportNumber->code.' '.$transportNumber->series.$transportNumber->number }}</span>

												</div>

											</div>
										@endif
										

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Vehicle Brand :')}}</span>

												<span class="customer-info-text">

													{{ $transportNumber->vehicle_brand }}

												</span>

											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Working Type')}}:</span>

												<span class="customer-info-text">

													{{ $transportNumber->working_type }}

												</span>

											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Engine No')}}:</span>

												<span class="customer-info-text">

													{{ $transportNumber->engineno }}

												</span>

											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Model Year :')}}</span>

												<span class="customer-info-text">

													{{ $transportNumber->modelyear }}

												</span>

											</div>

										</div>

										<div class="col-md-6 col-12">	

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Condition')}}</span>

												<span class="customer-info-text">

													{{ trans('app.'.$transportNumber->condition) }}

												</span>

											</div>

										</div>

											<div class="col-md-6 col-12">	

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Chasic No')}}:</span>

													<span class="customer-info-text">

														{{ $transportNumber->chassisno }}

													</span>

												</div>

											</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Factory Number')}}:</span>

												<span class="customer-info-text">

													@if(!empty($vehicle->factory_number))

											 			{{ $transportNumber->factory_number }} 

											 		@else

											 		{{ trans('app.Topilmadi') }}

											 		@endif

												</span>

											</div>

										</div>
									</div>

									<div class="row">

										<div class="col-12 wideget-user-desc d-flex">

											<div class="user-wrap">

												<h4 class="fw-600 fs-25">

													<span><i class="fa fa-user mr-3"></i></span> Egasi haqida ma'lumotlar:

												</h4>

											</div>

										</div>										

									</div>

									<div class="row">

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">Egasi:</span>

												<span class="customer-info-text">
													<a class="text-capitalize" target="_blank" href="/customer/list/{{ $transportNumber->owner_id }}">
														{{ $transportNumber->owner_lastname.' '.$transportNumber->owner_name.' '.$transportNumber->owner_middlename }}
													</a>
												</span>
											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">Turi(yuridik yoki jismoniy):</span>

												<span class="customer-info-text">
													{{ trans('app.'.$transportNumber->owner_type) }}
												</span>

											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Viloyat') }}:</span>

												<span class="customer-info-text">
													{{$transportNumber->state}}
												</span>

											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Town/City')}}:</span>

												<span class="customer-info-text">
													{{$transportNumber->city}}
												</span>

											</div>

										</div>
										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">Manzil:</span>

												<span class="customer-info-text">
													{{$transportNumber->address}}
												</span>

											</div>

										</div>
										@if($transportNumber->owner_type != 'legal')

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Passport No')}}:</span>

													<span class="customer-info-text">
														{{ $transportNumber->passport_series.'-'.$transportNumber->passport_number }}
													</span>

												</div>

											</div>

										@endif

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.STIR')}}:</span>

												<span class="customer-info-text">{{$transportNumber->inn}}</span>
											</div>
										</div>

									</div>
								</div>	
							</div>
						</div>
						<div class="col-4">
							
						</div>
					</div>
				</div>
			</div>
		</section>
	@else
	<div class="section" role="main">
		<div class="card">
			<div class="card-body text-center">
				<span class="titleup text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
			</div>
		</div>
	</div>

	@endif 
@endif

@if(!empty($print) && $print)
	<script type="text/javascript">
		$(document).ready(function(){
			console.log('loaded');
			window.print();
		});
	</script>
@endif
	
@endsection
@extends('layouts.app')
@section('content')

@if(!empty($certificate))
	<?php $userid = Auth::user()->id; ?>
		@if (CheckAccessUser('vehicle_pass', $userid, 'read')=='yes')
			<section>
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-12 details">
								<div class="row">
									<div class="col-md-12 col-sm-12">

										<div class="row">

											<div class="wideget-user-desc d-flex col-12">

												<div class="user-wrap">

													<h4 class="fw-600 fs-25">

														<span><i class="fa fa-file mr-3"></i></span>Texnik 	guvohnoma:

													</h4>

												</div>

											</div>										

										</div>
										<div class="row">
											<div class="col-md-4 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Seriya raqam:</span>
													<span class="customer-info-text">{{ $certificate->series.' '.$certificate->number }}</span>
												</div>
											</div>
											<div class="col-md-4 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Berilgan sana</span>
													<span class="customer-info-text">
														{{ date('d.m.Y',strtotime($certificate->given_date)) }}
													</span>
												</div>
											</div>

											<div class="col-md-4 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">Holati:</span>
													@if($certificate->status=='active')
														<span class="customer-info-text text-success">
															Faol
														</span>
													@else
														<span class="customer-info-text text-danger">
															Faolmas
														</span>
													@endif
												</div>
											</div>
											<div class="col-md-6 col-12 mb-2">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Asos hujjat:</span>
													<span class="customer-info-text">{{$certificate->doc ? $certificate->doc : 'Kiritilmagan' }}</span>
												</div>
											</div>
											<div class="col-md-6 col-12 mb-2">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Asos hujjat ma'lumotlari:</span>
													<span class="customer-info-text">{{$certificate->doc_note ? $certificate->doc_note : 'Kiritilmagan' }}</span>
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

													<span class="customer-info-text">{{ $certificate->vehicle_type }}</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Vehicle Brand :')}}</span>

													<span class="customer-info-text">

														{{$certificate->vehicle_brand}}

													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Working Type')}}:</span>

													<span class="customer-info-text">

														{{ $certificate->working_type }}

													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Engine No')}}:</span>

													<span class="customer-info-text">

														{{ $certificate->engineno }}

													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Model Year :')}}</span>

													<span class="customer-info-text">

														{{ $certificate->modelyear }}

													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">	

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Condition')}}</span>

													<span class="customer-info-text">

														{{ trans('app.'.$certificate->condition) }}

													</span>

												</div>

											</div>

												<div class="col-md-6 col-12">	

													<div class="customer-info-item border-bottom pt-3 fs-16">

														<span class="customer-info-desc fw-600">{{ trans('app.Chasic No')}}:</span>

														<span class="customer-info-text">

															{{ $certificate->chassisno }}

														</span>

													</div>

												</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Factory Number')}}:</span>

													<span class="customer-info-text">

														@if(!empty($vehicle->factory_number))

												 			{{ $certificate->factory_number }} 

												 		@else

												 		{{ trans('app.Topilmadi') }}

												 		@endif

													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Davlat raqami')}}:</span>

													<span class="customer-info-text">

														@if(!empty($certificate->n_code))

															{{$certificate->n_code.' '.$certificate->n_number.$certificate->n_series}}

														@else

															{{ trans("app.Davlat raqami berilmagan") }}

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

													<span class="customer-info-desc fw-600">Turi(yuridik yoki jismoniy):</span>

													<span class="customer-info-text">
														{{ trans('app.'.$certificate->owner_type) }}
													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Texnika egasi')}}:</span>

													<span class="customer-info-text">
														<a class="text-capitalize" target="_blank" href="/customer/list/{{ $certificate->owner_id }}">
															{{ $certificate->owner_lastname.' '.$certificate->owner_name.' '.$certificate->owner_middlename }}
														</a>
													</span>
												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Viloyat') }}:</span>

													<span class="customer-info-text">
														{{$certificate->state}}
													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Town/City')}}:</span>

													<span class="customer-info-text">
														{{$certificate->city}}
													</span>

												</div>

											</div>

											@if($certificate->owner_type != 'legal')

												<div class="col-md-6 col-12">

													<div class="customer-info-item border-bottom pt-3 fs-16">

														<span class="customer-info-desc fw-600">{{ trans('app.Passport No')}}:</span>

														<span class="customer-info-text">
															{{ $certificate->passport_series.'-'.$certificate->passport_number }}
														</span>

													</div>

												</div>

											@endif

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.STIR')}}:</span>

													<span class="customer-info-text">{{$certificate->inn}}</span>
												</div>
											</div>
										</div>
									</div>	
								</div>
							</div>
							<div class="col-12 border-bottom" id="single-page-preview">
								<iframe src="/certificate/preview?id={{$certificate->id}}" height="320"></iframe>
							</div>
							@if(strtotime($certificate->updated_at) >= strtotime('-1 day') && $certificate->status=='active')
								<div class="col-12 text-right py-3">
									<button class="btn btn-primary mb-4" id="print-saved-document">Chop etish</button>
								</div>
							@endif
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

@else
	something
@endif

@if(!empty($print) && $print)
	<script type="text/javascript">
		$(document).ready(function(){
			console.log('loaded');
			window.print();
		});
	</script>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
	$(function(){
		console.log('ready');
		$('button#print-saved-document').on('click', function(e){
			console.log('clicked');
			let iframe=$('#single-page-preview iframe');
			iframe.attr('src', iframe.attr('src')+'&print=true');
		});
	});
</script>
	
@endsection
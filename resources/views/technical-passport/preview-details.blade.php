@extends('layouts.app')
@section('content')

@if(!empty($technicalPassport))
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
											<div class="col-12 wideget-user-desc d-flex">
												<div class="user-wrap">
													<h4 class="fw-600 fs-25">
														<span><i class="fa fa-car mr-3"></i></span>Texnik passport
													</h4>
												</div>
											</div>										
										</div>
										<div class="row">
											<div class="col-md-4 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Seriya raqam:</span>
													<span class="customer-info-text">{{ $technicalPassport->series.' '.$technicalPassport->number }}</span>
												</div>
											</div>
											<div class="col-md-4 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Berilgan sana</span>
													<span class="customer-info-text">
														{{ date('d.m.Y',strtotime($technicalPassport->given_date)) }}
													</span>
												</div>
											</div>

											<div class="col-md-4 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">Holati:</span>
													@if($technicalPassport->status=='active')
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
													<span class="customer-info-text">{{$technicalPassport->doc ? $technicalPassport->doc : 'Kiritilmagan' }}</span>
												</div>
											</div>
											<div class="col-md-6 col-12 mb-2">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Asos hujjat ma'lumotlari:</span>
													<span class="customer-info-text">{{$technicalPassport->doc_note ? $technicalPassport->doc_note : 'Kiritilmagan' }}</span>
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

													<span class="customer-info-text">{{ $technicalPassport->vehicle_type }}</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Vehicle Brand :')}}</span>

													<span class="customer-info-text">

														{{ $technicalPassport->vehicle_brand }}

													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Working Type')}}:</span>

													<span class="customer-info-text">

														{{ $technicalPassport->working_type }}

													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Engine No')}}:</span>

													<span class="customer-info-text">

														{{ $technicalPassport->engineno }}

													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Model Year :')}}</span>

													<span class="customer-info-text">

														{{ $technicalPassport->modelyear }}

													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">	

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Condition')}}</span>

													<span class="customer-info-text">

														{{ trans('app.'.$technicalPassport->condition) }}

													</span>

												</div>

											</div>

												<div class="col-md-6 col-12">	

													<div class="customer-info-item border-bottom pt-3 fs-16">

														<span class="customer-info-desc fw-600">{{ trans('app.Chasic No')}}:</span>

														<span class="customer-info-text">

															{{ $technicalPassport->chassisno }}

														</span>

													</div>

												</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Factory Number')}}:</span>

													<span class="customer-info-text">

														@if(!empty($vehicle->factory_number))

												 			{{ $technicalPassport->factory_number }} 

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

														@if(!empty($technicalPassport->n_code))

															{{ $technicalPassport->n_code.' '.$technicalPassport->n_series.' '.$technicalPassport->n_number }}

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
														{{ trans('app.'.$technicalPassport->owner_type) }}
													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Texnika egasi')}}:</span>

													<span class="customer-info-text">
														<a class="text-capitalize" target="_blank" href="/customer/list/{{ $technicalPassport->owner_id }}">
															{{ $technicalPassport->owner_lastname.' '.$technicalPassport->owner_name.' '.$technicalPassport->owner_middlename }}
														</a>
													</span>
												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Viloyat') }}:</span>

													<span class="customer-info-text">
														{{$technicalPassport->state}}
													</span>

												</div>

											</div>

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Town/City')}}:</span>

													<span class="customer-info-text">
														{{$technicalPassport->city}}
													</span>

												</div>

											</div>

											@if($technicalPassport->owner_type != 'legal')

												<div class="col-md-6 col-12">

													<div class="customer-info-item border-bottom pt-3 fs-16">

														<span class="customer-info-desc fw-600">{{ trans('app.Passport No')}}:</span>

														<span class="customer-info-text">
															{{ $technicalPassport->passport_series.'-'.$technicalPassport->passport_number }}
														</span>

													</div>

												</div>

											@endif

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.STIR')}}:</span>

													<span class="customer-info-text">{{$technicalPassport->inn}}</span>
												</div>
											</div>
										</div>
									</div>	
								</div>
							</div>
							<div class="col-12 border-bottom" id="single-page-preview">
								<iframe src="/vehicle/technical-passport/preview?id={{$technicalPassport->id}}" height="320"></iframe>
							</div>
							@if(strtotime($technicalPassport->updated_at) >= strtotime('-1 day') && $technicalPassport->status=='active')
								<div class="col-12 text-right py-3">
									<button class="btn btn-primary mb-4" id="print-saved-document">Chop etish</button>
								</div>
							@endif
						</div>
					</div>
				</div>
			</section>
		@else

			<div class="right_col" role="main">

				<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">

		            <div class="nav toggle" style="padding-bottom:16px;">

		               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.') }}</span>

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
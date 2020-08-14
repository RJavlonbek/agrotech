@extends('layouts.app')
@section('content')

@if(!empty($driverLicence))
	<?php $userid = Auth::user()->id; ?>
	@if (CheckAccessUser('driver_lic', $userid, 'read')=='yes')
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
													<span><i class="fa fa-user mr-3"></i></span> Guvohnoma:
												</h4>
											</div>
										</div>										
									</div>

									<div class="row">
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">Seriya raqam:</span>
												<span class="customer-info-text">{{$driverLicence->series.$driverLicence->number }}</span>
											</div>
										</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">Holati:</span>
												@if($driverLicence->status=='active')
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
												<span class="customer-info-text">{{$driverLicence->doc ? $driverLicence->doc : 'Kiritilmagan' }}</span>
											</div>
										</div>
										<div class="col-md-6 col-12 mb-2">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">Asos hujjat ma'lumotlari:</span>
												<span class="customer-info-text">{{$driverLicence->doc_note ? $driverLicence->doc_note : 'Kiritilmagan' }}</span>
											</div>
										</div>
										<?php
										$types=json_decode($driverLicence->type,true);
										?>
										@foreach($types as $type)
											<div class="col-md-2 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Toifa:</span>
													<span class="customer-info-text">{{$type['name']}}</span>
												</div>
											</div>
											<div class="col-md-5 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Berilgan sana:</span>
													<span class="customer-info-text">{{date('d.m.Y',strtotime($type['given_date']))}}</span>
												</div>
											</div>
											<div class="col-md-5 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Yaroqlilik muddati:</span>
													<span class="customer-info-text">{{date('d.m.Y',strtotime('+10 years',strtotime($type['given_date'])))}}</span>
												</div>
											</div>
										@endforeach
									</div>

									<div class="row">
										<div class="wideget-user-desc d-flex col-12">
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
												<span class="customer-info-desc fw-600">{{ trans('app.Owner name')}}:</span>
												<span class="customer-info-text">
													<a class="text-capitalize" target="_blank" href="/customer/list/{{ $driverLicence->owner_id }}">
														{{ $driverLicence->owner_lastname.' '.$driverLicence->owner_name.' '.$driverLicence->owner_middlename }}
													</a>
												</span>
											</div>
										</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">Tug'ilgan sana:</span>
												<span class="customer-info-text">{{date('d.m.Y',strtotime($driverLicence->d_o_birth))}}</span>
											</div>
										</div>
										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Viloyat') }}:</span>

												<span class="customer-info-text">
													{{$driverLicence->state}}
												</span>

											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Town/City')}}:</span>

												<span class="customer-info-text">
													{{$driverLicence->city}}
												</span>

											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">Manzil:</span>

												<span class="customer-info-text">
													{{$driverLicence->address ? $driverLicence->address : 'Kiritilmagan'}}
												</span>

											</div>

										</div>


										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">{{ trans('app.Passport No')}}:</span>

												<span class="customer-info-text">
													{{ $driverLicence->passport_series.'-'.$driverLicence->passport_number }}
												</span>
											</div>
										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.STIR')}}:</span>

												<span class="customer-info-text">{{$driverLicence->inn}}</span>
											</div>
										</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">{{ trans('app.SHIR')}}:</span>
												<span class="customer-info-text">{{$driverLicence->inn}}</span>
											</div>
										</div>
									</div>
								</div>	
							</div>
						</div>
						<div class="col-12 border-bottom" id="single-page-preview">
							<iframe src="/driver-licence/preview?id={{$driverLicence->id}}" height="320"></iframe>
						</div>
						@if(strtotime($driverLicence->updated_at) >= strtotime('-1 day') && $driverLicence->status=='active')
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
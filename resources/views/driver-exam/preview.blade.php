@extends('layouts.app')
@section('content')

@if(!empty($driverexam))
	<?php $userid = Auth::user()->id; ?>
	@if (CheckAccessUser('driver_exam', $userid, 'read')=='yes')

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

													<span><i class="fa fa-user mr-3"></i></span> Imtihon:

												</h4>

											</div>

										</div>										

									</div>

									<div class="row">

										<div class="col-md-4 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">Imtihon turi:</span>

												<span class="customer-info-text">{{$driverexam->examtype }}</span>

											</div>

										</div>

										<div class="col-md-4 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">Natijasi:</span>

												<span class="customer-info-text text-danger">

													@if(!empty($driverexam->result))

														{{ $driverexam->result }}

													@else
														Kiritilmagan
													@endif
												</span>

											</div>

										</div>
										<div class="col-md-4 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">Sana:</span>

												<span class="customer-info-text">
													{{date('d.m.Y',strtotime($driverexam->given_date))}}
												</span>

											</div>

										</div>
									</div>

									<div class="row">

										<div class="col-12 wideget-user-desc d-flex">

											<div class="user-wrap">

												<h4 class="fw-600 fs-25">

													<span><i class="fa fa-user mr-3"></i></span> Traktorchi-mashinist:

												</h4>

											</div>

										</div>										

									</div>

									<div class="row">

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">F.I.SH.:</span>

												<span class="customer-info-text">

													<a class="text-capitalize" target="_blank" href="/customer/list/{{ $driverexam->owner_id }}">

														{{ $driverexam->owner_lastname.' '.$driverexam->owner_name.' '.$driverexam->owner_middlename }}

													</a>

												</span>

											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">Tug'ilgan sana:</span>

												<span class="customer-info-text">{{date('d.m.Y',strtotime($driverexam->d_o_birth))}}</span>

											</div>

										</div>

										<div class="col-md-6 col-12">



											<div class="customer-info-item border-bottom pt-3 fs-16">



												<span class="customer-info-desc fw-600">{{ trans('app.Viloyat') }}:</span>



												<span class="customer-info-text">

													{{$driverexam->state}}

												</span>



											</div>



										</div>



										<div class="col-md-6 col-12">



											<div class="customer-info-item border-bottom pt-3 fs-16">



												<span class="customer-info-desc fw-600">{{ trans('app.Town/City')}}:</span>



												<span class="customer-info-text">

													{{$driverexam->city}}

												</span>



											</div>



										</div>



										<div class="col-md-6 col-12">



											<div class="customer-info-item border-bottom pt-3 fs-16">



												<span class="customer-info-desc fw-600">Manzil:</span>



												<span class="customer-info-text">

													{{$driverexam->address}}

												</span>



											</div>



										</div>





										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.Passport No')}}:</span>



												<span class="customer-info-text">

													{{ $driverexam->passport_series.'-'.$driverexam->passport_number }}

												</span>

											</div>

										</div>



										<div class="col-md-6 col-12">



											<div class="customer-info-item border-bottom pt-3 fs-16">



												<span class="customer-info-desc fw-600">{{ trans('app.STIR')}}:</span>



												<span class="customer-info-text">{{$driverexam->inn}}</span>

											</div>

										</div>

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">

												<span class="customer-info-desc fw-600">{{ trans('app.SHIR')}}:</span>

												<span class="customer-info-text">{{$driverexam->inn}}</span>

											</div>

										</div>

									</div>

								</div>	

							</div>

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

	

@endsection
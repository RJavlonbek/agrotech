@extends('layouts.app')

	@section('content')

	<style>

		.right_side .table_row, .member_right .table_row {

		    border-bottom: 1px solid #dedede;

		    float: left;

		    width: 100%;

			padding: 1px 0px 4px 2px;

			

		}

		.member_right{border: 1px solid #dedede;

		    margin-left: 9px;}

		.table_row .table_td {
		  padding: 8px 8px !important;

		}

		.report_title {

		    float: left;

		    font-size: 20px;

		    margin-bottom: 10px;

		    padding-top: 10px;

		    width: 100%;

		}

		.b-detail__head-title {

		    border-left: 4px solid #2A3F54;

		    padding-left: 15px;

		   text-transform: capitalize;

		  

		}



		 .b-detail__head-price {

		    width: 100%;

		    float: right;

		    text-align: center;

		}

		.b-detail__head-price-num {

		   padding: 4px 34px;

		    font: 700 23px 'PT Sans',sans-serif;

		    

		}



		.thumb img{

		  border-radius: 0px;

		}





		.item .thumb {

		    width: 23%;

		  cursor: pointer;

		  float: left;

		  border:1px solid;

		 margin: 3px;

		 

		}

		.item .thumb img {

		  width: 100%;

		  height: 80px;

		}

		.item img {

		  width:435px;



		}

		.carousel-inner-1{

			margin-top: 16px;

		}

		.carousel-inner>.item>a>img, .carousel-inner>.item>img, .img-responsive, .thumbnail a>img, .thumbnail>img{height:300px; width:100%;}

		.shiptitleright{

			float: right;

		}
	
		.modal-body {
		    min-height: 670px;
		}

		ul.bar_tabs>li.active { background:#fff !important;}
	</style>

	<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')
    <div class="section">
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

				<div class="checkbox checkbox-success checkbox-circle">

					<input id="checkbox-10" type="checkbox" checked="">

					<label for="checkbox-10 colo_success">  {{session('message')}} </label>

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

									<li>

										<a href="{!! url('/vehicle/list')!!}">

											<span class="visible-xs"></span>

											<i class="fa fa-list fa-lg">&nbsp;</i> 

											{{ trans('app.Vehicle List')}}

										</a>

									</li>

									<li class="active">

										<a>

											<span class="visible-xs"></span>

											<i class="fa fa-user fa-lg">&nbsp;</i> <b>

											{{ trans('app.View Vehicle')}}</b>

										</a>

									</li>

								</ul>

							</div>

						</div>

						<div class="row">

							<div class="col-md-12 col-sm-12">

								<div class="row">

									<div class="wideget-user-desc d-flex col-12">

										<div class="user-wrap">

											<h4 class="fw-600 fs-25">

												<span><i class="fa fa-car mr-3"></i></span>

												@if($vehicle->type == 'vehicle')
													Texnika haqida ma'lumotlar:
												@elseif($vehicle->type == 'agregat')
													Agregat haqida ma'lumotlar:
												@elseif($vehicle->type == 'tirkama')
													Tirkama haqida ma'lumotlar:
												@endif
											</h4>
										</div>
									</div>										
								</div>
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-600">{{ trans('app.Model Name')}}:</span>
											<span class="customer-info-text">{{ empty($v_type) ? '-' : $v_type->vehicle_type }}</span>
										</div>
									</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">{{ trans('app.Vehicle Brand :')}}</span>
												<span class="customer-info-text">
													{{ $v_brand->vehicle_brand }}
												</span>
											</div>
										</div>
										@if($vehicle->type != 'agregat' && $vehicle->type != 'tirkama')
											<div class="col-md-6 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">{{ trans('app.Engine No')}}:</span>
													<span class="customer-info-text">
														{{ $vehicle->engineno }}
													</span>
												</div>
											</div>
										@endif
										@if($vehicle->type != 'agregat' && $vehicle->type != 'tirkama')
											<div class="col-md-6 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Dvigatel quvvati:</span>
													<span class="customer-info-text">
														{{ $vehicle->enginesize }}
													</span>
												</div>
											</div>
										@endif
										@if($vehicle->type != 'agregat')
											<div class="col-md-6 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Kuzov raqami:</span>
													<span class="customer-info-text">
														{{ $vehicle->corpusno }}
													</span>
												</div>
											</div>
										@endif
										@if(!empty($v_fuel->name))
											<div class="col-md-6 col-12">
												<div class="customer-info-item border-bottom pt-3 fs-16">
													<span class="customer-info-desc fw-600">Yoqilg'i turi:</span>
													<span class="customer-info-text">
														{{ $v_fuel->name }}
													</span>
												</div>
											</div>
										@endif
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">Rangi: </span>
												<span class="customer-info-text">
													@if(!empty($v_color))
														{{ $v_color->color }}
													@endif
												</span>
											</div>
										</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">To'la vazni:</span>
												<span class="customer-info-text">
													{{ $vehicle->weight_full }}
												</span>
											</div>
										</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">Yuksiz vazni: </span>
												<span class="customer-info-text">
													{{ $vehicle->weight }}
												</span>
											</div>
										</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">{{ trans('app.Model Year :')}}</span>
												<span class="customer-info-text">
													{{ $vehicle->modelyear }}
												</span>
											</div>
										</div>
									<div class="col-md-6 col-12">	
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-600">{{ trans('app.Condition')}}</span>
											<span class="customer-info-text">
												{{ trans('app.'.$vehicle->condition) }}
											</span>
										</div>
									</div>
										<div class="col-md-6 col-12">	
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">{{ trans('app.Chasic No')}}:</span>
												<span class="customer-info-text">
													{{ $vehicle->chassisno }}
												</span>
											</div>
										</div>

									<div class="col-md-6 col-12">

										<div class="customer-info-item border-bottom pt-3 fs-16">

											<span class="customer-info-desc fw-600">{{ trans('app.Factory Number')}}:</span>

											<span class="customer-info-text">

												@if(!empty($vehicle->factory_number))

										 			{{ $vehicle->factory_number }} 

										 		@else

										 		{{ trans('app.Topilmadi') }}

										 		@endif

											</span>

										</div>

									</div>

									<div class="col-md-6 col-12">

										<div class="customer-info-item border-bottom pt-3 fs-16">

											<span class="customer-info-desc fw-600">{{ trans('app.Working Type')}}:</span>

											<span class="customer-info-text">

												{{ empty($v_working) ? '-' : $v_working->name }}

											</span>

										</div>

									</div>

									<div class="col-md-6 col-12">

										<div class="customer-info-item border-bottom pt-3 fs-16">

											<span class="customer-info-desc fw-600">{{ trans('app.Davlat raqami')}}:</span>

											<span class="customer-info-text">

												@if(!empty($v_number))

													{{ $v_number->code.' '.$v_number->series.' '.$v_number->number }}

												@else

													{{ trans("app.Davlat raqami berilmagan") }}

												@endif

											</span>

										</div>

									</div>

									<div class="col-md-6 col-12">

										<div class="customer-info-item border-bottom pt-3 fs-16">

											@if($vehicle->type != 'vehicle')

												<span class="customer-info-desc fw-600">

													{{ trans('app.QX guvohnomasi')}}:

												</span>

												<span class="customer-info-text">

													@if(!empty($vehicle_c->series))

														{{ $vehicle_c->series.' '.$vehicle_c->number }}

													@else

														{{ trans("app.Topilmadi") }}

													@endif

												</span>

											@else

												<span class="customer-info-desc fw-600">

														{{ trans('app.Texnik passport')}}:

												</span>

												<span class="customer-info-text">

													@if(!empty($vehicle_c->series))

														{{ $vehicle_c->series.' '.$vehicle_c->number }}

													@else

														{{ trans("app.Topilmadi") }}

													@endif

												</span>

											@endif

										</div>

									</div>



								</div>

								<div class="row">

									<div class="wideget-user-desc d-flex col-12">

										<div class="user-wrap">

											<h4 class="fw-600 fs-25">

												<span><i class="fa fa-user mr-3"></i></span> Texnika egasi haqida ma'lumotlar:

											</h4>

										</div>

									</div>										

								</div>

								<div class="row">

									<div class="col-md-6 col-12">

										<div class="customer-info-item border-bottom pt-3 fs-16">

											<span class="customer-info-desc fw-600">Turi(yuridik yoki jismoniy):</span>

											<span class="customer-info-text">

												@if(!empty($owner->type))

													{{ trans('app.'.$owner->type) }}

												@else

													{{ trans("app.Topilmadi") }}

												@endif

											</span>

										</div>

									</div>

									<div class="col-md-6 col-12">

										<div class="customer-info-item border-bottom pt-3 fs-16">

											<span class="customer-info-desc fw-600">{{ trans('app.Texnika egasi')}}:</span>

											<span class="customer-info-text">

												@if(!empty($owner->name))

													<a class="text-capitalize" target="_blank" href="/customer/list/{{ $owner->id }}">

														@if(!empty($owner->lastname))

															{{ $owner->lastname.' '.$owner->name }}

															@if(!empty($owner->middlename))

																{{ $owner->middlename }}

															@endif

														@else

															{{ $owner->name }}

														@endif

													</a>

												@else

													{{ trans("app.Topilmadi") }}

												@endif

											</span>

										</div>

									</div>

									<div class="col-md-6 col-12">

										<div class="customer-info-item border-bottom pt-3 fs-16">

											<span class="customer-info-desc fw-600">{{ trans('app.Viloyat') }}:</span>

											<span class="customer-info-text">

												@if(!empty($v_region->name))

													{{ $v_region->name }}

												@else

													{{ trans("app.Topilmadi") }}

												@endif

											</span>

										</div>

									</div>

									<div class="col-md-6 col-12">

										<div class="customer-info-item border-bottom pt-3 fs-16">

											<span class="customer-info-desc fw-600">{{ trans('app.Town/City')}}:</span>

											<span class="customer-info-text">

												@if(!empty($v_city))

													{{ $v_city->name }}

												@else

													{{ trans("app.Town/city belgilanmagan") }}

												@endif

											</span>

										</div>

									</div>

									@if(!empty($owner->type))

										@if($owner->type != 'legal')

											<div class="col-md-6 col-12">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">{{ trans('app.Passport No')}}:</span>

													<span class="customer-info-text">

														@if(!empty($owner->passport_series))

															{{ $owner->passport_series.'-'.$owner->passport_number }}

														@else

															{{ trans("app.Kiritilmagan") }}

														@endif

													</span>

												</div>

											</div>

										@endif

									@endif

									<div class="col-md-6 col-12">

										<div class="customer-info-item border-bottom pt-3 fs-16">

											<span class="customer-info-desc fw-600">{{ trans('app.STIR')}}:</span>

											<span class="customer-info-text">

												@if(!empty($owner->inn))

													{{ $owner->inn }}

												@else

													{{ trans('app.Topilmadi') }}

												@endif

											</span>

										</div>

									</div>

								</div>

								@if(!empty($owner))
									<div class="row">

										<div class="wideget-user-desc d-flex col-12">

											<div class="user-wrap">

												<h4 class="fw-600 fs-25">

													<span><i class="fa fa-list mr-3"></i></span> Taqiqqa olinganlik holati:

												</h4>

											</div>

										</div>										

									</div>
									<div class="row">

										<div class="col-md-6 col-12">

											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-600">{{ trans("app.Condition") }}:</span>
												<span class="customer-info-text">
													{{$vehicle->lock_status=='lock' ? 'Taqiqqa olingan' : 'Taqiqqa olinmagan'}}
												</span>
											</div>

										</div>

										<div class="col-md-6 col-12">

											<button class="btn btn-success print-button"  data-toggle="modal"  data-target="#tm-modal" type="button" style="cursor: pointer;">Ma'lumotnoma berish</button>

										</div>
									</div>
									@if(!empty($vehicle_tm))
										<div class="row">
											<div class="wideget-user-desc d-flex col-12">
												<div class="user-wrap">
													<h4 class="fw-600 fs-25">
														<span><i class="fa fa-list mr-3"></i></span> TM-1 Ma'lumotnomalar:
													</h4>
												</div>
											</div>										
										</div>
										<div class="row">
											<div class="col-md-6 col-12">
												@foreach ($vehicle_tm as $item)
													<div class="customer-info-item border-bottom pt-3 fs-16">
														<span class="customer-info-desc fw-600">{{date('d.m.Y', strtoTime($item->date))}}</span>
														<span class="customer-info-text">
														<a data-toggle="modal" data-target="#tm-modal" class="tms" href="/vehicle/tm-1?&id={{$item->id}}">TM-1 ma'lumotnoma</a>
														</span>
													</div>
												@endforeach
											</div>
										</div>
									@endif
								@endif

							</div>	

						</div>

					</div>

				</div>

			</div>

			<div class="col-md-12">

				<div class="page-header">

					<ol class="breadcrumb">

						<li class="breadcrumb-item">

							<i class="fe fe-calendar mr-1"></i>&nbsp {{ trans('app.Timeline')}}

						</li>

					</ol>

				</div>

			</div>	
			<div class="col-md-8">
					<div id="tm-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

					<div class="modal-dialog">

						<div class="modal-content">

							<div class="modal-header">

								<h5 class="modal-title" id="example-Modal3">TM-1 ma'lumotnoma</h5>

								<button type="button" class="close" data-dismiss="modal" aria-label="Close">

									<span aria-hidden="true">&times;</span>

								</button>

							</div>

							<div class="modal-body">

							</div>

						</div>

					</div>	

				</div>

			<div class="col-md-12">

				<ul class="cbp_tmtimeline">

					<?php 

					$endwhile=false; ?>

					@while( (!empty($v_registration) || !empty($v_inspection) || !empty($v_prohibition) || !empty($v_certificate) || !empty($v_numbers)) && !$endwhile)

						<?php 

								$actionType = '';

								$actionTime = 0;

								$vR = null;

								$vI = null;

								$vP = null;

								$vC = null;

								$vN = null;

								if(count($v_registration) && !empty($v_registration[0])){

									$actionTime=strtotime($v_registration[0]->date);

									$actionType='v_reg';

								}

								if(count($v_inspection) && !empty($v_inspection) && strtotime(date('Y-m-d',strtotime($v_inspection[0]->date)))>=$actionTime){

									$actionTime=strtotime($v_inspection[0]->date);

									$actionType='v_med';

								}

								if(count($v_prohibition) && !empty($v_prohibition) && strtotime(date('Y-m-d',strtotime($v_prohibition[0]->date)))>=$actionTime){

									$actionTime=strtotime($v_prohibition[0]->date);

									$actionType='v_lock';

								}

								if(count($v_certificate) && !empty($v_certificate) && strtotime(date('Y-m-d',strtotime($v_certificate[0]->given_date)))>=$actionTime){

									$actionTime=strtotime($v_certificate[0]->given_date);

									$actionType='v_cer';

								}

								if(count($v_numbers) && !empty($v_numbers) && strtotime(date('Y-m-d',strtotime($v_numbers[0]->given_date)))>=$actionTime){

									$actionTime=strtotime($v_numbers[0]->given_date);

									$actionType='v_num';

								}

								switch($actionType){

									case 'v_reg':

										$vR=array_shift($v_registration);

										break;	
									case 'v_cer':

										$vC=array_shift($v_certificate);

										break;
									case 'v_num':

										$vN=array_shift($v_numbers);

										break;

									

									case 'v_med':

										$vI=array_shift($v_inspection);

										break;

									case 'v_lock':

										$vP=array_shift($v_prohibition);

										break;

									default:

										$endwhile=true;

										break;

								}?>





								@if (!empty($vR))





									<li>

										<time class="cbp_tmtime" datetime="2017-10-22T12:13">

											<span>{{date('d.m.Y',strtotime($vR->date))}}</span> 

										</time>

										<div class="cbp_tmicon">

											<img style="margin-top: -3px;" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/registration-480.png') }}">

										</div>

										<div class="cbp_tmlabel">

											<div class="row">

												<div class="col-12"> 

													<h2 class="text-dark timeline-title border-bottom mb-0"><span>{{ trans('app.'.$vR->action) }}</span> </h2>

													<div class="table-responsive">

														<table class="table card-table table-vcenter text-nowrap">

															<thead>

																<tr>

																	<th>

																		Viloyat

																	</th>

																	<th>

																		{{ trans('app.Town/City')}}

																	</th>

																	<th>

																		{{ trans('app.Texnika egasi') }}

																	</th>

																</tr>

															</thead>

															<tbody>

																<tr>

																	<td>

																		@if(!empty($vR->regionname))

																			{{ $vR->regionname }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>

																	<td>
																		{{$vR->id}}

																		@if(!empty($vR->districtname))

																			{{ $vR->districtname }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>

																	<td>

																		<span class="text-capitalize">

																			@if(!empty($vR->ownertype))

																					@if($vR->ownertype=='legal')

																						{{ $vR->ownername }}

																					@elseif ($vR->ownertype == 'physical')

																						{{ $vR->ownerlastname.' '.$vR->ownername.' ' }}

																						@if(!empty($vR->middlename))

																							{{ $vR->middlename }}

																						@endif

																					@else ?>

																						{{ trans('app.Topilmadi') }}

																				    @endif

																			@else

																				{{ trans('app.Topilmadi') }}

																			@endif

																		</span>

																	</td>

																</tr>

															</tbody>

														</table>

													</div>

												</div>

											</div>

										</div>

									</li>





								@elseif(!empty($vP))





									<li>

										<time class="cbp_tmtime" datetime="2017-10-22T12:13">

											<span>{{date('d.m.Y',strtotime($vP->date))}}</span> 

										</time>

										<div class="cbp_tmicon" style="background-color: #2DB67C;">

											<img class="ml-1" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/tractor4.png') }}">

										</div>

										<div class="cbp_tmlabel">

											<div class="row">

												<div class="col-12"> 

													<h2 class="text-dark timeline-title border-bottom mb-0"><span>{{ trans('app.'.$vP->action) }}</span> </h2>

													<div class="table-responsive">

														<table class="table card-table table-vcenter text-nowrap">

															<thead>

																<tr>

																	<th>

																		{{ trans('app.Texnika egasi') }}

																	</th>

																	<th>

																		{{ trans('app.Kim tomondan bajarildi') }}

																	</th>

																	<th>

																		{{ trans('app.Buyruq raqami') }} 

																	</th>

																</tr>

															</thead>

															<tbody>

																<tr>

																	<td>

																		<span class="text-capitalize">

																			@if(!empty($vP->ownertype))

																					@if($vP->ownertype=='legal')

																						{{$vP->ownername }}

																					@elseif ($vP->ownertype == 'physical')

																						{{ $vP->ownerlastname.' '.$vP->ownername.' ' }}

																						@if(!empty($vP->middlename))

																							{{ $vP->middlename }}

																						@endif

																					@else ?>

																						{{ trans('app.Topilmadi') }}

																				    @endif

																			@else

																				{{ trans('app.Topilmadi') }}

																			@endif

																		</span>

																	</td>

																	<td>

																		@if(!empty($vP->lockername))

																			{{ $vP->lockername }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>

																	<td>

																		@if(!empty($vP->orderno))

																			{{ $vP->orderno }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>																

																</tr>

															</tbody>

														</table>

													</div>

												</div>

											</div>

										</div>

									</li>





								@elseif(!empty($vI))





									<li>

										<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>{{date('d.m.Y',strtotime($vI->date))}}</span> </time>

										<div class="cbp_tmicon">

											<img src="{{ URL::asset('resources/views/layouts/assets/images/pngs/wrench.png') }}">

										</div>

										<div class="cbp_tmlabel">

											<div class="row">

												<div class="col-12"> 

													<h2 class="text-dark timeline-title border-bottom mb-0"><span>Texnik ko'rikdan o'tish</span> </h2>

													<div class="table-responsive">

														<table class="table card-table table-vcenter text-nowrap">

															<thead>

																<tr>

																	<th>

																		{{ trans('app.Texnika egasi') }}

																	</th>

																	<th>

																		{{ trans('app.Select Condition') }}

																	</th>

																	<th>

																		{{ trans("app.To'lov miqdori") }}

																	</th>

																</tr>

															</thead>

															<tbody>

																<tr>

																	<td>

																		<span class="text-capitalize">

																			@if(!empty($vI->ownertype))

																					@if($vI->ownertype=='legal')

																						{{$vI->ownername }}

																					@elseif ($vI->ownertype == 'physical')

																						{{ $vI->ownerlastname.' '.$vI->ownername.' ' }}

																						@if(!empty($vI->middlename))

																							{{ $vI->middlename }}

																						@endif

																					@else ?>

																						{{ trans('app.Topilmadi') }}

																				    @endif

																			@else

																				{{ trans('app.Topilmadi') }}

																			@endif

																		</span>

																	</td>

																	<td>

																		@if(!empty($vI->status))

																			{{ trans('app.'.$vI->status) }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>

																	<td>

																		@if(!empty($vI->total_amount))

																			{{ $vI->total_amount }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>

																</tr>

															</tbody>

														</table>

													</div>

												</div>

											</div>

										</div>

									</li>





								@elseif(!empty($vC))



									<li>

										<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>{{date('d.m.Y',strtotime($vC->given_date))}}</span> </time>

										<div class="cbp_tmicon">

											<img class="m-1" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/tractor4.png') }}">

										</div>

										<div class="cbp_tmlabel">

											<div class="row">

												<div class="col-12"> 

													<h2 class="text-dark timeline-title border-bottom mb-0">

														<span>

															@if($vehicle->type == 'vehicle')

																{{ trans('app.Texnik passport') }} 

																{{ trans('app.'.$vC->action) }}

															@else

																{{ trans('app.QX guvohnoma') }}

																{{ trans('app.'.$vC->action)}}

															@endif

														</span> 

													</h2>

													<div class="table-responsive">

														<table class="table card-table table-vcenter text-nowrap">

															<thead>

																<tr>

																	<th>

																		{{ trans('app.Texnika egasi') }}

																	</th>

																	<th>

																		@if($vehicle->type == 'vehicle')

																			 {{ trans('app.Texnik passport') }} seriya-raqam

																		@else

																		 	{{ trans('app.QX guvohnoma') }} seriya-raqam

																		 @endif

																	</th>

																	<th>

																		{{ trans("app.To'lov miqdori") }}

																	</th>

																</tr>

															</thead>

															<tbody>

																<tr>

																	<td>

																		<span class="text-capitalize">
																			{{$vC->id}}

																			@if(!empty($vC->ownertype))

																					@if($vC->ownertype=='legal')

																						{{$vC->ownername }}

																					@elseif ($vC->ownertype == 'physical')

																						{{ $vC->ownerlastname.' '.$vC->ownername.' ' }}

																						@if(!empty($vC->middlename))

																							{{ $vC->middlename }}

																						@endif

																					@else ?>

																						{{ trans('app.Topilmadi') }}

																				    @endif

																			@else

																				{{ trans('app.Topilmadi') }}

																			@endif

																		</span>

																	</td>

																	<td>

																		@if(!empty($vC->series))

																			{{ $vC->series.'-'.$vC->number }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>

																	<td>

																		{{ $vC->total_amount }}

																	</td>

																</tr>

															</tbody>

														</table>

													</div>

												</div>

											</div>

										</div>

									</li>



								@elseif(!empty($vN))



									<li>

										<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>{{date('d.m.Y',strtotime($vN->given_date))}}</span> </time>

										<div class="cbp_tmicon" style="background-color: #EB3080;">

											<img src="{{ URL::asset('resources/views/layouts/assets/images/pngs/car-number-2.png') }}">

										</div>

										<div class="cbp_tmlabel">

											<div class="row">

												<div class="col-12"> 

													<h2 class="text-dark timeline-title border-bottom mb-0"><span>{{ trans('app.Davlat raqami') }} {{ trans('app.'.$vN->action) }}</span> </h2>

													<div class="table-responsive">

														<table class="table card-table table-vcenter text-nowrap">

															<thead>

																<tr>

																	<th>

																		{{ trans('app.Texnika egasi') }}

																	</th>

																	<th>

																		{{ trans('app.Davlat raqami') }}

																	</th>

																	<th>

																		{{ trans('app.Select Condition') }}

																	</th>

																	<th>

																		{{ trans("app.To'lov miqdori") }}

																	</th>

																</tr>

															</thead>

															<tbody>

																<tr>

																	<td>

																		<span class="text-capitalize">

																			@if(!empty($vN->ownertype))

																					@if($vN->ownertype=='legal')

																						{{$vN->ownername }}

																					@elseif ($vN->ownertype == 'physical')

																						{{ $vN->ownerlastname.' '.$vN->ownername.' ' }}

																						@if(!empty($vN->middlename))

																							{{ $vN->middlename }}

																						@endif

																					@else ?>

																						{{ trans('app.Topilmadi') }}

																				    @endif

																			@else

																				{{ trans('app.Topilmadi') }}

																			@endif

																		</span>

																		

																	</td>

																	<td>

																		@if(!empty($vN->series))

																			{{ $vN->code.' '.$vN->series.' '.$vN->number }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>

																	<td>

																		@if(!empty($vN->status))

																			{{ trans('app.'.$vN->status) }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>

																	<td>

																		@if(!empty($vN->total_amount))

																			{{ $vN->total_amount }}

																		@else

																			{{ trans('app.Topilmadi') }}

																		@endif

																	</td>

																</tr>

															</tbody>

														</table>

													</div>

												</div>

											</div>

										</div>

									</li>

								@endif

					@endwhile

				</ul>

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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/blob.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/js/webcam.min.js') }}"></script> 
	<script type="text/javascript">
		$(document).ready(function(){
			$('.print-button[data-target="#tm-modal"]').on('click',function(){
				var url="/vehicle/tm-1?vehicle_id={{$vehicle->id}}&owner_id=<?=empty($owner)?'':$owner->id ?>";
				$('#tm-modal .modal-body').html('<iframe src="'+url+'"></iframe>');
				$('.send-to-print').on('click',function(){
					$(this).parent().find('iframe').attr('src',url+'&print=true');
				})
			});
			$('a.tms[data-target="#tm-modal"]').on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$('#tm-modal .modal-body').html('<iframe src="'+url+'"></iframe>');
				$('.send-to-print').on('click',function(){
					$(this).parent().find('iframe').attr('src',url+'&print=true');
				})
			});
		})
	</script>

@endsection
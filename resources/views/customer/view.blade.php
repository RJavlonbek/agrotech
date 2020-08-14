@extends('layouts.app')

@section('content')

<style>

.right_side .table_row, .member_right .table_row {

    border-bottom: 1px solid #dedede;

    float: left;

    width: 100%;

	padding: 1px 0px 4px 2px;

}

.table_row .table_td {

  padding: 8px 8px !important;

}

.report_title {

    float: left;

    font-size: 20px;

    width: 100%;

}

</style>

		<!-- page content -->

<?php $userid = Auth::user()->id; ?>

@if (getAccessStatusUser('Customers',$userid)=='yes')

    <div class="section">
    	<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="/"><i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Vehicle')}}
					</a>
				</li>

			</ol>

		</div>		

		@if(session('message'))

		<div class="row massage">

			<div class="col-md-12 col-sm-12 col-xs-12">

				<div class="alert alert-success text-center">

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

										<a href="{!! url('/customer/list')!!}">

											<span class="visible-xs"></span>

											<i class="fa fa-list fa-lg">&nbsp;</i> 

											{{ trans('app.Customer List')}}

										</a>

									</li>

									<li class="active">

										<a>

											<span class="visible-xs"></span>

											<i class="fa fa-user fa-lg">&nbsp;</i> <b>

											{{ trans('app.View Customer')}}</b>

										</a>

									</li>

								</ul>

							</div>

						</div>

						<div class="row">

							<div class="col-md-12 col-sm-12">

								<div class="row">

									<div class="wideget-user-desc d-flex">

										<div class="user-wrap">

											<h4>

												<span class="text-capitalize">{{ $customer->lastname }} {{$customer->name}} {{$customer->middlename}}</span> ({{$customer->ownership_form}})

											</h4>

											@if(!empty($customer->categories))

												@foreach(explode(',',$customer->categories) as $cat)

													<div style="letter-spacing: .03em;
															    font-size: 0.8125rem;
															    color: #fff;
															    min-width: 2.375rem;
															    border: 1px solid transparent;
															    padding: 0.375rem 0.75rem;
															    background-color:#0052cc;">

														{{ $cat}}

													</div>

												@endforeach

											@endif

										</div>

									</div>										

								</div>

								<div class="row">
									<div class="col-10">
										<div class="row">
											<div class="col-6">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">STIR:</span>

													<span class="customer-info-text">{{$customer->inn?$customer->inn:'Kiritilmagan'}}</span>

												</div>

											</div>

											@if($customer->type=='physical')

												<div class="col-6">

													<div class="customer-info-item border-bottom pt-3 fs-16">

														<span class="customer-info-desc fw-600">Tug'ilgan sana:</span>

														<span class="customer-info-text">

															{{$customer->d_o_birth?date('d.m.Y',strtotime($customer->d_o_birth)):'Kiritilmagan'}}

														</span>

													</div>

												</div>

												<div class="col-6">

													<div class="customer-info-item border-bottom pt-3 fs-16">

														<span class="customer-info-desc fw-600">ShIR:</span>

														<span class="customer-info-text">

															{{$customer->id_number?$customer->id_number:'Kiritilmagan'}}

														</span>

													</div>

												</div>

												<div class="col-6">

													<div class="customer-info-item border-bottom pt-3 fs-16">

														<span class="customer-info-desc fw-600">Pasport:</span>

														<span class="customer-info-text">

															@if($customer->passport_series && $customer->passport_number)

																{{$customer->passport_series.$customer->passport_number}}

															@else

																Kiritilmagan

															@endif

														</span>

													</div>

												</div>

											@endif

											<div class="col-6">	

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">Telefon:</span>

													<span class="customer-info-text">

														@if($customer->mobile)

															{{$customer->mobile}}

														@else

															Kiritilmagan

														@endif

													</span>

												</div>

											</div>

											@if($customer->type=='physical')

												<div class="col-6">	

													<div class="customer-info-item border-bottom pt-3 fs-16">

														<span class="customer-info-desc fw-600">Pasport berilgan:</span>

														<span class="customer-info-text">

															@if(!empty($passport_given_city) && !empty($customer->p_given_date))

																{{$customer->residence ? $passport_given_city->name : $passport_given_city.' IIB ('.date('d.m.Y',strtotime($customer->p_given_date)).')'}}

															@else

																Kiritilmagan

															@endif

														</span>

													</div>

												</div>

											@endif

											<div class="col-6">

												<div class="customer-info-item border-bottom pt-3 fs-16">

													<span class="customer-info-desc fw-600">Manzil:</span>

													<span class="customer-info-text">

														@if($customer->city && $customer->state)

															{{$customer->state.', '.$customer->city.', '.$customer->address}}

														@else

															Kiritilmagan

														@endif

													</span>

												</div>

											</div>
										</div>
									</div>
									<div class="col-2 text-center">
										@if($customer->type=='physical')
											@if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/uploads/driver-'.$customer->id.'.jpeg'))
												<img id="owner-image" src="{{ URL::asset('public/uploads/driver-'.$customer->id.'.jpeg') }}" style="height: 150px;">
											@else
												<img id="owner-image" src="{{ URL::asset('public/uploads/driver-64.jpeg') }}" style="height: 150px;">
											@endif
										@endif
									</div>
								</div>
								@if(!empty($active_driver_licence))
									<div class="row mt-4">

										<div class="col-12">

											<h4>Tegishli hujjatlar</h4>

											<div class="table-responsive">
												<table id="transports-table" class="table table-striped table-bordered nowrap">

													<thead>

														<tr>
															<th>Hujjat</th>
															<th>Berilgan sana</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$types=json_decode($active_driver_licence->licence_type,true);
														$givenTypes=[];
														foreach($types as $t){
															$givenTypes[]=$t['name'];
														}
														$givenTypes=implode(',',$givenTypes);
														?>
														<tr>
															<td>
																<a href="/driver-licence/preview?id={{ $active_driver_licence->id }}&details=true">
																	Traktorchi-mashinist guvohnomasi ({{$givenTypes}})
																</a>
															</td>
															<td>{{date('d.m.Y',strtotime($active_driver_licence->given_date))}}</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>

									</div>
								@endif

								<div class="row mt-4">

									<div class="col-12">

										<h4>Tegishli texnikalar texnika turi bo'yicha</h4>

										<div class="table-responsive">

											@if(!empty($transports_by_type))

												<table id="transports-table" class="table table-striped table-bordered nowrap">

													<thead>

														<tr>
															<th>Texnika</th>
															<th>Soni</th>
														</tr>
													</thead>
													<tbody>
														<?php $count=0; ?>
														@foreach($transports_by_type as $type)
															<?php $count+=$type->c; ?>
															<tr>
																<td>{{$type->vehicle_type}}</td>
																<td>{{$type->c}}</td>
															</tr>
														@endforeach
														<tr>
															<td><b>Jami</b></td>
															<td><b>{{$count}}</b></td>
														</tr>
													</tbody>
												</table>

											@else
												Tegishli texnikalar mavjud emas
											@endif

										</div>

									</div>

								</div>

								<div class="row mt-4">

									<div class="col-12">

										<div class="table-responsive">

											@if(!empty($transports))

												<table id="transports-table" class="table table-striped table-bordered nowrap">

													<thead>

														<tr>

															<th class="border-bottom-0">Texnika</th>

															<th class="border-bottom-0">Ishlab chiqarilgan</th>

															<th class="border-bottom-0">Davlat raqami</th>

															<th class="border-bottom-0">Hujjat</th>

															<th class="border-bottom-0">Texnik ko'rik muddati</th>

														</tr>

													</thead>

													<tbody>

														@foreach($transports as $transport)

															<tr>

																<td>

																	<a href="/vehicle/list/view/{{$transport->id}}/{{$customer->city_id}}">

																		<span>{{$transport->type}}</span>

																		<span>({{$transport->model}})</span>

																	</a>

																</td>

																<td>{{$transport->modelyear}}</td>

																<td>

																	@if($transport->code && $transport->series && $transport->number)

																		{{$transport->code.' '.$transport->series.$transport->number}}

																	@elseif($transport->main_type=='agregat')
																		-
																	@else
																		<span class="text-danger">

																			Berilmagan

																		</span>
																		<a href="/vehicle/transport-number?vehicle_id={{$transport->id}}&city_id={{$customer->city_id}}" class="btn btn-info float-right">Berish</a>

																	@endif

																</td>

																<td>
																	@if(isset($transport->passport_number) && isset($transport->passport_series) && $transport->passport_number)
																		{{$transport->passport_series.$transport->passport_number}}
																	@elseif(isset($transport->certificate_number) && isset($transport->certificate_series) && $transport->certificate_number)
																		{{$transport->certificate_series.$transport->certificate_number}}
																	@else
																		<span class="text-danger">
																			Berilmagan
																		</span>
																		<?php if($transport->main_type=='vehicle' || $transport->main_type=='tirkama'){
																			$url="/vehicle/technical-passport";
																		}else{
																			$url="/certificate/add";
																		} ?>
																		<a href="{{$url}}?vehicle_id={{$transport->id}}&city_id={{$customer->city_id}}" class="btn btn-info float-right">Hujjat berish</a>
																	@endif

																</td>

																<td>
																	@if(!empty($transport->inspection_date))
																		<?php $inspectionDate=strtotime('+1 year',strtotime($transport->inspection_date)); ?>
																		@if($inspectionDate < strtotime('now'))
																			<span class="text-danger">{{date('d.m.Y',$inspectionDate)}}</span>
																			<a href="/certificate/medadd?vehicle_id={{$transport->id}}&city_id={{$customer->city_id}}" class="btn float-right btn-info">Ko'rikdan o'tkazish</a>
																		@else
																			<span class="text-success">{{date('d.m.Y',$inspectionDate)}}</span>
																		@endif
																	@else
																		<span class="text-danger">O'tmagan</span>
																		<a href="/certificate/medadd?vehicle_id={{$transport->id}}&city_id={{$customer->city_id}}" class="btn float-right btn-info">Ko'rikdan o'tkazish</a>
																	@endif
																</td>
															</tr>

														@endforeach

													</tbody>

												</table>

											@endif

										</div>

									</div>

								</div>

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

			<div class="col-md-12">

				<ul class="cbp_tmtimeline">

					<?php 
					$endwhile=false;
					while( (!empty($transport_numbers) || !empty($technical_passports) || !empty($driver_licences) || !empty($registrations) || !empty($certificates)) && !$endwhile ){

						$actionTime=0;

						$actionType='';

						$tN=null;
						$dL=null;
						$tP=null;
						$ce=null;
						$re=null;

						if(count($transport_numbers) && !empty($transport_numbers[0])){
							$actionTime=strtotime($transport_numbers[0]->given_date);
							$actionType='transport_numbers';
						}

						if(count($technical_passports) && !empty($technical_passports[0]) && strtotime(date('Y-m-d',strtotime($technical_passports[0]->given_date)))>=$actionTime){
							$actionTime=strtotime($technical_passports[0]->given_date);
							$actionType='technical_passports';
						}

						if(count($certificates) && !empty($certificates[0]) && strtotime(date('Y-m-d',strtotime($certificates[0]->given_date)))>=$actionTime){
							$actionTime=strtotime($certificates[0]->given_date);
							$actionType='certificates';
						}

						if(count($driver_licences) && !empty($driver_licences[0]) && strtotime(date('Y-m-d',strtotime($driver_licences[0]->given_date)))>=$actionTime){
							$actionTime=strtotime($driver_licences[0]->given_date);
							$actionType='driver_licences';
						}

						if(count($registrations) && !empty($registrations[0]) && strtotime(date('Y-m-d',strtotime($registrations[0]->date)))>$actionTime){
							$actionTime=strtotime($registrations[0]->date);
							$actionType='registrations';
						}



						switch($actionType){
							case 'transport_numbers':
								$tN=array_shift($transport_numbers);
								break;
							case 'technical_passports':
								$tP=array_shift($technical_passports);
								break;
							case 'driver_licences':
								$dL=array_shift($driver_licences);
								break;
							case 'registrations':
								$re=array_shift($registrations);
								break;
							case 'certificates':
								$ce=array_shift($certificates);
								break;
							default:
								$endwhile=true;
								break;
						}



						if(!empty($tN)){ ?>

							<li>

								<time class="cbp_tmtime" datetime="2017-10-22T12:13">

									<span>

										{{date('d.m.Y',strtotime($tN->given_date))}}

									</span> 

								</time>

								<div class="cbp_tmicon">

									<img class="m-1" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/car-number-2.png') }}">

								</div>

								<div class="cbp_tmlabel">

									<div class="row">

										<div class="col-12"> 

											<h2 class="text-dark timeline-title border-bottom mb-0">

												@if($tN->action=='give')

													<span>Texnikaga davlat raqami berildi</span>

												@elseif($tN->action=='recover')

													<span>Texnika davlat raqami qayta tiklandi</span>

												@else

													<span>Unknown action</span>

												@endif

											</h2>

											<div class="table-responsive">

												<table class="table card-table table-vcenter text-nowrap">

													<thead>

														<tr>

															<th>

																Texnika

															</th>

															<th>

																Davlat raqami

															</th>
															<th title="Berilgan davlat raqamining hozirgi holati">
																Holati
															</th>

														</tr>

													</thead>

													<tbody>

														<tr>

															<td>

																<a href="/vehicle/list/view/{{$tN->vehicle_id}}/{{$customer->city_id}}">{{$tN->vehicle_type.' ('.$tN->model.')'}}</a>

															</td>

															<td>

																{{$tN->code.' '.$tN->series.$tN->number}}

															</td>
															<td>
																@if($tN->status=='active')
																	<span class="text-success">Faol</span>
																@elseif($tN->status=='inactive')
																	<span class="text-danger">Faolmas</span>
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
						<?php }elseif(!empty($tP)){ ?>

							<li>

								<time class="cbp_tmtime" datetime="2017-10-22T12:13">

									<span>{{date('d.m.Y',strtotime($tP->given_date))}}</span> 

								</time>

								<div class="cbp_tmicon" style="background-color: #2DB67C;">

									<img class="ml-1" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/tractor4.png') }}">

								</div>

								<div class="cbp_tmlabel">

									<div class="row">

										<div class="col-12"> 

											<h2 class="text-dark timeline-title border-bottom mb-0">

												@if($tP->action=='give')

													<span>Texnikaga texnik pasport berildi</span>

												@elseif($tP->action=='recover')

													<span>Texnika pasporti qayta tiklandi</span>

												@else

													<span>Noma'lum harakat</span>

												@endif

											</h2>

											<div class="table-responsive">

												<table class="table card-table table-vcenter text-nowrap">

													<thead>

														<tr>

															<th>

																Texnika

															</th>

															<th>

																Davlat raqami

															</th>

															<th>
																Texnik pasport raqami
															</th>
															<th>Holati</th>
														</tr>

													</thead>

													<tbody>

														<tr>

															<td>

																<a href="/vehicle/list/view/{{$tP->vehicle_id}}/{{$customer->city_id}}">{{$tP->vehicle_type.' ('.$tP->model.')'}}</a>

															</td>

															<td>

																{{$tP->number_code.' '.$tP->number_series.$tP->number_number}}

															</td>

															<td>

																{{$tP->series.$tP->number}}

															</td>
															<td>
																@if($tP->status=='active')
																	<span class="text-success">Faol</span>
																@else
																	<span class="text-danger">Faolmas</span>
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
						<?php }elseif(!empty($ce)){ ?>
							<li>

								<time class="cbp_tmtime" datetime="2017-10-22T12:13">

									<span>{{date('d.m.Y',strtotime($ce->given_date))}}</span> 

								</time>

								<div class="cbp_tmicon" style="background-color: #2DB67C;">

									<img class="ml-1" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/tractor4.png') }}">

								</div>

								<div class="cbp_tmlabel">

									<div class="row">

										<div class="col-12"> 

											<h2 class="text-dark timeline-title border-bottom mb-0">

												@if($ce->action=='give')

													<span>Texnikaga texnik guvohnoma berildi</span>

												@elseif($ce->action=='recover')

													<span>Texnika guvohnomasi qayta tiklandi</span>

												@else

													<span>Unknown action</span>

												@endif

											</h2>

											<div class="table-responsive">

												<table class="table card-table table-vcenter text-nowrap">

													<thead>

														<tr>

															<th>

																Texnika

															</th>

															<th>
																Guvohnoma raqami
															</th>
															<th>Holati</th>
														</tr>

													</thead>

													<tbody>

														<tr>

															<td>

																<a href="/vehicle/list/view/{{$ce->vehicle_id}}/{{$customer->city_id}}">{{$ce->vehicle_type.' ('.$ce->model.')'}}</a>

															</td>

															<td>

																{{$ce->series.$ce->number}}

															</td>
															<td>
																@if($ce->status=='active')
																	<span class="text-success">Faol</span>
																@else
																	<span class="text-danger">Faolmas</span>
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
						<?php }elseif(!empty($dL)){ ?>
							<li>

								<time class="cbp_tmtime" datetime="2017-10-22T12:13">
									<span>{{date('d.m.Y',strtotime($dL->given_date))}}</span> 
								</time>

								<div class="cbp_tmicon" style="background-color: #EB3080;">

									<img src="{{ URL::asset('resources/views/layouts/assets/images/pngs/dr-lisence.png') }}">

								</div>

								<div class="cbp_tmlabel">

									<div class="row">

										<div class="col-12"> 

											<h2 class="text-dark timeline-title border-bottom mb-0">
												@if($dL->action=='give')

													<span>Haydovchilik guvohnomasi berildi</span>

												@elseif($dL->action=='recover')

													<span>Haydovchilik guvohnomasi qayta tiklandi</span>

												@elseif($dL->action=='update')

													<span>Haydovchilik guvohnomasi yangilandi</span>
												@else
													<span>Unknown action - {{$dL->action}}</span>

												@endif
											</h2>
											<div class="table-responsive">

												<table class="table card-table table-vcenter text-nowrap">

													<thead>

														<tr>
															<th>Shaxs pasport raqami</th>
															<th>Guvohnoma seriya raqami</th>
															<th>Guvohnoma toifasi</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<span class="customer-info-text">
																	@if($customer->passport_series && $customer->passport_number)

																		{{$customer->passport_series.$customer->passport_number}}

																	@else

																		Kiritilmagan

																	@endif
																</span>
															</td>
															<td>
																<span>{{$dL->series.$dL->number}}</span>
															</td>
															<td>
																<?php 
																$types=json_decode($dL->licence_type,true);
																$givenTypes=[];
																foreach($types as $t){
																	$givenTypes[]=$t['name'];
																}
																$givenTypes=implode(',',$givenTypes);
																?>

																<span>{{$givenTypes}}</span>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>

									</div>

								</div>

							</li>
						<?php }elseif(!empty($re)){ ?>
							<li>
								<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>{{date('d.m.Y',strtotime($re->date))}}</span> </time>
								<div class="cbp_tmicon">
									<img style="margin-top: -3px;" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/registration-480.png') }}">
								</div>
								<div class="cbp_tmlabel">

									<div class="row">

										<div class="col-12"> 

											<h2 class="text-dark timeline-title border-bottom mb-0">
												@if($re->action=='regged')
													<span>Texnika ro'yxatga qo'yildi</span>
												@elseif($re->action='unregged')
													<span>Texnika ro'yxatdan chiqarildi</span>
												@endif
											</h2>

											<div class="table-responsive">
												<table class="table card-table table-vcenter text-nowrap">
													<thead>
														<tr>
															<th>Texnika</th>
															<th>Davlat raqami</th>
															<th>Manzil</th>
															@if($re->action=='regged')
																<th>Ro'yxatdan chiqarilgan</th>
															@elseif($re->action='unregged')
																<th>Ro'yxatga olingan</th>
															@endif
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<a href="/vehicle/list/view/{{$re->vehicle_id}}/{{$customer->city_id}}">{{$re->vehicle_type.' ('.$re->model.')'}}</a>
															</td>
															<td>
																@if($re->main_type!=='agregat')
																	@if(!empty($re->number_code))
																		{{$re->number_code.' '.$re->number_number.$re->number_series}}
																	@else
																		<span class="text-danger">Berilmagan</span>
																	@endif
																@else
																	<span>—</span>
																@endif
															</td>
															<td>
																<span>{{$re->state.', '.$re->city}}</span>
															</td>
															@if($re->action=='regged')
																@if(!empty($re->last_owner_id))
																	<td>
																		{{date('d.m.Y',strtotime($re->last_reg_date))}}, 
																		<a href="/customer/list/{{$re->last_owner_id}}" class="text-capitalize">{{$re->last_owner_lastname.' '.$re->last_owner_name.' '.$re->last_owner_middlename}}</a>
																	</td>
																@else
																	<td>Yangi texnika</td>
																@endif
															@elseif($re->action='unregged')
																@if(!empty($re->next_owner_id))
																	<td>
																		{{date('d.m.Y',strtotime($re->next_reg_date))}}, 
																		<a href="/customer/list/{{$re->next_owner_id}}" class="text-capitalize">{{$re->next_owner_lastname.' '.$re->next_owner_name.' '.$re->next_owner_middlename}}</a>
																	</td>
																@endif
															@endif
														</tr>
													</tbody>
												</table>
											</div>

										</div>

									</div>

								</div>

							</li>
						<?php }

					}?>

					{{-- 

					

					<li>

						<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> </time>

						<div class="cbp_tmicon">

							<img src="{{ URL::asset('resources/views/layouts/assets/images/pngs/wrench.png') }}">

						</div>

						<div class="cbp_tmlabel">

							<div class="row">

								<div class="col-12"> 

									<h2 class="text-dark timeline-title border-bottom mb-0"><span>Texnik ko'rikdan o'tish</span> </h2>

									<div class="row">

										<div class="col-4">										

											<div class="customer-info-item pt-3 fs-16">

												<div class="row">

													<div class="col-12">

														<span class="customer-info-desc fw-500">Texnika davlat raqami </span>

													</div>

													<div class="col-12">

														<span class="customer-info-text">124123</span>

													</div>

												</div>

											</div>

										</div>

										<div class="col-4">										

											<div class="customer-info-item pt-3 fs-16">

												<div class="row">

													<div class="col-12">

														<span class="customer-info-desc fw-500">To'lov </span>

													</div>

													<div class="col-12">

														<span class="customer-info-text">123234</span>

													</div>

												</div>

											</div>

										</div>

										<div class="col-4">										

											<div class="customer-info-item pt-3 fs-16">

												<div class="row">

													<div class="col-12">

														<span class="customer-info-desc fw-500">O'tdi/O'tmadi </span>

													</div>

													<div class="col-12">

														<span class="customer-info-text">123234</span>

													</div>

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

					</li> --}}

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

  <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

 <!-- Free Service only -->

  <script type="text/javascript">

  

$(document).ready(function(){



	// $('table#transports-table').DataTable({

	// 	responsive:true

	// });

   

    $(".freeserviceopen").click(function(){ 

	  

	  $('.modal-body').html("");

	   

       var f_serviceid = $(this).attr("f_serviceid");

	  

		var url = $(this).attr('url');

	      

       $.ajax({

       type: 'GET',

       url: url,

	

       data : {f_serviceid:f_serviceid},

       success: function (data)

       {            



			  $('.modal-body').html(data.html);

				

   },

   beforeSend:function(){

						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");

					},

error: function(e) {

       alert("An error occurred: " + e.responseText);

       console.log(e);	

}

       });



       });

   });

</script>     



<!-- Paid Service only -->

  <script type="text/javascript">

  

$(document).ready(function(){

   
	
	
    $(".paidservice").click(function(){ 

	  

	  $('.modal-body').html("");

	   

       var p_serviceid = $(this).attr("p_serviceid");

	  

		var url = $(this).attr('url');

	      

       $.ajax({

       type: 'GET',

       url: url,

	

       data : {p_serviceid:p_serviceid},

       success: function (data)

       {            



			  $('.modal-body').html(data.html);

				

   },

   beforeSend:function(){

						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");

					},

error: function(e) {

       alert("An error occurred: " + e.responseText);

       console.log(e);	

}

       });



       });

	   });



</script> 


<!--  Free cusomer model service -->



  <script type="text/javascript">

  

$(document).ready(function(){

   

    $(".customeropenmodel").click(function(){ 

	  

	  $('.modal-body').html("");

	    var open_customer_id= $(this).attr("open_customer_id");

		var url = $(this).attr('url');

		

       $.ajax({

       type: 'GET',

       url: url,

	   data : {servicesid:open_customer_id},

       success: function (data)

       {      

			  $('.modal-body').html(data.html);

				

		},

   beforeSend:function(){

						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");

					},

error: function(e) {

			alert("An error occurred: " + e.responseText);

			console.log(e);	

		}

       });

       });

   });



</script>

 

@endsection
@extends('layouts.app')

@section('content')

<Style>

.cld{

	 border-top: 3px solid #F25656;

}

.rjc{

	border-top: 3px solid #3a87ad;

}

.tmm{

	border-top: 3px solid #f39c12;

}

.mss{

    border-top: 3px solid  #12AFCB;

}

.freebuttom{

	    border-top: 3px solid #996600;

}

.paidbuttom{

	    border-top: 3px solid #f39c12 ;

}

.repeatbuttom{

	    border-top: 3px solid #00a65a ;

}

</style>

<script src="{{ URL::asset('build/js/jscharts.js') }}" defer="defer"></script>

<!-- <script src="{{ URL::asset('build/js/Chart.min.js') }}" defer="defer"></script> -->

	<div class="right_col" role="main">

	<!--  Free service view -->

		<div id="myModal-open-modal" class="modal fade" role="dialog">

			<div class="modal-dialog modal-lg modal-xs">

				<!-- Modal content-->

				<div class="modal-content">

					<div class="modal-header"> 

						<a href=""><button type="button" class="close">&times;</button></a>

						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Free Service Details')}}</h4>

					</div>

					<div class="modal-body">

					

					</div>

				</div>

			</div>

		</div>

		

	<!--  Paid service view -->

		<div id="myModal-com-service" class="modal fade" role="dialog">

			<div class="modal-dialog modal-lg modal-xs">

			<!-- Modal content-->

				<div class="modal-content">

					<div class="modal-header"> 

						<a href=""><button type="button" class="close">&times;</button></a>

						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Paid Service Details')}}</h4>

					</div>

					<div class="modal-body">

	                   

					</div>

				</div>

			</div>

		</div>

	<!--  Repeat Job Service view -->

		<div id="myModal-serviceup" class="modal fade" role="dialog">

			<div class="modal-dialog modal-lg modal-xs">

		<!-- Modal content-->

				<div class="modal-content">

					<div class="modal-header"> 

						<a href=""><button type="button" class="close">&times;</button></a>

						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Repeat Job Service Details')}}</h4>

					</div>

					<div class="modal-body">

	                   

					</div>

				</div>

			</div>

		</div>

	<!--  Free service customer view -->

		<div id="myModal-customer-modal" class="modal fade" role="dialog">

			<div class="modal-dialog modal-lg modal-xs">

				<!-- Modal content-->

				<div class="modal-content">

					

					<div class="modal-body">

					

					</div>

				</div>

			</div>

		</div>

        

	<!-- Active(login) in show admin , supportstaff,accountant -->

	

	<?php $userid=Auth::User()->id;?>

	@if(!empty(getActiveCustomer($userid)=='yes'))	

	<div class="card" style="margin-top: 0.75rem">	

		<div class="card-body">

			<div class="row">	

				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3 ">

					<a href="employee/list" target="blank">

						<div class="panel info-box panel-white">

							<div class="panel-body member">

							

							<img src="{{ URL::asset('public/img/dashboard/team.png')}}" class="dashboard_background" alt="" style="max-width: 100%;">	

								 <div class="info-box-stats">

									<p class="counter">

										@if(isset($employee))

										  <?php  echo $employee; ?>

										@else

										<?php  echo "0"; ?>

										@endif                                 </p>

									

									<span class="info-box-title">{{ trans('app.Employees')}}</span>

								</div>

								

							</div>

						</div>

					</a>

				</div>

				

				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">

					<a href="customer/list" target="blank">

						<div class="panel info-box panel-white">

							<div class="panel-body staff-member">

							<img src="{{ URL::asset('public/img/dashboard/client.png')}}" class="dashboard_background" alt="">	

								<div class="info-box-stats">

									<p class="counter">

										

									@if(isset($Customer))

										<?php echo $Customer; ?>

									@else

										<?php  echo "0"; ?>

									@endif

															  </p>

										<span class="info-box-title">{{ trans('app.Customers')}}</span>

								</div>

								

								

							</div>

						</div>

						</a>

				</div>

				

				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">

					<a href="supplier/list" target="blank">

						<div class="panel info-box panel-white">

							<div class="panel-body group">

							<img src="{{ URL::asset('public/img/dashboard/telemarketer.png')}}" class="dashboard_background" alt="">						<div class="info-box-stats">

									<p class="counter">

										@if(isset($Supplier))

										<?php echo $Supplier; ?>

									@else

										<?php  echo "0"; ?>

										@endif

										</p>

									

									<span class="info-box-title">{{ trans('app.Supplier')}} </span>

								</div>

								

								

							</div>

						</div>

					</a>

				</div>

				

				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">

					<a href="product/list" target="blank">

						<div class="panel info-box panel-white">

							<div class="panel-body message">

							<img src="{{ URL::asset('public/img/dashboard/industrial-robot.png')}}" class="dashboard_background" alt="">	

								<div class="info-box-stats">

									<p class="counter">

									  @if($product)

										<?php echo $product; ?>

									@else

										<?php  echo "0"; ?>

									  @endif

									</p>

									<span class="info-box-title">{{ trans('app.Products')}}</span>

								</div>

								

								

							</div>

						</div>

					</a>

				</div>

				

				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">

					<a href="sales/list" target="blank">

						<div class="panel info-box panel-white">

							<div class="panel-body member">

							<img src="{{ URL::asset('public/img/dashboard/contract.png')}}" class="dashboard_background" alt="">						<div class="info-box-stats">

									<p class="counter">

									@if($sales)

									 <?php echo $sales; ?>

								 @else

										<?php  echo "0"; ?>

								   @endif

									 </p>

									

									<span class="info-box-title"> {{ trans('app.Sales')}}</span>

								</div>

							

							</div>

						</div>

					</a>

				</div>

				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">

					<a  href="service/list" target="blank">

						<div class="panel info-box panel-white">

							<div class="panel-body staff-member">

							<img src="{{ URL::asset('public/img/dashboard/tasks.png')}}" class="dashboard_background" alt="">						<div class="info-box-stats">

									<p class="counter">

									@if($service)

										<?php echo $service; ?>

									@else

										<?php  echo "0"; ?>

									@endif

									</p>

									

									<span class="info-box-title">{{ trans('app.Services')}}</span>

								</div>

								

								

							</div>

						</div>

					</a>

				</div>

			</div>

		</div>

	</div>

	@endif

	<!-- end Active(login) in show admin , supportstaff,accountant -->

	<div class="row">

		<div class="col-md-12">



			<div class="page-header">



				<ol class="breadcrumb">



					<li class="breadcrumb-item">



						<a href="/"><i class="fe fe-calendar mr-1"></i>&nbsp {{ trans('app.Eslatmalar')}}



						</a>



					</li>



				</ol>



			</div>



		</div>

		

	</div>

	<div class="row">

		<div class="col-12 col-sm-12">

			<div class="card ">

				<div class="card-header">

					<div class="card-title mb-0">Texnik ko'rik bo'yicha</div>

				</div>

				<div class="card-body">

					<div class="table-responsive">

						<table class="table table-bordered text-nowrap mb-0">

							<thead>

								<tr>

									<th>{{ trans('app.No') }}</th>

									<th>{{ trans('app.Texnika egasi') }}</th>

									<th>{{ trans('app.Texnika') }}</th>

									<th>{{ trans("app.Texnik ko'rikdan o'tgan") }}</th>

									<th>{{ trans('app.Action') }}</th>

								</tr>

							</thead>

							<tbody>
								@if(!empty($medlist))

								<?php $i=1; ?>
									@foreach($medlist as $vehicle)

										<tr>

											<td>{{ $i }}</td>

											<td><a href="/customer/list/{{ $vehicle->owner_id }}" target="_blank">{{ $vehicle->ownername }}</a></td>

											<td><a href="/vehicle/list/view/{{ $vehicle->vehicle_id }}" target="_blank">{{ $vehicle->typename.'-'.$vehicle->brandname }}</a></td>

											<td>{{date('d.m.Y',strtotime($vehicle->passeddate))}}</td>

											<td><a href="/certificate/medadd?vehicle_id={{ $vehicle->vehicle_id }}" class="btn btn-danger">{{ trans("app.Texnik ko'rikdan o'tkazish") }}</a></td>

										</tr>
										<?php $i++; ?>
									@endforeach
								@endif

							</tbody>

						</table>

					</div>

				</div>

			</div>

		</div><!-- COL END -->

	</div>



	<div class="row">

		<div class="col-12 col-sm-12">

			<div class="card ">

				<div class="card-header">

					<div class="card-title mb-0">Ro'yxatga olish bo'yicha</div>

				</div>

				<div class="card-body">

					<div class="table-responsive">

						<table class="table table-bordered text-nowrap mb-0">

							<thead>

								<tr>

									<th>#No</th>

									<th>Texnika egasi</th>

									<th>texnika</th>

									<th>Ro'yxatdan chiqarilgan</th>

									<th>Manzil</th>

									<th>Status</th>

								</tr>

							</thead>

							<tbody>
								@if(!empty($registrationNotifications))
									@foreach($registrationNotifications as $regNotification)
										<tr>

											<td>#01</td>

											<td><a href="/customer/list/{{$regNotification->owner_id}}" target="_blank" class="text-capitalize">{{$regNotification->owner_name.' '.$regNotification->owner_lastname}}</a></td>

											<td><a href="/vehicle/list/view/{{$regNotification->vehicle_id}}" target="_blank">{{$regNotification->vehicle_type.' - '.$regNotification->vehicle_brand}}</a></td>

											<td>{{date('d.m.Y',strtotime($regNotification->date))}}</td>

											<td class="number-font1">{{$regNotification->state.', '.$regNotification->city}}</td>

											<td><a href="/certificate/regadd?vehicle_id={{$regNotification->vehicle_id}}" class="btn btn-danger">Ro'yxatga olish</a></td>

										</tr>
									@endforeach
								@else
									<tr><td colspan="4">Eslatmalar yo'q</td></tr>
								@endif

							</tbody>

						</table>

					</div>

				</div>

			</div>

		</div><!-- COL END -->

	</div>



	{{-- <div class="col-md-12">



				<div class="page-header">



					<ol class="breadcrumb">



						<li class="breadcrumb-item">



							<a href="/"><i class="fe fe-calendar mr-1"></i>&nbsp {{ trans('app.Timeline')}}



							</a>



						</li>



					</ol>



				</div>



			</div>	



			<div class="col-md-12">



				<ul class="cbp_tmtimeline">



					<?php 



					while(!empty($transport_numbers) || !empty($technical_passports) || !empty($driver_licences)){



						$actionTime=0;



						$actionType='';



						$tN=null;

						$dL=null;

						$tP=null;







						if(!empty($transport_numbers[0])){



							$actionTime=strtotime($transport_numbers[0]->given_date);



							$actionType='transport_numbers';



						}



						if(count($technical_passports) && strtotime($technical_passports[0]->given_date)>$actionTime){



							$actionTime=$technical_passports[0]->given_date;



							$actionType='technical_passports';



						}



						if(count($driver_licences) && strtotime($driver_licences[0]->given_date)>$actionTime){

							$actionTime=$driver_licences[0]->given_date;

							$actionType='driver_licences';

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

							default:



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



																Texnika davlat raqami



															</th>



															<th>



																To’lov



															</th>



														</tr>



													</thead>



													<tbody>



														<tr>



															<td>



																<a href="/vehicle/list/view/{{$tN->vehicle_id}}">{{$tN->vehicle_type.' ('.$tN->model.')'}}</a>



															</td>



															<td>



																{{$tN->code.' '.$tN->series.$tN->number}}



															</td>



															<td>



																{{$tN->payment_status}}



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



													<span>Texnikaga texnik passport berildi</span>



												@elseif($tP->action=='recover')



													<span>Texnika passporti qayta tiklandi</span>



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



																Texnika davlat raqami



															</th>



															<th>



																Tex-passport raqami



															</th>



															<th>



																To’lov



															</th>



														</tr>



													</thead>



													<tbody>



														<tr>



															<td>



																<a href="/vehicle/list/view/{{$tP->vehicle_id}}">{{$tP->vehicle_type.' ('.$tP->model.')'}}</a>



															</td>



															<td>



																{{$tP->number_code.' '.$tP->number_series.$tP->number_number}}



															</td>



															<td>



																{{$tP->series.$tP->number}}



															</td>



															<td>



																asdasd



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



															<th>Shaxs passport raqami</th>

															<th>Guvohnoma seriya raqami</th>

															<th>Guvohnoma toifasi</th>

															<th>To'lov</th>

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

															<td>

																<span>{{trans('app.paid')}}</span>

															</td>

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



					<li>



						<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> </time>



						<div class="cbp_tmicon">



							<img style="margin-top: -3px;" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/registration-480.png') }}">



						</div>



						<div class="cbp_tmlabel">



							<div class="row">



								<div class="col-12"> 



									<h2 class="text-dark timeline-title border-bottom mb-0"><span>Texnika egaisini ro'yxatga olish/ ro'yxatdan chiqarish</span> </h2>



									<div class="row">



										<div class="col-3">										



											<div class="customer-info-item pt-3 fs-16">



												<div class="row">



													<div class="col-12">



														<span class="customer-info-desc fw-500">Viloyat </span>



													</div>



													<div class="col-12">



														<span class="customer-info-text">124123</span>



													</div>



												</div>



											</div>



										</div>



										<div class="col-3">										



											<div class="customer-info-item pt-3 fs-16">



												<div class="row">



													<div class="col-12">



														<span class="customer-info-desc fw-500">{{ trans('app.Town/City')}} </span>



													</div>



													<div class="col-12">



														<span class="customer-info-text">123234</span>



													</div>



												</div>



											</div>



										</div>



										<div class="col-3">										



											<div class="customer-info-item pt-3 fs-16">



												<div class="row">



													<div class="col-12">



														<span class="customer-info-desc fw-500">Davlat raqami  </span>



													</div>



													<div class="col-12">



														<span class="customer-info-text">123234</span>



													</div>



												</div>



											</div>



										</div>



										<div class="col-3">										



											<div class="customer-info-item pt-3 fs-16">



												<div class="row">



													<div class="col-12">



														<span class="customer-info-desc fw-500"> To'lov </span>



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



					</li>



					



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



					</li>



				</ul>



			</div> --}}





		

	<!---end Active(login) in show admin,supportstaff,accountant-->	

 



 <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script> 

 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

 <script type="text/javascript" src="https://www.google.com/jsapi"></script>

 

 <!-- service event in calendarevent -->

 <?php if(!empty($serviceevent))

	{

		foreach($serviceevent as $serviceevents)

		{	

			

			$i=1;

			$n_start_date=date("Y-m-d", strtotime($serviceevents->service_date));

			$n_end_date=date("Y-m-d", strtotime($serviceevents->service_date));

			$sid=$serviceevents->job_no; 

			$userid=Auth::User()->id;

			if(!empty(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes'))

			{

				$view_data = getInvoiceStatus($serviceevents->job_no);

												

				if($view_data == "No")

				{

					$service_data_array[]=array('title'=>$serviceevents->job_no,

					'title1'=>$serviceevents->job_no,

					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),

					'customer'=>getCustomerName($serviceevents->customer_id),

					'vehicle'=>getVehicleName($serviceevents->vehicle_id),

					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),

					'url'=> 'jobcard/list/'.$serviceevents->id,

					'start'=>$n_start_date,

					'end'=>$n_end_date,

					'color'=>'#f0ad4e',

					);

				}

				else

				{

					$service_data_array[]=array('title'=>$serviceevents->job_no,

					'title1'=>$serviceevents->job_no,

					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),

					'customer'=>getCustomerName($serviceevents->customer_id),

					'vehicle'=>getVehicleName($serviceevents->vehicle_id),

					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),

					's_id'=>$serviceevents->id,

					'url1'=> 'dashboard/open-modal',

					'start'=>$n_start_date,

					'end'=>$n_end_date,

					'color'=>'#5FCE9B',

					);

				}

					

			}

			else

			{

				$view_data = getInvoiceStatus($serviceevents->job_no);

				

				if($view_data == "No")

				{

					$service_data_array[]=array('title'=>$serviceevents->job_no,

					'title1'=>$serviceevents->job_no,

					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),

					'customer'=>getCustomerName($serviceevents->customer_id),

					'vehicle'=>getVehicleName($serviceevents->vehicle_id),

					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),

					's_id'=>$serviceevents->id,

					'url11'=>'service/list/view',

					'start'=>$n_start_date,

					

					'end'=>$n_end_date,

					'color'=>'#f0ad4e',

					);

				}

				else

				{

					$service_data_array[]=array('title'=>$serviceevents->job_no,

					'title1'=>$serviceevents->job_no,

					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),

					'customer'=>getCustomerName($serviceevents->customer_id),

					'vehicle'=>getVehicleName($serviceevents->vehicle_id),

					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),

					's_id'=>$serviceevents->id,

					'url1'=> 'dashboard/open-modal',

					'start'=>$n_start_date,

					'end'=>$n_end_date,

					'color'=>'#5FCE9B',

					);

				}

			}

			

		}

	

	} 

	

	//Holiday Event

	if(!empty($holiday))

	{

		foreach($holiday as $holidays)

		{	

			$i=1;

			$n_start_date=date("Y-m-d", strtotime($holidays->date));

			$n_end_date=date("Y-m-d", strtotime($holidays->date));

			$service_data_array[]=array('title'=>substr($holidays->title,0,10),

			'title1'=>$holidays->title,

			'dates'=>date(getDateFormat(),strtotime($holidays->date)),

			'description'=>$holidays->description,

			'customer'=>'Holiday',

			'vehicle'=>"",

			'plateno'=>"",

			'start'=>$n_start_date,

			'end'=>$n_end_date,

			'color'=>'#3a87ad',

			);

		}

	} 

	if(!empty($service_data_array)) {

		$data1 = json_encode($service_data_array);

	}

	else{

		$data1=json_encode('0');

	}

?>

 <!-- Calendar Event in Dashboard---->

 <script>

	$(document).ready(function() {

		$('#calendarevent').fullCalendar({

		height: 620,

		 header: {

		left: 'prev,next today',

		center: 'title',

		right: 'month,agendaWeek,agendaDay'

		},

		defaultDate: new Date(),

			navLinks: true, // can click day/week names to navigate views

			editable: true,

			eventLimit: true, // allow "more" link when too many events

			editable: true,

			toolkip:true,

			events: <?php  if(!empty($data1)){ echo $data1;} ?>,

			eventMouseover: function (data, event, view) {

			   tooltip = '<div class="col-md-12 col-sm-12 col-xs-12 tooltiptopicevent" style="width:auto;height:auto;background:black;color:#fff;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;border-radius:5px;  line-height: 200%;">';

			   // alert(data.vehicle);

				if(data.title1 != '')

					tooltip = tooltip + data.title1 ; 

				if(data.dates != '')

					tooltip = tooltip + ' | ' + data.dates + '</br>' + ' ';  

				if(data.customer != '')

					tooltip = tooltip  + data.customer;

				if(data.plateno != '')

					tooltip = tooltip + ' | ' + data.plateno;

				if(data.vehicle != '')

					tooltip = tooltip + ' | ' + data.vehicle;

			

				tooltip = tooltip + '</div>';

			

            $("body").append(tooltip);

            $(this).mouseover(function (e) {

                $(this).css('z-index', 10000);

                $('.tooltiptopicevent').fadeIn('500');

                $('.tooltiptopicevent').fadeTo('10', 1.9);

            }).mousemove(function (e) {

                $('.tooltiptopicevent').css('top', e.pageY + 10);

                $('.tooltiptopicevent').css('left', e.pageX + 20);

            });

			},

			eventMouseout: function (data, event, view) {

				$(this).css('z-index', 8);

				$('.tooltiptopicevent').remove();

			},

			dayClick: function () {

				tooltip.hide()

			},

			eventResizeStart: function () {

				tooltip.hide()

			},

			eventDragStart: function () {

				tooltip.hide()

			},

			viewDisplay: function () {

				tooltip.hide()

			},

			

			eventClick: function(event) {

				if (event.url) {

					window.location(event.url);

				}

				if (event.url1)

				{

					$('#myModal-job').modal();



					$('.modal-body').html("");

					

					var serviceid = (event.s_id);					

									

											

					var url = (event.url1);

				

					   $.ajax({

					   type: 'GET',

					   url: url,

					

					   data : {open_id:serviceid},

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

				}

				if (event.url11)

				{

					$('#myModal-customer-modal').modal();

					$('.modal-body').html("");

					var servicesid = (event.s_id);

					var url = (event.url11);

					

				   $.ajax({

				   type: 'GET',

				   url: url,

				   data : {servicesid:servicesid},

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

				}

			}

      

		});

	});	

	

	</script>

	

 <!-- Monthly service in barchart---->

 <script type="text/javascript">

 google.load("visualization", "1", {packages:["corechart"]});

 google.setOnLoadCallback(drawChart);

 function drawChart() {

 var data = google.visualization.arrayToDataTable([

          ['Date', 'Service',{ role: 'style' },{ role: 'annotation' }],

		  <?php

		     for($i=1;$i<=sizeof($dates);$i++)

			 {

				$count =  getNumberOfService($i);

				

			 ?>

			 ['<?php echo $i;?>',<?php echo $count;?>,'',''],

			<?php 

			

			 }

		   ?>

 ]);

 var options = {

	legend:'none',

	heigth:150,

	chartArea:{left:40,'width':'90%',top:20,bottom:50,},

	fontSize :10,

	color:'#73879C',

	hAxis: {

			title: 'Dates',

			titleTextStyle: {fontSize:12,color:'#4E5E6A',fontName: 'Roboto'},

						

			},

    vAxis: {

			title: ' Number Of Service',

			titleTextStyle: {fontSize:12,color:'#4E5E6A',fontName: 'Roboto'},

			

			format:'decimal',

			},

 };

 var chart = new google.visualization.ColumnChart(document.getElementById("barchart"));

 chart.draw(data, options);

 }

 </script>

 

 <!-- Ontime   donutchart-->

    <script type="text/javascript">

      google.charts.load("current", {packages:["corechart"]});

      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([

          ['Hours', 'No of service'],

          ['24-Hours',<?php if(!empty($one_day)){echo $one_day;}else{echo"0";}?> ],

		

          ['48-Hours',<?php if(!empty($two_day)){echo $two_day;}else{echo"0";}?> ],

          ['48-Hours After',<?php if(!empty($more)){echo $more;}else{echo"0";}?> ],

       

        ]);

        var options = {

			

			fontSize:10,

			fontName:'sans-serif',

			height:150,

		 chartArea:{left:1,right:2,bottom:30,top:30},

		legend: { position: 'right', maxLines: 5,textStyle: {fontSize: 10,color:'#73879C',bold:true}},

		isStacked: 'relative',

		 vAxis: {

            minValue: 0,

            ticks: [0, .3, .6, .9, 1]

          }	

        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchartontime'));

        chart.draw(data, options);

      }

    </script>

<!-- Vehicle  donutchart-->

    <script type="text/javascript">

      google.charts.load("current", {packages:["corechart"]});

      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([

          ['Vehicle', 'Number of service'],

		  @foreach ($vehical as $vehicals)

			<?php $v_name = getVehicleName($vehicals->vid);?>

          ['<?php echo $v_name;?>',    <?php echo $vehicals->count;?> ],

         @endforeach

        ]);



        var options = {

			is3D: true, 

			fontSize:10,

			fontName:'sans-serif',

			height:150,

			chartArea:{left:3,right:3,bottom:30,top:10},

			legend: { position: 'right', maxLines: 5,textStyle: {fontSize: 10,color:'#73879C',bold:true}},

			isStacked: 'relative',

			vAxis: {

					minValue: 0,

					ticks: [0, .3, .6, .9, 1]

					}	

			};



        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));

        chart.draw(data, options);

      }

    </script>



<!-- Performance  donutchart-->

    <script type="text/javascript">

      google.charts.load("current", {packages:["corechart"]});

      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([

          ['Employee', 'No of service'],

           @foreach ($performance as $performances)

			<?php $assigne=getAssignedName($performances->a_id); ?>

          ['<?php echo $assigne;?>',    <?php echo $performances->count;?> ],

         @endforeach

        ]);



        var options = {

			is3D: true, 

			fontSize:10,

			fontName:'sans-serif',

			height:180,

		 chartArea:{left:5,right:5,bottom:5,top:15},

		legend: { position: 'right', maxLines: 15,textStyle: {fontSize: 12,padding:'5px',color:'#73879C',bold:true}},

		isStacked: 'relative',

		 vAxis: {

            minValue: 0,

            ticks: [0, .3, .6, .9, 1]

          }	

		};

        var chart = new google.visualization.PieChart(document.getElementById('donutchartperformance'));

        chart.draw(data, options);

      }

    </script>

<!--  Free service -->



  <script type="text/javascript">

  

$(document).ready(function(){

   

    $(".openmodel").click(function(){ 

	  

	  $('.modal-body').html("");

	    var open_id= $(this).attr("open_id");

		

		var url = $(this).attr('url');

       $.ajax({

       type: 'GET',

       url: url,

	   data : {open_id:open_id},

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



<!-- Paid service -->

  <script type="text/javascript">

  

$(document).ready(function(){

   

    $(".completedservice").click(function(){ 

	  

	  $('.modal-body').html("");

	   

       var c_service = $(this).attr("c_service");

	    

		var url = $(this).attr('url');

	     

       $.ajax({

       type: 'GET',

       url: url,

	

       data : {open_id:c_service},

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



<!-- Repeat Job service  -->

  <script type="text/javascript">

  

$(document).ready(function(){

   

    $(".service-up").click(function(){ 

	  

	  $('.modal-body').html("");

	   

       var u_service = $(this).attr("u_service");

	   

		var url = $(this).attr('url');

	     

       $.ajax({

       type: 'GET',

       url: url,

	

       data : {open_id:u_service},

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
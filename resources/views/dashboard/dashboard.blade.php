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
										@if(isset($staffs))
										  <?php  echo $staffs; ?>
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

									@if(!empty($owners_c))
										{{ $owners_c }}
									@else
										0
									@endif
															  </p>
										<span class="info-box-title">Mulk egalari</span>
								</div>						

							</div>
						</div>
						</a>
				</div>

				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
					<a href="customer/list?type=legal" target="blank">
						<div class="panel info-box panel-white">
							<div class="panel-body group">
							<img src="{{ URL::asset('public/img/dashboard/telemarketer.png')}}" class="dashboard_background" alt="" style="width: 48px;">						<div class="info-box-stats">
									<p class="counter">
										@if(!empty($owner_le))
											{{ $owner_le }}
										@else
										0
										@endif
										</p>

									<span class="info-box-title">Yuridik shaxslar </span>
								</div>


							</div>
						</div>
					</a>
				</div>

				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
					<a href="customer/list?type=physical" target="blank">
						<div class="panel info-box panel-white">
							<div class="panel-body message">
							<img src="{{ URL::asset('public/img/dashboard/industrial-robot.png')}}" class="dashboard_background" alt="" style="width: 48px;">	
								<div class="info-box-stats">
									<p class="counter">
									@if(!empty($owner_ph))
										{{ $owner_ph }}
									@else
										0
									@endif
									</p>
									<span class="info-box-title">Jismoniy shaxlar</span>
								</div>


							</div>
						</div>
					</a>
				</div>

				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
					<a href="supplier/list" target="blank">
						<div class="panel info-box panel-white">
							<div class="panel-body member">
							<img src="{{ URL::asset('public/img/dashboard/contract.png')}}" class="dashboard_background" alt="">						<div class="info-box-stats">
									<p class="counter">
									@if(!empty($supplier_c))
									 {{ $supplier_c }}
								 @else
										0
								   @endif
									 </p>

									<span class="info-box-title"> {{ trans('app.Yetkazib beruvchilar')}}</span>
								</div>

							</div>
						</div>
					</a>
				</div>
				<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
					<a  href="vehicle/list" target="blank">
						<div class="panel info-box panel-white">
							<div class="panel-body staff-member">
							<img src="{{ URL::asset('public/img/dashboard/tasks.png')}}" class="dashboard_background" alt="">						<div class="info-box-stats">
									<p class="counter">
									@if(!empty($count_veh))
										{{ $count_veh }}
									@else
										0
									@endif
									</p>

									<span class="info-box-title">Mavjud texnikalar</span>
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
						<i class="fe fe-calendar mr-1"></i>&nbsp Oxirgi harakatlar
					</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-sm-12">
			<div class="card ">
				<div class="card-header">
					<div class="card-title mb-0">Oxirgi haydovchilik guvohnomasi olganlar</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap mb-0">
							<thead>
								<tr>
									<th>{{ trans('app.No') }}</th>
									<th>{{ trans('app.Guvohnoma') }}</th>
									<th>Toifa</th>
									<th>{{ trans('app.Haydovchi') }}</th>
									<th>{{ trans('app.SHIR/STIR') }}</th>
									<th>Tuman/Viloyat</th>
									<th>Holati</th>
									<th>{{ trans('app.Given Date')}}</th>
									<th>To'lov miqdori</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1;?>
								@if(!empty($driver_lic))
									@foreach($driver_lic as $license)
										<?php 
										$types=json_decode($license->licence_type,true);
										$givenTypes=[];
										foreach($types as $t){
											$givenTypes[]=$t['name'];
										}
										$givenTypes=implode(',',$givenTypes);
										?>
										<tr>
											<td>{{ $i }}</td>
											<td>
												<a href="/driver-licence/preview?id={{$license->id}}&details=true">{{ $license->series.$license->number}}</a>
											</td>
											<td>{{$givenTypes}}</td>
											<td><a href="/customer/list/{{$license->owner_id}}" class="text-capitalize">{{ $license->lastname.' '.$license->name.' '.$license->middlename }}</a></td>
											<td>{{ $license->id_number?$license->id_number:$license->inn }}</td>
											<td>{{ $license->city.'/'.$license->state }} </td>
											<td>
												@if($license->status=='active')
													<span class="text-success">Faol</span>
												@else
													<span class="text-danger">Faolmas</span>
												@endif
											</td>
											<td>{{date('d.m.Y',strtotime($license->given_date))}}</td>
											<td  class="amount text-right">{{ $license->total_amount }}</td>
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
					<div class="card-title mb-0">Oxirgi ro'yxatdan o'tganlar</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap mb-0">
							<thead>
								<tr>
									<th>{{ trans('app.No') }}</th>
									<th>{{ trans('app.Vehicle') }}</th>
									<th>{{ trans('app.Texnika egasi') }}</th>
									<th>Davlat raqami</th>
									<th>Tuman/Viloyat</th>
									<th>{{ trans('app.Date') }}</th>
									<th>To'lov miqdori</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($vehicle_reg))
									<?php $i=1; ?>
									@foreach($vehicle_reg as $vehicle)

												<tr>
													<td>{{ $i }}</td>
													<td>
														{{ $vehicle->typename.'-'.$vehicle->brandname }}
													</td>
													<td>
														<a href="/customer/list/{{ $vehicle->owner_id }}" target="_blank" class="text-capitalize">
															@if($vehicle->ownertype=='legal')
																{{ $vehicle->ownername }}
															@elseif($vehicle->ownertype == 'physical')
																{{ $vehicle->ownerlastname.' '.$vehicle->ownername }} 
																@if(!empty($vehicle->middlename))
																	{{ $vehicle->middlename }}
																@endif
															@endif
														</a>
													</td>

													<td>
														@if(!empty($vehicle->tnscode))
															{{ $vehicle->tnscode.' '.$vehicle->tnsseries.' '.$vehicle->tnsnumber }}
														@else
															Davlat raqami berilmagan
														@endif
													</td>
													<td>
														{{ $vehicle->cityname.'/'.$vehicle->regionname }}
													</td>													
													<td>{{date('d.m.Y',strtotime($vehicle->date))}}
													</td><td class="amount text-right">
														{{ $vehicle->total_amount }}
													</td>
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
					<div class="card-title mb-0">Oxirgi davlat raqami berilganlar</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap mb-0">
							<thead>
								<tr>
									<th>{{ trans('app.No') }}</th>
									<th>Davlat raqami</th>
									<th>{{ trans('app.Texnika egasi') }}</th>
									<th>{{ trans('app.Vehicle') }}</th>

									<th>{{ trans('app.Date') }}</th>
									<th>To'lov miqdori</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($transport_num))
									<?php $i=1; ?>
									@foreach($transport_num as $vehicle)

												<tr>
													<td>{{ $i }}</td>
													<td>
														<a href="/vehicle/transport-number/preview?id={{ $vehicle->id }}&details=true">
															{{ $vehicle->tnscode.' '.$vehicle->tnsseries.' '.$vehicle->tnsnumber }}
														</a>
													</td>
													<td>
														<a href="/customer/list/{{ $vehicle->owner_id }}" target="_blank" class="text-capitalize">
															@if($vehicle->ownertype=='legal')
																{{ $vehicle->ownername }}
															@elseif($vehicle->ownertype == 'physical')
																{{ $vehicle->ownerlastname.' '.$vehicle->ownername }} 
																@if(!empty($vehicle->middlename))
																	{{ $vehicle->middlename }}
																@endif
															@endif
														</a>
													</td>
													<td>
														{{ $vehicle->typename.'-'.$vehicle->brandname }}
													</td>

													<td>{{date('d.m.Y',strtotime($vehicle->date))}}</td>
													<td class="amount text-right">
															{{ $vehicle->total_amount }}
													</td>
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
					<div class="card-title mb-0">Oxirgi texnik passport berilganlar</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap mb-0">
							<thead>
								<tr>
									<th>{{ trans('app.No') }}</th>
									<th>Seriya/Raqam</th>
									<th>{{ trans('app.Texnika egasi') }}</th>
									<th>{{ trans('app.Vehicle') }}</th>
									<th>Davlat raqami</th>									
									<th>{{ trans('app.Date') }}</th>
									<th>To'lov miqdori</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($technicalPassports))
									<?php $i=1; ?>
									@foreach($technicalPassports as $passport)
										<tr>
											<td>{{ $i }}</td>
											<td>
												<a href="/vehicle/technical-passport/preview?id={{ $passport->id.'&details=true' }}" target="_blank">
													{{ $passport->series.$passport->number }}
												</a>
											</td>
											<td>
												<a href="/customer/list/{{ $passport->owner_id }}" target="_blank" class="text-capitalize">
													{{$passport->owner_lastname.' '.$passport->owner_name.' '.$passport->owner_middlename}}
												</a>
											</td>
											<td>
												{{ $passport->vehicle_type.'-'.$passport->vehicle_brand }}
											</td>
											<td>
												{{ $passport->number_code.' '.$passport->number_series.' '.$passport->number_number }}
											</td>									
											<td>{{date('d.m.Y',strtotime($passport->given_date))}}</td>
											<td class="amount text-right">
												{{ $passport->total_amount }}
											</td>
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
					<div class="card-title mb-0">Oxirgi texnik guvohnomalar berilganlar</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap mb-0">
							<thead>
								<tr>
									<th>{{ trans('app.No') }}</th>
									<th>Seriya/Raqam</th>
									<th>{{ trans('app.Texnika egasi') }}</th>
									<th>{{ trans('app.Vehicle') }}</th>
									<th>{{ trans('app.Date') }}</th>

									<th>To'lov miqdori</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($technical_cer))
									<?php $i=1; ?>
									@foreach($technical_cer as $certificate)
										<tr>
											<td>{{ $i }}</td>
											<td>
												<a href="/certificate/preview?id={{ $certificate->id.'&details=true' }}" target="_blank">
													{{ $certificate->series.$certificate->number }}
												</a>
											</td>
											<td>
												<a href="/customer/list/{{ $certificate->owner_id }}" target="_blank" class="text-capitalize">
													{{$certificate->owner_lastname.' '.$certificate->owner_name.' '.$certificate->owner_middlename}}
												</a>
											</td>
											<td>
												{{ $certificate->vehicle_type.'-'.$certificate->vehicle_brand }}
											</td>
											<td>{{date('d.m.Y',strtotime($certificate->given_date))}}</td>													
											<td class="amount text-right">
												{{ $certificate->total_amount }}
											</td>
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
					<div class="card-title mb-0">Oxirgi texnik ko'rikdan o'tganlar</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap mb-0">
							<thead>
								<tr>
									<th>{{ trans('app.No') }}</th>
									<th>Talon raqami</th>
									<th>{{ trans('app.Texnika egasi') }}</th>
									<th>{{ trans('app.Vehicle') }}</th>
									<th>Davlat raqami</th>

									<th>{{ trans('app.Date') }}</th>
									<th>To'lov miqdori</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($technical_med))
									<?php $i=1; ?>
									@foreach($technical_med as $vehicle)

												<tr>
													<td>{{ $i }}</td>
													<td>
														{{ $vehicle->talon }}
													</td>
													<td>
														<a href="/customer/list/{{ $vehicle->owner_id }}" target="_blank" class="text-capitalize">
															@if($vehicle->ownertype=='legal')
																{{ $vehicle->ownername }}
															@elseif($vehicle->ownertype == 'physical')
																{{ $vehicle->ownerlastname.' '.$vehicle->ownername }} 
																@if(!empty($vehicle->middlename))
																	{{ $vehicle->middlename }}
																@endif
															@endif
														</a>
													</td>
													<td>
														{{ $vehicle->typename.'-'.$vehicle->brandname }}
													</td>
													<td>
														{{ $vehicle->tnscode.' '.$vehicle->tnsseries.' '.$vehicle->tnsnumber }}
													</td>
													<td>{{date('d.m.Y',strtotime($vehicle->date))}}</td>													
													<td class="amount text-right">
														{{ $vehicle->total_amount }}
													</td>
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
		<div class="col-md-12">
			<div class="page-header">
				<ol class="breadcrumb">
					<li class="breadcrumb-item text-danger">
						<i class="fe fe-calendar mr-1"></i>&nbsp Muddatida amalga oshirilmagan harakatlar
					</li>
				</ol>
			</div>
		</div>
	</div>
	</div>
	<div class="row">
		<div class="col-12 col-sm-12">
			<div class="card ">
				<div class="card-header">
					<div class="card-title mb-0">Texnik ko'rikning muddati tugagan texnikalar</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap mb-0">
							<thead>
								<tr>
									<th>{{ trans('app.No') }}</th>
									<th>{{ trans('app.Texnika egasi') }}</th>
									<th>{{ trans('app.Vehicle') }}</th>
									<th>{{ trans("app.Texnik ko'rikdan o'tgan") }}</th>
									<th>{{ trans('app.Action') }}</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($medlist))
									<?php $i=1; ?>
									@foreach($medlist as $inspection)
										<tr>
											<td>{{ $i }}</td>
											<td>
												<a href="/customer/list/{{ $inspection->owner_id }}" target="_blank" class="text-capitalize">
													@if($inspection->ownertype=='legal')
														{{ $inspection->ownername }}
													@elseif($inspection->ownertype == 'physical')
														{{ $inspection->ownerlastname.' '.$inspection->ownername }} 
														@if(!empty($inspection->middlename))
															{{ $inspection->middlename }}
														@endif
													@endif
												</a>
											</td>
											<td><a href="/vehicle/list/view/{{ $inspection->vehicle_id.'/'.$inspection->city_id }}" target="_blank">{{ $inspection->typename.'-'.$inspection->brandname }}</a></td>
											<td>{{date('d.m.Y',strtotime($inspection->passeddate))}}</td>
											<td><a href="/certificate/medadd?vehicle_id={{ $inspection->vehicle_id }}" class="btn btn-danger">{{ trans("app.Texnik ko'rikdan o'tkazish") }}</a></td>
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
					<div class="card-title mb-0">Ro'yxatga olish muddati o'tgan texnikalar ro'yxati</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-nowrap mb-0">
							<thead>
								<tr>
									<th>No</th>
									<th>Texnika egasi</th>
									<th>texnika</th>
									<th>Ro'yxatdan chiqarilgan</th>
									<th>Manzil</th>
									<th>Harakat</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($registrationNotifications))
									<?php $i=1; ?>
									@foreach($registrationNotifications as $regNotification)
										<tr>
											<td>{{$i}}</td>
											<td>
												<a href="/customer/list/{{$regNotification->owner_id}}" target="_blank" class="text-capitalize">
													{{$regNotification->owner_lastname.' '.$regNotification->owner_name.' '.$regNotification->owner_middlename}}
												</a>
											</td>
											<td><a href="/vehicle/list/view/{{$regNotification->vehicle_id}}/{{$regNotification->city_id}}" target="_blank">{{$regNotification->vehicle_type.' - '.$regNotification->vehicle_brand}}</a></td>
											<td>{{date('d.m.Y',strtotime($regNotification->date))}}</td>
											<td class="number-font1">{{$regNotification->state.', '.$regNotification->city}}</td>
											<td><a href="/certificate/regadd?type=regged&vehicle_id={{$regNotification->vehicle_id}}" class="btn btn-danger">Ro'yxatga olish</a></td>
										</tr>
										<?php $i++ ?>
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

	<!---end Active(login) in show admin,supportstaff,accountant-->	

 <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script> 
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 @endsection
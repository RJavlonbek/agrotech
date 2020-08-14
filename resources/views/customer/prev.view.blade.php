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
					<div class="card-body p-6">
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
										<a href="{!! url('/vehicle/add')!!}">
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
												{{ $customer->name }} {{$customer->lastname}} ({{$customer->ownership_form}})
											</h4>
											@if(!empty($customer->categories))
												@foreach(explode(',',$customer->categories) as $cat)
													<div class="btn btn-primary btn-radius">
														{{ $cat}}
													</div>
												@endforeach
											@endif
										</div>
									</div>										
								</div>
								<div class="row">
									<div class="col-6">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-600">Inn raqami:</span>
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
												<span class="customer-info-desc fw-600">Passport:</span>
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
												<span class="customer-info-desc fw-600">Passport berilgan:</span>
												<span class="customer-info-text">
													@if(!empty($passport_given_city) && !empty($customer->p_given_date))
														{{$passport_given_city->name.' IIB ('.date('d.m.Y',strtotime($customer->p_given_date)).')'}}
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
								<div class="row mt-4">
									<div class="col-12">
										<h4>Tegishli texnikalar</h4>
										<div class="table-responsive">
											@if(!empty($transports_by_type))
												<table id="transports-table" class="table table-striped table-bordered nowrap">
													<thead>
														<tr>
															@foreach($transports_by_type as $type)
																<th class="border-bottom-0">
																	{{$type->vehicle_type}}
																</th>
															@endforeach
															<th class="border-bottom-0">Jami</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															@foreach($transports_by_type as $type)
																<td>{{$type->c}}</td>
															@endforeach
															<td></td>
														</tr>
													</tbody>
												</table>
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
															<th class="border-bottom-0">Tex passport</th>
															<th class="border-bottom-0">Texnik ko'rik</th>
														</tr>
													</thead>
													<tbody>
														@foreach($transports as $transport)
															<tr>
																<td>
																	<a href="/vehicle/list/view/{{$transport->id}}">
																		<span>{{$transport->type}}</span>
																		<span>({{$transport->model}})</span>
																	</a>
																</td>
																<td>{{$transport->modelyear}}</td>
																<td>
																	@if($transport->code && $transport->series && $transport->number)
																		{{$transport->code.' '.$transport->series.$transport->number}}
																	@else
																		<span class="text-danger">
																			Berilmagan
																		</span>
																	@endif
																</td>
																<td>
																	@if($transport->passport_number && $transport->passport_series)
																		{{$transport->passport_series.$transport->passport_number}}
																	@else
																		<span class="text-danger">
																			Berilmagan
																		</span>
																	@endif
																</td>
																<td>O'tgan</td>
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
							<a href="/"><i class="fe fe-calendar mr-1"></i>&nbsp {{ trans('app.Timeline')}}
							</a>
						</li>
					</ol>
				</div>
			</div>	
			<div class="col-md-12">
				<ul class="cbp_tmtimeline">
					<?php 
					while(!empty($transport_numbers) || !empty($technical_passports)){
						$actionTime=0;
						$actionType='';
						$tN=null;
						$tP=null;

						if(!empty($transport_numbers[0])){
							$actionTime=strtotime($transport_numbers[0]->given_date);
							$actionType='transport_numbers';
						}
						if($technical_passports[0] && strtotime($technical_passports[0]->given_date)>$actionTime){
							$actionTime=$technical_passports[0]->given_date;
							$actionType='technical_passports';
						}

						switch($actionType){
							case 'transport_numbers':
								$tN=array_shift($transport_numbers);
								break;
							case 'technical_passports':
								$tP=array_shift($technical_passports);
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
											<div class="row">
												<div class="col-4">										
													<div class="customer-info-item pt-3 fs-16">
														<div class="row">
															<div class="col-12">
																<span class="customer-info-desc fw-500">
																	Texnika
																</span>
															</div>
															<div class="col-12">
																<span class="customer-info-text">
																	<a href="/vehicle/list/view/{{$tN->vehicle_id}}">
																		{{$tN->vehicle_type.' ('.$tN->model.')'}}
																	</a>
																</span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-4">										
													<div class="customer-info-item pt-3 fs-16">
														<div class="row">
															<div class="col-12">
																<span class="customer-info-desc fw-500">
																	Davlat raqami 
																</span>
															</div>
															<div class="col-12">
																<span class="customer-info-text">
																	{{$tN->code.' '.$tN->series.$tN->number}}
																</span>
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
																<span class="customer-info-text">
																	{{$tN->payment_status}}
																</span>
															</div>
														</div>
													</div>
												</div>
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
											<div class="row">
												<div class="col-3">										
													<div class="customer-info-item pt-3 fs-16">
														<div class="row">
															<div class="col-12">
																<span class="customer-info-desc fw-500">
																	Texnika
																</span>
															</div>
															<div class="col-12">
																<span class="customer-info-text">
																	<a href="/vehicle/list/view/{{$tP->vehicle_id}}">
																		{{$tP->vehicle_type.' ('.$tP->model.')'}}
																	</a>
																</span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-3">										
													<div class="customer-info-item pt-3 fs-16">
														<div class="row">
															<div class="col-12">
																<span class="customer-info-desc fw-500">
																	Davlat raqami
																</span>
															</div>
															<div class="col-12">
																<span class="customer-info-text">
																	{{$tP->number_code.' '.$tP->number_series.$tP->number_number}}
																</span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-3">										
													<div class="customer-info-item pt-3 fs-16">
														<div class="row">
															<div class="col-12">
																<span class="customer-info-desc fw-500">Tex-passport raqami </span>
															</div>
															<div class="col-12">
																<span class="customer-info-text">
																	{{$tP->series.$tP->number}}
																</span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-3">										
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
					<li>
						<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> </time>
						<div class="cbp_tmicon" style="background-color: #EB3080;">
							<img src="{{ URL::asset('resources/views/layouts/assets/images/pngs/dr-lisence.png') }}">
						</div>
						<div class="cbp_tmlabel">
							<div class="row">
								<div class="col-12"> 
									<h2 class="text-dark timeline-title border-bottom mb-0"><span>Haydovchilik guvohnomasi olish/qayta tiklash</span> </h2>
									<div class="row">
										<div class="col-4">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Shaxs passport raqami </span>
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
														<span class="customer-info-desc fw-500">Berildi/Qayta tiklandi </span>
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
							<img class="m-1" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/car-number-2.png') }}">
						</div>
						<div class="cbp_tmlabel">
							<div class="row">
								<div class="col-12"> 
									<h2 class="text-dark timeline-title border-bottom mb-0"><span>Texnikaga davlat raqami berish/qayta tiklash</span> </h2>
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
														<span class="customer-info-desc fw-500">Berildi/Qayta tiklandi </span>
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
			</div>
		</div>
	</div>
@else
	<div class="section" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
            <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
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
  
<!-- Repeat job  Service only -->
  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".repeatjobservice").click(function(){ 
	  
	  $('.modal-body').html("");
	   
       var r_service = $(this).attr("r_service");
	  
		var url = $(this).attr('url');
	      
       $.ajax({
       type: 'GET',
       url: url,
	
       data : {r_service:r_service},
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
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
		ul.bar_tabs>li.active { background:#fff !important;}

	</style>
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
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
						  <!--page conten -->
							<div class="row">
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="x_panel">
										<div id="carousel" class="carousel slide">
											<div class="carousel-inner">
											</div>
										</div>
										<div id="thumbcarousel" >
											<div class="carousel-inner-1">
											</div><!-- /carousel-inner -->
										</div> <!-- /thumbcarousel -->
									</div> 
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="x_panel">
										<span class="report_title">
											<span class="fa-stack cutomcircle">
												<i class="fa fa-align-left fa-stack-1x"></i>
											</span> 
											<span class="shiptitle" style="text-transform: capitalize;">{{ $vehicle->modelname }}</span>		
													
											<span class="shiptitleright">(<?php echo getCurrencySymbols(); ?>) {{ $vehicle->price }}</span>		
										</span>	
										<div class="col-md-12 col-sm-12 col-xs-12 member_right">					
											<div class="table_row">
												<div class="col-md-6 col-sm-6 col-xs-6 table_td">
													<b>{{ trans('app.Make :')}}</b>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6 table_td">
													<span class="txt_color">{{ $vehicle->modelname }}</span>
												</div>
											</div>					
											 <div class="table_row">
												<div class="col-md-6 col-sm-6 col-xs-6 table_td">
													<b>{{ trans('app.Vehicle Brand :')}}</b>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6 table_td">
													<span class="txt_color">{{ getVehicleBrands($vehicle->vehiclebrand_id) }}</span>
												</div>
											</div>
											<div class="table_row">
												<div class="col-md-6 col-sm-6 col-xs-6 table_td">
													<b>{{ trans('app.Engine :')}}</b>				
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6 table_td">
													<span class="txt_color"> {{ $vehicle->engine }}</span>
												</div>
											</div>
											<div class="table_row">
												<div class="col-md-6 col-sm-6 col-xs-6 table_td">
													 <b>{{ trans('app.Model Year :')}}</b>			
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6 table_td">
													<span class="txt_color">{{ $vehicle->modelyear }}</span>
												</div>
											</div>
										</div>
									</div>
								</div> 
							</div>
				<!-- end  slider -->
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="x_content">
										<ul class="nav nav-tabs bar_tabs" role="tablist" id="myTab">
											<li class="active"><a href="#tab_content1"  data-toggle="tab"></i> {{ trans('app.Basic Detail')}}</a></li>
											<li class=""><a href="#tab_content2"  data-toggle="tab" > {{ trans('app.Description')}}</a></li>
										</ul>
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="x_panel">
														<div class="tab-content">
															@if(!empty($desription))
															   <div  class="tab-pane fade " id="tab_content2" style="min-height: 320px;" >
																	<div class="row">
																	   @foreach($desription as $desriptions)
																			<div class="col-md-12 col-sm-12 col-xs-12">
																				{{ $desriptions->vehicle_description }}
																			</div>
																	   @endforeach
																	</div>
																</div>
															@endif
															<div  class="tab-pane fade active in" id="tab_content1" >
																<div class="col-md-12 col-sm-12 col-xs-12">
																	<span class="report_title">
																		<span class="fa-stack cutomcircle">
																			<i class="fa fa-align-left fa-stack-1x"></i>
																		</span> 
																		<span class="shiptitle">{{ trans('app.Basic Details')}}</span>
																	</span>
																		<div class="col-md-5 col-sm-12 col-xs-12 member_right" style="border: 1px solid #dedede; margin-left:9px;">
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<b>{{ trans('app.Vehicle Name :')}}</b>
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color"> {{ $vehicle->modelname }}</span>
																				</div>
																			</div>					
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<b>{{ trans('app.Vehicle Type')}} :</b>
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color"> {{ getVehicleType($vehicle->vehicletype_id) }}</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					  <b>{{ trans('app.Chasic No :')}}</b>				
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color"> {{ $vehicle->chassisno}}</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					 <b>{{ trans('app.Fuel type :')}}</b>			
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color">{{ getFuelType($vehicle->fuel_id) }} </span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					 <b>{{ trans('app.No of Gears:')}}</b>							
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color"> {{ $vehicle->nogears }}</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					 <b>{{ trans('app.Odometer Reading  :')}}</b>			
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color"> {{$vehicle->odometerreading }}</span>
																				</div>
																			</div>
																		</div> 
																		<div class="col-md-5 col-sm-12 col-xs-12 member_right" >
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					 <b>{{ trans('app.Date Of Manufacturing:')}}</b>
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color"> {{ date(getDateFormat(),strtotime($vehicle->dom)) }}</span>
																				</div>
																			</div>					
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<b>{{ trans('app.Gear Box:')}}</b>
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color"> {{ $vehicle->gearbox }}</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					  <b>{{ trans('app.Gear Box No :')}}</b>			
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color">{{ $vehicle->gearboxno }}</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<b>{{ trans('app.Engine No:')}}</b>			
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color">{{ $vehicle->engineno }}</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					 <b>{{ trans('app.Engine Size:')}}</b>							
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color"> {{ $vehicle->enginesize }}</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					  <b>{{ trans('app.Key No :')}}</b>			
																				</div>
																				<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																					<span class="txt_color"> {{ $vehicle->keyno }}</span>
																				</div>
																			</div>
																		</div> 
																</div>
															</div>
														</div>
												   </div>
												</div>
											</div>
									</div> 
								</div>
							</div>
						</div>
					</div>
				</div> 
		</div>
	@else
		<div class="right_col" role="main">
			<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
	              <div class="nav toggle" style="padding-bottom:16px;">
	               <span class="titleup">&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
	              </div>
	        </div>
		</div>
	@endif   
			
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
@endsection
@extends('layouts.app')
@section('content')
<style type='text/css'>
  .ui-datepicker-calendar,.ui-datepicker-month { display: none; }​
  .box_result{
  	display: none;
  }
  .result li{
  	cursor: pointer;
  	padding: 5px 0;
  }
  .result {
  	padding-left: 20px;	
  }
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Vehicles',$userid)=='yes')
	@if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')
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
						<div class="col-md-12 col-sm-12 col-12">
							<div class="alert alert-success checkbox-circle">
								<div class="row">
									<div class="col-12 m-2">
										<label class="form-label" for="checkbox-10 colo_success"> {{trans('app.Texnika qo\'shildi')}}
										</label>
									</div>
									<div class="col-12 m-2">
										<a target="_blank" class="btn btn-success" style="width: 30%" href="{!! url('vehicle/transport-number') !!}?vehicle_id={!! session('vehicle_id') !!}"> 
											{{ trans('app.Davlat raqamini berish') }}
										</a>
									</div>
									<div class="col-12 m-2">
										<a target="_blank" class="btn btn-primary" style="width: 30%" href="{{ url('certificate/add') }}?vehicle_id={!! session('vehicle_id') !!}">
											{{ trans('app.Texnik Passport/Guvohnoma berish') }}
										</a>
									</div>
									<div class="col-12 m-2">
										<a target="_blank" class="btn btn-success" style="width: 30%" href="{{ url('certificate/medadd') }}?vehicle_id={!! session('vehicle_id') !!}">
											{{ trans('app.Texnikani texnik ko\'rikdan o\'tkazish') }}
										</a> 
									</div>
									<div class="col-12 m-2">
										<a target="_blank" class="btn btn-primary" style="width: 30%" href="{{ url('vehicle/add') }}">
											<i class="fa fa-plus-circle"></i>
											{{ trans('app.Texnika qo\'shish') }}
										</a>
									</div>
									<div class="col-12 m-2">
										<a target="_blank" class="btn btn-primary" style="width: 30%" href="{{ url('vehicle/list') }}">
											<span class="visible-xs"></span>
											<i class="fa fa-list fa-lg">&nbsp;</i>
											{{ trans('app.Vehicle List')}}
										</a>
									</div>  
							</div>
						</div>
					</div>
				@else
					<div class="row">
						<div class="col-md-12">
							<div class="card">									
								<div class="card-body p-6">
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
													<a href="{!! url('/vehicle/add')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
														{{ trans('app.Add Vehicle')}}</b>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<form  action="{{ url('/vehicle/store') }}" method="post" id="vehicle_add" enctype="multipart/form-data" >
												<div class="row">
													
													<input type="hidden" name="_token" value="{{csrf_token()}}">

													<div class="col-md-6">

														<label class="form-label" style="visibility: hidden;">

															Texnika egasi</label>

														<div class="row">

															<div class="col-6 pr-0">

																
																	<div class="customer-type-button py-2" val='agregat'>

																		Agregat

																	</div>

															</div>

															<div class="col-6 pl-0">

																	<div class="customer-type-button py-2" val='vehicle'>

																		O'ziyurar

																	</div>

															</div>

														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">											
															<label class="form-label" for="first-name">{{ trans('app.Owner name')}}
															<label class="text-danger">*</label></label>
															<select class="form-control owner_search select-owner" required name="owner_id">
																@if(!empty($owner))
																	<option value="{{ $owner->id }}" selected="selected">{{ $owner->name }}</option>
																@endif
															</select>															
														</div>
													</div>	
													<div class="col-12 col-md-6 self">
														<div class="form-group">											
															<label class="form-label" for="">{{ trans('app.Category')}}
															<label class="text-danger">*</label></label>
															<select class="form-control owner_category" required name="category">
																@if(!empty($categories))
																	@foreach($categories as $category)
																		<option value="{{ $category->id }}">{{ $category->name }}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>	
													<div class="col-md-6 self name">
														<div class="form-group">
															<label class="form-label" for="first-name">
																{{ trans('app.Vehicle Brand')}} 
																<label class="text-danger">*</label>
															</label>
															<div class="row">
																<div class="col-9">
																	<select required class="form-control brand_search" name="brand_id" ></select>
																</div>
																<div class="col-3 addremove">
																	<button type="button" class="btn btn-success" data-target="#responsive-modal-brand" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
																</div>
															</div>
														</div>
													</div>											
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label" for="factory-name">{{ trans('app.Factory name')}}
																<label class="text-danger">*</label></label>
															<div class="row">
																<div class="col-9">
																	<select required class="form-control factory_search" name="factory_id"></select>
																</div>
																<div class="col-3 addremove">
																	<button type="button" class="btn btn-success" data-target="#responsive-modal-factory" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Yetkazib beruvchi')}}
																<label class="text-danger">*</label></label>
															<select name="supplier"  type="text" placeholder="{{ trans('app.Yetkazib berivchini kiriting')}}" class="form-control diller" >
																@if(!empty($suppliers))
																	@foreach($suppliers as $supplier)
																		<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>													
													<div class="col-md-6 self">
														<div class="form-group overflow-hidden">
															<label class="form-label" for="first-name">
																{{ trans('app.Vehicle Type')}} 
																<label class="text-danger">
																	*
																</label>
															</label>
															<select id="vehicletype" required class="form-control type_search w-100" disabled   name="type_name"></select>
															<input id="type_id" required type="hidden" class="form-control" name="type_id" >
														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label" for="first-name">{{ trans('app.Select Condition')}}
																<label class="text-danger">*</label> </label>
															<select class="form-control condition select2" name="condition">
																<option value="fit">{{ trans('app.fit')}}</option>
																<option value="unfit">{{trans('app.unfit')}}</option>
															</select> 
														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label" >{{ trans('app.Working Type')}}
																<label class="text-danger">*</label></label>
															<select id="workingtype" required class="form-control workingtypeselect" disabled name="name"></select>
															<input id="working_id" required type="hidden" class="form-control" name="working_id" >
														</div>

													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label" for="modelyear">{{ trans('app.Model Years')}}
																<label class="text-danger">*</label></label>
															<div class="input-group">
																<div class="input-group-prepend">
																	<div class="input-group-text">
																		<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																	</div>
																</div>
																<input required id="myDatepicker2" class="form-control fc-datepicker" name="modelyear" placeholder="yyyy">
															</div>
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Enter Factory number')}}</label>
															<input type="text" class="form-control" name="factory_number">	
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Chasic No')}}
															<label class="text-danger"> *</label></label>
															<input type="text"  name="chasicno"  value="{{ old('chasicno') }}" placeholder="{{ trans('app.Enter ChasicNo')}}" class="form-control" >
														</div>
													</div>
													<div class="col-md-3 agregat">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Kuzov No')}}
																<label class="text-danger">*</label></label>
															<input type="text"  name="corpusno"  value="{{ old('engineno') }}" placeholder="{{ trans('app.Enter Engine No')}}" maxlength="30" class="form-control" >
														</div>
													</div>
													<div class="col-md-3 agregat">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Engine No')}}
																<label class="text-danger">*</label></label>
															<input required type="text"  name="engineno"  value="{{ old('engineno') }}" placeholder="{{ trans('app.Enter Engine No')}}" maxlength="30" class="form-control" >
														</div>
													</div>
													<div class="col-md-3 agregat">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Dvigatel quvvati')}}
																<label class="text-danger">*</label></label>
															<input required name="enginesize" type="text" placeholder="{{ trans('app.Dvigatel quvvatini kiriting')}}" maxlength="30" class="form-control" >
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.To\'la vazni')}}
																<label class="text-danger">*</label></label>
															<input name="weight_full" required type="text" placeholder="{{ trans('app.Texnika to\'la vaznini kiriting')}}" maxlength="30" class="form-control" >
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Yuksiz vazni')}}
																<label class="text-danger">*</label></label>
															<input name="weight" required type="text" placeholder="{{ trans('app.Texnika yuksiz vaznini kiriting')}}" maxlength="30" class="form-control" >
														</div>
													</div>
													<div class="col-md-3 agregat">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Yonilg\'i turi')}}
																<label class="text-danger">*</label></label>
															<select name="fuel"  type="text" placeholder="{{ trans('app.Texnika yonilg\'i turini kiriting')}}" class="form-control fuel-type" >
																@if(!empty($fuels))
																	@foreach($fuels as $fuel)
																		<option value="{{ $fuel->id }}">{{ $fuel->fuel_type }}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Select Colors')}}
																<label class="text-danger">*</label></label>
															<select required class="form-control" name="color">
																@if(!empty($colors))
																	@foreach($colors as $color)
																		<option value="{{ $color->id }}">{{ $color->color }}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label" style="visibility: hidden;">label</label>
															<label class="custom-switch">
																<input id="lising" type="checkbox" name="lising" class="custom-switch-input">
																<input type="hidden" name="lising_id" id="lising_id" value="0">
																<input type="hidden" name="vehicle_type_id" id="vehicle_type_id">
																<span class="custom-switch-indicator"></span>
																<span class="custom-switch-description">{{ trans('app.Lizing')}}</span>
															</label>
														</div>
													</div>													
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label" style="visibility: hidden;">label</label>
															<button id="formsubmitbutton" class="btn btn-success">{{ trans('app.Saqlash')}}</button>
															<input id="formsubmit" type="submit" class="btn btn-success" value="{{ trans('app.Saqlash')}}" style="display: none;">
														</div>
													</div>												
												</div>
											</form>
										
										</div>	
												<!-- Vehicle type -->
										<div class="col-md-6">
											<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="example-Modal3">{{ trans('app.Add Vehicle Type')}}</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
														    <form class="form-horizontal formaction" action="" method="">
																<table class="table card-table table-vcenter text-nowrap vehical_type_class"  align="center">
																<div class="form-group data_popup">
																	<label class="form-label">{{ trans('app.Vehicle Type:')}} <span class="text-danger">*</span></label>
																	<div class="row">
																		<div class="col-10">
																			<input type="text" class="form-control vehical_type" name="vehical_type" id="vehical_type" placeholder="{{ trans('app.Enter Vehicle Type')}}" maxlength="20" required />
																		</div>
																		<div class="col-2 data_popup">																	
																			<button type="button" class="btn btn-success vehicaltypeadd" 
																			url="{!! url('/vehicle/vehicle_type_add') !!}" >{{ trans('app.Qo\'shish')}}</button>
																		</div>
																	</div>
																</div>
																	<thead>
																		<tr>
																			<td class="text-center"><strong>{{ trans('app.Vehicle Type')}}</strong></td>
																			<td class="text-right"><strong>{{ trans('app.Action')}}</strong></td>
																		</tr>
																	</thead>
																	<tbody>
																		@if(!empty($vehical_type))
																			@foreach ($vehical_type as $vehical_types)
																				<tr class="del-{{ $vehical_types->id }}">
																					<td class="text-center ">{{ $vehical_types->vehicle_type }}</td>
																					<td class="text-right">
																						<button type="button" vehicletypeid="{{ $vehical_types->id }}" 
																						deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletevehicletype"><i class="fe fe-trash-2"></i></button>
																					</td>
																				</tr>
																			@endforeach
																		@endif
																	</tbody>
																</table>
															</form>
														</div>
													</div>
												</div>	
											</div>
										</div>
												<!-- End  Vehicle Type  -->
												<!-- Vehicle working type -->
										<div class="col-md-6">
											<div id="responsive-modal-working" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="example-Modal3">{{ trans('app.Add working type')}}</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</i></span>
															</button>
														</div>
														<div class="modal-body">
														    <form class="form-horizontal formaction" action="" method="">
																<table class="table card-table table-vcenter text-nowrap vehical_type_class"  align="center">
																	<thead>
																		<tr>
																			<td class="text-center"><strong>{{ trans('app.Vehicle Type')}}</strong></td>
																			<td class="text-right"><strong>{{ trans('app.Action')}}</strong></td>
																		</tr>
																	</thead>
																	<tbody>
																		@if(!empty($working_types))
																		@foreach ($working_types as $working_type)
																		<tr class="del-{{ $working_type->id }}">
																			<td class="text-center ">
																				{{ $working_type->name }}</td>
																			<td class="text-right">
																				<button type="button" vehicleworkid="{{ $working_type->id }}" deletevehicalwork="{!! url('/vehicle/vehicalworkdelete') !!}" class="btn btn-danger btn-xs deletevehiclework">
																					<i class="fe fe-trash-2"></i>
																				</button>
																			</td>
																		</tr>
																		@endforeach
																		@endif
																	</tbody>
																</table>
																<div class="form-group data_popup">
																	<label class="form-label">{{ trans('app.Add working type')}} <span class="text-danger">*</span></label>
																	<div class="row">
																		<div class="col-10">
																	<input type="text" class="form-control vehicle_working" name="vehical_working" id="vehical_working" placeholder="{{ trans('app.Enter working type')}}" maxlength="20" required />
																</div>
																<div class="col-2 form-group data_popup">
																	
																	<button type="button" class="btn btn-success vehicalworkadd" 
																	url="{!! url('/vehicle/vehicle_working_add') !!}" >{{ trans('app.Qo\'shish')}}</button>
																</div>
															</div>
															</form>
														</div>
													</div>
												</div>	
											</div>
										</div>
												<!-- End  Vehicle working Type  -->
								
												<!-- Vehicle Brand -->
										<div class="col-md-6">
											<div id="responsive-modal-brand" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="example-Modal3">{{ trans('app.Add Vehicle Brand')}}</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
														    <form class="form-horizontal" action="" method="">
																<div class="row">
																	<div class="col-12 col-md-6 form-group data_popup">
																		<label class="form-label">{{ trans('app.Vehicle Type:')}} <span class="text-danger">*</span></label>
																		<select class="form-control vehical_brand_select vehical_id" name="vehical_id" vehicalurl="{!! url('/vehicle/vehicalformtype') !!}" required style="width: 100% !important">
																			<option>{{ trans('app.Select Vehicle Type')}}</option>
																				 @if(!empty($vehical_type))
																					@foreach($vehical_type as $vehical_types)
																						<option value="{{ $vehical_types->id }}">{{ $vehical_types->vehicle_type }}</option>
																					@endforeach
																				@endif
																		</select> 
																	</div>
																	<div class="col-12 col-md-6 form-group data_popup">
																		<label class="form-label">{{ trans('app.Vehicle Brand:')}} <span class="text-danger">*</span></label>
																		<input type="text" class="form-control vehical_brand" name="vehical_brand" id="vehical_brand" placeholder="{{ trans('app.Enter Vehicle brand')}}" maxlength="25" required />
																	</div>
																	<div class="col-12 col-md-6 form-group data_popup">
																		<label class="form-label">{{ trans('app.Working Type')}}: <span class="text-danger">*</span></label>
																		<select class="form-control vehical_working_type working_search" id="brandtype_id"  required style="width: 100% !important">
																			<option>{{ trans('app.Select Working Type')}}</option>
																		</select> 
																	</div>
																	<div class="col-12 col-md-6 form-group data_popup text-left">	
																		<label class="form-label" style="visibility: hidden;">button</label>				
																		<button type="button" class="btn btn-success vehicalbrandadd" 
																		vehiclebrandurl="{!! url('/vehicle/vehicle_brand_add') !!}">{{ trans('app.Qo\'shish')}}</button>
																	</div>
																</div>
																<table class="table card-table table-vcenter text-nowrap vehical_brand_class"  align="center">
																	<thead>
																		<tr>
																			<td class="text-center"><strong>{{ trans('app.Vehicle Brand')}}</strong></td>
																			<td class="text-right"><strong>{{ trans('app.Action')}}</strong></td>
																		</tr>
																	</thead>
																	<tbody>
																		@if(!empty($vehical_brand))
																		@foreach ($vehical_brand as $vehical_brands)
																		<tr class="del-{{ $vehical_brands->id}}" >
																		<td class="text-center ">{{ $vehical_brands->vehicle_brand }}</td>
																		<td class="text-right">
																		
																		<button type="button" brandid="{{ $vehical_brands->id }}" 
																		deletevehicalbrand="{!! url('/vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands"><i class="fe fe-trash-2"></i></button>
																		</td>
																		</tr>
																		@endforeach
																		@endif
																	</tbody>
																</table>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
												<!-- End Vehicle Brand --->	
							
												<!-- Factory -->	
										<div class="col-md-6">
											<div id="responsive-modal-factory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="example-Modal3">{{ trans('app.Add Factory')}}</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
														    <form class="form-horizontal" action="" method="post">
																<table class="table card-table table-vcenter text-nowrap factory_class"  align="center">
																	<thead>
																		<tr>
																			<td class="text-center"><strong>{{ trans('app.Factory name')}}</strong></td>
																			<td class="text-right"><strong>{{ trans('app.Action')}}</strong></td>
																		</tr>
																	</thead>
																	<tbody>
																		@if(!empty($factory_names))
																		@foreach ($factory_names as $factory_name)
																		<tr class="del-{{ $factory_name->id }} data_of_type" >
																		<td class="text-center ">{{ $factory_name->name }}</td>
																		<td class="text-right">
																		
																		<button type="button" factoryid="{{ $factory_name->id }}" 
																		deletefactory="{!! url('/vehicle/factorydelete') !!}" class="btn btn-danger btn-xs factorydeletes"><i class="fe fe-trash-2"></i></button>
																		</td>
																		</tr>
																		@endforeach
																		@endif
																	</tbody>
																</table>
																<div class="form-group data_popup">
																	<label class="form-label">{{ trans('app.Factory name')}}: <span class="text-danger">*</span></label>
																	<div class="row">
																		<div class="col-12 col-md-10">
																			<input type="text" class="form-control factory" name="factory_name" id="factory_name" placeholder="{{ trans('app.Enter factory name')}}" maxlength="20" required />
																			</div>
																		<div class="col-2 form-group data_popup">							
																			<button type="button" class="btn btn-success factoryadd"  
																			factoryurl="{!! url('/vehicle/factory_add') !!}">{{ trans('app.Submit')}}</button>
																		</div>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>	
											</div>
										</div>
												<!-- end Fuel Type -->	

												<!-- Model Name -->
										<div class="col-md-6">
											<div id="responsive-modal-vehi-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="example-Modal3">{{ trans('app.Add Factory')}}</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<form class="form-horizontal" action="" method="post">
																<table class="table card-table table-vcenter text-nowrap vehi_model_class"  align="center">
																	<thead>
																		<tr>
																			<td class="text-center"><strong>{{ trans('app.Model Name')}}</strong></td>
																			<td class="text-right"><strong>{{ trans('app.Action')}}</strong></td>
																		</tr>
																	</thead>
																	<tbody>
															
																		@if(!empty($model_name))
																		@foreach ($model_name as $model_names)
																		<tr class="mod-{{ $model_names->id }}" >
																		<td class="text-center ">{{ $model_names->model_name }}</td>
																		<td class="text-right">
																		
																		<button type="button" modelid="{{ $model_names->id }}" 
																		deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes"><i class="fe fe-trash-2"></i></button>
																		</td>
																		</tr>
																		@endforeach
																		@endif
																	</tbody>
																</table>
																<div class="form-group data_popup">
																	<label class="form-label">{{ trans('app.Model Name :')}} <span class="text-danger">*</span></label>
																	<div class="row">
																		<div class="col-10">
																			<input type="text" class="form-control vehi_modal_name" name="model_name" id="model_name" placeholder="{{ trans('app.Enter Model Name')}}" maxlength="20" required />
																		</div>
																		<div class="col-2 data_popup">
																			
																			<button type="button" class="btn btn-success vehi_model_add"  
																			modelurl="{!! url('/vehicle/vehicle_model_add') !!}">{{ trans('app.Submit')}}</button>
																		</div>
																	</div>	
																</div>
															</form>
														</div>
													</div>
												</div>	
											</div>
										</div>
												<!-- End Model Name -->
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
				
	@else
		<div class="right_col" role="main" style="background-color: #e6e6e6;">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle titleup">
							<span>&nbsp {{ trans('app.You are not authorize this page.')}}</span>
						</div>
					</nav>
				</div>
			</div>
		</div>
	@endif
 @else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
            <div class="nav toggle" style="padding-bottom:16px;">
				<span class="titleup">&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
            </div>
        </div>
	</div>
	
@endif   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $('#myDatepicker2').datetimepicker({
       format: "yyyy",
		autoclose: 2,
		minView: 4,
		startView: 4,
		endDate: new Date()
		
    });
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('select.vehical_brand_select').select2();
		$('select.vehical_brand_select').change(function(){
			var type = $(this).val();
			var url = '/selecttype'
			$.ajax({
				type:'GET',
				url:url,
				data:'id='+type,
				success:function(data){
					$('#brandtype_id').html(data);
				}
			});
		});
		$('select.working_search').select2();
		
	});

	$(document).ready(function(){
		$('#formsubmitbutton').on('click', function(){
			var type = $("#vehicletype").val();
			var work = $("#workingtype").val();
			var lising = $("#lising").is(":checked");
			if(lising){
				$("#lising_id").val('1');
			}else{
				$("#lising_id").val('0');
			}

			if(type==null || work==null){
				alert('hi'+$('#lising_id').val()+'ki');
			}else{
				$("#formsubmit").trigger('click');
			}
		})
		
	});
</script>
<!-- vehicle type -->
<script>
    $(document).ready(function(){
    	$('select.select-owner').select2({

			ajax:{

				url:'/customer/search',

				delay:300,

				dataType:'json',

				data:function(params){

					return{

						search:params.term

					}

				},

				processResults:function(data){

					console.log(data);

					data=data.map((item,index)=>{
						var ownershipForm='('+item.ownership_form+')';
						if(item.type=='physical'){
							ownershipForm='';
						}

						return {
							id:item.id,
							text:item.name+' '+(item.lastname?item.lastname:'')+ownershipForm
						}

					});

					return{

						results:data

					}

				}

			},

			placeholder:'Texnika egasini kiriting',

			minimumInputLength:1,

			escapeMarkup: function (markup) { return markup; },

			language:{

				inputTooShort:function(){

					return 'Mulk egasini nomi,INN raqami,STIR kiritib izlang';

				},

				searching:function(){

					return 'Izlanmoqda...';

				},

				noResults:function(){

					return "Natija topilmadi"

				}

			}

		});

    	$('select.owner_category').select2({
			placeholder:'Texnika tanlang',
    		minimumResultsForSearch: Infinity
    	});

    	$('select.workingtypeselect').select2({
    		placeholder: "Ish turini tanlang"
    	});

    	$('select.condition').select2({
			minimumResultsForSearch: Infinity});

    	$('select.vehical_brand_select').select2({
			minimumResultsForSearch: Infinity});

   		$('select.vehical_working_type').select2({
		 minimumResultsForSearch: Infinity});

   		$('select.fuel-type').select2({
   			placeholder: "Yonilg'i turini tanlang",
   			minimumResultsForSearch: Infinity
   		});

   		$('select.diller').select2({
   			minimumResultsForSearch: Infinity
   		});

	    $('select.type_search').select2({
			ajax:{
				url:'type_search_name',
				delay:300,
				dataType:'json',
				data:function(params){
					return{
						search:params.term
					}
				},
				processResults:function(data){
					data=data.map((name,index)=>{
						return {
							id:name.id,
							text:name.name
						}
					});
					return{
						results:data
					}
				}
			},
			placeholder:'Texnika turini kiriting',
			minimumInputLength:2
		});
		$('select.brand_search').select2({
			ajax:{
				url:'brand_search_name',
				delay:300,
				dataType:'json',
				data:function(params){
					return{
						search:params.term
					}
				},
				processResults:function(data){
					data=data.map((name,index)=>{
						return {
							id:name.id,
							text:name.name
						}
					});
					return{
						results:data
					}
				}
			},
			placeholder:'Texnika brandini kiriting',
			minimumInputLength:2
		});
		$('select.factory_search').select2({
			ajax:{
				url:'factory_search_name',
				delay:300,
				dataType:'json',
				data:function(params){
					return{
						search:params.term
					}
				},
				processResults:function(data){
					data=data.map((name,index)=>{
						return {
							id:name.id,
							text:name.name
						}
					});
					return{
						results:data
					}
				}
			},
			placeholder:'Zavod nomini kiriting',
			minimumInputLength:2
		});
		
		$('select.owner_search').select2({
			ajax:{
				url:'owner_search_name',
				delay:300,
				dataType:'json',
				data:function(params){
					return{
						search:params.term
					}
				},
				processResults:function(data){
					data=data.map((name,index)=>{
						return {
							id:name.id,
							text:name.name+' '+(name.lastname?name.lastname:'')+' '+(name.middlename?name.middlename:'')
						}
					});
					return{
						results:data
					}
				}
			},
			placeholder:'Texnika egasini kiriting',
			minimumInputLength:2
		});
		
		$('.vehicaltypeadd').click(function(){
				
			var vehical_type= $('.vehical_type').val();
			var url = $(this).attr('url');
	        if(vehical_type == ""){
	            swal('Please Enter Vehicle Type!');
	        }else{ 
				$.ajax({
						type:'GET',
						url:url,
						data :{vehical_type:vehical_type},

				   	success:function(data)
				   	{
					   
					   var newd = $.trim(data);
					   
					   var classname = 'del-'+newd;
					   
					  
					   
					   if (newd == '01')
					   {
						   swal('Duplicate Data !!! Please try Another...');
					   }
					   else
					   {
					   $('.vehical_type_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_type+'</td><td class="text-right"><button type="button" vehicletypeid='+data+' deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletevehicletype"><i class="fe fe-trash-2"></i></button></a></td><tr>');
					   
						$('.select_vehicaltype').append('<option value='+data+'>'+vehical_type+'</option>');
						$('.vehical_type').val('');
						
						$('.vehical_id').append('<option value='+data+'>'+vehical_type+'</option>');
						$('.vehical_type').val('');
					   }
					   
				   	},
			   
		 		});
			}
		});

		$('select.brand_search').change(function(){
			var id = $(this).val();
			$.ajax({
				type:'GET',
				url:'vehiclebrandselect',
				data:'brand='+id,
				success:function(data){
					var fdata = $.parseJSON(data);
					$("#vehicletype").html('<option selected="selected" value="'+fdata.type_id+'">'+fdata.type+'</option>');
					$("#workingtype").html('<option selected="selected" value="'+fdata.working_id+'">'+fdata.working+'</option>');
					$("#working_id").val(fdata.working_id);
					$("#type_id").val(fdata.type_id);
					
				}
			});
		});

		$('input[name="engineno"], input[name="chasicno"], input[name="corpusno"').change(function(){
			var engineno=$('input[name="engineno"]').val();
			var chasicno=$('input[name="chasicno"]').val();
			var corpusno=$('input[name="corpusno"]').val();

			if(engineno){
				$.ajax({
					type:'GET',
					url:'/certificate/check-engineno',
					data: 'engineno='+engineno+'&type=engine',

					success:function(data){
						var fdata = $.parseJSON(data);
						console.log(fdata);
						
						if(fdata.type == 'exist'){
							
							swal({
								title: "{{ trans('app.Kritilgan Dvigatel raqami mavjud!') }}",
					            type: "warning",
					            showCancelButton: true,
					            cancelButtonText: "Boshqa raqam kiritish",
					            confirmButtonColor: "#DD6B55",
					            confirmButtonText: "Texnikani ko'rish",
					            closeOnConfirm: true
							},function(isConfirm){
								if (isConfirm) {
									window.location.pathname = "{!! url('/vehicle/list/view') !!}/"+fdata.vehicle_id;
								} else {
									$('input[name=engineno]').val("");									
								}

							});
						}



					}

				});

			}
			if(chasicno){
				console.log('checking');
				$.ajax({
					type:'GET',
					url:'/certificate/check-engineno',
					data: 'chasicno='+chasicno+'&type=chasic',

					success:function(data){
						var fdata = $.parseJSON(data);
						console.log(fdata);

						if(fdata.type == 'exist'){
							
							swal({
								title: "{{ trans('app.Kritilgan shassi raqami mavjud!') }}",
					            type: "warning",
					            showCancelButton: true,
					            cancelButtonText: "Boshqa raqam kiritish",
					            confirmButtonColor: "#DD6B55",
					            confirmButtonText: "Texnikani ko'rish",
					            closeOnConfirm: true
							},function(isConfirm){
								if (isConfirm) {
									window.location.pathname = ""
								} else {
									$('input[name=chasicno]').val("");									
								};

							});
						}



					},

					error:function(err){

						console.log(err);

					}

				});

			}
			if(corpusno){
				console.log('checking');
				$.ajax({
					type:'GET',
					url:'/certificate/check-engineno',
					data: 'corpusno='+corpusno+'&type=corpus',

					success:function(data){
						var fdata = $.parseJSON(data);
						console.log(fdata);

						if(fdata.type == 'exist'){
							

							swal({
								title: "{{ trans('app.Kritilgan kuzov raqami mavjud!') }}",
					            type: "warning",
					            showCancelButton: true,
					            cancelButtonText: "Boshqa raqam kiritish",
					            confirmButtonColor: "#DD6B55",
					            confirmButtonText: "Texnikani ko'rish",
					            closeOnConfirm: true
							}).then((isConfirm) =>{
								if (isConfirm) {
									window.location.pathname = "/"
								} else {
									$('input[name=corpusno]').val("");
									$('input[name=corpusno]').focus();									
								};

							});
						}



					},

					error:function(err){

						console.log(err);

					}

				});

			}
		});


	});
</script>
<!-- vehicle work type -->
<script>
    $(document).ready(function(){
		
		$('.vehicalworkadd').click(function(){
			
			var vehical_working= $('.vehicle_working').val();
			var url = $(this).attr('url');
	        if(vehical_working == ""){
	            swal('Please Enter Vehicle Type!');
	        }else{ 
				$.ajax({
					type:'GET',
					url:url,

		   			data :{vehical_working:vehical_working},

			   		success:function(data)
			   		{
				   
					   var newd = $.trim(data);
					   
					   var classname = 'del-'+newd;
				   
				  
				   
					   if (newd == '01')
					   {
						   swal('Duplicate Data !!! Please try Another...');
					   }
					   else
					   {
					   $('.vehical_type_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_working+'</td><td class="text-right"><button type="button" vehicleworkid='+data+' deletevehicalwork="{!! url('/vehicle/vehicalworkdelete') !!}" class="btn btn-danger btn-xs deletevehiclework"><i class="fe fe-trash-2"></i></button></a></td><tr>');
					   
						$('.select_vehicalwork').append('<option value='+data+'>'+vehical_working+'</option>');
						$('.vehical_working').val('');
						
						$('.vehical_id').append('<option value='+data+'>'+vehical_working+'</option>');
						$('.vehical_working').val('');
					   }
				   
			   		},
			   
		 		});
			}
		});
	});
</script>
<!-- vehical Type delete-->
<script>
	$(document).ready(function(){
		
		$('body').on('click','.deletevehicletype',function(){
			
			var vtypeid = $(this).attr('vehicletypeid');
			
			var url = $(this).attr('deletevehical');
			
			swal({
			     title: "Are you sure?",
	            text: "You will not be able to recover this imaginary file!",
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes, delete it!",
	            closeOnConfirm: false
	        },
	         function(isConfirm){
					if (isConfirm) {
						$.ajax({
								type:'GET',
								url:url,
								data:{vtypeid:vtypeid},
								success:function(data){
			
									$('.del-'+vtypeid).remove();
									$(".select_vehicaltype option[value="+vtypeid+"]").remove();
									swal("Done!","It was succesfully deleted!","success");
						}
						});
					}else{
							swal("Cancelled", "Your imaginary file is safe :)", "error");
							} 
					})
		
			});
	});
</script>
<!-- vehical work Type delete-->
<script>
	$(document).ready(function(){
		
		$('body').on('click','.deletevehiclework',function(){
			
			var vworkid = $(this).attr('vehicleworkid');
			
			var url = $(this).attr('deletevehicalwork');
			
			swal({
			     title: "Are you sure?",
	            text: "You will not be able to recover this imaginary file!",
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes, delete it!",
	            closeOnConfirm: false
	        },
	         function(isConfirm){
					if (isConfirm) {
						$.ajax({
								type:'GET',
								url:url,
								data:{vworkid:vworkid},
								success:function(data){
			
									$('.del-'+vworkid).remove();
									$(".select_vehicalwork option[value="+vworkid+"]").remove();
									swal("Done!","It was succesfully deleted!","success");
						}
						});
					}else{
							swal("Cancelled", "Your imaginary file is safe :)", "error");
							} 
					})
		
			});
	});
</script>
<!-- vehical brand -->


<script>
    $(document).ready(function(){
		
		 $('.vehicalbrandadd').click(function(){
			 
		
        var vehical_id = $('.vehical_id').val();
		var vehical_brand= $('.vehical_brand').val();
		var url = $(this).attr('vehiclebrandurl');
		if(vehical_id == 'Select Vehicle Type'){
            swal('Please Enter Vehicle Type!');
        }
		else if(vehical_brand =='')
		{
			swal('Please Enter Vehicle Brand!');
		}
		else{ 
			$.ajax({
			   type:'GET',
			   url:url,
             
			   data :{vehical_id:vehical_id,
			         vehical_brand:vehical_brand
			   },

			   success:function(data)
               
               { 
			       var newd = $.trim(data);
				   var classname = 'del-'+newd;
                  
			    if (newd == "01")
			       {
			 	     swal('Duplicate Data !!! Please try Another...');
				   }
				   else
				   {
				   	 
					   $('.vehical_brand_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_brand+'</td><td class="text-right"><button type="button" brandid='+data+' deletevehicalbrand="{!! url('vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands"><i class="fe fe-trash-2"></i></button></a></td><tr>');
						$('.select_vehicalbrand').append('<option value='+data+'>'+vehical_brand+'</option>');
						$('.vehical_brand').val('');
					}
			     
			   },
			   
		 });
		}
		});
	});
</script>

<!-- vehical brand delete-->

	<script>
	$(document).ready(function(){
		$('body').on('click','.deletevehiclebrands',function(){
			
		var vbrandid = $(this).attr('brandid');
		var url = $(this).attr('deletevehicalbrand');
		swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {  
				$.ajax({
						type:'GET',
						url:url,
						data:{vbrandid:vbrandid},
						success:function(data){
							 $('.del-'+vbrandid).remove();
							 $(".select_vehicalbrand option[value="+vbrandid+"]").remove();
							swal("Done!","It was succesfully deleted!","success");
						}
					});
				}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
					} 
				})
	});
	});
	</script>

<!-- factory type -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
		
		 $('.factoryadd').click(function(){
			 
		 var factory= $('.factory').val();

		 var url = $(this).attr('factoryurl');
        if(factory == ""){
            swal('Please Factory name!');
        }else{  
			$.ajax({
			   type:'GET',
			   url:url,

			   data :{factory_name:factory},
			   success:function(data)
			   {
				    
			       var newd = $.trim(data);
				   var classname = 'del-'+newd;
				   
				   if(newd == '01')
				   {
					   swal('Duplicate Data !!! Please try Another...');
				   }
				   else
				   {
				    $('.factory_class').append('<tr class="'+classname+'"><td class="text-center">'+factory+'</td><td class="text-right"><button type="button" fuelid='+data+' deletefactory="{!! url('/vehicle/fueltypedelete') !!}" class="btn btn-danger btn-xs factorydeletes"><i class="fe fe-trash-2"></i></button></a></td><tr>');
					$('.select_fueltype').append('<option value='+data+'>'+name+'</option>');
					$('.fuel_type').val('');
				   }
			     
			   },
			   
			});
		}
		});
	});
</script>

<!-- factory delete-->

<script>
	$(document).ready(function(){
	
	$('body').on('click','.factorydeletes',function(){
   
	
		var factoryid = $(this).attr('factoryid');
		var url = $(this).attr('deletefactory');
		swal({
	            title: "Are you sure?",
	            text: "You will not be able to recover this imaginary file!",
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes, delete it!",
	            closeOnConfirm: false
	        },
	         function(isConfirm){
					if (isConfirm) {
									$.ajax({
									type:'GET',
									url:url,
									data:{factoryid:factoryid},
									success:function(data)
										{
											$('.del-'+factoryid).remove();
											$(".select_fueltype option[value="+factoryid+"]").remove();
											swal("Done!","It was succesfully deleted!","success");
										}
									});
								}else{
										swal("Cancelled", "Your imaginary file is safe :)", "error");
									} 
							})
		
					});
	});
</script>

<!-- Add Vehicle Model -->

<script>
	$(document).ready(function(){
		$('.vehi_model_add').click(function(){
			var model_name = $('.vehi_modal_name').val();
			var model_url = $(this).attr('modelurl');
		if(model_name == ""){
            swal('Please Enter Model Name!');
        }else{	
			$.ajax({
					
				type:'GET',
				url:model_url,
				data:{model_name:model_name},
				
				success:function(data)
				{
					
					var newd = $.trim(data);
					var classname = 'mod-'+newd;
				
				
				if(newd == '01')
				{
					swal("Duplicate Data !!! Please try Another... ");
				}
				else
				{
					$('.vehi_model_class').append('<tr class="'+classname+'"><td class="text-center">'+model_name+'</td><td class="text-right"><button type="button" modelid='+data+' deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes"><i class="fe fe-trash-2"></i></button></a></td><tr>');
					$('.model_addname').append('<option value='+model_name+'>'+model_name+'</option>');
					$('.vehi_modal_name').val('');
				}
				},
			});
		}
		});
		
	$('body').on('click','.modeldeletes',function(){
			
			var mod_del_id = $(this).attr('modelid');
			var del_url = $(this).attr('deletemodel');
			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
			},
			function(isConfirm){
				if (isConfirm) {
					$.ajax({
							type:'GET',
							url:del_url,
							data:{mod_del_id:mod_del_id},
							success:function(data)
							{
								$('.mod-'+mod_del_id).remove();
								$(".model_addname option[value="+mod_del_id+"]").remove();
								swal("Done!","It was succesfully deleted!","success");
							}
						});
					}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
						} 
				})
		});	
	});

</script>

<!-- End Add Vehicle Model -->

<script type="text/javascript">
	$(document).ready(function(){
		$('.self').hide();
		$('.agregat').hide();

		$('div.customer-type-button').on('click',(e)=>{

		var cType=$(e.target).attr('val');

		console.log('customer type selected',cType);

		if(cType=='agregat'){

			$('div.customer-type-button[val="agregat"]').addClass('selected');

			$('div.customer-type-button[val="vehicle"]').removeClass('selected');

			$("#vehicle_type_id").val('agregat');

			$('.self').show();
			$('.agregat').hide();

		}else if(cType=='vehicle'){

			$('div.customer-type-button[val="agregat"]').removeClass('selected');

			$('div.customer-type-button[val="vehicle"]').addClass('selected');

			$("#vehicle_type_id").val('vehicle');

			$('.self').show();
			$('.agregat').show();
		}
	});

	})
</script>


<!-- vehical Type from brand -->

<script>
$(document).ready(function(){
	
	$('.select_vehicaltype').change(function(){
		vehical_id = $(this).val();
		var url = $(this).attr('vehicalurl');

		$.ajax({
			type:'GET',
			url: url,
			data:{ vehical_id:vehical_id },
			success:function(response){
				$('.select_vehicalbrand').html(response);
			}
		});
	});
	
});

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
    $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
</script>

@endsection
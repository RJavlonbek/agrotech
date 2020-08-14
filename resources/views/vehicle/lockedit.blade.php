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
		@if (CheckAccessUser('vehicle_lock', $userid, 'edit')=='yes')
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
							<div class="col-md-12 col-sm-12">
								<div class="alert alert-success">
									<label class="form-label" for="checkbox-10 colo_success"> {{trans('app.Amal bajarildi')}}
										<a  class="btn btn-success" href="{!! url('vehicle/view') !!}/{!! session('last_id') !!}"> 
											{{ trans('app.View') }}
										</a> 
										<a  class="btn btn-primary" href="{!! url('/vehicle/vehicle_lock')!!}">
										<span class="visible-xs"></span>
										<i class="fa fa-list fa-lg">&nbsp;</i> 
											{{ trans('app.Taqiqqa olingan texnikalar') }}
										</a> 
										<a  class="btn btn-primary" href="{!! url('/vehicle/lock')!!}">
										<i class="fa fa-plus-circle"> </i>
											{{ trans('app.tahrirlash') }}
										</a> 
									</label>
								</div>
							</div>
						</div>
					@else
						<div class="row">
							<div class="col-md-12">
								<div class="card">									
									<div class="card-body">
										<div class="panel panel-primary">
											<div class="tab_wrapper page-tab">
												<ul class="tab_list">
													<li>
														<a href="{!! url('/vehicle/vehicle_lock')!!}">
															<span class="visible-xs"></span>
															<i class="fa fa-list fa-lg">&nbsp;</i> 
															{{ trans('app.Taqiqqa olingan texnikalar') }}
														</a>
													</li>
													<li class="active">
														<a href="{!! url('/vehicle/lock')!!}">
															<span class="visible-xs"></span>
															<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>{{ trans('app.Taqiqqa olishni tahrirlash') }}</b>
														</a>
													</li>
												</ul>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-12">
												<form  action="{{ url('/vehicle/vehicle_lock/edit/update/'.$lock->id) }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform">
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<div class="row">
														<div class="col-md-6 ">
															<div class="form-group">
																<label class="form-label" for="first-name">{{ trans('app.Texnika egasini tanlang')}} <label class="text-danger">*</label></label>
																<select class="form-control owner_search" name="owner_id">
																	<option selected value="{{ $owner->id }}">{{ $owner->name }}</option>
																</select>
															</div>
														</div>
													  	<div class="col-md-6">
															<div class="form-group">
																<label class="form-label" for="factory-name">{{ trans('app.Texnikani tanlash')}} <label class="text-danger">*</label></label>
																<select name="vehicle_id" class="form-control select-class vehicle_name" >			<option selected value="{{ $vehicle->id }}">{{ $type->vehicle_type.'-'.$vehicle->engineno }}</option>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="form-label">{{ trans('app.Xarakatni tanlang')}} <label class="text-danger">*</label></label>
																<select name="action" class="form-control select-class">
																	<option 
																		@if($lock->action=='lock')
																			selected
																		@endif
																	value="lock">{{ trans('app.Taqiqqa olish')}} </option>
																	<option
																		@if($lock->action=='unlock')
																			selected
																		@endif
																	 value="unlock">{{ trans('app.Taqiqqa chiqarish')}}</option>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="form-label">{{ trans('app.Kim tomondan taqiqlash')}} <label class="text-danger">*</label></label>
																<div class="row">
																	<div class="col-md-9 col-12">
																		<select class="form-control select-class select_vehicallocker" name="locker">
																			@if(!empty($lockers))
																				@foreach ($lockers as $locker)
																					<option 
																						@if($locker->id==$lock->locker_id)
																							selected
																						@endif
																					value="{{ $locker->id }}">{{ $locker->name }}</option>
																				@endforeach
																			@endif
																		</select> 
																	</div>
																	<div class="col-12 col-md-3 addremove">
																		<button type="button" class="btn btn-success" data-target="#responsive-modal" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label">{{ trans('app.Xat sanasi')}}</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<div class="input-group-text">
																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																			</div>
																		</div>
																		<input class="form-control fc-datepicker letter-date dol" name="letterdate" placeholder="yyyy-mm-dd" value="{{ $lock->letter_date }}" />
																	</div>
																</div>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label class="form-label" >{{ trans('app.Xat raqami')}} <label class="text-danger">*</label></label>
																<input type="text" class="form-control " name="letterno" value="{{ $lock->letter_number }}" />
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="form-label" >{{ trans('app.Buyruq raqami')}} <label class="text-danger">*</label></label>
																<input type="text" class="form-control " name="orderno" value="{{ $lock->order_number }}" />
															</div>
														</div>
														<div class="col-md-4">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans('app.Buyruq sanasi')}}</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<div class="input-group-text">
																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																			</div>
																		</div>
																		<input class="form-control fc-datepicker order-date doo" name="orderdate" placeholder="yyyy-mm-dd" value="{{ $lock->order_date }}" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans('app.Qabul sanasi')}}</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<div class="input-group-text">
																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																			</div>
																		</div>
																		<input class="form-control fc-datepicker reg-date" name="date" placeholder="yyyy-mm-dd" value="{{ $lock->date }}" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-12 col-md-4">
															<div class="form-group">
																<div class="col-12 text-left">
																	<label class="form-label" style="visibility: hidden;">label</label>
																	<input type="submit" class="btn btn-success" value="{{ trans('app.Saqlash')}}">
																</div>
															</div>
														</div>
													</div>
												</form>
												<!-- Vehicle locker  -->
													<div class="col-md-6">
														<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="example-Modal3">{{ trans('app.Vehicle Locker')}}</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																	    <form class="form-horizontal formaction" action="" method="">
																			<table class="table card-table table-vcenter text-nowrap vehicle_locker_class"  align="center">
																				<thead>
																					<tr>
																						<td class="text-center"><strong>{{ trans('app.Vehicle Locker')}}</strong></td>
																						<td class="text-right"><strong>{{ trans('app.Action')}}</strong></td>
																					</tr>
																				</thead>
																				<tbody>
																					@if(!empty($lockers))
																					@foreach ($lockers as $locker)
																					<tr class="del-{{ $locker->id }}">
																						<td class="text-center ">{{ $locker->name }}</td>
																						<td class="text-right">
																							<button type="button" vehiclelockerid="{{ $locker->id }}" 
																							deletevehicallocker="{!! url('/vehicle/lockerdelete') !!}" class="btn btn-danger btn-xs deletevehiclelocker"><i class="fe fe-trash-2"></i></button>
																						</td>
																					</tr>
																					@endforeach
																					@endif
																				</tbody>
																			</table>
																			<div class="form-group data_popup">
																				<label>{{ trans('app.Vehicle Locker')}}: <span class="text-danger">*</span></label>
																				<div class="row">
																					<div class="col-10">
																						<input type="text" class="form-control vehicle_locker" name="locker" id="vehicle_locker" placeholder="{{ trans('app.Enter Locker name')}}" maxlength="20" required />
																					</div>
																					<div class="col-2 data_popup">		
																						<button type="button" class="btn btn-success vehicallockeradd" url="{!! url('/vehicle/locker_add') !!}" >{{ trans('app.Submit')}}</button>
																					</div>
																				</div>
																			</div>
																		</form>
																	</div>
																</div>
															</div>	
														</div>
													</div>
												<!-- End  Vehicle Type  -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif
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
			<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
		    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
		    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
			<script>
		    $('#myDatepicker2').datetimepicker({
		       format: "yyyy",
				autoclose: 2,
				minView: 4,
				startView: 4,
				
		    });
		</script>
		<script>
	    $(document).ready(function(){
	    	$('select.select-class').select2({
				minimumResultsForSearch: Infinity});
	    });
    	</script>
		<script>
			$('input.letter-date').datetimepicker({
				format:'yyyy-mm-dd',
				autoclose:1,
				minView:2,
				startView:'decade',
				endDate: new Date()
			});
			$('input.order-date').datetimepicker({
				format:'yyyy-mm-dd',
				autoclose:1,
				minView:2,
				startView:'decade',
				endDate: new Date()
			});
			$('input.reg-date').datetimepicker({
				format:'yyyy-mm-dd',
				autoclose:1,
				minView:2,
				startView:'decade',
				endDate: new Date()
			});
		</script>
		<!-- vehicle owner -->
		<script>
		    $(document).ready(function(){
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
									text:name.name
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
				$('select.owner_search').change(function(){
					var id = $(this).val();
					$.ajax({
						type:'GET',
						url:'vehicle_search_lock',
						data:'id='+id,
						success: function(data) {
				            if (data!='01') {
				                $(".vehicle_name").html(data);
				            }
				           
				        }
					});
				});
			});
		</script>
		<!-- vehical Type delete-->
		<script>
			$(document).ready(function(){
				
				$('body').on('click','.deletevehiclelocker',function(){
					
					var vlockerid = $(this).attr('vehiclelockerid');
					
					var url = $(this).attr('deletevehicallocker');
					
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
										data:{vlockerid:vlockerid},
										success:function(data){
					
											$('.del-'+vlockerid).remove();
											$(".select_vehicallocker option[value="+vlockerid+"]").remove();
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
				
				 $('.vehicallockeradd').click(function(){
				var url = $(this).attr('url');
				var locker = $(".vehicle_locker").val();
				if(locker =='')
				{
					swal('Please Enter Vehicle Brand!');
				}
				else{ 
					$.ajax({
					   type:'GET',
					   url:url,
		             
					   data :{locker:locker
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
						   	 
							   $('.vehicle_locker_class').append('<tr class="'+classname+'"><td class="text-center">'+locker+'</td><td class="text-right"><button type="button" vehiclelockerid='+data+' deletevehicallocker="{!! url('vehicle/lockerdelete') !!}" class="btn btn-danger btn-xs deletevehiclelocker"><i class="fe fe-trash-2"</i></button></a></td><tr>');
								$('.select_vehicallocker').append('<option value='+data+'>'+locker+'</option>');
								$('.vehicle_locker').val('');
							}
					     
					   },
					   
				 });
				}
				});
			});
		</script>

	@endsection
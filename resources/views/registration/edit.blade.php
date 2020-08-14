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
		@if (CheckAccessUser('vehicle_reg', $userid, 'edit')=='yes')
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
											{{ trans('app.Taqiqqa olish') }}
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
														<a href="{!! url('/certificate/reglist')!!}">
															<span class="visible-xs"></span>
															<i class="fa fa-list fa-lg">&nbsp;</i> 
															{{ trans('app.Ro\'yhatdan chiqarilganlar')}}
														</a>
													</li>
													<li class="active">
														<a href="{!! url('/certificate/regadd')!!}">
															<span class="visible-xs"></span>
															<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
															{{ trans("app.Ro'yhatga olish/chiqarish")}}</b>
														</a>
													</li>
												</ul>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-12">
												<form  action="{{ url('/certificate/regupdate/'.$reg->id) }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform">
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<div class="row">
														<div class="col-md-6">
															<label class="form-label" style="visibility: hidden;">asd</label>
															<div class="row">
																<div class="col-6 pr-0">
																	<div class="customer-type-button 
																		@if($reg->action=='regged')
																			selected
																		@endif
																		 py-2" val="regged">
																		Ro'yxatdan o'tkazish
																	</div>
																</div>
																<div class="col-6 pl-0">
																	<div class="customer-type-button 
																	@if($reg->action=='unregged')
																			selected
																		@endif
																	 py-2" val="unregged">
																		Ro'yxatdan chiqarish
																	</div>
																</div>
															</div>
														</div>		
														<div class="col-md-6 ">
															<div class="form-group">
																<label class="form-label" for="first-name">{{ trans('app.Texnika egasini tanlang')}} <label class="text-danger">*</label></label>
																<select class="form-control owner_search" name="owner_id">
																	<option selected value="{{ $owner->id }}">{{ $owner->name }}</option>
																</select>
															</div>
														</div>
														<div class="col-md-4 col-12">
															<div class="form-group">
																<label class="form-label" for="factory-name">{{ trans('app.Texnikani tanlash')}} <label class="text-danger">*</label></label>
																<select name="vehicle_id" class="form-control select-class vehicle_name" >
																	<option selected value="{{ $vehicle->id }}">{{ $type->vehicle_type.'-'.$vehicle->engineno }}</option>			
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans('app.Berilgan sana')}}</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<div class="input-group-text">
																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																			</div>
																		</div>
																		<input class="form-control fc-datepicker reg-date" name="regdate" placeholder="yyyy-mm-dd" value="{{ $reg->date }}" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-12 payment1">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans('app.To\'lov miqdori')}}</label>
																	<div class="input-group">
																		<input class="form-control " type="number" min="0" step="100" name="totalamount" placeholder="" value="{{ $reg->total_amount }}" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-12 payment1">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans('app.To\'langan summa')}}</label>
																	<div class="input-group">
																		<input class="form-control "  type="number" min="0" step="100" name="paidamount" placeholder="" value="{{ $reg->paid_amount }}" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-12 payment1">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans("app.Chegirma miqdori")}}</label>
																	<div class="input-group">
																		<input type="number" class="form-control " name="discount" placeholder="" value="{{ $reg->discount }}" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans("app.Qo'shimcha ma'lumot")}}</label>
																	<div class="input-group">
																		<input class="form-control " name="note" placeholder="" value="{{ $reg->note }}" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-12 col-md-12">
															<div class="form-group">
																<div class="col-12 text-right">
																	<label class="form-label" style="visibility: hidden;"></label>
																	<input id="action" type="hidden" name="action" value="{{ $reg->action }}">
																	<input type="submit" class="btn btn-success" value="{{ trans('app.Saqlash')}}">
																</div>
															</div>
														</div>
													</div>
												</form>
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
		$('div.customer-type-button').on('click',(e)=>{
			var cType=$(e.target).attr('val');
			if(cType=='regged'){
				$('div.customer-type-button[val="regged"]').addClass('selected');
				$('div.customer-type-button[val="unregged"]').removeClass('selected');
				$('div.payment1').show();
				$("input#action").val("regged");
			}else if(cType=='unregged'){
				$('div.customer-type-button[val="regged"]').removeClass('selected');
				$('div.customer-type-button[val="unregged"]').addClass('selected');
				$('div.payment1').hide();
				$("input#action").val("unregged");
			}
		});



	    	$('select.select-class').select2({
				minimumResultsForSearch: Infinity});
	    });
    	</script>
		<script>
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
						url:'/vehicle/owner_search_name',
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
						url:'/vehicle/vehicle_search_lock',
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
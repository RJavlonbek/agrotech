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
		@if (CheckAccessUser('vehicle_lock', $userid, 'create')=='yes')
				<div class="section">
					<div class="page-header">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<i class="fe fe-life-buoy mr-1"></i>&nbsp 
								@if(!empty($title))
									{{ $title }}
								@else
									{{ trans('app.Taqiqqa olish')}}
								@endif
							</li>
						</ol>
					</div>
					@if(session('message'))
						<div class="row massage">
							<div class="col-md-12 col-sm-12">
								<div class="alert alert-success">
									<label class="form-label" for="checkbox-10 colo_success"> {{trans('app.Amal bajarildi')}}
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
														<a href="{!! url('/vehicle/vehicle_lock')!!}">
															<span class="visible-xs"></span>
															<i class="fa fa-list fa-lg">&nbsp;</i> 
															{{ trans('app.Taqiqqa olinganlar') }}
														</a>
													</li>
													<li class="active">
														<a href="javascript:void(0)">
															<span class="visible-xs"></span>
															<i class="fa fa-plus-circle fa-lg">&nbsp;</i> 
															<b>
															@if(!empty($view_id))
																{{ trans('app.Taqiqdan chiqarish')}}
															@else
																{{ trans('app.Taqiqqa olish')}}
															@endif
															</b>
														</a>
													</li>
												</ul>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-12">
												<form  action="{{ url('/vehicle/lockstore') }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform">
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<div class="row">
																
														<div class="col-md-6 invisible-item">
															<div class="form-group">
																<label class="form-label"  for="first-name">{{ trans('app.Texnika egasini tanlang')}} <label class="text-danger">*</label></label>
																<select required class="form-control owner_search" name="owner_id">
																	@if(!empty($view_id))
																		<option selected value="{{ $owner->id }}">
																			@if($owner->type=='legal')
																				{{ $owner->name }}
																			@elseif($owner->type == 'physical')
																				{{ $owner->lastname.' '.$owner->name }} 
																				@if(!empty($owner->middlename))
																					{{ $owner->name }}
																				@endif
																			@endif
																		</option>
																	@endif
																</select>
															</div>
														</div>
													  	<div class="col-md-6 invisible-item">
															<div class="form-group">
																<label class="form-label" for="factory-name">{{ trans('app.Texnikani tanlash')}} <label class="text-danger">*</label></label>
																<select name="vehicle_id" required class="form-control select-class-vehicle vehicle_name" >
																	@if(!empty($view_id))
																		<option value="{{ $vehicle->id }}">{{ $v_brand->vehicle_brand.' '.$v_type->vehicle_type }}{{ !empty($v_number->code)?$v_number->code.' '.$v_number->series.' '.$v_number->number:'' }}</option>
																	@endif
																</select>
															</div>
														</div>
														<div class="col-md-4 invisible-item">
															<div class="form-group">
																<label class="form-label">{{ trans('app.Kim tomondan taqiqlash')}} <label class="text-danger">*</label></label>
																<select class="form-control select-class-locker select_vehicallocker" name="locker" required>
																	<option value>Taqiqlovchini tanlang</option>
																	@if(!empty($lockers))
																		@foreach ($lockers as $locker)
																			<option value="{{ $locker->id }}">{{ $locker->name }}</option>
																		@endforeach
																	@endif
																	@if(!empty($view_id))
																		<option selected value="{{ $locker->id }}">{{ $locker->name }}</option>
																	@endif
																</select> 
															</div>
														</div>
														<div class="col-md-4 invisible-item">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label">{{ trans('app.Xat sanasi')}}</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<div class="input-group-text">
																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																			</div>
																		</div>
																		<input  readonly="true" required class="form-control letter-date dol" name="letterdate" placeholder="dd-mm-yyyy" value="{{ date('d-m-Y') }}" />
																	</div>
																</div>
															</div>
														</div>

														<div class="col-md-4 invisible-item">
															<div class="form-group">
																<label class="form-label" >{{ trans('app.Xat raqami')}} <label class="text-danger">*</label></label>
																<input required type="text" class="form-control " name="letterno" placeholder="Xat raqamini kiriting" />
															</div> 
														</div>
														<div class="col-md-4 invisible-item">
															<div class="form-group">
																<label class="form-label" >{{ trans('app.Buyruq raqami')}} <label class="text-danger">*</label></label>
																<input required type="text" class="form-control " name="orderno" placeholder="Buyruq raqamini kiriting" />
															</div>
														</div>
														<div class="col-md-4 invisible-item">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans('app.Buyruq sanasi')}}</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<div class="input-group-text">
																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																			</div>
																		</div>
																		<input  readonly="true" required class="form-control order-date doo" name="orderdate"  placeholder="dd-mm-yyyy" value="{{ date('d-m-Y') }}"/>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4 invisible-item">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans('app.Qabul sanasi')}}</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<div class="input-group-text">
																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																			</div>
																		</div>
																		<input  readonly="true" required class="form-control fc-datepicker reg-date" name="date"  placeholder="dd-mm-yyyy" value="{{ date('d-m-Y') }}"/>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-12 col-md-4 invisible-item">
															<div class="form-group">
																<div class="col-12 text-left">
																	<label class="form-label" style="visibility: hidden;">label</label>
																	<input type="hidden" class="form-control" type="text" name="action" 
																	@if(!empty($view_id))
																		value="unlock" 
																	@else
																		value="lock" 
																	@endif
																>
																	@if(!empty($view_id))
																		<input type="hidden" name="oldone" value="{{ $view_id }}">
																	@endif
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
		     <script src="{{ URL::asset('build/js/bootstrap-datetimepicker.min.js') }}"></script>
			<script>
		    $('#myDatepicker2').datetimepicker({
		       format: "yyyy",
				locale: 'uz-latn',
				autoclose: 2,
				minView: 4,
				startView: 4,
				
		    });
		</script>
		<script>
		    $(document).ready(function(){
		    	$('select.select-class-vehicle').select2({
		    		placeholder:'Texnikani tanlang',
		    		language:{

							inputTooShort:function(){

								return 'Texnika egasining ismi (nomi), STIR ini kiritib izlang';

							},

							searching:function(){

								return 'Izlanmoqda...';

							},

							noResults:function(){

								return "Natija topilmadi"

							},

							errorLoading:function(){
								return "Natija topilmadi"
					}

						},
					minimumResultsForSearch: Infinity});
		    	$('select.select-class-action').select2({
		    		placeholder:'Harakatni tanlang',
		    		language:{

							inputTooShort:function(){

								return 'Texnika egasining ismi (nomi), STIR ini kiritib izlang';

							},

							searching:function(){

								return 'Izlanmoqda...';

							},

							noResults:function(){

								return "Natija topilmadi"

							},

							errorLoading:function(){
								return "Natija topilmadi"
					}

						},
					minimumResultsForSearch: Infinity});
		    	$('select.select-class-locker').select2({
		    		placeholder: 'Taqiqlovchi organni tanlang',
		    		language:{

							inputTooShort:function(){

								return 'Texnika egasining ismi (nomi), STIR ini kiritib izlang';

							},

							searching:function(){

								return 'Izlanmoqda...';

							},

							noResults:function(){

								return "Natija topilmadi"

							},

							errorLoading:function(){
								return "Natija topilmadi"
					}

						},
					minimumResultsForSearch: Infinity});
		    });
    	</script>
		<script>
			$('input.letter-date').datetimepicker({
				format:'dd-mm-yyyy',
				language: 'uz',
				autoclose:1,
				minView:2,
				startView:'decade',
				
				endDate: new Date()
			});
			$('input.order-date').datetimepicker({
				format:'dd-mm-yyyy',
				language: 'uz',
				autoclose:1,
				minView:2,
				weekStart: 1,
				startView:'decade',
				endDate: new Date()
			});
			$('input.reg-date').datetimepicker({
				format:'dd-mm-yyyy',
				language: 'uz',
				autoclose:1,
				minView:2,
				weekStart: 1,
				startView:'decade',
				endDate: new Date()
			});
		</script>
		<!-- vehicle owner -->
		@if(empty($view_id))
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
										text:capitalize(name.name+(name.lastname?' '+name.lastname:'')+(name.middlename?' '+name.middlename:''))
									}
								});
								return{
									results:data
								}
							}
						},
						language:{

							inputTooShort:function(){

								return 'Texnika egasining ismi (nomi), STIR ini kiritib izlang';

							},

							searching:function(){

								return 'Izlanmoqda...';

							},

							noResults:function(){

								return "Natija topilmadi"

							},

							errorLoading:function(){
								return "Natija topilmadi"
					}

						},
						placeholder:'Texnika egasini kiriting',
						minimumInputLength:2
					});
					$('select.owner_search').change(function(){
						var id = $(this).val();
						$(".vehicle_name").val('');
						var type = $('#lockingaction').val();
						$.ajax({
							type:'GET',
							url:'vehicle_search_lock',
							data:'id='+id+'&type='+type,
							success: function(data) {
					            if (data!='01') {
					                $(".vehicle_name").html(data);
					            }
					           
					        }
						});
					});
					function capitalize(text){
			var words=text.split(' ');
			for(var i=0;i<words.length;i++){
				if(words[i][0] == null){
					continue;
				}else{
					words[i]=words[i][0].toUpperCase()+words[i].substring(1).toLowerCase();
				}
				
			}
			return words.join(' ');
		}
				});
			</script>
		@else
			<script>
			    $(document).ready(function(){
			    	$('select.owner_search').select2({
			    		placeholder: 'Texnika egasini Tanlang',
			    		language:{

							inputTooShort:function(){

								return 'Texnika egasining ismi (nomi), STIR ini kiritib izlang';

							},

							searching:function(){

								return 'Izlanmoqda...';

							},

							noResults:function(){

								return "Natija topilmadi"

							},

							errorLoading:function(){
								return "Natija topilmadi"
					}

						},
						minimumResultsForSearch: Infinity});
			    });
	    	</script>
		@endif
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
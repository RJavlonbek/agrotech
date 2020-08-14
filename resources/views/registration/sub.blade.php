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
		@if (CheckAccessUser('vehicle_reg', $userid, 'create')=='yes')
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
															{{ trans('app.Ro\'yxatdan chiqarilganlar')}}
														</a>
													</li>
													<li class="active">
														<a href="javascript:void(0)">
															<span class="visible-xs"></span>
															<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
															{{ trans("app.Ro'yxatdan chiqarish")}}</b>
														</a>
													</li>
												</ul>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-12">
												<form  action="javascript:void(0)"  class="form-horizontal upperform" id="vehicleregadd">
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<div class="row">
														<div class="col-md-6 hider">
															<div class="form-group">
																<label class="form-label" for="first-name">{{ trans('app.Texnika egasi')}} <label class="text-danger">*</label></label>
																<select required class="form-control owner_search" name="owner_id">
																	@if(!empty($owner))
																			<option value="{{ $owner->id }}" selected="selected">
																				<span class="text-capitalize">
																					@if($owner->type == 'legal')
																						{{ $owner->name }}
																					@elseif($owner->type == 'physical')
																						{{ $owner->lastname.' '.$owner->name }} 
																						@if(!empty($owner->middlename))
																							{{ $owner->middlename }}
																						@endif
																					@endif
																				</span>
																			</option>
																		@endif
																</select>
															</div>
														</div>
														<div class="col-md-6 col-12 hider">
															<div class="form-group">
																<label class="form-label" for="factory-name">{{ trans('app.Vehicle')}} <label class="text-danger">*</label></label>
																<select name="vehicle_id" class="form-control select-class-vehicle vehicle_name" >
																	@if(!empty($vehicle))
																		<option selected="selected" value="{{ $vehicle->vehicle_id }}">{{ $vehicle->vehicle_type.'-'.$vehicle->engineno }}</option>		
																	@endif
																</select>
															</div>
														</div>
														<div class="col-md-4 hider">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans('app.Date')}}</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<div class="input-group-text">
																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																			</div>
																		</div>
																		<input readonly="true" class="form-control fc-datepicker reg-date" name="regdate" placeholder="dd-mm-yyyy" value="{{ date('d-m-Y') }}" />
																	</div>
																</div>
															</div>
														</div>

														<div class="col-md-4 hider">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans("app.Qo'shimcha ma'lumot")}}</label>
																	<div class="input-group">
																		<input class="form-control " name="note" placeholder="Qo'shimcha ma'lumotlar..."/>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-6 col-12 payment1 hider">
															<div class="wd-200 mg-b-30">
																<div class="form-group hider">
																	<div class="row">
																		<div class="col-7">
																			<label class="form-label" >{{ trans('app.To\'lov miqdori')}}</label>
																			<div class="input-group">
																				<input disabled class="form-control " type="number" min="0" step="100" name="totalamount" placeholder="To'lov miqdori" value="0" />
																			</div>
																		</div>
																		<div class="col-5">
																			<label class="container-checkbox">to'landi
																			  	<input type="checkbox" required class="check-paid">
																			  	<span class="checkmark"></span>
																			</label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-3 unfit hider">
															<div class="form-group">
																<label class="form-label" style="visibility: hidden;">label</label>
																<label class="custom-switch">
																	<input id="unfitcheck" type="checkbox" name="unfitcheck" class="custom-switch-input">
																	<input type="hidden" name="unfit" id="unfit" value="0">
																	<span class="custom-switch-indicator"></span>
																	<span class="custom-switch-description">{{ trans('app.unfit')}}</span>
																</label>
															</div>
														</div>
														<div class="col-md-3 outof hider">
															<div class="form-group">
																<label class="form-label" style="visibility: hidden;">label</label>
																<label class="custom-switch">
																	<input id="outofcheck" type="checkbox" name="outofcheck" class="custom-switch-input">
																	<input type="hidden" name="outof" id="outof" value="0">
																	<span class="custom-switch-indicator"></span>
																	<span class="custom-switch-description">{{ trans('app.Chetga chiqarildi')}}</span>
																</label>
															</div>
														</div>
														<div class="col-12 col-md-12 hider">
															<div class="form-group">
																<div class="col-12 text-right">
																	<label class="form-label" style="visibility: hidden;"></label>
																	<input id="action" type="hidden" name="action" value="unregged">
																	<input id="url" type="hidden" name="url" value="/certificate/searchvehiclereg">
																	<button id="formsubmitbutton" class="btn btn-success" disabled>{{ trans('app.Saqlash')}}</button>
																	<input id="formsubmit" type="submit" class="btn btn-success" value="{{ trans('app.Saqlash')}}" style="display: none;">
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
		    <script src="{{ URL::asset('build/js/bootstrap-datetimepicker.min.js') }}"></script>
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
	    	@if(!empty($vehicle_id))
	    		$.ajax({
	    			type:'GET',
	    			url:'/payment/reg-out',
	    			data:'id='+{{$vehicle_id}},
	    			success:function(){
	    				$("input[name='totalamount']").val(parseInt(data));
	    			},
	    			error:function(){
	    				swal('Xatolik Boshqa Texnika tanlang', '', 'error');
	    				$('select[name="vehicle_id"]').val('');
	    				$("input[name='totalamount']").val('');
	    			}
	    		});
	    	@endif

	    	$('select[name="vehicle_id"]').change(function(){
	    		var id = $(this).val();
	    		$.ajax({
	    			type:'GET',
	    			url:'/payment/reg-out',
	    			data:'id='+id,
	    			success:function(data){
	    				$("input[name='totalamount']").val(parseInt(data));
	    			},
	    			error:function(){
	    				swal('Xatolik Boshqa Texnika tanlang', '', 'error');
	    				$('select[name="vehicle_id"]').val('');
	    				$("input[name='totalamount']").val('');
	    			}
	    		});
	    	})    	
	    	
			
	    	$('select.select-class-vehicle').select2({
	    		language:{
						inputTooShort:function(){
							return 'Texnika egasini ismi (nomi), STIR ini kiritib izlang';
						},
						searching:function(){
							return 'Izlanmoqda...';
						},
						noResults:function(){
							return "Natija topilmadi";
						}

					},
	    		placeholder: "Texnikani tanlang",
				minimumResultsForSearch: Infinity});
	    });

    	</script>
		<script>
			$('input.reg-date').datetimepicker({
				format:'dd-mm-yyyy',
				autoclose:1,
				minView:2,
				startView:'decade',
				endDate: new Date()
			});

	$(document).ready(function(){
		$('#vehicleregadd').on('submit',function(e){
			var outof = $("#outofcheck").is(":checked");
			var unfit = $("#unfitcheck").is(":checked");
			if(outof){
				$("#outof").val('1');
			}else{
				$("#outof").val('0');
			}
			if(unfit){
				$("#unfit").val('1');
			}else{
				$("#unfit").val('0');
			}
			var vehicle = $("select[name='vehicle_id']").val();
			$.ajax({
				type:'GET',
				url:'/certificate/checklising',
				data:'vehicle='+vehicle,
				success:function(result){
					if(result=='yes'){
						$("select[name='vehicle_id']").html('');
						$("select[name='owner_id']").html('');
						swal({   
					            title: "Ushbu texnika lizingda",

								text: "Lizinga berilgan yoki olingan texnikalar ro'yxatdan chiqarilmaydi!",   

					            type: "error",   

					            showCancelButton: false,   

					            confirmButtonColor: "#297FCA",   

					            confirmButtonText: "Boshqa texnika tanlash"

					        }).then((result)=>{
					        	if(result){
					        		 $("select[name='owner_id']").focus();
					        	}
					        });
					}else{
						$('input[name="totalamount"]').attr('disabled', false);
						var submitButton=$('#vehicleregadd').find('button[type="submit"]');
						submitButton.addClass('btn-loading');
						e.preventDefault();
						var formArray=$('#vehicleregadd').serializeArray();
						var url='/certificate/regstore';
						$.ajax({
							type:'POST',
							url:url,
							data:formArray,
							success:function(result){
								swal({
									title: "Ro'yxatdan chiqarildi!",
									text:"",
									type: "success",
									confirmButtonText: "Davom etish",
									showCancelButton: false
								}).then((isConfirm) => {
									if(unfit){
										window.location.pathname = "/certificate/reglistoutof";
									}
									else{
										window.location.pathname = "/certificate/reglist";
									}
								});
							},
							error:function(err){
								submitButton.removeClass('btn-loading');
								swal('Xatolik','','error');
								console.log(err);
							}
						});
					}
				},
			});	
		});
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

							return 'Texnika egasini ismi (nomi), STIR ini kiritib izlang';

						},

						searching:function(){

							return 'Izlanmoqda...';

						},

						noResults:function(){

							return "Natija topilmadi";

						},

						errorLoading:function(){
							return "Natija topilmadi";
						}

					},
					placeholder:'Texnika egasini kiriting',
					minimumInputLength:2
				});
				$('select.owner_search').change(function(){
					var url = '/vehicle/vehicle_search_lock';
					var type = 'unregged';
					var id = $(this).val();
					$.ajax({
						type:'GET',
						url:url,
						data:'id='+id+'&type='+type,
						success: function(data) {
				            if (data!='01') {
				                $(".vehicle_name").html(data);
				            }
				           
				        }
					});
				});

				if($('input.check-paid').length && !($('input.check-paid').is(":checked"))){
						$('#formsubmitbutton').attr('disabled','disabled');
					}

				$('input.check-paid').on('change', function(){
					if(($('input.check-paid').is(":checked"))){
						$('#formsubmitbutton').removeAttr('disabled');
					}
					else if(!($('input.check-paid').is(":checked"))){
						$('#formsubmitbutton').attr('disabled','disabled');
					}
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


	@endsection
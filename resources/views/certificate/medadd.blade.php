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
		@if (CheckAccessUser('vehicle_med', $userid, 'create')=='yes')
				<div class="section">
					<div class="page-header">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Texnikani texnik ko\'rikdan o\'tkazish')}}
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
											{{ trans('app.Texnik ko\'riklar') }}
										</a> 
										<a  class="btn btn-primary" href="{!! url('/vehicle/lock')!!}">
										<i class="fa fa-plus-circle"> </i>
											{{ trans('app.Texnik ko\'rikdan o\'tkazish') }}
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
														<a href="{!! url('/certificate/medlist')!!}">
															<span class="visible-xs"></span>
															<i class="fa fa-list fa-lg">&nbsp;</i> 
															{{ trans('app.Texnik ko\'riklar')}}
														</a>
													</li>
													<li class="active">
														<a href="{!! url('/certificate/medadd')!!}">
															<span class="visible-xs"></span>
															<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
															{{ trans('app.Texnik ko\'rikdan o\'tkazish')}}</b>
														</a>
													</li>
												</ul>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-12">
												<form  action="{{ url('/certificate/medstore') }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform">
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<div class="row">
														<div class="col-md-6 ">
															<div class="form-group">
																<label class="form-label" for="first-name">{{ trans('app.Texnika egasini tanlang')}} <label class="text-danger">*</label></label>
																<select required class="form-control owner_search" name="owner_id">
																	@if(!empty($owner))
																		<option selected value="{{ $owner->id }}">
																			@if($owner->type=='legal')
																				{{ $owner->name }}
																			@elseif($owner->type == 'physical')
																				{{ $owner->lastname.' '.$owner->name }} 
																				@if(!empty($owner->middlename))
																					{{ $owner->middlename }}
																				@endif
																			@endif
																		</option>
																	@endif
																</select>
															</div>
														</div>
													  	<div class="col-md-6">
															<div class="form-group">
																<label class="form-label" for="factory-name">{{ trans('app.Texnikani tanlash')}} <label class="text-danger">*</label></label>
																<select name="vehicle_id" class="form-control select-class-vehicle vehicle_name" >
																	@if(!empty($vehicle))
																		<option selected value="{{ $vehicle->id }}">{{ $type->vehicle_type.'-'.$v_brand->vehicle_brand }} {{ ($vehicle->type != 'agregat')?' '.$v_number->code.' '.$v_number->series.' '.$v_number->number:'' }}</option>
																	@endif			
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="form-label">Texnik ko'rik turini tanlang<label class="text-danger">*</label></label>
																<select required name="med_type" class="form-control select-class-type">
																	<option value> Harakatni tanlang</option>
																	@if(!empty($payments))
																		@foreach($payments as $payment)
																			@if($payment)
																				<option value="{{ $payment->id }}">{{ $payment->name }} </option>
																			@endif
																		@endforeach
																	@endif
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="form-label">{{ trans('app.Xarakatni tanlang')}} <label class="text-danger">*</label></label>
																<select required name="status" class="form-control select-class-condition">
																	<option value> Harakatni tanlang</option>
																	<option value="pass">{{ trans('app.O\'tdi')}} </option>
																	<option value="fail">{{ trans('app.O\'tmadi')}}</option>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="wd-200 mg-b-30">
																<div class="form-group">
																	<label class="form-label" >{{ trans('app.Date')}}</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<div class="input-group-text">
																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																			</div>
																		</div>
																		<input readonly="true" class="form-control fc-datepicker payment-date doo" name="givendate" placeholder="dd-mm-yyyy" value="{{ date('d-m-Y') }}" />
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="form-label" >{{ trans('app.Talon raqami')}} <label class="text-danger">*</label></label>
																<input required type="text" class="form-control " type="number" min="0" step="100" name="talonnumber" placeholder="{{ trans('app.Talon raqamini kiriting')}}" />
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-7">
																	<div class="form-group">
																		<label class="form-label" >{{ trans('app.To\'lov')}} <label class="text-danger">*</label></label>
																		<input disabled required type="text" class="form-control " type="number" min="0" step="100" name="totalpayment" placeholder="To'lov miqdori" />
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
														<div class="col-md-8">
															<div class="form-group">
																<div class="col-12">
																	<label class="form-label" style="visibility: hidden;">label</label>
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
	    	
	    	$('select.select-class-vehicle').select2({
	    		language:{

				
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
	    		placeholder: "Texnikani tanlang",
				minimumResultsForSearch: Infinity});
	    	$('select.select-class-condition').select2({
	    		placeholder: "Harakatni tanlang",
				minimumResultsForSearch: Infinity
			});
			$('select.select-class-type').select2({
	    		placeholder: "Harakatni tanlang",
				minimumResultsForSearch: Infinity
			});
	    });
	    
    	</script>
		<script>
			$('input.payment-date').datetimepicker({
				format:'dd-mm-yyyy',
				autoclose:1,
				minView:2,
				startView:'decade',
				endDate: new Date()
			});
			$('input.given-date').datetimepicker({
				format:'dd-mm-yyyy',
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

							return 'Texnika egani ismi (nomi), STIR ini kiritib izlang';

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

				$('select.select-class-type').change(function(){
					var type_id = $(this).val();
					var url = '/payment/medtype';
					$.ajax({
						type: 'GET',
						url: url,
						data: 'type='+type_id,
						success: function(data){
							var total = {{ $min->payment }}*(data/100);
							$('input[name="totalpayment"]').val(total);
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

	@endsection
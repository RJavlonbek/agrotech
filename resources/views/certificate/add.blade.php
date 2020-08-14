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

			@if (CheckAccessUser('vehicle_pass', $userid, 'create')=='yes')

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

									<div class="card-body p-6">

										<div class="panel panel-primary">

											<div class="tab_wrapper page-tab">

												<ul class="tab_list">
														<li>
															<a href="{!!url('/vehicle/technical-passport')!!}">
																<i class="fa fa-plus-circle fa-lg"> </i>
																<b>Texnik pasport berish</b>
															</a>
														</li>

														<li class="active">

															<a href="{!! url('/certificate/add')!!}">

																<span class="visible-xs"></span>

																<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

																{{ trans('app.Texnik guvohnoma berish')}}</b>

															</a>

														</li>

													</ul>

											</div>

										</div>

										<div class="row">

											<div class="col-md-12 col-sm-12 col-12">

												<form  action="{{ url('/certificate/store') }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform">

													<input type="hidden" name="_token" value="{{csrf_token()}}">

													<div class="row">

														<div class="col-md-6">

															<label class="form-label" style="visibility: hidden;">asd</label>

															<div class="row">

																<div class="col-6 pr-0">

																	<div class="customer-type-button selected py-2" val="new">

																		Berish

																	</div>

																</div>

																<div class="col-6 pl-0">

																	<div class="customer-type-button py-2" val="restore">

																		Qayta tiklash

																	</div>

																</div>

															</div>

														</div>
														<div class="col-md-6"></div>

														<div class="col-md-6 ">

															<div class="form-group">

																<label class="form-label" for="first-name">{{ trans('app.Texnika egasini tanlang')}} <label class="text-danger">*</label></label>

																<select class="form-control owner_search" name="owner_id">

																	@if(!empty($owner))

																		<option selected value="{{ $owner->id }}">{{ $owner->name }}</option>

																	@endif

																</select>

															</div>

														</div>

													  	<div class="col-md-4">

															<div class="form-group">

																<label class="form-label" for="factory-name">{{ trans('app.Texnikani tanlash')}} <label class="text-danger">*</label></label>

																<select name="vehicle_id" class="form-control select-class vehicle_name" >

																	@if(!empty($vehicle))

																		<option selected value="{{ $vehicle->id }}">{{ $type->vehicle_type.'-'.$vehicle->engineno }}</option>

																	@endif			

																</select>

															</div>

														</div>

														<div class="col-md-4">

															<div class="wd-200 mg-b-30">

																<div class="form-group">

																	<label class="form-label">{{ trans('app.Guvohnoma seriyasi')}}</label>

																	<div class="input-group">

																		<input class="form-control certificateseries" pattern="[A-Z]{2}" onkeyup="this.value=this.value.toUpperCase()" maxlength="2" name="series" placeholder="AA"/>

																	</div>

																</div>

															</div>

														</div>



														<div class="col-md-4">

															<div class="form-group">

																<label class="form-label" >{{ trans('app.Guvohnoma raqami')}} <label class="text-danger">*</label></label>

																<input type="text" class="form-control " name="number" />

															</div>

														</div>

														<div class="col-md-4">

															<div class="form-group">

																<label class="form-label" >{{ trans('app.Buyruq raqami')}} <label class="text-danger">*</label></label>

																<input type="text" class="form-control " name="orderno" />

															</div>

														</div>

														<div class="col-md-4">

															<div class="form-group">

																<label class="form-label" >{{ trans('app.To\'lov miqdori')}} <label class="text-danger">*</label></label>

																<input type="text" class="form-control " type="number" min="0" step="100" name="totalpayment" />

															</div>

														</div>

														<div class="col-md-4">

															<div class="form-group">

																<label class="form-label" >{{ trans('app.Chegirma miqdori')}} <label class="text-danger">*</label></label>

																<input type="text" class="form-control " type="number" min="0" step="100" name="discount" />

															</div>

														</div>

														<div class="col-md-4">

															<div class="wd-200 mg-b-30">

																<div class="form-group">

																	<label class="form-label" >{{ trans('app.To\'lov sanasi')}}</label>

																	<div class="input-group">

																		<div class="input-group-prepend">

																			<div class="input-group-text">

																				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>

																			</div>

																		</div>

																		<input class="form-control fc-datepicker payment-date doo" name="paymentdate" placeholder="yyyy-mm-dd"/>

																	</div>

																</div>

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

																		<input class="form-control fc-datepicker given-date doo" name="givendate" placeholder="yyyy-mm-dd"/>

																	</div>

																</div>

															</div>

														</div>

														<div class="col-md-4">

															<div class="wd-200 mg-b-30">

																<div class="form-group">

																	<label class="form-label" >{{ trans('app.To\'langan summa')}}</label>

																	<div class="input-group">

																		<input class="form-control " type="number" min="0" step="100" name="paidamount" placeholder=""/>

																	</div>

																</div>

															</div>

														</div>

														<div class="col-12 col-md-12 unique" style="display: none;">

															<div class="form-group">

																<div class="text-right">

																	<label class="form-label">{{ trans('app.Alohida belgilari')}}</label>

																	<div class="input-group">

																		<input class="form-control " name="" placeholder=""/>

																	</div>

																</div>

															</div>

														</div>

														<div class="col-12 col-md-12">

															<div class="form-group">

																<div class="text-right">

																	<label class="form-label" style="visibility: hidden;"></label>

																	<input type="submit" class="btn btn-success" value="{{ trans('app.Chop etish')}}">

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
					<div class="card-body">
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

				

		    });

		</script>

		<script>

	    $(document).ready(function(){

	    	$('select.select-class').select2({
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

				minimumResultsForSearch: Infinity});

	    	$('div.customer-type-button').on('click',(e)=>{

			var cType=$(e.target).attr('val');

			console.log('customer type selected',cType);

			if(cType=='new'){

				$('div.customer-type-button[val="new"]').addClass('selected');

				$('div.customer-type-button[val="restore"]').removeClass('selected');

				$('div.unique').hide();

			}else if(cType=='restore'){

				$('div.customer-type-button[val="new"]').removeClass('selected');

				$('div.customer-type-button[val="restore"]').addClass('selected');

				$('div.unique').show();

			}

		});

	    });

    	</script>

		<script>

			$('input.payment-date').datetimepicker({

				format:'yyyy-mm-dd',

				autoclose:1,

				minView:2,

				startView:'decade',

				endDate: new Date()

			});

			$('input.given-date').datetimepicker({

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
@extends('layouts.app')

@section('content')
<style>
.removeimage{float:left;    padding: 5px; height: 70px;}
.removeimage .text {
position:relative;
bottom: 45px;
display:block;
left: 20px;
font-size:18px;
color:red;
visibility:hidden;
}
.removeimage:hover .text {
visibility:visible;
}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (CheckAccessUser('vehicle_add', $userid, 'edit')=='yes')
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
						<div class="col-md-12 col-sm-12 col-12">
							<div class="alert alert-success checkbox-circle">
								<label for="checkbox-10 colo_success"> {{trans('app.Texnika qo\'shildi')}}
									<a target="_blank" class="btn btn-success" href="{!! url('vehicle/give_number') !!}?vehicle_id={!! session('vehicle_id') !!}"> 
										{{ trans('app.Davlat raqamini berish') }}
									</a>
									<a target="_blank" class="btn btn-primary" href="{{ url('vehicle/give_licence') }}?vehicle_id={!! session('vehicle_id') !!}">
										{{ trans('app.QX guvoxnoma berish') }}
									</a>
									<a target="_blank" class="btn btn-success" href="{{ url('vehicle/medicineonvehicle') }}?vehicle_id={!! session('vehicle_id') !!}">
										{{ trans('app.Texnikani texnik ko\'rikdan o\'tkazish') }}
									</a> 
									<a target="_blank" class="btn btn-primary" href="{{ url('vehicle/add') }}">
										<i class="fa fa-plus-circle"></i>
										{{ trans('app.Texnika qo\'shish') }}
									</a>
									<a target="_blank" class="btn btn-primary" href="{{ url('vehicle/list') }}">
										<span class="visible-xs"></span>
										<i class="fa fa-list fa-lg">&nbsp;</i>
										{{ trans('app.Vehicle List')}}
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
													<a href="{!! url('/vehicle/list')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-list fa-lg">&nbsp;</i> 
														{{ trans('app.Qo\'shish')}}
													</a>
												</li>
												<li class="active">
													<a href="{!! url('/vehicle/list/edit/'.$editid.'/'.$owner->city_id)!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
														{{ trans('app.Tahrirlash')}}</b>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<form  action="javascript:void(0)" id="vehicle_edit" enctype="multipart/form-data" >
												<div class="row">
												
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<div class="col-md-12" style="margin-bottom: 15px;">
														<label class="form-label" style="visibility: hidden;">
															Texnika egasi</label>
														<div class="row">
															<div class="col-3 pr-0">
																	<div class="customer-type-button py-2 <?php if($vehicaledit->type=='agregat')echo "selected"; ?>" val='agregat'>
																		Agregat
																	</div>
															</div>
															<div class="col-3 pr-0">
																	<div class="customer-type-button py-2 <?php if($vehicaledit->type=='tirkama')echo "selected"; ?>" val='tirkama'>
																		Tirkama
																	</div>
															</div>
															<div class="col-3 pl-0">
																	<div class="customer-type-button py-2 <?php if($vehicaledit->type=='vehicle')echo "selected"; ?>" val='vehicle'>
																		O'ziyurar
																	</div>
															</div>

														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">											
															<label class="form-label" for="first-name">{{ trans('app.Owner name')}}
															<label class="text-danger">*</label></label>
															<select class="form-control owner_search" required name="owner_id">
																<option value="{{ $owner->id }}" selected>
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
																		<option 
																			@if($vehicaledit->category==$category->id) 
																				selected
																			@endif
																			value="{{ $category->id }}">{{ $category->name }}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>	
													<div class="col-md-6 name self">
														<div class="form-group">
															<label class="form-label" for="first-name">
																{{ trans('app.Vehicle Brand')}} 
																<label class="text-danger">*</label>
															</label>
															<select required class="form-control brand_search" name="brand_id" >
																<option selected value="{{ $brand->id }}">{{ $brand->vehicle_brand }}</option>
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
															<select disabled id="vehicletype" required class="form-control type_search w-100"   name="type_id">
																<option selected value="{{ $type->id }}">{{ $type->vehicle_type }}</option>
															</select>
														</div>
													</div>
																								
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label" for="factory-name">{{ trans('app.Factory name')}}
																<label class="text-danger">*</label></label>
															<select required class="form-control factory_search" name="factory_id">
																@if(!empty($factory))
																	<option selected value="{{ $factory->id }}">{{ $factory->name }}</option>
																@endif
															</select>
														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Yetkazib beruvchi')}}
																<label class="text-danger">*</label></label>
															<select name="supplier" required type="text" placeholder="{{ trans('app.Yetkazib berivchini kiriting')}}" class="form-control diller" >
																@if(!empty($vehicle_supplier))
																	@foreach($vehicle_supplier as $supplier)
																		<option <?php if($supplier->id == $vehicaledit->supplier_id) echo "selected"; ?> value="{{ $supplier->id }}">{{ $supplier->name }}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label" for="first-name">{{ trans('app.Select Condition')}}
																<label class="text-danger">*</label> </label>
															<select class="form-control condition select2" name="condition">

																<option 
																	@if($vehicaledit->condition=='fit') 
																		selected 
																	@endif 
																value="fit">{{ trans('app.Fit')}}</option>
																<option 
																	@if($vehicaledit->condition=='unfit') 
																		selected 
																	@endif 
																	value="unfit">{{trans('app.Invalid')}}</option>
															</select> 
														</div>
													</div>
													
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label" for="first-name">{{ trans('app.Select Working Type')}}
																<label class="text-danger">*</label></label>
															<select disabled id="workingtype" required class="form-control working_search" name="working_id">
																<option selected value="{{ $working->id }}">{{ $working->name }}</option>
															</select>
														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">
															<div class="row">
																<div class="col-lg-9">
																	<label class="form-label">{{ trans('app.Factory Number')}}</label>
																	<input type="text" class="form-control" name="factory_number" placeholder="{{ trans('app.Enter Factory number')}}" required
																	@if(!empty($vehicaledit->factory_number))
																		value="{{ $vehicaledit->factory_number }}"
																	@endif
																	>	
																</div>
																<div class="col-lg-3">
																	<label class="container-checkbox">Raqamsiz
																	  	<input type="checkbox" class="check-required">
																	  	<span class="checkmark"></span>
																	</label>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">
															<div class="row">
																<div class="col-lg-9">
																	<label class="form-label">{{ trans('app.Chasic No')}}</label>
																	<input type="text"  name="chasicno"  placeholder="{{ trans('app.Enter ChasicNo')}}" class="form-control" required
																	@if(!empty($vehicaledit->chassisno))
																		value="{{ $vehicaledit->chassisno }}"
																	@endif 
																	>
																</div>
																<div class="col-lg-3">
																	<label class="container-checkbox">Raqamsiz
																	  	<input type="checkbox" class="check-required">
																	  	<span class="checkmark"></span>
																	</label>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-6 agregat">
														<div class="form-group">
															<div class="row">
																<div class="col-lg-9">
																		<label class="form-label">{{ trans('app.Kuzov No')}}</label>
																		<input type="text"  name="corpusno"  placeholder="{{ trans('app.Kuzov raqamini kiriting')}}" maxlength="30" class="form-control" required
																		@if(!empty($vehicaledit->corpusno))
																			value="{{ $vehicaledit->corpusno }}"
																		@endif
																		>
																	</div>
																<div class="col-lg-3">
																	<label class="container-checkbox">Raqamsiz
																	  	<input type="checkbox" class="check-required">
																	  	<span class="checkmark"></span>
																	</label>
																</div>
															</div>															
														</div>
													</div>
													<div class="col-md-6 agregat tirkama">
														<div class="form-group">
															<div class="row">
																<div class="col-lg-9">
																	<label class="form-label">{{ trans('app.Engine No')}}</label>
																	<input required type="text"  name="engineno"  placeholder="{{ trans('app.Enter Engine No')}}" maxlength="30" class="form-control" 
																	@if(!empty($vehicaledit->engineno))
																		value="{{ $vehicaledit->engineno }}"
																	@endif
																	>
																</div>
																<div class="col-lg-3">
																	<label class="container-checkbox">Raqamsiz
																	  	<input type="checkbox" class="check-required">
																	  	<span class="checkmark"></span>
																	</label>
																</div>
															</div>
														</div>
													</div>										
													<div class="col-md-3 agregat tirkama">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Dvigatel quvvati')}}
																<label class="text-danger">*</label></label>
															<input name="enginesize" disabled required type="text" placeholder="{{ trans('app.Dvigatel quvvatini kiriting')}}" maxlength="30" class="form-control" 
																@if(!empty($vehicaledit->enginesize))
																	value="{{ $vehicaledit->enginesize }}"
																@endif
															>
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
																<input required id="myDatepicker2" class="form-control fc-datepicker" name="modelyear" placeholder="yyyy" value="{{ $vehicaledit->modelyear }}">
																
															</div>
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.To\'la vazni')}}
																<label class="text-danger">*</label></label>
															<input name="weight_full" required type="text" placeholder="{{ trans('app.Texnika to\'la vaznini kiriting')}}" maxlength="30" class="form-control" 
																@if(!empty($vehicaledit->weight_full))
																	value="{{ $vehicaledit->weight_full }}"
																@endif
															>
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Yuksiz vazni')}}
																<label class="text-danger">*</label></label>
															<input name="weight" required type="text" placeholder="{{ trans('app.Texnika yuksiz vaznini kiriting')}}" maxlength="30" class="form-control" 
																@if(!empty($vehicaledit->weight))
																	value="{{ $vehicaledit->weight }}"
																@endif
															>
														</div>
													</div>
													<div class="col-md-3 agregat tirkama">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Yonilg\'i turi')}}
																<label class="text-danger">*</label></label>
															<select name="fuel" required type="text" placeholder="{{ trans('app.Texnika yonilg\'i turini kiriting')}}" class="form-control fuel-type" >
																@if(!empty($fuel_type))
																	@foreach($fuel_type as $fuel)
																		<option <?php if($vehicaledit->fuel_id == $fuel->id) echo "selected"; ?> value="{{ $fuel->id }}">{{ $fuel->name }}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Select Colors')}}
																<label class="text-danger">*</label></label>
															<select required class="form-control select-color" name="color">
																<option value>Rang tanlang</option>
																@if(!empty($vehicle_color))
																	@foreach($vehicle_color as $color)
																		<option <?php if($color->id == $vehicaledit->color_id) echo "selected"; ?> value="{{ $color->id }}">{{ $color->color }}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label" style="visibility: hidden;">label</label>
															<label class="custom-switch">
																<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
																<span class="custom-switch-indicator"></span>
																<span class="custom-switch-description">{{ trans('app.Lizing')}}</span>
															</label>
														</div>
													</div>	
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label" style="visibility: hidden;">label</label>
															<input type="hidden" name="lising_id" id="lising_id" value="0">
															<input type="hidden" name="vehicle_type_id" id="vehicle_type_id" value="{{$vehicaledit->type}}">
															<input type="submit" class="btn btn-success" value="{{ trans('app.Saqlash')}}">
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
    $('#myDatepicker').datetimepicker();
    
    $('#myDatepicker2').datetimepicker({
       format: "yyyy",
		autoclose: 2,
		minView: 4,
		startView: 4,
    });
</script>
<script type="text/javascript">
    $(".datepicker").datetimepicker({
		format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
	});
 </script>

<script type="text/javascript">
	$(document).ready(function(){
		$('select.type_search').select2({
			placeholder:'Texnika turini kiriting',
			minimumInputLength:2
		});
		$('select.brand_search').change(function(){
			$("#vehicletype").html('');
			$("#workingtype").html('');
			var id = $(this).val();
			var type = $('input[name="vehicle_type_id"]').val();
			if (id) {
				$.ajax({
					type:'GET',
					url:'/vehicle/vehiclebrandselect',
					data:'brand='+id,
					success:function(data){
						var fdata = $.parseJSON(data);
						if(type == 'vehicle' && fdata.enginesize == 0){
							swal({
								title: fdata.brand,
								text: "Kiritilgan Texnikada Dvigatel quvvati kiritilmagan Adminstrator bn bog'laning",
					            type: "warning",
					            confirmButtonColor: "#DD6B55",
					            confirmButtonText: "Boshqa rusum kiritish",
							}).then((isConfirm) => {	
								$('select.brand_search').val(null).trigger('change');	
								$('select.brand_search').focus();				
							});
						}else{
							$("#vehicletype").html('<option selected="selected" value="'+fdata.type_id+'">'+fdata.type+'</option>');
							$("#workingtype").html('<option selected="selected" value="'+fdata.working_id+'">'+fdata.working+'</option>');
							$("#working_id").val(fdata.working_id);
							$("#type_id").val(fdata.type_id);
							$('input[name="enginesize"]').val(fdata.enginesize);
						}
						
						
					}
				});
			}
		});
	})
</script>

<script>
    $(document).ready(function(){

    		$('.check-required').on('change', function(){
	   		if($(this).is(':checked')){

	   			$(this).closest('.form-group').find('input[type="text"]').attr('disabled','disabled');
	   		}

	   		else{
	   			$(this).closest('.form-group').find('input[type="text"]').removeAttr('disabled');
	   		}
	   	});

		@if($vehicaledit->type=='agregat')
			$('.agregat').hide();
			$('.agregat input').removeAttr("required");
			$('.tirkama input').removeAttr("required","required");
		@elseif($vehicaledit->type == 'tirkama')
			$('.tirkama input').removeAttr("required","required");
			$('.tirkama').hide();
		@endif

		$('div.customer-type-button').on('click',(e)=>{

			var cType=$(e.target).attr('val');

			if(cType=='agregat'){
				$('div.customer-type-button[val="agregat"]').addClass('selected');
				$('div.customer-type-button[val="vehicle"]').removeClass('selected');
				$('div.customer-type-button[val="tirkama"]').removeClass('selected');
				$("#vehicle_type_id").val('agregat');
				$('.self').show();
				$('.agregat').hide();
				$('.agregat input').removeAttr("required");
				$('#amount_new').show();
			}else if(cType=='vehicle'){

				$('div.customer-type-button[val="agregat"]').removeClass('selected');
				$('div.customer-type-button[val="tirkama"]').removeClass('selected');
				$('div.customer-type-button[val="vehicle"]').addClass('selected');
				$("#vehicle_type_id").val('vehicle');
				$('.self').show();
				$('.agregat').show();
				$('.agregat input').attr("required","required");
				$('#amount_new').show();
			}else if(cType=='tirkama'){
				$('div.customer-type-button[val="agregat"]').removeClass('selected');
				$('div.customer-type-button[val="vehicle"]').removeClass('selected');
				$('div.customer-type-button[val="tirkama"]').addClass('selected');
				$("#vehicle_type_id").val('tirkama');
				$('.self').show();
				$('.agregat').show();
				$('.tirkama').hide();
				$('.tirkama input').removeAttr("required","required");
				$('#amount_new').show();
				}	
			});
    	
    	$('input[name="engineno"], input[name="chasicno"], input[name="corpusno"').change(function(){
    		var brand = $('select[name="brand_id"]').val();
			var engineno=$('input[name="engineno"]').val();
			var chasicno=$('input[name="chasicno"]').val();
			var corpusno=$('input[name="corpusno"]').val();

			if(engineno){
				$.ajax({
					type:'GET',
					url:'/certificate/check-engineno',
					data: 'engineno='+engineno+'&type=engine'+'&edit='+'{{$editid}}'+'&brand=' + brand,

					success:function(data){
						var fdata = $.parseJSON(data);
						console.log(fdata);
						
						if(fdata.type == 'exist'){							
							var owner = "Texnika egasi: " + fdata.ownername + ";  " + "Texnika rusumi: " + fdata.vehiclename;
							swal({
								title: "{{ trans('app.Kritilgan Dvigatel raqami mavjud!') }}",
					            type: "warning",
					            text: owner,
					            showCancelButton: true,
					            cancelButtonText: "Boshqa raqam kiritish",
					            confirmButtonColor: "#DD6B55",
					            confirmButtonText: "Texnikani ko'rish",
					            closeOnConfirm: true
							}).then((isConfirm) => {								
									window.open("/vehicle/list/view/"+fdata.vehicle_id+"/"+fdata.city_id,"_blank");						
							}).catch((err) => {
								$('input[name=engineno]').val("");
								$('input[name=engineno]').focus();
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
					data: 'chasicno='+chasicno+'&type=chasic'+'&edit='+'{{$editid}}'+'&brand=' + brand,
					success:function(data){
						var fdata = $.parseJSON(data);
						console.log(fdata);
						if(fdata.type == 'exist'){
							var owner = "Texnika egasi: " + fdata.ownername + ";  " + "Texnika rusumi: " + fdata.vehiclename;
							swal({
								title: "{{ trans('app.Kritilgan shassi raqami mavjud!') }}",
					            type: "warning",
					            text: owner,
					            showCancelButton: true,
					            cancelButtonText: "Boshqa raqam kiritish",
					            confirmButtonColor: "#DD6B55",
					            confirmButtonText: "Texnikani ko'rish",
					            closeOnConfirm: true
							}).then((isConfirm) => {
									window.open("/vehicle/list/view/"+fdata.vehicle_id+"/"+fdata.city_id,"_blank");
							}).catch((err) => {
								$('input[name=chasicno]').val("");
								$('input[name=chasicno]').focus();
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
					data: 'corpusno='+corpusno+'&type=corpus'+'&edit='+'{{$editid}}'+'&brand=' + brand,

					success:function(data){
						var fdata = $.parseJSON(data);
						console.log(fdata);

						if(fdata.type == 'exist'){
							var owner = "Texnika egasi: " + fdata.ownername + ";  " + "Texnika rusumi: " + fdata.vehiclename;

							swal({
								title: "{{ trans('app.Kritilgan kuzov raqami mavjud!') }}",
					            type: "warning",
					            text: owner,
					            showCancelButton: true,
					            cancelButtonText: "Boshqa raqam kiritish",
					            confirmButtonColor: "#DD6B55",
					            confirmButtonText: "Texnikani ko'rish",
					            closeOnConfirm: true
							}).then((isConfirm) => {
									window.open("/vehicle/list/view/"+fdata.vehicle_id+"/"+fdata.city_id,"_blank");
							}).catch((err) => {
								$('input[name=corpusno]').val("");
								$('input[name=corpusno]').focus();
							});
						}



					},

					error:function(err){

						console.log(err);

					}

				});

			}
		});

    	$('select.owner_category').select2({
    		language:{
				inputTooShort:function(){

					return 'Tuman yoki shahar nomini kiritib izlang';

				},

				searching:function(){

					return 'Izlanmoqda...';

				},

				noResults:function(){

					return "Natija topilmadi"

				},

				errorLoading:function(){
							return "Natija topilmadi";
						}

			},
			placeholder:'Texnika kategoriyasini tanlang',
    		minimumResultsForSearch: Infinity
    	});

    	$('select.workingtypeselect').select2({

    		language:{
				inputTooShort:function(){

					return 'Tuman yoki shahar nomini kiritib izlang';

				},

				searching:function(){

					return 'Izlanmoqda...';

				},

				noResults:function(){

					return "Natija topilmadi"

				},

				errorLoading:function(){
							return "Natija topilmadi";
						}

			},
    		placeholder: "Ish turini tanlang"
    	});

    	$('select.condition').select2({

    		language:{
				inputTooShort:function(){

					return 'Tuman yoki shahar nomini kiritib izlang';

				},

				searching:function(){

					return 'Izlanmoqda...';

				},

				noResults:function(){

					return "Natija topilmadi"

				},

				errorLoading:function(){
							return "Natija topilmadi";
						}

			},
    		placeholder: 'Texnika holatini tanlang',
			minimumResultsForSearch: Infinity});

    	$('select.vehical_brand_select').select2({

    		language:{
				inputTooShort:function(){

					return 'Tuman yoki shahar nomini kiritib izlang';

				},

				searching:function(){

					return 'Izlanmoqda...';

				},

				noResults:function(){

					return "Natija topilmadi"

				},

				errorLoading:function(){
							return "Natija topilmadi";
						}

			},
			minimumResultsForSearch: Infinity});

   		$('select.vehical_working_type').select2({

    		language:{
				inputTooShort:function(){

					return 'Tuman yoki shahar nomini kiritib izlang';

				},

				searching:function(){

					return 'Izlanmoqda...';

				},

				noResults:function(){

					return "Natija topilmadi"

				},

				errorLoading:function(){
							return "Natija topilmadi";
						}

			},
		 minimumResultsForSearch: Infinity});

   		$('select.fuel-type').select2({

    		language:{
				inputTooShort:function(){

					return 'Tuman yoki shahar nomini kiritib izlang';

				},

				searching:function(){

					return 'Izlanmoqda...';

				},

				noResults:function(){

					return "Natija topilmadi"

				},

				errorLoading:function(){
							return "Natija topilmadi";
						}

			},
   			placeholder: "Yonilg'i turini tanlang",
   			minimumResultsForSearch: Infinity
   		});

   		$('select.diller').select2({

    		language:{
				inputTooShort:function(){

					return 'Tuman yoki shahar nomini kiritib izlang';

				},

				searching:function(){

					return 'Izlanmoqda...';

				},

				noResults:function(){

					return "Natija topilmadi"

				},

				errorLoading:function(){
							return "Natija topilmadi";
						}

			},
   			placeholder: "Yetkazib beruvchini kiriting",
   			minimumResultsForSearch: Infinity
   		});
   	});
	$(document).ready(function(){
		$('#vehicle_edit').one('submit',function(e){
			$("#vehicletype").attr('disabled', false);
			$("#workingtype").attr('disabled', false);
			$('input[name="enginesize"]').attr('disabled', false);
			var type = $("#vehicletype").val();
			var work = $("#workingtype").val();
			var lising = $("#lising").is(":checked");
			var messagebox = $("#message");
			if(lising){
				$("#lising_id").val('1');
			}else{
				$("#lising_id").val('0');
			}
			if(type==null){
				swal({
					title: "{{ trans('app.Texnika turi kiritilmagan!') }}",
					text: "{{ trans('app.Davom etish uchun texnika rusumiga texnika turini biriktiring.') }}",					
		            type: "warning",
		            showCancelButton: false,
		            confirmButtonColor: "#DD6B55",
		            confirmButtonText: "Texnika turini kiritish",
		            closeOnConfirm: true
				});
			}else if( work==null){
				swal({
					title: "{{ trans('app.Texnika ish turi kiritilmagan!') }}",
					text: "{{ trans('app.Davom etish uchun texnika rusumiga ish turi biriktiring.') }}",
		            type: "warning",
		            showCancelButton: false,
		            confirmButtonColor: "#DD6B55",
		            confirmButtonText: "Ish turini kiritish",
		            closeOnConfirm: true
				});
			}
			else{
				var submitButton=$(this).find('button[type="submit"]');
				submitButton.addClass('btn-loading');
				e.preventDefault();
				var formArray=$(this).serializeArray();
				var url='/vehicle/list/edit/update/{{$editid}}/{{ $owner->city_id }}';
				$.ajax({
					type:'POST',
					url:url,
					data:formArray,
					success:function(result){
						$("#vehicletype").attr('disabled', true);
						$("#workingtype").attr('disabled', true);
						$('input[name="enginesize"]').attr('disabled', true);
						swal('Saqlandi!','','success');
					},
					error:function(err){
						submitButton.removeClass('btn-loading');
						vswal('Xatolik','','error');
						console.log(err);
					}
				});
			}
			
		});
	});
    $(document).ready(function(){

		$('select.brand_search').select2({
			ajax:{
				url:'/vehicle/brand_search_name',
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
				url:'/vehicle/factory_search_name',
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
		$('select.working_search').select2({
			ajax:{
				url:'/vehicle/work_search_name',
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
			placeholder:'Ishlash soahsini kiriting',
			minimumInputLength:2
		});
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
	});
</script>


<!-- factory type -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endsection
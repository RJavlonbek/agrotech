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
@if (CheckAccessUser('vehicle_add', $userid, 'create')=='yes')
			<div class="section">
				<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Vehicle')}}
						</li>
					</ol>
				</div>
					<div class="row massage" id="message" >
						
					</div>
					<div class="row" id="showingform">
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
														{{ trans('app.Ro\'yxat')}}
													</a>
												</li>
												<li class="active">
													<a href="{!! url('/vehicle/add')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
														{{ trans("app.Qo'shish")}}</b>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<form  action="javascript:void(0)" id="vehicle_add" >
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
													<div class="col-md-6"></div>
													<div class="col-md-6 self">
														<div class="form-group">											
															<label class="form-label" for="first-name">{{ trans('app.Owner name')}}
															<label class="text-danger">*</label></label>
															<select class="form-control owner_search select-owner" required name="owner_id">
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
													<div class="col-12 col-md-6 self">
														<div class="form-group">											
															<label class="form-label" for="">{{ trans('app.Category')}}
															<label class="text-danger">*</label></label>
															<select class="form-control owner_category" required name="category">
																<option value>Kategoriyani tanlang</option>
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
															<select required class="form-control brand_search" name="brand_id" ></select>
														</div>
													</div>													
													<div class="col-md-6 self">
														<div class="form-group overflow-hidden">
															<label class="form-label" for="first-name">
																{{ trans('app.Vehicle Type')}} 
															</label>
															<select id="vehicletype" required class="form-control type_search w-100" disabled   name="type_name"></select>
															<input id="type_id" required type="hidden" class="form-control" name="type_id" >
														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label" >{{ trans('app.Working Type')}}
															</label>
															<select id="workingtype" required class="form-control workingtypeselect" disabled name="name"></select>
															<input id="working_id" required type="hidden" class="form-control" name="working_id" >
														</div>

													</div>											
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label" for="factory-name">{{ trans('app.Factory name')}}
															<label class="text-danger">*</label></label>
															<select required class="form-control factory_search" name="factory_id"></select>
														</div>
													</div>
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Yetkazib beruvchi')}}
																<label class="text-danger">*</label></label>
															<select name="supplier"  type="text" placeholder="{{ trans('app.Yetkazib berivchini kiriting')}}" class="form-control diller" >
																<option value disabled selected>Yetkazib beruvchini tanlang</option>
																@if(!empty($suppliers))
																	@foreach($suppliers as $supplier)
																		<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
																<option value disabled selected style="color: #999 !important;">Texnika holatini tanlang</option>
																<option value="fit">{{ trans('app.fit')}}</option>
																<option value="unfit">{{trans('app.unfit')}}</option>
															</select> 
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
															<label class="form-label">{{ trans('app.Factory Number')}}</label>
															<input type="text" class="form-control" name="factory_number" placeholder="{{ trans('app.Enter Factory number')}}">	
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Chasic No')}}
															</label>
															<input type="text"  name="chasicno"  placeholder="{{ trans('app.Enter ChasicNo')}}" class="form-control" >
														</div>
													</div>
													<div class="col-md-3 agregat">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Kuzov No')}}
															</label>
															<input type="text"  name="corpusno"  placeholder="{{ trans('app.Kuzov raqamini kiriting')}}" maxlength="30" class="form-control" >
														</div>
													</div>
													<div class="col-md-3 agregat">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Engine No')}}
																<label class="text-danger">*</label></label>
															<input required type="text"  name="engineno"  placeholder="{{ trans('app.Enter Engine No')}}" maxlength="30" class="form-control" >
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
																<option value>yonilg'i</option>
																@if(!empty($fuels))
																	@foreach($fuels as $fuel)
																		<option value="{{ $fuel->id }}">{{ $fuel->name }}</option>
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
																@if(!empty($colors))
																	@foreach($colors as $color)
																		<option value="{{ $color->id }}">{{ $color->color }}</option>
																	@endforeach
																@endif
															</select>
														</div>
													</div>
													<div id="amount_new" class="col-md-4 col-12 ">
														<div class="form-group ">
															<label class="form-label" >{{ trans('app.To\'lov miqdori')}}</label>
															<div class="input-group">
																<input disabled id="reg_amount_new" class="form-control " type="number" min="0" step="100" name="totalamount" placeholder="To'lov miqdori" value="" />
															</div>
														</div>
													</div>
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label" style="visibility: hidden;">label</label>
															<label class="custom-switch">
																<input id="lising" type="checkbox" name="lising" class="custom-switch-input">
																<input type="hidden" name="lising_id" id="lising_id" value="0">
																<input type="hidden" name="vehicle_type_id" id="vehicle_type_id">
																<input type="hidden" class="form-control fc-datepicker vehicle-date doo" name="date" placeholder="dd-mm-yyyy" value="{{ date('d-m-Y') }}" />
																<span class="custom-switch-indicator"></span>
																<span class="custom-switch-description">{{ trans('app.Lizing')}}</span>
															</label>
														</div>
													</div>													
													<div class="col-md-3 self">
														<div class="form-group">
															<label class="form-label" style="visibility: hidden;">label</label>
															<button type="submit" id="formsubmitbutton" class="btn btn-success">{{ trans('app.Saqlash')}}</button>
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
		endDate: new Date()
		
    });
    $('input.vehicle-date').datetimepicker({
		format:'dd-mm-yyyy',
		autoclose:1,
		minView:2,
		startView:'decade',
		endDate: new Date()
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#message').hide();
		$('select.select-color').select2({
			placeholder: "Texnika rangini tanlang",
			minimumResultsForSearch: Infinity
		})
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

			}
		});
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
		$('#vehicle_add').one('submit',function(e){
			$("#reg_amount_new").attr('disabled', false);
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
				var url='/vehicle/store';
				$.ajax({
					type:'POST',
					url:url,
					data:formArray,
					success:function(result){
						$("#showingform").hide();
						$("#message").show();
						$("#reg_amount_new").attr('disabled', true);
						data = '<div class="col-md-12 col-sm-12 col-12"><div class="alert alert-success checkbox-circle"><div class="row"><div class="col-12 m-2"><label class="form-label" for="checkbox-10 colo_success">Texnika qo\'shildi</label></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/vehicle/transport-number?vehicle_id='+result+'">Davlat raqami berish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/add?vehicle_id='+result+'">Texnik Pasport/Guvohnoma berish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/medadd?vehicle_id='+result+'">Texnikani texnik ko\'rikdan o\'tkazish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/vehicle/add"><i class="fa fa-plus-circle"></i>Texnika qo\'shish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/vehicle/list"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>Texnikalar ro\'yxati</a></div></div></div>';
						$("#message").html(data);
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
</script>
<!-- vehicle type -->
<script>
    $(document).ready(function(){

    	$('select.owner_category').select2({
			placeholder:'Texnika kategoriyasini tanlang',
    		minimumResultsForSearch: Infinity
    	});

    	$('select.workingtypeselect').select2({
    		placeholder: "Ish turini tanlang"
    	});

    	$('select.condition').select2({
    		placeholder: 'Texnika holatini tanlang',
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
   			placeholder: "Yetkazib beruvchini kiriting",
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
			language:{

			inputTooShort:function(){

				return '2 ta yoki undan ko\'p harf kiriting';

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
			minimumInputLength:2,
			language:{

				inputTooShort:function(){

					return '2 yoki undan ko\'p belgi kiritib izlang';

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

			}
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

					return 'Mulk egasini nomi, STIR ini kiritib izlang';

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
			placeholder:'Texnika egasini kiriting',
			minimumInputLength:2
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

		$('select.brand_search').change(function(){
			$("#vehicletype").html('');
			$("#workingtype").html('');
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
						if(data!='no'){
							var fdata = $.parseJSON(data);
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



					}

				});

			}
			if(chasicno){
				$.ajax({
					type:'GET',
					url:'/certificate/check-engineno',
					data: 'chasicno='+chasicno+'&type=chasic',

					success:function(data){
						if(data!='no'){
							var fdata = $.parseJSON(data);
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
						}
						



					},

					error:function(err){

						console.log(err);

					}

				});

			}
			if(corpusno){
				$.ajax({
					type:'GET',
					url:'/certificate/check-engineno',
					data: 'corpusno='+corpusno+'&type=corpus',

					success:function(data){
						if(data!='no'){
							var fdata = $.parseJSON(data);
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script type="text/javascript">
	$(document).ready(function(){
		$('.self').hide();
		$('.agregat').hide();
		$('#amount_new').hide();

		$('div.customer-type-button').on('click',(e)=>{

		var cType=$(e.target).attr('val');

		if(cType=='agregat'){

			$('div.customer-type-button[val="agregat"]').addClass('selected');

			$('div.customer-type-button[val="vehicle"]').removeClass('selected');

			$("#vehicle_type_id").val('agregat');

			$('.self').show();
			$('.agregat').hide();
			$('#amount_new').show();
			$('.agregat input').removeAttr("required");
			$('#reg_amount_new').val({{ $min->payment*($payment_a->payment/100) }});

		}else if(cType=='vehicle'){

			$('div.customer-type-button[val="agregat"]').removeClass('selected');

			$('div.customer-type-button[val="vehicle"]').addClass('selected');

			$("#vehicle_type_id").val('vehicle');

			$('.self').show();
			$('.agregat').show();
			$('#amount_new').show();
			$('.agregat input').attr("required","required");
			$('#reg_amount_new').val({{ $min->payment*($payment_v->payment/100) }});
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
    	days:["Yakshanba","Dushanba","Seshanba","Chorshanba","Payshanba","Juma","Shanba","Yakshanba"],
    	daysShort:["Yak","Du","Se","Chor","Pay","Jum","Shan","Yak"],
    	daysMin:["Ya","Du","Se","Chor","Pa","Ju","Sha","Ya"],
    	months:["Yanvar","Fevral","Mart","Aprel","May","Iyun","Iyul","Avgust","Sentabr","Oktabr","Noyabr","Dekabr"],
    	monthsShort:["Yan","Fev","Mar","Apr","May","Iyun","Iyul","Avg","Sen","Okt","Noy","Dek"],
    	today: "Bugun",
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
</script>

@endsection
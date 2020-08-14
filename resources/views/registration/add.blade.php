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

			  .bs-tooltip-auto[x-placement^=bottom] .arrow::before,
			  .bs-tooltip-auto[x-placement^=top] .arrow::before,
			  .bs-tooltip-bottom .arrow::before,
			   .bs-tooltip-top .arrow::before{
			    border-bottom-color: #f00;
			    border-top-color: #f00;
			    /* Red */
			  }

			  .tooltip-inner{
			  	background-color: #fff;
			  	border: 1px #f00 solid;
			  	color: #f00;
			  }

			  .red-border{
			  	border: 1px #f00 solid;
			  }

		</style>
			<!-- page content -->
		<?php $userid = Auth::user()->id; ?>
		@if (CheckAccessUser('vehicle_reg', $userid, 'create')=='yes')
				<div class="section">
					<div class="page-header">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="/"><i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Ro\'yxatga olish')}}
								</a>
							</li>
						</ol>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">									
								<div class="card-body">
									<div class="row massage" id="message" >
					
									</div>
									<div class="row" id="showingform">

										<div class="col-md-6">
											<label class="form-label" style="visibility: hidden;">asd</label>
											<div class="row">
												<div class="col-6 pr-0">
													<div class="vehicle_type-button customer-type-button py-2" val="new">
														Yangi ro'yxatdan o'tkazish
													</div>
												</div>
												<div class="col-6 pl-0">
													<div class="vehicle_type-button customer-type-button py-2 <?=$vehicle?'selected':'';  ?>" val="old"
														

													>
														Qayta ro'yxatdan o'tkazish
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6"></div>

										<div class="col-md-12 col-sm-12 col-12 tab-content" id="old" <?=$vehicle?'':'d="none"'; ?>>
											<form  action="javascript:void(0)"  id="vehicle-reg-add">
												<input type="hidden" name="_token" value="{{csrf_token()}}">
												<div class="row">
													<div class="col-12 new-regged">
														<div class="row">	
															<div class="col-md-4 hider">
																<div class="form-group">
																	<label class="form-label" for="first-name">{{ trans('app.Texnika egasi')}} <label class="text-danger">*</label></label>
																	<select class="form-control owner_search" name="owner_id" required="required">
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
															<div class="col-md-4 col-12 hider">
																<div class="form-group">
																	<label class="form-label" for="factory-name">{{ trans('app.Vehicle')}} <label class="text-danger">*</label></label>
																	<select name="vehicle_id" class="form-control select-class-vehicle vehicle_name" required="required">
																		<option value>option</option>	
																		@if(!empty($vehicle))
																			<option selected="selected" value="{{ $vehicle->vehicle_id }}">{{ $vehicle->brandname.'-'.$vehicle->typename }}</option>
																		@endif
																	</select>
																</div>
															</div>
															<div class="col-4 form-group">
                        										<label class="form-label">Asos</label>
                        										<select class="form-control select-doc" name="doc" required="required">
                        											<option value="">Asos hujjatni tanlang</option>
                        											@if(!empty($documents))
                        												@foreach($documents as $doc)
                        													<option <?=$doc->id==10?'disabled':'' ?> value="{{$doc->id}}">{{$doc->name}}</option>
                        												@endforeach
                        											@endif
                        										</select>
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
																			<input readonly="true"class="form-control fc-datepicker reg-date" name="regdate" placeholder="dd-mm-yyyy" value="{{ date('d-m-Y') }}" />
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-md-4 col-12 payment1 hider">
																<div class="wd-200 mg-b-30">
																	<div class="row">
																		<div class="col-7">
																			<div class="form-group hider">
																				<label class="form-label" >{{ trans('app.To\'lov miqdori')}}</label>
																				<div class="input-group">
																					<input disabled="" id="reg_amount" class="form-control " type="number" min="0" step="100" name="totalamount" placeholder="To'lov miqdori" value="" />
																				</div>
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
															<div class="col-12 col-md-12 hider">
																<div class="form-group">
																	<div class="col-12 text-right">
																		<label class="form-label" style="visibility: hidden;"></label>
																		<input id="action" type="hidden" name="action" value="regged">
																		<input class="rereg" type="hidden" name="vehicle_typefor_reg">
																		<button type="submit" id="formsubmitbutton" class="btn btn-success">{{ trans('app.Saqlash')}}</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</form>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12 tab-content" id="new" d='none'>
											<form  action="javascript:void(0)" id="vehicle_add" >
												<div class="row">
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<div class="col-md-12" style="margin-bottom: 15px;">
														<label class="form-label" style="visibility: hidden;">
															Texnika egasi</label>
														<div class="row">
															<div class="col-3 pr-0">
																	<div class="customer-type-button py-2 new-add" val='agregat'>
																		Agregat
																	</div>
															</div>
															<div class="col-3 pr-0">
																	<div class="customer-type-button py-2 new-add" val='tirkama'>
																		Tirkama
																	</div>
															</div>
															<div class="col-3 pl-0">
																	<div class="customer-type-button py-2 new-add" val='vehicle'>
																		O'ziyurar
																	</div>
															</div>

														</div>
													</div>
													<div class="col-md-4 self">
														<div class="form-group">											
															<label class="form-label" for="first-name">{{ trans('app.Texnika egasi')}}
															<label class="text-danger">*</label></label>
															<div class="row">
																<div class="col-9">
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
																<div class="col-3 addremove">
																	<a style="color: white;" href="{!! url('customer/add') !!}" target="_blank">
																		<div class="btn btn-success">
																			
																				Qo'shish
																			
																		</div>	
																	</a>								
																</div>
															</div>													
														</div>
													</div>	
													<div class="col-12 col-md-4 self">
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
													<div class="col-4 form-group self overflow-hidden">
                										<label class="form-label">Asos</label>
                										<select class="form-control custom-select select-doc" name="doc" required="required">
                											<option value="">Asos hujjatni tanlang</option>
                											@if(!empty($documents))
                												@foreach($documents as $doc)
                													<option value="{{$doc->id}}">{{$doc->name}}</option>
                												@endforeach
                											@endif
                										</select>
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
															<select class="form-control condition select2" name="condition" required>
																<option value disabled selected style="color: #999 !important;">Texnika holatini tanlang</option>
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
													<div class="col-md-6 self">
														<div class="form-group">
															<div class="row">
																<div class="col-9">
																	<label class="form-label">{{ trans('app.Factory Number')}}</label>
																	<input type="text" class="form-control" name="factory_number" placeholder="{{ trans('app.Enter Factory number')}}" required>	
																</div>
																<div class="col-3">
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
																<div class="col-9">
																	<label class="form-label">{{ trans('app.Chasic No')}}</label>
																	<input type="text"  name="chasicno"  placeholder="{{ trans('app.Enter ChasicNo')}}" class="form-control" required>
																</div>
																<div class="col-3">
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
																<div class="col-9">
																		<label class="form-label">{{ trans('app.Kuzov No')}}</label>
																		<input type="text"  name="corpusno"  placeholder="{{ trans('app.Kuzov raqamini kiriting')}}" maxlength="30" class="form-control" required>
																	</div>
																<div class="col-3">
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
																<div class="col-9">
																	<label class="form-label">{{ trans('app.Engine No')}}</label>
																	<input required type="text"  name="engineno"  placeholder="{{ trans('app.Enter Engine No')}}" maxlength="30" class="form-control" >
																</div>
																<div class="col-3">
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
															<input disabled required name="enginesize" type="text" placeholder="{{ trans('app.Dvigatel quvvatini kiriting')}}" maxlength="30" class="form-control" >
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
													<div class="col-md-3 agregat tirkama">
														<div class="form-group">
															<label class="form-label">{{ trans('app.Yonilg\'i turi')}}
																<label class="text-danger">*</label></label>
															<select name="fuel"  type="text" placeholder="{{ trans('app.Texnika yonilg\'i turini kiriting')}}" class="form-control fuel-type" required>
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
													<div class="col-md-6 col-12 self">
														<div class="row">
															<div class="col-7">
																<div id="amount_new" class="form-group ">
																	<label class="form-label" >{{ trans('app.To\'lov miqdori')}}</label>
																	<div class="input-group">
																		<input disabled id="reg_amount_new" class="form-control " type="number" min="0" step="100" name="totalamount" placeholder="To'lov miqdorin" value="" />
																	</div>
																</div>
															</div>
															<div class="col-5">
																<label class="container-checkbox">
																	<span id="tolandi">to'landi</span>
																  	<input type="checkbox" required class="check-paid">
																  	<span class="checkmark"></span>
																</label>
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
																<input type="hidden" name="vehicle_typefor_reg">
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
		    	days:["Yakshanba","Dushanba","Seshanba","Chorshanba","Payshanba","Juma","Shanba","Yakshanba"],
	    		daysShort:["Yak","Du","Se","Chor","Pay","Jum","Shan","Yak"],
	    		daysMin:["Ya","Du","Se","Chor","Pa","Ju","Sha","Ya"],
	    	  months:["Yanvar","Fevral","Mart","Aprel","May","Iyun","Iyul","Avgust","Sentabr","Oktabr","Noyabr","Dekabr"],
	    		monthsShort:["Yan","Fev","Mar","Apr","May","Iyun","Iyul","Avg","Sen","Okt","Noy","Dek"],
	    		today: "Bugun",
		       	format: "yyyy",
				autoclose: 2,
				minView: 4,
				startView: 4,
				
		    });
</script>
<script>
	$(document).ready(function(){
		$("select[name='doc']").change(function(){
			var id = $(this).val();
			if(id == 10){
				$('#tolandi').text('Tushundim');
				$('#reg_amount_new').attr('type', 'text');
				$('#reg_amount_new').val("To'lov undirilmaydi");
			}else{
				$('#tolandi').text("To'landi");
				$('#reg_amount_new').attr('type', 'number');
				var type = $("#vehicle_type_id").val();
				if(type == 'vehicle'){
					$('#reg_amount_new').val({{ $min->payment*($payment_v->payment/100) }});
				}else if(type == 'agregat'){
					$('#reg_amount_new').val({{ $min->payment*($payment_a->payment/100) }});
				}else if(type == 'tirkama'){
					$('#reg_amount_new').val({{ $min->payment*($payment_t->payment/100) }});
				}
			}
		})
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
		$('select.vehicle_name').change(function(){
			var vehicle = $(this).val();
			$.ajax({
				type:'GET',
				url:'/vehicle/checktype',
				data:'id='+vehicle,
				success:function(data){
					$('input[name="vehicle_typefor_reg"]').val(data);
				}
			});
		});
        $('select.select-doc').select2({
			minimumResultsForSearch:Infinity,
			placeholder:'Asos hujjatni tanlang'
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
					console.log(data);
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
				return 'Texnika egasi ismi (nomi), STIR ini kiritib izlang';
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
		$('select.vehicle_name').select2({
			ajax:{
				url:'/certificate/searchvehiclereg?type=regged',
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
							text:name.name+' '+name.typename
						}
					});
					return{
						results:data
					}
				}
			},
			placeholder:'Texnikani tanlang',
			language:{

			inputTooShort:function(){

				return 'Rusumi, shassi raqami, kuzov raqami, zavod raqamini kiritib izlang';

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
<script>
	$(document).ready(function(){
	   	@if(!empty($vehicle))
	    	$.ajax({
	    		type:'GET',
	    		url:'/payment/vehicle_reg',
	    		data:'id='+{{$vehicle->vehicle_id}},
	    		success: function(data){
	    			$('#reg_amount').val(data);
	    		}
	    	})
	   	@endif
	   	$('.check-required').on('change', function(){
	   		if($(this).is(':checked')){

	   			$(this).closest('.form-group').find('input[type="text"]').attr('disabled','disabled');
	   		}

	   		else{
	   			$(this).closest('.form-group').find('input[type="text"]').removeAttr('disabled');
	   		}
	   	});

	    $(".vehicle_type-button").on('click', function(){
	    	var vehicle_type = $(this).attr('val');
	    	if(vehicle_type == 'new'){
	    		$('.customer-type-button[val="new"]').addClass('selected');
	    		$('.customer-type-button[val="old"]').removeClass('selected');
	    		$('#old').hide();
	    		$('#new').show();

	    	}else if(vehicle_type == 'old'){
	    		$('.customer-type-button[val="old"]').addClass('selected');
	    		$('.customer-type-button[val="new"]').removeClass('selected');
	    		$('#new').hide();
	    		$('#old').show();
	    	}
	    });

	    $('select.select-class-vehicle').on('change', function(){
	    	var id = $(this).val();
	    	$.ajax({
	    		type:'GET',
	    		url:'/payment/vehicle_reg',
	    		data:'id='+id,
	    		success: function(data){
	    			$('#reg_amount').val(data);
	    		}
	    	})
	    })
	});

</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#message').hide();
		$('select.select-color').select2({
			placeholder: "Texnika rangini tanlang",
			minimumResultsForSearch: Infinity
		})
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
			var veh_type = $("#vehicle_type_id").val();
			$("#vehicletype").attr('disabled', false);
			$("#workingtype").attr('disabled', false);
			$("input[name='enginesize']").attr('disabled', false);
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
				$("#reg_amount_new").removeAttr('disabled');
				var formArray=$(this).serializeArray();
				var url='/vehicle/store';
				$.ajax({
					type:'POST',
					url:url,
					data:formArray,
					success:function(result){
						$("#reg_amount_new").attr('disabled', true);
						$("#vehicletype").attr('disabled', true);
						$("#workingtype").attr('disabled', true);
						$("input[name='enginesize']").attr('disabled', true);
						$("#showingform").hide();
						$("#message").show();
						if(veh_type == 'agregat')
						{
							data = '<div class="col-md-12 col-sm-12 col-12"><div class="alert alert-success checkbox-circle"><div class="row"><div class="col-12 m-2"><label class="form-label" for="checkbox-10 colo_success">Texnika qo\'shildi</label></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/medadd?vehicle_id='+result+'">Texnikani texnik ko\'rikdan o\'tkazish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/add?vehicle_id='+result+'">Texnik Pasport/Guvohnoma berish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/regadd?type=regged"><i class="fa fa-plus-circle"></i>Texnika qo\'shish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/vehicle/list"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>Texnikalar ro\'yxati</a></div></div></div>';	
						}
						else{
							data = '<div class="col-md-12 col-sm-12 col-12"><div class="alert alert-success checkbox-circle"><div class="row"><div class="col-12 m-2"><label class="form-label" for="checkbox-10 colo_success">Texnika qo\'shildi</label></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/vehicle/transport-number?vehicle_id='+result+'">Davlat raqami berish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/medadd?vehicle_id='+result+'">Texnikani texnik ko\'rikdan o\'tkazish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/add?vehicle_id='+result+'">Texnik Pasport/Guvohnoma berish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/regadd?type=regged"><i class="fa fa-plus-circle"></i>Texnika qo\'shish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/vehicle/list"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>Texnikalar ro\'yxati</a></div></div></div>';
						}
						$("#message").html(data);
						swal("Ro'yxatga olindi!","","success");
					},
					error:function(err){
						submitButton.removeClass('btn-loading');
						swal('Xatolik','','error');
						console.log(err);
					}
				});
			}
			
		});
	});
	$(document).ready(function(){
		$('#vehicle-reg-add').one('submit',function(e){
			var submitButton=$(this).find('button[type="submit"]');
			var type = $('input.rereg[name="vehicle_typefor_reg"]').val();
			$("#reg_amount").removeAttr('disabled');
			submitButton.addClass('btn-loading');
			e.preventDefault();
			var formArray=$(this).serializeArray();
			var url='/certificate/regstore';
			$.ajax({
				type:'POST',
				url:url,
				data:formArray,
				success:function(result){
					$("#reg_amount").attr('disabled', true);
						$("#showingform").hide();
						$("#message").show();
						if(type == 'agregat'){
							data = '<div class="col-md-12 col-sm-12 col-12"><div class="alert alert-success checkbox-circle"><div class="row"><div class="col-12 m-2"><label class="form-label" for="checkbox-10 colo_success">Texnika qo\'shildi</label></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/medadd?vehicle_id='+result+'">Texnikani texnik ko\'rikdan o\'tkazish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/add?vehicle_id='+result+'">Texnik Pasport/Guvohnoma berish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/regadd?type=regged"><i class="fa fa-plus-circle"></i>Texnika qo\'shish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/vehicle/list"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>Texnikalar ro\'yxati</a></div></div></div>';
						}else{
							data = '<div class="col-md-12 col-sm-12 col-12"><div class="alert alert-success checkbox-circle"><div class="row"><div class="col-12 m-2"><label class="form-label" for="checkbox-10 colo_success">Texnika qo\'shildi</label></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/vehicle/transport-number?vehicle_id='+result+'">Davlat raqami berish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/medadd?vehicle_id='+result+'">Texnikani texnik ko\'rikdan o\'tkazish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/add?vehicle_id='+result+'">Texnik Pasport/Guvohnoma berish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/certificate/regadd?type=regged"><i class="fa fa-plus-circle"></i>Texnika qo\'shish</a></div><div class="col-12 m-2"><a target="_blank" class="btn btn-primary" style="width: 30%" href="/vehicle/list"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>Texnikalar ro\'yxati</a></div></div></div>';
						}
						$("#message").html(data);
					swal("Ro'yxatga olindi!","","success");
				},
				error:function(err){
					submitButton.removeClass('btn-loading');
					vswal('Xatolik','','error');
					console.log(err);
				}
			});
			
		});
	});
</script>
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
			placeholder:'Texnika turini kiriting',
			minimumInputLength:2
		});
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
			language:{

			inputTooShort:function(){

				return 'Rusum nomini kiritib izlang';

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
			minimumInputLength:2,
			language:{

			inputTooShort:function(){

				return 'Zavod nomini kiritib izlang';

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
		});

		function capitalize(text){
			var words=text.split(' ');
			for(var i=0;i<words.length;i++){
				if(words[i]){
					words[i]=words[i][0].toUpperCase()+words[i].substring(1).toLowerCase();
				}
			}
			return words.join(' ');
		}
		$('input[name="engineno"], input[name="chasicno"], input[name="corpusno"], select[name="brand_id"]').change(function(){
			var brand = $('select[name="brand_id"]').val();

			var engineno=$('input[name="engineno"]').val();
			var chasicno=$('input[name="chasicno"]').val();
			var corpusno=$('input[name="corpusno"]').val();

			if(engineno){
				$.ajax({
					type:'GET',
					url:'/certificate/check-engineno',
					data: 'engineno='+engineno+'&type=engine&brand=' + brand,

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
									$('input[name="engineno"]').val('');							
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
					data: 'chasicno='+chasicno+'&type=chasic&brand=' + brand,

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
										$('input[name="chasicno"]').val('')
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
					data: 'corpusno='+corpusno+'&type=corpus&brand=' + brand,

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
										$('input[name="corpusno"]').val('');
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
		$('input[name="factory_number"], select[name="brand_id"]').change(function(){
			var num = $(this).val();
			$('input[name=type_name]').attr('disabled', false);
			var type = $('select[name="type_name"]').val();
			var brand = $('select[name="brand_id"]').val();
			$('input[name=type_name]').attr('disabled', true);
			if(!(num && brand)) return;
			$.ajax({
				type:'GET',
				url:'/vehicle/checkfactory',
				data:'num='+num+'&brand='+brand + '&type=' + type,
				success:function(data){
					if(data!='no'){
						var fdata = $.parseJSON(data);
						if(fdata.type == 'exist'){							
							var owner = "Texnika egasi: " + fdata.ownername + ";  " + "Texnika rusumi: " + fdata.vehiclename;
							swal({
								title: "{{ trans('app.Kritilgan Zavod raqami mavjud!') }}",
					            type: "warning",
					            text: owner,
					            showCancelButton: true,
					            cancelButtonText: "Boshqa raqam kiritish",
					            confirmButtonColor: "#DD6B55",
					            confirmButtonText: "Texnikani ko'rish",
					            closeOnConfirm: true
							}).then((isConfirm) => {	
								$('input[name="factory_number"]').val('');							
									window.open("/vehicle/list/view/"+fdata.vehicle_id+"/"+fdata.city_id,"_blank");						
							}).catch((err) => {
								$('input[name=factory_number]').val("");
								$('input[name=factory_number]').focus();
							});
						}
					
					}
				}
			});
		})

		$('.tab-content').filter('[d="none"]').hide();


	});
</script>
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
				$('div.customer-type-button[val="tirkama"]').removeClass('selected');
				$("#vehicle_type_id").val('agregat');
				$('.self').show();
				$('.agregat').hide();
				$('.agregat input, .agregat select').removeAttr("required");
				$('#amount_new').show();
				var doc = $("form#vehicle_add select[name='doc']").val();
				if(doc == 10){
					$('#tolandi').text('Tushundim');
					$('#reg_amount_new').attr('type', 'text');
					$('#reg_amount_new').val("To'lov undirilmaydi");
				}else{
					$('#tolandi').text("To'landi");
					$('#reg_amount_new').attr('type', 'number');
					$('#reg_amount_new').val({{ $min->payment*($payment_a->payment/100) }});
				}
			}else if(cType=='vehicle'){
				$('div.customer-type-button[val="agregat"]').removeClass('selected');
				$('div.customer-type-button[val="tirkama"]').removeClass('selected');
				$('div.customer-type-button[val="vehicle"]').addClass('selected');
				$("#vehicle_type_id").val('vehicle');
				$('.self').show();
				$('.agregat').show();
				$('.agregat input, .agregat select').attr("required","required");
				$('#amount_new').show();
				var doc = $("form#vehicle_add select[name='doc']").val();
				if(doc == 10){
					$('#tolandi').text('Tushundim');
					$('#reg_amount_new').attr('type', 'text');
					$('#reg_amount_new').val("To'lov undirilmaydi");
				}else{
					$('#tolandi').text("To'landi");
					$('#reg_amount_new').attr('type', 'number');
					$('#reg_amount_new').val({{ $min->payment*($payment_v->payment/100) }});
				}
			}else if(cType=='tirkama'){
				$('div.customer-type-button[val="agregat"]').removeClass('selected');
				$('div.customer-type-button[val="vehicle"]').removeClass('selected');
				$('div.customer-type-button[val="tirkama"]').addClass('selected');
				$("#vehicle_type_id").val('tirkama');
				$('.self').show();
				$('.agregat').show();
				$('.tirkama').hide();
				$('.tirkama input, .tirkama select').removeAttr("required","required");
				$('#amount_new').show();
				var doc = $("form#vehicle_add select[name='doc']").val();
				if(doc == 10){
					$('#tolandi').text('Tushundim');
					$('#reg_amount_new').attr('type', 'text');
					$('#reg_amount_new').val("To'lov undirilmaydi");
				}else{
					$('#tolandi').text("To'landi");
					$('#reg_amount_new').attr('type', 'number');
					$('#reg_amount_new').val({{ $min->payment*($payment_t->payment/100) }});
				}
			}	
	});

	})
</script>
<script>
			$('input.reg-date').datetimepicker({
				days:["Yakshanba","Dushanba","Seshanba","Chorshanba","Payshanba","Juma","Shanba","Yakshanba"],
    	daysShort:["Yak","Du","Se","Chor","Pay","Jum","Shan","Yak"],
    	daysMin:["Ya","Du","Se","Chor","Pa","Ju","Sha","Ya"],
    	months:["Yanvar","Fevral","Mart","Aprel","May","Iyun","Iyul","Avgust","Sentabr","Oktabr","Noyabr","Dekabr"],
    	monthsShort:["Yan","Fev","Mar","Apr","May","Iyun","Iyul","Avg","Sen","Okt","Noy","Dek"],
    	today: "Bugun",
				format:'dd-mm-yyyy',
				autoclose:1,
				minView:2,
				startView:'decade',
				endDate: new Date()
			});
</script>
		<!-- vehicle owner -->



	@endsection
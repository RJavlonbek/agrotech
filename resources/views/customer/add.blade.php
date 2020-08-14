@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- page content -->

<style>

.theTooltip {

	position: absolute!important;

	-webkit-transform-style: preserve-3d; transform-style: preserve-3d; -webkit-transform: translate(15%, -50%); transform: translate(15%, -50%);

}

</style>



<?php $userid = Auth::user()->id; ?>

		<?php $userid = Auth::user()->id; ?>
@if (CheckAccessUser('customer_add', $userid, 'create')=='yes')
		<div class="section">

			<div class="page-header">

				<ol class="breadcrumb">

					<li class="breadcrumb-item">

						<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Customer')}}

					</li>

				</ol>

			</div>

			<div class="row">

				<div class="col-md-12">

					<div class="card">									

						<div class="card-body">

							<div class="panel panel-primary">

								<div class="tab_wrapper page-tab">

									<ul class="tab_list">

										<li>

											<a href="{!! url('/customer/list')!!}">

												<span class="visible-xs"></span>

												<i class="fa fa-list fa-lg">&nbsp;</i> Mulk egalari ro'yxati

											</a>

										</li>

										<li class="active">

											<a href="{!! url('/customer/add')!!}">

												<span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>Mulk egasini qo'shish</b>

											</a>

										</li>

									</ul>

								</div>

							</div>

							<form action="javascript:void(0);" id="customer-form">
								<input type="hidden" name="filial_of" value="{{ empty($customer) ? 0 : $customer->filial_of }}">

								<div class="row">

									<input type="hidden" name="_token" value="{{csrf_token()}}">

									@if(isset($editid))

										<input type="hidden" name="customer_id" value="{{ $editid }}" />

									@endif

									<div class="col-md-6 {{empty($customer)?'unhidden':''}}">

										<label class="form-label" style="visibility: hidden;">

											Texnika egasi</label>

										<div class="row">

											<div class="col-6 pr-0">

												@if(!empty($customer) && $customer->type=='physical')

													<div class="customer-type-button selected py-2" val='physical'>

														Jismoniy shaxs

													</div>

												@else

													<div class="customer-type-button py-2" val='physical'>

														Jismoniy shaxs

													</div>

												@endif

											</div>

											<div class="col-6 pl-0">

												@if(!empty($customer) && $customer->type=='legal')

													<div class="customer-type-button selected py-2" val='legal'>

														Yuridik shaxs

													</div>

												@else

													<div class="customer-type-button py-2" val='legal'>

														Yuridik shaxs

													</div>

												@endif

											</div>

										</div>

									</div>

									<div class="col-md-6"></div>
									
									
									<div class="col-md-4 {{ $errors->has('firstname')?' has-error' : '' }} name">

										<div class="form-group">

											<label class="form-label">

												Ism

												<label class="text-danger">*</label>

											</label>

											<input type="text" class="form-control" name="name" required="" placeholder="Ismini kiriting" 

												@if(!empty($customer))

													value="{{$customer->name}}"

												@endif

											/>

										</div>

									</div>

									<div class="col-md-4 {{ $errors->has('lastname') ? ' has-error' : '' }} physical-fields">

										<div class="form-group">

											<label class="form-label">

												{{ trans('app.Last Name') }}<label class="text-danger">*</label>

											</label>

											<input type="text"name="lastname" placeholder="{{ trans('app.Enter Last Name')}}" class="form-control"

												@if(!empty($customer))

													value="{{$customer->lastname}}"

												@endif

											/>

										</div>

									</div>

									<div class="col-md-4 {{ $errors->has('middlename') ? ' has-error' : '' }} physical-fields">

										<div class="form-group">

											<label class="form-label">

												Otasining ismi<label class="text-danger">*</label>

											</label>

											<input type="text"name="middlename" placeholder="Otasining ismini kiriting" class="form-control" required="required" 
												@if(!empty($customer))
													value="{{$customer->middlename}}"
												@endif
											/>
										</div>

									</div>
									<div class="col-md-6">

										<div class="form-group">

											<label class="form-label">{{ trans('app.STIR') }}<label class="text-danger">*</label></label>

											<input class="form-control"  type="text" name="inn" placeholder="STIR ni kiriting" pattern="[0-9]{9}" maxlength="9" title="9ta raqam kiriting!"  data-pattern-mismatch = "Noto'g'ri shakl"

												@if(!empty($customer))

													value="{{$customer->inn}}"

												@endif
												required="required" 
											/>

										</div>

									</div>


									<div class="col-md-6 legal-fields">

										<div class="form-group overflow-hidden">

											<label class="form-label">Mulkchilik shakli</label>

											<div class="row">

												<div class="col-9">

													<select class="form-control ownership_form w-100"  data-placeholder="Mulkchilik shaklini tanlang" name="ownership_form">

														@if(!empty($ownershipForms))

															@foreach($ownershipForms as $o_form)

																<option value="{{ $o_form->id }}"

																	@if(!empty($customer) && $customer->form == $o_form->id)

																		selected="selected"

																	@endif 

																>

																	{{ $o_form->name }}

																</option>

															@endforeach

														@endif

													</select>

												</div>

												@if(Auth::user()->role=='admin')
													<div class="col-3 pl-0 text-right">
														<div class="btn btn-success myBtn w-100" data-toggle="modal" data-target="#ownership-form-modal">Qo'shish/O'chirish</div>
													</div>
												@endif
											</div>

										</div>

									</div>

									<div class="col-md-6 customer-category-col">

										<div class="form-group overflow-hidden">

											<label class="form-label">{{ trans('app.Kategoriya') }}</label>

											<select class="form-control customer_category w-100"  data-placeholder="Kategoriya tanlang" name="customer_category" multiple="" required="required">

												@if(!empty($categories))

													@foreach($categories as $cat)

														<option value="{{ $cat->id }}"

															@if(!empty($customer) && in_array($cat->id,explode(',',$customer->category)))

																selected=""

															@endif 

														>

															{{ $cat->name }}

														</option>

													@endforeach

												@endif	

											</select>

										</div>

									</div>


									<div class="col-12  physical-fields">

										<div class="row">

											<div class="col-md-6">

												<div class="wd-200 mg-b-30">

													<div class="form-group">

														<label class="form-label">{{ trans('app.Date Of Birth')}}</label>

														<div class="input-group">

															<div class="input-group-prepend">

																<div class="input-group-text">

																	<i class="fa fa-calendar tx-16 lh-0 op-6"></i>

																</div>

															</div>

															<input class="form-control fc-datepicker dob" name="dob" placeholder="dd-mm-yyyy" autocomplete="off" 

																@if(!empty($customer))

																	value="{{date('d-m-Y', strtotime($customer->d_o_birth))}}"

																@endif

															/>

														</div>

														@if ($errors->has('dob'))

															<span class="help-block">

																<strong style="margin-left:27%;">{{ $errors->first('dob') }}</strong>

															</span>

														@endif

													</div>

												</div>

											</div>

											<div class="col-md-6">

												<div class="form-group">

													<label class="form-label">{{ trans('app.SHIR') }}</label>

													<input class="form-control" type="text" name="id_number" placeholder="Shaxsiy identifikatsiya raqami" pattern="[0-9]{9}" maxlength="9" title="9ta raqam kiriting!"

														@if(!empty($customer))

															value="{{$customer->id_number}}"

														@endif

													/>

												</div>

											</div>
											<div class="col-2">
												<label class="container-checkbox">Chet el fuqarosi
												  	<input type="checkbox" class="resident-checkbox" autocomplete="off"
												  		@if(!empty($customer) && $customer->residence==0)
												  			checked="checked"
												  		@endif
												  	/>
												  	<span class="checkmark"></span>
												</label>
											</div>
											<div class="col-md-2">

												<div class="form-group">

													<label class="form-label">{{ trans('app.Passport seriyasi') }}</label>

													<input type="text" name="passport_series" maxlength="2" class="form-control"  placeholder="AA" pattern="[A-ZА-Я]{0,2}" onkeyup="this.value=this.value.toUpperCase()"

														@if(!empty($customer))

															value="{{$customer->passport_series}}"

														@endif

													/>

												</div>

											</div>

											<div class="col-md-2">

												<div class="form-group">

													<label class="form-label">{{ trans('app.Passport raqami') }}</label>

													<input type="text" name="passport_number" maxlength="7" pattern="[0-9]{7}" class="form-control" placeholder="1234567"

														@if(!empty($customer))

															value="{{$customer->passport_number}}"

														@endif

													/>

												</div>

											</div>

											<div class="col-md-3">

												<div class="wd-200 mg-b-30">

													<div class="form-group">

														<label class="form-label">{{ trans('app.Berilgan sana')}}</label>

														<div class="input-group">

															<div class="input-group-prepend">

																<div class="input-group-text">

																	<i class="fa fa-calendar tx-16 lh-0 op-6"></i>

																</div>

															</div>

															<input class="form-control p-givendate" name="p_given_date"  placeholder="dd-mm-yyyy" autocomplete="off" 

																@if(!empty($customer))

																	value="{{date('d-m-Y', strtotime($customer->p_given_date))}}"

																@endif

															/>

														</div>

													</div>

												</div>

											</div>

											<div class="col-md-3">

												<div class="form-group overflow-hidden">

													<label class="form-label">{{ trans('app.Kim tomonidan berilgan') }}</label>
                                                    @if(!empty($customer) && $customer->residence==0)
                                                        <input class="form-control" type="text" value="{{ $customer->p_given_city }}" name='p_given_city' placeholder="Shahar/Tuman nomini kiriting" />
                                                    @else
    													<select class="form-control p_given_city w-100" name="p_given_city" data-placeholder="Shahar/Tuman nomini kiriting">
    														@if(!empty($p_given_city))
    															<option value="{{$p_given_city->id}}" selected="selected">{{$p_given_city->name}}</option>
    														@endif										
    													</select>
    												@endif
												</div>

											</div>

										</div>

									</div>

									<div class="col-md-6 has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">

										<div class="form-group">

											<label class="form-label">{{ trans('app.Mobile num') }}</label>

											<input type="text"  name="mobile" placeholder="+998721234567" class="form-control" maxlength="15"

												@if(!empty($customer))

													value="{{$customer->mobile}}"

												@endif

											/>

											@if ($errors->has('mobile'))

											<span class="help-block">

												<strong>{{ $errors->first('mobile') }}</strong>

								  			</span>

											@endif

										</div>

									</div>

									<div class="col-md-6 has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">

										<div class="form-group">

											<label class="form-label">{{ trans('app.Email') }}</label>

											<input type="text"  name="email" placeholder="{{ trans('app.Enter Email')}}" class="form-control" maxlength="50"

												@if(!empty($customer))

													value="{{$customer->email}}"

												@endif

											/>

											@if ($errors->has('email'))

												<span class="help-block">

													<strong>{{ $errors->first('email') }}</strong>

												</span>

											@endif

										</div>

									</div>

									<div class="col-md-6">

										<div class="form-group overflow-hidden">

											<label class="form-label">{{ trans('app.Viloyat') }}<label class="text-danger">*</label></label>

											<select class="form-control state_of_country custom-select" name="state_id" url="{!! url('/getcityfromstate') !!}">
												@if(count($states))
													<option value="">Viloyat tanlang</option>
												@endif

												@if(!empty($states))

													@foreach($states as $state)

														<option value="{{ $state->id }}"

															@if( (!empty($customer_city) && $customer_city->state_id==$state->id) || count($states)==1)

																selected="selected"

															@endif

														> {{$state->name}} </option>

													@endforeach		

												@endif								

											</select>

										</div>

									</div>

									<div class="col-md-6 form-group overflow-hidden">

										<label class="form-label">

											Tuman / Shahar

											<label class="text-danger">*</label>

										</label>

										<div class="row">

											<div class="col-12">

												<select class="form-control  city_of_state custom-select" name="city" required=""

													@if(!empty($customer_city))

														val="{{$customer_city->id}}"

													@endif

												>
													@if($cities && count($cities))
														<option value="">Viloyat tanlang</option>
													@endif

													@if(!empty($cities))

														@foreach($cities as $city)

															<option value="{{ $city->id }}"

																@if((!empty($customer_city) && $customer_city->id==$city->id) || count($cities)==1)

																	selected="selected"

																@endif

															> {{$city->name}} </option>

														@endforeach		

													@endif

												</select>

											</div>

											{{-- <div class="col-4">

												<div class="btn btn-success w-100" data-toggle="modal" data-target="#cities-modal" >Tuman/Shaharlar</div>

											</div> --}}

										</div>

									</div>

									<div class="col-md-12">
										<label class="form-label">{{ trans('app.Address') }}</label>
										<textarea class="form-control" id="address" name="address" maxlength="100" rows="3" placeholder="{{ trans('app.Enter Address') }}">{{(!empty($customer))?$customer->address:''}}</textarea>
									</div>

									<div class="col-md-12 p-3">

											<div class="float-right">

												<button type="submit" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Saqlash</button>

											</div>											

									</div>

								</div>
							</form>									

						</div>

					</div>

				</div>



				<!-- Customer Category Modal -->

				<div class="col-md-6">

					<div id="customer-category-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

						<div class="modal-dialog">

							<div class="modal-content">

								<div class="modal-header">

									<h5 class="modal-title" id="example-Modal3">Kategoriya qo'shish</h5>

									<button type="button" class="close" data-dismiss="modal" aria-label="Close">

										<span aria-hidden="true">&times;</span>

									</button>

								</div>

								<div class="modal-body">

								    <form class="form-horizontal formaction" action="" method="">

										<table class="table card-table table-vcenter text-nowrap customer_category_class"  align="center">

											<thead>

												<tr>

													<td class="text-center">

														<strong>Kategoriya</strong>

													</td>

													<td class="text-right">

														<strong>{{ trans('app.Action')}}</strong>

													</td>

												</tr>

											</thead>

											<tbody>

												@if(!empty($categories))

													@foreach ($categories as $cat)

														<tr class="del-{{ $cat->id }}">

															<td class="text-center ">{{ $cat->name }}</td>

															<td class="text-right">

																<button type="button" customercategoryid="{{ $cat->id }}" 

																url="{!! url('/customer/customer_category_delete') !!}" class="btn btn-danger btn-xs deletecustomercategory" title="Kategoriyani o'chirish">

																	<i class="fe fe-trash-2"></i>

																</button>

															</td>

														</tr>

													@endforeach

												@endif

											</tbody>

										</table>

										<div class="form-group data_popup">

											<label class="form-label">Kategoriya nomi <span class="text-danger">*</span></label>

											<div class="row">

												<div class="col-10">

													<input type="text" class="form-control customer_category" name="customer_category" id="customer-_category" placeholder="Kategoriya nomini kiriting" maxlength="40" required />

												</div>

												<div class="col-2 form-group data_popup">

													<button type="button" class="btn btn-success customercategory_add" 

													url="{!! url('/customer/customer_category_add') !!}" >

														{{ trans('app.Submit')}}

													</button>

												</div>

											</div>

										</div>

									</form>

								</div>

							</div>

						</div>	

					</div>

				</div>



				<!-- Ownership Form Modal -->

				<div class="col-md-6">

					<div id="ownership-form-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

						<div class="modal-dialog">

							<div class="modal-content">

								<div class="modal-header">

									<h5 class="modal-title" id="example-Modal3">Mulkchilik shaklini qo'shish</h5>

									<button type="button" class="close" data-dismiss="modal" aria-label="Close">

										<span aria-hidden="true">&times;</span>

									</button>

								</div>

								<div class="modal-body">

								    <form class="" action="" method="">

										<table class="table card-table table-vcenter text-nowrap ownership_form_class"  align="center">

											<thead>

												<tr>

													<td class="text-center">

														<strong>Mulkchilik shakli</strong>

													</td>

													<td class="text-right">

														<strong>{{ trans('app.Action')}}</strong>

													</td>

												</tr>

											</thead>

											<tbody>

												@if(!empty($ownershipForms))

													@foreach ($ownershipForms as $o_form)

														<tr class="del-{{ $o_form->id }}">

															<td class="text-center ">{{ $o_form->name }}</td>

															<td class="text-right">

																<button type="button" ownershipformid="{{ $o_form->id }}" 

																url="{!! url('/customer/ownershipform_delete') !!}" class="btn btn-danger btn-xs ownershipform_delete" title="O'chirish">

																	<i class="fe fe-trash-2"></i>

																</button>

															</td>

														</tr>

													@endforeach

												@endif

											</tbody>

										</table>

										<div class="form-group data_popup">

											<label>Mulkchilik shakli nomi <span class="text-danger">*</span></label>

											<div class="row">

												<div class="col-10">

													<input type="text" class="form-control ownershipform" placeholder="Mulkchilik shakli nomini kiriting" maxlength="40" required />

												</div>

												<div class="col-2 data_popup">

													<button type="button" class="btn btn-success ownershipform_add" 

													url="{!! url('/customer/ownershipform_add') !!}" >

														{{ trans('app.Submit')}}

													</button>

												</div>

											</div>

										</div>

									</form>

								</div>

							</div>

						</div>	

					</div>

				</div>



				{{--   Cities Modal   --}}

				<div class="col-md-6">

					<div id="cities-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

						<div class="modal-dialog">

							<div class="modal-content">

								<div class="modal-header">

									<h5 class="modal-title" id="example-Modal3">Tuman/Shaharlar</h5>

									<button type="button" class="close" data-dismiss="modal" aria-label="Close">

										<span aria-hidden="true">&times;</span>

									</button>

								</div>

								<div class="modal-body">

								    <form class="" action="" method="">

										<table class="table card-table table-vcenter text-nowrap ownership_form_class"  align="center">

											<thead>

												<tr>

													<td class="text-center">

														<strong>Tuman/Shahar</strong>

													</td>

													<td class="text-right">

														<strong>{{ trans('app.Action')}}</strong>

													</td>

												</tr>

											</thead>

											<tbody class="cities-list-body">

											</tbody>

										</table>

										<div class="form-group data_popup">

											<label>Tuman/Shahar nomi <span class="text-danger">*</span></label>

											<div class="row">

												<div class="col-10">

													<input type="text" class="form-control city-name" placeholder="Tuman yoki shahar nomini kiriting" required />

												</div>

												<div class="col-2 data_popup">

													<button type="button" class="btn btn-success city_add">

														{{ trans('app.Submit')}}

													</button>

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

<script>

$(document).ready(function(){

	console.log('loaded');
	categories=$('select.customer_category option');

	function pGivenCitySelect2(){
		$('select.p_given_city').select2({

			ajax:{

				url:'/getcityfromsearch',

				delay:300,

				dataType:'json',

				data:function(params){

					return{

						search:params.term

					}

				},

				processResults:function(data){

					data=data.map((city,index)=>{

						return {

							id:city.id,

							text:city.name

						}

					});

					return{

						results:data

					}

				}

			},

			minimumInputLength:3,
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
					return "Natija topilmadi"
				}

			}
		});
	}
	
	pGivenCitySelect2();


	$('select.customer_category').select2({
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
					return "Natija topilmadi"
				}

			},
	    minimumResultsForSearch: Infinity
	});

	$('select.city_of_state').select2({
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
					return "Natija topilmadi"
				}

		},
		minimumResultsForSearch: Infinity,

		placeholder:"Tuman/shaharni tanlang"
	});

	$('select.ownership_form').select2({

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
	    minimumResultsForSearch: Infinity
	});

	$('select.state_of_country').select2({

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
		minimumResultsForSearch:Infinity,
		placeholder:'Viloyat tanlang'
	})

	$('select.state_of_country').on('change',function(){
		getCitiesOfState($(this));
	});

	if($('select.city_of_state').attr('val')){
		getCitiesOfState($('select.state_of_country'));
	}

	$('input[name="inn"], input[name="id_number"]').change(function(){
		var th=$(this);
		var inn=th.val();
		let text=th.attr('name')=='inn' ? 'STIR' : 'SHIR';
		$.ajax({
			url:'/customer/check-inn',
			data:{
				inn,
				field:th.attr('name')
			},
			type:'GET',
			success:function(data){
				data=JSON.parse(data);
				//console.log(data);
				if(data.exist && data.owner && data.owner.name){
					swal({
						title:'',
						type:'info',
						text:'Kiritiligan '+text+' '+data.owner.name+' '+(data.owner.lastname?data.owner.lastname:'')+' nomiga kiritilgan',
						showCancelButton:true,
						cancelButtonText:'Boshqa raqam kiritish',
						confirmButtonText:'"' + data.owner.name+' '+(data.owner.lastname?data.owner.lastname:'') + '" ga filial sifatida qo\'shish'
					}).then((result)=>{
						// th.val('');
						// console.log('result',window.location);
						// if(result){
						// 	window.open('/customer/list/'+data.owner.id);
						// }
						$('input[name="filial_of"]').val(data.owner.id);
					}).catch((e)=>{
						th.val('');
					});
				}
			}
		})
	});

	

	$('.customercategory_add').click(function(){

		var customer_category= $('input.customer_category').val();

		var url = $(this).attr('url');

        if(customer_category == ""){

            swal('Kategoriya nomini kiriting');

        }else{ 

			$.ajax({

				type:'GET',

				url:url,

			    data :{customer_category:customer_category},

			    success:function(data){

				    var newd = $.trim(data);

				    if (newd == '01'){

					    swal("Bu nomdagi kategoriya allaqachon mavjud! Iltimos, boshqa nom kiritib ko'ring");

				    }

				    else{

				    	var classname = 'del-'+newd;

				   		$('.customer_category_class').append('<tr class="'+classname+'"><td class="text-center">'+customer_category+'</td><td class="text-right"><button type="button" customercategoryid='+data+' deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletecustomercategory" title="Kategoriyani o\'chirish"><i class="fe fe-trash-2"></i></button></a></td><tr>');

						$('select.customer_category').append('<option value='+data+'>'+customer_category+'</option>');

						$('input.customer_category').val('');

						$('.deletecustomercategory').on('click',function(e){

							e.stopImmediatePropagation();

							deleteCustomerCategory($(this));

						});

				    } 

			    }, 

		 	});

		}
	});

	$('.deletecustomercategory').on('click',function(e){

		e.stopImmediatePropagation();

		deleteCustomerCategory($(this));
	});

	$('.ownershipform_add').click(function(){

		var ownershipForm= $('input.ownershipform').val();

		var url = $(this).attr('url');

        if(ownershipForm == ""){

            swal('Please Enter Vehicle Type!');

        }else{ 

			$.ajax({

				type:'GET',

				url:url,

			    data :{ownershipForm:ownershipForm},

			    success:function(data){

				    var newd = $.trim(data);

				    if (newd == '01'){

					    swal("Bu nomdagi mulkchilik shakli allaqachon mavjud! Iltimos, boshqa nom kiritib ko'ring");

				    }

				    else{

				    	var classname = 'del-'+newd;

				   		$('.ownership_form_class').append('<tr class="'+classname+'"><td class="text-center">'+ownershipForm+'</td><td class="text-right"><button type="button" ownershipformid='+data+' url="{!! url('/customer/ownershipform_delete') !!}" class="btn btn-danger btn-xs ownershipform_delete" title="Mulkchilik shaklini o\'chirish"><i class="fe fe-trash-2"></i></button></a></td><tr>');

						$('select.ownership_form').append('<option value='+data+'>'+ownershipForm+'</option>');

						$('input.ownershipform').val('');



						$('.ownershipform_delete').on('click',function(e){

							e.stopImmediatePropagation();

							deleteOwnershipForm($(this));

						});

				    } 

			    }, 

		 	});

		}
	});

	$('.ownershipform_delete').on('click',function(e){

		e.stopImmediatePropagation();

		deleteOwnershipForm($(this));
	});



	function getCitiesOfState(th){

		stateid = th.val();

		var url = th.attr('url');

		$.ajax({

			type:'GET',

			url: url,

			data:{ 

				stateid:stateid, },

			success:function(response){

				var citiesMenu=$('select.city_of_state')

				var customerCity=citiesMenu.attr('val');

				citiesMenu.html("<option value>option<option>"+response);

				if(customerCity){

					citiesMenu.find('option[value="'+customerCity+'"]').attr('selected','selected');

				}

			}

		});
	}

	function deleteCustomerCategory(th){

		var catid = th.attr('customercategoryid');

		var url = th.attr('url');

		swal({

		    title: "Kategoriyani o'chirmoqchimisiz?",

            text: "Sizda bu ma'lumotni qayta tiklash imkoniyati bo'lmaydi!",

            type: "warning",

            showCancelButton: true,

            confirmButtonColor: "#DD6B55",

            confirmButtonText: "Ha, o'chirilsin",

            cancelButtonText:'Bekor qilish',

        }).then(function(isConfirm){

			if (isConfirm) {

				$.ajax({

					type:'GET',

					url:url,

					data:{categoryid:catid},

					success:function(data){

						$('.customer_category_class .del-'+catid).remove();

						$("select.customer_category option[value="+catid+"]").remove();

						swal("Bajarildi!",'',"success");

					}

				});

			}else{

				swal("Cancelled", "Your imaginary file is safe :)", "error");

			} 

		});
	}

	function deleteOwnershipForm(th){

		var catid = th.attr('ownershipformid');

		var url = th.attr('url');

		swal({

		    title: "Mulkchilik shaklini o'chirmoqchimisiz?",

            text: "Sizda bu ma'lumotni qayta tiklash imkoniyati bo'lmaydi!",

            type: "warning",

            showCancelButton: true,

            confirmButtonColor: "#DD6B55",

            confirmButtonText: "Ha, o'chirilsin",

            cancelButtonText:'Bekor qilish',

            closeOnConfirm: false

        },

        function(isConfirm){

			if (isConfirm) {

				$.ajax({

					type:'GET',

					url:url,

					data:{ownershipFormId:catid},

					success:function(data){

						$('.ownership_form_class .del-'+catid).remove();

						$("select.ownership_form option[value="+catid+"]").remove();

						swal("Bajarildi!","success");

					}

				});

			}else{

				swal("Cancelled", "Your imaginary file is safe :)", "error");

			} 

		});
	}

	function removeCategories(type){
		console.log('removing '+type+' categories');
		var physicalCategories=[54,55];
		var options=$('select.customer_category option');
		for(var i=0; i<physicalCategories.length;i++){
			
			if(type=='physical'){
				options.filter('[value="'+physicalCategories[i]+'"]').remove();
			}else if(type=='legal'){
				options=options.filter(':not([value="'+physicalCategories[i]+'"])');
			}
		}
		if(type=='legal'){
			options.remove();
		}
	}

	function editCity(th){

		var cityId = th.attr('city-id');

		var row=th.closest('tr');

		var cityName=row.find('.city-name');



		if(th.is('.city-save')){

			th.removeClass('city-save');

			var data={

				_token:$('input[name="_token"]').val(),

				cityId,

				name:cityName.find('input').val(),

			}

			$.ajax({

				url:'/edit-city',

				type:'POST',

				data:data,

				success:function(data){

					console.log(data);

					cityName.html(cityName.find('input').val());

					th.html('<i class="fa fa-pencil"></i>');

				},

				error:function(err){

					console.log('error',err);

					swal('Xatolik','','error');

				}

			});

		}else{

			cityName.html('<input class="form-control" value="'+cityName.text().trim()+'" />');

			th.html('Saqlash');

			th.addClass('city-save');

		}
	}

	var hiddenType=$('.customer-type-button:not(.selected)').attr('val');
	$('.'+hiddenType+'-fields').find('input').removeAttr('required');
	$('.'+hiddenType+'-fields').hide();


	if($('.unhidden').length){
		$('form#customer-form > .row > div:not(.unhidden)').hide();
	}


	$('div.customer-type-button').on('click',(e)=>{
		$('select.customer_category').html(categories);
		$('form#customer-form > .row > div').show();
		var cType=$(e.target).attr('val');

		console.log('customer type selected',cType);

		if(cType=='physical'){

			$('div.customer-type-button[val="physical"]').addClass('selected');

			$('div.customer-type-button[val="legal"]').removeClass('selected');
			$('.name').addClass('col-md-4');
			$('.name').removeClass('col-md-6');

			$('.name').find('.form-label').html('Ism <label class="text-danger">*</label>');

			$('.name').find('.form-control').attr('placeholder', 'Texnika egasi ismini kiriting');
			$('.legal-fields').hide();
			$('.physical-fields').show();
			removeCategories('legal');
		}else if(cType=='legal'){

			$('div.customer-type-button[val="physical"]').removeClass('selected');

			$('div.customer-type-button[val="legal"]').addClass('selected');

			$('.name').addClass('col-md-6');
			$('.name').removeClass('col-md-4');

			$('.name').find('.form-label').html('Korxona nomi <label class="text-danger">*</label>');

			$('.name').find('.form-control').attr('placeholder', 'Texnika egasi nomini kiriting');
			$('.legal-fields').show();
			$('.physical-fields input').removeAttr('required');
			$('.physical-fields').hide();
			removeCategories('physical')
		}
	});



	$('#customer-form').one('submit',function(e){

		var submitButton=$(this).find('button[type="submit"]');

		submitButton.addClass('btn-loading');

		e.preventDefault();

		var formArray=$(this).serializeArray();
		var customerType=$('.customer-type-button.selected').attr('val');
		formArray.push({

			name:'customer_type',

			value:customerType

		});

		formArray.push({

			name:'category',

			value:$('select.customer_category').val()

		});

		formArray.push({
			name:'residence',
			value:$('input.resident-checkbox').is(':checked') ? 0 : 1
		});

		console.log(formArray);



		if($('input[name="customer_id"]').length && $('input[name="customer_id"]').val()){

			console.log('editing...');

			var url='/customer/list/edit/update/'+$('input[name="customer_id"]').val();

		}else{

			console.log('adding...');

			var url='/customer/store';

		}

		$.ajax({

			type:'POST',

			url:url,

			data:formArray,

			success:function(result){

				var customerId=result.trim();

				submitButton.removeClass('btn-loading').addClass('disabled');

				$('.buttons-after-submit').show();

				submitButton.after('<a href="/certificate/regadd?type=regged&owner_id='+customerId+'" class="btn btn-info add-transport-button ml-2" target="_blink">Texnika qo\'shish</a>');
				if(customerType=='physical'){
					submitButton.after('<a href="/driver-licence/give?owner_id='+customerId+'" class="btn btn-info give-driver-licence-button ml-2" target="_blink">Haydovchilik guvohnomasi berish</a>');
					submitButton.after('<a href="/driver-exam?owner_id='+customerId+'" class="btn btn-info driver-exams-button ml-2" target="_blink">Haydovchilik imtihonlarini topshirish</a>');
				}
				

				console.log(result);

				swal('Saqlandi!','','success');

			},

			error:function(err){

				submitButton.removeClass('btn-loading');

				vswal('Xatolik','','error');

				console.log(err);

			}

		});
	});

	// $('.customer-category-col .select2').one('click',function(){

	// 	console.log('select focus');

	// 	$(this).find('.select2-search').append('<div data-toggle="modal" data-target="#customer-category-modal" class="customer-category-add-button btn-radius btn-success">Ya\'ngi qo\'shish/O\'chirish</div>');
	// });

	$('.btn[data-target="#cities-modal"]').on('click',function(){

		var stateId=$('select.state_of_country').val();

		console.log('clicked');

		$.ajax({

			url:'/getcities',

			type:'GET',

			data:{

				stateId

			},

			success:function(data){

				console.log(data);

				var cities=JSON.parse(data);

				var citiesList=$('#cities-modal .cities-list-body');

				citiesList.html('');

				for(var i=0; i<cities.length;i++){

					var city=cities[i];

					citiesList.append('<tr><td class="text-center city-name">'+city.name+'</td><td class="text-right"><button type="button" city-id="'+city.id+'" state-id="'+stateId+'" class="btn btn-info btn-xs city-edit" title="O\'chirish"><i class="fa fa-pencil"></i></button></td></tr>');

				}



				$('.city-edit').on('click',function(e){

					e.stopImmediatePropagation();

					editCity($(this));

				});

			}

		});
	});

	$('.city_add').click(function(){

		var city= $('input.city-name').val();

        if(city == ""){

            swal('Tuman/Shahar nomini kiriting');

        }else{ 

			$.ajax({

				type:'POST',

				url:'/add-city',

			    data :{

			    	_token:$('input[name="_token"]').val(),

			    	city,

			    	stateId:$('select.state_of_country').val()

			    },

			    success:function(data){

				    var newd = $.trim(data);

				    if (newd == '01'){

					    swal("Bu nomdagi tuman/shahar allaqachon mavjud! Iltimos, boshqa nom kiritib ko'ring");

				    }

				    else{

				    	var classname = 'del-'+newd;

				   		$('#cities-modal .cities-list-body').append('<tr><td class="text-center city-name">'+city+'</td><td class="text-right"><button type="button" city-id="'+newd+'" class="btn btn-info btn-xs city-edit"><i class="fa fa-pencil"></i></button></td><tr>');

						$('select.city_of_state').append('<option value='+newd+'>'+city+'</option>');

						$('input.city-name').val('');



						$('.city-edit').on('click',function(e){

							e.stopImmediatePropagation();

							editCity($(this));

						});

				    } 

			    }, 

		 	});

		}
	});

	$('.resident-checkbox').on('change',function(){
		console.log('changed',$(this).val());
		if($(this).is(':checked')){
			$('select.p_given_city').select2('destroy');
			$('select.p_given_city').hide().after('<input name="p_given_city" class="form-control" type="text" placeholder="Viloyat/Shahar nomini kiriting" />');
		}else{
			$('select.p_given_city').show();
			pGivenCitySelect2();
			$('select.p_given_city').siblings().filter('input').remove();
		}
	});

});

</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>

    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

		<script src="{{ URL::asset('build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">

    $("input.dob").datetimepicker({
		format: "dd-mm-yyyy",

		autoclose: 1,

		minView: 2,

		startView:'decade',

		endDate: new Date(),
	});



	$('input.p-givendate').datetimepicker({
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

@endsection
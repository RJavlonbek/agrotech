@extends('layouts.app')

@section('content')

<!-- page content -->

<style>

.theTooltip {

	position: absolute!important;

	-webkit-transform-style: preserve-3d; transform-style: preserve-3d; -webkit-transform: translate(15%, -50%); transform: translate(15%, -50%);

}

.camera-direction{
	color: white;
	border-radius: 50%;
	background-color: black;
	opacity: 0.5;

}

.camera-directio i{
	margin: auto;
	vertical-align: middle;
}

.camera-direction.right{
	padding: 6px 9px;
	position: absolute;
	top: 240px;
	left: 450px;
}

.camera-direction.left{
	padding: 6px 9px;
	position: absolute;
	top: 240px;
	left: 40px;
}

.camera-direction.up{
	padding: 7px 8px;
	position: absolute;
	top: 9px;
	left: 245px;
}

.camera-direction.down{
	padding: 7px 8px;
	position: absolute;
	top: 450px;
	left: 245px;
}

img#signature-image{
	visibility: hidden; 
	position: absolute;
}

.display-signature-box{
	height:150px;
	border: 1px solid black;
	padding: 10px;
	text-align: center;
	display: inline-block;
	margin-bottom: 15px;
}



</style>



<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('driver_lic', $userid, 'create')=='yes')

		<div class="section">

			<div class="page-header">

				<ol class="breadcrumb">

					<li class="breadcrumb-item">

						<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Traktorchi-mashinist guvohnomasi')}}

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

											<a href="{!! url('/driver-licence/list')!!}">

												<span class="visible-xs"></span>

												<i class="fa fa-list fa-lg">&nbsp;</i> 

												{{trans("app.Ro'yxat")}}
											</a>

										</li>

										<li class="active">

											<a href="{!! url('/driver-licence/give')!!}">

												<span class="visible-xs"></span>

												<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

												{{trans("app.Berish")}}</b>

											</a>

										</li>

									</ul>

								</div>

									</div>

							<form action="javascript:void(0);" id="driver-licence-form" >

								<input type="hidden" name="image" class="image-tag">
								<input type="hidden" name="_token" value="{{csrf_token()}}">

								<div class="row">
									<div class="col-md-6">
										<label class="form-label" style="visibility: hidden;">asd</label>
										<div class="row">
											<div class="col-4 pr-0">
												<div class="customer-type-button selected py-2" val="give">
													Berish
												</div>
											</div>
											<div class="col-4 px-0">
												<div class="customer-type-button py-2" val="update">
													Yangilash
												</div>
											</div>
											<div class="col-4 pl-0">
												<div class="customer-type-button py-2" val="recover">
													Qayta tiklash
												</div>
											</div>
										</div>
									</div>								
									<div class="col-md-6"></div>
									<div class="col-12 col-md-6 form-group">

										<label class="form-label">Guvohnoma egasi</label>

										<select class="form-control select-customer" name="customer_id" required="required">

											@if(!empty($customer))

												<option value="{{$customer->id}}" selected="selected">

													{{$customer->name.' '.$customer->lastname.' ('.$customer->ownership_form.')'}}

												</option>

											@endif

										</select>

									</div>
									<div class="col-6 form-group">
										<label class="form-label">Asos</label>
										<select class="form-control select-doc" name="doc" required="required">
											<option value="">Asos hujjatni tanlang</option>
											@if(!empty($documents))
												@foreach($documents as $doc)
													<option value="{{$doc->id}}">{{$doc->name}}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="col-md-6">
										<label class="form-label">Alohida belgilar</label>
										<input class="form-control" type="text" name="note" />
									</div>
									<div class="col-12">

										<div class="row">

											<div class="col-12 col-md-6">

												<div class="row types-row">

													<div class="col-3">

														<label class="form-label text-center">Toifa</label>

													</div>

													<div class="col-5">

														<label class="form-label text-center">Berilgan sana</label>

													</div>

													<div class="col-4">

														<label class="form-label text-center">Muddat (yil)</label>

													</div>

													<div class="col-3">

														<ul class="list-group">

															<li class="list-group-item">

																A

																<div class="material-switch pull-right">

																	<input id="A" value="A" name="types[0][name]" type="checkbox"/>

																	<label for="A" class="label-primary"></label>

																</div>

															</li>

														</ul>

													</div>

													<div class="col-5">

														<div class="form-group">

															<input readonly="true" style="background-color: white !important;" name="types[0][date]" autocomplete="off" disabled='disabled' class="form-control given-date">

														</div>

													</div>

													<div class="col-4">

														<div class="form-group">														

															<input style="background-color: white !important;" disabled="" class="form-control duration" name="types[0][duration]" type="number" name="duration" min="0" step="1">

														</div>

													</div>

													<div class="col-3">

														<ul class="list-group">

															<li class="list-group-item">

																B

																<div class="material-switch pull-right">

																	<input id="B" value="B" name="types[1][name]" type="checkbox"/>

																	<label for="B" class="label-primary"></label>

																</div>

															</li>

														</ul>

													</div>

													<div class="col-5">

														<div class="form-group">

															<input readonly="true" style="background-color: white !important;" name="types[1][date]" autocomplete="off" disabled='disabled' class="form-control given-date">

														</div>

													</div>

													<div class="col-4">

														<div class="form-group">														

															<input style="background-color: white !important;" disabled="" class="form-control duration" name="types[1][duration]" type="number" name="duration" min="0" step="1">

														</div>

													</div>

													<div class="col-3">

														<ul class="list-group">

															<li class="list-group-item">

																C

																<div class="material-switch pull-right">

																	<input id="C" value="C" name="types[2][name]" type="checkbox"/>

																	<label for="C" class="label-primary"></label>

																</div>

															</li>

														</ul>

													</div>

													<div class="col-5">

														<div class="form-group">

															<input readonly="true" style="background-color: white !important;" name="types[2][date]" autocomplete="off" disabled='disabled' class="form-control given-date">

														</div>

													</div>

													<div class="col-4">

														<div class="form-group">														

															<input style="background-color: white !important;" disabled="" class="form-control duration" name="types[2][duration]" type="number" name="duration" min="0" step="1">

														</div>

													</div>

													<div class="col-3">

														<ul class="list-group">

															<li class="list-group-item">

																D

																<div class="material-switch pull-right">

																	<input id="D" name="types[3][name]" value="D" type="checkbox"/>

																	<label for="D" class="label-primary"></label>

																</div>

															</li>

														</ul>

													</div>

													<div class="col-5">

														<div class="form-group">

															<input readonly="true" style="background-color: white !important;" name="types[3][date]" autocomplete="off" disabled='disabled' class="form-control given-date">

														</div>

													</div>

													<div class="col-4">

														<div class="form-group">														

															<input style="background-color: white !important;" disabled="" class="form-control duration" name="types[3][duration]" type="number" name="duration" min="0" step="1">

														</div>

													</div>

													<div class="col-3">

														<ul class="list-group">

															<li class="list-group-item">

																E

																<div class="material-switch pull-right">

																	<input id="E" name="types[4][name]" value="E" type="checkbox"/>

																	<label for="E" class="label-primary"></label>

																</div>

															</li>

														</ul>

													</div>

													<div class="col-5">

														<div class="form-group">

															<input readonly="true" style="background-color: white !important;" name="types[4][date]" autocomplete="off" disabled='disabled' class="form-control given-date">

														</div>

													</div>

													<div class="col-4">

														<div class="form-group">														

															<input style="background-color: white !important;" disabled="" class="form-control duration" name="types[4][duration]" type="number" name="duration" min="0" step="1">

														</div>

													</div>

													<div class="col-3">

														<ul class="list-group">

															<li class="list-group-item">

																F

																<div class="material-switch pull-right">

																	<input id="F" name="types[5][name]" value="F" type="checkbox"/>

																	<label for="F" class="label-primary"></label>

																</div>

															</li>

														</ul>

													</div>

													<div class="col-5">

														<div class="form-group">

															<input readonly="true" style="background-color: white !important;" name="types[5][date]" autocomplete="off" disabled='disabled' class="form-control given-date">

														</div>

													</div>

													<div class="col-4">

														<div class="form-group">														

															<input style="background-color: white !important;" disabled="" class="form-control duration" name="types[5][duration]" type="number" name="duration" min="0" step="1">

														</div>

													</div>

												</div>

											</div>

											<div class="col-12 col-md-6">

												<div class="row">

													<div class="col-6 col-md-6 form-group">

														<label class="form-label">Seriya</label>

														<input class="form-control" type="text" name="series" pattern="[A-Z]{3}"

															@if(!empty($seriesNumber))

																value="{{$seriesNumber->series}}" disabled="disabled"

															@endif 

														/>

													</div>

													<div class="col-6 col-md-6 form-group">

														<label class="form-label">Raqam</label>

														<input class="form-control" type="text" name="number" required="required" 

															@if(!empty($seriesNumber))

																value="{{$seriesNumber->number}}" disabled="disabled"

															@endif 

														/>

													</div>

													<div class="col-6 col-md-6 form-group">
														<label class="form-label">Seriya raqam (viloyat bo'yicha)</label>
														<input class="form-control" type="text" name="local_series" pattern="[A-Z]{3}"
															@if(!empty($seriesNumber))
																value="{{$seriesNumber->local_series}}" disabled="disabled"
															@endif
														/>
													</div>

													<div class="col-6 col-md-6 form-group">

														<label class="form-label" style="visibility: hidden;">Raqam</label>
														<input class="form-control" type="text" name="local_number" required="required" 
															@if(!empty($seriesNumber))
																value="{{$seriesNumber->local_number}}" disabled="disabled"
															@endif 

														/>
													</div>

													<div class="col-6 form-group recover-field">
														<label class="form-label">Qayta tiklanish sababi</label>
														<select url='0' class="select-recover-reason form-control" name="recover_reason">
															<option value=""></option>
															<option value="lost">{{trans('app.reason-lost')}}</option>
															<option value="invalid">{{trans('app.reason-stolen')}}</option>
															<option value="invalid">{{trans('app.reason-invalid')}}</option>
														</select>
													</div>

													<div class="col-12">
														<div class="row">
															<div class="col-4">
																<div id="result-picture" style="width: 32mm; height: 40mm; background-color: #f1f2fd; border: 1px dashed red; margin-bottom: 15px;"></div>
																<button class="btn btn-success picture-button" data-toggle="modal" data-target="#picture-modal" type="button" disabled >Suratga olish</button>
															</div>
															<div class="col-8">
																<img id="signature-image" src="#">

																<div class="display-signature-box">
																	<canvas id="signature-canvas"></canvas>
																</div>
																<div class="has-feedback">
																	<input type="file" name="signature-file" id="signature-file" accept=".png, .jpg, .jpeg" style="display: none;">
																	<div class="row">
																		<div class="col-5">
																		   	<input type="button" name="fake-image" class="btn btn-primary" value="Imzoni yuklash" style="width: 100%; height: 2.375rem" disabled>
																		</div>
																		<div class="col-7">
																		</div>
																	</div>
																	  
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<div class="row">
															<div class="col-sm-7">

																<label class="form-label">To'lov</label>

																<input url='0' class="form-control" type="number" name="payment" min="0" disabled 
																	@if(!empty($customer))
																		@if($customer->residence == 1)
																			value="{{ $min->payment*($payment_n->payment/100) }}"
																		@elseif($customer->residence == 0)
																			value="{{ $min->payment*($payment_o->payment/100) }}"
																		@endif
																	@endif
																 required>

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

										</div>

									</div>								

									<div class="col-6">
										<label class="form-label" style="visibility: hidden;">label</label>
										<button class="btn btn-success" type="submit">Saqlash</button>
										<button class="btn btn-success print-button" disabled data-toggle="modal"  data-target="#preview-modal" type="button">Chop etish</button>
									</div>
								</div>

							</form>

						</div>

					</div>

				</div>

				{{--   Driver licence preview Modal   --}}
				<div class="col-md-8">
					<div id="preview-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

						<div class="modal-dialog">

							<div class="modal-content">

								<div class="modal-header">

									<h5 class="modal-title" id="example-Modal3">Traktorchi-mashinist guvohnomasini chop etish</h5>

									<button type="button" class="close" data-dismiss="modal" aria-label="Close">

										<span aria-hidden="true">&times;</span>

									</button>

								</div>

								<div class="modal-body">

								</div>

							</div>

						</div>	

					</div>

				</div>

				{{--   Take picture Modal   --}}
				<div class="col-md-8">
					<div id="picture-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

						<div class="modal-dialog" style="min-width: 700px;">

							<div class="modal-content">

								<div class="modal-header">

									<h5 class="modal-title" id="example-Modal3">Suratga olish</h5>

									<button type="button" class="close" data-dismiss="modal" aria-label="Close">

										<span aria-hidden="true">&times;</span>

									</button>

								</div>

								<div class="modal-body">
									{{-- <span class="camera-direction left"><i class="fa fa-angle-left"></i></span>
									<span class="camera-direction right"><i class="fa fa-angle-right"></i></span>
									<span class="camera-direction up"><i class="fa fa-angle-up"></i></span>
									<span class="camera-direction down"><i class="fa fa-angle-down"></i></span> --}}
									<div id="my-camera"></div>

									<div class="row">
										<div class="form-group col-6">
											<label class="form-label">Kamera</label>
											<select class="form-control select-camera"></select>
										</div>
										<div class="form-group col-6">
											<label class="form-label" style="visibility: hidden;">knopka</label>
											<div class="float-right btn btn-success" id="take-picture-button">Suratga olish</div>
										</div>
									</div>
									
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
<script type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/blob.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/js/webcam.min.js') }}"></script>    	

<script type="text/javascript">

	$(document).ready(function(){
		$('select[name="customer_id"]').on('change', function(){
			$('input[name="fake-image"]').removeAttr("disabled");
		});

		$('input[name="fake-image"]').on('click', function(){
			$('input[name="signature-file"]').val('');
			$('input[name="signature-file"]').click();
		});
		$('input[name="signature-file"]').on('change',function(){		
			$('textarea[name="file-name"]').text($('input[name="signature-file"]').val());
		});

		if($('.select-customer').val()){
			$('.picture-button').removeAttr('disabled');
		}
		$('select.select-customer').select2({
			ajax:{
				url:'/customer/search',
				delay:300,
				dataType:'json',
				data:function(params){
					return{
						search:params.term,
						type:'physical',
						driver_licence_info:true
					}
				},
				processResults:function(data){
					data=data.map((name,index)=>{
						return {
							id:name.id,
							text:capitalize(name.name+(name.lastname?' '+name.lastname:'')+(name.middlename?' '+name.middlename:'')),
							item:name
						}
					});
					return{
						results:data
					}
				}
			},
			placeholder:'Guvohnoma egasini tanlang',
			minimumInputLength:1,
			escapeMarkup: function (markup) { return markup; },
			language:{
				inputTooShort:function(){
					return 'Hadovchining ismi, STIR, SHIR kiritib izlang';
				},
				searching:function(){
					return 'Izlanmoqda...';
				},
				noResults:function(){
					return "Natija topilmadi"
				}
			},
			templateResult:customerFormat,
			templateSelection:customerFormat
		});

		$('select[name="recover_reason"]').change(function(){
			var old_p = parseInt($(this).attr('url'));
			var reason = $(this).val();
			var payment = parseInt($('input[name="payment"]').val());
			$.ajax({
				type: 'GET',
				url: '/payment/driver_licence',
				data: 'reason='+reason,
				success: function(data){
					var total = parseInt(data)+payment-old_p;
					$('input[name="payment"]').val(total);
					$('select[name="recover_reason"]').attr('url', data);
				}
			});
		});

		$('select.select-recover-reason').select2({
			minimumResultsForSearch:Infinity,
			placeholder:'Qayta tiklanish sababi'
		});

		$('.recover-field').hide();
		$('.recover-field select.select-recover-reason').removeAttr('required');

		function customerFormat(result){
			if(result.loading){

				return result.text;

			}

			if(result && result.item){
				var residenceInfo='<span class="residence-info" residence="'+result.item.residence+'"></span>';
			}else{
				residenceInfo='';
			}
			

			if(result && result.item && result.item.licence_series && result.item.licence_number){

				return result.text+'<span title="Guvohnoma raqami: '+ result.item.licence_series + result.item.licence_number +'" class="alert-for-licence text-danger float-right" licence-type=\''+ result.item.licence_type +'\'>Guvohnoma berilgan!</span>'+residenceInfo;

			}else{

				return result.text+residenceInfo;

			}
		}

		function capitalize(text){
			var words=text.split(' ');
			console.log(words);
			for(var i=0;i<words.length;i++){
				if(words[i][0] == null){
					continue;
				}else{
					words[i]=words[i][0].toUpperCase()+words[i].substring(1).toLowerCase();
				}
				
			}
			return words.join(' ');
		}

		$('select.select-customer').change(function(){
			var th=$(this);
			$('.customer-type-button').css('pointer-events','unset');
			var customerId=$(this).val();
			var hasLicence=$(this).next().find('.selection .alert-for-licence');
			var licence=hasLicence.attr('title');
			var licenceType=hasLicence.attr('licence-type');
			hasLicence=hasLicence.length;

			var residence = parseInt($('span.residence-info').attr('residence'));

			$('.recover-field').hide();
			$('.recover-field select.select-recover-reason').removeAttr('required');

			if(hasLicence && !$('.customer-type-button[val="recover"]').is('.selected') && !$('.customer-type-button[val="update"]').is('.selected')){
				var buttons = $('<div>').append('<div class="mb-2">Tanlangan traktorchi-mashinistga guvohnoma berilgan ('+licence+'). Davom etish uchun quyidagilardan birini tanlang</div>')
					.append(createButton('Guvohnomani yangilash', function() {
					$('.customer-type-button').filter('[val="give"]').css('pointer-events','none');
					$('.customer-type-button').removeClass('selected').filter('[val="update"]').addClass('selected');
					adjustTypes(licenceType);
			       	swal.close();
			       	console.log('ok'); 
			    })).append(createButton('Guvohnomani qayta tiklash', function() {
			        $('.customer-type-button').filter('[val="give"]').css('pointer-events','none');
   					$('.customer-type-button').removeClass('selected').filter('[val="recover"]').addClass('selected');

   					$('.recover-field select.select-recover-reason').attr('required','required');
   					$('.recover-field').show();

   					$('input[name="payment"]').val("0");
   					$('.recover-field select.select-recover-reason').attr('required','required');

   					adjustTypes(licenceType);
   			       	swal.close();
			       	console.log('Guvohnomani qayta tiklash'); 
			    })).append(createButton('Boshqa haydovchi tanlash', function() {
			    	th.find('option').remove();
			       	swal.close();
			    }));
			    
			    swal({
			      	title: '',
			      	html: buttons,
			      	type: "warning",
			      	showConfirmButton: false,
			      	showCancelButton: false,
			      	allowOutsideClick:false,
			      	width:800
			  	}).catch((err)=>{
			  		console.log('caught',err);
			  	});
			}else if(!hasLicence){  // licence is not given, so i am ging to disable recover and update button
				$('.customer-type-button').removeClass('selected').filter('[val="give"]').addClass('selected');
				$('.customer-type-button:not([val="give"])').css('pointer-events','none');
			}else{  // licence is given, and recover or update action is already selected, here i am going to disable give button till chosen transport changes
				$('.customer-type-button').filter('[val="give"]').css('pointer-events','none');
				adjustTypes(licenceType);
				if($('.customer-type-button[val="recover"]').is('.selected')){
					$('.recover-field').show();
					$('.recover-field select.select-recover-reason').attr('required','required');
				}
			}

			// if one of the driver is selected, 'take picture' button will be enabled
			if(customerId){
				$('.picture-button').removeAttr('disabled');
			}
			if(residence == 1){
			    var ctype = $('div.customer-type-button').attr("val");
			    if(ctype == 'update'){
			        $('input[name="payment"]').val('{{ $min->payment*($payment_u->payment/100) }}');
			    }else if(ctype == 'give'){
			        $('input[name="payment"]').val('{{ $min->payment*($payment_n->payment/100) }}');
			    }
			}else if(residence == 0){
				$('input[name="payment"]').val('{{ $min->payment*($payment_o->payment/100) }}');
			}
			
		});

	    function createButton(text, cb) {
	      return $('<div class="btn btn-primary mx-2">' + text + '</div>').on('click', cb);
	    }

		function adjustTypes(types){
			$('.types-row').find('input[type="checkbox"]').removeAttr('checked');
			$('.types-row input.given-date, .types-row input.duration').val('').attr('disabled','disabled');

			if(types){
				var types=JSON.parse(types);
				for(var i=0;i<types.length;i++){
					var t=types[i];
					var dateParts=t.given_date.split('-');
					if(dateParts[0].length==4){
						var date=dateParts.reverse().join('-');
					}else{
						var date=t.given_date;
					}
					var first=$('input[type="checkbox"]').filter('#'+t.name).closest('ul').parent();
					var second=first.next();
					var third=second.next();
					$('input[type="checkbox"]').filter('#'+t.name).attr('checked','checked');
					$('input[type="checkbox"]').filter('#'+t.name).attr('disabled','disabled');
					second.find('input').val(date).removeAttr('disabled');
					third.find('input').val(t.duration).removeAttr('disabled');
				}

			}
		}

		//enabling/disabling duration field when any licence type is chacked/unchecked
		$('input[type="checkbox"]').filter('[name^="types"]').change(function(){
			var th=$(this);
			var type = $('.customer-type-button.selected').attr('val');
			var oldp = $('input[name="payment"]').attr('url');
			var givenDate=th.closest('div[class^="col-"]').next().find('input.given-date');
			var duration=th.closest('div[class^="col-"]').next().next().find('input.duration');
			console.log(givenDate,duration);
			if(th.is(':checked')){
				if(type == 'recover' && oldp == '0'){
					var payment = parseInt($('input[name="payment"]').val());
					var total = parseInt('{{ $min->payment/2 }}')+payment;
					$('input[name="payment"]').attr('url', '{{ $min->payment/2 }}');
					$('input[name="payment"]').val(total);
				}
				givenDate.removeAttr('disabled').attr('required','required');
				givenDate.val('{{date('d-m-Y')}}');
				duration.removeAttr('disabled').attr('required','required');
				duration.val('10');
			}else{
				if(type == 'recover' && oldp != '0'){
					var licence = $('select.select-customer').next().find('.selection .alert-for-licence').attr('licence-type');
					var types = $('input[type="checkbox"]').filter('[name^="types"]');
					var p = 0;
					for(var i = 0; i < types.length; i++){
						if(types.eq(i).is(':checked') && !(types.eq(i).attr('disabled'))){
							p++;
						}
					}
				}
				if(p == 0){
					var payment = parseInt($('input[name="payment"]').val());
					var total = payment-parseInt('{{ $min->payment/2 }}');
					$('input[name="payment"]').attr('url', '0');
					$('input[name="payment"]').val(total);
				}
				givenDate.val('').attr('disabled','disabled').removeAttr('required');
				duration.val('').attr('disabled','disabled').removeAttr('required');

			}
		});

		$('div.customer-type-button').on('click',(e)=>{
			$('.recover-field').hide();
			$('.recover-field select.select-recover-reason').removeAttr('required');
			var cType=$(e.target).attr('val');


			if(cType=='give'){
				$('div.customer-type-button').removeClass('selected');
				$('div.customer-type-button[val="give"]').addClass('selected');
				$('input[name="payment"]').val('{{ $min->payment*($payment_n->payment/100) }}');
			}else if(cType=='recover'){
				$('div.customer-type-button').removeClass('selected');
				$('div.customer-type-button[val="recover"]').addClass('selected');
				$('.recover-field').show();
				$('.recover-field select.select-recover-reason').attr('required','required');
				$('input[name="payment"]').val('0');
			}else if(cType=='update'){
				$('div.customer-type-button').removeClass('selected');
				$('div.customer-type-button[val="update"]').addClass('selected');
				$('input[name="payment"]').val('{{ $min->payment*($payment_u->payment/100) }}');
			}
		});

	    $("input.given-date").datetimepicker({
			format: "dd-mm-yyyy",
			autoclose: 1,
			minView: 2,
			startView:'decade',
			endDate: new Date()
		});

		$('#driver-licence-form').on('submit',function(e){
			console.log('submitting');
			// first i am gonna check if at least one category was chosen
			var checkedCategories=$('input[type="checkbox"]').filter('[name^="types"]').filter(':checked');
			if(!checkedCategories.length){
				swal('Toifa tanlang!','','warning');
				e.preventDefault();
				return;
			}


			var th=$(this);
			var submitButton=$(this).find('button[type="submit"]');

			submitButton.addClass('btn-loading');
			var printButton=$(this).find('.btn.print-button');
			var pictureButton=$(this).find('.btn.picture-button');
			var disabled=$(this).find(':input:disabled').removeAttr('disabled');
			var formArray=$(this).serializeArray();
			disabled.attr('disabled','disabled');

			formArray.push({
				name:'action',
				value:$('.customer-type-button.selected').attr('val')
			});

			console.log(formArray);

			$.ajax({

				url:'/driver-licence/store',

				type:'POST',

				data:formArray,

				success:function(data){
					data=JSON.parse(data);
					submitButton.removeClass('btn-loading');
					if(data.message=='success' && data.id){
						swal('Saqlandi!','','success');
						submitButton.removeClass('btn-loading');
						printButton.removeAttr('disabled');
						th.prepend('<input type="hidden" name="driver-licence-id" value="'+data.id+'" />');
					}else if(data.message=='active-driver-licence-exists'){
						swal('Xatolik!','Tanlangan traktorchi-mashinistga tegishli aktiv guvohnoma mavjud. Qayta tiklashga urinib ko\'ring','error');
					}

				},error:function(err){
					console.log('Error on saving driver licence',err);
					submitButton.removeClass('btn-loading');
					swal('Xatolik!','','error');
				}

			});
		});

		Webcam.on('error',function(err){
			console.log('webcam error',err);
			swal('Kamera topilmadi','','error');
		});

		$('.picture-button').on('click',function(e){
			if($('select.select-customer').val()){
				Webcam.set({
    				width: 640,
    				height: 480,
    				
    				// // device capture size
    				// dest_width: 640,
    				// dest_height: 480,
    				
    				// // final cropped size
    				// crop_width: 320,
    				// crop_height: 400,
    				
    				// format and quality
    				image_format: 'jpeg',
    				jpeg_quality: 100,
			    });
				  
				Webcam.attach('#my-camera');
			}else{
				e.preventDefault();
				console.log('Driver is not selected');
				swal('Guvohnoma egasini tanlang','','error');
			}
		});

		cropper='';

		$('#take-picture-button').on('click',function(){
			var th=$(this);
			if(th.is('.crop-picture')){
				th.addClass('btn-loading');
				cropper.getCroppedCanvas().toBlob((blob)=>{
					console.log('blob',blob);
					var formDataToUpload = new FormData();
					formDataToUpload.append("image", blob);
					formDataToUpload.append('driverId',$('select.select-customer').val());
					formDataToUpload.append('_token',$('input[name="_token"]').val());
					
					console.log(formDataToUpload);

					$.ajax({
						type:'POST',
						url:'/driver-licence/save-image',
						contentType:false,
						processData:false,
						cache:false,
						data:formDataToUpload,
						success:function(data){
							console.log('success',data);
							th.removeClass('btn-loading').removeClass('crop-picture').addClass('save-picture').text('Saqlash');
							$('#result-picture').html('');
							$('#result-picture').html('<img src="'+data+'" />');
							$('.picture-button').text('Qayta suratga olish');
						},
						error:function(err){
							console.log('err',err);
						}
					});
				});
			}else if(th.is('.save-picture')){
				th.removeClass('save-picture').text('Suratga olish');
				$('#picture-modal .modal-header button.close').click();
			}else{
				th.addClass('btn-loading');
				console.log('taking picture...');
				Webcam.snap( function(data_uri) {
		            $(".image-tag").val(data_uri);
		            $('#my-camera').html('<img  id="taken-picture" src="'+data_uri+'"/>');
		            
		            setTimeout(function(){
		            	console.log('cropping',document.getElementById('taken-picture'));
		            	cropper = new Cropper(document.getElementById('taken-picture'),{
		            		aspectRatio: 4 / 5,
		            		autoCrop:true,
		            		ready(){
		            			console.log('ready');
		            			//this.cropper.crop();
		            			th.removeClass('btn-loading').addClass('crop-picture').text('Kesish');
		            		},
		            		crop(){
		            			//console.log('crop');
		            		},
		            		cropend(){
		            			if(th.is('.save-picture')){
		            				th.removeClass('save-picture').addClass('crop-picture').text('Kesish');
		            			}
		            		}
		            	});
		            },500);
		        });
			}
		});

		function b64toBlob(b64Data, contentType, sliceSize) {
	        contentType = contentType || '';
	        sliceSize = sliceSize || 512;

	        var byteCharacters = atob(b64Data);
	        var byteArrays = [];

	        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
	            var slice = byteCharacters.slice(offset, offset + sliceSize);

	            var byteNumbers = new Array(slice.length);
	            for (var i = 0; i < slice.length; i++) {
	                byteNumbers[i] = slice.charCodeAt(i);
	            }

	            var byteArray = new Uint8Array(byteNumbers);

	            byteArrays.push(byteArray);
	        }

	      	var blob = new Blob(byteArrays, {type: contentType});
	      	return blob;
		}

		$('.btn[data-target="#preview-modal"]').on('click',function(){
			var driverLicenceId=$('#driver-licence-form').find('input[name="driver-licence-id"]').val();
			var url='/driver-licence/preview?id='+driverLicenceId;
			$('#preview-modal .modal-body').html('<iframe src="'+url+'" width="50%" height="340"></iframe><div class="btn btn-info send-to-print mt-2">Chop etish</div>');
			$('.send-to-print').on('click',function(){
				$(this).parent().find('iframe').attr('src',url+'&print=true');
			});
		});

		$('select.select-doc').select2({
			minimumResultsForSearch:Infinity,
			placeholder:'Asos hujjatni tanlang'
		});

		const videoSelect = document.querySelector('select.select-camera');
		const selectors = [videoSelect];

		//audioOutputSelect.disabled = !('sinkId' in HTMLMediaElement.prototype);

		function gotDevices(deviceInfos) {
		  // Handles being called several times to update labels. Preserve values.
		  const values = selectors.map(select => select.value);
		  selectors.forEach(select => {
			    while (select.firstChild) {
			      select.removeChild(select.firstChild);
			    }
		  	});
		  for (let i = 0; i !== deviceInfos.length; ++i) {
		    const deviceInfo = deviceInfos[i];
		    const option = document.createElement('option');
		    option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
		      option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
		      videoSelect.appendChild(option);
		    } else {
		      console.log('Some other kind of source/device: ', deviceInfo);
		    }
		  }
		  selectors.forEach((select, selectorIndex) => {
		    if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
		      select.value = values[selectorIndex];
		    }
		  });
		}

		navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);

		// Attach audio output device to video element using device/sink ID.
		function attachSinkId(element, sinkId) {
		  if (typeof element.sinkId !== 'undefined') {
		    element.setSinkId(sinkId)
		      .then(() => {
		        console.log(`Success, audio output device attached: ${sinkId}`);
		      })
		      .catch(error => {
		        let errorMessage = error;
		        if (error.name === 'SecurityError') {
		          errorMessage = `You need to use HTTPS for selecting audio output device: ${error}`;
		        }
		        console.error(errorMessage);
		        // Jump back to first output device in the list as it's the default.
		        audioOutputSelect.selectedIndex = 0;
		      });
		  } else {
		    console.warn('Browser does not support output device selection.');
		  }
		}

		function gotStream(stream) {
		  window.stream = stream; // make stream available to console
		  const videoElement = document.querySelector('#my-camera video');
		  console.log('videoElement',videoElement);
		  videoElement.srcObject = stream;
		  // Refresh button list in case labels have become available
		  return navigator.mediaDevices.enumerateDevices();
		}

		function handleError(error) {
		  console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
		}

		function start() {
		  if (window.stream) {
		    window.stream.getTracks().forEach(track => {
		      track.stop();
		    });
		  }
		  const videoSource = videoSelect.value;
		  const constraints = {
		    video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		  };
		  navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		}

		videoSelect.onchange = start;

		start();


		// signature logic start
		$('#signature-file').change(function(e){
			let input=this;
			let customerId=$('select.select-customer').val();

			if(customerId){
				var reader = new FileReader();

				reader.onload = function (e) {
					console.log('loaded', e);
				    $('#signature-image').attr('src', e.target.result);

				    setTimeout(function(){
		    		    // canvas
		    		    var canvas = document.getElementById("signature-canvas");
		    		    var ctx = canvas.getContext("2d");;

		    		    // getting image
		    		    image = document.getElementById("signature-image");

		    		    // setting canvas size according to the image
		    		    let w=image.clientWidth;
		    		    let h=image.clientHeight
		    		    canvas.height = h;
		    		    canvas.width = w;

		    		    //console.log('w:'+w,'h:'+h);

		    		    // draw loaded image into canvas
		    		    ctx.drawImage(image,0,0, w, h);

		    		    // making canvas transparent
		    		    var imgd = ctx.getImageData(0, 0, w, h),
		    		        pix = imgd.data,
		    		        newColor = {r:0,g:0,b:0, a:0};

		    		    for (var i = 0, n = pix.length; i <n; i += 4) {
		    		        var r = pix[i],
		    		            g = pix[i+1],
		    		            b = pix[i+2];

		    	            // If its white then change it
		    	            if(r >= 50 && g >= 50 && b >= 50){ 
		    	                // Change the white to whatever.
		    	                pix[i] = newColor.r;
		    	                pix[i+1] = newColor.g;
		    	                pix[i+2] = newColor.b;
		    	                pix[i+3] = newColor.a;
		    	            }
		    		    }

		    		    ctx.putImageData(imgd, 0, 0);


		    		    // trimming canvas
		    		    let trimmedCanvas=trimCanvas(canvas);
		    		    console.log('trimmed', trimmedCanvas);

		    		    //$(canvas).after(trimmedCanvas);

		    		    canvas.toBlob((blob)=>{
		    		    	//console.log('blob', blob);

		    		    	let signatureFormData=new FormData();
		    		    	signatureFormData.append('image', blob);
		    		    	signatureFormData.append('_token', $('input[name="_token"]').val());
		    		    	signatureFormData.append('driverId', customerId);

		    		    	$.ajax({
		    		    		url:'/driver-licence/save-signature',
		    		    		type:'POST',
		    		    		contentType:false,
								processData:false,
								cache:false,
								data:signatureFormData,
								success:function(data){
									console.log('success',data);
								}
		    		    	})
		    		    });
				    }, 1000); 
				}

				reader.readAsDataURL(input.files[0]);
			}else{
				e.preventDefault();
				$(this).val('');
				alert('Guvohnoma egasini tanlang!');
			}
			$('input[name = "fake-image"]').val("Imzoni o'zgartirish");
		});


		function trimCanvas(c) {
		    var ctx = c.getContext('2d'),
		        //copy = document.createElement('canvas').getContext('2d'),
		        pixels = ctx.getImageData(0, 0, c.width, c.height),
		        l = pixels.data.length,
		        i,
		        bound = {
		            top: null,
		            left: null,
		            right: null,
		            bottom: null
		        },
		        x, y;
		    
		    // Iterate over every pixel to find the highest
		    // and where it ends on every axis ()
		    for (i = 0; i < l; i += 4) {
		        if (pixels.data[i + 3] !== 0) {
		            x = (i / 4) % c.width;
		            y = ~~((i / 4) / c.width);

		            if (bound.top === null) {
		                bound.top = y;
		            }

		            if (bound.left === null) {
		                bound.left = x;
		            } else if (x < bound.left) {
		                bound.left = x;
		            }

		            if (bound.right === null) {
		                bound.right = x;
		            } else if (bound.right < x) {
		                bound.right = x;
		            }

		            if (bound.bottom === null) {
		                bound.bottom = y;
		            } else if (bound.bottom < y) {
		                bound.bottom = y;
		            }
		        }
		    }
		    
		    // Calculate the height and width of the content
		    var trimHeight = bound.bottom - bound.top,
		        trimWidth = bound.right - bound.left,
		        trimmed = ctx.getImageData(bound.left, bound.top, trimWidth, trimHeight);

		    ctx.canvas.width = trimWidth;
		    ctx.canvas.height = trimHeight;
		    ctx.putImageData(trimmed, 0, 0);

		    //return trimmed;

		    // Return trimmed canvas
		    return ctx.canvas;
		}


	});
</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>

<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

	

<script type="text/javascript">

    $("input.dob").datetimepicker({

		format: "yyyy-mm-dd",

		autoclose: 1,

		minView: 2,

		startView:'decade',

		endDate: new Date()

	});



	$('input.p-givendate').datetimepicker({

		format:'yyyy-mm-dd',

		autoclose:1,

		minView:2,

		startView:'decade',

		endDate: new Date()

	});

 </script>

@endsection
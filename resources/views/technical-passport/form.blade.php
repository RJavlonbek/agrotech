@extends('layouts.app')

@section('content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('vehicle_pass', $userid, 'create')=='yes')
	<div class="section">
		<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<i class="fe fe-life-buoy mr-1"></i>&nbsp Texnikaga texnik pasport berish
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
									<li class="{{$doc=='passport'?'active':''}}">
										<a href="{!!url('/vehicle/technical-passport')!!}">
											<i class="fa fa-plus-circle fa-lg"> </i>
											<b>Texnik pasport berish</b>
										</a>
									</li>
									<li class="{{$doc=='certificate'?'active':''}}">
										<a href="{!! url('/certificate/add')!!}">
											<span class="visible-xs"></span>
											<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
											{{ trans('app.Texnik guvohnoma berish')}}</b>
										</a>
									</li>
								</ul>

							</div>

						</div>
						<form action="javascript:void(0);" id="technical-passport-form">
							<div class="row">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="doc" value={{$doc}}>
								<div class="col-md-6">
									<label class="form-label" style="visibility: hidden;">asd</label>
									<div class="row">
										<div class="col-6 pr-0">
											<div class="customer-type-button selected py-2" val="give">
												Berish
											</div>
										</div>
										<div class="col-6 pl-0">
											<div class="customer-type-button py-2" val="recover">
												Qayta tiklash
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6"></div>
								<div class="col-3">
									<label class="form-label">Sana</label>
									<input readonly="true" class="form-control given-date" name="given_date" placeholder="dd-mm-yyyy" required="required" autocomplete="off" value="{{date('d-m-Y')}}">
								</div>
								<div class="col-5 form-group">
									<label class="form-label">Texnika egasi</label>
									<select class="form-control select-customer" name="customer_id" required="required">
										@if(!empty($customer))
											<option value="{{$customer->id}}" selected="selected">
												{{$customer->lastname.' '.$customer->name.' '.$customer->middlename}}
											</option>
										@endif
									</select>
								</div>
								<div class="col-4 form-group">
									<label class="form-label">Asos</label>
									<select class="form-control select-doc" name="source-doc" required="required">
										<option value="">Asos hujjatni tanlang</option>
										@if(!empty($documents))
											@foreach($documents as $document)
												<option value="{{$document->id}}">{{$document->name}}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="col-6 form-group">
									<label class="form-label">Texnika</label>
									<select 
										chosen-vehicle="{{!empty($vehicle)?$vehicle->id:''}}" 
										class="form-control select-transport" 
										name="transport" 
										required="required" 
										title="Texnika tanlang">
									</select>
								</div>
								<div class="col-3 form-group">
									<label class="form-label">Seriya</label>
									<input class="form-control" type="text" name="series" pattern="^[A-Z]{3,5}$" onkeyup="this.value=this.value.toUpperCase()" title="3 ta harf kiriting" disabled="disabled" 
										@if(!empty($seriesNumber))
											value={{$seriesNumber->series}}
										@endif 
									/>
								</div>
								<div class="col-3 form-group">
									<label class="form-label">Raqam</label>
									<input class="form-control" type="text" name="number" required="required" pattern="[0-9]{6}" title="7 ta raqam kiriting" disabled="disabled" 
										@if(!empty($seriesNumber))
											value={{$seriesNumber->number}}
										@endif 

									/>

								</div>
								<div class="col-md-3 recover-field">
									<div class="form-group">
										<label class="form-label">Qayta tiklash sababi</label>
										<select class="form-control reason" name="recover_reason" required="required">
											<option value=""></option>
											<option  value="stolen">{{trans('app.reason-stolen')}}</option>
											<option  value="lost">{{trans('app.reason-lost')}}</option>
											<option  value="invalid">{{trans('app.reason-invalid')}}</option>
											<option value="new-version">Yangi namunaga o'tkazish</option>
										</select>
									</div>
								</div>									
								<div class="col-md-3">
									<label class="form-label">Alohida belgilar</label>
									<input class="form-control" type="text" name="note" />
								</div>
								<div class="col-md-5">
									<div class="row">
										<div class="col-sm-7">

											<label class="form-label">To'lov</label>

											<input class="form-control" type="number" name="payment" min="0" disabled required
											@if(!empty($payment_n))
												value="{{ $min->payment*($payment_n->payment/100) }}"
											@endif 
											>

										</div>
										<div class="col-5">
											<label class="container-checkbox">to'landi
											  	<input type="checkbox" required class="check-paid">
											  	<span class="checkmark"></span>
											</label>
										</div>

									</div>

								</div>

								<div class="col-12">
									<button type="button" class="btn btn-success float-right ml-2 print-button" data-toggle="modal" data-target="#preview-modal" disabled>Chop etish</button>
									<button class="btn btn-success float-right" type="submit">Saqlash</button>
								</div>

							</div>
						</form>
					</div>
				</div>
			</div>

			{{--   Technical passport preview Modal   --}}
			<div class="col-md-8">

				<div id="preview-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

					<div class="modal-dialog">

						<div class="modal-content">

							<div class="modal-header">

								<h5 class="modal-title" id="example-Modal3">{{$doc=='passport'?'Texnik pasport chop etish':'Texnik guvohnoma chop etish'}}</h5>

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

<script type="text/javascript">

	$(document).ready(function(){

		$('select.reason').select2({
			placeholder:'Qayta tiklash sababi',
			minimumResultsForSearch:Infinity
		});

		$("select[name='recover_reason']").change(function(){
			var data = $(this).val();
			$.ajax({
				type: 'GET',
				url: '/payment/technical-pass',
				data: 'payment='+data+'&type='+'{{ $doc }}',
				success: function(result){
					var data = {{ $min->payment }}*(result/100);
					$('input[name="payment"]').val(data);
				},
			})
		});

		$('.recover-field').hide();
		$('.recover-field select.reason').removeAttr('required');

		$('select.select-customer').select2({

			ajax:{

				url:'/customer/search',

				delay:300,

				dataType:'json',
				data:function(params){
					return{
						search:params.term
					}
				},

				processResults:function(data){

					console.log(data);

					data=data.map((item,index)=>{

						var ownershipForm='('+item.ownership_form+')';
						if(item.type=='physical'){
							ownershipForm='';
						}
						return {
							id:item.id,
							text:capitalize((item.lastname?item.lastname+' ':'')+item.name+(item.middlename?' '+item.middlename:''))+' '+ownershipForm
						}
					});

					return{

						results:data

					}

				}

			},

			placeholder:'Texnika egasini kiriting',

			minimumInputLength:1,

			escapeMarkup: function (markup) { return markup; },

			language:{

				inputTooShort:function(){

					return 'Egasining ismi (nomi), STIR ini kiritib izlang';

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

		$('select.select-transport').select2({
			minimumResultsForSearch: Infinity,
			escapeMarkup: function (markup) { return markup; },
			templateResult:transportFormat,

			language:{

				inputTooShort:function(){

					return 'Egasining ismi (nomi), STIR ini kiritib izlang';

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
			templateSelection:transportFormat,
			placeholder:'Texnika tanlang',		
		});



		function transportFormat(result){

			console.log('formatting',result);

			if(result.loading){

				return result.text;

			}

			if(result.element){

				var passport=$(result.element).attr('passport');
				var certificate=$(result.element).attr('certificate');
				var number=$(result.element).attr('number');
				var vType=$(result.element).attr('type');
				if(passport){

					return result.text+'<span title="Pasport raqami: '+passport+'" class="alert-for-passport text-danger float-right">Texnik pasport berilgan!</span>'

				}else if(certificate){
					return result.text+'<span title="Texnik guvohnoma raqami: '+certificate+'" class="alert-for-passport text-danger float-right">Texnik guvohnoma berilgan!</span>';
				}else if(!number && vType!=='agregat'){
					return result.text+'<span class="alert-for-passport text-danger float-right">Davlat raqami berilmagan!</span>';
				}

			}

			return result.text;
		}



		//check if one of the transports is chosen
		if($('select.select-transport').attr('chosen-vehicle') && $('select.select-customer').val()){
			var customerId=$('select.select-customer').val();
			var chosenVehicle=$('select.select-transport').attr('chosen-vehicle');
			var doc=$('input[name="doc"]').val();
			$.ajax({

				url:'/vehicle/find-by-owner',
				data:{
					customer_id:customerId,
					chosen_vehicle:chosenVehicle,
					type:doc=='passport'?'vehicle':'agregat'
				},
				success:function(data){
					console.log(data);
					$('select.select-transport').html('<option value="">Texnika tanlang</option>'+data);
					transportChangeHandler($('select.select-transport'));
				}
			});
		}

		$('select.select-customer').change(function(){
			var customerId=$(this).val();
			var doc=$('input[name="doc"]').val();
			$.ajax({
				url:'/vehicle/find-by-owner',
				data:{
					customer_id:customerId,
					type:doc=='passport'?'vehicle':'agregat'
				},
				success:function(data){
					console.log(data);
					$('select.select-transport').html('<option value="">Texnika tanlang</option>'+data);
				}
			});
		});

		$('select.select-transport').change(function(){
			transportChangeHandler($(this));
		});

		function transportChangeHandler(th){
			var selectedElement=th.find('option:selected')
			$('.customer-type-button').css('pointer-events','unset');
			var passport=selectedElement.attr('passport');
			var certificate=selectedElement.attr('certificate');
			var number=selectedElement.attr('number');
			var vType=selectedElement.attr('type');

			$('.recover-field').hide();
			$('.recover-field select.reason').removeAttr('required');

			if((passport || certificate) && !$('.customer-type-button[val="recover"]').is('.selected')){
				if(passport){
					var text='Tanlangan texnikaga texnik pasport berilgan ('+passport+'). Davom etish uchun quyidagilardan birini tanlang';
				}else if(certificate){
					var text='Tanlangan texnikaga texnik guvohnoma berilgan ('+certificate+'). Davom etish uchun quyidagilardan birini tanlang'
				}
				swal({
					text,
					type:'info',
					title:'',
					showCancelButton:true,
					confirmButtonText:'Hujjatni qayta tiklash',
					cancelButtonText:'Boshqa texnika tanlash'
				}).then((result)=>{
					console.log('result',result);
					$('.customer-type-button').filter('[val="give"]').css('pointer-events','none');
					$('.customer-type-button').removeClass('selected').filter('[val="recover"]').addClass('selected');

					$('.recover-field').show();
					$('.recover-field select.reason').attr('required','required');
				}).catch((err)=>{
					console.log('cought',err);
					th.find('option:selected').attr('selected','');
					if(!th.find('option').first().val()){
						th.prepend('<option value="" selected="selected">Texnika tanlang</option>');
					}else{
						th.find('option').first().attr('selected','selected');
					}
				});
			}else if(!passport && !certificate){  // passport is not given, so i am ging to disable recover button
				$('.customer-type-button').removeClass('selected').filter('[val="give"]').addClass('selected');
				$('.recover-field').hide();
				$('.customer-type-button').filter('[val="recover"]').css('pointer-events','none');
			}else{  // passport is given, and recover action is already selected, here i am going to disable give button till chosen transport changes
				$('.customer-type-button').filter('[val="give"]').css('pointer-events','none');

				$('.recover-field').show();
				$('.recover-field select.reason').attr('required','required');
			}
			if(!number && vType!=='agregat'){
				swal({
					text:'Tanlangan texnikaga davlat raqami berilmagan. Davom etish uchun quyidagilardan birini tanlang',
					type:'info',
					title:'',
					showCancelButton:true,
					confirmButtonText:'Davlat raqami berish',
					cancelButtonText:'Boshqa texnika tanlash'
				}).then(function(result){
					console.log('result',result);
					window.location='/vehicle/transport-number?vehicle_id='+th.val();
				}).catch((err)=>{
					th.find('option:selected').attr('selected','');
					if(!th.find('option').first().val()){
						th.prepend('<option value="" selected="selected">Texnika tanlang</option>');
					}else{
						th.find('option').first().attr('selected','selected');
					}
				});

			}
		}


		$('div.customer-type-button').on('click',(e)=>{
			var cType=$(e.target).attr('val');
			console.log('customer type selected',cType);

			if(cType=='give'){
				$('input[name="payment"]').val('{{ $min->payment*($payment_n->payment/100) }}');

				$('.recover-field').hide();
				$('.recover-field select.reason').removeAttr('required');

				$('div.customer-type-button[val="give"]').addClass('selected');
				$('div.customer-type-button[val="recover"]').removeClass('selected');
				$('select').val(null);
				$('select.select-doc option[value="18"]').removeAttr('disabled');

			}else if(cType=='recover'){
				$('input[name="payment"]').val('');
				$('.recover-field').show();
				$('.recover-field select.reason').attr('required','required');

				$('div.customer-type-button[val="give"]').removeClass('selected');
				$('div.customer-type-button[val="recover"]').addClass('selected');
				$('select').val(null);
				$('select.select-doc').val(null).trigger('change').find('option[value="18"]').attr('disabled','disabled');
			}
		});

	    $("input.given-date").datetimepicker({
			format: "dd-mm-yyyy",

			autoclose: 1,

			minView: 2,

			startView:'month',

			endDate: new Date()
		});

		$('#technical-passport-form').on('submit',function(){
			var th=$(this);
			var submitButton=$(this).find('button[type="submit"]');
			var printButton=$(this).find('button.btn.print-button');
			var doc=$('input[name="doc"]').val();
			submitButton.addClass('btn-loading');

			var disabled=$(this).find(':input:disabled').removeAttr('disabled');

			var formArray=$(this).serializeArray();

			disabled.attr('disabled','disabled');

			formArray.push({
				name:'action',
				value:$('.customer-type-button.selected').attr('val')
			});

			console.log(formArray);

			$.ajax({

				url:'/vehicle/technical-passport',

				type:'POST',

				data:formArray,

				success:function(data){  // it should return the id of new added document
					submitButton.removeClass('btn-loading');
					
					data=JSON.parse(data);
					if(data.message=='success' && data.id){
						printButton.removeAttr('disabled');
						var n=doc=='passport'?'technical-passport-id':'vehicle-certificate-id';
						swal('Saqlandi!','','success');
						th.prepend('<input type="hidden" name="'+n+'" value="'+data.id+'" />');
					}else if(data.message=='active-technical-passport-exists'){
						swal('Xatolik!','Tanlangan texnikaga tegishli aktiv texnik pasport mavjud, qayta tiklashga urinib ko\'ring','error');
					}else if(data.message=='error'){
						swal('Xatolik', data.text)
					}else{
						swal('Xatolik!','','error');
					}
				},
				error:function(err){
					console.log('Error on saving technical passport',err);
					submitButton.removeClass('btn-loading');
					swal('Xatolik','','error');
				}
			});
		});

		$('.btn[data-target="#preview-modal"]').on('click',function(){
			var doc=$('input[name="doc"]').val();
			if(doc=='passport'){
				var technicalPassportId=$('#technical-passport-form').find('input[name="technical-passport-id"]').val();
				var url='/vehicle/technical-passport/preview?id='+technicalPassportId;
			}else if(doc=='certificate'){
				var certificateId=$('#technical-passport-form').find('input[name="vehicle-certificate-id"]').val();
				var url='/certificate/preview?id='+certificateId;
			}
			
			$('#preview-modal .modal-body').html('<iframe src="'+url+'"height="340"></iframe><div class="btn btn-info float-right mt-2 send-to-print">Chop etish</div>');
			$('.send-to-print').on('click',function(){
				$(this).parent().find('iframe').attr('src',url+'&print=true');
			})
		});
		$('select.select-doc').select2({
			minimumResultsForSearch:Infinity,
			placeholder:'Asos hujjatni tanlang'
		});

		defaultSeries=$('input[name="series"]').val();
		defaultNumber=$('input[name="number"]').val();

		$("select.select-doc").change(function(){
			var doc=$('input[name="doc"]').val();
			let paymentInput=$('input[name="payment"]');
			var id = $(this).val();
			if((doc=='passport' && id == 18) || (doc=='certificate' && id==30)){  // mavjud bazadan elektron bazaga o'tkazish
				$('input.check-paid').prop('checked', true).trigger('change');
				paymentInput.attr('type', 'text');
				paymentInput.val("To'lov undirilmaydi");

				$('input[name="series"]').removeAttr('disabled').val('').attr('required', 'required');
				$('input[name="number"]').removeAttr('disabled').val('').attr('required', 'required');
			}else{
				$('input.check-paid').prop('checked', false).trigger('change');
				paymentInput.attr('type', 'number');
				$('input[name="new_b"').trigger('change');

				$('input[name="series"]').attr('disabled', 'disabled').val(defaultSeries);
				$('input[name="number"]').attr('disabled', 'disabled').val(defaultNumber);
			}
		});
	});

</script>



@endsection
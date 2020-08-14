@extends('layouts.app')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php $userid = Auth::user()->id; ?>

@if (CheckAdmin($userid)=='yes')

	<div class="section">

		<div class="page-header">

			<ol class="breadcrumb">

				<li class="breadcrumb-item">

					<i class="fe fe-life-buoy mr-1"></i>&nbsp Texnikaga davlat raqami berish

				</li>

			</ol>

		</div>

		<div class="row">

			<div class="col-md-12">

				<div class="card">									

					<div class="card-body">

						<form action="javascript:void(0);" id="transport-number-form">

							<div class="row">

								<input type="hidden" name="_token" value="{{csrf_token()}}">

								<div class="col-md-6">

									<label class="form-label" style="visibility: hidden;">asd</label>

									<div class="row">

										<div class="col-md-6 pr-0">

											<div class="customer-type-button <?=($t_number->action=='give')?'selected':'' ?> py-2" val="give">
												Berish
											</div>
										</div>

										<div class="col-md-6 pl-0">

											<div class="customer-type-button py-2" val="recover" <?=($t_number->action=='recover')?'selected':'' ?>>
												Qayta tiklash
											</div>

										</div>

									</div>

								</div>
								<div class="col-md-6"></div>
								<div class="col-md-3">

									<label class="form-label">Davlat raqami berilgan sana</label>

									<input class="form-control given-date" name="given_date" placeholder="dd-mm-yyyy" required="required" autocomplete="off" value="{{date('d-m-Y', strtotime($t_number->given_date))}}">

								</div>

								<div class="col-md-5 form-group">

									<label class="form-label">Texnika egasi</label>

									<select class="form-control select-customer" name="customer_id" required="required" title="Texnika egalaridan tanlang">

										@if(!empty($customer))

											<option value="{{$customer->id}}" selected="selected" customer-state="{{$customer->state_id}}">

												{{$customer->lastname.' '.$customer->name.' '.$customer->middlename}}

											</option>

										@endif

									</select>

								</div>
								<div class="col-4 form-group">
									<label class="form-label">Asos</label>
									<select class="form-control select-doc" name="doc" required="required">
										<option value="">Asos hujjatni tanlang</option>
										@if(!empty($documents))
											@foreach($documents as $document)
												<option doc-note='{{$t_number->doc_note}}' <?=($t_number->doc==$document->id)?'selected':'' ?> value="{{$document->id}}">{{$document->name}}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="col-md-6 form-group">

									<label class="form-label">Texnika</label>

									<select 

										chosen-vehicle="{{!empty($vehicle)?$vehicle->id:''}}" 

										class="form-control select-transport" 

										name="transport" 

										required="required" 

										title="Texnika tanlang">
										@if(!empty($vehicle))

											<option value="{{$vehicle->id}}" selected="selected">

												{{$vehicle->type.' ('.$vehicle->brand.') '}}

											</option>

										@endif

									</select>

								</div>

								<div class="col-md-6 form-group">

									<label class="form-label">Davlat raqami turi</label>

									<select class="form-control select-type custom-select" name="type" required="required">
										<option value="">va</option>
										<option value="1" <?=$t_number->type==1?'selected':'' ?>>1 (Yuridik o'ziyurarlar uchun)</option>

										<option value="2" <?=$t_number->type==2?'selected':'' ?>>2 (Jismoniy o'ziyurarlar uchun)</option>

										<option value="3" <?=$t_number->type==3?'selected':'' ?>>3 (Yuridik tirkamalar uchun)</option>

										<option value="4" <?=$t_number->type==4?'selected':'' ?>>4 (Jismoniy tirkamalar uchun)</option>

									</select>

								</div>

								<div class="col-md-6 form-group">

									<label class="form-label">Viloyat kodi</label>

									<div class="row">

										<div class="col-8">

											<select class="form-control select-state custom-select" name="state_id">

												@if(!empty($states))
													<option value=""></option>
													@foreach($states as $state)

														<option <?=($t_number->state_id==$state->id)?'selected':'' ?> value="{{$state->id}}" state-code="{{$state->code}}">

															{{$state->name.' - '.$state->code}}

														</option>

													@endforeach

												@endif

											</select>

										</div>

										@if(Auth::user()->role=='admin')
											<div class="col-md-4">

												<div class="btn btn-success w-100" data-toggle="modal" data-target="#states-modal">Viloyatlar</div>

											</div>
										@endif

									</div>

								</div>

								<div class="col-md-2 form-group">

									<label class="form-label">Seriya</label>

									<input class="form-control" value="{{$t_number->series}}"  type="text" name="series" pattern="[A-Z]{2}" onkeyup="this.value=this.value.toUpperCase()" required="required" title="2 ta harf kiriting!" placeholder="AA" maxlength="2" />

								</div>

								<div class="col-md-4 form-group">

									<label class="form-label">Raqam</label>

									<input class="form-control" value="{{$t_number->number}}" type="text" name="number" pattern="[0-9]{3}" required="required" title="3 ta raqam kiriting!" placeholder="777" maxlength="3" />

								</div>

								<div class="col-md-3 recover-field">
									<div class="form-group">
										<label class="form-label">Qayta tiklash sababi</label>
										<select class="form-control reason" name="recover_reason">
											<option value=""></option>
											<option value="lost_a" <?=$t_number->recover_reason=='lost_a'?'selected':'' ?>>Yo'qolgan eski namunadagi DRBga yangi DRB berish</option>
											<option value="lost_b" <?=$t_number->recover_reason=='lost_a'?'selected':'' ?>>Yo'qolgan yangi namunadagi DRBga yangi DRB berish</option>
											<option value="invalid" <?=$t_number->recover_reason=='lost_a'?'selected':'' ?>>{{trans('app.reason-invalid')}}</option>
										</select>
									</div>
								</div>
								<div class="col-3" id="oldnum">
									<label class="container-checkbox">Eski raqamni qoldirish
									  	<input class="leave-old-number-checkbox" name='new_b' type="checkbox">
									  	<span class="checkmark"></span>
									</label>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-sm-9">
											<label class="form-label">To'lov</label>
											<input class="form-control" type="number" name="payment" min="0" disabled value="" required>
										</div>
										<div class="col-3">
											<label class="container-checkbox">
												<span id="tolandi">To'landi</span>
											  	<input type="checkbox" required class="check-paid">
											  	<span class="checkmark"></span>
											</label>
										</div>
									</div>
								</div>

								<div class="col-md-3">
									<label class="form-label" style="visibility: hidden;">label</label>
									<button class="btn btn-success float-right" type="submit">Saqlash</button>

								</div>

							</div>

						</form>

					</div>

				</div>

			</div>

		</div>



		<!-- States Modal -->

		<div class="col-md-6">

			<div id="states-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">

							<h5 class="modal-title" id="example-Modal3">Viloyatlar</h5>

							<button type="button" class="close" data-dismiss="modal" aria-label="Close">

								<span aria-hidden="true">&times;</span>

							</button>

						</div>

						<div class="modal-body">

							<table class="table card-table table-vcenter text-nowrap ownership_form_class"  align="center">

								<thead>

									<tr>

										<td class="text-center">

											<strong>Viloyat</strong>

										</td>

										<td>

											<strong>Kod</strong>

										</td>

										<td class="text-right">

											<strong>{{ trans('app.Action')}}</strong>

										</td>

									</tr>

								</thead>

								<tbody>

									@if(!empty($states))

										@foreach ($states as $state)

											<tr class="del-{{ $state->id }}">

												<td class="text-center state-name">{{ $state->name }}</td>

												<td class="text-center state-code">{{$state->code}}</td>

												<td class="text-right">

													<button type="button" stateid="{{ $state->id }}" 

													url="{!! url('/update-state') !!}" class="btn btn-info btn-xs state-edit" title="Tahrirlash">

														<i class="fa fa-pencil"></i>

													</button>

												</td>

											</tr>

										@endforeach

									@endif

								</tbody>

							</table>

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
		var payment = 0;
		@foreach($payment_n as $payment)
			@if($payment->key_payment == 'new_a')
				payment = {{ $min->payment*($payment->payment/100) }}
			@endif
		@endforeach
		$("input[name='payment']").val(parseInt(payment));
		$('select.reason').select2({
			placeholder:'Qayta tiklash sababi',
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
			minimumResultsForSearch:Infinity
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
						search:params.term,
						stateInfo:true
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
							text:capitalize((item.lastname?item.lastname+' ':'')+item.name+(item.middlename?' '+item.middlename:''))+' '+ownershipForm,
							item,
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

					return 'Mulk egasini nomi, SHIR, STIR ni kiritib izlang';

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
			templateResult:customerFormat,
			templateSelection:customerFormat
		});

		$('select.select-doc').select2({
			minimumResultsForSearch:Infinity,
			placeholder:'Asos hujjatni tanlang'
		});
		@if(!empty($editId))
			$('select.select-doc').trigger('change');
		@endif

		$("select.select-doc").change(function(){
			let paymentInput=$('input[name="payment"]');
			var id = $(this).val();
			if(id == 12){
				$('input.check-paid').prop('checked', true).trigger('change');
				paymentInput.attr('type', 'text');
				paymentInput.val("To'lov undirilmaydi");
			}else{
				$('input.check-paid').prop('checked', false).trigger('change');
				paymentInput.attr('type', 'number');
				$('input[name="new_b"').trigger('change');
			}
		});

		function customerFormat(result){
			if(result.loading){
				return result.text;
			}
			if(result && result.item && result.item.state_id){
				return result.text+'<span class="customer-state-info" state-id="'+result.item.state_id+'"></span>';
			}else{
				return capitalize(result.text.trim());
			}
		}

		function capitalize(text){
			var words=text.split(' ');
			for(var i=0;i<words.length;i++){
				words[i]=words[i][0].toUpperCase()+words[i].substring(1).toLowerCase();
			}
			return words.join(' ');
		}

		$('select.select-state').select2({
			minimumResultsForSearch: Infinity,
			placeholder: 'Viloyatni tanlang'
		});

		$('select.select-type').select2({
			minimumResultsForSearch: Infinity,
			placeholder: 'Davlat raqami turini tanlang'
		});

		$('select.select-transport').select2({

			minimumResultsForSearch: Infinity,

			escapeMarkup: function (markup) { return markup; },

			templateResult:transportFormat,

			templateSelection:transportFormat,

			placeholder:'Texnika tanlang',

			language:{

				searching:function(){

					return 'Izlanmoqda...';

				},

				noResults:function(){

					return "Tanlangan texnika egasiga tegishli texnika mavjud emas"

				}

			}
		});

		$('select[name="recover_reason"]').change(function(){
			var reason = $(this).val();
			var payment = 0;
			@foreach($payment_r as $payment)
				if(reason == '{{ $payment->key_payment }}'){
					payment = {{ $min->payment*($payment->payment/100) }}
				}
			@endforeach
			$("input[name='payment']").val(parseInt(payment));
		});

		$('input[name="new_b"]').change(function(e){
			var vehicleId=$('select.select-transport').val();
			var type = $(this).is(':checked');

			// one vehicle should be chosen
			if(!vehicleId && type){
				swal('Texnika tanlang!','','warning');
				$(this).prop('checked',false);
				e.preventDefault();
				e.stopImmediatePropagation();
				return;
			}

			// payment section
			
			var payment = 0;
			if(type){
				@foreach($payment_n as $payment)
					if('new_b' == '{{ $payment->key_payment }}'){
						payment = {{ $min->payment*($payment->payment/100) }}
					}
				@endforeach
			}else{
				@foreach($payment_n as $payment)
					if('new_a' == '{{ $payment->key_payment }}'){
						payment = {{ $min->payment*($payment->payment/100) }}
					}
				@endforeach
			}
			$("input[name='payment']").val(parseInt(payment));

			
			if(type){
				// getting last active number
				$.ajax('/vehicle/get-last-active-transport-number',{
					type:'GET',
					data:{
						vehicle_id:vehicleId
					},
					success:function(data){
						data=JSON.parse(data);
						if(data && data.id && data.result!=='not-found'){
							$('input[name="series"]').val(data.series).attr('disabled','disabled');
							$('input[name="number"]').val(data.number).attr('disabled','disabled');
							$('select.select-state option').removeAttr('selected').filter('[state-code="'+data.code+'"]').attr('selected','selected');
							$('select.select-state').trigger('change').prop('disabled',true);
						}else{
							// for now do nothing
						}
					},
					error:function(err){
						console.log('error while getting last active number',err);
					}
				})
			}else{
				// clearing number fields
				$('input[name="series"]').val('').removeAttr('disabled');
				$('input[name="number"]').val('').removeAttr('disabled');
				$('select.select-state').prop('disabled',false);
			}
		});

		function transportFormat(result){
			if(result.loading){
				return result.text;
			}
			var number=$(result.element).attr('number');
			if(number){
				return result.text+'<span title="Davlat raqami: '+number+'" class="alert-for-number text-danger float-right">Davlat raqami berilgan!</span>'
			}else{
				return result.text;
			}
		}


		//check if one of the transports is chosen
		if($('select.select-transport').attr('chosen-vehicle') && $('select.select-customer').val()){

			var customerId=$('select.select-customer').val();

			var chosenVehicle=$('select.select-transport').attr('chosen-vehicle');

			$.ajax({

				url:'/vehicle/find-by-owner',

				data:{

					customer_id:customerId,
					type:'vehicle',
					chosen_vehicle:chosenVehicle

				},

				success:function(data){
					console.log(data);
					$('select.select-transport').html('<option value="">Texnika tanlang</option>'+data);
					transportChangeHandler($('select.select-transport'));
				}

			});
			// setting state checked according to chosen customer's state
			$('select.select-state option').removeAttr('selected');
			$('select.select-state').val($('select.select-customer option').attr('customer-state')).trigger('change');
		}

		$('select.select-customer').change(function(){
			var customerId=$(this).val();
			$.ajax({
				url:'/vehicle/find-by-owner',
				data:{
					customer_id:customerId,
					type:'vehicle',
					action:'edit'
				},
				success:function(data){
					console.log(data);
					$('select.select-transport').html('<option value="">Texnika tanlang</option>'+data);
				}
			});
			var chosenState=$(this).next().find('span.customer-state-info').attr('state-id');
			console.log('chosenState',chosenState);

			$('select.select-state option').removeAttr('selected').filter('[value='+chosenState+']').attr('selected','selected');
			$('select.select-state').val(chosenState).trigger('change');
		});



		$('select.select-transport').change(function(){
			transportChangeHandler($(this));
		});

		function transportChangeHandler(th){
			console.log($('select.select-transport option:selected').attr('type'));
			$('input.leave-old-number-checkbox').prop('checked',false).trigger('change');
			$('.customer-type-button').css('pointer-events','unset');

			var number=th.find('option:selected').attr('number');

			if(number && !$('.customer-type-button[val="recover"]').is('.selected')){

				swal({

					text:'Tanlangan texnikaga davlat raqami berilgan ('+number+'). Davom etish uchun quyidagilardan birini tanlang',

					type:'info',

					title:'',

					showCancelButton:true,

					confirmButtonText:'Davlat raqamini qayta tiklash',

					cancelButtonText:'Boshqa texnika tanlash'

				}).then((result)=>{
						$('.recover-field').show();
						$('.recover-field select.reason').attr('required','required');

						$('#oldnum').hide();
						$('.customer-type-button').removeClass('selected').filter('[val="recover"]').addClass('selected');

						$('.customer-type-button').filter('[val="give"]').css('pointer-events','none');
				}).catch((err)=>{
					th.find('option:selected').attr('selected','');

					if(!th.find('option').first().val()){

						th.prepend('<option value="" selected="selected">Texnika tanlang</option>');

					}else{

						th.find('option').first().attr('selected','selected');

					}
				});

			}else if(!number){

				$('.customer-type-button').removeClass('selected').filter('[val="give"]').addClass('selected');
				$('.recover-field').hide();
				$('.recover-field select.reason').removeAttr('required');
				
				$('.customer-type-button').filter('[val="recover"]').css('pointer-events','none');

			}else{  // transport number is given, and recover action is already selected, here i am going to disable give button till chosen transport changes

				$('.customer-type-button').filter('[val="give"]').css('pointer-events','none');

			}
		}

		$('div.customer-type-button').on('click',(e)=>{

			var cType=$(e.target).attr('val');
			if(cType=='give'){
				$('.recover-field').hide();
				$('.recover-field select.reason').removeAttr('required');
				
				$('div.customer-type-button[val="give"]').addClass('selected');

				$('div.customer-type-button[val="recover"]').removeClass('selected');

				$('select').val(null);
				$('#oldnum').show();
				var payment = 0;
				@foreach($payment_n as $payment)
					@if($payment->key_payment == 'new_a')
						payment = {{ $min->payment*($payment->payment/100) }}
					@endif
				@endforeach
				$("input[name='payment']").val(parseInt(payment));

				$('select.select-doc option[value="12"]').removeAttr('disabled');

			}else if(cType=='recover'){
				$('.recover-field').show();
				$('.recover-field select.reason').attr('required','required');

				$('div.customer-type-button[val="give"]').removeClass('selected');

				$('div.customer-type-button[val="recover"]').addClass('selected');
				$("input[name='payment']").val('0');
				$('#oldnum').hide();

				$('select').val(null);


				$('select.select-doc').val(null).trigger('change').find('option[value="12"]').attr('disabled','disabled');
			}
		});

	    $("input.given-date").datetimepicker({
			format: "dd-mm-yyyy",
			autoclose: 1,
			minView: 2,
			startView:'month',
			endDate: new Date(),
		});

		$('#transport-number-form').one('submit',function(e){
			e.preventDefault();
			var submitButton=$(this).find('button[type="submit"]');
			submitButton.addClass('btn-loading');

			var disabled=$(this).find(':input:disabled').removeAttr('disabled');
			var formArray=$(this).serializeArray();
			disabled.attr('disabled','disabled');

			formArray.push({
				name:'action',
				value:$('.customer-type-button.selected').attr('val')
			});
			formArray.push({
				name:'code',
				value:$('select.select-state option:selected').attr('state-code')
			});
			var transportId=$('select.select-transport').val();
			console.log(formArray);
			$.ajax({
				url:'/vehicle/transport-number/update/{{$editId}}',
				type:'POST',
				data:formArray,
				success:function(data){
					submitButton.removeClass('btn-loading').attr('disabled','disabled');

					if(data=='success'){
						swal('Saqlandi!','','success');
						var mainType=$('select.select-transport option:selected').attr('type');  // agregat or vehicle
						if(mainType=='agregat'){
							var button='<a href="/certificate/add?vehicle_id='+ transportId +'" class="btn btn-success mr-2 float-right">Texnik guvohnoma berish</a>';
						}else{
							var button='<a href="/vehicle/technical-passport?vehicle_id='+ transportId +'" class="btn btn-success mr-2 float-right">Texnik pasport berish</a>';
						}
						submitButton.after(button);
					}else if(data=='active-transport-number-exists'){
						swal('Xatolik!','Tanlangan texnikaga tegishli aktiv davlat raqami mavjud, qayta tiklashga urinib ko\'ring','error');
					}else{
						swal('Xatolik!','','error');
					}
				},
				error:function(err){
					console.log('Error on saving transport number');
					swal('Xatolik','','error');
				}
			});
		});


		$('.state-edit').on('click',function(){

			var th=$(this);

			var row=$(this).closest('tr');

			var stateName=row.find('.state-name');

			var stateCode=row.find('.state-code');



			if($(this).is('.state-save')){

				console.log('stata save clicked');

				$(this).removeClass('state-save');

				var url=$(this).attr('url');

				var data={

					_token:$('input[name="_token"]').val(),

					stateId:$(this).attr('stateid'),

					name:row.find('.state-name input').val(),

					code:row.find('.state-code input').val()

				}

				$.ajax({

					url:url,

					type:'POST',

					data:data,

					success:function(data){

						console.log(data);

						stateName.html(stateName.find('input').val());

						stateCode.html(stateCode.find('input').val());

						th.html('<i class="fa fa-pencil"></i>');

					},

					error:function(err){

						console.log('error',err);

						swal('Xatolik','','error');

					}

				});

			}else{

				stateName.html('<input class="form-control" value="'+stateName.text()+'" />');

				stateCode.html('<input class="form-control" value="'+stateCode.text()+'" />');

				$(this).html('Saqlash');

				$(this).addClass('state-save');

			}
		});



		// checking if entered transport number exists in database
		$('select.select-state, input[name="series"], input[name="number"]').change(function(){
			checkIfNumberExist();
		});

		$('input[name="number"]').on('keyup',function(){
			var submitButton=$('#transport-number-form button[type="submit"]');
			submitButton.attr('disabled','disabled');
		});

		function checkIfNumberExist(){
			var code=$('select.select-state option:selected').attr('state-code');
			var series=$('input[name="series"]').val();
			var number=$('input[name="number"]').val();
			var editId = {{$editId}};
			var submitButton=$('#transport-number-form button[type="submit"]');
			if(code && series && number){
				console.log('checking');
				$.ajax({
					type:'GET',
					url:'/vehicle/check-for-transport-number',
					data:{
						code,
						series,
						number,
						editId
					},

					success:function(data){

						console.log(data);

						if(data=='exist'){
							$('input[name="number"]').val('');
							submitButton.attr('disabled','disabled');
							swal('Kiritilgan davlat raqami mavjud!','Viloyat kodini, seriya yoki raqamni o\'zgartirishingiz mumkin','error');
							return 'exist';
						}else{
							if($('input.check-paid').is(':checked')){
								submitButton.removeAttr('disabled');
							}
							return 'not-exist';
						}

					},

					error:function(err){

						console.log(err);

					}

				});

			}
		}
	
	    

	});

</script>



@endsection
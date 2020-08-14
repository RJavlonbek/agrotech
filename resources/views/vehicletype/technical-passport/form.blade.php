@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Customers',$userid)=='yes')
	<div class="section">
		<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#"><i class="fe fe-life-buoy mr-1"></i>&nbsp Tex passport berish</a>
				</li>
			</ol>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">									
					<div class="card-body p-6">
						<form action="javascript:void(0);" id="technical-passport-form">
							<div class="row">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
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
								<div class="col-6">
									<label class="form-label">Passport berilgan sana</label>
									<input class="form-control given-date" name="given_date" placeholder="yyyy-mm-dd" required="required">
								</div>
								<div class="col-6 form-group">
									<label class="form-label">Texnika egasi</label>
									<select class="form-control select-customer" name="customer_id">
										@if(!empty($customers))
											@foreach($customers as $customer)
												<option value="{{$customer->id}}">
													{{$customer->name.' '.$customer->lastname.' ('.$customer->ownership_form.')'}}
												</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="col-6 form-group">
									<label class="form-label">Texnika</label>
									<select class="form-control select-transport" name="transport" required="required">
									</select>
								</div>
								<div class="col-2 form-group">
									<label class="form-label">Seriya</label>
									<input class="form-control" type="text" name="series" pattern="[A-Z]{3}" onkeyup="this.value=this.value.toUpperCase()" placeholder="AAA" />
								</div>
								<div class="col-4 form-group">
									<label class="form-label">Raqam</label>
									<input class="form-control" type="text" name="number" required="required" />
								</div>
								<div class="col-3">
									<label class="form-label">Umumiy summa</label>
									<input class="form-control" type="number" name="total_amount" min="0" step="100">
								</div>
								<div class="col-3">
									<label class="form-label">To'langan summa</label>
									<input class="form-control" type="number" name="paid_amount" min="0" step="100">
								</div>
								<div class="col-12">
									<button class="btn btn-success float-right" type="submit">Saqlash</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
              <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
              </div>
          </div>
	</div>
@endif
<script type="text/javascript">
	$(document).ready(function(){
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
						return {
							id:item.id,
							text:item.name+' '+(item.lastname?item.lastname:'')+' ('+item.ownership_form+')'
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
					return 'Mulk egasini nomi,INN raqami,STIR kiritib izlang';
				},
				searching:function(){
					return 'Izlanmoqda...';
				},
				noResults:function(){
					return "Natija topilmadi"
				}
			}
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
					return "Natija topilmadi"
				}
			}
		});

		function transportFormat(result){
			console.log('formatting',result);
			if(result.loading){
				return result.text;
			}
			var passport=$(result.element).attr('passport');
			console.log(passport);
			if(passport){
				return result.text+'<span title="Passport raqami: '+passport+'" class="alert-for-passport text-danger float-right">Passport berilgan!</span>'
			}else{
				return result.text;
			}
		}

		$('select.select-customer').change(function(){
			var customerId=$(this).val();
			$.ajax({
				url:'/vehicle/find-by-owner',
				data:{
					customer_id:customerId
				},
				success:function(data){
					console.log(data);
					$('select.select-transport').html('<option value="">Texnika tanlang</option>'+data);
				}
			});
		});

		$('select.select-transport').change(function(){
			var th=$(this)
			var passport=th.find('option:selected').attr('passport');
			if(passport && !$('.customer-type-button[val="recover"]').is('.selected')){
				swal({
					text:'Tanlangan texnikaga texnik passport berilgan ('+passport+'). Davom etish uchun quyidagilardan birini tanlang',
					type:'info',
					title:'',
					showCancelButton:true,
					confirmButtonText:'Passportni qayta tiklash',
					cancelButtonText:'Boshqa texnika tanlash'
				},function(result){
					console.log('result',result);
					if(result){
						$('.customer-type-button').removeClass('selected').filter('[val="recover"]').addClass('selected');
					}else{
						th.find('option').first().attr('selected','selected');
						console.log('val',th.val());
					}
				});
			}
		});

		$('div.customer-type-button').on('click',(e)=>{
			var cType=$(e.target).attr('val');
			console.log('customer type selected',cType);
			if(cType=='give'){
				$('div.customer-type-button[val="give"]').addClass('selected');
				$('div.customer-type-button[val="recover"]').removeClass('selected');
			}else if(cType=='recover'){
				$('div.customer-type-button[val="give"]').removeClass('selected');
				$('div.customer-type-button[val="recover"]').addClass('selected');
			}
		});

	    $("input.given-date").datetimepicker({
			format: "yyyy-mm-dd",
			autoclose: 1,
			minView: 2,
			startView:'decade',
			endDate: new Date()
		});

		$('#technical-passport-form').on('submit',function(){
			var submitButton=$(this).find('button[type="submit"]');
			submitButton.addClass('btn-loading');
			var formArray=$(this).serializeArray();
			formArray.push({
				name:'action',
				value:$('.customer-type-button.selected').attr('val')
			});
			console.log(formArray);
			$.ajax({
				url:'/vehicle/technical-passport',
				type:'POST',
				data:formArray,
				success:function(data){
					submitButton.removeClass('btn-loading');
					if(data=='success'){
						swal('Saqlandi!','','success');
					}else{
						swal('Xatolik!','','error');
					}
				}
			});
		});
	});
</script>

@endsection
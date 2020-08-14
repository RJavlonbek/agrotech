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

@if (CheckAccessUser('driver_exam', $userid, 'create')=='yes')
		<div class="section">

			<div class="page-header">

				<ol class="breadcrumb">

					<li class="breadcrumb-item">

						<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Haydovchilik imtihonlari')}}

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

											<a href="{!! url('/driver-exam/list')!!}">

												<span class="visible-xs"></span>

												<i class="fa fa-list fa-lg">&nbsp;</i> 

												Haydovchi imtihonlari ro'yxati

											</a>

										</li>

										<li class="active">

											<a href="{!! url('/driver-exam')!!}">

												<span class="visible-xs"></span>

												<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

												Haydovchi imtihonlarini topshirish</b>

											</a>

										</li>

									</ul>

								</div>

							</div>

							<form action="javascript:void(0);" id="driver-exam-form">

								<div class="row">

									<input type="hidden" name="_token" value="{{csrf_token()}}">

									<div class="col-6 form-group">

										<label class="form-label">{{trans('app.Haydovchi')}}</label>

										<select class="form-control select-customer" name="customer_id" required="required">

											@if(!empty($customer))

												<option value="{{$customer->id}}" selected="selected">

													{{$customer->name.' '.$customer->lastname.' ('.$customer->ownership_form.')'}}

												</option>

											@endif

										</select>

									</div>

									<div class="col-12 col-md-6">

										<div class="form-group">

											<label class="form-label">Imtihon turi</label>

											<select class="form-control select-type" name="type" required="required">

												@if(!empty($examTypes))
													<option value="">turi</option>

													@foreach($examTypes as $type)

														<option value="{{$type->id}}">

															{{$type->name}}

														</option>

													@endforeach

												@endif

											</select>

										</div>

									</div>

									<div class="col-md-6 form-group">

										<label class="form-label">Imtihon topshirilgan sana</label>

										<input readonly="true" class="form-control given-date" name="given_date" placeholder="dd-mm-yyyy" value="{{date('d-m-Y')}}" required="required">

									</div>
									<div class="col-md-6 form-group">
										<label class="form-label">Imtihon natijasi</label>
										<input class="form-control" type="text" name="result" placeholder="Natijani kiriting">
									</div>

									<div class="col-md-3 col-12 form-group">
										<label class="container-checkbox form-label">Qayta topshirilmoqda
										  	<input type="checkbox" name="retest">
										  	<span class="checkmark"></span>
										</label>
									</div>

									<div class="col-md-6 form-group">
										<div class="row">
											<div class="col-7">
												<label class="form-label">To'lov</label>
												<input class="form-control" type="number" name="payment" min="0" step="0" placeholder="To'lov miqdori" disabled>
											</div>
											<div class="col-5">
												<label class="container-checkbox">to'landi
												  	<input type="checkbox" required class="check-paid">
												  	<span class="checkmark"></span>
												</label>
											</div>
										</div>

									</div>

									<div class="col-12 text-right">
										<button class="btn btn-success submit-button" type="submit">Tasdiqlash</button>
									</div>

								</div>

							</form>

						</div>

					</div>

				</div>



				<!-- MODAL EXAM TYPE -->

				<div class="col-md-6">

					<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

						<div class="modal-dialog">

							<div class="modal-content">

								<div class="modal-header">

									<h5 class="modal-title" id="example-Modal3">{{ trans('app.Imtihon turini qo\'shish')}}</h5>

									<button type="button" class="close" data-dismiss="modal" aria-label="Close">

										<span aria-hidden="true">&times;</span>

									</button>

								</div>

								<div class="modal-body">

								    <form class="form-horizontal formaction" action="" method="">

										<table class="table card-table table-vcenter text-nowrap exam_type_class"  align="center">

											<thead>

												<tr>

													<td class="text-center"><strong>{{ trans('app.Imtihon turi')}}</strong></td>

													<td class="text-right"><strong>{{ trans('app.Action')}}</strong></td>

												</tr>

											</thead>

											<tbody>

												@if(!empty($examTypes))

													@foreach($examTypes as $type)

														<tr class="">

															<td class="text-center exam-type-name">

																{{$type->name}}

															</td>

															<td class="text-right">

																<button type="button" class="btn btn-info btn-xs examtype_edit" exam-type-id="{{$type->id}}" title="O'zgartirish">

																	<i class="fe fe-edit"></i>

																</button>

															</td>

														</tr>

													@endforeach

												@endif

											</tbody>

										</table>

											<div class="form-group data_popup">

												<label class="form-label">{{ trans('app.Imtihon turi')}}: <span class="text-danger">*</span></label>

											<div class="row">

												<div class="col-10">

													<input type="text" class="form-control exam-type" name="exam-type" id="exam-type" placeholder="{{ trans('app.Imtihon turini kiriting')}}" required />

												</div>

												<div class="col-2 data_popup">																	

													<button type="button" class="btn btn-success examtype_add" 

													url="" >

														{{ trans('app.Qo\'shish')}}

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



<script type="text/javascript">

	$(document).ready(function(){

		$("input[name='retest']").on('change', function(){
			var data = $(this).is(':checked');
			var type = $("select[name='type']").val();
			if(data){
				
				@foreach($payment_r as $payment)
					if(type == {{ $payment->key_payment }}){
						var payment_r = {{ intval($payment->payment) }};
					}
				@endforeach
				var payment = {{ intval($min->payment) }}*(payment_r/100);
			}else{
				@foreach($payment_n as $payment)
					if(type == {{ $payment->key_payment }}){
						var payment_r = {{ intval($payment->payment) }};
					}
				@endforeach
				var payment = {{intval($min->payment) }}*(payment_r/100);
			}
			$("input[name='payment']").val(parseInt(payment));
		});
		$("select[name='type']").on('change', function(){
			var type = $(this).val();
			var data = $("input[type='checkbox']").is(':checked');
			if(data){
				
				@foreach($payment_r as $payment)
					if(type == {{ $payment->key_payment }}){
						var payment_r = {{ intval($payment->payment) }};
					}
				@endforeach
				var payment = {{ intval($min->payment) }}*(payment_r/100);
			}else{
				@foreach($payment_n as $payment)
					if(type == {{ $payment->key_payment }}){
						var payment_r = {{ intval($payment->payment) }};
					}
				@endforeach
				var payment = {{ intval($min->payment) }}*(payment_r/100);
			}
			$("input[name='payment']").val(parseInt(payment));
		})

		$('select.select-customer').select2({

			ajax:{

				url:'/customer/search',

				delay:300,

				dataType:'json',

				data:function(params){

					return{

						search:params.term,

						type:'physical'

					}

				},

				processResults:function(data){

					console.log(data);

					data=data.map((item,index)=>{
						return {
							id:item.id,
							text:capitalize((item.lastname?item.lastname+' ':'')+item.name+(item.middlename?' '+item.middlename:'')),
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



		$('select.select-type').select2({

    		

			minimumResultsForSearch:Infinity,

			placeholder:'Imtihon turini tanlang'

		});

		$('#driver-exam-form').one('submit',function(){
			var submitButton=$(this).find('button.submit-button');

			submitButton.addClass('btn-loading');
			var disabled=$(this).find(':input:disabled').removeAttr('disabled');
			var formArray=$(this).serializeArray();
			disabled.attr('disabled','disabled');

			$.ajax({

				url:'/driver-exam/store',

				type:'POST',

				data:formArray,

				success:function(data){

					submitButton.removeClass('btn-loading').attr('disabled','disabled');

					if(data=='success'){

						swal({title:'Saqlandi!',
							  text:'',
							  type:'success',
							  confirmButtonText: "Davom etish"
							}).then((isConfirm) =>{
								window.location.pathname = "/driver-exam/list";
							});

					}else{

						swal('Xatolik!','','error');

					}

				}

			});

		});



		$('.examtype_add').click(function(){

			var examType= $('input#exam-type').val();

	        if(examType == ""){

	            swal('Imtihon turi nomini kiriting!');

	        }else{ 

				$.ajax({

					type:'POST',

					url:'/driver-exam/add-exam-type',

				    data :{

				    	_token:$('input[name="_token"]').val(),

				    	examType:examType

				    },

				    success:function(data){

					    var newd = $.trim(data);

					    if (newd == '01'){

						    swal("Bu nomdagi imtihon turi allaqachon mavjud! Iltimos, boshqa nom kiritib ko'ring");

					    }

					    else{

					    	var classname = 'del-'+newd;

					   		$('.exam_type_class').append('<tr class="'+classname+'"><td class="text-center exam-type-name">'+examType+'</td><td class="text-right"><button type="button" exam-type-id='+newd+' class="btn btn-info btn-xs examtype_edit" title="O\'zgartirish"><i class="fe fe-trash-2"></i></button></a></td><tr>');

							$('select.select-type').append('<option value='+newd+'>'+examType+'</option>');

							$('input#exam-type').val('');



							$('.examtype_edit').on('click',function(e){

								e.stopImmediatePropagation();

								editExamType($(this));

							});

					    } 

				    }, 

			 	});

			}

		});



		$('.examtype_edit').on('click',function(e){

			e.stopImmediatePropagation();

			editExamType($(this));

		});



		function editExamType(th){

			var examTypeId = th.attr('exam-type-id');

			var row=th.closest('tr');

			var examTypeName=row.find('.exam-type-name');



			if(th.is('.exam-type-save')){

				console.log('exam-type save clicked');

				th.removeClass('exam-type-save');

				var data={

					_token:$('input[name="_token"]').val(),

					examTypeId,

					name:examTypeName.find('input').val(),

				}

				$.ajax({

					url:'/driver-exam/edit-exam-type',

					type:'POST',

					data:data,

					success:function(data){

						console.log(data);

						examTypeName.html(examTypeName.find('input').val());

						th.html('<i class="fa fa-pencil"></i>');

					},

					error:function(err){

						console.log('error',err);

						swal('Xatolik','','error');

					}

				});

			}else{

				examTypeName.html('<input class="form-control" value="'+examTypeName.text().trim()+'" />');

				th.html('Saqlash');

				th.addClass('exam-type-save');

			}

		}

	});

</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>

    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/bootstrap-datetimepicker.min.js') }}"></script>

	

<script type="text/javascript">
	$('input.given-date').datetimepicker({

		format:'dd-mm-yyyy',

		autoclose:1,

		minView:2,

		startView:'month',

		endDate: new Date()

	});

 </script>

@endsection
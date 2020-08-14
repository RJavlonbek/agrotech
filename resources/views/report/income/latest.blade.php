@extends('layouts.app')
@section('content')

<!-- page content -->
<?php $userid = Auth::user()->id; ?>
<style>

</style>

		@if (CheckAccessUser('report_pay', $userid, 'read')=='yes')

		    <div class="section">

				@if(session('message'))

					<div class="row massage">

						<div class="col-md-12 col-sm-12 col-xs-12">

							<div class="alert alert-success text-center">

			                 @if(session('message') == 'Successfully Submitted')

								<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>

							   @elseif(session('message')=='Successfully Updated')

							   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>

							   @elseif(session('message')=='Successfully Deleted')

							   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>

						    @endif

			                </div>

						</div>

					</div>

				@endif

				<!-- PAGE-HEADER END -->

				<div class="row">

					<div class="col-md-12">
					
						<div class="card">									

							<div class="card-body">
							<form>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="form-label">
												Viloyat
											</label>
											<select name="state" class="form-control state">
												@if(!empty($states))
													<option value="">asd</option>
													<option value="all"
														@if(!empty($state) && $state=='all')
															selected="selected"
														@endif
													>
														Respublika bo'yicha
													</option>

													@foreach($states as $st)
														<option value="{{$st->id}}"
															@if(!empty($state) && $state==$st->id)
																selected="selected"
															@endif
														>
															{{ $st->name }}
														</option>
													@endforeach
												@elseif(!empty($state))
													<option value="{{$state}}">{{ getStateName($state) }}</option>
												@endif
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group city-field">
											<label class="form-label">
												Tuman
											</label>
											<select type="" name="city" class="form-control city" val="{{$city}}">
												<option value="">asd</option>
												@if(!empty($cities))
													@if(!($currentPosition=='district'))
														<option value="all"
															@if(!empty($city) && $city=='all')
																selected="selected"
															@endif
														>
															Viloyat bo'yicha
														</option>
													@endif
													@foreach($cities as $ci)
														<option value="{{$ci->id}}"
															@if(!empty($city) && $city==$ci->id)
																selected="selected"
															@endif
														>
															{{ $ci->name }}
														</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group user-field">
											<label class="form-label">
												Inspektor
											</label>
											<select type="" name="user" class="form-control user" val="{{$user}}">
												@if($currentPosition=='district')
													<option value="{{ $currentUser->id }}">{{ $currentUser->name.' '.$currentUser->lastname }}</option>
												@endif
											</select>
										</div>
									</div>
								</div>

								<div id="list-date-filter">

									<div class="{{($from && $till) ? 'open':''}}" style="display: inline-block;">

											<input class="form-control fc-datepicker from" name="from" placeholder="dd-mm-yyyy" autocomplete="off" required="required" 

												@if(!empty($from))

													value="{{$from}}"

												@endif

											/> dan

											<input class="form-control fc-datepicker till" name="till" placeholder="dd-mm-yyyy" autocomplete="off" required="required" 

												@if(!empty($till))

													value="{{$till}}"

												@endif

											/> gacha



											{{-- @if($from && $till)
												<button type="button" class="btn btn-primary" id="cancel-date-filter">Filtrni bekor qilish</button>
											@else --}}

												<button type='submit' class="btn btn-primary" style="margin-right: 10px;">Filtrlash</button>

											{{-- @endif --}}


									</div>

									<div class="float-right-buttons">

										<div class="print-table-button btn btn-primary float-right" table='datatable-1'><i class='fa fa-print'></i> Chop etish</div>

										<div class="export-excel-button btn btn-primary  mr-2 float-right" table='datatable-1' filename="So'nggi amalga oshirilgan to'lovlar"><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>

									</div>

								</div>
							</form>

								<div class="table-responsive">
										<table id="datatable-1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

											<thead>

												<tr>
													<th>№</th>
													<th>To'lov turi</th>
													<th>Texnika</th>
													<th>Egasi</th>
													<th>Inspektor</th>
													<th>Tuman</th>
													<th>Sana</th>
													<th>To'lov miqdori</th>
												</tr>

											</thead>

											<tbody>
												@if(!empty($payments))
													<?php $i=0;
														$totalAmount=0; ?>
													@foreach($payments as $payment)
														<?php $i++;
															$amount=isset($payment->total_amount) ? $payment->total_amount : (isset($payment->payment) ? $payment->payment : 0);
															$totalAmount+=$amount ?>
														<tr>
															<td>{{$i}}</td>
															<td>
																@if(!empty($payment->link))
																	<a href="{{$payment->link}}" target="_blink">{{$payment->payment_type}}</a>
																@else
																	{{$payment->payment_type}}
																@endif
															</td>
															<td>
																@if(isset($payment->vehicle))
																	<a href="/vehicle/list/view/{{$payment->vehicle_id}}/{{$payment->customer_city_id}}" target="_blink">{{$payment->vehicle}}</a>
																@else
																	-
																@endif
															</td>
															<td>
																<a href="/customer/list/{{$payment->owner_id}}" target="_blink" class="text-capitalize">
																	{{$payment->owner_lastname.' '.$payment->owner_name.' '.$payment->owner_middlename}}
																</a>
															</td>
															<td>{{$payment->user_lastname.' '.$payment->username}}</td>
															<td>{{($payment->state_id && $payment->city_id) ? getStateName($payment->state_id).', '.getCityName($payment->city_id) : "—"}}</td>
															<td>{{date('d.m.Y',strtotime($payment->date))}}</td>
															<td class="text-right amount">{{ $amount }}</td>
														</tr>
													@endforeach
													<tr>
														<td>{{++$i}}</td>
														<td class="font-weight-bold">Jami</td>
														<td class="font-weight-bold text-right amount">{{$totalAmount}}</td>
														<td colspan="4"></td>
													</tr>
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

			<div class="right_col" role="main">

				<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">

		            <div class="nav toggle" style="padding-bottom:16px;">

		               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.') }}</span>

		            </div>

		        </div>

			</div>

		@endif    

        <!-- /page content -->

        <script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>

<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>

	$(document).ready(function(){

		$('#datatable-1_length label').css('visibility','hidden');

		$('.state').select2({
			placeholder: "Viloyatni tanlang",
			minimumResultsForSearch: Infinity
		});

		$('.city').select2({
			placeholder: "Tuman/shaharni tanlang tanlang",
			minimumResultsForSearch: Infinity
		});

		$('select.user').select2({
			placeholder: "Xodimni tanlang",
			minimumResultsForSearch: Infinity
		});

		if(!$('select.state').val()){
			$('.user-field, .city-field').hide();
		}

		$('select.state').on('change',function(){
			$('.user-field, .city-field').fadeIn('500');
			getCitiesOfState($(this));
		});

		$('select.city').on('change',function(){
			getUsers();
		});

		//getCitiesOfState($('select.state'));

		if($('select.city').val() || $('select.state').val()){
			getUsers();
		}

		function getCitiesOfState(th){
			stateid = th.val();
			if(stateid){
				$.ajax({

					type:'GET',

					url: '/getcityfromstate',

					data:{ 

						stateid:stateid
					},

					success:function(response){

						var citiesMenu=$('select.city')

						var customerCity=citiesMenu.attr('val');

						citiesMenu.html("<option value>option<option>"+response);

						if(customerCity){

							citiesMenu.find('option[value="'+customerCity+'"]').attr('selected','selected');

						}

						getUsers();

					}

				});
			}
		}

		function getUsers(){
			var usersMenu=$('select.user')
			usersMenu.attr('disabled','disabled');
			var stateId=$('select.state').val();
			var cityId=$('select.city').val();

			$.ajax({
				type:'GET',
				url: '/user/get',
				data:{
					stateId,
					cityId
				},
				success:function(response){
					
					var chosen=usersMenu.attr('val');
					usersMenu.removeAttr('val');
					usersMenu.html("<option value>option<option>"+response);
					if(chosen){
						usersMenu.find('option[value="'+chosen+'"]').attr('selected','selected');
					}
					usersMenu.removeAttr('disabled');
				}
			});
		}

		$('#datatable').DataTable( {

			responsive: true,

			sorting: false,

	        "language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); ?>.json"
	        }
	    });

		$('body').on('click', '.deletecustomers', function() {

		  var url =$(this).attr('url');

	        swal({   

	            title: "Are You Sure?",

				text: "You will not be able to recover this data afterwards!",   

	            type: "warning",   

	            showCancelButton: true,   

	            confirmButtonColor: "#297FCA",   

	            confirmButtonText: "Yes, delete!",   

	            closeOnConfirm: false 

	        }, function(){

				window.location.href = url;



	        });
	    }); 

  	}); 



</script>

@endsection
@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (CheckAdmin($userid)=='yes')	
   <div class="section">
		<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Employee')}}
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
										<a href="{!! url('/employee/list')!!}">
											<span class="visible-xs"></span>
											<i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Ro\'yxat')}}
										</a>
									</li>
									<li class="active">
										<span class="visible-xs"></span>
										<i class="fa fa-plus-circle fa-lg">&nbsp;</i> 
										<b>{{ trans('app.Qo\'shish')}}</b>
									</li>
								</ul>
							</div>
						</div>
						<form method="post" action="{!! url('employee/store') !!}" enctype="multipart/form-data"  class="form-horizontal upperform">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<h4><b>{{ trans('app.Personal Information')}}</b></h4>
									<p class="col-md-12 col-sm-12 ln_solid"></p>
								</div>
								<div class="col-md-6 form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
									<label class="form-label" for="first-name">
										{{ trans('app.First Name')}} <label class="text-danger">*</label>
									</label>
									<div class="">
								  		<input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"  placeholder="{{
								  		trans('app.Enter First Name')}}" class="form-control" maxlength="25" required>
										@if ($errors->has('firstname'))
								   			<span class="help-block">
									 			<strong>Ism noto'g'ti shaklda kiritilgan</strong>
								  			 </span>
							 		    @endif
									</div>
								</div>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
						   		<div class="col-md-6 form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
									<label class="form-label" for="last-name">
										{{ trans('app.Last Name')}} <label class="text-danger">*</label> 
									</label>
									<div class="">
								  	<input type="text" id="lastname" name="lastname"  value="{{ old('lastname') }}" placeholder="{{ trans('app.Enter Last Name')}}" class="form-control" maxlength="25" required>
										@if ($errors->has('lastname'))
										   <span class="help-block">
											 <strong>Familiya noto'g'ti shaklda kiritilgan</strong>
										   </span>
										 @endif
									</div>
								</div>
							   	<div class="col-md-6 form-group has-feedback {{ $errors->has('displayname') ? ' has-error' : '' }}">
									<label for="middle-name" class="form-label">{{ trans('app.Display Name')}} <label class="text-danger">*</label></label>
									<div class="">
										<input type="text" id="displayname" class="form-control" value="{{ old('displayname') }}" placeholder="{{ trans('app.Enter Display Name')}}" maxlength="25"  name="displayname">
										@if ($errors->has('displayname'))
										   <span class="help-block">
											 <strong>Otasining ismi noto'g'ti shaklda kiritilgan</strong>
										   </span>
										 @endif
									</div>
								</div>
								<div class="col-md-3 form-group has-feedback">
									<label class="form-label">{{ trans('app.Gender')}} <label class="text-danger">*</label></label>
									<div class=" gender">
										<label class="custom-control custom-radio">
											<input type="radio" class="custom-control-input"  name="gender" value="1" checked required checked>
											<span class="custom-control-label">{{ trans('app.Male')}} </span>
										</label>
										 <label class="custom-control custom-radio">
											<input type="radio"  class="custom-control-input" name="gender" value="2" required>
											<span class="custom-control-label">{{ trans('app.Female')}} </span>
										</label>
									</div>
								</div> 
								<div class="col-md-3 form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
									<label class="form-label">{{ trans('app.Date Of Birth')}} <label class="text-danger">*</label></label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
												</div>
											</div>
											<input type="text" id="date_of_birth" class="form-control dob" placeholder="<?php echo getDatepicker();?>" name="dob" value="{{ old('dob') }}" onkeypress="return false;" required />
												@if(!empty($customer))
													value="{{$customer->d_o_birth}}"
												@endif
										</div>
									@if ($errors->has('dob'))
										<span class="help-block">
											<strong style="margin-left:27%;">Tug'ilgan sana noto'g'ti shaklda kiritilgan</strong>
										</span>
									@endif
								</div>
								<div class="col-md-4 form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
									<label class="form-label" for="Password">{{ trans('app.Password')}} <label class="text-danger">*</label></label>
									<div class="">
										<input type="password" id="password" placeholder="{{ trans('app.Enter Password')}}" name="password"  class="form-control" maxlength="20" autocomplete="new-password" required>
										@if ($errors->has('password'))
										<span class="help-block">
											<strong>Parol noto'g'ti shaklda kiritilgan</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-md-4 form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
									<label class="form-label currency" style="padding-right: 0px;"for="Password">{{ trans('app.Confirm Password') }} <label class="text-danger">*</label></label>
									<div class="">
										<input type="password"  name="password_confirmation" placeholder="{{ trans('app.Enter Confirm Password')}}" class="form-control" maxlength="20" title='' required>
										@if ($errors->has('password_confirmation'))
										<span class="help-block">
											<strong>Parol noto'g'ti shaklda kiritilgan</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-md-4 form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
									<label class="form-label" for="mobile">{{ trans('app.Mobile No')}} <label class="text-danger">*</label></label>
									<div class="">
										<input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="{{ trans('app.Enter Mobile No')}}"class="form-control" maxlength="15" required>
										@if ($errors->has('mobile'))
										<span class="help-block">
											<strong>Raqam noto'g'ti shaklda kiritilgan</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-md-6 form-group has-feedback {{ $errors->has('landlineno') ? ' has-error' : '' }}">
									<label class="form-label" for="landline-no">{{ trans('app.Landline No')}} <label class="text-danger">*</label></label>
									<div class="">
										<input type="text" id="landlineno" name="landlineno" value="{{ old('landlineno') }}" placeholder="{{ trans('app.Enter LandLine No')}}" maxlength="15" class="form-control">
										@if ($errors->has('landlineno'))
										<span class="help-block">
											<strong>Raqam noto'g'ti shaklda kiritilgan</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-md-6 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
									<label class="form-label" for="Email">{{ trans('app.Email')}} <label class="text-danger">*</label></label>
									<div class="">
										<input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="{{ trans('app.Enter Email')}}"class="form-control" maxlength="50" required>
										@if ($errors->has('email'))
										<span class="help-block">
											<strong>Email noto'g'ti shaklda kiritilgan</strong>
										</span>
										@endif
									</div>
								</div>  
								<div class="col-md-4 form-group {{ $errors->has('join_date') ? ' has-error' : '' }}">
									<label class="form-label" for="Town/City">{{ trans('app.Join Date')}} <label class="text-danger">*</label></label>
									<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
												</div>
											</div>

										<input type="text" id="join_date" class="form-control joindate" placeholder="<?php echo getDatepicker();?>" value="{{ old('join_date') }}"  name="join_date" readonly required />
									</div>
										@if ($errors->has('join_date'))
										<span class="help-block">
											<strong>Parol noto'g'ti shaklda kiritilgan</strong>
										</span>
										@endif
								</div>								
								<div class="col-md-4 form-group has-feedback">
									<label class="form-label" for="image">{{ trans('app.Designation')}} <label class="text-danger">*</label></label>
									<div class="">
										<select class="role_search" name="role">
											@if(!empty($roles))
												@foreach($roles as $role)
													<option value="{{$role->id}}">{{$role->name}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>	
								<div class="col-md-4 col-sm-6 form-group">
									<label class="form-label">Inspeksiyaning bo'limi nomi</label>
									<input type="text" name="branchName" class="form-control" placeholder="m-n: Zarbdor tuman agro inspeksiya" value="{{ old('branchName') }}">
								</div>

								<div class="col-md-6 form-group {{ $errors->has('left_date') ? ' has-error' : '' }}">
									<label class="form-label" for="image">{{ trans('app.Left Date')}}</label>
									<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
												</div>
											</div>

										<input type="text" id="left_date" class="form-control leftdate" placeholder="<?php echo getDatepicker();?>"  name="left_date" value="{{ old('left_date') }}" readonly >
									</div>

									@if ($errors->has('left_date'))
										<span class="help-block" style="margin-left: 27%;">
											<strong>{{ $errors->first('left_date') }}</strong>
										</span>
										@endif
								</div>
								<div class="col-md-6 form-group has-feedback {{ $errors->has('image') ? ' has-error' : '' }}">
									<label class="form-label" for="image">{{ trans('app.Image')}}</label>
									<input type="file" id="image" name="image" style="display: none;">
									<div class="row">
										<div class="col-4">
										   	<input type="button" name="fake-image" class="btn btn-primary" value="Rasm yuklash" style="width: 100%; height: 2.375rem">
										</div>
										<div class="col-8">
										  	<textarea disabled name="file-name" style="width: 100%; height: 2.375rem; background-color: #f1f2fd"></textarea>
										</div>
									</div>
									  @if ($errors->has('image'))
											<span class="help-block">
												<strong>Xatolik</strong>
											</span>
										@endif
								</div>
								<div class="col-md-12 col-sm-12 space">
									<h4><b>{{ trans('app.Address')}}</b></h4>
									<p class="colo-md-12 col-sm-12 ln_solid"></p>
								</div>
								<div class="col-md-6 form-group has-feedback">
									<label class="form-label" for="State ">{{ trans('app.State')}} </label>
									<div class="">
										<select required class="form-control state_of_country" name="state[]" multiple="multiple" stateurl="{!! url('/getcityfromstate') !!}">
											@if(!empty($states))
												@foreach($states as $state)
													<option value="{{$state->id}}">{{$state->name}}</option>
												@endforeach
											@endif
										</select>

									</div>
								</div>
								<div class="col-md-6 form-group has-feedback city-select">
									<label class="form-label" for="Town/City">{{ trans('app.Town/City')}}</label>
									<div class="">
										<select class="form-control city_of_state" multiple="multiple" required  name="city[]">
										</select>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 form-group has-feedback">
									<label class="form-label" for="Address">{{ trans('app.Address')}} <label class="text-danger">*</label></label>
									<div class="">
										<textarea id="address" name="address" class="form-control" maxlength="100"  required>{{ old('address')}}</textarea>
									</div>
								</div>
								<div class="form-group col-md-12 col-sm-12">
									<div class="col-md-12 col-sm-12 text-center">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
									</div>
								</div>
							</div>
						</form>
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
	<script type="text/javascript">
		$(document).ready(function(){
			$('input[name="password_confirmation"]').change(function(){
				if($('input[name="password_confirmation"]').val() != $('input[name="password"]').val()){
					swal({
							title: "Parol noto'g'ri kiritilgan",
				            type: "warning",
				            text: "Tasdiqlovchi parol kiritilgan parolga mos kelmadi",
				            confirmButtonColor: "#DD6B55",
				            confirmButtonText: "Qaytadan tasdiqlash",
				            closeOnConfirm: true
						}).then((isConfirm) => {								
								$('input[name="password_confirmation"]').val('').focus().title('');						
						})
				}
			});
			$('select[name="role"]').change(function(){
				var position = $(this).val();
				$.ajax({
					type: 'GET',
					url: '/setting/getrole',
					data: 'position='+position,
					success: function(data){
						if (data == 'country') {
							$('select[name="state[]"]').attr("multiple", "multiple");
							$('select[name="city[]"]').removeAttr("multiple");
							$('select[name="city[]"]').removeAttr('multiple');
						}else if(data == 'district'){
							$('select[name="city[]"]').attr("multiple", "multiple");
							$('select[name="state[]"]').removeAttr('multiple');
						}else if(data == 'region'){
							$('select[name="city[]"]').removeAttr("multiple");
							$('select[name="state[]"]').removeAttr('multiple');
						}

					}
				});
				

			});
			$('select.role_search').select2({
	    		language:{
					inputTooShort:function(){
						return 'Lavozim bn izlang';
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
				placeholder: "Lavozim turini tanlang"
		    });
		});
	    $("input.dob").datetimepicker({
			format: "dd-mm-yyyy",
			autoclose: 1,
			minView: 2,
			startView:'decade',
			endDate: new Date(),
		});
		 $("input.leftdate").datetimepicker({
			format: "dd-mm-yyyy",
			autoclose: 1,
			minView: 2,
			startView:'decade',
			endDate: new Date(),
		});
		  $("input.joindate").datetimepicker({
			format: "dd-mm-yyyy",
			autoclose: 1,
			minView: 2,
			startView:'decade',
			endDate: new Date(),
		});
	</script>
	<script>
	$(document).ready(function(){
	$('input[name="fake-image"]').on('click', function(){
		$('input[name="image"]').click();
	});
	$('input[name="image"]').on('change',function(){		
		$('textarea[name="file-name"]').text($('input[name="image"]').val());
	});
	$('select.state_of_country').select2({
		placeholder: 'Viloyatni tanlang',
		minimumResultsForSearch: Infinity,
		language:{
			inputTooShort:function(){
				return 'Tuman yoki shahar nomini kiritib izlang';
			},
			searching:function(){
				return 'Izlanmoqda...';
			},
			noResults:function(){
				return "Natija topilmadi"
			}
		}
	});
	$('select.city_of_state').select2({
		placeholder: 'Tuman / shaharni tanlang',
		minimumResultsForSearch: Infinity,
		language:{
			inputTooShort:function(){
				return 'Tuman yoki shahar nomini kiritib izlang';
			},
			searching:function(){
				return 'Izlanmoqda...';
			},
			noResults:function(){
				return "Natija topilmadi"
			}
		}
	});

	$('body').on('change','.state_of_country',function(){
		stateid = $(this).val();

		var url = $(this).attr('stateurl');
		$.ajax({
			type:'GET',
			url: url,
			data:{ stateid:stateid },
			success:function(response){
				$('.city_of_state').html(response);
			}
		});
	});
});
</script>
<script>
	$(document).ready(function(){

	$('.datepicker1').datetimepicker({
        format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
		endDate: new Date(),
    });



		$(".datepicker,.input-group-addon").click(function(){	
		var dateend = $('#left_date').val('');

		});

		$(".datepicker").datetimepicker({
			format: "<?php echo getDatepicker(); ?>",
			 minView: 2,
			autoclose: 1,
		}).on('changeDate', function (selected) {
			var startDate = new Date(selected.date.valueOf());

			$('.datepicker2').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,

			}).datetimepicker('setStartDate', startDate); 
		})
		.on('clearDate', function (selected) {
			 $('.datepicker2').datetimepicker('setStartDate', null);
		})

			$('.datepicker2').click(function(){

			var date = $('#join_date').val(); 
			if(date == '')
			{
				swal('First Select Join Date');
			}
			else{
				$('.datepicker2').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
				})

			}
			});
		});	

</script>

  <!--
  left_date
  join_date
  -->
  @endsection
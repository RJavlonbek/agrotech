@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (CheckAdmin($userid)=='yes' || $userid == $user->id)
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
											<i class="fa fa-edit fa-lg">&nbsp;</i> 
											<b>{{ trans('app.Tahrirlash')}}</b>
										</li>
									</ul>
								</div>
							</div>	
							<form method="post" action="update/{{ $user->id }}" enctype="multipart/form-data" class="form-horizontal upperform">
								<div class="row">
									{!! method_field('patch') !!}
									<div class="col-md-12 col-sm-12 space">
										<h4><b>{{ trans('app.Personal Information')}}</b></h4>
										<p class="col-md-12 col-sm-12 ln_solid"></p>
									</div>  
									<div class="col-md-6 col-sm-6 form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
										<label class="form-label" for="first-name">{{ trans('app.First Name')}} <label class="text-danger">*</label></label>
										<div>
											<input type="text" id="firstname" name="firstname" placeholder="{{ trans('app.Enter First Name')}}" class="form-control" value="{{ $user->name }}" maxlength="25" required>
											@if ($errors->has('firstname'))
											<span class="help-block">
												<strong>{{ $errors->first('firstname') }}</strong>
											</span>
											@endif
										</div>
									</div>
									<div class="col-md-6 col-sm-6 form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
										<label class="form-label" for="last-name">{{ trans('app.Last Name')}} <label class="text-danger">*</label></label>
										<div>
										  <input type="text" id="lastname" name="lastname" placeholder="{{ trans('app.Enter Last Name')}}" class="form-control" value="{{ $user->lastname }}" maxlength="25">
										   @if ($errors->has('lastname'))
											   <span class="help-block">
												 <strong>{{ $errors->first('lastname') }}</strong>
											   </span>
											 @endif
										</div>
									</div>
								
								  
									<div class="col-md-6 col-sm-6 form-group has-feedback {{ $errors->has('displayname') ? ' has-error' : '' }}">
										<label for="middle-name" class="form-label">{{ trans('app.Display Name')}} <label class="text-danger">*</label></label>
										<div>
											<input type="text" id="displayname" class="form-control" placeholder="{{ trans('app.Enter Display Name')}}" name="displayname" value="{{ $user->display_name }}" maxlength="25">
											@if ($errors->has('displayname'))
											<span class="help-block">
												<strong>{{ $errors->first('displayname') }}</strong>
											</span>
											@endif
										</div>
									</div>
									<div class="col-md-3 col-sm-3 form-group has-feedback">
										<label class="form-label">{{ trans('app.Gender')}} <label class="text-danger">*</label></label>
										<div class="gender">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input"  name="gender" value="1" <?php if($user->gender ==1) { echo "checked"; }?> required><span class="custom-control-label">{{ trans('app.Male')}} </span>
											</label>
											<label class="custom-control custom-radio">
												<input type="radio"  class="custom-control-input" name="gender" value="2" <?php if($user->gender ==2) { echo "checked"; }?> required><span class="custom-control-label">{{ trans('app.Female')}} </span>
											</label>
										</div>
									</div>
								
								  
									<div class="col-md-3 col-sm-3 form-group  {{ $errors->has('dob') ? ' has-error' : '' }}">
										<label class="form-label">{{ trans('app.Date Of Birth')}} <label class="text-danger">*</label></label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
												</div>
											</div>
											<input type="text" id="datepicker" class="form-control dob" placeholder="<?php echo getDateFormat();?>" name="dob" value="{{ date(getDateFormat(),strtotime($user->birth_date)) }}"  onkeypress="return false;" required />
										</div>
										@if ($errors->has('dob'))
												<span class="help-block">
													<strong style="margin-left:27%;">{{ $errors->first('dob') }}</strong>
												</span>
											@endif
									</div>
								
								  
									<div class="col-md-4 col-sm-4 form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
										<label class="form-label" for="Password">{{ trans('app.Password')}} </label>
										<div>
											<input type="password" id="password" name="password" placeholder="{{ trans('app.Enter Password')}}" maxlength="20" class="form-control" >
											@if ($errors->has('password'))
												<span class="help-block">
													<strong>{{ $errors->first('password') }}</strong>
												</span>
											@endif
										</div>
									</div>
									<div class="col-md-4 col-sm-4 form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
										<label class="form-label currency" style="padding-right: 0px;"for="Password">{{ trans('app.Confirm Password') }}</label>
										<div>
											<input type="password"  name="password_confirmation" placeholder="{{ trans('app.Enter Confirm Password')}}" class="form-control" maxlength="20">
											@if ($errors->has('password_confirmation'))
											<span class="help-block">
												<strong>{{ $errors->first('password_confirmation') }}</strong>
											</span>
											@endif
										</div>
									</div>
								
								  
									<div class="col-md-4 col-sm-4 form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
										<label class="form-label" for="mobile">{{ trans('app.Mobile No')}} <label class="text-danger">*</label></label>
										<div>
											<input type="text" id="mobile" name="mobile" placeholder="{{ trans('app.Enter Mobile No')}}" class="form-control" value="{{ $user->mobile_no }}" maxlength="15" required>
											@if ($errors->has('mobile'))
											<span class="help-block">
												<strong>{{ $errors->first('mobile') }}</strong>
											</span>
											@endif
										</div>
									</div>

									<div class="col-md-6 col-sm-6 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }} ">
										<label class="form-label" for="Email">{{ trans('app.Email')}} <label class="text-danger">*</label></label>
										<div>
										  <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ $user->email }}" maxlength="50" required>
										   @if ($errors->has('email'))
												 <span class="help-block">
												   <strong>{{ $errors->first('email') }}</strong>
												 </span>
											   @endif
										</div>
									</div>
									<div class="col-md-6 col-sm-6 form-group has-feedback {{ $errors->has('landlineno') ? ' has-error' : '' }}">
										<label class="form-label" for="landline-no">{{ trans('app.Landline No')}} <label class="text-danger">*</label></label>
										<div>
										  <input type="text" id="landlineno" name="landlineno" placeholder="{{ trans('app.Enter LandLine No')}}" class="form-control" value="{{ $user->landline_no }}" maxlength="15">
											@if ($errors->has('landlineno'))
												 <span class="help-block">
												   <strong>{{ $errors->first('landlineno') }}</strong>
												 </span>
											   @endif
										</div>
									</div>
								
								  
									<div class="col-md-4 col-sm-6 form-group {{ $errors->has('join_date') ? ' has-error' : '' }}">
										<label class="form-label" for="Town/City">{{ trans('app.Join Date')}} <label class="text-danger">*</label></label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
												</div>
											</div>
											<input type="text" id="join_date" class="form-control joindate" placeholder="<?php echo getDateFormat();?>"  value="{{date(getDateFormat(),strtotime($user->join_date))}}"  name="join_date" required readonly />
											@if ($errors->has('join_date'))
											<span class="help-block">
												<strong>{{ $errors->first('join_date') }}</strong>
											</span>
											@endif
										</div>
									</div>
									<div class="col-md-4 col-sm-6 form-group has-feedback " <?=($userid == $user->id)?"style='display:none'":""; ?> >
										<label class="form-label" for="image">{{ trans('app.Designation')}}</label>
										<div>
											<select class="role_search" name="role">
												@if(!empty($roles))
													@foreach($roles as $role)
														<option <?=($user->role != 'admin' && $user->role == $role->id)?'selected':'';  ?> value="{{$role->id}}">{{$role->name}}</option>
													@endforeach
												@endif
											</select>
											@if ($errors->has('designation'))
											<span class="help-block" style="color:red;">
												<strong>{{ $errors->first('designation') }}</strong>
											</span>
											@endif
										</div>
									</div>
									<div class="col-md-4 col-sm-6 form-group">
										<label class="form-label">Inspeksiyaning bo'limi nomi</label>
										<input type="text" name="branchName" class="form-control" placeholder="m-n: Zarbdor tuman agro inspeksiya" value="{{ $user->branch_name }}">
									</div>
								
								  	
									<div class="col-md-6 col-sm-6 form-group {{ $errors->has('left_date') ? ' has-error' : '' }}">
										<label class="form-label" for="image">{{ trans('app.Left Date')}} 
										</label>
									    <div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
												</div>
											</div>
											<?php 
												if($user->left_date =='0000-00-00')
												{
													$leftdate=getDatepicker();
												}
												else
												{
													$leftdate=date(getDateFormat(),strtotime($user->left_date));
												}
											?>
										   <input type="text" id="left_date" class="form-control leftdate" placeholder="<?php echo getDateFormat();?>" 
										   value="{{ $leftdate }}"  name="left_date" readonly />
										   
										</div>
										@if ($errors->has('left_date'))
											<span class="help-block" style="margin-left: 27%;">
												<strong>{{ $errors->first('left_date') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-md-6 col-sm-6 form-group has-feedback {{ $errors->has('image') ? ' has-error' : '' }}">
										<label class="form-label" for="image">{{ trans('app.Image')}}</label>
										<div>
										  <input type="file" id="image" name="image" value="{{$user->image}}"  class="form-control" style="display: none;">
										  <div class="row">
											<div class="col-4">
											   	<input type="button" name="fake-image" class="btn btn-primary" value="Rasm yuklash" style="width: 100%; height: 2.375rem">
											</div>
											<div class="col-8">
											  	<textarea disabled name="file-name" style="width: 100%; height: 2.375rem; background-color: #f1f2fd"></textarea>
											</div>
										</div>
										 <img src="{{ URL::asset('public/employee/'.$user->image) }}"  width="40px" height="40px" class="img-circle" style="margin-top:10px;">
										 @if ($errors->has('image'))
											<span class="help-block">
												<strong>{{ $errors->first('image') }}</strong>
											</span>
										@endif
										</div>
									</div>
								
									<div class="col-md-12 col-sm-12 space">
										<h4><b>{{ trans('app.Address')}}</b></h4>
										<p class="col-md-12 col-sm-12 ln_solid"></p>
									</div>
									<div class="col-md-6 col-sm-6 form-group has-feedback" <?=($userid == $user->id)?"style='display:none'":""; ?>>
										<label class="form-label" for="State ">{{ trans('app.State')}} </label>
											<select class="form-control state_of_country" name="state[]" stateurl="{!! url('/getcityfromstate') !!}" multiple="multiple" >
												@if(!empty($state))
													@foreach ($state as $states)
														<option value="{!! $states->id !!}" <?=($user->state_id == $states->id)?'selected':'' ?> >{!! $states->name !!}
														</option>
													@endforeach
												@endif
										
											</select>
									</div>
									<div class="col-md-6 col-sm-6 form-group has-feedback" <?=($userid == $user->id)?"style='display:none'":""; ?>>
										<label class="form-label" for="Town/City">{{ trans('app.Town/City')}}</label>
										<div>
											<select class="form-control city_of_state" name="city[]" multiple="multiple">
												<option value=""></option>
												@if(!empty($cities))
													@foreach ($cities as $citys)
															<option value="{!! $citys->id !!}" <?=($user->city_id == $citys->id)?'selected':'' ?>  >{!! $citys->name !!}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
									<div class="col-12 form-group has-feedback">
										 <label class="form-label" for="Address">{{ trans('app.Address')}} <label class="text-danger">*</label></label>
										<div>
										  <textarea  id="address" name="address" class="form-control" maxlength="100" required>{{ $user->address }}</textarea>
										</div>
									</div>
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="form-group col-md-12 col-sm-12">
										<div class="col-md-12 col-sm-12 text-center">
											<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
											<button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
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
@else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
            <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
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
$(document).ready(function(){
	$('select[name="role"]').change(function(){
				var position = $(this).val();
				$.ajax({
					type: 'GET',
					url: '/setting/getrole',
					data: 'position='+position,
					success: function(data){
						if (data == 'country') {
							$('select[name="state[]"]').attr("multiple", "multiple");
							$('.city-select').hide();
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
	
	$('input[name="fake-image"]').on('click', function(){
		$('input[name="image"]').click();
	});
	$('input[name="image"]').on('change',function(){		
		$('textarea[name="file-name"]').text($('input[name="image"]').val());
	});
	
	$('.select_country').change(function(){
		countryid = $(this).val();
		var url = $(this).attr('countryurl');
		$.ajax({
			type:'GET',
			url: url,
			data:{ countryid:countryid },
			success:function(response){
				$('.state_of_country').html(response);
			}
		});
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
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
</script>

@endsection
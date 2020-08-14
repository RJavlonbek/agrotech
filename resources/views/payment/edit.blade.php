@extends('layouts.app')
@section('content')
<style>
.checkbox-success{
	background-color: #cad0cc!important;
	 color:red;
}
</style>
<?php $userid = Auth::user()->id; ?>
@if (CheckAdmin($userid)=='yes')
	
	<div class="section">
				<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ $title }}
						</li>
					</ol>
				</div>
			<div class="clearfix"></div>
			 @if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-success danger text-center">
						 
						  <label for="checkbox-10 colo_success"> {{ trans('app.Duplicate Data')}} </label>
						</div>
					</div>
				</div>
			@endif
				<div class="row">
						<div class="col-md-12">
							<div class="card">									
								<div class="card-body">
									<div class="panel panel-primary">
										<div class="tab_wrapper page-tab">
											<ul class="tab_list">
												<li>
													<a href="{!! url('/payment/list')!!}">
													<span class="visible-xs"></span>
													<i class="fa fa-list fa-lg">&nbsp;</i> 
													 {{ trans("app.Ro'yxat")}}
												</a>
												</li>
												<li class="active">
													<a href="{!! url('/payment/add')!!}">
													<span class="visible-xs"></span>
													<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
													{{ trans("app.Qo'shish")}}</b>
												</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<form action="update/{{ $payment->id }}" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
												<div class="row">
													@if($payment->category == 'min')
														<input type="hidden" name="category" value="{{ $payment->category }}">
														<div class="col-12 col-md-6">
														  	<div class="form-group">
																<label class="form-label">Eng kam ish xaqi
																</label>
																<input type="text"  required="required" name="payment" placeholder="Eng kam ish xaqi miqdorini kiriting" class="form-control" value="{{ $payment->payment }}" >
														  	</div>
														</div>
														<input type="hidden" name="_token" value="{{csrf_token()}}">
														<div class="col-12 col-md-6">
															<label class="form-label" style="visibility: hidden;">label</label>
														 	<div class="form-group">
																<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
																<button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
														  	</div>
														</div>
													@else
														<div class="col-md-6 self">
															<div class="form-group">
																<label class="form-label">To'lov turi
																	<label class="text-danger">*</label></label>
																<select name="category"  type="text" placeholder="To'lov turini tanlang" class="form-control diller" >
																	<option value disabled selected>To'lov turini tanlang</option>
																	<option <?php if($payment->category=='vehicle_med') echo "selected"; ?> value="vehicle_med">Texnik ko'rik</option>
																	<option <?php if($payment->category=='vehicle_num') echo "selected"; ?> value="vehicle_num">Davlat raqami berish</option>
																	<option <?php if($payment->category=='vehicle_pass') echo "selected"; ?> value="vehicle_pass">Texnik pasport berish</option>
																	<option <?php if($payment->category=='driver_lic') echo "selected"; ?> value="vehicle_lic">Haydovchilik guvohnomasi</option>
																	<option <?php if($payment->category=='vehicle_lic') echo "selected"; ?> value="vehicle_cer">Texnika guvohnomasi</option>
																	<option <?php if($payment->category=='driver_exam') echo "selected"; ?> value="driver_exam">Haydovchi imtihoni</option>
																	<option <?php if($payment->category=='vehicle_reg') echo "selected"; ?> value="vehicle_reg">Ro'yxatga olish</option>
																	<option <?php if($payment->category=='vehicle_out') echo "selected"; ?> value="vehicle_reg">Ro'yxatdan chiqarish</option>
																	<option <?php if($payment->category=='vehicle_tm') echo "selected"; ?> value="vehicle_tm">Tm-1 malumotnoma</option>
																</select>
															</div>
														</div>
														<div class="col-12 col-md-6">
														  	<div class="form-group">
																<label class="form-label">To'lov nomi
																</label>
																<input type="text"  required="required" name="name" placeholder="To'lov nomini kriting" class="form-control"
																	@if(!empty($payment->name))
																		value="{{ $payment->name }}" 
																	@endif
																>
														  	</div>
														</div>
														<div class="col-12 col-md-6">
														  	<div class="form-group">
																<label class="form-label">To'lov miqdori(%)
																</label>
																<input type="text"  required="required" name="payment" placeholder="To'lov miqdorini kriting" class="form-control"
																	@if(!empty($payment->name))
																		value="{{ $payment->payment }}" 
																	@endif
																>
														  	</div>
														</div>
														<input type="hidden" name="_token" value="{{csrf_token()}}">
														<div class="col-12 col-md-6">
															<label class="form-label" style="visibility: hidden;">label</label>
														 	<div class="form-group">
																<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
																<button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
														  	</div>
														</div>
													@endif
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
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}">
</script>

<script>
    $(document).ready(function(){
		$('select.payment').select2({
			placeholder:'To\'lov turini tanlang',
			minimumResultsForSearch: Infinity
		});
	});

</script> 
@endsection
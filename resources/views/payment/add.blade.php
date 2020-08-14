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
											<form action="{{ url('/payment/store') }}" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
												<div class="row">
													<div class="col-md-6 self">
														<div class="form-group">
															<label class="form-label">To'lov turi
																<label class="text-danger">*</label></label>
															<select required name="category"  type="text" placeholder="To'lov turini tanlang" class="form-control payment" >
																<option value disabled selected>To'lov turini tanlang</option>
																<option value="vehicle_med">Texnik ko'rik</option>
																<option value="vehicle_num">Davlat raqami berish</option>
																<option value="vehicle_pass">Texnik pasport berish</option>
																<option value="driver_lic">Haydovchilik guvohnomasi</option>
																<option value="vehicle_cer">Texnika guvohnomasi</option>
																<option value="driver_exam">Haydovchi imtihoni</option>
																<option value="vehicle_reg">Ro'yxatga olish</option>
																<option value="vehicle_out">Ro'yxatdan chiqarish</option>
																<option value="vehicle_tm">Tm-1 malumotnoma</option>
															</select>
														</div>
													</div>
													<div class="col-12 col-md-6">
													  	<div class="form-group">
															<label class="form-label">To'lov nomi
															</label>
															<input type="text"  required="required" name="name" placeholder="To'lov nomini kriting" class="form-control">
													  	</div>
													</div>
													<div class="col-12 col-md-6">
													  	<div class="form-group">
															<label class="form-label">To'lov miqdori(%)
															</label>
															<input type="text"  required="required" name="payment" placeholder="To'lov miqdorini kriting" class="form-control">
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
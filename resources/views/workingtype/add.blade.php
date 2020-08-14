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
							<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Texnika ish turi')}}
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
												<a href="{!! url('/workingtype/list')!!}">
												<span class="visible-xs"></span>
												<i class="fa fa-list fa-lg">&nbsp;</i> 
												 {{ trans('app.Ro\'yxat')}}
											</a>
											</li>
											<li class="active">
												<a href="{!! url('/workingtype/add')!!}">
												<span class="visible-xs"></span>
												<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
												{{ trans('app.Qo\'shish')}}</b>
											</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<form action="{{ url('/workingtype/store') }}" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
											<div class="row">
												<div class="col-12 col-md-6">
												  	<div class="form-group">
														<label class="form-label" for="workingtype_input">{{ trans('app.Workingtype')}} <label class="text-danger">*</label>
														</label>
														<input id="workingtype_input" type="text"  required="required" name="workingtype" placeholder="{{ trans('app.Enter WorkingType')}}" class="form-control">
												  	</div>
												</div>
												<div class="col-12 col-md-6">
													<div class="form-group">
														<label class="form-label" for="vehicle_category">{{ trans('app.Vehicle Type')}} <label class="text-danger">*</label></label>
														<select id="vehicle_category" name="type" class="form-control vehicle_type">
															<option value>tur</option>
															@if(!empty($types))
																@foreach($types as $type)
																	<option value="{{ $type->id }}">{{ $type->vehicle_type }}</option>
																@endforeach
															@endif
														</select>
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
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){		
    	$('select.vehicle_type').select2({
    		placeholder: "Texnika turini tanlang",
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
	});
</script>
@endsection
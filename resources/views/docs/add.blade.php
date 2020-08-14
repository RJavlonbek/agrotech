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

							<i class="fe fe-life-buoy mr-1"></i>&nbsp Asos hujjatlar

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

								<div class="card-body p-6">

									<div class="panel panel-primary">

										<div class="tab_wrapper page-tab">

											<ul class="tab_list">

												<li>
													<a href="{!! url('/docs/list')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-list fa-lg">&nbsp;</i> 
														Asos hujjatlar
													</a>
												</li>

												<li class="active">
													<a href="{!! url('/docs/add')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
														Qo'shish</b>
													</a>
												</li>

											</ul>

										</div>

									</div>

									<div class="row">

										<div class="col-md-12 col-sm-12 col-xs-12">

											<form action="/docs/store" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
												<input type="hidden" name="_token" value="{{csrf_token()}}">
												<div class="row">

													<div class="col-12 col-md-6">

													  	<div class="form-group">

															<label class="form-label" for="">Asos hujjat nomi <label class="text-danger">*</label>

															</label>

															<input type="text" id="color" name="name"  class="form-control" placeholder="Asos nomini kiriting" required>

													  	</div>

													</div>
													<div class="col-4">
														<div class="form-group">
															<label class="form-label">Qaysi xizmat uchun</label>
															<select name="service" class="form-control select-service" required="required">
																<option value="">Xizmat turini tanlang</option>
																<option value="registration">{{getServiceName('registration')}}</option>
																<option value="driver-license">{{ getServiceName('driver-license') }}</option>
																<option value="technical-passport">{{ getServiceName('technical-passport') }}</option>
																<option value="certificate">{{ getServiceName('certificate') }}</option>
																<option value="number">{{ getServiceName('number') }}</option>
															</select>
														</div>
													</div>

													<div class="col-12 col-md-2">

														<label class="form-label" style="visibility: hidden;">labelll</label>

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

	<div class="right_col" role="main">

		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">

              <div class="nav toggle" style="padding-bottom:16px;">

               <span class="titleup">&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>

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

    	$('select.vehicle_type').select2();

    	$('select.select-service').select2({
    		minimumResultsForSearch:Infinity,
    		placeholder:'Xizmat turini tanlang'
    	});

	});

</script>

@endsection
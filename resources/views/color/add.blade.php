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

							<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Colors')}}

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

													<a href="{!! url('/color/list')!!}">

													<span class="visible-xs"></span>

													<i class="fa fa-list fa-lg">&nbsp;</i> 

													 {{ trans('app.List Colors')}}

												</a>

												</li>

												<li class="active">

													<a href="{!! url('/color/add')!!}">

													<span class="visible-xs"></span>

													<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

													{{ trans('app.Add Colors')}}</b>

												</a>

												</li>

											</ul>

										</div>

									</div>

									<div class="row">

										<div class="col-md-12 col-sm-12 col-xs-12">

											<form action="/color/store" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

												<div class="row">

													<div class="col-12 col-md-6">

													  	<div class="form-group">

															<label class="form-label" for="">{{ trans('app.Color Name')}} <label class="text-danger">*</label>

															</label>

															<input type="text" id="color" name="color"  class="form-control" placeholder="Rang nomini kiriting" maxlength="20" required>

													  	</div>

													</div>

													<input type="hidden" name="_token" value="{{csrf_token()}}">

													<div class="col-12 col-md-6">

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

	});

</script>

@endsection
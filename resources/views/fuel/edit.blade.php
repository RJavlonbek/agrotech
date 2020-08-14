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
					<i class="fe fe-life-buoy mr-1"></i>&nbsp Yonilg'i turlari
				</li>
			</ol>
		</div>
		<div class="clearfix"></div>
			@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alert alert-success text-center">
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
											<a href="{!! url('/fuel/list')!!}">
												<span class="visible-xs"></span>
												<i class="fa fa-list fa-lg">&nbsp;</i> 
												{{ trans('app.Ro\'yxat')}}
											</a>
										</li>
										<li class="active">
											<a href="{!! url('/fuel/list/edit/'.$editid )!!}">
												<span class="visible-xs"></span>
												<i class="fa fa-edit fa-lg">&nbsp;</i> <b>
												{{ trans('app.Tahrirlash')}}</b>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<form action="update/{{ $fuel->id }}" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
										<div class="row">
											<div class="col-12 col-md-6">
											  	<div class="form-group">
													<label class="form-label" for="first-name">Yonilg'i turi <label class="text-danger">*</label>
													</label>
												  	<input type="text"  required="required" name="fuel" value="{{ $fuel->name }}" class="form-control">
												</div>
											</div>
									  		<div class="col-12 col-md-6">
									  			<input type="hidden" name="_token" value="{{csrf_token()}}">
									  			<label class="form-label" style="visibility: hidden;"> label</label>
											  	<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>								  
											  	<button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
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
@endsection
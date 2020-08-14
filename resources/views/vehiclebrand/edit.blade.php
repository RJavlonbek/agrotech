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
					<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Vehicle Brand')}}
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
										<a href="{!! url('/vehiclebrand/list')!!}">
											<span class="visible-xs"></span>
											<i class="fa fa-list fa-lg">&nbsp;</i> 
											{{ trans('app.Ro\'yxat')}}
										</a>
									</li>
									<li class="active">
										<a href="{!! url('/vehiclebrand/list/edit/'.$editid)!!}">
											<span class="visible-xs"></span>
											<i class="fa fa-edit fa-lg">&nbsp;</i> <b>
											{{ trans('app.Tahrirlash')}}</b>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-12">
								<form  action="update/{{$vehicalbrands->id}}"  method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="form-label" for="first-name">{{ trans('app.Vehicle Types')}} <label class="text-danger">*</label>
												</label>
												<select name="vehicletype" class="form-control vehicletype" >
													@if(!empty($vehicaltypes))
														@foreach($vehicaltypes as $vehicaltypess)
															<option value="{{ $vehicaltypess->id }}" 
															<?php if($vehicaltypess->id==$vehicalbrands->vehicle_id) { echo"selected"; } ?>> {{ $vehicaltypess->vehicle_type }}</option>
														@endforeach
											   		@endif
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="form-label" for="first-name">{{ trans('app.Vehicle Brand')}} <label class="text-danger">*</label>
												</label>
												<input type="text"  required="required" name="vehicalbrand" value="{{$vehicalbrands->vehicle_brand}}" class="form-control">
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="form-group">
												<label class="form-label" for="first-name">Dvigatel quvvatini kiriting<label class="text-danger">*</label>
												</label>
												 <input type="text"  required="required" name="enginesize" placeholder="Dvigatel quvvatini kiriting" class="form-control" maxlength="30" value="{{$vehicalbrands->enginesize}}">
											</div>
										</div>
										<div class="col-12 col-md-6">
												<div class="form-group">
													<label class="form-label" for="first-name">{{ trans('app.Working Type')}} <label class="text-danger">*</label></label>
													<select name="working_id" class="form-control working_search" required="required" >
														@if(!empty($working))
														@foreach($working as $work)
															<option value="{{ $work->id }}" 
															<?php if($work->id==$vehicalbrands->working_type_id) { echo"selected"; } ?>> {{ $work->name }}</option>
														@endforeach
											   		@endif
													</select>
												</div>
											</div>
										<div class="col-12 col-md-6">
											<label class="form-label" style="visibility: hidden;">label</label>
											<input type="hidden" name="_token" value="{{csrf_token()}}">
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
		$('select.vehicletype').select2({

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

			},
			minimumResultsForSearch: 2});
		$('select.working_search').select2({

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

			},
			minimumResultsForSearch: 2});
		$('select.vehicletype').change(function(){
			var type = $(this).val();
			var url = '/selecttype'
			$.ajax({
				type:'GET',
				url:url,
				data:'id='+type,
				success:function(data){
					$('#type_id').html(data);
				}
			});
		});
		
	});

	
</script>
@endsection
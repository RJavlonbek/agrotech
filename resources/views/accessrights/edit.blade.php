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
					<i class="fe fe-life-buoy mr-1"></i>&nbsp Lavozimlar
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
													<a href="{!! url('/setting/accessrights/list')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-list fa-lg">&nbsp;</i> 
														{{ trans('app.Ro\'yxat')}}
													</a>
												</li>
												<li class="active">
													<a href="{!! url('/setting/accessrights/add')!!}">
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
											<form  action="{{ url('/setting/accessrights/addstore') }}" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
												<div class="row">
													<div class="col-12 col-md-6">
													  	<div class="form-group">
															<label class="form-label" for="first-name">Lavozim nomi<label class="text-danger">*</label>
															</label>
															<input type="text"  required="required" name="position" placeholder="Lavozim nomini kiriting" class="form-control"
															value="{{ $position->name }}">
															<input type="hidden" name="id" value="{{$position->id}}">
													  	</div>
													</div>
													<div class="col-12 col-md-6">
													  	<div class="form-group">
															<label class="form-label" for="first-name">Lavozim joylashuvi<label class="text-danger">*</label>
															</label>
															<select class="form-control position-des" name="carera">
																<option <?=($position->position == 'country')?'selected':'';  ?> value="country">Respublika uchun lavozim</option>
																<option <?=($position->position == 'region')?'selected':'';  ?> value="region">Viloyat uchun lavozim</option>
																<option <?=($position->position == 'district')?'selected':'';  ?> value="district">Tuman uchun lavozim</option>

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
									<div class="row" >
										<div class="col-md-12 col-sm-12" >
											<div class="table-responsive">
												<table id="example-3" class="table table-striped table-bordered nowrap">
													<thead>
														<tr>
															<th>#</th>
															<th>Xarakat nomi</th>
															<th>Yaratish</th>
															<th>Ko'rish</th>
															<th>O'zgartirish</th>
															<th>O'chirish</th>
														</tr>
													</thead>
													<tbody>
														@if(!empty($roles))
														<?php  $report = array('report_pay', 'report_new', 'report_exist', 'report_reg', 'report_old'); ?>
														   <?php $i = 1; ?>   
															@foreach ($roles as $role)
															    <tr>
																	<td>{!! $i !!}</td>
																	<td>{!! $role->name !!}</td>
																	<td>
																		<input 
																		@if(in_array($role->key_name, $report))
																			disabled
																		@endif 
																		 type="checkbox" class="position" role_id="{{ $role->id }}" role_type="create" <?=$role->create?"checked":"";?> />
																	</td>
																	<td>
																		<input type="checkbox" class="position" role_id="{{ $role->id }}" role_type="read"  <?=$role->read?"checked":"";?> />
																	</td>
																	
																	<td>
																		<input  
																			@if(in_array($role->key_name, $report))
																				disabled
																			@endif
																		type="checkbox" class="position" role_id="{{ $role->id }}" role_type="edit"  <?=$role->edit?"checked":"";?> />
																	</td>
																	<td>
																		<input
																			@if(in_array($role->key_name, $report))
																				disabled
																			@endif
																		 type="checkbox" class="position" role_id="{{ $role->id }}" role_type="delete"  <?=$role->delete?"checked":"";?> />
																	</td>							
																</tr>
																 <?php $i++; ?>
															@endforeach
														@endif
													</tbody>
												</table>
											</div>
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
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
    	
    	$('select.position-des').select2({
    		minimumResultsForSearch: Infinity
    	});

        $('input.position[type="checkbox"]').click(function(){

            if($(this).prop("checked") == true){
				var role_type = $(this).attr('role_type');
				var role_id = $(this).attr('role_id');
				var value = 1;
                var url = '{!! url('/setting/accessrights/change_role')!!}';
				$.ajax({
						type: 'GET',
						url: url,
						data : {role_type:role_type,value:value,role_id:role_id},
						success: function (response)
							 {	
								
							},

						});
            }
            else if($(this).prop("checked") == false){
                var role_type = $(this).attr('role_type');
				var value = 0;
				var role_id = $(this).attr('role_id');
                var url = '{!! url('/setting/accessrights/change_role')!!}';
				$.ajax({
						type: 'GET',
						url: url,
						data : {role_type:role_type,value:value,role_id:role_id},
						success: function (response)
							 {	
								
							},
						});
            }
        });
    });
</script>

@endsection

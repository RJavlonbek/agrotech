@extends('layouts.app')
@section('content')
<?php $userid = Auth::user()->id; ?>
@if (CheckAdmin($userid)=='yes')
	<div class="section">
		<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<i class="fe fe-life-buoy mr-1"></i>&nbsp Lavozim boshqaruvi
				</li>
			</ol>
		</div>
				@if(session('message'))
					<div class="row massage">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="alert alert-success text-center">
			                 @if(session('message') == 'Successfully Submitted')
								<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
							   @elseif(session('message')=='Successfully Updated')
							   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
							   @elseif(session('message')=='Successfully Deleted')
							   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>
						    @endif
			                </div>
						</div>
					</div>
				@endif
            </div>
            <div class="row">
						<div class="col-md-12">
							<div class="card">									
								<div class="card-body">
									<div class="panel panel-primary">
										<div class="tab_wrapper page-tab">
											<ul class="tab_list">
												<li class="active">
													<a href="{!! url('setting/accessrights/list')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-list fa-lg">&nbsp;</i> <b>
														Lavozimlar</b>
													</a>
												</li>
												<li >
													<a href="{!! url('/setting/accessrights/add')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
														{{ trans('app.Qo\'shish')}}</b>
													</a>
												</li>
											</ul>
										</div>
									</div>
			<div class="clearfix"></div>
            <div class="row" >
				<div class="col-md-12 col-sm-12" >
					<div >
						<table id="example-1" class="table table-striped table-bordered table-top jambo_table">
							<thead>
								<tr>
									<th >#</th>
									<th >Lavozim</th>
									<th >Harakat</th>
								</tr>
							</thead>
							<tbody>
								   <?php $i = 1; ?>   
								@foreach ($accessright as $accessrights)
								    <tr>
										<td>{!! $i !!}</td>
										<td>{!! $accessrights->name !!}</td>
										<td>
											<a href="{!! url ('/setting/accessrights/list/edit/'.$accessrights->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
											 
											<a  url="{!! url('/setting/accessrights/list/delete/'.$accessrights->id)!!}" class="sa-warning deletevehicle"> <button type="button" class="btn btn-round btn-danger ">{{ trans('app.Delete')}}</button></a>
										</td>						
									</tr>
									 <?php $i++; ?>
								@endforeach
							</tbody>
						</table>
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
				<span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
            </div>
        </div>
	</div>
@endif   
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
 
<script type="text/javascript">
    $(document).ready(function(){
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
<script>
 $('body').on('click', '.sa-warning', function() {
  
    var url = $(this).attr('url');
    
        swal({   
            title: "O'chirishni istaysizmi?",
      		text: "O'chirilgan ma'lumotlar qayta tiklanmaydi!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#297FCA",   
            confirmButtonText: "Ha, o'chirish!",   
            closeOnConfirm: false,
            cancelButtonText: "O'chirishni bekor qilish"
        }).then((isConfirm) =>{
      window.location.href = url;
             
        });
    }); 

 
</script>
@endsection
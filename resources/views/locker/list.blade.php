@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (CheckAdmin($userid)=='yes')
    <div class="section">
				<!-- PAGE-HEADER -->
			<div class="page-header">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<i class="fe fe-life-buoy mr-1"></i>&nbsp Taqiqqa oluvchilar
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
           <div class="row">
					<div class="col-md-12">
						<div class="card">									
							<div class="card-body p-6">
								<div class="panel panel-primary">
									<div class="tab_wrapper page-tab">
										<ul class="tab_list">
												<li class="active">
													<a href="{!! url('/locker/list')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-list fa-lg">&nbsp;</i> 
														{{ trans('app.Ro\'yxat')}}
													</a>
												</li>
												<li>
													<a href="{!! url('/locker/add')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
														{{ trans('app.Qo\'shish')}}</b>
													</a>
												</li>
											</ul>
									</div>
								</div>
								<div class="table-responsive">
									<table id="example-1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">
										<thead>
											<tr>
												<th class="border-bottom-0 border-top-0" style="max-width: 40px;">#</th>
												<th class="border-bottom-0 border-top-0">{{ trans('app.Name') }}</th>
												<th class="border-bottom-0 border-top-0">{{ trans('app.Action')}}</th>
											</tr>
										</thead>
													<tbody>
										<?php $i=1;?>
										 @foreach($lockers as $locker)
											<tr>
												<td>{{ $i }}</td>
												<td>{{ $locker->name }}</td>
												<td> 
												   <a href="{!! url ('/locker/list/edit/'.$locker->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
												   
												  <a url="{!! url('/locker/list/delete/'.$locker->id)!!}" class="sa-warning"> <button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
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
<!--- delete vehicaltypes -->
<script>
$('body').on('click', '.sa-warning', function() {
  
    var url =$(this).attr('url');
        swal({   
            title: "O'chirishni istaysizmi?",
      text: "O'chirilgan ma'lumotlar qayta tiklanmaydi!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#297FCA",   
            confirmButtonText: "Ha, o'chirish!",
            cancelButtonText: "O'chirishni bekor qilish",   
            closeOnConfirm: false 
        }).then((result) =>{
      window.location.href = url;
             
        });
    }); 
 
</script>

@endsection
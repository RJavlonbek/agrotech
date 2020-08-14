@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')
    <div class="section">
				<!-- PAGE-HEADER -->
			<div class="page-header">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="#"><i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Vehicle')}}</a>
					</li>
				</ol>
			</div>
            <div class="row">
					<div class="col-md-12">
						<div class="card">									
							<div class="card-body">
								<div class="table-responsive">
									<table id="example-1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">
										<thead>
											<tr>
												<th class="border-bottom-0 border-top-0" style="max-width: 40px;">#</th>
												<th class="border-bottom-0 border-top-0">{{ trans('app.Vehicle Type') }}</th>
												<th class="border-bottom-0 border-top-0">{{ trans('app.Action')}}</th>
											</tr>
										</thead>
													<tbody>
										<?php $i=1;?>
										 @foreach($vehicaltypes as $vehicaltypess)
											<tr>
												<td>{{ $i }}</td>
												<td>{{ $vehicaltypess -> vehicle_type }}</td>
												<td> 
												   <a href="{!! url ('/vehicletype/list/edit/'.$vehicaltypess->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
												   
												  <a url="{!! url('/vehicletype/list/delete/'.$vehicaltypess->id)!!}" class="sa-warning"> <button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
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
<!-- language change in user selected -->	
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
		responsive: true,
        "language": {
			
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
			?>.json"
        }
    } );
} );
</script>
<!--- delete vehicaltypes -->
<script>
$('body').on('click', '.sa-warning', function() {
  
    var url =$(this).attr('url');
        swal({   
            title: "Are You Sure?",
      text: "You will not be able to recover this data afterwards!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#297FCA",   
            confirmButtonText: "Yes, delete!",   
            closeOnConfirm: false 
        }, function(){
      window.location.href = url;
             
        });
    }); 
 
</script>

@endsection
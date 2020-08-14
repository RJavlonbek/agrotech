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

							<i class="fe fe-life-buoy mr-1"></i>{{trans('app.Colors')}}

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

				<!-- PAGE-HEADER END -->

				<div class="row">

					<div class="col-md-12">

						<div class="card">									

							<div class="card-body">

								<div class="panel panel-primary">



									<div class="tab_wrapper page-tab">



										<ul class="tab_list">



												<li class="active" >



													<a href="{!! url('/color/list')!!}">



														<span class="visible-xs"></span>



														<i class="fa fa-list fa-lg">&nbsp;</i> 



														{{ trans('app.List Colors') }}



													</a>



												</li>



												<li class="">



													<a href="{!! url('/color/add')!!}">



														<span class="visible-xs"></span>



														<i class="fa fa-list fa-lg">&nbsp;</i> 



														{{ trans('app.Add Colors') }}



													</a>



												</li>

												

											</ul>



									</div>



								</div>

								<div class="table-responsive">

									<table id="example-1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

								<thead>

									<tr>

										<th>#</th>

										<th class="border-bottom-0 border-top-0">{{ trans('app.Color Name')}}</th>

										<th class="border-bottom-0 border-top-0">{{ trans('app.Action')}}</th>

									</tr>

								</thead>

								<tbody>

									<?php $i = 1; ?>   

									

									@foreach ($color as $colors)

									<tr>

										<td>{{ $i }}</td>

										<td>{{ $colors->color }}</td>

										<td>

											<a href="{!! url('/color/list/edit/'.$colors->id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>

											<a url="{!! url('/color/list/delete/'.$colors->id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>

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

		<div class="section" role="main">
			<div class="card">
				<div class="card-body text-center">
					<span class="titleup text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
				</div>
			</div>
		</div>

		@endif    

        <!-- /page content -->

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

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

<script>



$(document).ready(function(){

	$('body').on('click', '.sa-warning', function(){
		var url =$(this).attr('url');
        swal({   
            title: "O'chirmoqchimisiz?",

			text: "Ma'lumotlarni qayta tiklash imkoniyati bo'lmaydi!",   

            type: "warning",   

            showCancelButton: true,   

            confirmButtonColor: "#297FCA",   

            confirmButtonText: "O'chirish",   
            cancelButtonText:'Bekor qilish'

        }).then((result)=>{
        	if(result){
        		window.location.href = url;
        	}
        }).catch((err)=>{
        	swal.close();
        });
	}); 

});

 

</script>



@endsection
@extends('layouts.app')

@section('content')

<!-- page content -->

	<?php $userid = Auth::user()->id; ?>

<style>



</style>



@if (CheckAdmin($userid)=='yes')

		    <div class="section">
		    	<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fe fe-life-buoy mr-1"></i>&nbsp Imtihon turlari
						</li>
					</ol>
				</div>

				<!-- PAGE-HEADER -->

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

							<div class="card-body p-6">

								<div class="panel panel-primary">
									<div class="tab_wrapper page-tab">
										<ul class="tab_list">

												<li class="active">
													<a>
														<span class="visible-xs"></span>
														<i class="fa fa-list fa-lg">&nbsp;</i> 
														Imtihon turlari
													</a>

												</li>



												<li class="">
													<a href="{!! url('/exam-type/add')!!}">
														<span class="visible-xs"></span>
														<i class="fa fa-list fa-lg">&nbsp;</i> 
														Qo'shish
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

										<th class="border-bottom-0 border-top-0">Imtihon turi</th>

										<th class="border-bottom-0 border-top-0">{{ trans('app.Action')}}</th>

									</tr>

								</thead>

								<tbody>

									<?php $i = 1; ?>   

									

									@foreach ($examTypes as $examType)

										<tr>

											<td>{{ $i }}</td>

											<td>{{ $examType->name }}</td>

											<td>

												<a href="{!! url('/exam-type/list/edit/'.$examType->id) !!}" >
													<button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button>
												</a>
												<a url="{!! url('/exam-type/list/delete/'.$examType->id) !!}" class="sa-warning">
													<button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button>
												</a>

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

		               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.') }}</span>

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
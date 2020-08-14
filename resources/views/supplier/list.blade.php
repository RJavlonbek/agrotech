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

					<a href="#"><i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Supplier')}}lar</a>

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

						<div class="card-body">

							<div class="panel panel-primary">

								<div class="tab_wrapper page-tab">

									<ul class="tab_list">

											<li class="active">

												<a href="{!! url('/supplier/list')!!}">

													<span class="visible-xs"></span>

													<i class="fa fa-list fa-lg">&nbsp;</i> 

													 {{ trans('app.Supplier List')}}

												</a>

											</li>

											<li>

												<a href="{!! url('/supplier/add')!!}">

													<span class="visible-xs"></span>

													<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

													{{ trans('app.Add Supplier')}}</b>

												</a>

											</li>

										</ul>

								</div>

							</div>	

							<div class="table-responsive">							

								<table id="datatable" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

								<thead>

									<tr>

										<th>#</th>

										<th>{{ trans('app.Supplier Name') }}</th>

										<th>{{ trans('app.Action')}}</th>

									</tr>

								</thead>

								<tbody>
									@if(!empty($suppliers))
										<?php $i=1; ?>
										@foreach($suppliers as $supplier)
											<tr>
												<td>{{$i}}</td>

												<td>{{$supplier->name}}</td>

												<td> 
													<a href="/supplier/list/edit/{{$supplier->id}}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
													<a url="{!! url('/supplier/list/delete/'.$supplier->id) !!}" class="sa-warning"> <button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
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

@else

	<div class="section" role="main">
		<div class="card">
			<div class="card-body text-center">
				<span class="titleup text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
			</div>
		</div>
	</div>
	
@endif   

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>


<!-- delete vehicalbrand -->

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
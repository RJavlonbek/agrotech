@extends('layouts.app')

@section('content')

<!-- page content -->

	<?php $userid = Auth::user()->id; ?>

<style>



</style>
@if (CheckAdmin($userid)=='yes')

		    <div class="section">

				<!-- PAGE-HEADER -->

				<div class="page-header">

					<ol class="breadcrumb">

						<li class="breadcrumb-item">

							<a href="#"><i class="fe fe-life-buoy mr-1"></i>Mulk egasi kategoriyalari</a>

						</li>

					</ol>

				</div>

				@if(session('message'))

				<div class="row massage">

					<div class="col-md-12 col-sm-12 col-xs-12">

						<div class="checkbox checkbox-success checkbox-circle">

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

								<div class="table-responsive">

									<table id="example-1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

										<thead>

											<tr>

												<th class="border-bottom-0 border-top-0">#</th>

												<th class="border-bottom-0 border-top-0">Kategoriya</th>
												<th>{{ trans('app.Action')}}</th>
											</tr>

										</thead>

										<tbody>

										<?php $i=1;?>

											@if(!empty($customerCategories))

												@foreach($customerCategories as $cat)

													<tr>

														<td>{{ $i }}</td>

														<td>{{ $cat->name}}</td>
														<td> 
															<a href="{!! url ('/customer/category/edit/'.$cat->id) !!}"> 
																<button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button>
															</a>
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

	$('body').on('click', '.deletecustomers', function() {

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

  }); 

 

</script>



@endsection
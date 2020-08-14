@extends('layouts.app')

@section('content')

<!-- page content -->

	<?php $userid = Auth::user()->id; ?>

<style>



</style>



		@if (getAccessStatusUser('Customers',$userid)=='yes')

		    <div class="section">

				<!-- PAGE-HEADER -->

				<div class="page-header">

					<ol class="breadcrumb">

						<li class="breadcrumb-item">

							<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Mulk egalari')}}

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

												<li class="{{empty($type)?'active':''}}" >

													<a href="{!! url('/customer/list')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														{{ trans('app.Barchasi') }}

													</a>

												</li>

												<li class="{{(!empty($type) && $type=='legal')?'active':''}}">

													<a href="{!! url('/customer/list?type=legal')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														Yuridik shaxslar

													</a>

												</li>

												<li class="{{(!empty($type) && $type=='physical')?'active':''}}">

													<a href="{!! url('/customer/list?type=physical')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														Jismoniy shaxslar

													</a>

												</li>

												<li>

													<a href="{!! url('/customer/add')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

														Yangi qo'shish</b>

													</a>

												</li>

											</ul>

									</div>

								</div>

								<div id="list-date-filter">
									<div class="show-date btn btn-default filter-button">Vaqt bo'yicha filtrlash <i class="fa {{ ($from && $till) ? 'fa-angle-left':'fa-angle-right' }}"></i></div>
									<div class="date {{($from && $till) ? 'open':''}}">
										<form class="input-filter">
											<input class="form-control fc-datepicker from input-filter" name="from" placeholder="dd-mm-yyyy" autocomplete="off" required="required" 
												@if(!empty($from))
													value="{{$from}}"
												@endif
											/> dan
											<input class="form-control fc-datepicker till input-filter" name="till" placeholder="dd-mm-yyyy" autocomplete="off" required="required" 
												@if(!empty($till))
													value="{{$till}}"
												@endif
											/> gacha
											@if($from && $till)
												<button type="button" class="btn btn-primary filter-button" id="cancel-date-filter">Filtrni bekor qilish</button>
											@else
												<button type='submit' class="btn btn-primary  filter-button">Filtrlash</button>
											@endif
										</form>
									</div>
									<div class="float-right-buttons">
										<div class="print-table-button btn btn-primary float-right-button" table='example-1'><i class='fa fa-print'></i> Chop etish</div>
										<div class="export-customer-button btn btn-primary  mr-2 float-right-button" table='example-1' filename='Texnik pasportlar'><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>
									</div>
								</div>
								<div class="row">
									<div class="col-8"></div>
									<div class="col-4">
										<form class="d-flex">
											<input type="text" name="s" class="search-input form-control" placeholder="Qidirish" required="required" value="{{ isset($_GET['s']) ? $_GET['s'] : '' }}">
											<button type='submit' class="btn btn-primary"><i class="fa fa-search"></i></button>
										</form>
									</div>
								</div>

								<div class="table-responsive">

									<table id="examples1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

										<thead>

											<tr>

												<th class="border-bottom-0 border-top-0">#</th>

												<th class="border-bottom-0 border-top-0">{{(!empty($type) && $type=='legal') ? 'Korxona nomi' : ((!empty($type) && $type=='physical')?'F.I.Sh':'Mulk egasi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Address') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Mobile Number') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Action')}}</th>

											</tr>

										</thead>

										<tbody>

										<?php 
											if(isset($_GET['page'])){
												$i = (intval($_GET['page'])-1)*50+1;
											}else{
												$i = 1;
											}
											
										 ?>

											@if(!empty($customers))

												@foreach($customers as $customer)

													<tr>

														<td>{{ $i }}</td>

														<td>

															<a href="{!! url('/customer/list/'.$customer->id) !!}">

																<span class="text-capitalize">{{ $customer->lastname.' '.$customer->name.' '.$customer->middlename}}</span> 
																	@if($customer->type != 'physical')
																		({{$customer->ownership_form}})
																	@endif

															</a>

														</td>

														<td>{{ $customer->state.', '.$customer->city }}</td>

														<td>{{ $customer->mobile?$customer->mobile:'Kiritilmagan' }}</td>

														<td> 

															<?php $userid=Auth::User()->id; ?>

															@if(getActiveCustomer($userid)=='yes')

																 

																<a class="btn btn-round btn-success" href="{!! url ('/customer/list/edit/'.$customer->id) !!}">{{ trans('app.Edit')}}</a>

																 

																<!-- <button  url="{!! url('/customer/list/delete/'.$customer->id)!!}" class="deletecustomers btn btn-round btn-danger">{{ trans('app.Delete')}}</button>
 -->
															@elseif(getActiveEmployee($userid)=='yes')

																<a href="{!! url('/customer/list/'.$customer->id) !!}">

																 <button type="button" class="btn btn-round btn-info">

																 	{{ trans('app.View')}}

																 </button></a>

															@else

																<a href="{!! url('/customer/list/'.$customer->id) !!}">

																 <button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>

																<a href="{!! url ('/customer/list/edit/'.$customer->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>	

															@endif

													    </td>

													</tr>

													<?php $i++; ?>

												@endforeach

											@endif

										</tbody>

									</table>
									{{ $customers->links() }}
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

	$(".export-customer-button").on('click', function(){
		window.location.href = '{{URL::to('/export/customer')}}';
	});

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

            title: "Mulk egasini bazadan o'chirmoqchimisiz?",

			text: "O'chirilgan ma'lumotlarni qayta tiklash imkoni bo'lmaydi",   

            type: "warning",   

            showCancelButton: true,   

            confirmButtonColor: "#297FCA",   

            confirmButtonText: "O'chirish",

            cancelButtonText:'Bekor qilish',   

            closeOnConfirm: false 

        }, function(){

			window.location.href = url;

             

        });

    }); 

  }); 

 

</script>



@endsection
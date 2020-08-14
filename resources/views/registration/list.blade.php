@extends('layouts.app')

@section('content')

<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('vehicle_reg', $userid, 'read')=='yes')

	<div class="section">

				<!-- PAGE-HEADER -->

				<div class="page-header">

					<ol class="breadcrumb">

						<li class="breadcrumb-item">

							<i class="fe fe-life-buoy mr-1"></i>Ro'yxatdan chiqarilgan texnikalar

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

												<li class="active">

													<a href="{!! url('/certificate/reglist')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														{{ trans('app.Ro\'yxatdan chiqarilganlar')}}

													</a>

												</li>

												<li >

													<a href="{!! url('/certificate/regadd?type=unregged')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

														{{ trans("app.Ro'yxatdan chiqarish")}}</b>

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

										<div class="export-excel-button btn btn-primary  mr-2 float-right-button" table='example-1' filename="Ro'yxatdan chiqarilgan texnikalar"><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>

									</div>

								</div>

								<div class="table-responsive">

									<table id="examples1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

										<thead>

											<tr>

												<th class="border-bottom-0 border-top-0">#</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Texnika egasi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Turi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Condition') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Status')}}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Date')}}</th>

												<th class="border-bottom-0 border-top-0 no-print">{{ trans('app.Action')}}</th>



											</tr>

										</thead>

										<tbody>

										<?php $i=1;?>

											@if(!empty($registrations))

												@foreach($registrations as $registration)

													<tr>

														<td>{{ $i }}</td>

														<td>

															@if(CheckAccessUser('customers', $userid, 'customer_add'))

																<a class="text-capitalize" href="{!! url('/customer/list/'.$registration->owner_id) !!}">

																	@if($registration->ownertype=='legal')

																		{{ $registration->ownername }}

																	@elseif($registration->ownertype == 'physical')

																		{{ $registration->ownerlastname.' '.$registration->ownername }} 

																		@if(!empty($registration->middlename))

																			{{ $registration->middlename }}

																		@endif

																	@endif

																</a>

															@else

																<a class="text-capitalize" href="javascript:void(0)">

																	@if($registration->ownertype=='legal')

																		{{ $registration->ownername }}

																	@elseif($registration->ownertype == 'physical')

																		{{ $registration->ownerlastname.' '.$registration->ownername }} 

																		@if(!empty($registration->middlename))

																			{{ $registration->middlename }}

																		@endif

																	@endif

																</a>

															@endif

														</td>

														<td>

															@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')

																<a href="/vehicle/list/view/{{ $registration->vehicle_id }}/{{ $registration->city_id }}">{{ $registration->typename.' '.$registration->brandname }}</a>

															@else

																<a href="javascript:void(0)">{{ $registration->typename.' '.$registration->brandname }}</a>

															@endif

														</td>

														<td>{{ trans('app.'.$registration->action) }}</td>

														<td>{{ trans('app.'.$registration->status) }}</td>

														<td>{{ date('d.m.Y', strtotime(date($registration->date))) }}</td>

														<td class="no-print">

															@if (CheckAccessUser('vehicle_reg', $userid, 'edit')=='yes')

																@if($registration->status!='cencelled')

																	<a class="cancelreg" url="{!! url ('/certificate/reglist/regback/'.$registration->id) !!}"> 

																		<button type="button" class="btn btn-round btn-success">{{ trans('app.Bekor Qilish')}}</button>

																	</a>

																@elseif($registration->status=='cencelled')

																	<a  url="{!! url('/certificate/reglist/delete/'.$registration->id)!!}" class="sa-warning deletecertificate"> 

																		<button type="button" class="btn btn-round btn-danger ">{{ trans('app.Delete')}}</button>

																	</a>

																@endif

															@else

																@if($registration->status!='cencelled')

																	<a class="cancelreg" url="{!! url ('/certificate/reglist/regback/'.$registration->id) !!}"> 

																		<button type="button" class="btn btn-round btn-success">{{ trans('app.Bekor Qilish')}}</button>

																	</a>

																@endif	

															@endif

													    </td>

													</tr>

													<?php $i++; ?>

												@endforeach

											@endif

										</tbody>

									</table>
									@if(!empty($registrations))
										{{$registrations->links()}}
									@endif

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

<script type="text/javascript">

 	$(document).ready(function(){

 		$('.cancelreg').on('click',function(e){

			e.stopImmediatePropagation();

			cancelregistration($(this));

		});

 	});



 	function cancelregistration(th){

		var url = th.attr('url');

		swal({

		    title: "Bekor qilishni istaysizmi?",

            text: "O'chirilgan ma'lumotlar qayta tiklanmaydi!",

            type: "warning",

            showCancelButton: true,

            confirmButtonColor: "#DD6B55",

            confirmButtonText: "Ha, bekor qilish",

            cancelButtonText:'Ortga qaytish',

            closeOnConfirm: false

        }).then((isConfirm)=>{

			if (isConfirm) {

				$.ajax({
					type:'GET',
					url:url,
					success: function(data){
						swal({
							title: data,
							text: '',
							type:'success',
							showConfirmButton: false});

						window.location.reload();
					}
				});

			}else{

				swal("Cancelled", "Your imaginary file is safe :)", "error");

			} 

		});

	}

 </script>

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

<!-- delete vehical -->

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

        }, function(){

        	swal('Saqlandi!','','success');
      		window.location.reload();             

        });

    }); 

 

</script>



<script>

 $('body').on('click', '.cancelreg', function() {

  

    var url = $(this).attr('url');

    

        swal({   

            title: "Xarakatni bekor qilmoqcimisiz",

      text: "Sizda bu ma'lumotni qayta tiklash imkoniyati bo'lmaydi!",   

            type: "warning",   

            showCancelButton: true,   

            confirmButtonColor: "#297FCA",   

            confirmButtonText: "Bekor Qilish",  

            cancelButtonText: "Ortga Qaytish", 

            closeOnConfirm: false 

        }, function(){

        	swal('Saqlandi!','','success');
     	 	window.location.reload();             

        });

    }); 

 

</script>



@endsection
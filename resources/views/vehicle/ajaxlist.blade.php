@extends('layouts.app')

@section('content')

<?php $userid = Auth::user()->id; ?>

@if (CheckAccessUser('vehicle_add', $userid, 'read')=='yes')

	<div class="section">

				<!-- PAGE-HEADER -->

				<div class="page-header">

					<ol class="breadcrumb">

						<li class="breadcrumb-item">

							<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Vehicle')}}

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

												<li class="{{$type=='all'?'active':''}}">

													<a href="{!! url('/vehicle/list')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														{{ trans('app.Ro\'yxat') }}

													</a>

												</li>

												<li class="{{$type=='legal'?'active':''}}">

													<a href="{!! url('/vehicle/list?type=legal')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														{{ trans('app.Yuridik shaxslar') }}

													</a>

												</li>

												<li class="{{$type=='physical'?'active':''}}">

													<a href="{!! url('/vehicle/list?type=physical')!!}">

														<span class="visible-xs"></span>

														<i class="fa fa-list fa-lg">&nbsp;</i> 

														{{ trans('app.Jismoniy shaxslar') }}

													</a>

												</li>

												<li>

													@if (CheckAccessUser('vehicle_add', $userid, 'create')=='yes')

														<a href="{!! url('/certificate/regadd?type=regged')!!}">

															<span class="visible-xs"></span>

															<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

															{{ trans('app.Qo\'shish') }}</b>

														</a>

													@else

														<a href="javascript:void(0)">

															<span class="visible-xs"></span>

															<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>

															{{ trans('app.Qo\'shish') }}</b>

														</a>

													@endif

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

										<div class="print-table-button btn btn-primary float-right-button" table='examples1'><i class='fa fa-print'></i> Chop etish</div>

										<div class="export-excel-button btn btn-primary  mr-2 float-right-button" table='examples1' filename='Texnikalar'><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>

									</div>
									<div class="float-right-buttons" style="width:210px;margin-right:40px">
										<input style="margin-top:10px; padding:5px 10px" placeholder="Dvigatel, Kuzov, Shassi" type="search" name="search_key" value="<?=!empty($search)?$search:'' ?>" class="form-control form-control-sm" autocomplete="off"/>
									</div>

								</div>

								<div class="table-responsive">

									<table id="vehicles" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">

										<thead>

											<tr>

												<th class="border-bottom-0 border-top-0">#</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Rusumi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Turi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Texnika egasi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Ishlash sohasi') }}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Davlat raqami')}}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Texnik passport')}}</th>

												<th class="border-bottom-0 border-top-0">{{ trans('app.Qo\'shimcha')}}</th>

												<th class="border-bottom-0 border-top-0 no-print">{{ trans('app.Action')}}</th>

											</tr>

										</thead>

										<tbody>

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
	

	$("input[name='search_key']").keyup(function(){
		var key = $(this).val();
		if(key == ''){
			window.location.href = "/vehicle/list";
		}else{
			window.location.href = "/vehicle/list?key="+key;
		}
	})

} );

</script>

<!-- delete vehical -->

<script>


	$(document).ready(function () {
        draw_data();

        function draw_data(start_date = '', end_date = '') {
            $('#vehicles').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "/vehicle/ajaxlist",
                    'type': 'GET',
                    'data': {
                        start_date: start_date,
                        end_date: end_date
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
            });
        }

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date);
            } else {
                alert("Date range is Required");
            }
        });
    });

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
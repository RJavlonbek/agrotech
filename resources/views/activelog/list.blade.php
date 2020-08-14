@extends('layouts.app')
@section('content')
<?php $userid = Auth::user()->id; ?>
@if (CheckAdmin($userid)=='yes')
	<div class="section">
				<!-- PAGE-HEADER -->
				<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fe fe-life-buoy mr-1"></i>&nbsp Xodimlar harakati
						</li>
					</ol>
				</div>
				<!-- PAGE-HEADER END -->
				<div class="row">
					<div class="col-md-12">
						<div class="card">							
							<div class="card-body">
								<div id="list-date-filter">
									<div class="float-right-buttons">
										<div class="print-table-button btn btn-primary float-right-button" table='examples1'><i class='fa fa-print'></i> Chop etish</div>
										<div class="export-excel-button btn btn-primary  mr-2 float-right-button" table='example-1' filename='Texnik pasportlar'><i class="fa fa-file-excel-o"></i> Excelga jo'natish</div>
									</div>
								</div>
								<div class="table-responsive">
									<table id="examples1" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">
										<thead>
											<tr>
												<th class="border-bottom-0 border-top-0">#</th>
												<th class="border-bottom-0 border-top-0">Xodim</th>
												<th class="border-bottom-0 border-top-0">Texnika egasi</th>
												<th class="border-bottom-0 border-top-0">Texnika</th>
												<th class="border-bottom-0 border-top-0">Xarakat</th>
												<th class="border-bottom-0 border-top-0">Xarakat IP adresi</th>
												<th class="border-bottom-0 border-top-0">Harakat vaqti</th>
											</tr>
										</thead>
										<tbody>
										<?php $i=1;?>
											@if(!empty($activities))
												@foreach($activities as $active)
													<tr>
														<td>{{ $i }}</td>
														<td >
															<a class="text-capitalize" href="/employee/view/{{ $active->user_id }}" >
																@if($active->role == 'admin')
																	{{ $active->username }}
																@else
																	{{ $active->userlastname.' '.$active->username }}
																@endif
															</a>
														</td>
														<td >
															@if(!empty($active->owner_id))
																<a class="text-capitalize" href="{!! url('/customer/list/'.$active->owner_id) !!}">
																	@if($active->ownertype=='legal')
																		{{ $active->ownername }}
																	@elseif($active->ownertype == 'physical')
																		{{ $active->ownerlastname.' '.$active->ownername }} 
																		@if(!empty($active->middlename))
																			{{ $active->middlename }}
																		@endif
																	@endif
																</a>
															@else
																<a href="javascript:void(0)">
																	Texnika egasi bu xarakatda qatnashmagan
																</a>
															@endif
														</td>
														<td>
															<?php $actiontype = array('vehicle_lock', 'vehicle_reg', 'vehicle_cer', 'technical_pass', 'technical_num', 'vehicle_edit', 'vehicle_med'); ?>
															@if($active->type == 'customer_add')
																<a href="javascript:void(0)">
																	Texnika bu xarakatda qatnashmagan
																</a>
															@elseif(in_array($active->type, $actiontype) && empty($active->vehicle_id))
																<a href="javascript:void(0)">
																	Texnika bazadan o'cirilgan
																</a>
															@elseif($active->type == 'driver_lic')
																<a href="javascript:void(0)">
																	Texnika bu xarakatda qatnashmagan
																</a>
															@elseif($active->type == 'driver_exam')
																<a href="javascript:void(0)">
																	Texnika bu xarakatda qatnashmagan
																</a>
															@elseif($active->type == 'user_added' || $active->type == 'user_edit' || $active->type == 'user_deleted')
																<a href="javascript:void(0)">
																	Texnika bu xarakatda qatnashmagan
																</a>
															@else
																<a href="{!! url('/vehicle/list/view/'.$active->vehicle_id.'/'.$active->city_id) !!}">
																	{{ $active->brandname.'-'.$active->typename }} {{ $active->id }}
																</a>
															@endif
														</td>
														<td>
															@if($active->type == 'vehicle_med')
																<a href="{!! url('/technical-inspection/preview?id='.$active->action_id) !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'vehicle_lock')
																<a href="javascript:void()">{{ $active->action }}</a>
															@elseif($active->type == 'vehicle_reg')
																<a href="{!! url('/vehicle/list/view/'.$active->vehicle_id.'/'.$active->city_id) !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'driver_exam')
																<a href="{!! url('/driver-exam/list/preview?id='.$active->action_id) !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'vehicle_cer')
																<a href="{!! url('/certificate/preview?id='.$active->action_id.'&details=true') !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'driver_lic')
																<a href="{!! url('/driver-licence/preview?id='.$active->action_id.'&details=true') !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'technical_num')
																<a href="{!! url('/vehicle/transport-number/preview?id='.$active->action_id.'&details=true') !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'technical_pass')
																<a href="{!! url('/vehicle/technical-passport/preview?id='.$active->action_id.'&details=true') !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'customer_add')
																<a href="{!! url('/customer/list/'.$active->action_id) !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'vehicle_edit')
																<a href="{!! url('/vehicle/list/view/'.$active->vehicle_id.'/'.$active->city_id) !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'user_edit' || $active->type == 'user_added')
																<a href="{!! url('/employee/view/'.$active->action_id) !!} ">{{ $active->action }}</a>
															@elseif($active->type == 'user_deleted')
																<a href="javascript:void(0)">{{ $active->action }}</a>
															@elseif($active->type == 'vehicle_tm')
																<a href="/vehicle/tm-1?vehicle_id={{$active->vehicle_id}}&owner_id={{$active->owner_id}}&type=old">{{ $active->action }}</a>
															@endif
														</td>
														<td>
															@if(!empty($active->ip_adress))
																{{ $active->ip_adress }}
															@endif
														</td>
														<td> 
															{{ date('d.m.Y  H:i:s', strtotime($active->action_time)) }}
													    </td>
													</tr>
													<?php $i++; ?>
												@endforeach
											@endif
										</tbody>
									</table>
									{{ $activities->links() }}
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
        }).then((isConfirm) =>{
      window.location.href = url;
             
        });
    }); 

 
</script>

@endsection
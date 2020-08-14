@extends('layouts.app')
	@section('content')
	<style>
		.right_side .table_row, .member_right .table_row {
		    border-bottom: 1px solid #dedede;
		    float: left;
		    width: 100%;
			padding: 1px 0px 4px 2px;
			
		}
		.member_right{border: 1px solid #dedede;
		    margin-left: 9px;}
		.table_row .table_td {
		  padding: 8px 8px !important;
		  
		}
		.report_title {
		    float: left;
		    font-size: 20px;
		    margin-bottom: 10px;
		    padding-top: 10px;
		    width: 100%;
		}
		.b-detail__head-title {
		    border-left: 4px solid #2A3F54;
		    padding-left: 15px;
		   text-transform: capitalize;
		  
		}

		 .b-detail__head-price {
		    width: 100%;
		    float: right;
		    text-align: center;
		}
		.b-detail__head-price-num {
		   padding: 4px 34px;
		    font: 700 23px 'PT Sans',sans-serif;
		    
		}

		.thumb img{
		  border-radius: 0px;
		}


		.item .thumb {
		    width: 23%;
		  cursor: pointer;
		  float: left;
		  border:1px solid;
		 margin: 3px;
		 
		}
		.item .thumb img {
		  width: 100%;
		  height: 80px;
		}
		.item img {
		  width:435px;

		}
		.carousel-inner-1{
			margin-top: 16px;
		}
		.carousel-inner>.item>a>img, .carousel-inner>.item>img, .img-responsive, .thumbnail a>img, .thumbnail>img{height:300px; width:100%;}
		.shiptitleright{
			float: right;
		}
		ul.bar_tabs>li.active { background:#fff !important;}

	</style>
	  <?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Vehicles',$userid)=='yes')
     <div class="section">
    	<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="/"><i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Vehicle')}}
					</a>
				</li>
			</ol>
		</div>		
		@if(session('message'))
		<div class="row massage">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-success checkbox-circle">
					<input id="checkbox-10" type="checkbox" checked="">
					<label for="checkbox-10 colo_success">  {{session('message')}} </label>
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
									<li>
										<a href="{!! url('/vehicle/list')!!}">
											<span class="visible-xs"></span>
											<i class="fa fa-list fa-lg">&nbsp;</i> 
											{{ trans('app.Vehicle List')}}
										</a>
									</li>
									<li class="active">
										<a href="{!! url('/vehicle/add')!!}">
											<span class="visible-xs"></span>
											<i class="fa fa-user fa-lg">&nbsp;</i> <b>
											{{ trans('app.View Vehicle')}}</b>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="row">
									<div class="wideget-user-desc d-flex">
										<div class="user-wrap">
											<h4>
												Texnika haqida ma'lumotlar:
											</h4>
										</div>
									</div>										
								</div>
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.Model Name')}}:</span>
											<span class="customer-info-text">{{ $v_type->vehicle_type }}</span>
										</div>
									</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-500">{{ trans('app.Vehicle Brand :')}}</span>
												<span class="customer-info-text">
													{{ $v_brand->vehicle_brand }}
												</span>
											</div>
										</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-500">{{ trans('app.Engine No')}}:</span>
												<span class="customer-info-text">
													{{ $vehicle->engineno }}
												</span>
											</div>
										</div>
										<div class="col-md-6 col-12">
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-500">{{ trans('app.Model Year :')}}</span>
												<span class="customer-info-text">
													{{ $vehicle->modelyear }}
												</span>
											</div>
										</div>
									<div class="col-md-6 col-12">	
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.Condition')}}</span>
											<span class="customer-info-text">
												{{ $vehicle->condition }}
											</span>
										</div>
									</div>
										<div class="col-md-6 col-12">	
											<div class="customer-info-item border-bottom pt-3 fs-16">
												<span class="customer-info-desc fw-500">{{ trans('app.Chasic No')}}:</span>
												<span class="customer-info-text">
													{{ $vehicle->chassisno }}
												</span>
											</div>
										</div>
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.Factory Number')}}:</span>
											<span class="customer-info-text">
										 	{{ $vehicle->factory_number }} 
											</span>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.Working Type')}}:</span>
											<span class="customer-info-text">
												{{ $v_working->name }}
											</span>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.Davlat raqami')}}:</span>
											<span class="customer-info-text">
												@if(!empty($v_number))
													{{ $v_number->series }}
												@else
													{{ trans("app.Davlat raqami berilmagan") }}
												@endif
											</span>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.QX guvohnomasi')}}:</span>
											<span class="customer-info-text">
												fisasa
											</span>
										</div>
									</div>

								</div>
								<div class="row">
									<div class="wideget-user-desc d-flex">
										<div class="user-wrap">
											<h4>
												Texnika egasi haqida ma'lumotlar:
											</h4>
										</div>
									</div>										
								</div>
								<div class="row">
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">Turi(yuridik yoki jismoniy):</span>
											<span class="customer-info-text">
												{{ $owner->type }}
											</span>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.Owner name')}}:</span>
											<span class="customer-info-text">
												{{ $owner->name }}
											</span>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">Viloyat:</span>
											<span class="customer-info-text">
												{{ $v_region->name }}
											</span>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.Town/City')}}:</span>
											<span class="customer-info-text">
												@if(!empty($v_city))
													{{ $v_city->name }}
												@else
													{{ trans("app.Town/city belgilanmagan") }}
												@endif
											</span>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.Passport No')}}:</span>
											<span class="customer-info-text">
												{{ $owner->passport_series.'-'.$owner->passport_number }}
											</span>
										</div>
									</div>
									<div class="col-md-6 col-12">
										<div class="customer-info-item border-bottom pt-3 fs-16">
											<span class="customer-info-desc fw-500">{{ trans('app.STIR')}}:</span>
											<span class="customer-info-text">
												{{ $owner->inn }}
											</span>
										</div>
									</div>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="/"><i class="fe fe-calendar mr-1"></i>&nbsp {{ trans('app.Timeline')}}
							</a>
						</li>
					</ol>
				</div>
			</div>	
			<div class="col-md-12">
				<ul class="cbp_tmtimeline">
					<li>
						<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> </time>
						<div class="cbp_tmicon">
							<img style="margin-top: -3px;" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/registration-480.png') }}">
						</div>
						<div class="cbp_tmlabel">
							<div class="row">
								<div class="col-12"> 
									<h2 class="text-dark timeline-title border-bottom mb-0"><span>Ro’yxatga olingan/chiqarilgan	</span> </h2>
									<div class="table-responsive">
										<table class="table card-table table-vcenter text-nowrap">
											<thead>
												<tr>
													<th>
														Harakat (ro’y olingan/ro’y chiqarilgan)
													</th>
													<th>
														Viloyat
													</th>
													<th>
														{{ trans('app.Town/City')}}
													</th>
													<th>
														Texnika egasi to’liq nomi
													</th>
													<th>
														Texnika davlat raqami
													</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														adfsdfasdf
													</td>
													<td>
														adfsdfasdf
													</td>
													<td>
														adfsdfasdf
													</td>
													<td>
														adfsdfasdf
													</td>
													<td>
														adfsdfasdf
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="row">
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Harakat (ro’y olingan/ro’y chiqarilgan) </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">124123</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Viloyat </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">{{ trans('app.Town/City')}} </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<link href="" target="_blank"><span class="customer-info-desc fw-500">Texnika egasi to’liq nomi </span></link>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500"> Texnika davlat raqami </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> </time>
						<div class="cbp_tmicon" style="background-color: #2DB67C;">
							<img class="ml-1" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/tractor4.png') }}">
						</div>
						<div class="cbp_tmlabel">
							<div class="row">
								<div class="col-12"> 
									<h2 class="text-dark timeline-title border-bottom mb-0"><span>Taqiqga olingan/chiqarilgan</span> </h2>
									<div class="row">
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Harakat (Ta’qiqga olinga || taqiqdan chiqarilgan)</span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">124123</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Notarius tartib raqami </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Texnika egasi to’liq nomi </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Texnika davlat raqami</span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Tex-passport raqami</span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">To’lov</span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> </time>
						<div class="cbp_tmicon">
							<img src="{{ URL::asset('resources/views/layouts/assets/images/pngs/wrench.png') }}">
						</div>
						<div class="cbp_tmlabel">
							<div class="row">
								<div class="col-12"> 
									<h2 class="text-dark timeline-title border-bottom mb-0"><span>Texnik ko'rikdan o'tish</span> </h2>
									<div class="row">
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Texnika davlat raqami </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">124123</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<link href="" target="_blank"><span class="customer-info-desc fw-500">Texnika egasi to’liq nomi </span></link>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">To'lov </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>										
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> </time>
						<div class="cbp_tmicon" style="background-color: #EB3080;">
							<img src="{{ URL::asset('resources/views/layouts/assets/images/pngs/car-number-2.png') }}">
						</div>
						<div class="cbp_tmlabel">
							<div class="row">
								<div class="col-12"> 
									<h2 class="text-dark timeline-title border-bottom mb-0"><span>Davlat raqami berilgan/yangilangan</span> </h2>
									<div class="row">
										<div class="col-md-4 col-12 ">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Harakat (berilgan || qayta tiklangan) </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">124123</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Texnika egasi to’liq nomi</span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Davlat raqami </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">To'lov </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> </time>
						<div class="cbp_tmicon">
							<img class="m-1" src="{{ URL::asset('resources/views/layouts/assets/images/pngs/tractor4.png') }}">
						</div>
						<div class="cbp_tmlabel">
							<div class="row">
								<div class="col-12"> 
									<h2 class="text-dark timeline-title border-bottom mb-0"><span>QX guvohnomasi berilgan/yangilangan</span> </h2>
									<div class="row">
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Texnika egasi to’liq nom</span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">124123</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">QX guvohnomasi raqami</span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">124123</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">To'lov </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-12">										
											<div class="customer-info-item pt-3 fs-16">
												<div class="row">
													<div class="col-12">
														<span class="customer-info-desc fw-500">Berildi/Qayta tiklandi </span>
													</div>
													<div class="col-12">
														<span class="customer-info-text">123234</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
@else
	<div class="section" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
            <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
            </div>
        </div>
	</div>
@endif 
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
@endsection
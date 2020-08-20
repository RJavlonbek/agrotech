<!doctype html>
 <html lang="en" dir="ltr">
	 <head>
<!--  index.html
D 28:26 !-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<meta name="msapplication-TileColor" content="#0061da" />
<meta name="theme-color" content="#1643a3" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
 <meta name="apple-mobile-web-app-capable" content="yes" />
 <meta name="mobile-web-app-capable" content="yes" />
 <meta name="HandheldFriendly" content="True" />
 <meta name="MobileOptimized" content="320" />
 <link rel="icon" href="favicon.ico" type="image/x-icon" />
 <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

 <!-- Title -->
 <title></title>
 <link rel="stylesheet" href="{{ URL::asset('resources/views/layouts/assets/fonts/fonts/font-awesome.min.css') }}" />


 <!-- Sidemenu Css -->
 <link href="{{ URL::asset('resources/views/layouts/assets/plugins/fullside-menu/css/style.css') }}" rel="stylesheet" />
 <link href="{{ URL::asset('resources/views/layouts/assets/plugins/fullside-menu/waves.min.css') }}" rel="stylesheet" />

 <!-- Dashboard Css -->
 <link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/tasks-style.css') }}">

 <!-- c3.js Charts Plugin -->
 <link href="assets/plugins/charts-c3/c3-chart.css" rel="stylesheet" />

 <!-- Morris.js Charts Plugin -->
 <link href="assets/plugins/morris/morris.css" rel="stylesheet" />

 <!-- Custom scroll bar css-->
 <link href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

 <!---Font icons-->
<link href="assets/plugins/iconfonts/plugin.css" rel="stylesheet" />
</head>
 <body class=""> 
	 <div id="global-loader"></div>
	 <div class="page">
		 <div class="page-main">
			 <div class="app-header1 header py-1 d-flex">
				 <div class="container-fluid">
					 <div class="d-flex">
						 <a class="header-brand" href="index.html">
							 
						 </a>
						 <div class="menu-toggle-button">
							 <a class="nav-link wave-effect" href="#" id="sidebarCollapse">
								 <span class="fa fa-bars"></span>
							 </a>
						 </div>
						 <div class="mt-2">
							  <div class="searching mt-3 ml-2">

									 <a href="javascript:void(0)" class="search-open mt-3">
										 <i class="fa fa-search text-white"></i>
									 </a>


								 <div class="search-inline">
									<form method="get">
									 	<input type="hidden" name="method" value="{{ $method }}" />
										<input type="hidden" name="status" value="{{ $status }}" />
										<input type="text" class="form-control" name="search" placeholder="Qidirish" />
										<button type="submit">
											<i class="fa fa-search"></i>
										</button>
										<a href="javascript:void(0)" class="search-close">
											<i class="fa fa-times"></i>
										</a>
									</form>
								 </div>
							 </div>
						 </div>
						 <div class="d-flex order-lg-2 ml-auto">
							<div class="dropdown mt-1">
								<?php $user=Auth::user();?>
								<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
									 <span class="avatar avatar-md brround" style="background-image: url({{ URL::asset('resources/views/layouts/assets/images/avtar.png') }})"></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
									<div class="text-center">
										<a href="/employee/view/{{$user->id}}" class="dropdown-item text-center font-weight-sembold user">
											{{$user->name.' '.$user->lastname}} 
										</a>
									</div>
								</div>
							</div>
						 </div>

					 </div>
				 </div>
			 </div>

			 <div class="wrapper">
				 <!-- Sidebar Holder -->
				 <nav id="sidebar" class="nav-sidebar">
					 <ul class="list-unstyled components" id="accordion">
						<li>
					 		<a href="{!! url('/mib-requests/list?method=1') !!}" class="slide-item">
								Qarzdorning mulklari haqida ma'lumotlar uchun so'rovnomalar
							</a>
						</li>
						<li>
							<a href="{!! url('/mib-requests/list?method=2') !!}" class="slide-item">
								Qarzdorga tegishli mulkni taqiqqa olish uchun so'rovnomalar
							</a>
						</li>
						<li>
							<a href="{!! url('/mib-requests/list?method=3') !!}" class="slide-item">
								Qarzdorga tegishli mulkni taqiqdan chiqarish uchun so'rovnomalar
							</a>
						</li>
						<li class="">
							<a href="/" class="accordion-toggle wave-effect">
								<i class="fa fa-sign-out mr-2"></i> Tizimga qaytish
							</a>
						</li>
					 </ul>
				 </nav>
				 <div class=" content-area ">
					 <div class="page-header">
						 <h4 class="page-title">Majburiy Ijro Byurosi tomonidan yuborilgan so'rovlar </h4>
						 <ol class="breadcrumb">
							 <li class="breadcrumb-item"><a href="/">Agro </a></li>
							 <li class="breadcrumb-item active" aria-current="page">So'rovlar</li>
						 </ol>
					 </div>

					 <div class="row mg-t-20">
						 <div class="col-12">
							 <div class="card">
								<div class="card-header ">
									 <h3 class="card-title ">
									 	@if($method == 1)
										 	Qarzdorning mulklari haqida ma'lumotlar uchun so'rovnomalar
										@elseif($method == 2)
											Qarzdorga tegishli mulkni taqiqqa olish uchun so'rovnomalar
										@elseif($method == 3)
											Qarzdorga tegishli mulkni taqiqdan chiqarish uchun so'rovnomalar
										@else
											So'rovnomalar
										@endif
									</h3>
									<div class="card-options">
										<form method="get">
									 		<input type="hidden" name="method" value="{{ $method }}" />
											<inpit type="hidden" name="search" value="{{ $search }}" />
											<select class="form-control select2-vehicle-type status-filter" data-placeholder="Holat" name="status">
												<option value="">Barchasi</option>
												<option value="0" {{ $status==0 ? "selected='selected'" : ""}} >Qabul qilingan</option>
												<option value="1" {{ $status==1 ? "selected='selected'" : ""}} >Yakunlangan</option>
												<option value="2" {{ $status==2 ? "selected='selected'" : ""}} >Xatolik</option>
											</select>
										</form>
									</div>
								</div>
								@if(!empty($requests))
								 	<div class="table-responsive">
									 	<table class="table table-hover card-table table-striped table-vcenter table-outline">
											<thead>
												@if($method == 1)
													<tr>
														<th scope="col">№</th>
														<th scope="col">Qarzdor</th>
														<th scope="col">Qarzdor ma'lumotlari</th>
														<th scope="col">Sana </th>
														<th scope="col">Holat </th>
														<th scope="col">Harakat</th>
													</tr>
												@elseif($method == 2)
													<tr>
														<th scope="col">№</th>
														<th scope="col">MIB filiali</th>
														<th scope="col">MIB xodimi</th>
														<th scope="col">Buyruq ma'lumotlari</th>
														<th scope="col">Texnika ma'lumotlari</th>
														<th scope="col">Sana </th>
														<th scope="col">Holat </th>
														<th scope="col">Harakat</th>
													</tr>
												@elseif($method == 3)
													<tr>
														<th scope="col">№</th>
														<th scope="col">Ta'qiq ID</th>
														<th scope="col">MIB filiali</th>
														<th scope="col">MIB xodimi</th>
														<th scope="col">Buyruq ma'lumotlari</th>
														<th scope="col">Sana </th>
														<th scope="col">Holat </th>
														<th scope="col">Harakat</th>
													</tr>
												@else
													Unknown method
												@endif
											</thead>
											<tbody>
												<?php $i=$page == 1 ? 0 : 10*$page; ?>
												@foreach($requests as $req)
													<?php $i++; ?>
													@if($method == 1)
														<tr>
															<th scope="row">{{ $i }}</th>
															<td>{{ $req->fio_debtor }}</td>
															<td>
																@if($req->inn_debtor)
																	INN: {{ $req->inn_debtor }}
																@elseif($req->passport_sn && $req->passport_num)
																	Pasport: {{ $req->passport_sn . $req->passport_num }}
																@elseif($req->pinfl_debtor)
																	SHIR: {{ $req->pinfl_debtor }}
																@else
																	--
																@endif
															</td>
															<td>{{ date('d.m.Y H:i', strtotime($req->created_at)) }}</td>
															<td>
																@if($req->status==0)
																	<span class="badge badge-info">
																		<i class="fa fa-clock-o"></i>
																		Qabul qilingan
																	</span>
																@elseif($req->status==1)
																	<span class="badge badge-success">
																		<i class="fa fa-check"></i>
																		Yakunlangan
																	</span>
																@elseif($req->status==2)
																	<span class="badge badge-danger">
																		<i class="fa fa-ban"></i>
																		Xatolik
																	</span>
																@endif
															</td>
															<td>
																<a class="btn btn-sm btn-primary" href="/mib-requests/list/{{ $req->id }}">
																	<i class="fa fa-eye"></i> Ko'rish 
																</a>
															</td>
														</tr>
													@elseif($method == 2)
														<tr>
															<th scope="row">{{ $i }}</th>
															<td>{{ $req->branch_name }}</td>
															<td>{{ $req->inspector_fio }}</td>
															<td>{{ date('d.m.Y', strtotime($req->doc_outgoing_date)) }} №{{ $req->doc_number }}</td>
															<td>
																@if($req->property_number)
																	<li>DRB: {{ $req->property_number }}</li>
																@endif
																@if($req->property_pass_info && $req->property_pass_num)
																	<li>Hujjat: {{ $req->property_pass_info.$property_pass_num }}</li>
																@endif
															</td>
															<td>{{ date('d.m.Y H:i:s', strtotime($req->created_at))}}
															<td>
																@if($req->status==0)
																	<span class="badge badge-info">
																		<i class="fa fa-clock-o"></i>
																		Qabul qilingan
																	</span>
																@elseif($req->status==1)
																	<span class="badge badge-success">
																		<i class="fa fa-check"></i>
																		Yakunlangan
																	</span>
																@elseif($req->status==2)
																	<span class="badge badge-danger">
																		<i class="fa fa-ban"></i>
																		Xatolik
																	</span>
																@endif
															</td>
															<td>
																<a class="btn btn-sm btn-primary" href="/mib-requests/list/{{ $req->id }}">
																	<i class="fa fa-eye"></i> Ko'rish 
																</a>
															</td>
														</tr>
													@elseif($method == 3)
														<tr>
															<th scope="row">{{ $i }}</th>
															<td>{{ $req->ban_id }}</td>
															<td>{{ $req->branch_name }}</td>
															<td>{{ $req->inspector_fio }}</td>
															<td>{{ date('d.m.Y', strtotime($req->doc_outgoing_date)) }} №{{ $req->doc_number }}</td>
															<td>{{ date('d.m.Y H:i:s', strtotime($req->created_at))}}
															<td>
																@if($req->status==0)
																	<span class="badge badge-info">
																		<i class="fa fa-clock-o"></i>
																		Qabul qilingan
																	</span>
																@elseif($req->status==1)
																	<span class="badge badge-success">
																		<i class="fa fa-check"></i>
																		Yakunlangan
																	</span>
																@elseif($req->status==2)
																	<span class="badge badge-danger">
																		<i class="fa fa-ban"></i>
																		Xatolik
																	</span>
																@endif
															</td>
															<td>
																<a class="btn btn-sm btn-primary" href="/mib-requests/list/{{ $req->id }}">
																	<i class="fa fa-eye"></i> Ko'rish 
																</a>
															</td>
														</tr>
													@else
														Invalid method
													@endif
												@endforeach
											</tbody>
										</table>
										{{ $requests->links() }}
								 	</div>
								@endif
							 </div>
						 </div>
					 </div>
				 </div>
			 </div>
		 </div>

		 <!--footer-->
		<footer class="footer">
			<div class="container">
				 <div class="row align-items-center flex-row-reverse">
					 <div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
						Copyright © 2019
					 </div>
				 </div>
			</div>
		</footer>
		 <!-- End Footer-->
	</div>
	 <!-- Back to top -->
	 <a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>

	 <!-- Dashboard Core -->
	 <script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>
	 <script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
	 {{-- <script src="assets/js/vendors/jquery.sparkline.min.js"></script>
	 <script src="assets/js/vendors/selectize.min.js"></script>
	 <script src="assets/js/vendors/jquery.tablesorter.min.js"></script>
	 <script src="assets/js/vendors/circle-progress.min.js"></script>
	 <script src="assets/plugins/rating/jquery.rating-stars.js"></script> --}}

	 <!-- Fullside-menu Js-->
	 <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fullside-menu/jquery.slimscroll.min.js') }}"></script>
	 <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fullside-menu/waves.min.js') }}"></script>

	 <!-- Echarts Js-->
	 {{-- <script src="assets/plugins/echarts/echarts.js"></script>
	 <script src="assets/js/index1.js"></script> --}}

	 <!--Morris.js Charts Plugin -->
	 {{-- <script src="assets/plugins/am-chart/amcharts.js"></script>
	 <script src="assets/plugins/am-chart/serial.js"></script> --}}

	 <!-- Custom scroll bar Js-->
	 {{-- <script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script> --}}


	 <!-- Custom Js-->
	 <script src="{{ URL::asset('resources/views/layouts/assets/js/tasks-script.js') }}"></script>

	 <script type="text/javascript">
	 	$(function(){
			$('select.status-filter').on('change', function(e){
				console.log('changed');
				$(this).closest('form').submit();
			});
		});
	 </script>

 </body>
 </html>
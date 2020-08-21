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

<!-- SELECT2 CSS -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/select2/dist/css/select2.min.css') }}">

<!-- Sweetalert -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/sweet-alert/sweetalert.css') }}">

<!-- Datepicker -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('build/css/bootstrap-datetimepicker.min.css') }}">

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
									 <form>
										 <input type="text" class="form-control" placeholder="Search here" />
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
				 <div class="content-area" response="{{ $req->response }}" request-id="{{ $req->id }}" request-status="{{ $req->status }}">
				 	<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="page-header">
						<h4 class="page-title">MIB tomonidan yuborilgan so'rov haqida ma'lumot </h4>
						<ol class="breadcrumb">
							 <li class="breadcrumb-item"><a href="/">Agro </a></li>
							 <li class="breadcrumb-item active" aria-current="page"><a href="/task/list">So'rovlar</a></li>
						</ol>
					</div>

					<div class="row mg-t-20">
						<div class="col-12">
							<div class="card">
								<div class="card-header ">
									<h3 class="card-title ">
                                        @if($req->method == 1)
                                            Qarzdorning mulklari haqida ma'lumotlar uchun so'rovnoma
                                        @elseif($req->method == 2)
                                            Qarzdorga tegishli mulkni taqiqqa olish uchun so'rovnoma
                                        @elseif($req->method == 3)
                                            Qarzdorga tegishli mulkni taqiqdan chiqarish uchun so'rovnoma
                                        @else
                                            So'rovnomalar
                                        @endif
									</h3>
									<div class="card-options">
										<h5>
											@if($req->status==0)
												<span class="badge badge-info">
													Qabul qilingan
												</span>
											@elseif($req->status==1)
												<span class="badge badge-success">
													<i class="fa fa-eye"></i>
													Yakunlangan
												</span>
											@elseif($req->status==2)
												<span class="badge badge-danger">
													<i class="fa fa-clock-o"></i>
													Xatolik
												</span>
											@endif
                                            <span class="badge badge-info ml-2">
                                                <i class="fa fa-clock-o"></i>
                                                {{ date('d.m.Y H:i', strtotime($req->created_at)) }}
                                            </span>
										</h5>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-6">
											<h3>So'rov (MIB)</h3>
											<div class="table-responsive">
												<table class="table table-hover card-table table-vcenter table-outline text-nowrap">
													<tbody>
                                                        @if($req->method == 1)
                                                            <tr>
                                                                <td class="field-name">Qarzdor FISH : </td>
                                                                <td class="field-value">{{ $req->fio_debtor }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">Pasport: </td>
                                                                <td class="field-value">{{ $req->passport_sn . $req->passport_num }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">SHIR: </td>
                                                                <td class="field-value">{{ $req->pinfl_debtor }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">STIR : </td>
                                                                <td class="field-value">{{ $req->inn_debtor }}</td>
                                                            </tr>
                                                        @elseif($req->method == 2)
                                                            <tr>
                                                                <td class="field-name">Ijro etiluvchi hujjat: </td>
                                                                <td class="field-value">{{ date('d.m.Y', strtotime($req->doc_outgoing_date)) . " №" . $req->doc_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">MIB filiali : </td>
                                                                <td class="field-value">{{ $req->branch_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">MIB xodimi FISh : </td>
                                                                <td class="field-value">{{ $req->inspector_fio }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">Texnika DRB : </td>
                                                                <td class="field-value">{{ $req->property_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">Texnika hujjati : </td>
                                                                <td class="field-value">{{ $req->property_pass_info.$req->property_pass_num }}</td>
                                                            </tr>
                                                        @elseif($req->method == 3)
                                                            <tr>
                                                                <td class="field-name">Taqiq id raqami: </td>
                                                                <td class="field-value">{{ $req->ban_id }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">Ijro etiluvchi hujjat: </td>
                                                                <td class="field-value">{{ date('d.m.Y', strtotime($req->doc_outgoing_date)) . " №" . $req->doc_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">MIB filiali : </td>
                                                                <td class="field-value">{{ $req->branch_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="field-name">MIB xodimi FISh : </td>
                                                                <td class="field-value">{{ $req->inspector_fio }}</td>
                                                            </tr>
                                                        @endif
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-6">
											<h3>Javob (Agroinspeksiya) </h3>
											<pre>
{{ print_r($response) }}
                                            </pre>
                                            <pre>
{{ $req->response) }}
                                            </pre>
										</div>
									</div>
								</div>
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

	<!-- SELECT2 JS -->
	<script src="{{ URL::asset('resources/views/layouts/assets/plugins/select2/dist/js/select2.min.js') }}"></script>

	<!-- Sweetalert -->
	<script src="{{ URL::asset('resources/views/layouts/assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>

	

	<!-- DATEPICKER JS -->
	<script src="{{ URL::asset('build/js/bootstrap-datetimepicker.min.js') }}"></script>

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

 </body>
 </html>g
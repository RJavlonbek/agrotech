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
						<li class="">
							<a href="#Apps" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
								<i class="fa fa-th-large mr-2"></i> So'rovlar
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
						 <h4 class="page-title">Davlat xizmatlari markazi tomonidan yuborilgan so'rovlar </h4>
						 <ol class="breadcrumb">
							 <li class="breadcrumb-item"><a href="/">Agro </a></li>
							 <li class="breadcrumb-item active" aria-current="page">So'rovlar</li>
						 </ol>
					 </div>

					 <div class="row mg-t-20">
						 <div class="col-12">
							 <div class="card">
								<div class="card-header ">
									 <h3 class="card-title ">So'rovlar </h3>
									 <div class="card-options">

									 </div>
								</div>
								@if(!empty($requests))
								 	<div class="table-responsive">
									 	<table class="table table-hover card-table table-striped table-vcenter table-outline">
											<thead>
											   	<tr>
											   		<th scope="col">№</th>
												 	<th scope="col">So'rov turi </th>
												 	<th scope="col">Ariza raqami</th>
												 	<th scope="col">DXM filiali</th>
												 	<th scope="col">Sana </th>
												 	<th scope="col">Subyekt</th>
												 	<th scope="col">Mas'ul xodim </th>
												 	<th scope="col">Holat </th>
												 	<th scope="col">Harakat</th>
											   	</tr>
											</thead>
											<tbody>
												<?php $i=0; ?>
												@foreach($requests as $req)
													<?php $i++; ?>
												   	<tr>
														<th scope="row">{{ $i }}</th>
														<td>
															@if($req->method==1)
																Tadbirkorlik subyektining ixtiyoriy ravishda tugatilishi to'g'risida xabarnoma
															@elseif($req->method==2)
																Ariza bekor qilinganligi to'g'risida xabarnoma
															@elseif($req->method==3)
																Likvidatsiyani ijro etuvchi xodim o'zgarganligi to'g'risida xabarnoma
															@elseif($req->method==4)
																Likvidatsiya qilishdan oldingi so'rov
															@elseif($req->method==5)
																Likvidatsiya jarayoni yakunlanganligi to'g'risida xabarnoma
															@elseif($req->method==6)
																Tadbirkorlik subyektini harakatsiz rejimga o'tganligi to'g'risida xabarnoma
															@elseif($req->method==7)
																Tadbirkorlik subyektini aktiv holatga qaytarilganligi to'g'risida xabarnoma
															@elseif($req->method==8)
																metod 8
															@endif
														</td>
														<td>{{ $req->application_id }}</td>
														<td>{{ $req->center_name }}</td>
														<td>{{ date('d.m.Y H:i', strtotime($req->recieved_at)) }}</td>
														<td>{{ $req->entity_name }}</td>
														<td>Admin </td>
														<td>
															@if($req->status==0)
																<span class="badge badge-secondary">
																	Ko'rilmagan
																</span>
															@elseif($req->status==1)
																<span class="badge badge-primary">
																	<i class="fa fa-eye"></i>
																	Ko'rilgan
																</span>
															@elseif($req->status==2)
																<span class="badge badge-info">
																	<i class="fa fa-clock-o"></i>
																	Jo'natilgan
																</span>
															@elseif($req->status==3)
																<span class="badge badge-warning">
																	<i class="fa fa-close"></i>
																	Bekor qilingan
																</span>
															@elseif($req->status==4)
																<span class="badge badge-success">
																	<i class="fa fa-check"></i>
																	Yakunlangan
																</span>
															@elseif($req->status==5)
																<span class="badge badge-danger">
																	<i class="fa fa-ban"></i>
																	Xatolik
																</span>
															@endif
														</td>
														<td>
															<a class="btn btn-sm btn-primary" href="/task/list/{{ $req->id }}">
																<i class="fa fa-eye"></i> Ko'rish 
															</a>
														</td>
												   	</tr>
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

 </body>
 </html>
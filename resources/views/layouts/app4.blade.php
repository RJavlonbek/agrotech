<!doctype html>
<html lang="en" dir="ltr">
	<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Slica – Bootstrap Responsive Flat Admin Dashboard HTML5 Template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="admin site template, html admin template,responsive admin template, admin panel template, bootstrap admin panel template, admin template, admin panel template, bootstrap simple admin template premium, simple bootstrap admin template, best bootstrap admin template, simple bootstrap admin template, admin panel template,responsive admin template, bootstrap simple admin template premium"/>

		<!--favicon -->
		<link rel="icon" href="{{ URL::asset('resources/views/layouts/assets/images/logo.svg') }}" type="image/x-icon"/>

		<!-- TITLE -->
		<title>Slica 4</title>
	<link href="{{ URL::asset('vendors/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
	
	<link href="{!! URL::asset('build/dist/css/select2.min.css'); !!}" rel='stylesheet' type='text/css'>
	
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/skins-modes.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/color-style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/sidemenu/sidemenu.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/p-scroll/p-scroll.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/icons.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/right-sidebar/right-sidebar.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/charts-c3/c3-chart.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/skins/skins-modes/color1.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/fonts.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ URL::asset('build/css/bootstrap-datetimepicker.min.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/myStyle.css') }}">

	<!-- SELECT2 CSS -->
	<link href="{{ URL::asset('resources/views/layouts/assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>

	<!-- sweetalert -->
	<link href="{{ URL::asset('vendors/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">

	<!-- TABS -->
	<link href="{{ URL::asset('resources/views/layouts/assets/plugins/tabs/tabs.css') }}" rel="stylesheet" />
	
	<!-- TIME PICKER CSS -->
	<link href="../assets/plugins/time-picker/time-picker.css" rel="stylesheet"/>

	</head>

	<body class="app">

		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="{{ URL::asset('resources/views/layouts/assets/images/svgs/loader.svg') }}" class="loader-img" alt="Loader">
		</div>
		

		<div class="page">
			<div class="page-main">
				<!-- HEADER -->
				<div class="header app-header">
					<div class="container-fluid">
						<div class="d-flex header-nav">
							<div class="color-headerlogo">
								<a class="header-desktop" href="index.html"></a>
								<a class="header-mobile" href="index.html"></a>
							</div><!-- Color LOGO -->
							<a href="#" data-toggle="sidebar" class="nav-link icon toggle"><i class="fe fe-align-justify"></i></a>
							<div class="">
								<form class="form-inline">
									<div class="search-element">
										<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
										<button class="btn btn-primary-color" type="submit"><i class="fe fe-search"></i></button>
									</div>
								</form>
							</div><!-- SEARCH -->
							<div class="d-flex order-lg-2 ml-auto header-right-icons header-search-icon">
								<div class="dropdown  search-icon">
									<a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch">
										<i class="fe fe-search"></i>
									</a>
								</div>
							    <div class="dropdown  header-fullscreen">
									<a class="nav-link icon full-screen-link nav-link-bg" id="fullscreen-button">
										<i class="fe fe-minimize" ></i>
									</a>
								</div><!-- MESSAGE-BOX -->
								<div class="dropdown header-user">
									<a href="#" class="nav-link icon" data-toggle="dropdown">
										<span><img src="{{ URL::asset('resources/views/layouts/assets/images/users/male/2.jpg') }}" alt="profile-user" class="avatar brround cover-image mb-0 ml-0"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<div class=" dropdown-header noti-title text-center border-bottom p-3">
											<div class="header-usertext">
												<h5 class="mb-1">Jacob Allan</h5>
												<p class="mb-0">Web Developer</p>
											</div>
										</div>
										<a class="dropdown-item" href="profile.html">
											<i class="mdi mdi-account-outline mr-2"></i> <span>My profile</span>
										</a>
										<a class="dropdown-item" href="#">
											<i class="mdi mdi-settings mr-2"></i> <span>Settings</span>
										</a>
										<a class="dropdown-item" href="#">
											<i class="fe fe-calendar mr-2"></i> <span>Activity</span>
										</a>
										<a class="dropdown-item" href="#">
											<i class="mdi mdi-compass-outline mr-2"></i> <span>Support</span>
										</a>
										<a class="dropdown-item" href="login.html">
											<i class="mdi  mdi-logout-variant mr-2"></i> <span>Logout</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- HEADER END -->

				
				<!-- Sidebar menu-->
				<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
				<aside class="app-sidebar">
					<div class="side-tab-body p-0 border-0" id="sidemenu-Tab">
						<div class="first-sidemenu">
							<ul class="resp-tabs-list hor_1">
								<?php $userid=Auth::User()->id;?>
								<li><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">{{ trans('app.Dashboard')}}</span></li>
								<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Inventory',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">{{ trans('app.Inventory')}}</span></li>
								@endif
								<li><i class="side-menu__icon fe fe-edit"></i><span class="side-menu__label">{{ trans('app.Users')}}</span></li>
								<?php   $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Vehicles',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-package"></i><span class="side-menu__label">Vehicles</span></li>
								@endif
								<li><i class="side-menu__icon fe fe-stop-circle"></i><span class="side-menu__label">Texnika egalari </span></li>
								<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Services',$userid)=='yes')
                 				<li><i class="fa fa-slack image_icon"></i><span class="side-menu__label"> {{ trans('app.Services')}} </span></li>
                 				@endif
                 				<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Invoices',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-file-text"></i><span class="side-menu__label">{{ trans('app.Invoices')}}</span></li>
								@endif

								<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Job Card',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-tablet"></i><span class="side-menu__label">Job Card</span></li>
								@endif

				 				<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Accounts & Tax Rates',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-life-buoy"></i><span class="side-menu__label">{{ trans('app.Accounts & Tax Rates')}}</span></li>
								@endif

								<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Sales',$userid)=='yes')
								@if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')
								<li><i class="side-menu__icon fe fe-shopping-cart"></i><span class="side-menu__label">{{ trans('app.Sales')}}</span></li>
								@else
								<li><i class="side-menu__icon fe fe-info"></i><span class="side-menu__label">{{ trans('app.Purchase')}}</span></li>
								@endif
								@endif

								<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Compliance',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-info"></i><span class="side-menu__label">{{ trans('app.Compliance')}}</span></li>
								@endif

								<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Reports',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-info"></i><span class="side-menu__label">{{ trans('app.Reports')}}</span></li>
								@endif

								<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Email Templates',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-info"></i><span class="side-menu__label">{{ trans('app.Email Templates')}}</span></li>
								@endif

								<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Custom Fields',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-info"></i><span class="side-menu__label">{{ trans('app.Custom Fields')}}</span></li>
								@endif

								<?php $userid=Auth::User()->id;?>
								@if (getAccessStatusUser('Observation library',$userid)=='yes')
								<li><i class="side-menu__icon fe fe-info"></i><span class="side-menu__label">{{ trans('app.Observation library')}}</span></li>
								@endif
							</ul>
						</div>
						<div class="second-sidemenu">
							<div class="resp-tabs-container hor_1">
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side1" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side2" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side3" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side4" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">	
													<div class="tab-content">
														<div class="tab-pane active" id="side1">
															<h5 class="mt-3 mb-4">{{ trans('app.Dashboard')}}</h5>
															<a href="{!! url('/') !!}"><i class="fa fa-home"></i> {{ trans('app.Dashboard')}} </a>
														</div>													
													</div>									
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side11" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side21" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side13" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side14" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side11">
															<h5 class="mt-3 mb-4">{{ trans('app.Inventory')}}</h5>
															<a class="slide-item" href="{!! url('/supplier/list')!!}">{{ trans('app.Supplier')}} </a>
															<a class="slide-item" href="{!! url('/product/list') !!}">{{ trans('app.Product')}}</a>
															<a class="slide-item" href="{!! url('/purchase/list')!!}">{{ trans('app.Purchase')}}</a>
															<a class="slide-item" href="{!! url('/stoke/list')!!}"> {{ trans('app.Stock')}}</a>
														</div>													
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side21" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side22" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side23" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side24" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>												
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side21">
															<h5 class="mt-3 mb-4">{{ trans('app.Users')}}</h5>
															<?php $userid=Auth::User()->id;?>
				    										 @if (getAccessStatusUser('Customers',$userid)=='yes')
															<a href="{!! url('/customer/list')!!}" class="slide-item">{{ trans('app.Customers')}}</a>
															@endif
															
															<?php $userid=Auth::User()->id;?>
				     										@if (getAccessStatusUser('Employees',$userid)=='yes')
															<a href="{!! url('/employee/list')!!}" class="slide-item">{{ trans('app.Employees')}}</a>
															@endif

															<?php $userid=Auth::User()->id;?>
				     										@if (getAccessStatusUser('Support Staffs',$userid)=='yes')
															<a href="{!! url('/supportstaff/list')!!}" class="slide-item">{{ trans('app.Support Staff')}}</a>
															@endif
				    										
				    										<?php $userid=Auth::User()->id;?>
				     										@if (getAccessStatusUser('Accountants',$userid)=='yes')
                      										<a href="{!! url('/accountant/list')!!}" class="slide-item">{{ trans('app.Accountant')}}</a>
				     										@endif
														</div>														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="resp-tab-content-active">
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side31" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side32" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side33" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side34" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>	
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side31">
															<h5 class="mt-3 mb-4">{{ trans('app.Vehicles')}}</h5>
															<?php   $userid=Auth::User()->id;?>
															@if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')
				  											<a href="{!! url('/vehicle/list') !!}" class="slide-item">{{ trans('app.List Vehicle')}}</a>
                      										<a href="{!! url('/vehicletype/list') !!}" class="slide-item">{{ trans('app.List Vehicle Type')}}</a>
                      										<a href="{!! url('/vehiclebrand/list') !!}" class="slide-item">{{ trans('app.List Vehicle Brand')}}</a>
					  										<a href="{!! url('/color/list') !!}" class="slide-item"> {{ trans('app.Colors')}}</a>
					  										@else					  										
					  										<a href="{!! url('/vehicle/list') !!}" class="slide-item">{{ trans('app.Vehicles')}} </a>
					  										@endif
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side31" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side32" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side33" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side34" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side-21">
															<h5 class="mt-3 mb-4">Texnika egalari</h5>
															<a href="{!! url('/customer/list') !!}" class="slide-item">Tenika egalari ro'yxati</a>
															<a href="{!! url('/customercategory/list') !!}" class="slide-item">Kategoriyalar</a>															
														</div>												
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side41" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side42" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side43" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side44" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side41">
															<h5 class="mt-3 mb-4">{{ trans('app.Services')}}</h5>							
															<a href="{!! url('/service/list') !!}	" class="slide-item">{{ trans('app.Services')}}</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side51" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side52" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side53" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side54" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side51">
															<h5 class="mt-3 mb-4">{{ trans('app.Invoices')}}</h5>
															<a href="{!! url('/invoice/list') !!}" class="slide-item">{{ trans('app.Invoices')}}</a>
														</div>														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">	
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side61" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side62" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side63" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side64" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>									
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side61">
															<h5 class="mt-3 mb-4">{{ trans('app.Job Card')}}</h5>
															<a href="{!! url('/jobcard/list')!!}" class="slide-item">{{ trans('app.Job Card')}}</a>
															<a href="{!! url('/gatepass/list')!!}" class="slide-item">{{ trans('app.Gate Pass')}}</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side71" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side72" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side73" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side74" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>											
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side71">
															<h5 class="mt-3 mb-4">{{ trans('app.Accounts & Tax Rates')}}</h5>
															<a href="{!! url('/taxrates/list') !!}" class="slide-item">{{ trans('app.List Tax Rates')}}</a>
															<a href="{!! url('/payment/list') !!}" class="slide-item">{{ trans('app.List Payment Method')}}</a>
															<a href="{!! url('/income/list')!!}" class="slide-item">{{ trans('app.Income')}}</a>
															<a href="{!! url('/expense/list')!!}" class="slide-item">{{ trans('app.Expenses')}}</a>
														</div>													
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side81" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side82" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side83" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side84" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side41">
															<?php $userid=Auth::User()->id;?>
															@if (getAccessStatusUser('Sales',$userid)=='yes')
																@if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')
																<h5 class="mt-3 mb-4">{{ trans('app.Sales')}}</h5>					
																<a href="{!! url('/sales/list') !!}	" class="slide-item">{{ trans('app.Sales')}}</a>
																@else
																<h5 class="mt-3 mb-4">{{ trans('app.Purchase')}}</h5>
																<a href="{!! url('/sales/list') !!}	" class="slide-item">{{ trans('app.Purchase')}}</a>
																@endif
																@endif											
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side91" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side92" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side93" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side94" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side91">
															<h5 class="mt-3 mb-4">{{ trans('app.Compliance')}}</h5>							
															<a href="{!! url('/rto/list') !!}" class="slide-item">{{ trans('app.Compliance')}}</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side101" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side102" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side103" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side104" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side101">
															<h5 class="mt-3 mb-4">{{ trans('app.Reports')}}</h5>							
															<a href="{!! url('/report/salesreport') !!}" class="slide-item">{{ trans('app.Reports')}}</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side111" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side112" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side113" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side114" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side111">
															<h5 class="mt-3 mb-4">{{ trans('app.Email Templates')}}</h5>				
															<a href="{!! url('/mail/mail') !!}" class="slide-item">{{ trans('app.Email Templates')}}</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side121" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side122" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side123" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side124" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side121">
															<h5 class="mt-3 mb-4">{{ trans('app.Custom Fields')}}</h5>						
															<a href="{!! url('/setting/custom/list') !!}" class="slide-item">{{ trans('app.Custom Fields')}}</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel sidetab-menu">
												<div class="tab-menu-heading p-0 pb-2 border-0">
													<div class="tabs-menu ">
														<!-- Tabs -->
														<ul class="nav panel-tabs">
															<li class=""><a href="#side131" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Home</a></li>
															<li><a href="#side132" data-toggle="tab" ><i class="fe fe-message-square"></i>Chat</a></li>
															<li><a href="#side133" data-toggle="tab"><i class="fe fe-calendar "></i>Events</a></li>
															<li><a href="#side134" data-toggle="tab"><i class="fe fe-codepen "></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side131">
															<h5 class="mt-3 mb-4">{{ trans('app.Observation library')}}</h5>			
															<a href="{!! url('/observation/list') !!}" class="slide-item">{{ trans('app.Observation library')}}</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</aside>
				<!--sidemenu end-->
				</div>
				@yield('content')
		 	
			</div>

		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>

		<!-- JQUERY SCRIPTS JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>

		<!-- BOOTSTRAP SCRIPTS JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>

		<!-- SPARKLINE JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery.sparkline.min.js') }}"></script>

		<!-- CHART-CIRCLE JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/circle-progress.min.js') }}"></script>

		<!-- RATING STAR JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/rating/rating-stars.js') }}"></script>

		<!--- TABS JS -->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
		<script src=".{{ URL::asset('resources/views/layouts/assets/plugins/tabs/tab-content.js') }}"></script>

		<!-- Custom Theme Scripts -->
    	<script src="{{ URL::asset('build/js/custom.min.js') }}" defer="defer"></script>
		<script src="{{ URL::asset('vendors/sweetalert/sweetalert.min.js')}}"></script>

		<!-- C3 CHART JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/charts-c3/c3-chart.js') }}"></script>

		<!-- INPUT MASK JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/input-mask/input-mask.min.js') }}"></script>

        <!-- P-SCROLL JS -->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/p-scroll/p-scroll.js') }}"></script>
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/p-scroll/p-scroll-leftmenu.js') }}"></script>

		<!--SIDEMENU JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/sidemenu/sidemenu.js') }}"></script>

		<!-- SIDEMENU-RESPONSIVE-TABS JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/sidemenu-responsive-tabs/js/sidemenu-responsive-tabs.js') }}"></script>

		<!--- TABS JS -->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/tabs/tab-content.js') }}"></script>

		<!--LEFT-MENU JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/js/left-menu.js') }}"></script>

		<!-- SIDEBAR JS -->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/right-sidebar/right-sidebar.js') }}"></script>

		<!-- SELECT2 JS -->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/select2/select2.full.min.js') }}"></script>
		
		
		<!-- TIMEPICKER JS -->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/time-picker/time-picker.js') }}"></script>
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/time-picker/toggles.min.js') }}"></script>


		<!-- SELECT2 JS -->
		<script src="{{ URL::asset('resources/views/layouts/assets/js/select2.js') }}"></script>

		<!-- FILE UPLOADES JS -->
        <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fileupload/js/fileupload.min.js') }}"></script>
        <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fileupload/js/file-upload.js') }}"></script>

		<!-- MULTI SELECT JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/multipleselect/multiple-select.js') }}"></script>
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/multipleselect/multi-select.js') }}"></script>

		<script src="{{ URL::asset('build/js/jquery-editable-select.js') }}"></script>

		<!-- CUSTOM JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/js/custom.js') }}"></script>

	</body>
</html>
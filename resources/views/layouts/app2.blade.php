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
		<title>Slica</title>
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

	<!-- SELECT2 CSS -->
	<link href="{{ URL::asset('resources/views/layouts/assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>

	<!-- TABS -->
	<link href="{{ URL::asset('resources/views/layouts/assets/plugins/tabs/tabs.css') }}" rel="stylesheet" />
	
	<!-- TIME PICKER CSS -->
	<link href="../assets/plugins/time-picker/time-picker.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/myStyle.css') }}">
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
															<li><a href="#side43" data-toggle="tab"><i class="fe fe-calendar"></i>Events</a></li>
															<li><a href="#side44" data-toggle="tab"><i class="fe fe-codepen"></i>Activity</a></li>
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body p-0 border-0">
													<div class="tab-content">
														<div class="tab-pane active " id="side41">
															<h5 class="mt-3 mb-4">Pages</h5>
															<a href="profile.html" class="slide-item">Profile</a>
															<a href="editprofile.html" class="slide-item">Edit Profile</a>
															<a href="empty.html" class="slide-item">Empty Page</a>
															<a href="gallery.html" class="slide-item">Gallery</a>
															<a href="about.html" class="slide-item">About Company</a>
															<a href="services.html" class="slide-item">Services</a>
															<a href="faq.html" class="slide-item">FAQS</a>
															<a href="terms.html" class="slide-item">Terms</a>
															<a href="invoice.html" class="slide-item">Invoice</a>
															<a href="pricing.html" class="slide-item">Pricing Tables</a>
															<a href="blog.html" class="slide-item">Blog</a>
															<h5 class="mt-5 mb-4">Account</h5>
															<ul class="side-account">
																<li class="acc-link" >
																	<a href="#">
																		<i class="fe fe-download text-primary mr-2 fs-20"></i> Downloads
																	</a>
																</li>
																<li class="acc-link" >
																	<a href="#">
																		<i class="fe fe-folder-plus text-secondary mr-2 fs-20"></i> Archive
																	</a>
																</li>
																<li class="acc-link" >
																	<a href="#">
																		<i class="fe fe-rss text-danger mr-2 fs-20"></i> Feed Manager
																	</a>
																</li>
																<li class="acc-link" >
																	<a href="#">
																		<i class="fe fe-settings text-warning mr-2 fs-20"></i> Settings
																	</a>
																</li>
															</ul>
														</div>
														<div class="tab-pane  " id="side42">
															<h5 class="mt-3 mb-4">Chat</h5>
															<div class="input-group  mb-4">
																<input type="text" class="form-control" placeholder="Search ...">
																<span class="input-group-append">
																	<button class="btn btn-primary" type="button">Search</button>
																</span>
															</div>
															<div class=" ">
																<div class="list-group-item d-flex  align-items-center p-1 ">
																	<div class="mr-3">
																		<span class="avatar avatar-lg brround cover-image" data-image-src="../assets/images/users/female/2.jpg"><span class="avatar-status bg-green"></span></span>
																	</div>
																	<div>
																		<strong>Madeleine</strong> Hey! there I' am available....
																		<div class="small text-muted">
																			3 hours ago
																		</div>
																	</div>
																</div>
																<div class="list-group-item d-flex  align-items-center p-2">
																	<div class="mr-3">
																		<span class="avatar avatar-lg brround cover-image" data-image-src="../assets/images/users/male/2.jpg"></span>
																	</div>
																	<div>
																		<strong>Anthony</strong> New product Launching...
																		<div class="small text-muted">
																			5 hour ago
																		</div>
																	</div>
																</div>
																<div class="list-group-item d-flex  align-items-center p-2">
																	<div class="mr-3">
																		<span class="avatar avatar-lg brround cover-image" data-image-src="../assets/images/users/female/9.jpg"><span class="avatar-status bg-green"></span></span>
																	</div>
																	<div>
																		<strong>Olivia</strong> New Schedule Realease......
																		<div class="small text-muted">
																			45 mintues ago
																		</div>
																	</div>
																</div>
																<div class="list-group-item d-flex  align-items-center p-2">
																	<div class="mr-3">
																		<span class="avatar avatar-lg brround cover-image" data-image-src="../assets/images/users/female/1.jpg"><span class="avatar-status bg-green"></span></span>
																	</div>
																	<div>
																		<strong>Madeleine</strong> Hey! there I' am available....
																		<div class="small text-muted">
																			3 hours ago
																		</div>
																	</div>
																</div>
																<div class="list-group-item d-flex  align-items-center p-2">
																	<div class="mr-3">
																		<span class="avatar avatar-lg brround cover-image" data-image-src="../assets/images/users/male/1.jpg"></span>
																	</div>
																	<div>
																		<strong>Anthony</strong> New product Launching...
																		<div class="small text-muted">
																			5 hour ago
																		</div>
																	</div>
																</div>
																<div class="list-group-item d-flex  align-items-center p-2">
																	<div class="mr-3">
																		<span class="avatar avatar-lg brround cover-image" data-image-src="../assets/images/users/female/5.jpg"><span class="avatar-status bg-green"></span></span>
																	</div>
																	<div>
																		<strong>Lily May</strong> New Schedule Realease......
																		<div class="small text-muted">
																			45 mintues ago
																		</div>
																	</div>
																</div>
																<div class="list-group-item d-flex  align-items-center p-2">
																	<div class="mr-3">
																		<span class="avatar avatar-lg brround cover-image" data-image-src="../assets/images/users/male/4.jpg"><span class="avatar-status bg-green"></span></span>
																	</div>
																	<div>
																		<strong>Eric Walsh</strong> Okay...I will be waiting for you
																		<div class="small text-muted">
																			12 mintues ago
																		</div>
																	</div>
																</div>
																<div class="list-group-item d-flex  align-items-center p-2">
																	<div class="mr-3">
																		<span class="avatar avatar-lg brround cover-image" data-image-src="../assets/images/users/female/1.jpg"></span>
																	</div>
																	<div>
																		<strong>Alison White</strong> Hi we can explain our new project......
																		<div class="small text-muted">
																			45 mintues ago
																		</div>
																	</div>
																</div>
																<div class="list-group-item d-flex  align-items-center p-2">
																	<div class="mr-3">
																		<span class="avatar avatar-lg brround cover-image" data-image-src="../assets/images/users/male/7.jpg"><span class="avatar-status bg-green"></span></span>
																	</div>
																	<div>
																		<strong>Jacob Lewis</strong> New product Launching...
																		<div class="small text-muted">
																			45 mintues ago
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="tab-pane" id="side43">
															<h5 class="mt-3 mb-4">Event</h5>
															<div class="latest-timeline">
																<div class="timeline">
																	<div class="mt-0 event-text">
																		<h6 class="mb-0"><a target="_blank" href="#" class="timeline-head">Employees Meeting</a></h6>
																		<span class="fs-11 text-muted mb-2">23 May, 2019</span>
																		<p class="fs-11">sed do eiusmod tempor incididunt ut labore et . </p>
																	</div>
																	<div class="event-text">
																		<h6 class="mb-0"><a href="#" class="timeline-head">Ramazan Festival  Celebration</a></h6>
																		<span class="mb-2 fs-11 text-muted">21 May, 2019</span>
																		<p class="">sed do eiusmod tempor  magna aliqua nisi ut . </p>
																	</div>
																	<div class="event-text">
																		<h6 class="mb-0"><a href="#" class="timeline-head">Best Employee Announcement</a></h6>
																		<span class="mb-2 fs-11 text-muted">18 May, 2019</span>
																		<p class="">sed do eiusmod tempor incididunt ut aliquip.</p>
																	</div>
																	<div class="event-text">
																		<h6 class="mb-0"><a href="#" class="timeline-head">Weekend trip</a></h6>
																		<span class="mb-2 fs-11 text-muted">16 May, 2019</span>
																		<p class="">sed do eiusmod tempor incididunt ut aliquip.</p>
																	</div>
																	<div class="event-text">
																		<h6 class="mb-0"><a href="#" class="timeline-head">New Project Started..</a></h6>
																		<span class="mb-2 fs-11 text-muted">15 May, 2019</span>
																		<p class="">sed do eiusmod tempor incididunt ut aliquip.</p>
																	</div>
																	<div class="mb-0 event-text">
																		<h6 class="mb-0"><a href="#" class="timeline-head">Gradening working</a></h6>
																		<span class="mb-2 fs-11 text-muted">07 May, 2019</span>
																		<p class="">sed do eiusmod tempor  aliqua nisi ut aliquip . </p>
																	</div>
																</div>
															</div>
														</div>
														<div class="tab-pane" id="side44">
															<h5 class="mt-3 mb-4">Activity</h5>
															<div class="activity mt-3">
																<img src="../assets/images/users/male/1.jpg" alt="" class="img-activity">
																<div class="time-activity">
																	<div class="item-activity">
																		<p class="mb-0"><b>Adam	Berry</b> Add a new projects <b> AngularJS Template</b></p>
																		<small class="text-muted ">30 mins ago</small>
																	</div>
																</div>
																<img src="../assets/images/users/female/2.jpg" alt="" class="img-activity">
																<div class="time-activity">
																	<div class="item-activity">
																		<p class="mb-0"><b>Irene Hunter</b> Add a new projects <b>Free HTML Template</b></p>
																		<small class="text-muted ">1 days ago</small>
																	</div>
																</div>
																<img src="../assets/images/users/male/3.jpg" alt="" class="img-activity">
																<div class="time-activity">
																	<div class="item-activity">
																		<p class="mb-0"><b>John	Payne</b> Add a new projects <b>Free PSD Template</b></p>
																		<small class="text-muted ">3 days ago</small>
																	</div>
																</div>
																<img src="../assets/images/users/female/4.jpg" alt="" class="img-activity">
																<div class="time-activity">
																	<div class="item-activity mb-0">
																		<p class="mb-0"><b>Julia Hardacre</b> Add a new projects <b>Free UI Template</b></p>
																		<small class="text-muted ">5 days ago</small>
																	</div>
																</div>
																<img src="../assets/images/users/male/5.jpg" alt="" class="img-activity">
																<div class="time-activity">
																	<div class="item-activity">
																		<p class="mb-0"><b>Adam	Berry</b> Add a new projects <b> AngularJS Template</b></p>
																		<small class="text-muted ">30 mins ago</small>
																	</div>
																</div>
																<img src="../assets/images/users/female/6.jpg" alt="" class="img-activity">
																<div class="time-activity">
																	<div class="item-activity">
																		<p class="mb-0"><b>Irene Hunter</b> Add a new projects <b>Free HTML Template</b></p>
																		<small class="text-muted ">1 days ago</small>
																	</div>
																</div>
																<img src="../assets/images/users/male/7.jpg" alt="" class="img-activity">
																<div class="time-activity">
																	<div class="item-activity">
																		<p class="mb-0"><b>John	Payne</b> Add a new projects <b>Free PSD Template</b></p>
																		<small class="text-muted ">3 days ago</small>
																	</div>
																</div>
																<img src="../assets/images/users/female/8.jpg" alt="" class="img-activity">
																<div class="time-activity">
																	<div class="item-activity mb-0">
																		<p class="mb-0"><b>Julia Hardacre</b> Add a new projects <b>Free UI Template</b></p>
																		<small class="text-muted ">5 days ago</small>
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
				<div class="app-content">
					<div class="section">
				<!-- PAGE-HEADER -->
				<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="#"><i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Vehicle')}}</a>
						</li>
					</ol>
				</div>
				<!-- PAGE-HEADER END -->
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
														<i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
														{{ trans('app.Add Vehicle')}}</b>
													</a>
												</li>
											</ul>
									</div>
								</div>
								<div class="row">
			<div class="col-md-12">
				<div class="card">									
					<div class="card-body p-6">
						<form action="javascript:void(0);" id="technical-passport-form">
							<div class="row">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="col-md-6">
									<label class="form-label" style="visibility: hidden;">asd</label>
									<div class="row">
										<div class="col-6 pr-0">
											<div class="customer-type-button selected py-2" val="give">
												Berish
											</div>
										</div>
										<div class="col-6 pl-0">
											<div class="customer-type-button py-2" val="recover">
												Qayta tiklash
											</div>
										</div>
									</div>
								</div>								
								<div class="col-6 form-group">
									<label class="form-label">Guvohnoma egasi</label>
									<select class="form-control select-customer" name="customer_id">
										<option value="">
										</option>
									</select>
								</div>
								<div class="col-6 form-group">
									<label class="form-label">Guvohnoma toifasi</label>
									<select class="form-control select-type custom-select" name="type" required="required">
										<option value="1">1 (Yuridik o'ziyurarlar uchun)</option>
										<option value="2">2 (Jismoniy o'ziyurarlar uchun)</option>
										<option value="3">3 (Yuridik tirkamalar uchun)</option>
										<option value="4">4 (Jismoniy tirkamalar uchun)</option>
									</select>
								</div>
								<div class="col-2 form-group">
									<label class="form-label">Seriya</label>
									<input class="form-control" type="text" name="series" pattern="[A-Z]{3}" onkeyup="this.value=this.value.toUpperCase()" pla/>
								</div>
								<div class="col-4 form-group">
									<label class="form-label">Raqam</label>
									<input class="form-control" type="text" name="number" required="required" />
								</div>
								<div class="col-4 form-group">
									<label class="form-label">Davlat raqami berilgan sana</label>
									<input class="form-control given-date" name="given_date" placeholder="yyyy-mm-dd" required="required">
								</div>
								<div class="col-4 form-group">
									<label class="form-label">Umumiy summa</label>
									<input class="form-control" type="number" name="total_amount" min="0" step="100">
								</div>
								<div class="col-4 form-group">
									<label class="form-label">To'langan summa</label>
									<input class="form-control" type="number" name="paid_amount" min="0" step="100">
								</div>
								<div class="col-12">
									<button class="btn btn-success" type="submit">Saqlash</button>
									<button class="btn btn-success" type="submit">Saqlash</button>
									<button class="btn btn-success" type="submit">Saqlash</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
								</form>			
							</div>
						</div>
					</div>
				</div>
			</div>




<script type="text/javascript">
$('document').ready({
	$('select.customer_category').select2({
	});
	$('.condition').select2({
	    minimumResultsForSearch: Infinity
	});
});</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('select.select-customer').select2({
			ajax:{
				url:'/customer/search',
				delay:300,
				dataType:'json',
				data:function(params){
					return{
						search:params.term
					}
				},
				processResults:function(data){
					console.log(data);
					data=data.map((item,index)=>{
						return {
							id:item.id,
							text:item.name+' '+(item.lastname?item.lastname:'')+' ('+item.ownership_form+')'
						}
					});
					return{
						results:data
					}
				}
			},
			placeholder:'Texnika egasini kiriting',
			minimumInputLength:1,
			escapeMarkup: function (markup) { return markup; },
			language:{
				inputTooShort:function(){
					return 'Mulk egasini nomi,INN raqami,STIR kiritib izlang';
				},
				searching:function(){
					return 'Izlanmoqda...';
				},
				noResults:function(){
					return "Natija topilmadi"
				}
			}
		});

		$('select.select-transport').select2({
			minimumResultsForSearch: Infinity,
			escapeMarkup: function (markup) { return markup; },
			templateResult:transportFormat,
			templateSelection:transportFormat,
			placeholder:'Texnika tanlang',
			language:{
				searching:function(){
					return 'Izlanmoqda...';
				},
				noResults:function(){
					return "Natija topilmadi"
				}
			}
		});

		function transportFormat(result){
			console.log('formatting',result);
			if(result.loading){
				return result.text;
			}
			var number=$(result.element).attr('number');
			console.log(number);
			if(number){
				return result.text+'<span title="Davlat raqami: '+number+'" class="alert-for-number text-danger float-right">Davlat raqami berilgan!</span>'
			}else{
				return result.text;
			}
		}

		$('select.select-customer').change(function(){
			var customerId=$(this).val();
			$.ajax({
				url:'/vehicle/find-by-owner',
				data:{
					customer_id:customerId
				},
				success:function(data){
					console.log(data);
					$('select.select-transport').html('<option value="">Texnika tanlang</option>'+data);
				}
			});
		});

		$('select.select-transport').change(function(){
			var th=$(this)
			var number=th.find('option:selected').attr('number');
			if(number && !$('.customer-type-button[val="recover"]').is('.selected')){
				swal({
					text:'Tanlangan texnikaga davlat raqami berilgan ('+number+'). Davom etish uchun quyidagilardan birini tanlang',
					type:'info',
					title:'',
					showCancelButton:true,
					confirmButtonText:'Davlat raqamini qayta tiklash',
					cancelButtonText:'Boshqa texnika tanlash'
				},function(result){
					console.log('result',result);
					if(result){
						$('.customer-type-button').removeClass('selected').filter('[val="recover"]').addClass('selected');
					}else{
						th.find('option').first().attr('selected','selected');
						console.log('val',th.val());
					}
				});
			}
		});

		$('div.customer-type-button').on('click',(e)=>{
			var cType=$(e.target).attr('val');
			console.log('customer type selected',cType);
			if(cType=='give'){
				$('div.customer-type-button[val="give"]').addClass('selected');
				$('div.customer-type-button[val="recover"]').removeClass('selected');
			}else if(cType=='recover'){
				$('div.customer-type-button[val="give"]').removeClass('selected');
				$('div.customer-type-button[val="recover"]').addClass('selected');
			}
		});

	    $("input.given-date").datetimepicker({
			format: "yyyy-mm-dd",
			autoclose: 1,
			minView: 2,
			startView:'decade',
			endDate: new Date()
		});

		$('#technical-passport-form').on('submit',function(){
			var submitButton=$(this).find('button[type="submit"]');
			submitButton.addClass('btn-loading');
			var formArray=$(this).serializeArray();
			formArray.push({
				name:'action',
				value:$('.customer-type-button.selected').attr('val')
			});
			console.log(formArray);
			$.ajax({
				url:'/vehicle/technical-passport',
				type:'POST',
				data:formArray,
				success:function(data){
					submitButton.removeClass('btn-loading');
					if(data=='success'){
						swal('Saqlandi!','','success');
					}else{
						swal('Xatolik!','','error');
					}
				}
			});
		});

		$('.state-edit').on('click',function(){
			var stateName=$(this).parent().siblings().filter('.state-name');
			var stateCode=$(this).parent().siblings().filter('.state-code');
			stateName.html('<input class="form-control" value="'+stateName.text()+'" />');
			stateCode.html('<input class="form-control" value="'+stateCode.text()+'" />');
		});
	});
</script>
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

		<!-- DATEPICKER JS -->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/date-picker/date-picker.js') }}"></script>
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/date-picker/jquery-ui.js') }}"></script>
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/input-mask/input-masked.js') }}"></script>

		<!-- SELECT2 JS -->
		<script src="{{ URL::asset('resources/views/layouts/assets/js/select2.js') }}"></script>

		<!-- FILE UPLOADES JS -->
        <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fileupload/js/fileupload.min.js') }}"></script>
        <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fileupload/js/file-upload.js') }}"></script>

		<!-- MULTI SELECT JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/multipleselect/multiple-select.js') }}"></script>
		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/multipleselect/multi-select.js') }}"></script>


		<!-- CUSTOM JS-->
		<script src="{{ URL::asset('resources/views/layouts/assets/js/custom.js') }}"></script>
		<script src="{{ URL::asset('build/js/control.js') }}"></script>

	</body>
</html>
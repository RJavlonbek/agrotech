<DOCTYPE html>

<html lang="en" dir="ltr">

	<head>



		<!-- Meta data -->

		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>

		<meta content="Slica – Bootstrap Responsive Flat Admin Dashboard HTML5 Template" name="description">

		<meta content="Spruko Technologies Private Limited" name="author">

		<meta name="keywords" content="admin site template, html admin template,responsive admin template, admin panel template, bootstrap admin panel template, admin template, admin panel template, bootstrap simple admin template premium, simple bootstrap admin template, best bootstrap admin template, simple bootstrap admin template, admin panel template,responsive admin template, bootstrap simple admin template premium"/>



		<!--favicon -->

		<link rel="icon" href="{{ URL::asset('resources/views/layouts/assets/images/LS.png') }}" type="image/x-icon"/>



		<!-- TITLE -->

		<title>@if(!empty($title)){{$title." |"}} @endif  {{ getNameSystem() }}</title>

		<link href="{{ URL::asset('resources/views/layouts/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

		

		



		

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/style.css') }}">

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/skins-modes.css') }}">

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/sidemenu/sidemenu.css') }}">

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}">

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/p-scroll/p-scroll.css') }}">

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/icons.css') }}">

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/right-sidebar/right-sidebar.css') }}">

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/plugins/charts-c3/c3-chart.css') }}">

		<link rel="stylesheet" type="text/css" href="{{ URL::asset('build/css/bootstrap-datetimepicker.min.css') }}">



		<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/color-style.css') }}">



		<!-- SELECT2 CSS -->

		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />



		<!-- Data table css -->

		<link href="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />

		<link rel="stylesheet" href="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}">

		<link href="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />



		<!-- TABS -->

		<link href="{{ URL::asset('resources/views/layouts/assets/plugins/tabs/tabs.css') }}" rel="stylesheet" />



		

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

								<a class="header-desktop" href="/"></a>

								<a class="header-mobile" href="/"></a>

							</div><!-- Color LOGO -->

							<a href="#" data-toggle="sidebar" class="nav-link icon toggle"><i class="fe fe-align-justify"></i></a>

							<div class="" style="visibility: hidden;">

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

										<span><img src="{{ URL::asset('resources/views/layouts/assets/images/avatar.png') }}" alt="profile-user" class="avatar brround cover-image mb-0 ml-0"></span>

									</a>

									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

										<div class=" dropdown-header noti-title text-center border-bottom p-3">

											<div class="header-usertext">
												<?php $user=Auth::user(); ?>
												<a href="/user/list/{{$user->id}}"><h5 class="mb-1">{{$user->name.' '.$user->lastname}}</h5></a>
											</div>

										</div>
										<a class="dropdown-item" title="Logout" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">

							                <i class="mdi  mdi-logout-variant mr-2"></i><span>Tizimdan chiqish</span>

											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

													@csrf

											</form>

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

								<a style="color: white;" href="{!! url('/') !!}"><div class="mainMenu" style=""><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">{{ trans('app.Bosh sahifa')}}</span></div></a>

								<?php $userid=Auth::User()->id;?>

								@if (getAccessStatusUser('Inventory',$userid)=='yes')

								<li number="1"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">{{ trans('app.Xodimlar')}}</span></li>

								@endif

								<?php   $userid=Auth::User()->id;?>

								@if (getAccessStatusUser('Vehicles',$userid)=='yes')

								<li number="2"><i class="side-menu__icon fe fe-package"></i><span class="side-menu__label">{{ trans('app.Mulk egalari')}}</span></li>

								@endif

								<li number="3"><i class="side-menu__icon fe fe-truck"></i><span class="side-menu__label">{{ trans('app.Texnikalar')}} </span></li>

								<?php $userid=Auth::User()->id;?>

								@if (getAccessStatusUser('Invoices',$userid)=='yes')

								<li number="4"><i class="side-menu__icon fe fe-file-text"></i><span class="side-menu__label">{{ trans('app.Hujjatlar')}}</span></li>

								@endif

								<?php $userid=Auth::User()->id;?>

								@if (getAccessStatusUser('Services',$userid)=='yes')

                 				<li number="5"><i class="fa fa-slack image_icon"></i><span class="side-menu__label"> {{ trans('app.Services')}} </span></li>

                 				@endif

                 				



								



								<?php $userid=Auth::User()->id;?>

								@if (getAccessStatusUser('Reports',$userid)=='yes')

								<li number="6"><i class="side-menu__icon fa fa-file"></i><span class="side-menu__label">{{ trans('app.Vehicle Report')}}</span></li>

								@endif





								<?php $userid=Auth::User()->id;?>

								@if (getAccessStatusUser('Observation library',$userid)=='yes')

								<li number="7"><i class="side-menu__icon fe fe-info"></i><span class="side-menu__label">{{ trans('app.Boshqa bo\'limlar')}}</span></li>

								@endif

								<?php $userid=Auth::User()->id;?>

								 @if (getAccessStatusUser('Settings',$userid)=='yes')

									 @if(getActiveAdmin($userid)=='yes')

									 	<li number="8"><i class="side-menu__icon fe fe-settings"></i><span class="side-menu__label">{{ trans('app.Settings')}}</span></li>

									@else

										<li number="8"><i class="side-menu__icon fe fe-settings"></i><span class="side-menu__label">{{ trans('app.Settings')}}</span></li>

									@endif

								 @endif

					            <a style="color: white;"  href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
					            	<div class="mainMenu" style="">
					            		<i class="side-menu__icon fe fe-log-out"></i>
					            		<span class="side-menu__label">{{ trans('app.Tizimdan chiqish')}}</span>
					           			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
													@csrf
										</form>
									</div>
								</a>

							</ul>

						</div>

						<div class="second-sidemenu">

							<div class="resp-tabs-container hor_1">

								<div>

									<div class="row">

										<div class="col-md-12">

											<div class="panel sidetab-menu">

												<div class="panel-body tabs-menu-body p-0 border-0">

													<div class="tab-content">

														<div class="tab-pane active " id="side11">

															<h5 class="mt-3 mb-4">{{ trans('app.Employees')}}</h5>

															<a class="slide-item" href="#">{{ trans('app.Customers')}} </a>

															<a class="slide-item" href="#">{{ trans('app.Employees')}}</a>

															<a class="slide-item" href="#">{{ trans('app.Support staff')}}</a>

															<a class="slide-item" href="#"> {{ trans('app.Accountants')}}</a>

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

												<div class="panel-body tabs-menu-body p-0 border-0">

													<div class="tab-content">

														<div class="tab-pane active " id="side21">

															<h5 class="mt-3 mb-4">{{ trans('app.Mulk egalari')}}</h5>

															<?php $userid=Auth::User()->id;?>

				    										 @if (getAccessStatusUser('Customers',$userid)=='yes')

															<a href="{!! url('/customer/list?type=legal') !!}" class="slide-item">{{ trans('app.Yuridik shaxslar ro\'yxati')}}</a>

															@endif

															

															<?php $userid=Auth::User()->id;?>

				     										@if (getAccessStatusUser('Employees',$userid)=='yes')

															<a href="{!! url('/customer/list?type=physical') !!}" class="slide-item">{{ trans('app.Jismoniy shaxslar ro\'yxati')}}</a>

															@endif

															@if (getAccessStatusUser('Employees',$userid)=='yes')

															<a href="{!! url('/customer/list') !!}" class="slide-item">{{ trans('app.Barchasi')}}</a>

															@endif



															<?php $userid=Auth::User()->id;?>

				     										@if (getAccessStatusUser('Support Staffs',$userid)=='yes')

															<a href="{!! url('/customer/add')!!}" class="slide-item">{{ trans('app.Mulk egasini qo\'shish')}}</a>

															@endif

				    										

				    										<?php $userid=Auth::User()->id;?>

				     										@if (getAccessStatusUser('Accountants',$userid)=='yes')

                      										<a href="{!! url('/customer/category/list') !!}" class="slide-item">{{ trans('app.Mulk egasi kategoriyalari')}}</a>

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

															<li class="" style="width: 48%;"><a href="#side31" class="active" data-toggle="tab"><i class="fe fe-list"></i>{{ trans('app.Ro\'yxat')}}</a></li>

															<li style="width: 48%;"><a href="#side32" data-toggle="tab" ><i class="fe fe-plus-circle"></i>{{ trans('app.Qo\'shish')}}</a></li>

														</ul>

													</div>

												</div>

												<div class="panel-body tabs-menu-body p-0 border-0">

													<div class="tab-content">

														<div class="tab-pane active " id="side31">

															<h5 class="mt-3 mb-4">{{ trans('app.Ro\'yxat')}}</h5>

															<?php   $userid=Auth::User()->id;?>

															@if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')

				  											<a href="{!! url('/vehicle/list') !!}" class="slide-item">{{ trans('app.List Vehicle')}}</a>

                      										<a href="{!! url('/vehicletype/list') !!}" class="slide-item">{{ trans('app.List Vehicle Type')}}</a>

                      										<a href="{!! url('/vehiclebrand/list') !!}" class="slide-item">{{ trans('app.List Vehicle Brand')}}</a>

                      										<a href="{!! url('/workingtype/list') !!}" class="slide-item">{{ trans('app.List Vehicle WorkingType')}}</a>

                      										<a href="{!! url('/certificate/reglistoutof') !!}" class="slide-item">{{ trans('app.Hisobdan chiqarilgan texnikalar')}}</a>

					  										@else					  										

					  										<a href="{!! url('/vehicle/list') !!}" class="slide-item">{{ trans('app.Vehicles')}} </a>

					  										@endif

														</div>

														<div class="tab-pane " id="side32">

															<h5 class="mt-3 mb-4">{{ trans('app.Qo\'shish')}}</h5>

				  											<a href="{!! url('/vehicle/add') !!}" class="slide-item">{{ trans('app.Add Vehicle')}}</a>

															<a href="{!! url('/vehicletype/vehicletypeadd') !!}" class="slide-item">{{ trans('app.Add Vehicle Type')}}</a>

                      										<a href="{!! url('/vehiclebrand/add') !!}" class="slide-item">{{ trans('app.Add Vehicle Brand')}}</a>

                      										<a href="{!! url('/workingtype/add') !!}" class="slide-item">{{ trans('app.Add working type')}}</a>

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

												

												<div class="panel-body tabs-menu-body p-0 border-0">

													<div class="tab-content">

														<div class="tab-pane active " id="side-21">

															<h5 class="mt-3 mb-4">Hujjatlar</h5>

															<a href="{!! url('/driver-licence/give') !!}" class="slide-item">{{ trans('app.Haydovchilik guvohnomasi berish')}}</a>

															<a href="{!! url('/vehicle/transport-number') !!}" class="slide-item">

					  											{{ trans('app.Davlat raqami berish')}}

					  										</a>	

															<a href="{!! url('/vehicle/technical-passport') !!}" class="slide-item"> {{ trans('app.Texnik passport berish')}}</a>		

															<a href="{{ url('/certificate/add') }}" class="slide-item">{{ trans('app.Texnik guvohnoma berish') }} </a>	

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

												<div class="panel-body tabs-menu-body p-0 border-0">

													<div class="tab-content">

														<div class="tab-pane active " id="side41">

															<h5 class="mt-3 mb-4">{{ trans('app.Services')}}</h5>							

															<a href="{{ url('/certificate/medlist') }}" class="slide-item">{{ trans('app.Texnik ko\'rik') }} </a>

															<a href="{!! url('/vehicle/vehicle_lock') !!}" class="slide-item"> {{ trans('app.Taqiqqa olish')}}</a>

															<a href="{{ url('/certificate/reglist') }}" class="slide-item">{{ trans('app.Ro\'yxatga olish/chiqarish') }} </a>

															<a href="{!! url('/driver-exam') !!}" class="slide-item">Haydovchilik imtihonlari</a>	

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

															<li class="" style="width: 45%;"><a href="#side51" class="active" data-toggle="tab"><i class="fe fe-monitor"></i>Mavjud texnikalar</a></li>

															<li style="width: 45%;"><a href="#side52" data-toggle="tab" ><i class="fe fe-message-square"></i>Ro'yxatdan o'tgan</a></li>

															<li style="width: 45%;"><a href="#side53" data-toggle="tab"><i class="fe fe-calendar "></i>Yangi texnika</a></li>

															<li style="width: 45%;"><a href="#side54" data-toggle="tab"><i class="fe fe-codepen "></i>Talab</a></li>

														</ul>

													</div>

												</div>

												<div class="panel-body tabs-menu-body p-0 border-0">

													<div class="tab-content">

														<div class="tab-pane active" id="side51">

															<h5 class="mt-3 mb-4">Mavjud texnikalar</h5>

															<a href="{!! url('/report/exist') !!}" class="slide-item">Viloyat mavjud texnika</a>
															<a href="{!! url('/report/ownership?form=state') !!}" class="slide-item">Viloyat mulkchiligi</a>
															<a href="{!! url('/report/ownership?form=city') !!}" class="slide-item">Tuman / shahar mulkchiligi</a>

															<a href="#" class="slide-item">Kategoriya bo'yicha</a>

															<a href="#" class="slide-item">Texnka yoshi</a>

														</div>

														<div class="tab-pane " id="side52">

															<h5 class="mt-3 mb-4">Ro'yxatdan o'tgan/o'tmagan</h5>

															<a href="#" class="slide-item">Viloyat bo'yicha</a>

															<a href="#" class="slide-item">Tuman/shahar bo'yicha</a>

														</div>

														<div class="tab-pane" id="side53">

															<h5 class="mt-3 mb-4">Yangi texnika</h5>

															<a href="#" class="slide-item">Viloyat bo'yicha</a>

															<a href="#" class="slide-item">Tuman/shahar bo'yicha</a>

														</div>

														<div class="tab-pane" id="side54">

															<h5 class="mt-3 mb-4">Talab</h5>

															<a href="#" class="slide-item">Talab</a>

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

															<li class="" style="width: 48%;"><a href="#side771" class="active" data-toggle="tab"><i class="fe fe-list"></i>{{ trans('app.Ro\'yxat')}}</a></li>

															<li style="width: 48%;"><a href="#side772" data-toggle="tab" ><i class="fe fe-plus-circle"></i>{{ trans('app.Qo\'shish')}}</a></li>

														</ul>

													</div>

												</div>

												<div class="panel-body tabs-menu-body p-0 border-0">

													<div class="tab-content">

														<div class="tab-pane active " id="side771">

															<h5 class="mt-3 mb-4">{{ trans('app.Ro\'yxat')}}</h5>

															<?php   $userid=Auth::User()->id;?>

															@if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')

				  											<a href="{!! url('/factory/list') !!}" class="slide-item">{{ trans('app.List Vehicle Factory')}}</a>

															<a href="{{ url('/cities/list') }}" class="slide-item">{{ trans('app.Cities') }} </a>

															<a href="{{ url('/color/list') }}" class="slide-item">{{ trans('app.Colors') }} </a>

															<a href="{{ url('/supplier/list') }}" class="slide-item">{{ trans('app.Yetkazib beruvchilar') }} </a>
															<a href="{{ url('/locker/list') }}" class="slide-item">Taqiqqa oluvchilar</a>
															<a href="{{ url('/fuel/list') }}" class="slide-item">Yonilg'i turlari</a>

					  										@endif

														</div>

														<div class="tab-pane " id="side772">

															<h5 class="mt-3 mb-4">{{ trans('app.Qo\'shish')}}</h5>

				  											<a href="{!! url('/factory/add') !!}" class="slide-item">{{ trans('app.List Vehicle Factory')}}</a>

															<a href="{{ url('/cities/add') }}" class="slide-item">{{ trans('app.Cities') }} </a>

															<a href="{{ url('/color/add') }}" class="slide-item">{{ trans('app.Colors') }} </a>

															<a href="{{ url('/supplier/add') }}" class="slide-item">{{ trans('app.Yetkazib beruvchilar') }} </a>
															<a href="{{ url('/locker/add') }}" class="slide-item">Taqiqqa oluvchilar</a>
															<a href="{{ url('/fuel/add') }}" class="slide-item">Yonilg'i turlari</a>

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

																			

												<div class="panel-body tabs-menu-body p-0 border-0">

													<div class="tab-content">

														<div class="tab-pane active " id="side61">

															<h5 class="mt-3 mb-4">{{ trans('app.Job Card')}}</h5>

															<?php $userid=Auth::User()->id;?>

															 @if (getAccessStatusUser('Settings',$userid)=='yes')

																 @if(getActiveAdmin($userid)=='yes')

																	<a href="{!! url('/setting/general_setting/list') !!}" title="Settings" class="slide-item">{{ trans('app.Settings')}}</span></a>
																	<a href="{!! url('/payment/list') !!}" title="Settings" class="slide-item">To'lov sozlamalari</span></a>


																@else

																	<a href="{!! url('/setting/timezone/list') !!}" title="Settings" class="slide-item"> {{ trans('app.Settings')}}</span></a>

																@endif

															 @endif	

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

					@yield('content')

					<!-- CONTAINER CLOSED -->

				</div>

			</div>



		<!-- BACK-TO-TOP -->

		<a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>



		



		<!-- JQUERY SCRIPTS JS-->

		

		<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>



		<!-- BOOTSTRAP SCRIPTS JS-->

		<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/js/sweet-alert.js') }}"></script>



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

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/chart/chart.bundle.js') }}"></script>



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

		

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

		

		

		<!-- TIMEPICKER JS -->

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/time-picker/time-picker.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/time-picker/toggles.min.js') }}"></script>



		<!-- DATEPICKER JS -->

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/date-picker/date-picker.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/date-picker/jquery-ui.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/input-mask/input-masked.js') }}"></script>

		<script src="{{ URL::asset('build/js/bootstrap-datetimepicker.min.js') }}"></script>



		



		<!-- FILE UPLOADES JS -->

        <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fileupload/js/fileupload.min.js') }}"></script>

        <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fileupload/js/file-upload.js') }}"></script>

        <!-- SWEET ALERT -->

        <script src="{{ URL::asset('resources/views/layouts/assets/js/sweet-alert.js') }}"></script>

        <script src="{{ URL::asset('resources/views/layouts/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>



		<!-- MULTI SELECT JS-->

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/multipleselect/multiple-select.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/multipleselect/multi-select.js') }}"></script>



		<!-- DATA TABLE JS-->

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js/jszip.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js/pdfmake.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js//vfs_fonts.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js/buttons.print.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>

		<script src="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/datatable.js') }}"></script>
		<script sync type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/file-saver.min.js') }}"></script>
		<script sync type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/blob.min.js') }}"></script>
		<!-- CUSTOM JS-->

		<script src="{{ URL::asset('resources/views/layouts/assets/js/custom.js') }}"></script>

		<script src="{{ URL::asset('build/js/control.js') }}"></script>



		<script type="text/javascript">

			$(document).ready(function(){



				$('.mainMenu').on("click", function(){

					localStorage.tab_active=100;

				})

				$('.app-sidebar .first-sidemenu li').on("click", function(){

					localStorage.tab_active = $(this).attr("number");

				});

				
				if(typeof(Storage)!=="undefined"){

					if(localStorage.tab_active == 100){
						$('.app-header .toggle').click();

					}


					else if(localStorage.tab_active){

						$tab_content_active = localStorage.tab_active - 1;

						$('li[number='+localStorage.tab_active+']').addClass("resp-tab-active active");

						$('h2[aria-controls = hor_1_tab_item-'+ $tab_content_active +']').addClass("resp-tab-active");

						$('div[aria-labelledby = hor_1_tab_item-'+ $tab_content_active +']').addClass("resp-tab-content-active");

					}

					

					else{

						localStorage.tab_active=2;

						$tab_content_active = localStorage.tab_active - 1;

						$('li[number='+localStorage.tab_active+']').addClass("resp-tab-active active");

						$('h2[aria-controls = hor_1_tab_item-'+ $tab_content_active +']').addClass("resp-tab-active");

						$('div[aria-labelledby = hor_1_tab_item-'+ $tab_content_active +']').addClass("resp-tab-content-active");

					}

				}

				$('select, input').attr("autocomplete","off");

			});

		</script>

		



	</body>

</html>
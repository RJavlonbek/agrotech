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
						<li class="">
							<a href="/task/list" class="accordion-toggle wave-effect">
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
				 <div class="content-area" response="{{ $req->response }}" request-id="{{ $req->id }}" request-status="{{ $req->status }}">
				 	<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="page-header">
						<h4 class="page-title">Davlat xizmatlari markazi tomonidan yuborilgan so'rov haqida ma'lumot </h4>
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
											Tadbirkorlik subyektining ro'yxatdan o'chirilganligi to'g'risida xabarnoma
										@endif
									</h3>
									<div class="card-options">
										<h5>
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
										</h5>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-6">
											<h3>So'rov</h3>
											<div class="table-responsive">
												<table class="table table-hover card-table table-vcenter table-outline text-nowrap">
													<tbody>
														<tr>
															<td class="field-name">Ariza raqami: </td>
															<td class="field-value">{{ $req->application_id }}</td>
														</tr>
														<tr>
															<td class="field-name">Qabul qilish sanasi: </td>
															<td class="field-value">{{ date('d.m.Y H:i', strtotime($req->recieved_at)) }}</td>
														</tr>
														<tr>
															<td class="field-name">DXA filiali : </td>
															<td class="field-value">{{ $req->center_name }}</td>
														</tr>
														<tr>
															<td class="field-name">DXA xodimi FISh : </td>
															<td class="field-value">{{ $req->lik_fio }}</td>
														</tr>
														<tr>
															<td class="field-name">DXA xodimi STIR : </td>
															<td class="field-value">{{ $req->lik_inn }}</td>
														</tr>
														<tr>
															<td class="field-name">DXA xodimi pasporti : </td>
															<td class="field-value">{{ $req->lik_passport_sn.$req->lik_passport_num }}</td>
														</tr>
														<tr>
															<td class="field-name">Telefon : </td>
															<td class="field-value">{{ $req->lik_tel }}</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-6">
											<h3>Tadbirkorlik subyekti</h3>
											<div class="table-responsive">
												<table class="table table-hover card-table table-vcenter table-outline text-nowrap">
													<tbody>
														<tr>
															<td class="field-name">Ro'yxatga olish sanasi: </td>
															<td class="field-value">
																{{ $req->entity_registration_date ? date('d.m.Y', strtotime($req->entity_registration_date)) : '-' }}
															</td>
														</tr>
														<tr>
															<td class="field-name">Ro'yxatga olish raqami: </td>
															<td class="field-value">{{ $req->entity_registration_number }}</td>
														</tr>
														<tr>
															<td class="field-name">Nomi : </td>
															<td class="field-value">{{ $req->entity_name }}</td>
														</tr>
														<tr>
															<td class="field-name">STIR : </td>
															<td class="field-value">{{ $req->entity_inn }}</td>
														</tr>
														<tr>
															<td class="field-name">Tashkilot ID formasi : </td>
															<td class="field-value">{{ $req->entity_opf_id }}</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										@if($req->method==1)
											<div class="col-12 items-list">
												<h3>Tadbirkorlik subyektiga tegishli texnikalar</h3>
												<div class="item-sample-form">
													<div class="row item-form border-top py-4">
														<div class="col-12 d-flex">
															<div class="card-options mr-0">
																<a class="card-options-remove remove-item-form"><i class="fa fa-close"></i></a>
															</div>
														</div>
														<div class="col-2 form-group">
															<p class="card-text text-muted mb-1">Turi </p>
															<select class="form-control select2-vehicle-type" disabled="disabled" data-placeholder="Texnika turi">
																<option value=""></option>
																@if(!empty($types))
																	@foreach($types as $type)
																		<option value="{{ $type->id }}">{{ $type->name }}</option>
																	@endforeach
																@endif
															</select>
														</div>
														<div class="col-2 form-group">
															<p class="card-text text-muted mb-1">Rusumi </p>
															<select class="form-control select2-vehicle-brand" data-placeholder="Texnika turi">
																<option value=""></option>
																@if(!empty($brands))
																	@foreach($brands as $brand)
																		<option value="{{ $brand->id }}" type-id="{{ $brand->type_id }}">{{ $brand->name }}</option>
																	@endforeach
																@endif
															</select>
														</div>
														<div class="col-2 form-group">
															<p class="card-text text-muted mb-1">Ishlab chiqarilgan yili</p>
															<input type="text" name="produced-year" class="form-control produced-year" placeholder="" />
														</div>
														<div class="col-2 form-group">
															<p class="card-text text-muted mb-1">Davlat raqami belgisi</p>
															<input type="text" name="tr-number" class="form-control" placeholder="" />
														</div>
														<div class="col-2 form-group">
															<p class="card-text text-muted mb-1">Tex pasport seriya-raqami</p>
															<input type="text" name="tech-passport" class="form-control" placeholder="" />
														</div>
														<div class="col-2 form-group">
															<p class="card-text text-muted mb-1">Berilgan sana</p>
															<input type="text" name="passport-given-date" class="form-control passport-given-date" placeholder="" />
														</div>

														<div class="col-4 form-group">
															<p class="card-text text-muted mb-1">Kim tomonidan berilgan (inspeksiya bo'limi)</p>
															<input type="text" name="tech-passport-given-by" class="form-control" placeholder="" />
														</div>
														<div class="col-2 form-group">
															<p class="card-text text-muted mb-1">Shassi (Kuzov) raqami</p>
															<input type="text" name="chassis-no" class="form-control" placeholder="" />
														</div>
														<div class="col-2 form-group">
															<p class="card-text text-muted mb-1">Dvigatel raqami</p>
															<input type="text" name="engine-no" class="form-control" placeholder="" />
														</div>
														<div class="col-4 form-group">
															<p class="card-text text-muted mb-1">Alohida belgilari</p>
															<input type="text" name="note" class="form-control" placeholder="" />
														</div>

														<div class="col-2 form-group">
															<label class="custom-switch mt-6">
																<input type="checkbox" name="prohibition" class="custom-switch-input" />
																<span class="custom-switch-indicator"></span>
																<span class="custom-switch-description">Taqiqqa olingan </span>
															</label>
														</div>
														<div class="prohibition-field col-2 form-group">
															<p class="card-text text-muted mb-1">Taqiqqa olingan sana</p>
															<input type="text" name="prohibition-date" class="form-control prohibition-date" placeholder="" />
														</div>
														<div class="prohibition-field col-4 form-group">
															<p class="card-text text-muted mb-1">Taqiqqa oluvchi organ</p>
															<input type="text" name="prohibition-by" class="form-control" placeholder="" />
														</div>
													</div>
												</div>
												@if(!empty($response) && !empty($response->objects))
													@foreach($response->objects as $item)
														<div class="row item-form border-top py-4">
															<div class="col-12 d-flex">
																<div class="card-options mr-0">
																	<a class="card-options-remove remove-item-form"><i class="fa fa-close"></i></a>
																</div>
															</div>
															<div class="col-2 form-group">
																<p class="card-text text-muted mb-1">Turi </p>
																<select class="form-control select2-vehicle-type" disabled="disabled" data-placeholder="Texnika turi">
																	@if(!empty($types))
																		@foreach($types as $type)
																			<option value="{{ $type->id }}"
																				{{ $item->type == $type->name ? 'selected="selected"' : ''}}
																			>{{ $type->name }}</option>
																		@endforeach
																	@endif
																</select>
															</div>
															<div class="col-2 form-group">
																<p class="card-text text-muted mb-1">Rusumi </p>
																<select class="form-control select2-vehicle-brand" data-placeholder="Texnika turi">
																	<option value=""></option>
																	@if(!empty($brands))
																		@foreach($brands as $brand)
																			<option value="{{ $brand->id }}" type-id="{{ $brand->type_id }}"
																				{{ $item->model == $brand->name ? 'selected="selected"' : ''}}
																			>{{ $brand->name }}</option>
																		@endforeach
																	@endif
																</select>
															</div>
															<div class="col-2 form-group">
																<p class="card-text text-muted mb-1">Ishlab chiqarilgan yili</p>
																<input type="text" name="produced-year" class="form-control produced-year" placeholder="" 
																	value="{{ $item->produced_year }}" 
																/>
															</div>
															<div class="col-2 form-group">
																<p class="card-text text-muted mb-1">Davlat raqami belgisi</p>
																<input type="text" name="tr-number" class="form-control" placeholder="" 
																	value="{{ $item->number }}"
																/>
															</div>
															<div class="col-2 form-group">
																<p class="card-text text-muted mb-1">Tex pasport seriya-raqami</p>
																<input type="text" name="tech-passport" class="form-control" placeholder="" 
																	value="{{ $item->p_series }}"/>
															</div>
															<div class="col-2 form-group">
																<p class="card-text text-muted mb-1">Berilgan sana</p>
																<input type="text" name="passport-given-date" class="form-control passport-given-date" placeholder="" 
																	value="{{ $item->p_given_date }}"
																/>
															</div>

															<div class="col-4 form-group">
																<p class="card-text text-muted mb-1">Kim tomonidan berilgan (inspeksiya bo'limi)</p>
																<input type="text" name="tech-passport-given-by" class="form-control" placeholder="" 
																	value="{{ $item->p_given_by }}"
																/>
															</div>
															<div class="col-2 form-group">
																<p class="card-text text-muted mb-1">Shassi (Kuzov) raqami</p>
																<input type="text" name="chassis-no" class="form-control" placeholder="" 
																	value="{{ $item->chassis_no }}"
																/>
															</div>
															<div class="col-2 form-group">
																<p class="card-text text-muted mb-1">Dvigatel raqami</p>
																<input type="text" name="engine-no" class="form-control" placeholder="" 
																	value="{{ $item->engine_no }}"
																/>
															</div>
															<div class="col-4 form-group">
																<p class="card-text text-muted mb-1">Alohida belgilari</p>
																<input type="text" name="note" class="form-control" placeholder="" 
																	value="{{ $item->note }}"
																/>
															</div>
															<div class="col-2 form-group">
																<label class="custom-switch mt-6">
																	<input type="checkbox" name="prohibition" class="custom-switch-input" 
																		{{ $item->prohibition->pr_status=='taqiqqa olingan' ? 'checked="checked"' : '' }}
																	/>
																	<span class="custom-switch-indicator"></span>
																	<span class="custom-switch-description">Taqiqqa olingan </span>
																</label>
															</div>
															<div class="prohibition-field col-2 form-group">
																<p class="card-text text-muted mb-1">Taqiqqa olingan sana</p>
																<input type="text" name="prohibition-date" class="form-control prohibition-date" placeholder="" 
																	value="{{ $item->prohibition->pr_date }}" />
															</div>
															<div class="prohibition-field col-4 form-group">
																<p class="card-text text-muted mb-1">Taqiqqa oluvchi organ</p>
																<input type="text" name="prohibition-by" class="form-control" placeholder="" 
																	value="{{ $item->prohibition->pr_by }}" />
															</div>
														</div>
													@endforeach
												@else
													<h4 class="no-items-message">
														<span class="badge badge-warning"> Texnikalar mavjud emas! </span>
													</h4>
												@endif
											</div>
											<div class="col-12 card-footer text-right">
												@if($req->status == 1)
													<button class="btn btn-success" id="add-item-button"><i class="fa fa-plus"></i> Texnika qo'shish</button>
													<button class="btn btn-info" id="save-button"> Saqlash</button>
													<button class="btn btn-primary" id="send-button"> Jo'natish</button>
												@endif
											</div>
										@else
											<div class="col-12">
												<h3>So'rov natijasi</h3>
												<h4 class="result-message">
													@if($req->status == 4) 
														{{-- finished --}}
														@if($req->method==2)
															<span class="badge badge-success"> Arizani bekor qilish bajarildi </span>
														@elseif($req->method==3)
															<span class="badge badge-success"> Likvidatorni o'zgartirish bajarildi </span>
														@elseif($req->method==5)
															<span class="badge badge-success"> Likvidatsiya jarayoni yakunlanganligi tasdiqlandi </span>
														@else
															<span class="badge badge-success"> 
																{{ json_decode($req->auto_response)->result_message }}
															</span>
														@endif
													@elseif($req->status == 5)
														{{-- Error response was sent --}}
														<span class="badge badge-danger">
															{{ json_decode($req->auto_response)->result_message }}
														</span>
													@endif
												</h4>
											</div>
										@endif
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


	<script type="text/javascript">
		$(function(){
			saved = false;
			$('.item-sample-form').hide();

			if($('.content-area').attr('request-status') != 1){
				$('.items-list .item-form input, .items-list .item-form select').attr('disabled', 'disabled');
				$('.items-list .item-form .card-options-remove').css('visibility', 'hidden');
			}else{
				$('.items-list > .item-form').each((i,form)=>{
					prepareFields($(form));
				});
			}

			$('#add-item-button').on('click', function(e){
				console.log('adding new item');
				$('.no-items-message').hide();
				let form = $('.item-sample-form').html();
				$('.items-list').append(form);
				form=$('.items-list .item-form').last();

				prepareFields(form);
			});

			$('#save-button').on('click', function(){
				let btn = $(this);
				btn.addClass('btn-loading');

				save().then(data=>{
					btn.removeClass('btn-loading');
					//data = JSON.parse(data);
					console.log('promise', data);
					if(data.status && data.status=='success'){
						swal({
							type: "success",
							title: "Saqlandi",
							showConfirmButton: false,
							timer: 1000
						});
					}else{
						swal({
							type:"warning",
							title: '',
							text: data.message
						});
					}
				});
			});

			$('#send-button').on('click', function(){
				let btn = $(this);
				let otherButtons = btn.siblings().attr('disabled', 'disabled'); 
				btn.addClass('btn-loading');

				save().then(data=>{
					//console.log('save response', data);

					if(data.status == 'success'){
						send().then((sendResponse)=>{
							btn.removeClass('btn-loading');
							console.log('sendResponse', sendResponse);
							if(sendResponse.status != 'success'){
								swal({
									type:'warning',
									title: 'Jo\'natishda xatolik!',
									text: 'Status: '+sendResponse.status+'; javob: '+sendResponse.message+'; '+sendResponse.url+' ga ulanib bo\'lmadi!'
								});
							}else{
								swal({
									type: 'success',
									title: 'Jo\'natildi',
								});
							}
						});
					}

					// if(data.status && data.status=='success' && data.json){
					// 	let url = 'http://10.190.2.65:8088/liquidation/agrotech/get_info';
					// 	$.ajax({
					// 		url,
					// 		type: "POST",
					// 		data: data.json,
					// 		success: (res)=>{
					// 			btn.removeClass('btn-loading');
					// 			otherButtons.removeAttr('disabled');
					// 			console.log('sending successful', res);
					// 			swal({
					// 				type: 'success',
					// 				title: 'Jo\'natildi',
					// 			});

					// 			markAsSent().then((r)=>{
					// 				console.log('saved to database', r);
					// 			});
					// 		},
					// 		error: (err)=>{	
					// 			btn.removeClass('btn-loading');
					// 			otherButtons.removeAttr('disabled');
					// 			console.log('error whikle sending', err);
					// 			swal({
					// 				type:'warning',
					// 				title: 'Jo\'natishda xatolik!',
					// 				text: 'Status: '+err.status+'; javob: '+err.statusText+'; '+url+' ga ulanib bo\'lmadi!'
					// 			});
					// 		}
					// 	});
					// }else{
					// 	swal({
					// 		type:"warning",
					// 		title: '',
					// 		text: data.message
					// 	});
					// }

					// $.ajax({
					// 	url: '/api/send-request',
					// 	type:'GET',
					// 	success:(data)=>{
					// 		console.log('success', data);
					// 		btn.removeClass('btn-loading');
					// 	},
					// 	error: (err)=>{
					// 		console.error('Jo\'natishda xatolik: ', err);
					// 		btn.removeClass('btn-loading');
					// 	}
					// });

					// $.ajax({
					// 	//url: 'http://10.190.4.250/api/get_info',
					// 	url: 'http://agroteh.uz/api/get_info',
					// 	type:'POST',
					// 	success:(data)=>{
					// 		console.log('success', data);
					// 		btn.removeClass('btn-loading');
					// 	},
					// 	error: (err)=>{
					// 		console.error('Jo\'natishda xatolik: ', err);
					// 		btn.removeClass('btn-loading');
					// 	}
					// });
				});
			});
		});

		function save(){
			let response=$('.content-area').attr('response');
			let hasError=false;

			try{
				response = JSON.parse(response);
			} catch (e){
				//console.log(e);
				alert('Invalid JSON: '+response);
				window.location.reload();
			}
			//console.log(response);
			response.objects = [];

			$('.items-list > .item-form').each((index, form)=>{
				form=$(form);
				form.find('.is-invalid.state-invalid').removeClass('is-invalid state-invalid');
				let validated=true;
				inputs=form.find('input');
				for(let i=0; i<inputs.length; i++){
					let input=inputs.eq(i);
					if(!input.val()){							
						if(input.is('.prohibition-field input') && !form.find('input[name="prohibition"]').is(':checked')){

						}else{
							input.addClass('is-invalid state-invalid');
							validated=false;
						}
					}
				}
				if(validated){
					let item={
						number: form.find('input[name="tr-number"]').val(),
						model: form.find('select.select2-vehicle-brand option:selected').text(),
						p_series: form.find('input[name="tech-passport"]').val(),
						p_given_date: form.find('input[name="passport-given-date"]').val(),
						p_given_by: form.find('input[name="tech-passport-given-by"]').val(),
						produced_year: form.find('input[name="produced-year"]').val(),
						type: form.find('select.select2-vehicle-brand option:selected').text(),
						chassis_no: form.find('input[name="chassis-no"]').val(),
						engine_no: form.find('input[name="engine-no"]').val(),
						note: form.find('input[name="note"]').val()
					}
					if(form.find('input[name="prohibition"]').is(':checked')){
						item.prohibition={
							pr_status: "taqiqqa olingan",
							pr_date: form.find('input[name="prohibition-date"]').val(),
							pr_by: form.find('input[name="prohibition-by"]').val()
						}
					}else{
						item.prohibition={
							pr_status: "taqiqqa olinmagan",
							pr_date: "",
							pr_by: ""
						}
					}

					response.objects.push(item);
				}else{
					hasError = true;
					console.log('couldn\'t be validated');
				}
			});

			return new Promise((resolve, reject)=>{
				$.ajax({
					url:'/task/save',
					type:'POST',
					data:{
						id: $('.content-area').attr('request-id'),
						json: JSON.stringify(response),
						_token: $('input[name="_token"]').val()
					},
					success: function(data){
						if(hasError){
							resolve({
								status:'error',
								message: 'Ma\'lumotlarni to\'ldirishda xatolik bor!'
							});
						}
						resolve(data);
					},
					error: function(err){
						resolve({
							status: 'error'
						});
					}
				});
			});
		}

		function send(){
			return new Promise((resolve, reject)=>{
				$.ajax({
					url: '/task/'+$('.content-area').attr('request-id')+'/response-sent',
					type: 'GET',
					success:(res)=>{
						resolve(res);
					},
					error: (err)=>{
						resolve({
							status: 'error',
							message: err
						});
					}
				});
			});
		}

		function prepareFields(form){
			// Select2 by showing the search
			form.find('.select2-vehicle-type').select2({
			  minimumResultsForSearch: ''
			});

			form.find('.select2-vehicle-brand').select2({
			  minimumResultsForSearch: ''
			});

			form.find('input.produced-year').datetimepicker({
		    	format: 'yyyy',
		    	initialDate: "2014",
				autoclose: 1,
				minView: 4,
				startView: 4
			});

			form.find('.passport-given-date').datetimepicker({
		    	days:["Yakshanba","Dushanba","Seshanba","Chorshanba","Payshanba","Juma","Shanba","Yakshanba"],
		    	daysShort:["Yak","Du","Se","Chor","Pay","Jum","Shan","Yak"],
		    	daysMin:["Ya","Du","Se","Chor","Pa","Ju","Sha","Ya"],
		    	months:["Yanvar","Fevral","Mart","Aprel","May","Iyun","Iyul","Avgust","Sentabr","Oktabr","Noyabr","Dekabr"],
		    	monthsShort:["Yan","Fev","Mar","Apr","May","Iyun","Iyul","Avg","Sen","Okt","Noy","Dek"],
		    	today: "Bugun",
		    	format: 'dd.mm.yyyy',
		    	initialDate: "01.01.2014",
				autoclose: 1,
				minView: 2,
				startView: 4
			});

			form.find('.prohibition-date').datetimepicker({
		    	days:["Yakshanba","Dushanba","Seshanba","Chorshanba","Payshanba","Juma","Shanba","Yakshanba"],
		    	daysShort:["Yak","Du","Se","Chor","Pay","Jum","Shan","Yak"],
		    	daysMin:["Ya","Du","Se","Chor","Pa","Ju","Sha","Ya"],
		    	months:["Yanvar","Fevral","Mart","Aprel","May","Iyun","Iyul","Avgust","Sentabr","Oktabr","Noyabr","Dekabr"],
		    	monthsShort:["Yan","Fev","Mar","Apr","May","Iyun","Iyul","Avg","Sen","Okt","Noy","Dek"],
		    	today: "Bugun",
		    	format: 'dd.mm.yyyy',
		    	initialDate: "01.01.2018",
				autoclose: 1,
				minView: 2,
				startView: 4
			});

			form.find('.select2-vehicle-brand').change(function(e){
				let typeId = $(this).find('option:selected').attr('type-id');
				$('.select2-vehicle-type').val(typeId).trigger('change');
			});

			if(!form.find('input[name="prohibition"]').is(':checked')){
				form.find('.prohibition-field').hide();
			}
			
			form.find('input[name="prohibition"]').change(function(){
				let checked = $(this).is(':checked');
				// if(checked){
				// 	form.find('.prohibition-field').slideIn();
				// }else{
				// 	form.find('.prohibition-field').hide();
				// }
				form.find('.prohibition-field').fadeToggle();
			});

			form.find('.remove-item-form').on('click', function(){
				form.remove();
			});
		}
	</script>

 </body>
 </html>
<!DOCTYPE html>

<html lang="en">

<head>
    <!-- <meta content="text/html; charset=UTF-8"> -->
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ URL::asset('fevicol.png') }}" type="image/gif" sizes="16x16">
    <title>AgroTech project</title>

    <!-- Bootstrap -->
    <link href= "{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }} " rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }} " rel="stylesheet">
	 <!-- Own Theme Style -->
    <link href="{{ URL::asset('build/css/own.css') }} " rel="stylesheet">
	<!-- sweetalert -->
	<link href="{{ URL::asset('vendors/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
  <link rel="icon" href="{{ URL::asset('resources/views/layouts/assets/images/LS.png') }}" type="image/x-icon"/>

    <!-- TITLE -->
    <title>@if(!empty($title)){{$title." |"}} @endif  {{ getNameSystem() }}</title>
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
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/css/bootstrap-datetimepicker.min.css') }}">
    <!-- SELECT2 CSS -->
    <link href="{{ URL::asset('resources/views/layouts/assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>

    <!-- Data table css -->
    <link href="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}">
    <link href="{{ URL::asset('resources/views/layouts/assets/plugins/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />

    <!-- TABS -->
    <link href="{{ URL::asset('resources/views/layouts/assets/plugins/tabs/tabs.css') }}" rel="stylesheet" />

    
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/myStyle.css') }}">
    <link href="{{ URL::asset('resources/views/layouts/assets/plugins/single-page/css/single-page.css') }}" rel="stylesheet" type="text/css">
	 <!-- Custom Theme Scripts -->
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
    <script src="{{ URL::asset('build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- SELECT2 JS -->
    <script src="{{ URL::asset('resources/views/layouts/assets/js/select2.js') }}"></script>

    <!-- FILE UPLOADES JS -->
        <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fileupload/js/fileupload.min.js') }}"></script>
        <script src="{{ URL::asset('resources/views/layouts/assets/plugins/fileupload/js/file-upload.js') }}"></script>
        <!-- SWEET ALERT -->
        <script src="{{ URL::asset('resources/views/layouts/assets/js/sweet-alert.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('vendors/sweetalert/sweetalert.min.js') }}"></script>

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
    
    <!-- CUSTOM JS-->
    <script src="{{ URL::asset('resources/views/layouts/assets/js/custom.js') }}"></script>
    <script src="{{ URL::asset('build/js/control.js') }}"></script>
	<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom.min.js') }}" defer="defer"></script>
	<script src="{{ URL::asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
<style>
.login_form{background: #2A3F54;}	
.login_content a:hover {
    text-decoration: none;
    color: #fff;
}
.login_content{text-shadow: none;}
.help-block{text-align: left;}

#myVideo{
	position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%; 
  min-height: 100%;
}
</style>
  </head>
  
<body class="app">
<div class="login-img">

      <!-- GLOABAL LOADER -->
      <div id="global-loader">
        <img src="{{ URL::asset('resources/views/layouts/assets/images/svgs/loader.svg')}}" class="loader-img" alt="Loader">
      </div>

      <div class="page">
        <div class="">
        	<video autoplay muted loop id="myVideo">
        		<source src="{{ URL::asset('resources/views/layouts/assets/images/Agriculture-1098.mp4')}}" type="video/mp4">
        			Your browser does not support HTML5 video.
        	</video>
            <!-- CONTAINER OPEN -->
          <div class="col col-login mx-auto">
            <div class="text-center">
              <img src="{{ URL::asset('resources/views/layouts/assets/images/logo.png')}}" class="header-brand-img" alt="">
            </div>
          </div>
          <div class="container-login100">
            <div class="wrap-login100 p-6">
              <form class="login100-form validate-form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <span class="login100-form-title">
                  Dasturga kirish
                </span>
                <div class="wrap-input100 validate-input" data-validate = "To'g'ri shakldagi pochta manzilini kiriting: ex@abc.xyz">
                  <input class="input100" type="text"  name="email" placeholder="Email"  value="{{ old('email') }}">
                  <span class="focus-input100"></span>
                  <span class="symbol-input100">
                    <i class="zmdi zmdi-email" aria-hidden="true"></i>
                  </span>                 
                </div>
                 @if ($errors->has('email'))
                      <span class="help-block">
                          <strong>Kiritilgan pochta ma'lumotlari noto'g'ri</strong>
                      </span>
                  @endif
                <div class="wrap-input100 validate-input" data-validate = "Parol kiritish majburiy">
                  <input class="input100" type="password" name="password" placeholder="Parol">
                  <span class="focus-input100"></span>
                  <span class="symbol-input100">
                    <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                  </span>                   
                </div>
                @if ($errors->has('password'))
                                      <span class="help-block">
                                          <strong>Parol kiritilmagan yoki noto'g'ri kiritilgan</strong>
                                      </span>
                                  @endif
               {{--  <div class="text-right pt-1">
                  <p class="mb-0"><a href="{{url('/password/reset')}}" class="text-primary ml-1">Forgot Password?</a></p>
                </div> --}}
                <div class="container-login100-form-btn">
                  <button class="login100-form-btn btn-primary">
                   Kirish
                  </button>
                </div>
              </form>
            </div>
          </div>
          <!-- CONTAINER CLOSED -->
        </div>
      </div>
    </div>
	
	@if(!empty(session('firsttime')))
		
		<Script>
			$(document).ready(function(){
				swal({   
					title: "Your Installation is Successful",   
					 
				}, function(){
					
						window.location.reload()
				});	
				});	
		
		</script>
		<?php Session::flush(); ?>
	@endif
  </body>

</html>



                   
                       

                      
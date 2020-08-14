@extends('layouts.app')
@section('content')
<style>
.right_side .table_row, .member_right .table_row {
    border-bottom: 1px solid #dedede;
    float: left;
    width: 100%;
	padding: 1px 0px 4px 2px;
}
.table_row .table_td {
  padding: 8px 8px !important;
}
.report_title {
    float: left;
    font-size: 20px;
    width: 100%;
}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Employees',$userid)=='yes')
	
	

     <div class="section">
			<div class="page-header">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Employee')}}
					</li>
				</ol>
			</div>
		@if(session('message'))
		<div class="row massage">
			<div class="col-md-12 col-sm-12">
				<div class="alert alert-success text-center">
					<input id="checkbox-10" type="checkbox" checked="">
					<label for="checkbox-10 colo_success">  {{session('message')}} </label>
				</div>
			</div>
		</div>
		@endif
		<div class="row">
			<div class="col-md-12">
				<div class="card">									
					<div class="card-body">
						<div class="panel panel-primary">
							<div class="tab_wrapper page-tab">
								<ul class="tab_list">
									<li>
										<a href="{!! url('/employee/list')!!}">
											<span class="visible-xs"></span>
											<i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Ro\'yxat')}}
										</a>
									</li>
									<li class="active">
										<span class="visible-xs"></span>
										<i class="fa fa-edit fa-lg">&nbsp;</i> 
										<b>{{ trans('app.View Employee')}}</b>
									</li>
								</ul>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="row">
									<div class="col-md-4 col-sm-12 left_side">
										<img src="{{ URL::asset('public/employee/'.$user->image) }}" class="cimg">
									</div>
									<div class="col-md-8 col-sm-12 right_side">
										<div class="table_row row">
											<div class="col-md-5 col-sm-12 table_td">
												<i class="fa fa-user"></i> 
													<b>{{ trans('app.Employee')}}</b>	
											</div>
											<div class="col-md-7 col-sm-12 table_td">
												<span class="txt_color">
												{{ $user->name.' '.$user->lastname }}
												</span>
											</div>
										</div>
										<div class="table_row row">
											<div class="col-md-5 col-sm-12 table_td">
												<i class="fa fa-id-card"></i> 
													<b>Lavozimi</b>	
											</div>
											<div class="col-md-7 col-sm-12 table_td">
												<span class="txt_color">
												@if(!empty($position))
													{{ $position->name }}
												@else
													Adminstrator
												@endif
												</span>
											</div>
										</div>
										<div class="table_row row">
											<div class="col-md-5 col-sm-12 table_td">
												<i class="fa fa-envelope"></i> 
												<b>{{ trans('app.Email')}}</b> 	
											</div>
											<div class="col-md-7 col-sm-12 table_td">
												<span class="txt_color">{{ $user->email }}</span>
											</div>
										</div>
										<div class="table_row row">
											<div class="col-md-5 col-sm-12 table_td"><i class="fa fa-phone"></i> <b>{{ trans('app.Mobile No')}}</b>
											</div>
											<div class="col-md-7 col-sm-12 table_td">
												<span class="txt_color">
													<span class="txt_color">{{ $user->mobile_no }} </span>
												</span>
											</div>
										</div>
										<div class="table_row row">
											<div class="col-md-5 col-sm-12 table_td">
												<i class="fa fa-calendar"></i><b> {{ trans('app.Date Of Birth')}}</b>	
											</div>
											<div class="col-md-7 col-sm-12 table_td">
												<span class="txt_color">{{ date(getDateFormat(),strtotime($user->birth_date)) }}</span>
											</div>
										</div>
										<div class="table_row row">
											<div class="col-md-5 col-sm-12 table_td">
												<i class="fa fa-mars"></i> <b>{{ trans('app.Gender')}} </b>
											</div>
											<div class="col-md-7 col-sm-12 table_td">
												<span class="txt_color">
												@if($user->gender =='1')
												  	<?php echo"erkak ";?>
												@else
													<?php echo"ayol";?>
												@endif
												 </span>
											</div>
										</div>
										<div class="table_row row">
											<div class="col-md-5 col-sm-12 table_td">
												<i class="fa fa-map-marker"></i> <b>{{ trans('app.Address')}}</b>		</div>
											<div class="col-md-7 col-sm-12 table_td">
												<span class="txt_color">
													{{ getStateNameus($user->id)}}<br/>
													{{ getCityNameus($user->id) }}<br/>
												  	{{ $user->address }}.
												</span>
											</div>
										</div>
									</div>
									@if($userid == $user->id)							
										<div class="col-12 text-right m-2">
											<a href="/employee/edit/{{ $user->id }}"> <button class="btn btn-primary">O'zgartirish</button></a>
										</div>
									@endif
									
		                        </div>
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
        <!-- /page content -->
 <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
 <!-- Free Service only -->
  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".emp_freeservice").click(function(){ 
	  
	  $('.modal-body').html("");
	   
       var emp_free = $(this).attr("emp_free");
	  
		var url = $(this).attr('url');
	      
       $.ajax({
       type: 'GET',
       url: url,
	
       data : {emp_free:emp_free},
       success: function (data)
       {            

			  $('.modal-body').html(data.html);
				
   },
   beforeSend:function(){
						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
					},
error: function(e) {
       alert("An error occurred: " + e.responseText);
       console.log(e);	
}
   });
       });
   });
</script>     
	

<!-- Paid Service only -->
  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".emp_paidservice").click(function(){ 
	  
	  $('.modal-body').html("");
	   
       var emp_paid = $(this).attr("emp_paid");
	  
		var url = $(this).attr('url');
	      
       $.ajax({
       type: 'GET',
       url: url,
	
       data : {emp_paid:emp_paid},
       success: function (data)
       {            

			  $('.modal-body').html(data.html);
				
   },
   beforeSend:function(){
						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
					},
error: function(e) {
       alert("An error occurred: " + e.responseText);
       console.log(e);	
}
   });
       });
   });
</script>
  
<!-- Repeat job Service only -->
  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".emp_repeatjob").click(function(){ 
	  
	  $('.modal-body').html("");
	   
       var emp_repeat = $(this).attr("emp_repeat");
	  
		var url = $(this).attr('url');
	      
       $.ajax({
       type: 'GET',
       url: url,
	
       data : {emp_repeat:emp_repeat},
       success: function (data)
       {            

			  $('.modal-body').html(data.html);
				
   },
   beforeSend:function(){
						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
					},
error: function(e) {
       alert("An error occurred: " + e.responseText);
       console.log(e);	
}
   });
       });
   });
</script>   	
@endsection
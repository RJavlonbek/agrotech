<!DOCTYPE html>



<html>



<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">



	<title>{{$title}}</title>



	<style type="text/css">

		p{

			font-size: 9px;

			font-weight: bold;

			font-family:'Montserrat', sans-serif;

			position: absolute;



		}

		.back-side{

			display: inline-block;

			position: relative; 

			width: 86mm;

			height: 54mm;

			background-size: cover; 

			background-image: url({{ URL::asset('resources/views/layouts/assets/images/dr-licence2.png') }}); 

			margin-left: 20px;



		}

		.front-side{

			display: inline-block;

		}

		.back-side p{

			font-size: 7px;

		}

		img.signature{
			max-width: 15mm;
			max-height: 8mm;
			top: 147.1px; 
			left: 31.7px; 
			position: absolute;
		}





		@media print {

			body{

				margin: 0;

			}



			.back-side{

				display: block;

				margin: 0;

				page-break-before: always;

			}



			.front-side{
				display: block;
			}

		}



		@page {

		    /*size: 86mm 54.1mm;*/

		    margin: 0%;

		}

	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<body>

	@if(!empty($driverLicence))

		<?php $givenDate=strtotime($driverLicence->given_date); ?>

			<div class="front-side" style="position: relative; width: 86mm; height: 54mm;background-size: cover; background-image: url({{ URL::asset('resources/views/layouts/assets/images/dr-licence1.png') }})" >

				<p style="top: 43px; left:113px" class="text-capitalize">1.</p>

				<p style="top: 54px;  left: 113px;" class="text-capitalize">2.</p>

				<p style="top: 75px;  left: 113px;">3.</p>

				<p style="top: 86px;  left: 113px; max-width: 160px; min-height: 24px;">4a. </p>

				<p style="top: 86px;  left: 195px; min-height: 32px">4b.</p>



				<p style="top: 98px;  left: 113px;">4c.</p>

				<p style="top: 109px;  left: 113px;">4d. </p>

				<p style="top: 120px;  left: 113px;">5.</p>

				<p style="top: 153px;  left: 15px;">7.</p>

				<p style="top: 131px;  left: 113px;">8. </p>

				<p style="top: 162px;  left: 113px;">9. </p>





				<p style="top: 43px; left:126px" class="text-capitalize">{{' '.$driverLicence->owner_lastname}}</p>

				<p style="top: 54px;  left: 126px;" class="text-capitalize">{{' '.$driverLicence->owner_name}}</p>

				<p style="top: 64px;  left: 126px;" class="text-capitalize">{{$driverLicence->owner_middlename}}</p>

				<p style="top: 75px;  left: 126px;" ><span style="text-transform: uppercase;">{{getCityName($driverLicence->p_given_city)}}</span>{{ ', '.date('d.m.Y',strtotime($driverLicence->d_o_birth))}}</p>

				<p style="top: 86px;  left: 126px; max-width: 160px; min-height: 24px;"> {{' '.date('d.m.Y', $givenDate)}}</p>

				<p style="top: 86px;  left: 209px; min-height: 32px"> {{' '.date('d.m.Y',strtotime('+10 years', $givenDate)) }}</p>



				<p style="top: 98px;  left: 126px;" class="text-capitalize"> {{ getCityName($driverLicence->given_city_id) }}</p>

				@if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/uploads/drivers/'.date('Y/m/d', $givenDate).'/driver-'.$driverLicence->owner_id.'.jpeg'))

					<img src="{{ URL::asset('public/uploads/drivers/'.date('Y/m/d', $givenDate).'/driver-'.$driverLicence->owner_id.'.jpeg') }}" style="top: 53.1px; left: 14.7px; width: 20.15mm; height: 25.15mm; position: absolute;">

				@else

					<img src="{{ URL::asset('public/uploads/drivers/driver-default.jpeg') }}" style="top: 53.1px; left: 14.7px; width: 20.15mm; height: 25.15mm; position: absolute;">

				@endif



				@if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/uploads/signatures/'.date('Y/m/d', $givenDate).'/signature-driver-'.$driverLicence->owner_id.'.png'))

					<img class="signature" src="{{ URL::asset('public/uploads/signatures/'.date('Y/m/d', $givenDate).'/signature-driver-'.$driverLicence->owner_id.'.png?v='.strtotime('now')) }}">

				@else

					<img class="signature" src="{{ URL::asset('public/uploads/signatures/signature-driver-default.png') }}">

				@endif



				<p style="top: 109px;  left: 126px;"> {{$driverLicence->id_number?$driverLicence->id_number:($driverLicence->inn?$driverLicence->inn:'XXX')}}</p>



				<p style="top: 120px;  left: 126px;"> {{($driverLicence->local_series.$driverLicence->local_number) ? ($driverLicence->local_series.$driverLicence->local_number) : '-' }}</p>



				<p style="top: 131px;  left: 126px; width: 140px;" class="text-capitalize">{{' '.$driverLicence->city.', '.$driverLicence->address}}</p>



				<?php 

				$types=json_decode($driverLicence->type,true);

				$givenTypes=[]; // comma separated type names

				$typesArray=['','','','','','']; // array of types, if the type is not given then that index of the array will be empty

				foreach($types as $t){

					$givenTypes[]=$t['name'];

					switch ($t['name']) {

						case 'A':

							$typesArray[0]=$t;

							break;

						case 'B':

							$typesArray[1]=$t;

							break;

						case 'C':

							$typesArray[2]=$t;

							break;

						case 'D':

							$typesArray[3]=$t;

							break;

						case 'E':

							$typesArray[4]=$t;

							break;

						case 'F':

							$typesArray[5]=$t;

							break;

						default:

							break;

					}

				}

				$givenTypes=implode(',',$givenTypes);



				?>



				<p style="top: 162px;  left: 126px;">{{' '.$givenTypes}}</p>

				<p style="top: 174px; right: 60px;" >{{$driverLicence->series.$driverLicence->number}}</p>

			</div>

			<div class="back-side" style="">

				<p style="top: 33px; left: 196px;">{{$typesArray[0]?date('d.m.Y',strtotime($typesArray[0]['given_date'])):''}}</p>

				<p style="top: 33px; left: 235px;">{{$typesArray[0]?date('d.m.Y',strtotime('+10 years',strtotime($typesArray[0]['given_date']))):''}}</p>



				<p style="top: 54px; left: 196px;">{{$typesArray[1]?date('d.m.Y',strtotime($typesArray[1]['given_date'])):''}}</p>

				<p style="top: 54px;  left: 235px;">{{$typesArray[1]?date('d.m.Y',strtotime('+10 years',strtotime($typesArray[1]['given_date']))):''}}</p>



				<p style="top: 75px;  left: 196px;">{{$typesArray[2]?date('d.m.Y',strtotime($typesArray[2]['given_date'])):''}}</p>

				<p style="top: 75px;  left: 235px;">{{$typesArray[2]?date('d.m.Y',strtotime('+10 years',strtotime($typesArray[2]['given_date']))):''}}</p>



				<p style="top: 95px;  left: 196px;">{{$typesArray[3]?date('d.m.Y',strtotime($typesArray[3]['given_date'])):''}}</p>

				<p style="top: 95px;  left: 235px;">{{$typesArray[3]?date('d.m.Y',strtotime('+10 years',strtotime($typesArray[3]['given_date']))):''}}</p>



				<p style="top: 115px;  left: 196px;">{{$typesArray[4]?date('d.m.Y',strtotime($typesArray[4]['given_date'])):''}}</p>

				<p style="top: 115px;  left: 235px;">{{$typesArray[4]?date('d.m.Y',strtotime('+10 years',strtotime($typesArray[4]['given_date']))):''}}</p>



				<p style="top: 135px;  left: 196px;" class="text-capitalize">{{$typesArray[5]?date('d.m.Y',strtotime($typesArray[5]['given_date'])):''}}</p>

				<p style="top: 135px;  left: 235px;">{{$typesArray[5]?date('d.m.Y',strtotime('+10 years',strtotime($typesArray[5]['given_date']))):''}}</p>
				<p style="top: 160px;  left: 235px;">
					@if(!empty($driverLicence->note))
						{{$driverLicence->note}}
					@else
						XXX
					@endif
				</p>

			</div>

			<div class="note_for_driverlicence">
				
			</div>

	@else

		Guvohnoma chop etib bo'lingan

	@endif



	<script type="text/javascript">

		$(window).on("load", function(e) {

			var imgHeight = $('img.signature').outerHeight()/2;


			if(imgHeight<14){

				var newHeight = 149.1 + (14 - imgHeight/2);

				$('img.signature').css("top", newHeight + "px");

			}

		});


		$(window).on("load", function(e) {

			

			// capitalizing text of the element with class "text-capitalize"

			if($('.text-capitalize').length){

				$('.text-capitalize').each(function(index){

					var t=$(this).text().trim();

					$(this).text(upperize(t));

				});

			}

		});



		function upperize(text){

			var words=text.split(' ');

			for(var i=0;i<words.length;i++){

				if(words[i]){

					words[i]=words[i].toUpperCase();

				}

			}

			return words.join(' ');

		}



		function capitalize(text){

			var words=text.split(' ');

			for(var i=0;i<words.length;i++){

				if(words[i]){

					words[i]=words[i][0].toUpperCase()+words[i].substring(1).toLowerCase();

				}

			}

			return words.join(' ');

		}

	</script>

	@if(!empty($print) && $print)

		<script type="text/javascript">

			$(document).ready(function(){

				console.log('loaded');

				window.print();

			});

		</script>
		<script type="text/javascript">

			$(document).ready(function(){
				
			

		});

		</script>

	@endif

</body>
</html>
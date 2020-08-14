<!DOCTYPE html>



<html>



<head>



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
			background-image: url({{ URL::asset('resources/views/layouts/assets/images/tech-licence2.png') }});
			margin-left: 20px;
			
		}

		.front-side{
			display: inline-block;

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

			label{
				display: none;
			}
			#Header, #Footer { display: none !important; }
		}

		@page {
		    /*size: 86mm 55mm;*/
		    margin: 0%;
		}



	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<body>
	@if(!empty($certificate))
		<section>
			<div class="row">
				@if(isset($details) && $details)
					<div class="col-6 details">
						
					</div>
				@endif
				<div class="col-6">
					<div class="front-side" style="position: relative; width: 86mm; height: 54mm;background-size: cover; background-image: url({{ URL::asset('resources/views/layouts/assets/images/tech-licence12.png') }}">
						<p style="top: 39px; left:92px">1.</p>



						<p style="top: 50px;  left: 92px;">2.</p>



						<p style="top: 63px;  left: 92px;">3.</p>



						<p style="top: 75px;  left: 92px; max-width: 160px; min-height: 24px;">4. </p>



						<p style="top: 99px;  left: 92px; min-height: 32px; max-width: 165px;">5. </p>



						<p style="top: 129px;  left: 92px;">6.</p>



						<p style="top: 142px;  left: 92px;">7.</p>



						<p style="top: 156px;  left: 92px;">8. </p>



						<p style="top: 39px; left:105px">{{$certificate->vehicle_type?$certificate->vehicle_type:'XXX'}}</p>



						<p style="top: 50px;  left: 105px;">{{$certificate->vehicle_brand}}</p>



						<p style="top: 63px;  left: 105px;">{{$certificate->color ? $certificate->color : 'XXX'}}</p>



						<p style="top: 75px;  left: 105px; max-width: 160px; min-height: 24px;">
							@if($certificate->owner_type=='legal')
								"{{ $certificate->owner_name }}"
							@else 
								<span class="text-capitalize">{{$certificate->owner_lastname.' '.$certificate->owner_name}}</span>
							@endif
							{{ isset($certificate->ownership_form) ? $certificate->ownership_form : '' }}
						</p>
						<p style="top: 86px;  left: 105px; max-width: 160px; min-height: 24px;">
							@if($certificate->owner_type!='legal')
								<span class="text-capitalize">{{$certificate->owner_middlename}}</span>
							@endif
						</p>


						<p style="top: 99px;  left: 105px; min-height: 32px; max-width: 165px;" class="text-capitalize">{{$certificate->city.', '.$certificate->address}}</p>



						<p style="top: 129px;  left: 105px;">{{date('d/m/Y',strtotime($certificate->given_date))}}</p>



						<p style="top: 142px;  left: 105px;" class="text-capitalize">{{$certificate->state}} bo'limi</p>



						<p style="top: 156px;  left: 105px;">{{$certificate->id_number?$certificate->id_number:$certificate->inn}}</p>

					</div>

					<div class="back-side" style="">

						<p style="top: -1px; left: 240px;">{{' '.$certificate->series}}</p>

						<p style="top: 10px; left: 240px;">{{' '.$certificate->number}}</p>

						<p style="top: -1px; left: 154px;">9. {{' '.$certificate->modelyear}}</p>

						<p style="top: 21px;  left: 154px;" class="text-capitalize">10. {{' '.$certificate->vehicle_type}}</p>

						<p style="top: 41px;  left: 154px;">11. {{$certificate->factory_number?$certificate->factory_number:($certificate->chassisno?$certificate->chassisno:'XXX')}}</p>

						<p style="top: 61px;  left: 154px; max-width: 160px; min-height: 24px;" class="text-capitalize">12. {{ $certificate->weight_full ? $certificate->weight_full.'(kg)' : 'XXX' }}</p>

						<p style="top: 82px;  left: 154px; min-height: 32px" class="text-capitalize">13. {{ $certificate->weight ? $certificate->weight.'(kg)' : 'XXX' }}</p>

						<p style="top: 103px;  left: 154px;" class="text-capitalize">14. {{' '.$certificate->working_type?$certificate->working_type:'XXX'}}</p>

						<p style="top: 127px;  left: 154px;">15. {{$certificate->note?$certificate->note:'XXX'}}</p>

					</div>
				</div>
			</div>
		</section>
	@else
		<div>Guvohnoma topilmadi</div>
	@endif



	@if(!empty($print) && $print)

		<script type="text/javascript">

			$(document).ready(function(){

				console.log('loaded');

				window.print();

			});

		</script>

	@endif

	
	<script type="text/javascript">
		$(window).on("load", function(e) {

			// capitalizing text of the element with class "text-capitalize"
			if($('.text-capitalize').length){
				$('.text-capitalize').each(function(index){
					var t=$(this).text().trim();
					$(this).text(upperize(t));
				});
			}

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
				var words=text.trim().split(' ');
				for(var i=0;i<words.length;i++){
					if(words[i]){
						words[i]=words[i][0].toUpperCase()+words[i].substring(1).toLowerCase();
					}
				}
				return words.join(' ');
			}
		});
	</script>


</body>







</html>
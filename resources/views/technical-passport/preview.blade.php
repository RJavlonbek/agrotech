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
			background-image: url({{ URL::asset('resources/views/layouts/assets/images/tech-pasport2.png') }});
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
				margin-left: 0;
				page-break-before: always;
			}

			label{
				display: none;
			}
			#Header, #Footer { display: none !important; }
		}

		@page {
		    /*size: 86mm 54mm;*/
		    margin: 0%;
		}

	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<body>
	@if(!empty($technicalPassport))
		<div class="front-side" style="position: relative; width: 86mm; height: 54mm;background-size: cover; background-image: url({{ URL::asset('resources/views/layouts/assets/images/tech-pasport1.png') }}">
			<div class="row">
				<div class="col-1">
					<p style="top: 39px; left:97px">1.</p>

					<p style="top: 52px;  left: 97px;">2. </p>

					<p style="top: 63px;  left: 97px;">3. </p>

					<p class="text-capitalize" style="top: 75px;  left: 97px; max-width: 160px; min-height: 24px;">4.</p>

					<p style="top: 100px;  left: 97px; min-height: 32px; max-width: 165px;">5. </p>

					<p style="top: 131px;  left: 97px;">6. </p>

					<p style="top: 145px;  left: 97px;">7.</p>

					<p style="top: 159px;  left: 97px;">8. </p>
				</div>
				<div class="col-11">

					<p style="top: 39px; left:107px" class="text-capitalize">{{' '.$technicalPassport->n_code.' '.$technicalPassport->n_series.' '.$technicalPassport->n_number}}</p>

					<p style="top: 51px;  left: 107px;" class="text-capitalize"> {{' '.$technicalPassport->vehicle_brand}}</p>

					<p style="top: 64px;  left: 107px;" class="text-capitalize"> {{' '.$technicalPassport->color}}</p>

					<p style="top: 76px;  left: 107px; max-width: 160px; min-height: 24px;" class="text-capitalize">
						@if($technicalPassport->owner_type=='legal')
							"{{ $technicalPassport->owner_name }}"
						@else 
							<span class="text-capitalize">{{$technicalPassport->owner_lastname.' '.$technicalPassport->owner_name}}</span>
						@endif
						{{ isset($technicalPassport->ownership_form) ? $technicalPassport->ownership_form : '' }}
					<p  class="text-capitalize" style="top: 87px;  left: 107px; max-width: 160px; min-height: 24px;">
						{{$technicalPassport->owner_middlename}}</p>

					<p style="top: 100px;  left: 107px; min-height: 32px; max-width: 165px;" class="text-capitalize"> {{' '.$technicalPassport->city.', '.$technicalPassport->address}}</p>

					<p style="top: 131px;  left: 107px;" class="text-capitalize">{{' '.date('d/m/Y',strtotime($technicalPassport->given_date))}}</p>

					<p style="top: 144px;  left: 107px;" class="text-capitalize">{{' '.$technicalPassport->state}}</p>

					<p style="top: 158px;  left: 107px;" class="text-capitalize">{{$technicalPassport->id_number?$technicalPassport->id_number:$technicalPassport->inn}}</p>
				</div>
			</div>
		</div>
		<div class="back-side" style="">
			<p style="top: 1px; left: 245px;">{{$technicalPassport->series}}</p>
			<p style="top: 12px; left: 245px;">{{$technicalPassport->number}}</p>
			<p style="top: -1px; left: 154px;">9. {{' '.$technicalPassport->modelyear}}</p>
			<p style="top: 21px; left: 154px;">10. {{' '.$technicalPassport->vehicle_type}}</p>
			<p style="top: 42px; left: 154px;">11. @if($technicalPassport->corpusno)
											            {{$technicalPassport->corpusno}}
											          @elseif($technicalPassport->chassisno)
											            {{$technicalPassport->chassisno}}
											          @else
											            XXX
											          @endif</p>
			<p style="top: 63px; left: 154px; max-width: 160px; min-height: 24px;">12. {{ $technicalPassport->weight_full ? $technicalPassport->weight_full.'(kg)' : 'XXX' }}</p>
			<p style="top: 84px; left: 154px; min-height: 32px">13. {{ $technicalPassport->weight ? $technicalPassport->weight.'(kg)' : 'XXX' }}</p>
			<p style="top: 105px; left: 154px;">14. {{$technicalPassport->engineno?$technicalPassport->engineno:'XXX'}}</p>
			<p style="top: 129px; left: 154px;">15. {{ $technicalPassport->enginesize ? $technicalPassport->enginesize : 'XXX' }}</p>
			<p style="top: 149px; left: 154px;">16. {{$technicalPassport->fuel_type?$technicalPassport->fuel_type:'XXX'}}</p>
			<p style="top: 171px; left: 154px;">17. {{$technicalPassport->note?$technicalPassport->note:'XXX'}}</p>
		</div>
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
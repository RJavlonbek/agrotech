<!DOCTYPE html>

<html>

<head>

	<title></title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<style type="text/css">

		body{

			width: 90%;

			font-family: 'sanf-serif', 'Times new Roman';

		}

		@page{

			margin-right: 1cm;
			margin-left: 3cm;
		}

		.body-center{

			font-size: 18px;
		}

		.header-1, .header-2, .header-3{

			text-align: center;

		}

		.header-1, .header-2{

			margin-bottom: 20px;

				font-weight: 800;

		}


		.header-2{
			font-size: 18px;
		}


		.header-1{
			font-size: 19px;
		}



		.header-3{

			font-weight: 900;

			margin-bottom: 15px;


		}



		p.condition{

			display: inline-table;

			width: 110mm;

			border-bottom: 1px black solid;

			text-align: center;

		}



		.text-underlined{

			font-size: 25px;

			border-bottom: 1px black solid;

			margin-bottom: 7px;
			
			min-height: 32px;

			font-family: "Times New Roman";

			font-style: italic;
		}



		.text-bottom{

			font-size: 15px;

			margin-bottom: 12px; 

		}



		.row-flex{

		    display: -ms-flexbox;

		    display: flex;

		    -ms-flex-wrap: wrap;

		    flex-wrap: wrap;

		    margin-right: -15px;

		    margin-left: -15px;

		}



		.column-1{

			flex: 0 0 4.333333%;

    		max-width: 4.333333%;

		}



		.column-11{

			flex: 0 0 95.666667%;

    		max-width: 95.666667%;

		}



		.column-1, .column-11{

			position: relative;

    		width: 100%;

    		padding-right: 15px;

    		

    		padding-left: 15px;

		}

		.col-1, .column-1, .col-4{
			font-size: 25px;
		}

		input{
			width: 100%;
			background-color: white;
			border: 1px solid #A6A6A6; 
		}

		.btn{
			line-height: 1.2 !important;
			padding: .35rem .75rem
		}


	</style>

</head>

<body>

	<div class="header-1">

		Қишлоқ хўжалиги, мелиорация ва йўл-қурилиш техникаларини давлат рўйхатидан ўтказиш тартиби <br> тўғрисидаги низомга <br>
		10-ИЛОВА




	</div>

	<div class="header-2">

		(ТМ-1 ШАКЛ) <br> Қишлоқ хўжалиги, мелиорация ва йўл-қурилиш техникаси <br> ҳамда ўзиюрар машиналар тўғрисида 



	</div>

	<div class="header-3">
		М А Ъ Л У М О Т Н О М А № <strong>{{$tm_num}}</strong>
	</div>



	<div class="body-center">

		Техниканинг тақиқлари тўғрисида маълумот 
		<p class="condition font-weight-bold">
			@if($vehicle->lock_status=='lock')
				Taqiqqa olingan {{$vehicle->locker.' ('.$vehicle->lock_date.')'}}
			@elseif($vehicle->lock_status=='unlock')
				Taqiqqa olinmagan 
			@endif
		</p>
		<p>Техника эгаси тўғрисидаги маълумотлар:</p>
		<div class="row">

			<div class="col-12">

				<div class="row-flex">

					<div class="column-1">

						1.

					</div>

					<div class="column-11 left-margin">

						<p class="text-underlined font-weight-bold "><span class="text-capitalize">{{$owner->name.' '.$owner->lastname.' '.$owner->middlename}} </span> <?=($owner->type=='legal')?$owner->ownerform:'' ?> </p><p class="text-center text-bottom">(ташкилот номи ёки мулк эгасининг Ф.И.О.)</p>

					</div>

				</div>

				<div class="row-flex">

					<div class="column-1">

						2.

					</div>

					<div class="column-11 left-margin">

						<p class="text-underlined font-weight-bold">{{$owner->state.', '.$owner->city.', '.$owner->address}}</p><p class="text-center text-bottom">(манзили)</p>

					</div>

				</div>

			</div>

		</div>

		<p>Техника тўғрисидаги маълумотлар:</p>

		<div class="row">

			<div class="col-6">

				<div class="row">

					<div class="col-1">

						1.

					</div>

					<div class="col-11">

						<p class="text-underlined font-weight-bold">{{$vehicle->vehicle_type}}</p><p class="text-center text-bottom">Номи</p>

					</div>

				</div>

			</div>

			<div class="col-6">

				<div class="row">

					<div class="col-1">

						5.

					</div>

					<div class="col-11">

						<p class="text-underlined font-weight-bold">{{ $vehicle->modelyear }}</p><p class="text-center text-bottom">Ишлаб чиқарилган йили</p>

					</div>

				</div>

			</div>

			<div class="col-6">

				<div class="row">

					<div class="col-1">

						2.

					</div>

					<div class="col-11">

						<p class="text-underlined font-weight-bold">{{ $vehicle->brand }}</p><p class="text-center text-bottom">Русуми</p>

					</div>

				</div>

			</div>

			<div class="col-6">

				<div class="row">

					<div class="col-1">

						6.

					</div>

					<div class="col-11">

						<p class="text-underlined font-weight-bold">{{ $vehicle->engineno ? $vehicle->engineno : '-' }}</p><p class="text-center text-bottom">Двигатель рақами</p>

					</div>

				</div>

			</div>

			<div class="col-6">

				<div class="row">

					<div class="col-1">

						3.

					</div>

					<div class="col-11">

						<p class="text-underlined font-weight-bold">{{ $vehicle->factory_number }}</p><p class="text-center text-bottom">Завод рақами</p>

					</div>

				</div>

			</div>

			<div class="col-6">

				<div class="row">

					<div class="col-1">

						7.

					</div>

					<div class="col-11">

						<p class="text-underlined font-weight-bold">-</p><p class="text-center text-bottom">Двигатель русуми</p>

					</div>

				</div>

			</div>

			<div class="col-6">

				<div class="row">

					<div class="col-1">

						4.

					</div>

					<div class="col-11">

						<p class="text-underlined font-weight-bold">{{ $vehicle->passport_series.$vehicle->passport_number }}</p><p class="text-center text-bottom">Техник паспорт серияси ва рақами</p>

					</div>

				</div>

			</div>

			<div class="col-6">

				<div class="row">

					<div class="col-1">

						8.

					</div>

					<div class="col-11">

						<p class="text-underlined font-weight-bold">{{ $vehicle->registration_date }}</p><p class="text-center text-bottom">Рўйхатга қўйилган санаси</p>

					</div>

				</div>

			</div>

		</div>

		<div class="row">

			<div class="col-4">

				9. Қўшимча маълумотлар:

			</div>

			<div class="col-8">

				<p class="text-underlined font-weight-bold">
					@if($vehicle->type != 'agregat' && $vehicle->type != 'tirkama')
						Dvigatel quvvati: {{ $vehicle->enginesize }}
					@endif
				</p>

			</div>

			<div class="col-12">

				<p class="text-underlined font-weight-bold">
					@if($vehicle->type != 'agregat')
						Davlat raqami: {{ $vehicle->t_code.' '.$vehicle->t_series.' '.$vehicle->t_number }}
					@endif
				</p>

			</div>

		</div>

		<div class="row">

			<div class="col-12">

				<div class="row-flex">

					<div class="column-1">

						10.

					</div>

					<div class="column-11 left-margin">

						<p class="text-underlined font-weight-bold ">{{ getCityName($user->city_id) }}</p>
						<p class="text-center text-bottom">(Марказнинг бўлими ёки бўлинмаси номи)</p>

					</div>

				</div>

				<div class="row">

					<div class="col-12">

						<p class="text-underlined font-weight-bold">{{CheckPosition($user->id)}}</p><p class="text-center text-bottom">(лавозими, махсус гувоҳнома рақами)</p>

					</div>

				</div>

				<div class="row">

					<div class="col-8 text-center">

						<p class="text-underlined font-weight-bold">{{$user->lastname.' '.$user->name}}</p><p class="text-center text-bottom">(Ф.И.О.)</p>

					</div>

					<div class="col-4 text-center">

						<p class="text-underlined font-weight-bold" style="padding-bottom: 37px;"></p><p class="text-center text-bottom">(имзо)</p>

					</div>

				</div>
				@if(empty($type == 'old'))
					<p style="font-size: 20px; line-height: 25px; font-weight: 550; margin: 18px auto 22px auto">М.Ў.	Маълумотнома берилган сана: {{date('Y')}} йил «{{ date('d') }}»<span id="month"></span></p>
				@else
					<p style="font-size: 20px; line-height: 25px; font-weight: 550; margin: 18px auto 22px auto">М.Ў.	Маълумотнома берилган сана: {{date('Y', strtotime($tm->date))}} йил «{{ date('d', strtotime($tm->date)) }}»<span id="month"></span></p>
				@endif

				<p style="font-size: 18px; line-height: 28px;">

					Изоҳ. Ушбу маълумотнома техникаларнинг олди-сотдиси бўлганда, совға қилинганда, мерос қилиб қолдирилганда ёки бошқа ҳолларда шартнома тузилишида нотариал идоралар, савдо биржалари ва бошқалар томонидан талаб қилиниши лозим. Ушбу маълумотнома билан бирга техник паспорт тақдим этилиши шарт. Маълумотноманинг амал қилиш муддати 10 кун. Маълумотнома техниканинг нархини белгилашга ва ажратиладиган кредит суммасига, лизингга беришга асос бўла олмайди. 

				</p>

			</div>
			<hr/>
			<div class="col-12" id="payment-box">
				<div class="row">
					@if(empty($type == 'old'))
						<div class="col-12">
							<label>To'lov miqdori</label>
						</div>
						<div class="col-4">
							<input type="text" disabled name="payment" required value="{{$min->payment*($payment->payment/100)}}">
						</div>
						<div class="col-3">
							<label class="container-checkbox" style="display: flex;">to'landi
							  	<input type="checkbox" name="payment-check" class="check-paid" style="margin: auto;">
							  	<span class="checkmark"></span>
							</label>
						</div>
					@endif
					<div class="col-5">
						<button class="print-button btn btn-primary float-right" <?=$type=='new'?'disabled':'' ?> >Chop etish</button>
					</div>
				</div>
			</div>
		</div>

	</div>

<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		@if($type == 'new')
			$('.print-button').on('click',function(){
				$('#payment-box').hide();
				$('input[name="payment"]').attr('disabled', false);
				var payment = $('input[name="payment"]').val();
				$.ajax({
					type:'GET',
					url:'/vehicle/tm-formsubmit',
					data:'v_id={{$vehicle->id}}&o_id={{$owner->id}}&payment='+payment+'&number='+{{$tm_num}},
					success:function(){
						$('input[name="payment"]').attr('disabled', true);
						window.print();
					},
					error:function(){
						swal('Xatolik Oynani Yangilab qaytadan urinib korin', '', 'error');
					}
				});
			});
			$('input[name="payment-check"]').change(function(){
				var check = $(this).is(':checked');
				if(check){
					$('button.print-button').attr('disabled', false);
				}else{
					$('button.print-button').attr('disabled', true);
				}
			})
		@else
			$('.print-button').on('click',function(){
				$('#payment-box').hide();
				window.print();
			});
		@endif

		var month = new Array();
		  month[0] = "январь";
		  month[1] = "февраль";
		  month[2] = "март";
		  month[3] = "апрель";
		  month[4] = "май";
		  month[5] = "июнь";
		  month[6] = "июль";
		  month[7] = "август";
		  month[8] = "сентябрь";
		  month[9] = "октябрь";
		  month[10] = "ноябрь";
		  month[11] = "декабрь";

		  var d = new Date();
		  var n = month[d.getMonth()];
		  $('#month').text("  " + n);
	});
</script>

<script type="text/javascript">
	$(window).on("load", function(e) {

	// capitalizing text of the element with class "text-capitalize"
	if($('.text-capitalize').length){
		$('.text-capitalize').each(function(index){
			var t=$(this).text().trim();
			$(this).text(capitalize(t));
		});
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
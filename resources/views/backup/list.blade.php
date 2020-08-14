@extends('layouts.app')
@section('content')
<!-- page content -->
<style>
	<?php $userid = Auth::user()->id; ?>
</style>
<div class="section">
	<!-- PAGE-HEADER -->
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<i class="fe fe-life-buoy mr-1"></i>Elektron imzo ilovasi
			</li>
		</ol>
	</div>
	<!-- PAGE-HEADER END -->
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-10">
							<p class="imzo-warning">* Yuklab olingan arxiv faylni arxivdan chiqarib <b>C://ElektronImzo</b> manziliga saqlang. Imzo qo'yish uchun ushbu papkadagi <b>ElektronImzo.exe</b> ilovasini ishga tushiring.(Elektron imzo qurilmasi ulanganligini tekshiring)</p>
						</div>
						<div class="col-2">
							<a href="{!! url('/public/uploads/ElektronImzo.zip') !!}" download class="imzo-yuklash"><button class="btn btn-primary"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
						</div>
					</div>
				</div>
			</div>
			@if (CheckAdmin($userid)=='yes')

				<div class="page-header">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fe fe-life-buoy mr-1"></i>Ma'lumotlar bazasi
						</li>
					</ol>
				</div>
				<div class="card">									
					<div class="card-body">
						<div class="row">
							<div class="col-12 text-right">
								<button class="btn btn-primary" id="export-sql-button">
									Ma'lumotlar bazasini arxivlash
								</button>
							</div>

						</div>
						<div class="table-responsive">
							<table id="example-3" class="table table-striped table-bordered nowrap" style="margin-top:20px; width:100%;">
								<thead>
									<tr>
										<th>Fayl</th>
										<th class="border-bottom-0 border-top-0">{{ trans('app.Date')}}</th>
										<th class="border-bottom-0 border-top-0">Hajmi</th>
										<th class="border-bottom-0 border-top-0">{{ trans('app.Action')}}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($files as $file)
										<tr>
											<td>{{ $file->name }}</td>
											<td>{{ $file->date }}</td>
											<td>{{ $file->size }}</td>
											<td>
												<button filename={{$file->name}} class="btn btn-round btn-success sql-download-button">
													<i class="fa fa-download" style="line-height: 35px; "></i>  Yuklab olish
												</button>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
			<div class="page-header">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<i class="fe fe-life-buoy mr-1"></i> Bo'limlarga oid qo'llanmalar
					</li>
				</ol>
			</div>
			<div class="card">									
					<div class="card-body">
						<div class="table-responsive">
							<table id="example-3" class="table table-striped table-bordered nowrap instruction-table" style="margin-top:20px; width:100%;">
								<thead>
									<tr>
										<th>Bo'lim nomi</th>
										<th class="border-bottom-0 border-top-0">Fayl</th>
									</tr>
								</thead>
								<tbody>
										<tr>
											<td>Mulk egalari</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/mulk-egalari.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
										<tr>
											<td>Texnikalar</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/texnikalar.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
										<tr>
											<td>Texnik guvohnoma</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/texnik-guvohnoma.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
										<tr>
											<td>Texnik pasport</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/texnik-pasport.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
										<tr>
											<td>Traktorchi mashinist guvohnomasi</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/traktorchi-mashinist-guvohnomasi.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
										<tr>
											<td>Davlat raqami belgisi</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/davlat-raqam-belgisi.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
										<tr>
											<td>Xizmatlar</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/xizmatlar.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
										<tr>
											<td>Hisobotlar</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/hisobotlar.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
										<tr>
											<td>Planshetdan foydalanish</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/for-sign.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
										<tr>
											<td>Eski bazani kritish</td>
											<td>
												<a href="https://agroteh.uz/public/instruction/old-data.pdf" target="_blank" download class="imzo-yuklash"><button class="btn btn-success"><i class="fa fa-download"> </i>  Yuklab olish</button></a>
											</td>
										</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			
		</div>
	</div>
</div>
        <!-- /page content -->
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script>
	$(document).ready(function() {
		$('.sql-download-button').on('click',function(e){
			e.preventDefault();
			console.log('clicked');
			var url='/get-backup-file?filename='+$(this).attr('filename');
			$.ajax(url,{
				type:'GET',
				success:function(){
					window.location=url;
				}
			});
		});
    $('#datatable').DataTable( {
		responsive: true,
        "language": {
			 "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
			?>.json"
        }
    } );
} );
</script>
@endsection
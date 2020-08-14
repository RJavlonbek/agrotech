<!DOCTYPE html>
<html>
<head>
	<title>Excel</title>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('resources/views/layouts/assets/css/style.css') }}">
</head>
<body>
	<div class="card">
		<div class="card-body">
			<h3>Excel fayldagi texnikalar ma'lumotlarini tizimga avtomatik import qilish</h3>
			<ul class="ml-4 p-4" style="list-style-type: decimal;">
				<h4>Instruction</h4>
				<li>Berilgan formatda to'ldirilgan excel fayl tanlanib, jo'natiladi</li>
				<li>Faylda topilgan umumiy elementlar (texnikalar) soni, muvofaqqiyatli bajarilgan elementlar soni va xatolik topilgan elemetlar soni haqida ma'lumot keladi</li>
				<li><b>AGAR XATOLIKLAR BO'LSA: </b>Xatolik topilgan elementlardan tashkil topgan yangi jadval ko'rinadi, jadvalning oxirgi ustuni qanday xatolik topilganligi bo'yicha qisqacha ma'lumot beradi</li>
				<li>Yangi jadval avtomatik tarzda excel fayl ko'rinishida yuklab olinadi</li>
				<li>Yuklab olingan fayl (xato elementlardan tuzilgan fayl) ochilib, xatoliklarga qarab tuzatishlar kiritiladi</li>
				<li>Tuzatishlar kiritilgan fayl saqlanib, birinchi bosqichdan boshlab qaytadan bajariladi</li>
			</ul>
			<form method="POST" enctype="multipart/form-data">
				<label>Excel</label>
				<input type="file" name="file" />
				<input type="hidden" name="import" value="true">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<button type="submit">Import qilish</button>
			</form>
		</div>
	</div>

	@if(isset($rowsWithError) && !empty($rowsWithError) && isset($totalRows))
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3>{{ $totalRows." elementdan ".$successedRows." element bajarildi! " }}</h3>
						<h3 class="text-danger">{{ (count($rowsWithError)-2)." elementda xatolik topildi" }}</h3>
					</div>
					<div class="card-body">
						<table class="table table-bordered" style="background: #fff;" id="table-of-errors">
							@foreach($rowsWithError as $key => $row)
								@if($key==0 || $key==1)
									<tr>
										<?php
										for($i=0; $i<count($row); $i++){
											$cell = $row[$i];
											$colspan = 1;
											if($key==0){
												while(isset($row[$i+1]) && $row[$i+1]==''){
													$colspan++;
													$i++;
												}
											}
											?>
											<th {{ $colspan ? "colspan=".$colspan : "" }}><b>{{ $cell }}</b></th>
										<?php } ?>
									</tr>
								@else
									<tr>
										@foreach($row as $columnNumber => $cell)
											<td {{ $columnNumber==(count($row)-1) ? 'style=color:red;' : "" }}>
												{{ $cell }}
											</td>
										@endforeach
									</tr>
								@endif
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
	@endif
</body>

<script src="{{ URL::asset('resources/views/layouts/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>
<script sync type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/file-saver.min.js') }}"></script>
<script sync type="text/javascript" src="{{ URL::asset('resources/views/layouts/assets/plugins/table-export/blob.min.js') }}"></script>
<script type="text/javascript">
	function exportTableToExcel(tableID, filename = ''){
	    var downloadLink;
	    filename = filename?filename+'.xls':'report.xls';
	    var dataType = 'application/vnd.ms-excel';
	    var tableSelect = document.getElementById(tableID);

	    var tableHTML = "<table border='2px'><tr>";
        for(var j = 0 ; j < tableSelect.rows.length ; j++) 
        {     
        	if(tableSelect.rows[j]){
        		tableHTML=tableHTML+tableSelect.rows[j].innerHTML+"</tr>";
        	}
        }
        tableHTML=tableHTML+"</table>";
    	tableHTML=tableHTML.replace(/<span[^>]*>|<\/span>/g, "");
    	tableHTML=tableHTML.replace(/<a[^>]*>|<\/a>/g, "");

    	var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">'; // meta tag is important for cyrillic characters
    	tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    	tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    	tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    	tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    	tableHTML=tab_text+tableHTML+'</body></html>';

    	var blob=new Blob([tableHTML],{ type: "application/vnd.ms-excel" });
    	saveAs(blob, filename);
	}

	// function exportTableToExcel(tableID, filename = ''){
	//     var downloadLink;
	//     var dataType = 'application/vnd.ms-excel';
	//     var tableSelect = document.getElementById(tableID);
	//     var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
	    
	//     // Specify file name
	//     filename = filename?filename+'.xls':'excel_data.xls';
	    
	//     // Create download link element
	//     downloadLink = document.createElement("a");
	    
	//     document.body.appendChild(downloadLink);
	    
	//     if(navigator.msSaveOrOpenBlob){
	//         var blob = new Blob(['\ufeff', tableHTML], {
	//             type: dataType
	//         });
	//         navigator.msSaveOrOpenBlob( blob, filename);
	//     }else{
	//         // Create a link to the file
	//         downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
	    
	//         // Setting the file name
	//         downloadLink.download = filename;
	        
	//         //triggering the function
	//         downloadLink.click();
	//     }
	// }
	
</script>
@if(isset($rowsWithError) && count($rowsWithError) > 2)
	<script type="text/javascript">
		setTimeout(()=>{
			exportTableToExcel('table-of-errors', '{{ count($rowsWithError) - 2 }}-xatolik');
		}, 1000);
	</script>
@endif
</html>
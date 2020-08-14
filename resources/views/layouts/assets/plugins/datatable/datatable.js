$(function(e) {
	$('#examples1').DataTable({
		"searching":false,
		"pageLength": 50,
		"paging": false,
		"info": false,
		"language":{
			"search": "Qidirish: ",
            "lengthMenu": "Sahifada  _MENU_  ta qayd",
            "zeroRecords": "Ma'lumot topilmadi",
            "info": "_PAGES_ ta sahifadan _PAGE_ chisi",
            "infoFiltered":   "",
            "infoEmpty": "Ma'lumot mavjud emas",
            "paginate":{
            	"previous":"Avvalgi sahifa",
            	"next": "Keyingi sahifa"
            }
        }
	});
	var table = $('#example1').DataTable();
	$('#example2').DataTable( {
		"scrollY":        "200px",
		"scrollCollapse": true,
		"paging":         false,
		"pageLength": 50,
		"language":{
			"search": "Qidirish: ",
            "lengthMenu": "Sahifada  _MENU_  ta qayd",
            "zeroRecords": "Ma'lumot topilmadi",
            "info": "_PAGES_ ta sahifadan _PAGE_ chisi",
             "infoFiltered":   "",
            "infoEmpty": "Ma'lumot mavjud emas",
            "paginate":{
            	"previous":"Avvalgi sahifa",
            	"next": "Keyingi sahifa"
            }
        }
	});
	 $('#example3').DataTable( {
		responsive: {
			details: {
				display: $.fn.dataTable.Responsive.display.modal( {
					header: function ( row ) {
						var data = row.data();
						return 'Details for '+data[0]+' '+data[1];
					}
				} ),
				renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
					tableClass: 'table'
				} )
			}
		}
	});
	var table = $('#example').DataTable( {
		lengthChange: false,
		buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
	} );
	table.buttons().container()
		.appendTo( '#example_wrapper .col-md-6:eq(0)');
		
	//sample datatable	
	$('#example-2').DataTable();
	
	//Details display datatable
	$('#example-1').DataTable( {
		"pageLength": 50,
		"language":{
			"search": "Qidirish: ",
            "lengthMenu": "Sahifada  _MENU_  ta qayd",
            "zeroRecords": "Ma'lumot topilmadi",
            "info": "_PAGES_ ta sahifadan _PAGE_ chisi",
             "infoFiltered":   "",
            "infoEmpty": "Ma'lumot mavjud emas",
            "paginate":{
            	"previous":"Avvalgi sahifa",
            	"next": "Keyingi sahifa"
            }
        },
		responsive: {
			details: {
				display: $.fn.dataTable.Responsive.display.modal( {
					header: function ( row ) {
						var data = row.data();
						return data[1];
					}
				} ),
				renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
					tableClass: 'table'
				} )
			}
		}

	} );
	$('#datatable').DataTable( {
		"pageLength": 50,
		"language":{
			"search": "Qidirish: ",
            "lengthMenu": "Sahifada  _MENU_  ta qayd",
            "zeroRecords": "Ma'lumot topilmadi",
            "infoFiltered": "",
            "info": "_PAGES_ ta sahifadan _PAGE_ chisi",
            "infoEmpty": "Ma'lumot mavjud emas",
            "paginate":{
            	"previous":"Avvalgi sahifa",
            	"next": "Keyingi sahifa"
            }
        }
	} );



	$('#datatable-1').DataTable( {
		"pageLength": Infinity,
		"language":{
			"search": "Qidirish: ",
            "lengthMenu": "Sahifada  _MENU_  ta qayd",
            "zeroRecords": "Ma'lumot topilmadi",
            "info": "_PAGES_ ta sahifadan _PAGE_ chisi",
            "infoFiltered": "",
            "infoEmpty": "Ma'lumot mavjud emas",
            "paginate":{
            	"previous":"Avvalgi sahifa",
            	"next": "Keyingi sahifa"
            }
        }
	} );
	$('#example-3').DataTable( {
		"pageLength": Infinity,
		"language":{
			"search": "Qidirish: ",
            "lengthMenu": "Sahifada  _MENU_  ta qayd",
            "zeroRecords": "Ma'lumot topilmadi",
            "info": "_PAGES_ ta sahifadan _PAGE_ chisi",
            "infoFiltered": "",
            "infoEmpty": "Ma'lumot mavjud emas",
            "paginate":{
            	"previous":"Avvalgi sahifa",
            	"next": "Keyingi sahifa"
            }
        }
	} );
});
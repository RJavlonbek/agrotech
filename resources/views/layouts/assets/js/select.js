

$(document).ready(function() {

	'use strict';

	setTimeout(function(){
		$('.custom-select').select2({
			minimumResultsForSearch: Infinity
		});
	},200);



	var elements = $(".page-tab li a");

	for(var i=0; i < elements.length; i++){

		if(elements.eq(i).is(".active")){

			$(".page-tab").champ({

				active_tab: i+1

			});

		}

	}

	



	$(function() {

	'use strict';

	$('#datatable1').DataTable({

		responsive: true,

		language: {

			searchPlaceholder: 'Search...',

			sSearch: '',

			lengthMenu: '_MENU_ items/page',

		}

	});

	$('#datatable2').DataTable({

		bLengthChange: false,

		searching: false,

		responsive: true

	});

	// Select2

	$('.dataTables_length select').select2({

		minimumResultsForSearch: Infinity

	});

});

	});




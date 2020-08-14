(function($) {

	"use strict";

	



	/*PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=

feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=*/

	// ______________Full screen

	$("#fullscreen-button").on("click", function toggleFullScreen() {

		if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {

			if (document.documentElement.requestFullScreen) {

				document.documentElement.requestFullScreen();

			} else if (document.documentElement.mozRequestFullScreen) {

				document.documentElement.mozRequestFullScreen();

			} else if (document.documentElement.webkitRequestFullScreen) {

				document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);

			} else if (document.documentElement.msRequestFullscreen) {

				document.documentElement.msRequestFullscreen();

			}

		} else {

			if (document.cancelFullScreen) {

				document.cancelFullScreen();

			} else if (document.mozCancelFullScreen) {

				document.mozCancelFullScreen();

			} else if (document.webkitCancelFullScreen) {

				document.webkitCancelFullScreen();

			} else if (document.msExitFullscreen) {

				document.msExitFullscreen();

			}

		}

	})

	

	

	// ______________ PAGE LOADING

	$(window).on("load", function(e) {
		function reset_select2_size(obj)
{
    if (typeof(obj)!='undefined') {
        obj.find('.select2-container').parent().each(function() {
            $(this).find('.select2-container').css({"width":"10px"});
        });

        obj.find('.select2-container').parent().each(function() {
            var width = ($(this).width()-5)+"px";
            $(this).find('.select2-container').css({"width":width});
        });
        return;
    }

    $('.select2-container').filter(':visible').parent().each(function() {
        $(this).find('.select2-container').css({"width":"10px"});
    });
    $('.select2-container').filter(':visible').parent().each(function() {
        var width = ($(this).width()-5)+"px";
        $(this).find('.select2-container').css({"width":width});
    });
}

function onWindowResized( event )
{
    reset_select2_size();
}

onWindowResized();

$('.customer-type-button').on('click', onWindowResized());
	    
	    $('select.select-doc').one('change',function(e){
	        var formGroup=$(this).closest('.form-group');
	        if(formGroup){
	            var label='<label class="form-label">Asos hujjat ma\'lumotlari</label>';
	            var placeHolder='Hujjat tartib raqami, sanasi ...';
	            var input='<input class="form-control" name="doc-note" placeholder="'+placeHolder+'" type="text" />';
	            formGroup.after('<div class="form-group col-12">'+label+input+'</div>');
	        }
	    });

        $('.panel-tabs .add').on('click', function(e){
			var tab = $(this).attr('href');
			var a=$(tab +' a.slide-item').eq(0);
			location.href=a.attr('href');
			console.log(a);
			a.click();

		});
		
	    $("#list-date-filter input.from, #list-date-filter input.till").datetimepicker({
			format: "dd-mm-yyyy",
			autoclose: 1,
			minView: 2,
			startView:'decade',
			endDate: new Date(),
		});

		$('iframe').attr('frameBorder','0');

		// capitalizing text of the element with class "text-capitalize"
		if($('.text-capitalize').length){
			$('.text-capitalize').each(function(index){
				var t=$(this).text().trim();
				$(this).text(capitalize(t));
			});
		}
		
		$("#global-loader").fadeOut("slow");

		$('.tab_list a').on('click', function(e){
			var currentUrl = $(this).attr('href');
			var activeTab = $('a.slide-item[href="' + currentUrl +'"]').closest('.resp-tab-content').attr('aria-labelledby');
			window.localStorage.activeTab=activeTab;

			var activeTabPane = $('a.slide-item[href="' + currentUrl +'"]').closest('.tab-pane').attr('id');
			window.localStorage.activeTabPane=activeTabPane;

			var activeTabPane2 = $('a.slide-item[href="' + currentUrl +'"]').closest('.tab-pane');
			window.localStorage.activeTabPane2=activeTabPane2;

			//var active_slide = $('a.slide-item[href="' + currentUrl +'"]').index($('a.slide-item[href="' + currentUrl +'"]').parent().find('a'));
			var active_slide = $('a.slide-item[href="' + currentUrl +'"]').index(activeTabPane2 + ' a.slide-item');
			window.localStorage.active_slide = active_slide + 2;
		});

		$('a.slide-item').on('click',function(e){
			var activeTab = $(this).closest('.resp-tab-content').attr('aria-labelledby');
			window.localStorage.activeTab=activeTab;

			var activeTabPane=$(this).closest('.tab-pane').attr('id');
			window.localStorage.activeTabPane=activeTabPane;

			var active_slide = $(this).index('.resp-tab-content[aria-labelledby='+localStorage.activeTab+'] .tab-pane.active a');
			window.localStorage.active_slide = active_slide + 2;
		});

		$('.mainMenu').on("click", function(){
			localStorage.active_slide=100;
		})


		if(localStorage.active_slide == 100){
			$('.app-header .toggle').click();
		}

		if(localStorage.activeTab){
			$('.resp-tab-content[aria-labelledby='+localStorage.activeTab+']').addClass('resp-tab-content-active');
			$('.resp-tab-content[aria-labelledby='+localStorage.activeTab+'] .panel-tabs li a').removeClass('active');
			$('.resp-tab-content[aria-labelledby='+localStorage.activeTab+'] .tab-pane').removeClass('active');
			$('li.resp-tab-item[aria-controls='+localStorage.activeTab+']').addClass('resp-tab-active');
			$('a.slide-item').removeClass('active');
			$('#'+localStorage.activeTabPane+' .slide-item:nth-child('+ localStorage.active_slide + ')').addClass('active');
		}

		if(localStorage.activeTabPane){
			$('.tab-pane#'+localStorage.activeTabPane).addClass('active');
			$('.sidetab-menu li a[href="#'+localStorage.activeTabPane+'"]').addClass('active');
		}

		$('body').on('click','#list-date-filter .show-date', function(){
			$('.date').animate({
				opacity:1,
				marginLeft:'1%'
			},300,()=>{
				$(this).removeClass('show-date').addClass('hide-date');
				$(this).find('i').addClass('fa-angle-left').removeClass('fa-angle-right');
			});
		});

		$('body').on('click','#list-date-filter .hide-date',function(){
			$('.date').animate({
				opacity:0,
				marginLeft:'-200%'
			},300,()=>{
				$(this).removeClass('hide-date').addClass('show-date');
				$(this).find('i').removeClass('fa-angle-left').addClass('fa-angle-right');
			});
		});

		$('.amount').each(function(index){
			$(this).text(amountMake($(this).text()));
		});

		$('.print-table-button').on('click',function(){
			var table=$('#'+$(this).attr('table'));

			table.print({
				NoPrintSelector:'.no-print',
				title:'',
				prepend:'SOME text'
			});
		});

		$('body').on('click','#cancel-date-filter',function(){
			var form=$(this).closest('form');
			form.find('input').removeAttr('required').val('');
			form.submit();
		});

		$('#list-date-filter input').on('change',function(){
			var button=$(this).closest('form').find('button');
			if(button.is('#cancel-date-filter')){
				button.removeAttr('id').attr('type','submit').text('Filtrlash');
			}
		});

		$('.export-excel-button').on('click',function(){
			exportTableToExcel($(this).attr('table'),$(this).attr('filename'));
		});

		$('#export-sql-button').on('click',function(e){
			var th=$(this);
			th.addClass('btn-loading');
			$.ajax('/backup',{
				type:"GET",
				success:function(data){
					console.log(data);
					th.removeClass('btn-loading');
					window.location.reload();
				},
				error:function(err){
					console.log(err);
					//swal
				}
			});
		});

	});

	function capitalize(text){
		var words=text.trim().split(' ');
		for(var i=0;i<words.length;i++){
			if(words[i]){
				words[i]=words[i][0].toUpperCase()+words[i].substring(1).toLowerCase();
			}
		}
		return words.join(' ');
	}

	function amountMake(amount=0,multiplier=1,currency=''){
	  var a=amount.toString().trim();
	  var res=[];
	  var c=0;
	  for(var i=a.length-1;i>=0;i--){
	    c++;
	    res.unshift(a[i]);
	    if((c % 3==0) && i!=0){
	      res.unshift(' ');
	    }
	  }
	  return res.join('')+' '+currency;
	}

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

    	var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    	tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    	tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    	tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    	tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    	tableHTML=tab_text+tableHTML+'</body></html>';

    	var blob=new Blob([tableHTML],{ type: "application/vnd.ms-excel" });
    	saveAs(blob, filename);
	}

	

	// ______________ BACK TO TOP BUTTON

	$(window).on("scroll", function(e) {

		if ($(this).scrollTop() > 0) {

			$('#back-to-top').fadeIn('slow');

		} else {

			$('#back-to-top').fadeOut('slow');

		}

	});

	$("#back-to-top").on("click", function(e) {

		$("html, body").animate({

			scrollTop: 0

		}, 600);

		return false;

	});

	

	// ______________ COVER IMAGE

	$(".cover-image").each(function() {

		var attr = $(this).attr('data-image-src');

		if (typeof attr !== typeof undefined && attr !== false) {

			$(this).css('background', 'url(' + attr + ') center center');

		}

	});

	

	// ______________ RATING STAR

	var ratingOptions = {

		selectors: {

			starsSelector: '.rating-stars',

			starSelector: '.rating-star',

			starActiveClass: 'is--active',

			starHoverClass: 'is--hover',

			starNoHoverClass: 'is--no-hover',

			targetFormElementSelector: '.rating-value'

		}

	};

	$(".rating-stars").ratingStars(ratingOptions);

	

	

	// ______________Chart-circle

	if ($('.chart-circle').length) {

		$('.chart-circle').each(function() {

			let $this = $(this);

			$this.circleProgress({

				fill: {

					color: $this.attr('data-color')

				},

				size: $this.height(),

				startAngle: -Math.PI / 4 * 2,

				emptyFill: '#f6f6f6',

				lineCap: 'round'

			});

		});

	}

	

	// ______________ GLOBAL SEARCH

	$(document).on("click", "[data-toggle='search']", function(e) {

		var body = $("body");



		if(body.hasClass('search-gone')) {

			body.addClass('search-gone');

			body.removeClass('search-show');

		}else{

			body.removeClass('search-gone');

			body.addClass('search-show');

		}

	});

	var toggleSidebar = function() {

		var w = $(window);

		if(w.outerWidth() <= 1024) {

			$("body").addClass("sidebar-gone");

			$(document).off("click", "body").on("click", "body", function(e) {

				if($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {

					$("body").removeClass("sidebar-show");

					$("body").addClass("sidebar-gone");

					$("body").removeClass("search-show");

				}

			});

		}else{

			$("body").removeClass("sidebar-gone");

		}

	}

	toggleSidebar();

	$(window).resize(toggleSidebar);

	

	/** Constant div card */

	const DIV_CARD = 'div.card';

	/** Initialize tooltips */

	$('[data-toggle="tooltip"]').tooltip();

	/** Initialize popovers */

	$('[data-toggle="popover"]').popover({

		html: true

	});

	

	// ______________ FUNCTION FOR REMOVE CARD

	$('[data-toggle="card-remove"]').on('click', function(e) {

		let $card = $(this).closest(DIV_CARD);

		$card.remove();

		e.preventDefault();

		return false;

	});

	

	// ______________ FUNCTIONS FOR COLLAPSED CARD

	$('[data-toggle="card-collapse"]').on('click', function(e) {

		let $card = $(this).closest(DIV_CARD);

		$card.toggleClass('card-collapsed');

		e.preventDefault();

		return false;

	});

	/*PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=

feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=*/

	// ______________ CARD FULL SCREEN

	$('[data-toggle="card-fullscreen"]').on('click', function(e) {

		let $card = $(this).closest(DIV_CARD);

		$card.toggleClass('card-fullscreen').removeClass('card-collapsed');

		e.preventDefault();

		return false;

	});

	$('button[type="submit"]').on('click', function(){
		console.log('clicked');
		var form = $(this).closest("form");
		form.find('select').each(function(){
			var select=$(this); 
			if(select.attr('required') && !select.attr('disabled') && !select.val()){
				let selectBox=select.siblings().filter('span.select2');
				selectBox.addClass('qowildi');
				selectBox.attr('data-original-title',"Maydonni to'ldiring");
				selectBox.attr('rel','tooltip');
				selectBox.addClass('red-border');
				$(this).blur();
				console.log($(this).attr('name'));
				selectBox.tooltip({placement: 'bottom',trigger: 'manual'}).tooltip('show');
				selectBox.on('click',function(){
					selectBox.tooltip('hide');
					selectBox.removeClass('red-border');
				});
			}else{
				console.log('else',select.attr('required')+' '+select.val());
			}
		});
	});



	if($('input.check-paid').length && !($('input.check-paid').is(":checked"))){
			$('.btn[type="submit"]').attr('disabled','disabled');
		}

	$('input.check-paid').on('change', function(){
		if(($('input.check-paid').is(":checked"))){
			$('.btn[type="submit"]').removeAttr('disabled');
		}
		else if(!($('input.check-paid').is(":checked"))){
			$('.btn[type="submit"]').attr('disabled','disabled');
		}
	});

	



	

	

	// ______________Skins

	

	/*//////////////////// Header skins  //////////////////////*/

	

	//$('body').addClass("default-header"); // 

	

	// $('body').addClass("color-header"); //

	

	// $('body').addClass("dark-header"); //

	

	/*//////////////////// Horizontal skins  //////////////////////*/

	

	//$('body').addClass("default-hor");  //

	

	// $('body').addClass("light-hor"); //

	

	// $('body').addClass("dark-hor"); //

	

	/*//////////////////// Left-menu skins  //////////////////////*/

	

	//$('body').addClass("default-left"); // 

	

	//$('body').addClass("light-left"); // 

	

	//$('body').addClass("dark-left"); // 

	

	//$('body').addClass("menu-style1"); // 

	

})(jQuery);


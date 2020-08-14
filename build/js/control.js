$("input.search_for").keyup(function() {
	var url = $(this).attr("url");
	var box = $(this).siblings(".box_result");
	var result = $(this).siblings(".box_result");
    $.ajax({
        type: "GET",
        url: url,
        data: "search=" + $(this).val(),
        success: function(data) {
            if (data!='01') {
                box.show();
                result.children(".result").html(data);
            }
           
        }
    });
});

function select_type(id, type, name) {
    if (type=='brand') {
    	$("#brand").hide();
    	$("#brand_id").siblings(".form-control").val(name);
    	$("#brand_id").val(id);
    }else if (type=='factory'){
    	$("#factory").hide();
    	$("#factory_id").siblings(".form-control").val(name);
    	$("#factory_id").val(id);
    }else if(type=='owner'){
    	$("#owner").hide();
    	$("#owner_id").siblings(".form-control").val(name);
    	$("#owner_id").val(id);
    }else if(type=='type'){
    	$("#type").hide();
    	$("#vehicle_type").siblings(".form-control").val(name);
    	$(this).parents(".form-control").val(name);
    	$("#vehicle_type").val(id);

    }
}

$("input.owner_search").keyup(function() {
    var url = $(this).attr("url");
    var box = $(this).siblings(".box_result");
    var result = $(this).siblings(".box_result");
    $.ajax({
        type: "GET",
        url: url,
        data: "search=" + $(this).val(),
        success: function(data) {
            if (data!='01') {
                box.show();
                result.children(".result").html(data);
            }
           
        }
    });
});
$("input.vehicle_search").keyup(function() {
    var url = $(this).attr("url");
    var box = $(this).siblings(".box_result");
    var result = $(this).siblings(".box_result");
    var owner_id = $("#owner_id").val();
    $.ajax({
        type: "GET",
        url: url,
        data: "search=" + $(this).val()+"&owner_id="+2,
        success: function(data) {
            if (data!='01') {
                box.show();
                result.children(".result").html(data);
            }
           
        }
    });
});
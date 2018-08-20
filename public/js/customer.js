$(document).ready(function(){
	$(".export_change").change(function(){
		var vendor_code = $("#vendor_code").val();
		var location_name = $("#location").val();
		$.ajax({
			type : "get",
			url:'../../admin/location-count',
			data:{location:location_name,vendor_code:vendor_code},
			success: function(data) {
				$("#location_count").val(data);
				$('#from_count').attr({"max":data});
				$('#to_count').attr({"max":data});
			}
		});
	});
	$(".count_value").keyup(function(){
		  var exportCount = parseInt($('#to_count').val())-parseInt($('#from_count').val())+parseInt(1);
		  $("#export_count").val(exportCount);
		  console.log(exportCount);
	})
});

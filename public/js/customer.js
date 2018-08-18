$(document).ready(function(){
	$("#location").change(function(){
		var location_name = $("#location").val();
		$.ajax({
			type : "get",
			url:'../../admin/location-count',
			data:{location:location_name},
			success: function(data) {
				$("#location_count").val(data);
				$('#from_count').attr({"max":data});
				$('#to_count').attr({"max":data});
			}
		});
	});
});

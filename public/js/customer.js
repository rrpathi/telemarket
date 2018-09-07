$(document).ready(function(){
	$( window ).on("load", function() {
		$('#vendor_code').hide();
	});
	$(".category_change").change(function(){
		var location = $("#location").val();
		var category_value = $("#database_type").val();
		$.ajax({
			type : "get",
			url:'/admin/catagory-change',
			data:{location:location,category_value:category_value},
			success: function(data) {
				$('#optionData').html(data);
				$('.export_change').trigger('change');
			}
		});
	});
	$('body').on('change', '.export_change', function() {
		var vendor_code = $("#vendor_code").val();
		var location = $("#location").val();
		var database_type = $("#database_type").val();
		var category_value = $("#category").val();
		// console.log(category_value);
		if (category_value!='') {
			$('#vendor_code').show();
		}
		$.ajax({
			type : "get",
			url:'/admin/location-count',
			data:{location:location,vendor_code:vendor_code,database_type:database_type,category_value:category_value},
			success: function(data) {
				$("#location_count").val(data);
				$('#from_count').attr({"max":data});
				$('#to_count').attr({"max":data});
			}
		});
	});
	$(".count_value").on('keyup change',function(){
		  var exportCount = parseInt($('#to_count').val())-parseInt($('#from_count').val())+parseInt(1);
		  $("#export_count").val(exportCount);
		  // console.log(exportCount);
	})

	// GET EXPORT DATA COUNT
	$('body').on('change', '#exportCustomer', function() {
		var exportCustomer = $("#exportCustomer option:selected").val();
		$.ajax({
			type : "get",
			url:'/admin/customer_export_count',
			data:{customer_id:exportCustomer},
			success: function(data) {
				console.log(data);
				if(data['count']!=''){
					$("#showTableData").html(data.table);
					$('#CustomerCount').val(data.count);
					$('#CustomerCount').attr('readonly', true);
				}else{
					$('#CustomerCount').attr('readonly', false);
				}
			}
		});
	});

});

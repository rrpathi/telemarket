$(document).ready(function(){
	$( window ).on("load", function() {
		$('#vendor_code').hide();
	});

    $('body').on('change','.location_change',function() {
        var location = $("#location").val();
        $.ajax({
            type : "get",
            url:'/admin/location_change',
            data:{location:location},
            success: function(data) {
                $('#DatabaseTypeData').html(data);
                $('.category_change').trigger('change');
            }
        });
    });


    $('body').on('change','.database_type_change',function(){
		var location = $("#location").val();
		var database_type = $("#database_type").val();
		$.ajax({
			type : "get",
			url:'/admin/database_type_change',
			data:{location:location,database_type:database_type},
			success: function(data) {
				// console.log(data);
                $('#CategoryDatas').html(data);
                $('.export_change').trigger('change');
			}
		});
	});

    $('body').on('change','.catagory_change',function(){
        var location = $("#location").val();
        var database_type = $("#database_type").val();
        var category_value = $("#category").val();
        $.ajax({
            type : "get",
            url:'/admin/catagory_change',
            data:{location:location,category_value:category_value,database_type:database_type},
            success: function(data) {
                // console.log(data);
                $('#VendorCodeData').html(data);
                $('.export_data_count').trigger('change');
            }
        });
    });


	$('body').on('change', '.export_data_count', function() {
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
				// console.log(data);
				if(data ==''){
					$("#showTableData").html('');
					$('#CustomerCount').val('');
					$('#CustomerCount').attr('readonly', false);
				}else{
					if(data['count']!=''){
						$("#showTableData").html(data.table);
						$('#CustomerCount').val(data.count);
						$('#CustomerCount').attr('readonly', true);
					}else{
						$("#showTableData").html('');
						$('#CustomerCount').val('');
						$('#CustomerCount').attr('readonly', false);
					}
				}
			}
		});
	});

 // for staffs re coded
	$('body').on('change', '.ExportsCustomer', function() {
		var ExportsCustomer = $(".ExportsCustomer option:selected").val();
		$.ajax({
			type : "get",
			url:'/staff/customer_export_count',
			data:{customer_id:ExportsCustomer},
			success: function(data) {
				console.log(data);
					if(data ==''){
					$("#showTableDataS").html('');
					$('#CustomerCount').val('');
					$('#CustomerCount').attr('readonly', false);
				}else{
					if(data['count']!=''){
						$("#showTableDataS").html(data.table);
						$('#CustomerCount').val(data.count);
						$('#CustomerCount').attr('readonly', true);
					}else{
						$("#showTableDataS").html('');
						$('#CustomerCount').val('');
						$('#CustomerCount').attr('readonly', false);
					}
				}
			}
		});
	});

	$('body').on('change', '#exportCustomerData', function() {
		var exportCustomer = $("#exportCustomerData option:selected").val();
		$.ajax({
			type : "get",
			url:'/staff/customer_export_status',
			data:{customer_id:exportCustomer},
			success: function(data) {
				$('#ApprovalData').html('');
				$('#exportStatus').val('');
				$('#CustomerDisctiption').val('');
					// console.log(data);
				if (data!='') {
					if(data.tempData.remaining_count==0){
						$('#ApprovalData').html(data.table);
						if(data.tempData.approvedStatus==0){
							var status = "Waiting for Approval";
							$('#exportButtonStaff').attr("disabled", "disabled");
						}else if(data.tempData.approvedStatus==1){
							var status = "Approved";
							$('#exportButtonStaff').removeAttr("disabled");
						}else{
							var status = "Rejected";
							$('#exportButtonStaff').attr("disabled", "disabled");
						}
						$('#exportStatus').val(status);
						$('#CustomerDisctiption').val(data.tempData.discription);
					}else{
						$('#ApprovalData').html('');
						$('#exportStatus').val('Data Nill For Export');
						$('#CustomerDisctiption').val('');
						$('#exportButtonStaff').attr("disabled", "disabled");
					}
				}else{
					$('#exportStatus').val('Data Nill For Export');
					$('#exportButtonStaff').attr("disabled", "disabled");
				}
			}
		});
	});



	$('body').on('change', '#exportApproval', function() {
		var exportApproval = $("#exportApproval").val();
		$.ajax({
			type : "get",
			url:'/admin/getExportApprovalStatus',
			data:{customer_id:exportApproval},
			success: function(data) {
					console.log(data.tempData);
					$('input[name=approvedStatus]').prop("checked", false);
					$('#CustomerDisctiption').val('');
				if(data!=''){
					$('#ApprovalData').html(data.table);
					$('#CustomerDisctiption').attr("disabled", false);
					$('#adminApproved').attr("disabled", false);
					$('#adminDisapproved').attr("disabled", false);
						if(data.tempData.approvedStatus==1){
							$('#adminApproved').prop("checked", true);
							$('#CustomerDisctiption').val(data.tempData.discription);
						}else if(data.tempData.approvedStatus==2){
							$('#adminDisapproved').prop("checked", true);
							$('#CustomerDisctiption').val(data.tempData.discription);
						}
				}else{
					$('#adminApproved').attr("disabled", "disabled");
					$('#adminDisapproved').attr("disabled", "disabled");
					$('#CustomerDisctiption').attr("disabled", "disabled");
					$('#CustomerDisctiption').val('');
					$('#ApprovalData').html('');
				}
			}
		});
	});
});

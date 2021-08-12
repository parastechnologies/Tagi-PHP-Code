$('document').ready(function() {
	// select all checkbox	
	$(document).on('click', '#select_all', function() {          	
		$(".emp_checkbox").prop("checked", this.checked);
		$("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
	});	
	$(document).on('click', '.emp_checkbox', function() {		
		if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
			$('#select_all').prop('checked', true);
		} else {
			$('#select_all').prop('checked', false);
		}
		$("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
	});  
	// delete selected records
	jQuery('#delete_records').on('click', function(e) { 
		var employee = [];  
		$(".emp_checkbox:checked").each(function() {  
			employee.push($(this).data('emp-id'));
		});	
		if(employee.length <=0)  {  
			alert("Please select records.");  
		}  
		else { 	
			WRN_PROFILE_DELETE = "Are you sure you want to delete "+(employee.length>1?"these":"this")+" row?";  
			var checked = confirm(WRN_PROFILE_DELETE);  
			if(checked == true) {			
				var selected_values = employee.join(","); 
				
				$.ajax({ 
					type: "POST",  
					url: "https://controlpanel.tagmoi.co/dashboard/deleteSelectedTag",  
					cache:false,  
					data: 'emp_id='+selected_values,  
					success: function(response) {	
					    
						// remove deleted employee rows
						var emp_ids = response.split(",");
						for (var i=0; i<emp_ids.length; i++ ) {						
							$("#"+emp_ids[i]).remove();
						}
						window.location.reload();
					}   
				});				
			}  
		}  
	});
});
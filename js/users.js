function refreshAddModal(){	
	// remove text from invalid
	$('.invalid-feedback').text('');
	$('#username').removeClass('is-invalid');
	$('#password').removeClass('is-invalid');
	$('#confirm_password').removeClass('is-invalid');
}

$(document).ready(function() {
    var user_datatable = $('#userTable').DataTable({
        'ajax': 'get-users.php',
        'order': [],
	});

	//checkbox on edit model
	$('#edit_password').prop('disabled', true);
	$('#edit_confirm_password').prop('disabled', true);

	$('#change_password').change(function() {
		if($('#change_password').is(':checked')){
			$('#edit_password').prop('disabled', false);
			$('#edit_confirm_password').prop('disabled', false);
		}else{
			$('#edit_password').prop('disabled', true);
			$('#edit_confirm_password').prop('disabled', true);
		}
	});	

	$('#addUserModalBtn').on('click', function(){
		// reset the form text
		$("#addUserForm")[0].reset();
		refreshAddModal();

		$(document).on('submit', '#addUserForm', function(event){
			event.preventDefault();

			refreshAddModal();

			var username = $("#username").val();		

			if(username == "") {
				$("#username").addClass('is-invalid');
				$('#username_invalid').text('Please enter username!');
			}
			if(username){
				var form = $(this);
				// button loading
				$("#add-loading").removeClass('d-none');

				$.ajax({
					url : 'add-users.php',
					type: 'POST',
					data: form.serialize(),
					dataType: 'json',
					success:function(response) {
						//remove loading
						$("#add-loading").addClass('d-none');
						console.log(response);
						if(response.success == true) {
							// reload the manage member table 
							user_datatable.ajax.reload(null, false);	

							// reset the form text
							$("#addUserForm")[0].reset();					
							refreshAddModal();		
																				
						}else if(response.success == false){
							if(response.messages.username){
								$('#username').addClass('is-invalid');
								$('#username_invalid').text(response.messages.username);
							}
							if(response.messages.password){
								$('#password').addClass('is-invalid');
								$('#password_invalid').text(response.messages.password);
							}
							if(response.messages.confirm_password){
								$('#confirm_password').addClass('is-invalid');
								$('#confirm_password_invalid').text(response.messages.confirm_password);
							}
							if(response.messages.error){
								//toastr
							}
						}
					}
				});
			}						
			return false;
		});
	});
});

function refreshEditModal(){	
	// remove text from invalid
	$('.invalid-feedback').text('');
	$('#edit_username').removeClass('is-invalid');
	$('#edit_role').removeClass('is-invalid');
	//$('#edit_division').removeClass('is-invalid');
	$('#edit_password').removeClass('is-invalid');
	$('#edit_confirm_password').removeClass('is-invalid');
}

function editUser(user_id = null) {
	if(user_id) {
		// remove the added user id 
		$('#edit_user_id').remove();

		// reset the form text
		$("#editUserForm")[0].reset();
		refreshEditModal();				

		$.ajax({
			url: 'get-selected-user.php',
			type: 'post',
			data: {edit_user_id: user_id},
			dataType: 'json',
			success:function(response) {
				console.log(response);
				$("#edit_username").val(response.username);
				$("#edit_role").val(response.role);
				//$("#edit_division").val(response.division);

				// add the user id 
				$("#editUserFooter").after('<input type="hidden" name="edit_user_id" id="edit_user_id" value="' + response.user_id + '" />');
				
				$(document).on('submit', '#editUserForm', function(event){
					event.preventDefault();

					refreshEditModal();

					var form = $(this);
					// button loading
					$("#edit-loading").removeClass('d-none');

					$.ajax({
						url : form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							// remove loading
							$("#edit-loading").addClass('d-none');

							if(response.success == true) {
								// reload the manage member table 
								user_datatable.ajax.reload(null, false);									  	  			
								
								refreshEditModal();
							} 
						}
					});
					return false;
				});
			}
		});
	} else {
		alert('Oops!! Refresh the page');
	}
}

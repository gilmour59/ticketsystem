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

function editUser(user_id = null) {
	if(user_id) {
		// remove the added categories id 
		$('#editCategoriesId').remove();
		// reset the form text
		$("#editCategoriesForm")[0].reset();
		// reset the form text-error
		$(".text-danger").remove();
		// reset the form group errro		
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// edit categories messages
		$("#edit-categories-messages").html("");
		// modal spinner
		$('.modal-loading').removeClass('div-hide');
		// modal result
		$('.edit-categories-result').addClass('div-hide');
		//modal footer
		$(".editCategoriesFooter").addClass('div-hide');		

		$.ajax({
			url: 'php_action/fetchSelectedCategories.php',
			type: 'post',
			data: {user_id: user_id},
			dataType: 'json',
			success:function(response) {

				// modal spinner
				$('.modal-loading').addClass('div-hide');
				// modal result
				$('.edit-categories-result').removeClass('div-hide');
				//modal footer
				$(".editCategoriesFooter").removeClass('div-hide');	

				// set the categories name
				$("#editCategoriesName").val(response.categories_name);
				// set the categories status
				$("#editCategoriesStatus").val(response.categories_active);
				// add the categories id 
				$(".editCategoriesFooter").after('<input type="hidden" name="editCategoriesId" id="editCategoriesId" value="'+response.categories_id+'" />');


				// submit of edit categories form
				$("#editCategoriesForm").unbind('submit').bind('submit', function() {
					var categoriesName = $("#editCategoriesName").val();
					var categoriesStatus = $("#editCategoriesStatus").val();

					if(categoriesName == "") {
						$("#editCategoriesName").after('<p class="text-danger">Brand Name field is required</p>');
						$('#editCategoriesName').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editCategoriesName").find('.text-danger').remove();
						// success out for form 
						$("#editCategoriesName").closest('.form-group').addClass('has-success');	  	
					}

					if(categoriesStatus == "") {
						$("#editCategoriesStatus").after('<p class="text-danger">Brand Name field is required</p>');
						$('#editCategoriesStatus').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editCategoriesStatus").find('.text-danger').remove();
						// success out for form 
						$("#editCategoriesStatus").closest('.form-group').addClass('has-success');	  	
					}

					if(categoriesName && categoriesStatus) {
						var form = $(this);
						// button loading
						$("#editCategoriesBtn").button('loading');

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {
								// button loading
								$("#editCategoriesBtn").button('reset');

								if(response.success == true) {
									// reload the manage member table 
									manageCategoriesTable.ajax.reload(null, false);									  	  			
									
									// remove the error text
									$(".text-danger").remove();
									// remove the form error
									$('.form-group').removeClass('has-error').removeClass('has-success');
			  	  			
			  	  			$('#edit-categories-messages').html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
								}  // if

							} // /success
						}); // /ajax	
					} // if


					return false;
				}); // /submit of edit categories form

			} // /success
		}); // /fetch the selected categories data

	} else {
		alert('Oops!! Refresh the page');
	}
}

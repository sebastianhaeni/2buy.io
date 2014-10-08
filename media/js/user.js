(function($){
	$('#change-password form').submit(function(){
		
		var oldPassword = $('#change-old-password').val();
		var newPassword = $('#change-new-password').val();
		
		$.ajax({
			url: '/api/v1/user/password',
			method: 'put',
			data: {oldPassword: oldPassword, newPassword: newPassword},
			success: function(response){
				console.log(response);
			},
			error: function(response){
				console.log(response);
			}
		});
		
		return false;
	});
})(jQuery);
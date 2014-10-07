(function($){
	$('#signup-form').submit(function(){
		var data = $(this).serialize();
		$('#signup-form :input').prop('disabled', true);
		
		$.ajax({
			url: 'api/v1/user/register',
			data: data,
			method: 'post',
			success: function(response){
				$('#signup-form').hide();
				$('#signup-success-message').removeClass('hide');
			},
			error: function(response){
				// TODO show error message
				$('#signup-form :input').prop('disabled', false);
			}
		});
		
		return false;
	});
})(jQuery);
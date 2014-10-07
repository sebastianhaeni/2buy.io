(function($){
	$('#signin-form').submit(function(){
		var data = $(this).serialize();
		$('#signin-form :input').prop('disabled', true);
		
		$.ajax({
			url: 'api/v1/user/login',
			data: data,
			method: 'post',
			success: function(response){
				window.location.href = 'app';
			},
			error: function(response){
				// TODO show error message
				$('#signin-form :input').prop('disabled', false);
			}
		});
		
		return false;
	});
})(jQuery);
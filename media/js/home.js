(function($){
	$.ajax({
		url: 'api/v1/user/isLoggedIn',
		success: function(responseText, responseContent, response){
			if(response.status == 202){
				window.location.href = 'app';
			}
		}
	});
})(jQuery);
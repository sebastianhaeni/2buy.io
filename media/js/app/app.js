(function($) {
	
	$.ajax({
		url: '/api/v1/user/isLoggedIn',
		error: function(){
			window.location.href = 'signin';
		}
	});
	
	$.ajax({
		url: '/api/v1/community/' + $.cookie('community'),
		success: function(response){
			$('#community-name').html(response.name);
		}
	});

	$('#logout').click(function(){
		logout();
	});

	function logout(){
		$.ajax({
			url: '/api/v1/user/logout',
			success: function(){
				window.location.href = '/';
			}
		});
	}

})(jQuery);
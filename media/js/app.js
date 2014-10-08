(function($) {
	
	$.ajax({
		url: '/api/v1/user/isLoggedIn',
		error: function(){
			window.location.href = 'signin';
		}
	});

	$('#history').click(function() {
		showHistory($(this));
	});

	$('#stats').click(function() {
		showStats($(this));
	});

	$('#shopping').click(function() {
		showShoppingList($(this));
	});

	$('#products').click(function() {
		showProducts($(this));
	});
	
	$('#logout').click(function(){
		logout();
	});

	if (window.location.hash == "#history") {
		showHistory($('#history'));
	} else if (window.location.hash == "#stats") {
		showStats($('#stats'));
	} else if (window.location.hash == "#products") {
		showProducts($('#products'));
	}
	
	function logout(){
		$.ajax({
			url: '/api/v1/user/logout',
			success: function(){
				window.location.href = '/';
			}
		});
	}

})(jQuery);
(function($) {
    $.ajax({
        url : 'api/v1/user/isLoggedIn',
        success : function(response) {
            if (response.loggedIn) {
            	
            	if(window.location.pathname == '/signup' || window.location.pathname == '/signin'){
            		window.location.href = 'app';
            		return;
            	}
            	
            	$('.logged-in').removeClass('hide');
            	$('.not-logged-in').hide();
            }
        }
    });
})(jQuery);
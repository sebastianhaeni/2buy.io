(function($) {
    $.ajax({
        url : 'api/v1/user/isLoggedIn',
        success : function(response) {
            if (response.loggedIn) {
                window.location.href = 'app';
            }
        }
    });
})(jQuery);
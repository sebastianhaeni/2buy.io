(function($) {
    $('#signin-form').submit(function() {
        var data = $(this).serialize();
        $('#signin-form :input').prop('disabled', true);

        $.ajax({
            url : 'api/v1/user/login',
            data : data,
            method : 'post',
            success : function(response) {
                window.location.href = 'app';
            },
            error : function(response) {
                $('#signin-form :input').prop('disabled', false);
                $('#signin-error-message').removeClass('hide');
                $('#login-password').val('').focus();
            }
        });

        return false;
    });

    $('#signin-form :input').on('input', function() {
        $('#signin-error-message').addClass('hide');
    });
})(jQuery);
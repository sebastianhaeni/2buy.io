(function($) {
    $('#signup-form').submit(function() {
        var data = $(this).serialize();
        $('#signup-form :input').prop('disabled', true);

        $.ajax({
            url : '/api/v1/user/register',
            data : data,
            method : 'post',
            success : function(response) {
                $('#signup-form').hide();
                $('#signup-error-message').addClass('hide');
                $('#signup-success-message').removeClass('hide');
            },
            error : function(response) {
                console.log(response);
                $('#signup-form :input').prop('disabled', false);
                $('#signup-error-message').removeClass('hide');
            }
        });

        return false;
    });
    
    $('#register-password-repeat').keyup(function(){
        if($(this).val() != $('#register-password').val()){
            this.setCustomValidity("✗");
        } else {
            this.setCustomValidity("");
        }
    });

    $('#signup-form :input').on('input', function() {
        $('#signup-error-message').addClass('hide');
    });
})(jQuery);
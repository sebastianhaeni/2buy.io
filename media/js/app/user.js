(function($) {
    'use strict';

    $('#change-password form').submit(function() {
        var oldPassword = $('#change-old-password').val();
        var newPassword = $('#change-new-password').val();

        $(this).find(':input').prop('disabled', true);

        $.ajax({
            url : '/api/v1/user/password',
            method : 'put',
            data : {
                oldPassword : oldPassword,
                newPassword : newPassword
            },
            success : function(response) {
                $('#change-old-password').val('');
                $('#change-new-password').val('');
                $('#change-password-error-message').addClass('hide');
                $('#change-password form :input').prop('disabled', false);
                $('#change-password').modal('hide');
            },
            error : function(response) {
                $('#change-old-password').val('');
                $('#change-new-password').val('');
                $('#change-password form :input').prop('disabled', false);
                $('#change-password-error-message').removeClass('hide');
            }
        });

        return false;
    });

    $('#settings form').submit(function() {
        var email = $('#settings-email').val();
        var phone = $('#settings-phone').val();

        $(this).find(':input').prop('disabled', true);

        $.ajax({
            url : '/api/v1/user',
            method : 'put',
            data : {
                email : email,
                phone : phone
            },
            success : function(response) {
                $('#settings form :input').prop('disabled', false);
                $('#settings-error-message').addClass('hide');
                $('#settings').modal('hide');
            },
            error : function(response) {
                $('#settings form :input').prop('disabled', false);
                $('#settings-error-message').removeClass('hide');
            }
        });

        return false;
    });

    loadUser();

    function loadUser() {
        $.ajax({
            url : '/api/v1/user',
            success : function(response) {
                $('#username').html(response.name);
                $('#settings-email').val(response.email);
                $('#settings-phone').val(response.phone);
                
                if(response.hasOwnProperty('communityHasUser') && response.communityHasUser.admin == '1'){
                    $('.community-admin').removeClass('community-admin');
                }
            }
        });
    }
})(jQuery);

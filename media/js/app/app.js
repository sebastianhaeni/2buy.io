(function($) {
    'use strict';

    window.app2buy = angular.module('app2buy', [ 'ngResource', 'angularMoment' ]).config(
            function($interpolateProvider) {
                $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
            });

    $.ajax({
        url : '/api/v1/user/isLoggedIn',
        success : function(response) {
            if (!response.loggedIn) {
                window.location.href = 'signin';
            }
        }
    });

    if ($.cookie('community') == undefined && window.location.pathname != '/app') {
        window.location.href = '/app';
    }

    $('#logout').click(function() {
        logout();
    });

    function logout() {
        $.ajax({
            url : '/api/v1/user/logout',
            success : function() {
                window.location.href = '/';
            }
        });
    }
    
})(jQuery);

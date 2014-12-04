(function($) {
    'use strict';

    app2buy.controller('ShoppinglistHistoryController', [ '$scope', 'ShoppinglistHistory',
            function($scope, ShoppinglistHistory) {
                $scope.transactions = ShoppinglistHistory.query();
            } ]);

    app2buy.factory('ShoppinglistHistory', [ '$resource', function($resource) {
        return $resource('/api/v1/community/:communityId/transaction/history', {}, {
            query : {
                method : 'GET',
                params : {
                    communityId : $.cookie('community')
                },
                isArray : true
            }
        });
    } ]);

    $('#clear-history-form').submit(function() {
        $(this).find(':input').prop('disabled', true);

        $.ajax({
            url : '/api/v1/community/' + $.cookie('community') + '/transaction/history/clear',
            method : 'delete',
            success : function() {
                $('#clear-history-form').find(':input').prop('disabled', false);
                $('#clear-history-error-message').addClass('hide');
                $('#clear-history-dialog').modal('hide');
                $('#transaction-history .list').html('');
            },
            error : function() {
                $('#clear-history-form').find(':input').prop('disabled', false);
                $('#clear-history-error-message').removeClass('hide');
            }
        });

        return false;
    });

})(jQuery);

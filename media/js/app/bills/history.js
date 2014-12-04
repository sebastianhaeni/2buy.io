(function($) {
    'use strict';

    app2buy.controller('BilllistHistoryController', [ '$scope', 'BilllistHistory',
        function($scope, BilllistHistory) {
            $scope.bills = BilllistHistory.query();
        } ]);

    app2buy.factory('BilllistHistory', [ '$resource', function($resource) {
        return $resource('/api/v1/community/:communityId/bill/history', {}, {
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
            url : '/api/v1/community/' + $.cookie('community') + '/bill/history/clear',
            method : 'delete',
            success : function() {
                $('#clear-history-form').find(':input').prop('disabled', false);
                $('#clear-history-error-message').addClass('hide');
                $('#clear-history-dialog').modal('hide');
                $('#bill-history .list').html('');
            },
            error : function() {
                $('#clear-history-form').find(':input').prop('disabled', false);
                $('#clear-history-error-message').removeClass('hide');
            }
        });

        return false;
    });

})(jQuery);

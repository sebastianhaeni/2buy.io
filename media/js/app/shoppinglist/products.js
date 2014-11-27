(function($) {
    'use strict';

    app2buy.controller('ShoppinglistProductController', [ '$scope', 'ShoppinglistProduct',
            function($scope, ShoppinglistProduct) {
                $scope.products = ShoppinglistProduct.query();
                $scope.showDeleteDialog = function(id, name) {
                    $('#delete-product-dialog').attr('data-id', id);
                    $('#delete-product-dialog').attr('data-community-id', $.cookie('community'));
                    $('#delete-product-name').text(name);
                    $('#delete-product-dialog').modal('show');
                }
            } ]);

    
    app2buy.factory('ShoppinglistProduct', [ '$resource', function($resource) {
        return $resource('/api/v1/community/:communityId/product', {}, {
            query : {
                method : 'GET',
                params : {
                    communityId : $.cookie('community')
                },
                isArray : true
            }
        });
    } ]);

    $('#delete-product-form').submit(function(){
        var id = $('#delete-product-dialog').attr('data-id');
        var communityId = $('#delete-product-dialog').attr('data-community-id');

        $.ajax({
            url : '/api/v1/community/' + communityId + '/product/' + id,
            method : 'delete',
            success : function() {
                $('#product-list [data-id=' + id + ']').remove();
                $('#delete-product-dialog').modal('hide');
            },
            error : function() {
                $('#delete-product-error-message').removeClass('hide');
            }
        });

        return false;
    });
     

})(jQuery);

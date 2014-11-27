(function($) {
    'use strict';

    app2buy.controller('ShoppinglistProductController', [ '$scope', 'ShoppinglistProduct',
            function($scope, ShoppinglistProduct) {
                $scope.products = ShoppinglistProduct.query();
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

})(jQuery);

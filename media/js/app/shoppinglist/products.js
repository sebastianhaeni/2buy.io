(function($) {
    'use strict';

    app2buy.controller('ShoppinglistProductController', [ '$scope', 'ShoppinglistProduct',
            function($scope, ShoppinglistProduct) {
                $scope.products = ShoppinglistProduct.query();

                $scope.showDeleteDialog = function(product) {
                    $('#delete-product-dialog').attr('data-id', product.id);
                    $('#delete-product-dialog').attr('data-community-id', $.cookie('community'));
                    $('#delete-product-name').text($('#product-list [data-id=' + product.id + '] .product-name').text());
                    $('#delete-product-dialog').modal('show');
                };
                
                $scope.showEditDialog = function(product){
                    $('#edit-product-dialog').attr('data-id', product.id);
                    $('#edit-product-dialog').attr('data-community-id', $.cookie('community'));
                    $('#edit-product-name').val($('#product-list [data-id=' + product.id + '] .product-name').text());
                    $('#edit-product-dialog').modal('show');
                };

                $scope.toggleInSuggestions = function(product) {
                    $.ajax({
                        url : '/api/v1/community/' + $.cookie('community') + '/product/' + product.id,
                        method : 'put',
                        data : {
                            inSuggestions : $('.item[data-id=' + product.id + '] input[type=checkbox]').is(':checked') ? '1': '0'
                        }
                    });
                };
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
    
    $('#edit-product-form').submit(function() {
        var id = $('#edit-product-dialog').attr('data-id');
        var communityId = $('#edit-product-dialog').attr('data-community-id');
        var name = $('#edit-product-name').val();
        $(this).find(':input').prop('disabled', true);

        $.ajax({
            url : '/api/v1/community/' + communityId + '/product/' + id,
            method : 'put',
            data : {
                name : name
            },
            success : function() {
                $('#product-list [data-id=' + id + '] .product-name').text(name);
                $('#edit-product-error-message').addClass('hide');
                $('#edit-product-form :input').prop('disabled', false);
                $('#edit-product-dialog').modal('hide');
            },
            error : function() {
                $('#edit-product-form :input').prop('disabled', false);
                $('#edit-product-error-message').removeClass('hide');
            }
        });

        return false;
    });

    $('#delete-product-form').submit(function() {
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
    
    $('#new-product-form').submit(function(){
        
        var name = $('#new-product-name').val();
        
        $('#new-product-error-message').addClass('hide');

        $(this).find(':input').prop('disabled', true);
        
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/product',
            data: {name: name},
            method: 'post',
            success: function(){
                $('#new-product-form').find(':input').prop('disabled', false);
                $('#new-product-name').val('');
                
                $('#new-product-error-message').addClass('hide');
                $('#new-product-dialog').modal('hide');
                
                // TODO apply changes to model
            },
            error: function(){
                $('#new-product-form').find(':input').prop('disabled', false);
                $('#new-product-error-message').removeClass('hide');
            }
        });
        
        return false;
    });

})(jQuery);

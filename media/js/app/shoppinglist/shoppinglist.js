(function($) {
    'use strict';

    $.ajax({
        url : '/api/v1/community/' + $.cookie('community')
                + '/transaction?filter=boughtBy:null,cancelled:0',
        success : function(response) {
            $.each(response, function(i, article) {
                addArticle(article);
            });
        }
    });

    function addArticle(a) {

        var amount = '<span class="amount">' + a.amount + '</span>';
        var product = '<span class="product">' + a.product.name + '</span>';
        var reportedBy = '<span class="reportedBy">' + a.reporter.name + '</span>';
        var reportedDate = '<span class="reportedDate">' + a.reportedDate + '</span>';

        var div = $('<div class="item transaction" data-id="' + a.id + '">' + amount
                + product + reportedBy + reportedDate + '</div>');

        $('#shoppinglist .list').append(div);
    }
    
})(jQuery);
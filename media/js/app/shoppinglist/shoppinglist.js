(function($) {
    'use strict';

    function loadArticles(){
        $.ajax({
            url : '/api/v1/community/' + $.cookie('community') + '/transaction?filter=boughtBy:null,cancelled:0',
            success : function(response) {
                $.each(response, function(i, article) {
                    addArticle(article);
                });
            }
        });
    }

    function addArticle(a) {

        if($('#shoppinglist div[data-id=' + a.id + ']').length > 0){
            return;
        }
        
        var amount = '<span class="amount">' + a.amount + '</span>';
        var product = '<span class="product">' + a.product.name + '</span>';
        var reportedBy = '<span class="reportedBy">' + a.reporter.name + '</span>';
        var reportedDate = '<span class="reportedDate">' + a.reportedDate + '</span>';

        var div = $('<div class="item transaction" data-id="' + a.id + '">' + amount
                + product + reportedBy + reportedDate + '</div>');

        $('#shoppinglist .list').append(div);
    }
    
    $('#add-article form').submit(function(){
        
        var name = $('#add-article-name').val();
        var amount = $('#add-article-amount').val();
        
        $('#add-article-error-message').addClass('hide');

        $(this).find(':input').prop('disabled', true);
        
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/transaction',
            data: {name: name, amount: amount},
            method: 'post',
            success: function(){
                $('#add-article form').find(':input').prop('disabled', false);
                $('#add-article-name').val('');
                $('#add-article-amount').val(1);
                $('#add-article').modal('hide');
                loadArticles();
            },
            error: function(){
                $('#add-article form').find(':input').prop('disabled', false);
                $('#add-article-error-message').removeClass('hide');
            }
        });
        
        return false;
    });
    
    var suggestions = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: '/api/v1/community/' + $.cookie('community') + '/product/suggestions?query=%QUERY'
    });
       
    suggestions.initialize();
       
    $('#add-article-name').typeahead(null, {
        name: 'add-article-name',
        displayKey: 'value',
        source: suggestions.ttAdapter()
    });
    
    loadArticles();
    
})(jQuery);


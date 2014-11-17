(function($) {
    'use strict';
    
    function loadHistory(){
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/transaction/history',
            success: function(response){
                $.each(response, function(i, item){
                    addItem(item);
                });
            }
        });
    }
    
    function addItem(item){
        var content = '';

        if(item.cancelled == '1'){
            content = '<span class="amount">' + item.amount + '</span><span class="product">' + item.product.name + '</span>gemeldet von <span class="reportedBy">' + item.reporter.name + '</span>um ' 
            + '<span class="reportedDate">' + moment(item.reportedDate).format('lll') + '</span>gelöscht von <span class="reportedBy text-danger">' + item.canceller.name + '</span>um ' 
            + '<span class="reportedDate">' + moment(item.closeDate).format('lll') + '</span>'; 
        } else {
            content = '<span class="amount">' + item.amount + '</span><span class="product">' + item.product.name + '</span>gemeldet von <span class="reportedBy">' + item.reporter.name + '</span>um ' 
                + '<span class="reportedDate">' + moment(item.reportedDate).format('lll') + '</span>gekauft von <span class="reportedBy text-success">' + item.buyer.name + '</span>um ' 
                + '<span class="reportedDate">' + moment(item.boughtDate).format('lll') + '</span>'; 
        }
        
        var div = $('<div class="transaction item" data-id="' + item.id + '">' + content + '</div>');
        
        $('#history .list').append(div);
    }
    
    $('#clear-history-form').submit(function(){
        $(this).find(':input').prop('disabled', true);
        
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/transaction/history/clear',
            method: 'delete',
            success: function(){
                $('#clear-history-form').find(':input').prop('disabled', false);
                $('#clear-history-error-message').addClass('hide');
                $('#clear-history-dialog').modal('hide');
                $('#history .list').html('');
            },
            error: function(){
                $('#clear-history-form').find(':input').prop('disabled', false);
                $('#clear-history-error-message').removeClass('hide');
            }
        });
        
        return false;
    });
    
    if($('#history').length == 1){
        loadHistory();
    }
    
})(jQuery);
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
            content = '<span class="amount">' + item.amount + '</span><span class="product">' + item.product.name + '</span>gemeldet von <span class="reportedBy">' + item.reporter.name + '</span>um' 
            + '<span class="reportedDate">' + moment(item.reportedDate).format('lll') + '</span>gelöscht von <span class="reportedBy text-danger">' + item.canceller.name + '</span>um' 
            + '<span class="reportedDate">' + moment(item.closeDate).format('lll') + '</span>'; 
        } else {
            content = '<span class="amount">' + item.amount + '</span><span class="product">' + item.product.name + '</span>gemeldet von <span class="reportedBy">' + item.reporter.name + '</span>um' 
                + '<span class="reportedDate">' + moment(item.reportedDate).format('lll') + '</span>gekauft von <span class="reportedBy text-success">' + item.buyer.name + '</span>um' 
                + '<span class="reportedDate">' + moment(item.boughtDate).format('lll') + '</span>'; 
        }
        
        var div = $('<div class="transaction item" data-id="' + item.id + '">' + content + '</div>');
        
        $('#history .list').append(div);
    }
    
    loadHistory();
    
})(jQuery);
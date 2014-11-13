(function($) {
    'use strict';
    
    var holdTime = 600;
    var tapHold = null;
    var editingTransactionId = null;

    function loadTransactions(){
        $.ajax({
            url : '/api/v1/community/' + $.cookie('community') + '/transaction/active',
            success : function(response) {
                $.each(response, function(i, transaction) {
                    addTransaction(transaction);
                });
                
                $('#shoppinglist .transaction').draggable({ 
                    axis: 'x', 
                    revert: function(){
                        return !$(this).hasClass('buyed') && !$(this).hasClass('cancelled');  
                    },
                    drag: function(){
                        var width = $(this).width();
                        var left = parseInt($(this).css('left'));
                        
                        if(left < -(width / 3)){
                            $(this).addClass('buyed');
                            return;
                        } else if (left > (width / 3)){
                            $(this).addClass('cancelled');
                            return;
                        }
                        $(this).removeClass('buyed');
                        $(this).removeClass('cancelled');
                    },
                    stop: function(){
                        if($(this).hasClass('buyed')){
                            buy($(this));
                        } else if($(this).hasClass('cancelled')){
                            cancel($(this));
                        }
                    }
                }).on('mousedown', function(){
                    tapHold = $(this).addClass('holding').attr('data-hold-start', new Date().getTime());
                    setTimeout(editTransaction.bind(this, $(this)), holdTime);
                    $('#shoppinglist .transaction').removeClass('active');
                    $(this).addClass('active');
                }).on('mouseout', function(){
                    if(tapHold != null){
                        tapHold.removeClass('holding');
                        tapHold = null;
                    }
                }).on('mouseup', function(){
                    if(tapHold != null){
                        tapHold.removeClass('holding');
                        tapHold = null;
                    }
                });
                
                setTimeout(function(){
                    $('#shoppinglist .transaction').addClass('disable-item-drop-in');
                }, 300);
            }
        });
    }

    function addTransaction(a) {

        if($('#shoppinglist div[data-id=' + a.id + ']').length > 0){
        	$('.transaction[data-id=' + a.id + '] .amount').html(a.amount);
            return;
        }
        
        var amount = '<span class="amount">' + a.amount + '</span>';
        var product = '<span class="product">' + a.product.name + '</span>';
        
        var details = '<div class="details">'
            + '<span class="reportedBy details">' + a.reporter.name + '</span>' 
            + '<span class="reportedDate details">' + moment(a.reportedDate).format('lll') + '</span></div>';
        
        var div = $('<div class="item transaction" data-id="' + a.id + '">' + amount + product + details + '</div>');

        $('#shoppinglist .list').append(div);
    }
    
    function buy(el){
        var transactionId = el.attr('data-id');
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/transaction/buy/' + transactionId,
            type: 'put',
            success: function(response){
                el.addClass('closed');
            },
            error: function(){
                alert('Error!');
            }
        });
    }

    function cancel(el){
        var transactionId = el.attr('data-id');
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/transaction/cancel/' + transactionId,
            type: 'put',
            success: function(response){
                el.addClass('closed');
            },
            error: function(){
                alert('Error!');
            }
        });
    }
    
    function editTransaction(el){
        if(tapHold == null || parseInt($(this).attr('data-hold-start')) > new Date().getTime() - holdTime){
            return;
        }
        if($(this).hasClass('ui-draggable')){
            var left = parseInt($(this).css('left'));
            if(!isNaN(left) && Math.abs(left) > 5){
                return;
            }
            editingTransactionId = $(this).attr('data-id');
            $('#edit-transaction-name').val($(this).children('.product').html());
            $('#edit-transaction-amount').val($(this).children('.amount').html());
            $('#edit-transaction').modal('show');
        }
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
                $('#add-article-error-message').addClass('hide');
                $('#add-article').modal('hide');
                loadTransactions();
            },
            error: function(){
                $('#add-article form').find(':input').prop('disabled', false);
                $('#add-article-error-message').removeClass('hide');
            }
        });
        
        return false;
    });
    
    $('#edit-transaction form').submit(function(){
        var amount = $('#edit-transaction-amount').val();
        $(this).find(':input').prop('disabled', true);
        
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/transaction/' + editingTransactionId,
            data: {amount: amount},
            method: 'put',
            success: function(){
                $('#edit-transaction form').find(':input').prop('disabled', false);
                $('#edit-transaction-error-message').addClass('hide');
                $('.transaction[data-id=' + editingTransactionId + '] .amount').html(amount);
                $('#edit-transaction').modal('hide');
            },
            error: function(){
                $('#edit-transaction form').find(':input').prop('disabled', false);
                $('#edit-transaction-error-message').removeClass('hide');
            }
        });
        
        return false;
    });
    
    $('#add-article-name').typeahead({
        hint: true,
        highlight: true,
        minLength: 0
    }, {
        name: 'add-article-name',
        displayKey: 'value',
        source: function(query, cb) {
            console.log(query);
            $.ajax({
                url: '/api/v1/community/' + $.cookie('community') + '/product/suggestions',
                data: {query: query},
                success: cb
            });
        }
    }).on('click', function () {
        var ev = $.Event('keydown');
        ev.keyCode = ev.which = 40;
        $(this).trigger(ev);
        return true;
    });
    
    loadTransactions();
    
})(jQuery);


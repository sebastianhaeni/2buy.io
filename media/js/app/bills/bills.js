(function ($) {
    'use strict';

    // WARNING do not check in code that triggers or listens to events on other pages than bills
    //    $('#barcode-scanner').on('show.bs.modal', function() {
    //        $('#barcode-image').click();
    //    });
    //
    //    $('#button-scan-barcode').click(function() {
    //        $('#barcode-image').click();
    //    });

    function loadBills() {
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/bill/active',
            success: function (response) {
                $.each(response, function (i, bill) {
                    addBill(bill);
                });

                $('#billlist .bill-user').draggable({
                    axis: 'x',
                    revert: function () {
                        return !$(this).hasClass('accepted') && !$(this).hasClass('declined');
                    },
                    drag: function () {
                        var width = $(this).width();
                        var left = parseInt($(this).css('left'));

                        if (left < -(width / 3)) {
                            $(this).addClass('accepted');
                            return;
                        } else if (left > (width / 3)) {
                            $(this).addClass('declined');
                            return;
                        }
                        $(this).removeClass('accepted');
                        $(this).removeClass('declined');
                    },
                    stop: function () {
                        if ($(this).hasClass('accepted')) {
                            acceptUser($(this));
                        } else if ($(this).hasClass('declined')) {
                            declineUser($(this));
                        }
                    }
                });

                $('#billlist .bill-user .details .bill').draggable({
                    axis: 'x',
                    revert: function () {
                        return !$(this).hasClass('accepted') && !$(this).hasClass('declined');
                    },
                    drag: function () {
                        var width = $(this).width();
                        var left = parseInt($(this).css('left'));

                        if (left < -(width / 3)) {
                            $(this).addClass('accepted');
                            return;
                        } else if (left > (width / 3)) {
                            $(this).addClass('declined');
                            return;
                        }
                        $(this).removeClass('accepted');
                        $(this).removeClass('declined');
                    },
                    stop: function () {
                        if ($(this).hasClass('accepted')) {
                            accept($(this));
                        } else if ($(this).hasClass('declined')) {
                            decline($(this));
                        }
                    }
                });

                setTimeout(function () {
                    $('#billlist .bill-user').addClass('disable-item-drop-in');
                }, 300);

                setTimeout(function () {
                    $('#billlist .bill-user .details .bill').addClass('disable-item-drop-in');
                }, 300);
            }
        });
    }

    function addBill(bill) {
        if ($('#billlist .bill-user[data-id=' + bill.createdBy + ']').length > 0) {
            var priceTotalElement = $('.bill-user[data-id=' + bill.createdBy + '] .price-total');
            var num = Number(priceTotalElement.text()) + Number(bill.price);
            priceTotalElement.html(parseFloat(num).toFixed(2));

            if ($('#billlist div[data-id=' + bill.createdBy + '] div[data-id=' + bill.id + ']').length > 0) {

            } else {
                $('.bill-user[data-id=' + bill.createdBy + '] .details').append($(createDetailBill(bill)));

            }
        } else {

            var price = '<span class="price-total">' + bill.price + '</span>';


            var details = ''
                + '<span class="createdBy">' + bill.creater.name + '</span><div class="details">' + createDetailBill(bill) + '</div>';
            var div = $('<div class="item bill-user" data-id=' + bill.createdBy + '>' + price + details + '</div>');

            $('#billlist .list').append(div);
        }
    }

    function createDetailBill(bill) {

        var image = '<div class="imageContainer"><div class="imageCenterer"><img src="/media/img/bills/'
            + bill.picturePath
            + '" /></div></div>';

        var detailsbill = image
            + '<span class="createdDate detail">'
            + moment(bill.createdDate).format('l')
            + '</span><span class="price detail">'
            + bill.price
            + '</span>';

        return '<div class="item bill" data-id="' + bill.id + '">' + detailsbill + '</div>';
    }

    function acceptUser(el) {
        var userId = el.attr('data-id');
        var details = el.find('.bill');
        var billIds = "";
        $.each(details, function () {
            billIds += ',' + $(this).attr('data-id');
        });

        billIds = billIds.substr(1, billIds.length);

        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/bill/accept/' + billIds,
            type: 'put',
            success: function (response) {
                el.addClass('closed');
                toastr.options.positionClass = 'toast-bottom-left';
                toastr.options.timeOut = 4000;
                toastr.options.progressBar = true;
                // TODO remove translatable text from js
                toastr.success('<div class="pull-left">Bill accepted</div>'
                + '<div class="pull-right"><button class="btn btn-danger btn-xs btn-undo" data-id="' + billIds + '"><i class="fa fa-undo"></i> Undo</button></div>');
                $('.btn-undo[data-id="' + billIds + '"]').click(function () {
                    $.ajax({
                        url: '/api/v1/community/' + $.cookie('community') + '/bill/undo/' + billIds,
                        type: 'put',
                        success: function () {
                            $('.bill-user[data-id="' + userId + '"]').removeClass('closed').removeClass('declined').removeClass('accepted').css('left', 0);
                        }
                    });
                });
            },
            error: function () {
                alert('Error!');
            }
        });
    }

    function accept(el) {
        var priceTotalElement = el.closest('.bill-user').find('.price-total');
        var num = Number(priceTotalElement.text()) - Number(el.find('.price').text());
        priceTotalElement.html(parseFloat(num).toFixed(2));
        var billId = el.attr('data-id');
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/bill/accept/' + billId,
            type: 'put',
            success: function (response) {
                el.addClass('closed');
                if (el.closest('.bill-user').find('.bill').not('.closed').length == 0){
                    el.closest('.bill-user').addClass('accepted');
                    el.closest('.bill-user').addClass('closed');
                }
                toastr.options.positionClass = 'toast-bottom-left';
                toastr.options.timeOut = 4000;
                toastr.options.progressBar = true;
                // TODO remove translatable text from js
                toastr.success('<div class="pull-left">Bill accepted</div>'
                + '<div class="pull-right"><button class="btn btn-danger btn-xs btn-undo" data-id="' + billId + '"><i class="fa fa-undo"></i> Undo</button></div>');
                $('.btn-undo[data-id=' + billId + ']').click(function () {
                    $.ajax({
                        url: '/api/v1/community/' + $.cookie('community') + '/bill/undo/' + billId,
                        type: 'put',
                        success: function () {
                            $('.bill[data-id=' + billId + ']').removeClass('closed').removeClass('declined').removeClass('accepted').css('left', 0);
                            var num = Number(priceTotalElement.text()) + Number(el.find('.price').text());
                            priceTotalElement.html(parseFloat(num).toFixed(2));
                            el.closest('.bill-user').removeClass('closed').removeClass('declined').removeClass('accepted');
                        }
                    });
                });
            },
            error: function () {
                alert('Error!');
            }
        });
    }


    function declineUser(el) {
        var userId = el.attr('data-id');
        var details = el.find('.bill');
        var billIds = "";
        $.each(details, function () {
            billIds += ',' + $(this).attr('data-id');
        });

        billIds = billIds.substr(1, billIds.length);

        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/bill/decline/' + billIds,
            type: 'put',
            success: function (response) {
                el.addClass('closed');
                toastr.options.positionClass = 'toast-bottom-left';
                toastr.options.timeOut = 4000;
                toastr.options.progressBar = true;
                // TODO remove translatable text from js
                toastr.error('<div class="pull-left">Bill declined</div>'
                + '<div class="pull-right"><button class="btn btn-danger btn-xs btn-undo" data-id="' + billIds + '"><i class="fa fa-undo"></i> Undo</button></div>');
                $('.btn-undo[data-id="' + billIds + '"]').click(function () {
                    $.ajax({
                        url: '/api/v1/community/' + $.cookie('community') + '/bill/undo/' + billIds,
                        type: 'put',
                        success: function () {
                            $('.bill-user[data-id="' + userId + '"]').removeClass('closed').removeClass('declined').removeClass('buyed').css('left', 0);
                        }
                    });
                });
            },
            error: function () {
                alert('Error!');
            }
        });
    }

    function decline(el) {
        var priceTotalElement = el.closest('.bill-user').find('.price-total');
        var num = Number(priceTotalElement.text()) - Number(el.find('.price').text());
        priceTotalElement.html(parseFloat(num).toFixed(2));
        var billId = el.attr('data-id');
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/bill/decline/' + billId,
            type: 'put',
            success: function (response) {
                el.addClass('closed');
                if (el.closest('.bill-user').find('.bill').not('.closed').length == 0){
                    el.closest('.bill-user').addClass('declined');
                    el.closest('.bill-user').addClass('closed');
                }
                toastr.options.positionClass = 'toast-bottom-left';
                toastr.options.timeOut = 4000;
                toastr.options.progressBar = true;
                // TODO remove translatable text from js
                toastr.error('<div class="pull-left">Bill declined</div>'
                + '<div class="pull-right"><button class="btn btn-danger btn-xs btn-undo" data-id="' + billId + '"><i class="fa fa-undo"></i> Undo</button></div>');
                $('.btn-undo[data-id=' + billId + ']').click(function () {
                    $.ajax({
                        url: '/api/v1/community/' + $.cookie('community') + '/bill/undo/' + billId,
                        type: 'put',
                        success: function () {
                            $('.bill[data-id=' + billId + ']').removeClass('closed').removeClass('declined').removeClass('buyed').css('left', 0);
                            var num = Number(priceTotalElement.text()) + Number(el.find('.price').text());
                            priceTotalElement.html(parseFloat(num).toFixed(2));
                            el.closest('.bill-user').removeClass('closed').removeClass('declined').removeClass('accepted');
                        }
                    });
                });
            },
            error: function () {
                alert('Error!');
            }
        });
    }

    $('#add-bill form').submit(function () {

        var price = $('#add-bill-price').val();
        var name = $('#add-bill-name').val();

        $(this).find(':input').prop('disabled', true);

        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/bill',
            data: {name: name, price: price},
            method: 'post',
            success: function () {
                $('#add-bill form').find(':input').prop('disabled', false);
                $('#add-bill-price').val('');
                $('#add-bill').modal('hide');
                loadBills();
            },
            error: function () {
                $('#add-bill form').find(':input').prop('disabled', false);
            }
        });

        return false;
    });

    $('#add-bill').on('shown.bs.modal', function () {
        var ev = $.Event('keydown');
        ev.keyCode = ev.which = 40;
        $('#add-bill-name').focus().trigger(ev);
    });

    if ($('#billlist').length == 1) {
        loadBills();
    }
})(jQuery);
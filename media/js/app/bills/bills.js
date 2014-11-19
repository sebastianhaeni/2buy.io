(function ($) {
    'use strict';

    function loadBills() {
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/bill/active',
            success: function (response) {
                $.each(response, function (i, bill) {
                    addBill(bill);
                });

                $('#billlist .bill').draggable({
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
                    $('#billlist .bill').addClass('disable-item-drop-in');
                }, 300);
            }
        });
    }

    function addBill(a) {
        if ($('#billlist div[data-id=' + a.id + ']').length > 0) {
            $('.bill[data-id=' + a.id + '] .price').html(a.price);
            return;
        }

        var price = '<span class="price">' + a.price + '</span>';

        var details = '<div class="details">'
            + '<span class="createdBy details">' + a.creater.name + '</span>'
            + '<span class="createdDate details">' + moment(a.createdDate).format('l') + '</span></div>';

        var div = $('<div class="item bill" data-id="' + a.id + '">' + price + details + '</div>');

        $('#billlist .list').append(div);
    }

    function accept(el) {
        var billId = el.attr('data-id');
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/bill/accept/' + billId,
            type: 'put',
            success: function (response) {
                el.addClass('closed');
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
        var billId = el.attr('data-id');
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/bill/decline/' + billId,
            type: 'put',
            success: function (response) {
                el.addClass('closed');
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
                            $('.bill[data-id=' + billId + ']').removeClass('closed').removeClass('cancelled').removeClass('buyed').css('left', 0);
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
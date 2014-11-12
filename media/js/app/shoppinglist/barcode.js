(function($) {
    'use strict';

    var ctx;
    var canvas;
    var workerCount = 0;
    var resultArray = [];
    var canvasSize = 400;

    $('#barcode-scanner').on('show.bs.modal', function() {
        $('#barcode-image').click();
    });

    $('#button-scan-barcode').click(function() {
        $('#barcode-image').click();
    });

    $('#barcode-image').on('change', function(e) {
        var file = e.target.files[0];
        var imageType = /image.*/;

        if (!file.type.match(imageType)) {
            return;
        }

        var reader = new FileReader();
        reader.onload = fileOnload;
        reader.readAsDataURL(file);
    });

    function fileOnload(e) {
        $('#barcode-scanner .progress').show();
        var $img = $('<img>', {
            src : e.target.result
        });

        canvas = document.createElement("canvas");
        canvas.id = 'barcode-canvas';

        ctx = canvas.getContext("2d");

        $img.load(function() {
            canvas.width = this.width > canvasSize ? canvasSize : this.width;
            canvas.height = this.height / (this.width / canvas.width);

            ctx.drawImage(this, 0, 0, canvas.width, canvas.height);
            setTimeout(scanBarcode, 100);
        });
    }

    function scanBarcode() {
        resultArray = [];

        var data = ctx.getImageData(0, 0, canvas.width, canvas.height).data;

        workerCount = 4;

        DecodeWorker.postMessage({
            ImageData : data,
            Width : canvas.width,
            Height : canvas.height,
            FormatPriority: ['EAN-13'],
            DecodeNr: 1,
            cmd : "normal"
        });
        RightWorker.postMessage({
            ImageData : data,
            Width : canvas.width,
            Height : canvas.height,
            FormatPriority: ['EAN-13'],
            DecodeNr: 1,
            cmd : "right"
        });
        LeftWorker.postMessage({
            ImageData : data,
            Width : canvas.width,
            Height : canvas.height,
            FormatPriority: ['EAN-13'],
            DecodeNr: 1,
            cmd : "left"
        });
        FlipWorker.postMessage({
            ImageData : data,
            Width : canvas.width,
            Height : canvas.height,
            FormatPriority: ['EAN-13'],
            DecodeNr: 1,
            cmd : "flip"
        });

    }

    function receiveMessage(e) {
        if (e.data.success === "log") {
            console.log(e.data.result);
            return;
        }

        workerCount--;
        
        if (e.data.success) {
            var tempArray = e.data.result;
            for (var i = 0; i < tempArray.length; i++) {
                if (resultArray.indexOf(tempArray[i]) == -1) {
                    resultArray.push(tempArray[i]);
                }
            }

            var barcode = resultArray[0].split(': ')[1];

            $('#barcode-scanner .progress').hide();
            $('#barcode-product').val(barcode);

            $.ajax({
                url : '/api/v1/barcode/' + barcode,
                success : function(response) {
                    $('#barcode-product-name').val(response.name);

                    if (response.image) {
                        $('#barcode-product-image img').attr('src',
                                response.image);
                        $('#barcode-product-image').show();
                    } else {
                        $('#barcode-product-image').hide();
                    }
                }
            });
        } else if (resultArray.length === 0) {
            if (workerCount <= 0) {
                // TODO show proper dialog
                alert('Erkennung fehlgeschlagen. Versuchen Sie es erneut.');
                $('#barcode-scanner .progress').hide();
            }
        }
    }

    var path = '/bower_components/BarcodeReader/src/DecoderWorker.js';

    var DecodeWorker = new Worker(path);
    var RightWorker = new Worker(path);
    var LeftWorker = new Worker(path);
    var FlipWorker = new Worker(path);

    DecodeWorker.onmessage = receiveMessage;
    RightWorker.onmessage = receiveMessage;
    LeftWorker.onmessage = receiveMessage;
    FlipWorker.onmessage = receiveMessage;
})(jQuery);
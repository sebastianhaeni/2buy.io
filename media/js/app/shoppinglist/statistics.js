(function($) {
    'use strict';

    var colors = ['#5DA5DA', '#FAA43A', '#60BD68', '#B2912F', '#B276B2', '#DECF3F', '#F15854', '#4D4D4D', '#F17CB0'];

    function getColor(seed){
        Math.seedrandom(seed);
        return "#" + ((1 << 24) * Math.random() | 0).toString(16);
    }

    function showStats(el){
        var buyerCanvas = $("#buyerChart").get(0);
        buyerCanvas.width = $("#buyerChart").width();
        buyerCanvas.height = $("#buyerChart").width();
        var buyerCtx = buyerCanvas.getContext("2d");
        
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/stats/purchases',
            success: function(data){
                var pieData = [];
                $.each(data, function(i, s){
                    pieData.push({value: parseInt(s.buyCount), label: s.buyerName, color: colors[i]});
                });
                new Chart(buyerCtx).Pie(pieData, {});
            }
        });

        var reporterCanvas = $("#reporterChart").get(0);
        reporterCanvas.width = $("#reporterChart").width();
        reporterCanvas.height = $("#reporterChart").width();
        var reporterCtx = reporterCanvas.getContext("2d");
        
        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/stats/orders',
            success: function(data){
                var pieData = [];
                $.each(data, function(i, s){
                    pieData.push({value: parseInt(s.reportCount), label: s.reporterName, color: colors[i]});
                });
                new Chart(reporterCtx).Pie(pieData, {});
            }
        });
    }
    
    showStats();
})(jQuery);
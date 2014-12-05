(function($) {
    'use strict';

    var colors = ['#5DA5DA', '#FAA43A', '#60BD68', '#B2912F', '#B276B2', '#DECF3F', '#F15854', '#4D4D4D', '#F17CB0'];

    function getColor(seed){
        Math.seedrandom(seed);
        return "#" + ((1 << 24) * Math.random() | 0).toString(16);
    }

    function showStats(){
        showPaidStats();
        showDeclinedStats();
    }

    function showPaidStats(){
        var paidCanvas = $("#paidChart").get(0);

        if(paidCanvas == null){
            return;
        }

        paidCanvas.width = $("#paidChart").width();
        paidCanvas.height = $("#paidChart").width();
        var createrCtx = paidCanvas.getContext("2d");

        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/stats/paid',
            success: function(data){
                var pieData = [];
                $.each(data, function(i, s){
                    pieData.push({value: parseFloat(s.sumBills), label: s.createrName, color: colors[i]});
                });
                new Chart(createrCtx).Pie(pieData, {});
            }
        });
    }

    function showDeclinedStats(){
        var declinedCanvas = $("#declinedChart").get(0);

        if(declinedCanvas == null){
            return;
        }

        declinedCanvas.width = $("#declinedChart").width();
        declinedCanvas.height = $("#declinedChart").width();
        var createrCtx = declinedCanvas.getContext("2d");

        $.ajax({
            url: '/api/v1/community/' + $.cookie('community') + '/stats/declined',
            success: function(data){
                var pieData = [];
                $.each(data, function(i, s){
                    pieData.push({value: parseFloat(s.sumBills), label: s.createrName, color: colors[i]});
                });
                new Chart(createrCtx).Pie(pieData, {});
            }
        });
    }

    showStats();
})(jQuery);
"use strict";
$(document).ready(function() {
    $("#visitsspark-chart").sparkline([209, 210, 209, 210, 210, 211, 212, 210, 210, 211, 213, 212, 211, 210, 212, 211, 210, 212], {
        type: 'line',
        width: '100%',
        height: '48',
        lineColor: '#4fb7fe',
        fillColor: '#e7f5ff',
        tooltipSuffix: 'Users'
    });
    function spark_sales() {
        var barParentdiv = $('#salesspark-chart').closest('div');
        var barCount = [209, 210, 209, 210, 210, 211, 212, 210, 210, 211, 213, 212, 211, 210, 212, 211, 210, 212];
        var barSpacing = 2;
        $("#salesspark-chart").sparkline(barCount, {
            type: 'bar',
            width: '100%',
            barWidth: (barParentdiv.width() - (barCount.length * barSpacing)) / barCount.length,
            height: '48',
            barSpacing: barSpacing,
            barColor: '#9bd5ff',
            tooltipSuffix: ' Sales'
        });
        $('#salesspark-chart').sparkline([209, 210, 209, 210, 210, 211, 212, 210, 210, 211, 213, 212, 211, 210, 212, 211, 210, 212],
            {
                composite: true,
                fillColor: false,
                width: "100%",
                spotColor: '#f0ad4e',
                lineColor: '#EF6F6C',
                tooltipSuffix: ' Sales'
            });

    }

    spark_sales();


    function spark_loader() {
        var lpoints = [];
        for (var i = 0; i < 20; i++) {
            var load = 5 + parseInt(Math.random() * 90 - 5);
            if (load < 25) {
                load = 25;
            }
            if (load > 100) {
                load = 90;
            }
            lpoints.push(load);
        }
        $('#mousespeed').sparkline(lpoints, {
            type: 'line',
            height: "48px",
            width: "100%",
            lineColor: '#4fb7fe',
            fillColor: '#e7f5ff',
            tooltipSuffix: ' Comments'
        });
        setTimeout(spark_loader, 1800);
    }

    spark_loader();


    function spark_sales1() {
        var barParentdiv = $('#rating').closest('div');
        var barCount = [1, 2, 3, 2, 5, 3, 5, 6, 5, 6, 5, 7, 8, 8, 6, 7, 4, 3, 5, 4, 2, 3, 5, 3, 2, 1];
        var barSpacing = 2;
        $("#rating").sparkline(barCount, {
            type: 'bar',
            width: '100%',
            barWidth: (barParentdiv.width() - (barCount.length * barSpacing)) / barCount.length,
            height: '50',
            barSpacing: barSpacing,
            barColor: '#9bd5ff',
            tooltipSuffix: ' Rating'
        });
    }

    spark_sales1();

//   flip js

    $("#top_widget1, #top_widget2, #top_widget3, #top_widget4").flip({
        axis: 'x',
        trigger: 'hover'
    });


    var options = {
        useEasing: true,
        useGrouping: true,
        decimal: '.',
        prefix: '',
        suffix: ''
    };
    new CountUp("widget_countup1", 0, 3250, 0, 5.0, options).start();
    new CountUp("widget_countup2", 0, 1140, 0, 5.0, options).start();
    new CountUp("widget_countup3", 0, 85, 0, 7.0, options).start();
    new CountUp("widget_countup4", 0, 8, 0, 9.0, options).start();


//=================================main chart================================

// Chartist
    var Chartist1 = new Chartist.Line('#chart1', {
        labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        series: [{
            label: 'Views',
            data: [{meta: 'Views', value: 4},
                {meta: 'Views', value: 6},
                {meta: 'Views', value: 4},
                {meta: 'Views', value: 7},
                {meta: 'Views', value: 4},
                {meta: 'Views', value: 6},
                {meta: 'Views', value: 3},
                {meta: 'Views', value: 7},
                {meta: 'Views', value: 3},
                {meta: 'Views', value: 6},

                {meta: 'Views', value: 4},
                {meta: 'Views', value: 6}]
        },

            {
                label: 'Sales',
                data: [{meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 3},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 4},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 3},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 3},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 4},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 3}]
            }]
    }, {
        height: 300,
        fullWidth: true,
        low: 0,
        high: 7,
        showArea: true,
        axisY: {
            onlyInteger: true,
            offset: 20
        }
        ,
        plugins: [
            Chartist.plugins.tooltip()
        ]
    });

    Chartist1.on('draw', function (data) {


        if (data.type === 'point') {
            data.element.animate({
                y1: {
                    begin: 100 * data.index,
                    dur: 2000,
                    from: data.y + 1000,
                    to: data.y,
                    easing: Chartist.Svg.Easing.easeOutQuint
                },
                y2: {
                    begin: 100 * data.index,
                    dur: 2000,
                    from: data.y + 1000,
                    to: data.y,
                    easing: Chartist.Svg.Easing.easeOutQuint
                }
            });
        }

        if (data.type === 'line' || data.type === 'area') {
            data.element.animate({
                d: {
                    begin: 2000 * data.index,
                    dur: 2000,
                    from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                    to: data.path.clone().stringify(),
                    easing: Chartist.Svg.Easing.easeOutQuint
                }
            });
        }
    });

});
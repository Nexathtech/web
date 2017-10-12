var initWidgets = function(printsData, salesData) {
  console.log(printsData);
  console.log(salesData);

  /* Prints chart */
  var barParentdiv = $('#prints-chart').closest('div');
  var barCount = printsData.latest.digits;
  var barSpacing = 2;
  $('#prints-chart').sparkline(barCount, {
    type: 'bar',
    width: '100%',
    barWidth: (barParentdiv.width() - (barCount.length * barSpacing)) / barCount.length,
    height: '50',
    barSpacing: barSpacing,
    barColor: '#9bd5ff',
    tooltipFormat: '<strong>{{offset:offset}}</strong>: {{value}} prints',
    tooltipValueLookups: {
      'offset': printsData.latest.labels
    }
  });

  /* Sales chart */
  var salesParentdiv = $('#sales-chart').closest('div');
  var salesCount = salesData.latest.digits;
  $('#sales-chart').sparkline(salesCount, {
    type: 'bar',
    width: '100%',
    barWidth: (salesParentdiv.width() - (salesCount.length * barSpacing)) / salesCount.length,
    height: '50',
    barSpacing: barSpacing,
    barColor: '#9bd5ff',
    tooltipFormat: '<strong>{{offset:offset}}</strong>: {{value}} sales',
    tooltipValueLookups: {
      'offset': salesData.latest.labels
    }
  });

  /* CountUp */
  var options = {
    useEasing: true,
    useGrouping: true,
    decimal: '.',
    prefix: '',
    suffix: ''
  };
  new CountUp('widget_countup1', 0, printsData.total, 0, 4.0, options).start();
  new CountUp("widget_countup2", 0, salesData.total, 0, 4.0, options).start();

  /* Flip top widgets on hover */
  $("#top_widget1, #top_widget2").flip({
    axis: 'x',
    trigger: 'hover'
  });

  /* Main chart (Chartist) */
  var prints = [];
  var sales = [];
  var chartHeigh = 10; // height of the chart
  printsData.latest.digits.forEach(function(item) {
      prints.push({meta: 'Prints', value: item});
      if (item > chartHeigh) {
        chartHeigh = item;
      }
  });
  salesData.latest.digits.forEach(function(item) {
    sales.push({meta: 'Sales', value: item});
  });

  var Chartist1 = new Chartist.Line('#chart1', {
    labels: salesData.latest.labels,
    series: [
      {
        label: 'Prints',
        data: prints
      },
      {
        label: 'Sales',
        data: sales
      }
    ]
  }, {
    height: 300,
    fullWidth: true,
    low: 0,
    high: chartHeigh,
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

};
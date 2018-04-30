var initWidgets = function(printsData, salesData, usersData, devicesData) {

  /* Prints chart */
  var dataElement = $('#prints-chart').closest('div');
  $('#prints-chart').sparkline(printsData.latest.digits, sparklineOptions(dataElement, printsData, 'prints'));

  /* Sales chart */
  dataElement = $('#sales-chart').closest('div');
  $('#sales-chart').sparkline(salesData.latest.digits, sparklineOptions(dataElement, salesData, 'sales'));

  /* Users chart */
  dataElement = $('#users-chart').closest('div');
  $('#users-chart').sparkline(usersData.latest.digits, sparklineOptions(dataElement, usersData, 'users'));

  /* Devices chart */
  dataElement = $('#devices-chart').closest('div');
  $('#devices-chart').sparkline(devicesData.latest.digits, sparklineOptions(dataElement, devicesData, 'devices'));

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
  new CountUp("widget_countup3", 0, usersData.total, 0, 4.0, options).start();
  new CountUp("widget_countup4", 0, devicesData.total, 0, 4.0, options).start();

  /* Flip top widgets on hover */
  $("#top_widget1, #top_widget2, #top_widget3, #top_widget4").flip({
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

function sparklineOptions(dataElement, data, label) {
  var barSpacing = 2;
  var salesCount = data.latest.digits;

  return {
    type: 'bar',
    width: '100%',
    barWidth: (dataElement.width() - (salesCount.length * barSpacing)) / salesCount.length,
    height: '50',
    barSpacing: barSpacing,
    barColor: '#9bd5ff',
    tooltipFormat: '<strong>{{offset:offset}}</strong>: {{value}} ' + label,
    tooltipValueLookups: {
      'offset': data.latest.labels
    }
  };
}
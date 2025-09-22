<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales'],
          [2004,  1000],
          [2005,  1170],
          [2006,  660],
          [2007,  1030]
        ]);
        var options = {
          title: 'Company Performance',
          trendlines: {
            0: {
              type: 'polynomial',
              degree: 3,
              visibleInLegend: true
            }
          }
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>

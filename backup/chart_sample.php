<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!--
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    -->
 
    <?php
        $Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);

        mysqli_query($Conn, "set names utf8;");
        mysqli_query($Conn, "set session character_set_connection=utf8;");
        mysqli_query($Conn, "set session character_set_results=utf8;");
        mysqli_query($Conn, "set session character_set_client=utf8;");
            
        $sql = "SELECT STR_TO_DATE(CONCAT(YEAR,LPAD(MONTH,'2','0'),LPAD(DAY,'2','0')), '%Y%m%d') AS dt, CAST(price AS DECIMAL(10,6)) AS temp  from molit_info_all  WHERE areacode = '11620'  AND apart_name = '관악드림(동아)'  AND size = '114.75'  ORDER BY STR_TO_DATE(CONCAT(YEAR,LPAD(MONTH,'2','0'),LPAD(DAY,'2','0')), '%Y%m%d')";
        
        $sql2 = "SELECT ROUND(MAX(CAST(price AS DECIMAL(10,2)))+1) AS temp_max, ROUND(MIN(CAST(price AS DECIMAL(10,2)))-1) AS temp_min  from molit_info_all  WHERE areacode = '11620'  AND apart_name = '관악드림(동아)'  AND size = '114.75'";
        
        $result = mysqli_query($Conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data_array[] = $row;
            }
            $chart = json_encode($data_array);
            
            
            $result2 = mysqli_query($Conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            
            echo $row2['temp_max'];
            echo $row2['temp_min'];
            
        } else {
            echo "No Data";
        }
 
        mysqli_close($Conn);
    ?>
 
    <script type="text/javascript">
        google.charts.load('current', { packages: ['corechart', 'line'] });
        google.charts.load('current', { packages: ['table'] });
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            var chart_array = <?php echo $chart; ?>;
            //console.log(JSON.stringify(chart_array))
            var header = ['Date&Time(MM-DD HH:MM)', '가격(억)'];
            var row = "";
            var rows = new Array();
            jQuery.each(chart_array, function(index, item) {
                row = [
                    item.dt,  // 너무 긴 날짜 및 시간을 짧게 추출
                    Number(item.temp)
                ];
                rows.push(row); 
            });
 
            var jsonData = [header].concat(rows);
            var data = new google.visualization.arrayToDataTable(jsonData);
 
            var lineChartOptions = {
                title: '가격추이',
                hAxis: {
                    title: 'Time',
                    showTextEvery: 1    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시     
                },
                series: {
                    0: { targetAxisIndex: 0 }
                },
                vAxes: {
                    0: {
                        viewWindow: { min: <?=$row2['temp_min']?>, max: <?=$row2['temp_max']?> }
                    }
                },
                interpolateNulls : true
                //,
                //curveType: 'function',
                //legend: { position: 'bottom' }
            };
 
            var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div'));
            lineChart.draw(data, lineChartOptions);
 
            // 테이블 차트
            //var tableChartOptions = {
            //    showRowNumber: true,
            //    width: '40%',
            //    height: '20%'
            //}
 
            //var tableChart = new google.visualization.Table(document.getElementById('tableChart_div'));
            //tableChart.draw(data, tableChartOptions);
        }
    </script>
</head>
<body>
    <div id="lineChart_div" style="width: 100%; height: 300px"></div>
    <!--<div id="tableChart_div"></div>-->
</body>
</html>
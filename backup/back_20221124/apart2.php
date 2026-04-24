<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="./test.css">

<?php

$apart_name = $_REQUEST["apart_name"];
$size = $_REQUEST["size"];
$dong = $_REQUEST["dong"];
$area_main_name = $_REQUEST["area_main_name"];

$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);

$sql = "
    SELECT concat(year,'/',month,'/',day) as yearmonthday, apart_name, size, stair, price, type
    FROM molit_info_all
    where area_main_name = '$area_main_name'
    and apart_name = '$apart_name'
    and size = '$size'
    order by insert_date desc
    ";
    
$sql_doro = "
    SELECT build_year, doro, doro_code1, doro_code2
    FROM apart_dong
    where area_main_name = '$area_main_name'
    and apart_name = '$apart_name'
    ";    


mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

mysqli_query($Conn, "update molit_visit_count set count = count + 1 where count_type = 'apart_detail';");

$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}


$rs_doro = mysqli_query($Conn, $sql_doro);
$row_doro = mysqli_fetch_assoc($rs_doro);

$build_year = $row_doro['build_year'];
$doro = $row_doro['doro'];
$doro_code1 = $row_doro['doro_code1'];
$doro_code2 = $row_doro['doro_code2'];

//여기는 그래프 관련
$sql_chart = "SELECT STR_TO_DATE(CONCAT(YEAR,LPAD(MONTH,'2','0'),LPAD(DAY,'2','0')), '%Y%m%d') AS dt, CAST(price AS DECIMAL(10,6)) AS temp  from molit_info_all  WHERE area_main_name = '$area_main_name'  and apart_name = '$apart_name'  and size = '$size'  ORDER BY STR_TO_DATE(CONCAT(YEAR,LPAD(MONTH,'2','0'),LPAD(DAY,'2','0')), '%Y%m%d')";
        
$sql_min_max = "SELECT ROUND(count(1)/10) as cnt, ROUND(MAX(CAST(price AS DECIMAL(10,2)))+2) AS temp_max, ROUND(MIN(CAST(price AS DECIMAL(10,2)))-2) AS temp_min  from molit_info_all  WHERE area_main_name = '$area_main_name'  and apart_name = '$apart_name'  and size = '$size'";

$result_chart = mysqli_query($Conn, $sql_chart);

if (mysqli_num_rows($result_chart) > 0) {
    while ($row_chart = mysqli_fetch_assoc($result_chart)) {
        $data_array[] = $row_chart;
    }
    $chart = json_encode($data_array);
    
    $result_min_max = mysqli_query($Conn, $sql_min_max);
    $row_min_max = mysqli_fetch_assoc($result_min_max);
    
} else {
    echo "No Data";
}
//여기는 그래프 관련

?>

<h1><?php echo $area_main_name; ?> <?php echo $dong; ?> <?php echo $apart_name; ?><br>건축년도 : <?php echo $build_year; ?>년, 전용면적 : <?php echo $size; ?>㎡ 실거래 리스트(2017년 이후)</h1>
<h1><a target="_blank" href='https://m.land.naver.com/search/result/<?php echo str_replace(' ','%20',$dong); ?><?php echo str_replace(' ','%20',$apart_name); ?>아파트'>네이버 부동산 바로가기</a><h1>
<h1><a target="_blank" href='https://hogangnono.com/search?q=<?php echo str_replace(' ','%20',$dong); ?><?php echo str_replace(' ','%20',$apart_name); ?>아파트'>호갱노노 바로가기</a><h1>

<iframe id="inlineFrameExample"
    title="Inline Frame Example"
    width="100%"
    height="500"
    src="https://map.kakao.com/?q=%EC%84%9C%EC%9A%B8%ED%8A%B9%EB%B3%84%EC%8B%9C+%EC%83%88%EC%B0%BD%EB%A1%9C8%EA%B8%B8+00072-00000">
</iframe>

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
                showTextEvery: <?=$row_min_max['cnt']?>    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시     
            },
            series: {
                0: { targetAxisIndex: 0 }
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max['temp_min']?>, max: <?=$row_min_max['temp_max']?> }
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
<div id="lineChart_div" style="width: 100%; height: 300px"></div>

<table>
    <thead>
    <tr>
        <th>아파트명</th>
        <th>거래일자</th>
        <th>층</th>
        <th>가격</th>
        <th>거래유형</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td><?=$row['apart_name']?></td>
          <td><?=$row['yearmonthday']?></td>
          <td><?=$row['stair']?>층</td>
          <td><?=$row['price']?>억</td>
          <td><?=$row['type']?></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<h3><center>Copyright ©2022 Lee, Inc. All rights reserved<br>Developer : jungsup2.lee@gmail.com</center></h3>
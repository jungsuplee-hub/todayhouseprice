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
$all_area = $_REQUEST["all_area"];

$today = date("Y-m-d");

if( $all_area == "Y"){
  $size_text = "";
}else{
  $size_text = "and size = '$size'";
}

$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);

$sql = "
    SELECT concat(year,'/',month,'/',day) as yearmonthday, apart_name, round(size,2) as size, stair, price, type
    FROM molit_info_all
    where area_main_name = '$area_main_name'
    and apart_name = '$apart_name'
    $size_text
    order by date_format(concat(year,'/',month,'/',day),'%Y-%m-%d') desc
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


$rs = mysqli_query($Conn, "select count(1) as cnt from molit_visit_count where ymd = '$today' and count_type = 'apart_detail';");
$row = mysqli_fetch_assoc($rs);
if($row['cnt']==0) {
  mysqli_query($Conn, "insert into molit_visit_count (ymd, count, count_type) values('$today',1,'apart_detail');");
}else{
  mysqli_query($Conn, "update molit_visit_count set count = count + 1 where ymd = '$today' and count_type = 'apart_detail';");
}

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
<center><span style="font-size:30px;"><b>아파트 실거래가 상세조회</b></span><a style="font-size:15px;" href='http://1.239.38.238:8880/info.php'>(텔레그램알림받기)</a></center>
<br>
<span style="font-size:30px;"><?php echo $area_main_name; ?> <?php echo $dong; ?> <?php echo $apart_name; ?>(건축년도 : <?php echo $build_year; ?>년) <br>전용면적 : <?php if( $all_area=="Y") { echo "전체";} else {echo $size; echo "㎡";}?>, 실거래 리스트(2017년 이후)</span>
<h1>
<a href='http://1.239.38.238:8880/apart.php?area_main_name=<?php echo $area_main_name; ?>&apart_name=<?php echo $apart_name; ?>&size=<?php echo $size; ?>&dong=<?php echo $dong; ?>&all_area=Y'>전체면적보기</a>
<a style="float:right;" href='http://1.239.38.238:8880/apart_rent.php?area_main_name=<?php echo $area_main_name; ?>&apart_name=<?php echo $apart_name; ?>&size=<?php echo $size; ?>&dong=<?php echo $dong; ?>&all_area=<?php echo $all_area; ?>'>해당 아파트 전/월세 정보 보기</a>
<h1>
<h2>
<a target="_blank" href='https://m.land.naver.com/search/result/<?php echo str_replace(' ','%20',$dong); ?><?php echo str_replace(' ','%20',$apart_name); ?>아파트'>네이버 부동산 바로가기</a>
<a style="float:right;" target="_blank" href='https://hogangnono.com/search?q=<?php echo str_replace(' ','%20',$dong); ?><?php echo str_replace(' ','%20',$apart_name); ?>아파트'>호갱노노 바로가기</a>
<h2>

<center>
<iframe id="inlineFrameExample"
    title="Inline Frame Example"
    width="80%"
    height="400"
    src="https://m.map.kakao.com/actions/searchView?q=<?php echo str_replace(' ','%20',$area_main_name); ?>%20<?php echo str_replace(' ','%20',$doro); ?>%20<?php echo str_replace(' ','%20',$doro_code1); ?>-<?php echo str_replace(' ','%20',$doro_code2); ?>&wxEnc=LQMSQP&wyEnc=QNLURRS&lvl=4#!/all/map/place">
</iframe>
</center>
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
        <th>전용면적</th>
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
          <td><?=$row['size']?>㎡</td>
          <td><?=$row['stair']?>층</td>
          <td><?=$row['price']?>억</td>
          <td><?=$row['type']?></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<center><span style="font-size:20px;">Copyright ©2022 Lee, Inc. All rights reserved<br>Developer : jungsup2.lee@gmail.com</span></center>
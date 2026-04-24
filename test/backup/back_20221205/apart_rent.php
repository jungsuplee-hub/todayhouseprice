<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
<title>오늘집값 - 아파트 실거래 조회</title>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
     crossorigin="anonymous"></script>
</head>
<link rel="stylesheet" type="text/css" href="./test_rent.css">

<?php
$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
$today = date("Y-m-d");
/////////////////////조회수//////////////////////////
$is_count = false;
if ($_COOKIE["todayhouseprice"]=="") {    
    setcookie("todayhouseprice", "count", time() + 60 * 60);
    $is_count = true;
}
if ($is_count) {
  $rs = mysqli_query($Conn, "select count(1) as cnt from molit_visit_count where ymd = '$today' and count_type = 'apart_detail';");
  $row = mysqli_fetch_assoc($rs);
  if($row['cnt']==0) {
    mysqli_query($Conn, "insert into molit_visit_count (ymd, count, count_type) values('$today',1,'apart_detail');");
  }else{
    mysqli_query($Conn, "update molit_visit_count set count = count + 1 where ymd = '$today' and count_type = 'apart_detail';");
  }
}
/////////////////////조회수//////////////////////////


$apart_name = $_REQUEST["apart_name"];
$size = $_REQUEST["size"];
$dong = $_REQUEST["dong"];
$area_main_name = $_REQUEST["area_main_name"];
$all_area = $_REQUEST["all_area"];



if( $all_area == "Y"){
  $size_text = "";
}else{
  $size_text = "and round(size,2) = '$size'";
}



$sql = "
    SELECT concat(year,'/',month,'/',day) as yearmonthday, apart_name, round(size,2) as size, stair, rent_price as price, month_price , type
    FROM molit_info_rent_all
    where area_main_name = '$area_main_name'
    and apart_name = '$apart_name'
    and dong = '$dong'
    $size_text
    order by date_format(concat(year,'/',month,'/',day),'%Y-%m-%d') desc
    ";
    
$sql_doro = "
    SELECT build_year, doro, doro_code1, doro_code2
    FROM apart_dong
    where area_main_name = '$area_main_name'
    and apart_name = replace('$apart_name','(임대)','')
    and dong = '$dong'
    ";    


mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");


//조회수 출력
$sql_count = "
select
(SELECT SUM(COUNT) from molit_visit_count) AS total,
(SELECT SUM(COUNT) from molit_visit_count WHERE YMD = '$today') AS today
FROM DUAL;
";
$rs_count = mysqli_query($Conn, $sql_count);
$row_count = mysqli_fetch_assoc($rs_count);

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
$sql_chart = "SELECT STR_TO_DATE(CONCAT(YEAR,LPAD(MONTH,'2','0'),LPAD(DAY,'2','0')), '%Y%m%d') AS dt, CAST(rent_price AS DECIMAL(10,6)) AS temp  from molit_info_rent_all  WHERE area_main_name = '$area_main_name'  and apart_name = '$apart_name'  and round(size,2) = '$size' and month_price = '0'  ORDER BY STR_TO_DATE(CONCAT(YEAR,LPAD(MONTH,'2','0'),LPAD(DAY,'2','0')), '%Y%m%d')";
        
$sql_min_max = "SELECT ROUND(count(1)/10) as cnt, ROUND(MAX(CAST(rent_price AS DECIMAL(10,2)))+2) AS temp_max, ROUND(MIN(CAST(rent_price AS DECIMAL(10,2)))-2) AS temp_min  from molit_info_rent_all  WHERE area_main_name = '$area_main_name'  and apart_name = '$apart_name'  and round(size,2) = '$size' and month_price = '0'";

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
<span style="font-size:15px; float:right;"><b>Total : <?=$row_count['total']?>, Today : <?=$row_count['today']?></b></span>
<center>
<a href="./apart_today.php"><img style="vertical-align: middle;" width="90", height="90" src="./todayhouseprice2.png"></a>
<span style="font-size:30px; vertical-align: middle;"><b>아파트 전/월세 상세조회</b></span>
</center>
<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>
<br>
<span style="font-size:25px;"><b><?php echo $area_main_name; ?> <?php echo $dong; ?> <?php echo $apart_name; ?>(건축년도 : <?php echo $build_year; ?>년) <br>전용면적 : <?php if( $all_area=="Y") { echo "전체";} else {echo $size; echo "㎡";}?>, 전/월세 리스트(2017년 이후)</b></span>
<h1>
<a href='./apart_rent.php?area_main_name=<?php echo $area_main_name; ?>&apart_name=<?php echo $apart_name; ?>&size=<?php echo $size; ?>&dong=<?php echo $dong; ?>&all_area=Y'>전체면적보기</a>
<a style="float:right;" href='./apart.php?area_main_name=<?php echo $area_main_name; ?>&apart_name=<?php echo $apart_name; ?>&size=<?php echo $size; ?>&dong=<?php echo $dong; ?>&all_area=<?php echo $all_area; ?>'>해당 아파트 매매 정보 보기</a>
</h1>
<h2>
<a target="_blank" href='https://m.land.naver.com/search/result/<?php echo str_replace(' ','%20',$dong); ?><?php echo str_replace(' ','%20',$apart_name); ?>아파트'>네이버 부동산 바로가기</a>
<a style="float:right;" target="_blank" href='https://hogangnono.com/search?q=<?php echo str_replace(' ','%20',$dong); ?> <?php echo str_replace(' ','%20',str_replace($dong,'',$apart_name)); ?>아파트'>호갱노노 바로가기</a>
</h2>

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
            title: '전세 가격추이(월제 세외) / 단위 (억)',
            legend: 'none',
            chartArea: {left: '4%', width: '93%'},
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
<center><div id="lineChart_div" style="width: 80%; height: 300px"></div></center>

<table>
    <thead>
    <tr>
        <th style="font-size: 20px;">아파트명</th>
        <th style="font-size: 20px;">거래일자</th>
        <th style="font-size: 20px;">전용면적</th>
        <th style="font-size: 20px;">층</th>
        <th style="font-size: 20px;">전세(보증금)</th>
        <th style="font-size: 20px;">월세</th>
        <th style="font-size: 20px;">거래유형</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td  style="font-size: 20px; <?php if ($row['month_price']!='0') {echo 'color: skyblue;';} ?>"><b><?=$row['apart_name']?></b></td>
          <td  style="font-size: 20px; <?php if ($row['month_price']!='0') {echo 'color: skyblue;';} ?>"><b><?=$row['yearmonthday']?></b></td>
          <td  style="font-size: 20px; <?php if ($row['month_price']!='0') {echo 'color: skyblue;';} ?>"><b><?=$row['size']?>㎡</b></td>
          <td  style="font-size: 20px; <?php if ($row['month_price']!='0') {echo 'color: skyblue;';} ?>"><b><?=$row['stair']?>층</b></td>
          <td  style="font-size: 20px; <?php if ($row['month_price']!='0') {echo 'color: skyblue;';} ?>"><b><?=$row['price']?>억</b></td>
          <td  style="font-size: 20px; <?php if ($row['month_price']!='0') {echo 'color: skyblue;';} ?>"><b><?php if ($row['month_price']!="0") {echo $row['month_price']; echo "만원";} ?></b></td>
          <td  style="font-size: 20px; <?php if ($row['month_price']!='0') {echo 'color: skyblue;';} ?>"><b><?php if ($row['month_price']!="0") {echo "월세";}else {echo "전세";} ?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : jungsup2.lee@gmail.com</b></span></center>

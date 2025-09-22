<!DOCTYPE html>
<head>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EF60WVGV7F"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'G-EF60WVGV7F');
gtag('config', 'AW-945296853');
gtag('event', 'conversion', {'send_to': 'AW-945296853/nBcaCMiZnYcYENWr4MID'});
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
<title>오늘집값 - 아파트 관련 지표</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 아파트 관련 지표">
<meta property="og:description" content="오늘집값 - 금일 등록된 아파트 신규 매매/전세 정보를 조회할 수 있습니다.">
<meta property="og:image" content="./todayhouseprice2.png">
<meta property="og:url" content="http://todayhouseprice.com/apart_today.php">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
     crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="./todayhouseprice.css">
</head>
<?php
$Conn = mysqli_connect("localhost", "root", "e0425820", "jsdb", 3306);
mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

$today = date("Y-m-d");
include_once "./config.php";
//session_start();
//$userid = $_SESSION["userid"];
/////////////////////조회수//////////////////////////

/////////////////////금일 지수//////////////////////////
$rs_today = mysqli_query($Conn, "select dallor, gumri_usa, gumri_korea, kospi, kosdaq, substr(update_date,1,19) as update_date from today_index");
$row_today = mysqli_fetch_assoc($rs_today);
/////////////////////금일 지수//////////////////////////

?>
<center>
<span style="font-size:20px;">기준금리 : </span>
<a href="https://m.search.naver.com/search.naver?where=m&sm=mtb_etc&mra=blJH&qvt=0&query=%EB%8C%80%ED%95%9C%EB%AF%BC%EA%B5%AD%20%EC%A4%91%EC%95%99%EC%9D%80%ED%96%89%20%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC"><img style="vertical-align:top;" width="44", height="24" src="./kor.png"></a>
<span style="font-size:20px;"><?=$row_today['gumri_korea']?></span>
&nbsp;
<a href="https://m.search.naver.com/p/crd/rd?m=1&px=736&py=298&sx=736&sy=298&p=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&q=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&ie=utf8&rev=1&ssc=tab.m.all&f=m&w=m&s=LoFy%2FTw7JT27hrVNgxlLxg%3D%3D&time=1672725258737&abt=%5B%7B%22eid%22%3A%22PWL-AREA-EX%22%2C%22vid%22%3A%222%22%7D%2C%7B%22eid%22%3A%22SBR1%22%2C%22vid%22%3A%22634%22%7D%5D&a=nco_xgr*3.list&r=1&i=88211u5i_000000000000&u=https%3A%2F%2Fm.search.naver.com%2Fsearch.naver%3Fwhere%3Dm%26sm%3Dmtb_etc%26mra%3DblJH%26qvt%3D0%26query%3D%25EB%25AF%25B8%25EA%25B5%25AD%2520%25EC%25A4%2591%25EC%2595%2599%25EC%259D%2580%25ED%2596%2589%2520%25EA%25B8%25B0%25EC%25A4%2580%25EA%25B8%2588%25EB%25A6%25AC&cr=1"><img style="vertical-align: top;" width="44", height="24" src="./usa.png"></a>
<span style="font-size:20px;"><?=$row_today['gumri_usa']?></span>
&nbsp;&nbsp;
<a href="https://m.search.naver.com/search.naver?sm=mtb_hty.top&where=m&oquery=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&tqi=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&query=%ED%99%98%EC%9C%A8"><img style="vertical-align: top;" width="24", height="24" src="./dallor.png"></a>
<span style="font-size:20px;">환율 : <?=$row_today['dallor']?>원</span>

&nbsp;&nbsp;
<a href="https://finance.naver.com/sise/"><img style="vertical-align: top;" width="35", height="24" src="./chart.png"></a>
<span style="font-size:20px;">코스피 : <?=$row_today['kospi']?></span>
<br>
<span style="font-size:15px;">(updated : <?=$row_today['update_date']?>)</span>
</center>
<br>






<h1>아파트 매매 거래량 그래프</h1>

<!--  거래량  -->
<?php
//여기는 그래프 관련
$sql_chart1 = "
    SELECT
    concat(year,'년 ',month,'월') as yearmonth
    ,sum(cnt)  AS cnt
    FROM molit_trend
    where type = '매매'
    $area_main_name_text
    group by year, month
    order by cast(year as unsigned), cast(month as unsigned)
    ";


$sql_min_max1 = "
    select max(cnt)+100 as temp_max, min(cnt)-100 as temp_min
    from
    (
    SELECT year, month, sum(cnt) as cnt
        FROM molit_trend
        where type = '매매'
        $area_main_name_text
        group by year, month
    ) as a
";



$result_chart1 = mysqli_query($Conn, $sql_chart1);

while ($row_chart1 = mysqli_fetch_assoc($result_chart1)) {
    $data_array1[] = $row_chart1;
}
$chart1 = json_encode($data_array1);

$result_min_max1 = mysqli_query($Conn, $sql_min_max1);
$row_min_max1 = mysqli_fetch_assoc($result_min_max1);


?>


<span style="font-size:30px;">전국 매매 거래량 그래프</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart1; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','거래량'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yearmonth,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전국 월별 거래량 추이',
            chartArea: {left: '10%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 8    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max1['temp_max']?>},title : "거래량"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div1'));
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



<center><div id="lineChart_div1" style="width: 100%; height: 400px"></div></center>





<!--  거래량  -->
<?php
//여기는 그래프 관련
$sql_chart1_1 = "
    SELECT
    concat(year,'년 ',month,'월') as yearmonth
    ,sum(cnt)  AS cnt
    FROM molit_trend
    where type = '매매'
    and area_main_name = '서울특별시'
    group by year, month
    order by cast(year as unsigned), cast(month as unsigned)
    ";


$sql_min_max1_1 = "
    select max(cnt)+100 as temp_max, min(cnt)-100 as temp_min
    from
    (
    SELECT year, month, sum(cnt) as cnt
        FROM molit_trend
        where type = '매매'
        and area_main_name = '서울특별시'
        group by year, month
    ) as a
";



$result_chart1_1 = mysqli_query($Conn, $sql_chart1_1);

while ($row_chart1_1 = mysqli_fetch_assoc($result_chart1_1)) {
    $data_array1_1[] = $row_chart1_1;
}
$chart1_1 = json_encode($data_array1_1);

$result_min_max1_1 = mysqli_query($Conn, $sql_min_max1_1);
$row_min_max1_1 = mysqli_fetch_assoc($result_min_max1_1);


?>

<br><br>
<span style="font-size:30px;">서울특별시 매매 거래량 그래프</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart1_1; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','거래량'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yearmonth,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '서울특별시 월별 거래량 추이',
            chartArea: {left: '10%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 8    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max1_1['temp_max']?>},title : "거래량"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div1_1'));
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



<center><div id="lineChart_div1_1" style="width: 100%; height: 400px"></div></center>









<!--전국 아파트 실거래 매매가격지수 그래프-->
<?php


$sql_chart3 = "
select dt, temp
from
(
select
concat(substr(RESEARCH_DATE,1,4),'/',substr(RESEARCH_DATE,5,2),'/',substr(RESEARCH_DATE,7,2)) as dt,
CAST(INDICES as DECIMAL(10,2)) as temp
from AptTradingPriceIndex
where 1=1
and LEVEL_NO = 0
and REGION_CD = 'A1000'
and TR_GBN = 'S'
order by RESEARCH_DATE desc
limit 156
) aa
order by aa.dt
";

$sql_min_max3 = "
select
MIN(CAST(INDICES as DECIMAL(10,2))) as temp_min,
MAX(CAST(INDICES as DECIMAL(10,2))) as temp_max
from AptTradingPriceIndex
where 1=1
and LEVEL_NO = 0
and REGION_CD = 'A1000'
and TR_GBN = 'S'
order by RESEARCH_DATE desc
limit 156;
";

$sql3 = "
  select concat(substr(RESEARCH_DATE,1,4),'/',substr(RESEARCH_DATE,5,2),'/',substr(RESEARCH_DATE,7,2)) as RESEARCH_DATE,
  CAST(MAX(case when REGION_CD = 'A1000' then INDICES end) as DECIMAL(10,2)) as case_BUY_A1000,
  CAST(MAX(case when REGION_CD = '11000' then INDICES end) as DECIMAL(10,2)) as case_BUY_11000,
  CAST(MAX(case when REGION_CD = 'A2000' then INDICES end) as DECIMAL(10,2)) as case_BUY_A2000,
  CAST(MAX(case when REGION_CD = 'A2001' then INDICES end) as DECIMAL(10,2)) as case_BUY_A2001,
  CAST(MAX(case when REGION_CD = 'A3000' then INDICES end) as DECIMAL(10,2)) as case_BUY_A3000,
  CAST(MAX(case when REGION_CD = 'A9000' then INDICES end) as DECIMAL(10,2)) as case_BUY_A9000
  from
  (
  select RESEARCH_DATE, REGION_CD, INDICES
  from AptTradingPriceIndex
  where 1=1
  and LEVEL_NO = 0
  and REGION_CD in ('A1000','11000','A2000','A2001','A3000','A9000')
  and TR_GBN = 'S'
  ) aa
  group by aa.RESEARCH_DATE
  order by aa.RESEARCH_DATE desc
  limit 10
    ";


$result_chart3 = mysqli_query($Conn, $sql_chart3);

while ($row_chart3 = mysqli_fetch_assoc($result_chart3)) {
    $data_array3[] = $row_chart3;
}
$chart3 = json_encode($data_array3);

$result_min_max3 = mysqli_query($Conn, $sql_min_max3);
$row_min_max3 = mysqli_fetch_assoc($result_min_max3);

$rs3 = mysqli_query($Conn, $sql3);

while ( $row3 = mysqli_fetch_assoc($rs3) ) {
    $rows3[] = $row3;
}
?>

<h1>전국 아파트 실거래 매매가격지수 그래프</h1>
<span style="font-size:20px;">국토부 제공 자료를 바탕으로 만들어진 데이터 입니다.
<br>아파트 실거래 가격지수란?
<br>아파트의 가격변화를 기준시점(‘21년 6월)을 100으로 한 상대값으로 표시한 것임
<br>*A지역 아파트 실거래 가격지수가 125라는 것은 ’21년 6월 대비 25% 상승하였음을 의미
</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart3; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '전세수급동향'];
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
            title: '매매가격지수 추이',
            legend: 'none',
            chartArea: {left: '4%', width: '93%'},
            hAxis: {
                title: 'Time',
                showTextEvery: 15    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 }
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max3['temp_min']?>, max: <?=$row_min_max3['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div3'));
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


<center><div id="lineChart_div3" style="width: 100%; height: 300px"></div></center>

<table>
    <thead>
    <tr>
        <th style="font-size: 20px;">조사날짜</th>
        <th style="font-size: 20px;">전국</th>
        <th style="font-size: 20px;">서울</th>
        <th style="font-size: 20px;">수도권</th>
        <th style="font-size: 20px;">지방권</th>
        <th style="font-size: 20px;">6대광역시</th>
        <th style="font-size: 20px;">9개도</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows3 as $row3) { ?>
      <tr>
          <td style="font-size: 20px;"><b><?=$row3['RESEARCH_DATE']?></b></td>
          <td style="font-size: 20px;"><b><?=$row3['case_BUY_A1000']?></b></td>
          <td style="font-size: 20px;"><b><?=$row3['case_BUY_11000']?></b></td>
          <td style="font-size: 20px;"><b><?=$row3['case_BUY_A2000']?></b></td>
          <td style="font-size: 20px;"><b><?=$row3['case_BUY_A2001']?></b></td>
          <td style="font-size: 20px;"><b><?=$row3['case_BUY_A3000']?></b></td>
          <td style="font-size: 20px;"><b><?=$row3['case_BUY_A9000']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>







<!--전국 아파트 실거래 전세가격지수 그래프-->
<?php
$sql_chart3_1 = "
select dt, temp
from
(
select
concat(substr(RESEARCH_DATE,1,4),'/',substr(RESEARCH_DATE,5,2),'/',substr(RESEARCH_DATE,7,2)) as dt,
CAST(INDICES as DECIMAL(10,2)) as temp
from AptTradingPriceIndex
where 1=1
and LEVEL_NO = 0
and REGION_CD = 'A1000'
and TR_GBN = 'D'
order by RESEARCH_DATE desc
limit 156
) aa
order by aa.dt
";

$sql_min_max3_1 = "
select
MIN(CAST(INDICES as DECIMAL(10,2))) as temp_min,
MAX(CAST(INDICES as DECIMAL(10,2))) as temp_max
from AptTradingPriceIndex
where 1=1
and LEVEL_NO = 0
and REGION_CD = 'A1000'
and TR_GBN = 'D'
order by RESEARCH_DATE desc
limit 156;
";


$sql3_1 = "
  select concat(substr(RESEARCH_DATE,1,4),'/',substr(RESEARCH_DATE,5,2),'/',substr(RESEARCH_DATE,7,2)) as RESEARCH_DATE,
  CAST(MAX(case when REGION_CD = 'A1000' then INDICES end) as DECIMAL(10,2)) as case_BUY_A1000,
  CAST(MAX(case when REGION_CD = '11000' then INDICES end) as DECIMAL(10,2)) as case_BUY_11000,
  CAST(MAX(case when REGION_CD = 'A2000' then INDICES end) as DECIMAL(10,2)) as case_BUY_A2000,
  CAST(MAX(case when REGION_CD = 'A2001' then INDICES end) as DECIMAL(10,2)) as case_BUY_A2001,
  CAST(MAX(case when REGION_CD = 'A3000' then INDICES end) as DECIMAL(10,2)) as case_BUY_A3000,
  CAST(MAX(case when REGION_CD = 'A9000' then INDICES end) as DECIMAL(10,2)) as case_BUY_A9000
  from
  (
  select RESEARCH_DATE, REGION_CD, INDICES
  from AptTradingPriceIndex
  where 1=1
  and LEVEL_NO = 0
  and REGION_CD in ('A1000','11000','A2000','A2001','A3000','A9000')
  and TR_GBN = 'D'
  ) aa
  group by aa.RESEARCH_DATE
  order by aa.RESEARCH_DATE desc
  limit 10
    ";

$result_chart3_1 = mysqli_query($Conn, $sql_chart3_1);

while ($row_chart3_1 = mysqli_fetch_assoc($result_chart3_1)) {
    $data_array3_1[] = $row_chart3_1;
}
$chart3_1 = json_encode($data_array3_1);

$result_min_max3_1 = mysqli_query($Conn, $sql_min_max3_1);
$row_min_max3_1 = mysqli_fetch_assoc($result_min_max3_1);
//여기는 그래프 관련


$rs3_1 = mysqli_query($Conn, $sql3_1);

while ( $row3_1 = mysqli_fetch_assoc($rs3_1) ) {
    $rows3_1[] = $row3_1;
}


 ?>

<h1>전국 아파트 실거래 전세가격지수 그래프</h1>

 <script type="text/javascript">
     google.charts.load('current', { packages: ['corechart', 'line'] });
     google.charts.load('current', { packages: ['table'] });
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {
         var chart_array = <?php echo $chart3_1; ?>;
         //console.log(JSON.stringify(chart_array))
         var header = ['Date&Time(MM-DD HH:MM)', '전세가격지수'];
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
             title: '전세가격지수 추이',
             legend: 'none',
             chartArea: {left: '4%', width: '93%'},
             hAxis: {
                 title: 'Time',
                 showTextEvery: 15    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
             },
             series: {
                 0: { targetAxisIndex: 0 }
             },
             vAxes: {
                 0: {
                     viewWindow: { min: <?=$row_min_max3_1['temp_min']?>, max: <?=$row_min_max3_1['temp_max']?> }
                 }
             },
             interpolateNulls : true
             //,
             //curveType: 'function',
             //legend: { position: 'bottom' }
         };

         var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div3_1'));
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


 <center><div id="lineChart_div3_1" style="width: 100%; height: 300px"></div></center>

 <table>
     <thead>
     <tr>
         <th style="font-size: 20px;">조사날짜</th>
         <th style="font-size: 20px;">전국</th>
         <th style="font-size: 20px;">서울</th>
         <th style="font-size: 20px;">수도권</th>
         <th style="font-size: 20px;">지방권</th>
         <th style="font-size: 20px;">6대광역시</th>
         <th style="font-size: 20px;">9개도</th>
     </tr>
     </thead>
     <tbody>
       <?php foreach ($rows3_1 as $row3_1) { ?>
       <tr>
           <td style="font-size: 20px;"><b><?=$row3_1['RESEARCH_DATE']?></b></td>
           <td style="font-size: 20px;"><b><?=$row3_1['case_BUY_A1000']?></b></td>
           <td style="font-size: 20px;"><b><?=$row3_1['case_BUY_11000']?></b></td>
           <td style="font-size: 20px;"><b><?=$row3_1['case_BUY_A2000']?></b></td>
           <td style="font-size: 20px;"><b><?=$row3_1['case_BUY_A2001']?></b></td>
           <td style="font-size: 20px;"><b><?=$row3_1['case_BUY_A3000']?></b></td>
           <td style="font-size: 20px;"><b><?=$row3_1['case_BUY_A9000']?></b></td>
       </tr>
       <?php } ?>
     </tbody>
 </table>
<br><br><br>





<?php


$sql_chart4 = "
select * FROM
(
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from NoBunYang
group by yyyymm
order by yyyymm desc
limit 48
) aa
order by aa.yyyymm
";

$sql_min_max4 = "
select min(temp) as temp_min, max(temp) as temp_max
FROM(
select yyyymm as dt, sum(cast(cnt as unsigned)) as temp
from NoBunYang
group by yyyymm
order by yyyymm desc
limit 48
) aa
";


$sql4 = "
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
sum(cast(cnt as unsigned)) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from NoBunYang
group by yyyymm
order by yyyymm desc
limit 12
    ";


$result_chart4 = mysqli_query($Conn, $sql_chart4);

while ($row_chart4 = mysqli_fetch_assoc($result_chart4)) {
    $data_array4[] = $row_chart4;
}
$chart4 = json_encode($data_array4);

$result_min_max4 = mysqli_query($Conn, $sql_min_max4);
$row_min_max4 = mysqli_fetch_assoc($result_min_max4);

$rs4 = mysqli_query($Conn, $sql4);

while ( $row4 = mysqli_fetch_assoc($rs4) ) {
    $rows4[] = $row4;
}
?>

<h1>전국 아파트 미분양 그래프</h1>
<span style="font-size:20px;">국토부 제공 자료를 바탕으로 만들어진 데이터 입니다.</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart4; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '서울', '부산', '대구', '인천', '광주', '대전', '울산', '경기', '강원', '충북', '충남', '전북', '전남', '경북', '경남', '제주', '세종'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt2),
                Number(item.cnt3),
                Number(item.cnt4),
                Number(item.cnt5),
                Number(item.cnt6),
                Number(item.cnt7),
                Number(item.cnt8),
                Number(item.cnt9),
                Number(item.cnt10),
                Number(item.cnt11),
                Number(item.cnt12),
                Number(item.cnt13),
                Number(item.cnt14),
                Number(item.cnt15),
                Number(item.cnt16),
                Number(item.cnt17)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전국 미분양 추이',
            chartArea: {left: '7%', width: '91%', height:'70%'},
            seriesType: "bars",
            isStacked: true,
            hAxis: {
                showTextEvery: 4    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            series: {
                0: { targetAxisIndex: 0 }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max4['temp_max']?> }
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div4'));
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


<center><div id="lineChart_div4" style="width: 100%; height: 400px"></div></center>

<table>
    <thead>
    <tr>
        <th style="font-size: 15px;">조사년월</th>
        <th style="font-size: 15px;">전국</th>
        <th style="font-size: 13px;">서울</th>
        <th style="font-size: 13px;">부산</th>
        <th style="font-size: 13px;">대구</th>
        <th style="font-size: 13px;">인천</th>
        <th style="font-size: 13px;">광주</th>
        <th style="font-size: 13px;">대전</th>
        <th style="font-size: 13px;">울산</th>
        <th style="font-size: 13px;">경기</th>
        <th style="font-size: 13px;">강원</th>
        <th style="font-size: 13px;">충북</th>
        <th style="font-size: 13px;">충남</th>
        <th style="font-size: 13px;">전북</th>
        <th style="font-size: 13px;">전남</th>
        <th style="font-size: 13px;">경북</th>
        <th style="font-size: 13px;">경남</th>
        <th style="font-size: 13px;">제주</th>
        <th style="font-size: 13px;">세종</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows4 as $row4) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row4['yyyymm']?></b></td>
          <td style="font-size: 15px;"><b><?=$row4['cnt_all']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt1']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt2']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt3']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt4']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt5']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt6']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt7']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt8']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt9']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt10']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt11']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt12']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt13']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt14']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt15']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt16']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt17']?></b></td>

      </tr>
      <?php } ?>
    </tbody>
</table>
<br><br><br>














<?php


$sql_chart41 = "
select * FROM
(
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from NoBunYangAfter
group by yyyymm
order by yyyymm desc
limit 48
) aa
order by aa.yyyymm
";

$sql_min_max41 = "
select min(temp) as temp_min, max(temp) as temp_max
FROM(
select yyyymm as dt, sum(cast(cnt as unsigned)) as temp
from NoBunYangAfter
group by yyyymm
order by yyyymm desc
limit 48
) aa
";


$sql41 = "
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
sum(cast(cnt as unsigned)) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from NoBunYangAfter
group by yyyymm
order by yyyymm desc
limit 12
    ";


$result_chart41 = mysqli_query($Conn, $sql_chart41);

while ($row_chart41 = mysqli_fetch_assoc($result_chart41)) {
    $data_array41[] = $row_chart41;
}
$chart41 = json_encode($data_array41);

$result_min_max41 = mysqli_query($Conn, $sql_min_max41);
$row_min_max41 = mysqli_fetch_assoc($result_min_max41);

$rs41 = mysqli_query($Conn, $sql41);

while ( $row41 = mysqli_fetch_assoc($rs41) ) {
    $rows41[] = $row41;
}
?>

<h1>전국 아파트 공사완료 후 미분양 그래프</h1>
<span style="font-size:20px;">국토부 제공 자료를 바탕으로 만들어진 데이터 입니다.</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart41; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '서울', '부산', '대구', '인천', '광주', '대전', '울산', '경기', '강원', '충북', '충남', '전북', '전남', '경북', '경남', '제주', '세종'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt2),
                Number(item.cnt3),
                Number(item.cnt4),
                Number(item.cnt5),
                Number(item.cnt6),
                Number(item.cnt7),
                Number(item.cnt8),
                Number(item.cnt9),
                Number(item.cnt10),
                Number(item.cnt11),
                Number(item.cnt12),
                Number(item.cnt13),
                Number(item.cnt14),
                Number(item.cnt15),
                Number(item.cnt16),
                Number(item.cnt17)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전국 미분양 추이',
            chartArea: {left: '7%', width: '91%', height:'70%'},
            seriesType: "bars",
            isStacked: true,
            hAxis: {
                showTextEvery: 4    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            series: {
                0: { targetAxisIndex: 0 }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max41['temp_max']?> }
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div41'));
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


<center><div id="lineChart_div41" style="width: 100%; height: 400px"></div></center>

<table>
    <thead>
    <tr>
        <th style="font-size: 15px;">조사년월</th>
        <th style="font-size: 15px;">전국</th>
        <th style="font-size: 13px;">서울</th>
        <th style="font-size: 13px;">부산</th>
        <th style="font-size: 13px;">대구</th>
        <th style="font-size: 13px;">인천</th>
        <th style="font-size: 13px;">광주</th>
        <th style="font-size: 13px;">대전</th>
        <th style="font-size: 13px;">울산</th>
        <th style="font-size: 13px;">경기</th>
        <th style="font-size: 13px;">강원</th>
        <th style="font-size: 13px;">충북</th>
        <th style="font-size: 13px;">충남</th>
        <th style="font-size: 13px;">전북</th>
        <th style="font-size: 13px;">전남</th>
        <th style="font-size: 13px;">경북</th>
        <th style="font-size: 13px;">경남</th>
        <th style="font-size: 13px;">제주</th>
        <th style="font-size: 13px;">세종</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows41 as $row41) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row41['yyyymm']?></b></td>
          <td style="font-size: 15px;"><b><?=$row41['cnt_all']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt1']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt2']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt3']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt4']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt5']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt6']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt7']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt8']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt9']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt10']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt11']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt12']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt13']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt14']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt15']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt16']?></b></td>
          <td style="font-size: 13px;"><b><?=$row41['cnt17']?></b></td>

      </tr>
      <?php } ?>
    </tbody>
</table>
<br><br><br>







<?php


$sql_chart5 = "
select * FROM
(
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from NewBunYang
group by yyyymm
order by yyyymm desc
limit 48
) aa
order by aa.yyyymm
";

$sql_min_max5 = "
select min(temp) as temp_min, max(temp)+1000 as temp_max
FROM(
select yyyymm as dt, sum(cast(cnt as unsigned)) as temp
from NewBunYang
where area not in ('전국','수도권','5대광역시 및 세종특별자치시','기타지방')
group by yyyymm
order by yyyymm desc
limit 48
) aa
";


$sql5 = "
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '전국' then cnt end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from NewBunYang
group by yyyymm
order by yyyymm desc
limit 12
    ";


$result_chart5 = mysqli_query($Conn, $sql_chart5);

while ($row_chart5 = mysqli_fetch_assoc($result_chart5)) {
    $data_array5[] = $row_chart5;
}
$chart5 = json_encode($data_array5);

$result_min_max5 = mysqli_query($Conn, $sql_min_max5);
$row_min_max5 = mysqli_fetch_assoc($result_min_max5);

$rs5 = mysqli_query($Conn, $sql5);

while ( $row5 = mysqli_fetch_assoc($rs5) ) {
    $rows5[] = $row5;
}
?>

<h1>전국 아파트 신규분양 그래프</h1>
<span style="font-size:20px;">국토부 제공 자료를 바탕으로 만들어진 데이터 입니다.</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart5; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '서울', '부산', '대구', '인천', '광주', '대전', '울산', '경기', '강원', '충북', '충남', '전북', '전남', '경북', '경남', '제주', '세종'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt2),
                Number(item.cnt3),
                Number(item.cnt4),
                Number(item.cnt5),
                Number(item.cnt6),
                Number(item.cnt7),
                Number(item.cnt8),
                Number(item.cnt9),
                Number(item.cnt10),
                Number(item.cnt11),
                Number(item.cnt12),
                Number(item.cnt13),
                Number(item.cnt14),
                Number(item.cnt15),
                Number(item.cnt16),
                Number(item.cnt17)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전국 신규분양 추이',
            chartArea: {left: '7%', width: '91%', height:'70%'},
            seriesType: "bars",
            isStacked: true,
            hAxis: {
                showTextEvery: 4    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            series: {
                0: { targetAxisIndex: 0 }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max5['temp_max']?> }
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div5'));
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


<center><div id="lineChart_div5" style="width: 100%; height: 400px"></div></center>

<table>
    <thead>
    <tr>
        <th style="font-size: 15px;">조사년월</th>
        <th style="font-size: 15px;">전국</th>
        <th style="font-size: 13px;">서울</th>
        <th style="font-size: 13px;">부산</th>
        <th style="font-size: 13px;">대구</th>
        <th style="font-size: 13px;">인천</th>
        <th style="font-size: 13px;">광주</th>
        <th style="font-size: 13px;">대전</th>
        <th style="font-size: 13px;">울산</th>
        <th style="font-size: 13px;">경기</th>
        <th style="font-size: 13px;">강원</th>
        <th style="font-size: 13px;">충북</th>
        <th style="font-size: 13px;">충남</th>
        <th style="font-size: 13px;">전북</th>
        <th style="font-size: 13px;">전남</th>
        <th style="font-size: 13px;">경북</th>
        <th style="font-size: 13px;">경남</th>
        <th style="font-size: 13px;">제주</th>
        <th style="font-size: 13px;">세종</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows5 as $row5) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row5['yyyymm']?></b></td>
          <td style="font-size: 15px;"><b><?=$row5['cnt_all']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt1']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt2']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt3']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt4']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt5']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt6']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt7']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt8']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt9']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt10']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt11']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt12']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt13']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt14']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt15']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt16']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt17']?></b></td>

      </tr>
      <?php } ?>
    </tbody>
</table>
<br><br><br>







<?php
$sql_chart51 = "
select
yyyyquarter,
IFNULL(CAST(MAX(case when area = '서울' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '수도권' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '기타지방' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '전국' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt_all
from InitialBunYangRate
group by yyyyquarter
order by yyyyquarter
";

$sql_min_max51 = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+10 as temp_max
FROM InitialBunYangRate
";


$sql51 = "
select
concat(substr(yyyyquarter,1,4),'년 ',substr(yyyyquarter,5,2)) as yyyyquarter,
IFNULL(CAST(MAX(case when area = '전국' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '수도권' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '기타지방' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt3
from InitialBunYangRate
group by yyyyquarter
order by yyyyquarter desc
limit 10
    ";


$result_chart51 = mysqli_query($Conn, $sql_chart51);

while ($row_chart51 = mysqli_fetch_assoc($result_chart51)) {
    $data_array51[] = $row_chart51;
}
$chart51 = json_encode($data_array51);

$result_min_max51 = mysqli_query($Conn, $sql_min_max51);
$row_min_max51 = mysqli_fetch_assoc($result_min_max51);
//여기는 그래프 관련


$rs51 = mysqli_query($Conn, $sql51);

while ( $row51 = mysqli_fetch_assoc($rs51) ) {
    $rows51[] = $row51;
}

?>

<h1>아파트 평균 초기분양율 그래프</h1>
<span style="font-size:20px;">주택도시보증공사 자료를 바탕으로 만들어진 데이터 입니다.</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart51; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '서울', '수도권', '기타지방','전국평균'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyyquarter,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt2),
                Number(item.cnt3),
                Number(item.cnt_all)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전국 초기분양률 추이',
            chartArea: {left: '7%', width: '88%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 4}
            ,1: {type: 'line', targetAxisIndex: 0, lineWidth: 4}
            ,2: {type: 'line', targetAxisIndex: 0, lineWidth: 4}
            ,3: {type: 'bars', targetAxisIndex: 0 , color: '#ced4da'}},
            hAxis: {
                showTextEvery: 2    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max51['temp_max']?>}, title : "지역별"
                },
                1: {
                    viewWindow: { min: 0, max: 100}, title : "전국"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div51'));
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


<center><div id="lineChart_div51" style="width: 100%; height: 400px"></div></center>

<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:20%">조사시점</th>
        <th style="font-size: 20px; width:20%">전국</th>
        <th style="font-size: 20px; width:20%">서울</th>
        <th style="font-size: 20px; width:20%">수도권</th>
        <th style="font-size: 20px; width:20%">지방</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows51 as $row51) { ?>
      <tr>
          <td style="font-size: 20px;"><b><?=$row51['yyyyquarter']?>분기</b></td>
          <td style="font-size: 20px;"><b><?=$row51['cnt_all']?>%</b></td>
          <td style="font-size: 20px;"><b><?=$row51['cnt1']?>%</b></td>
          <td style="font-size: 20px;"><b><?=$row51['cnt2']?>%</b></td>
          <td style="font-size: 20px;"><b><?=$row51['cnt3']?>%</b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<br><br><br>



<?php
$sql_chart52 = "
select
yyyymm,
IFNULL(CAST(MAX(case when area = '전국' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt1
from TongGye_Budongsan_Customer_Index
group by yyyymm
order by yyyymm
";

$sql_min_max52 = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+10 as temp_max
FROM TongGye_Budongsan_Customer_Index
";


$sql52 = "
select
concat(substr(yyyymm,1,4),'년 ',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '전국' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '수도권' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '비수도권' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt3
from TongGye_Budongsan_Customer_Index
group by yyyymm
order by yyyymm desc
limit 10
    ";


$result_chart52 = mysqli_query($Conn, $sql_chart52);

while ($row_chart52 = mysqli_fetch_assoc($result_chart52)) {
    $data_array52[] = $row_chart52;
}
$chart52 = json_encode($data_array52);

$result_min_max52 = mysqli_query($Conn, $sql_min_max52);
$row_min_max52 = mysqli_fetch_assoc($result_min_max52);
//여기는 그래프 관련


$rs52 = mysqli_query($Conn, $sql52);

while ( $row52 = mysqli_fetch_assoc($rs52) ) {
    $rows52[] = $row52;
}


 ?>

 <h1>부동산시장 소비자심리지수 그래프</h1>
 <span style="font-size:20px;">국토연구원 자료를 바탕으로 만들어진 데이터 입니다.</span>
 <br>
 <br>

 <span style="font-size:15px;">ㅇ 소비자심리지수는 0~200사이의 값으로 표현되며, 지수가 100을 넘으면 가격상승이나 거래증가 응답이 많음을 의미<br>
 ㅇ 소비심리지수는 일차적으로 각 조사항목별로 생성되고 항목별 지수가 단계적으로 더해져 최종 부동산시장 소비심리지수가 생성됨<br>
 ㅇ 지수값에 따라 9개 등급(상승국면 1~3단계, 보합국면 1~3단계, 하강국면 1~3단계)으로 구분<br>
 ㅇ 국면의 경우 지수가 115보다 크면 상승국면, 95보다 작으면 하강국면이고 그 사이를 보합국면으로 구분<br>
 ㅇ 결과표 및 상대표본오차수준은 해당 월 공표자료 부록 참고</span>
 <br>
 <br>
 <script type="text/javascript">
     google.charts.load('current', { packages: ['corechart', 'line'] });
     google.charts.load('current', { packages: ['table'] });
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {
         var chart_array = <?php echo $chart52; ?>;
         //console.log(JSON.stringify(chart_array))
         var header = ['Date&Time(MM-DD HH:MM)', '소비심리지수'];
         var row = "";
         var rows = new Array();
         jQuery.each(chart_array, function(index, item) {
             row = [
                 item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                 Number(item.cnt1)
             ];
             rows.push(row);
         });

         var jsonData = [header].concat(rows);
         var data = new google.visualization.arrayToDataTable(jsonData);

         var lineChartOptions = {
             title: '소비심리지수 추이',
             legend: 'none',
             chartArea: {left: '5%', width: '92%'},
             hAxis: {
                 title: 'Time',
                 showTextEvery: 13    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
             },
             series: {
                 0: { targetAxisIndex: 0, lineWidth: 4}
             },
             vAxes: {
                 0: {
                     viewWindow: { min: <?=$row_min_max52['temp_min']?>, max: <?=$row_min_max52['temp_max']?> }
                 }
             },
             interpolateNulls : true
             //,
             //curveType: 'function',
             //legend: { position: 'bottom' }
         };

         var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div52'));
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


 <center><div id="lineChart_div52" style="width: 100%; height: 400px"></div></center>

 <table>
     <thead>
     <tr>
         <th style="font-size: 20px; width:20%">조사시점</th>
         <th style="font-size: 20px; width:20%">전국</th>
         <th style="font-size: 20px; width:20%">수도권</th>
         <th style="font-size: 20px; width:20%">비수도권</th>
     </tr>
     </thead>
     <tbody>
       <?php foreach ($rows52 as $row52) { ?>
       <tr>
           <td style="font-size: 20px;"><b><?=$row52['yyyymm']?>월</b></td>
           <td style="font-size: 20px;"><b><?=$row52['cnt1']?></b></td>
           <td style="font-size: 20px;"><b><?=$row52['cnt2']?></b></td>
           <td style="font-size: 20px;"><b><?=$row52['cnt3']?></b></td>
       </tr>
       <?php } ?>
     </tbody>
 </table>
<br><br><br>


<?php
$sql_chart6 = "
select
yyyyquarter,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17,
ROUND(avg(cast(cnt as UNSIGNED))) as cnt_all
from BuyBurdenIndex
group by yyyyquarter
order by yyyyquarter
";

$sql_min_max6 = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+10 as temp_max
FROM BuyBurdenIndex
";


$sql6 = "
select
concat(substr(yyyyquarter,1,4),'년 ',substr(yyyyquarter,5,2)) as yyyyquarter,
ROUND(avg(cast(cnt as UNSIGNED))) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from BuyBurdenIndex
group by yyyyquarter
order by yyyyquarter desc
limit 6
    ";

$result_chart6 = mysqli_query($Conn, $sql_chart6);

while ($row_chart6 = mysqli_fetch_assoc($result_chart6)) {
    $data_array6[] = $row_chart6;
}
$chart6 = json_encode($data_array6);

$result_min_max6 = mysqli_query($Conn, $sql_min_max6);
$row_min_max6 = mysqli_fetch_assoc($result_min_max6);
//여기는 그래프 관련


$rs6 = mysqli_query($Conn, $sql6);

while ( $row6 = mysqli_fetch_assoc($rs6) ) {
    $rows6[] = $row6;
}

?>

<h1>전국 주택구입부담지수 그래프</h1>
<span style="font-size:20px;">주택금융통계시스템 자료를 바탕으로 만들어진 데이터 입니다.
<br><br>주택구입부담지수란?
<br>중위소득 가구가 표준대출을 받아 중간가격의 주택을 구입하는 경우의 상환부담을 나타내는 지수
<br><br>ex) 지수가 91%라고 하면 중간소득 가구가 중간가격의 주택을 구입할 경우 <br>적정부담액 (소득의 약25%)의 90.1%를 주택구입담보대출 원리금 상환으로 부담한다는 것으로<br>지수의 수치가 높을수록 주택구입 부담이 커지는 것을 의미
</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart6; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '서울', '부산', '대구', '인천', '광주', '대전', '울산', '경기', '강원', '충북', '충남', '전북', '전남', '경북', '경남', '제주', '세종','전국평균'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyyquarter,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt2),
                Number(item.cnt3),
                Number(item.cnt4),
                Number(item.cnt5),
                Number(item.cnt6),
                Number(item.cnt7),
                Number(item.cnt8),
                Number(item.cnt9),
                Number(item.cnt10),
                Number(item.cnt11),
                Number(item.cnt12),
                Number(item.cnt13),
                Number(item.cnt14),
                Number(item.cnt15),
                Number(item.cnt16),
                Number(item.cnt17),
                Number(item.cnt_all)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전국 미분양 추이',
            chartArea: {left: '7%', width: '88%', height:'70%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0}
            ,1: {type: 'line', targetAxisIndex: 0}
            ,2: {type: 'line', targetAxisIndex: 0}
            ,3: {type: 'line', targetAxisIndex: 0}
            ,4: {type: 'line', targetAxisIndex: 0}
            ,5: {type: 'line', targetAxisIndex: 0}
            ,6: {type: 'line', targetAxisIndex: 0}
            ,7: {type: 'line', targetAxisIndex: 0}
            ,8: {type: 'line', targetAxisIndex: 0}
            ,9: {type: 'line', targetAxisIndex: 0}
            ,10: {type: 'line', targetAxisIndex: 0}
            ,11: {type: 'line', targetAxisIndex: 0}
            ,12: {type: 'line', targetAxisIndex: 0}
            ,13: {type: 'line', targetAxisIndex: 0}
            ,14: {type: 'line', targetAxisIndex: 0}
            ,15: {type: 'line', targetAxisIndex: 0}
            ,16: {type: 'line', targetAxisIndex: 0}
            ,17: {type: 'bars', targetAxisIndex: 1 , color: '#ced4da'}},
            hAxis: {
                showTextEvery: 2    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max6['temp_max']?>}, title : "지역별"
                },
                1: {
                    viewWindow: { min: 0, max: 100}, title : "전국"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div6'));
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


<center><div id="lineChart_div6" style="width: 100%; height: 400px"></div></center>

<table>
    <thead>
    <tr>
        <th style="font-size: 15px;">조사시점</th>
        <th style="font-size: 15px;">전국</th>
        <th style="font-size: 15px;">서울</th>
        <th style="font-size: 15px;">부산</th>
        <th style="font-size: 15px;">대구</th>
        <th style="font-size: 15px;">인천</th>
        <th style="font-size: 15px;">광주</th>
        <th style="font-size: 15px;">대전</th>
        <th style="font-size: 15px;">울산</th>
        <th style="font-size: 15px;">경기</th>
        <th style="font-size: 15px;">강원</th>
        <th style="font-size: 15px;">충북</th>
        <th style="font-size: 15px;">충남</th>
        <th style="font-size: 15px;">전북</th>
        <th style="font-size: 15px;">전남</th>
        <th style="font-size: 15px;">경북</th>
        <th style="font-size: 15px;">경남</th>
        <th style="font-size: 15px;">제주</th>
        <th style="font-size: 15px;">세종</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows6 as $row6) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row6['yyyyquarter']?>분기</b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt_all']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt1']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt2']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt3']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt4']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt5']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt6']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt7']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt8']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt9']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt10']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt11']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt12']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt13']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt14']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt15']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt16']?></b></td>
          <td style="font-size: 15px;"><b><?=$row6['cnt17']?></b></td>

      </tr>
      <?php } ?>
    </tbody>
</table>
<br><br><br>







<?php


$sql_chart7 = "
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '전국' then cnt end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from MemeAvg
group by yyyymm
order by yyyymm
";

$sql_min_max7 = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+50 as temp_max
FROM MemeAvg
where area in ('전국','서울','부산','대구','인천','광주','대전','울산','경기','강원','충북','충남','전북','전남','경북','경남','제주','세종')
";

$sql_min_max72 = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+50 as temp_max
FROM MemeAvg
where area = '전국'
";


$sql7 = "
select
concat(substr(yyyymm,1,4),'년 ',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '전국' then cnt end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from MemeAvg
group by yyyymm
order by yyyymm desc
limit 10
    ";

$result_chart7 = mysqli_query($Conn, $sql_chart7);

while ($row_chart7 = mysqli_fetch_assoc($result_chart7)) {
    $data_array7[] = $row_chart7;
}
$chart7 = json_encode($data_array7);

$result_min_max7 = mysqli_query($Conn, $sql_min_max7);
$row_min_max7 = mysqli_fetch_assoc($result_min_max7);

$result_min_max72 = mysqli_query($Conn, $sql_min_max72);
$row_min_max72 = mysqli_fetch_assoc($result_min_max72);
//여기는 그래프 관련


$rs7 = mysqli_query($Conn, $sql7);

while ( $row7 = mysqli_fetch_assoc($rs7) ) {
    $rows7[] = $row7;
}


 ?>


<h1>아파트 매매 실거래 평균가격 그래프 (단위: 만원/㎡)</h1>
 <span style="font-size:20px;">한국 부동산원 자료를 바탕으로 만들어진 데이터 입니다.</span>
 <br>
 <script type="text/javascript">
     google.charts.load('current', { packages: ['corechart'] });
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {
         var chart_array = <?php echo $chart7; ?>;

         //console.log(JSON.stringify(chart_array))
         var header = ['Date&Time(MM-DD HH:MM)', '서울', '부산', '대구', '인천', '광주', '대전', '울산', '경기', '강원', '충북', '충남', '전북', '전남', '경북', '경남', '제주', '세종','전국평균'];
         var row = "";
         var rows = new Array();
         jQuery.each(chart_array, function(index, item) {
             row = [
                 item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                 Number(item.cnt1),
                 Number(item.cnt2),
                 Number(item.cnt3),
                 Number(item.cnt4),
                 Number(item.cnt5),
                 Number(item.cnt6),
                 Number(item.cnt7),
                 Number(item.cnt8),
                 Number(item.cnt9),
                 Number(item.cnt10),
                 Number(item.cnt11),
                 Number(item.cnt12),
                 Number(item.cnt13),
                 Number(item.cnt14),
                 Number(item.cnt15),
                 Number(item.cnt16),
                 Number(item.cnt17),
                 Number(item.cnt_all)
             ];
             rows.push(row);
         });

         var jsonData = [header].concat(rows);
         var data = new google.visualization.arrayToDataTable(jsonData);

         var lineChartOptions = {
             title: '아파트 평균가격 추이',
             chartArea: {left: '7%', width: '91%', height:'72%'},
             seriesType: "bars",
             series: {0: {type: 'line', targetAxisIndex: 0}
             ,1: {type: 'line', targetAxisIndex: 0}
             ,2: {type: 'line', targetAxisIndex: 0}
             ,3: {type: 'line', targetAxisIndex: 0}
             ,4: {type: 'line', targetAxisIndex: 0}
             ,5: {type: 'line', targetAxisIndex: 0}
             ,6: {type: 'line', targetAxisIndex: 0}
             ,7: {type: 'line', targetAxisIndex: 0}
             ,8: {type: 'line', targetAxisIndex: 0}
             ,9: {type: 'line', targetAxisIndex: 0}
             ,10: {type: 'line', targetAxisIndex: 0}
             ,11: {type: 'line', targetAxisIndex: 0}
             ,12: {type: 'line', targetAxisIndex: 0}
             ,13: {type: 'line', targetAxisIndex: 0}
             ,14: {type: 'line', targetAxisIndex: 0}
             ,15: {type: 'line', targetAxisIndex: 0}
             ,16: {type: 'line', targetAxisIndex: 0}
             ,17: {type: 'line', targetAxisIndex: 0}},
             hAxis: {
                 showTextEvery: 6    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
             },
             annotations: {
                    textStyle: {
                      fontSize: 35,
                      opacity: 1.8
                    }
             },
             vAxes: {
                 0: {
                     viewWindow: { min: 0, max: <?=$row_min_max7['temp_max']?>}, title : "지역별"
                 }
             },
             interpolateNulls : true,
             //,
             //curveType: 'function',
             legend: { position: 'top' , maxLines: 3}
         };

         var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div7'));
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


 <center><div id="lineChart_div7" style="width: 100%; height: 400px"></div></center>

 <table>
     <thead>
     <tr>
         <th style="font-size: 15px;">조사시점</th>
         <th style="font-size: 15px;">전국</th>
         <th style="font-size: 15px;">서울</th>
         <th style="font-size: 15px;">부산</th>
         <th style="font-size: 15px;">대구</th>
         <th style="font-size: 15px;">인천</th>
         <th style="font-size: 15px;">광주</th>
         <th style="font-size: 15px;">대전</th>
         <th style="font-size: 15px;">울산</th>
         <th style="font-size: 15px;">경기</th>
         <th style="font-size: 15px;">강원</th>
         <th style="font-size: 15px;">충북</th>
         <th style="font-size: 15px;">충남</th>
         <th style="font-size: 15px;">전북</th>
         <th style="font-size: 15px;">전남</th>
         <th style="font-size: 15px;">경북</th>
         <th style="font-size: 15px;">경남</th>
         <th style="font-size: 15px;">제주</th>
         <th style="font-size: 15px;">세종</th>
     </tr>
     </thead>
     <tbody>
       <?php foreach ($rows7 as $row7) { ?>
       <tr>
           <td style="font-size: 15px;"><b><?=$row7['yyyymm']?>월</b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt_all']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt1']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt2']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt3']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt4']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt5']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt6']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt7']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt8']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt9']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt10']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt11']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt12']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt13']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt14']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt15']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt16']?></b></td>
           <td style="font-size: 15px;"><b><?=$row7['cnt17']?></b></td>

       </tr>
       <?php } ?>
     </tbody>
 </table>
<br><br><br>





<?php

$sql_chart8 = "
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '전국' then cnt end) as DECIMAL(10,2)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,2)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,2)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,2)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,2)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,2)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,2)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,2)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,2)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,2)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,2)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,2)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,2)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,2)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,2)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,2)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,2)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,2)),0) as cnt17
from RentRate
group by yyyymm
order by yyyymm
";

$sql_min_max8 = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+50 as temp_max
FROM RentRate
";

$sql_min_max82 = "
select min(CAST(cnt as DECIMAL(10,0)))-10 as temp_min, max(CAST(cnt as DECIMAL(10,0)))+10 as temp_max
FROM RentRate
where area = '전국'
";


$sql8 = "
select
concat(substr(yyyymm,1,4),'년 ',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '전국' then cnt end) as DECIMAL(10,1)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,1)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,1)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,1)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,1)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,1)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,1)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,1)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,1)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,1)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,1)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,1)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,1)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,1)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,1)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,1)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,1)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,1)),0) as cnt17
from RentRate
group by yyyymm
order by yyyymm desc
limit 10
    ";

$result_chart8 = mysqli_query($Conn, $sql_chart8);

while ($row_chart8 = mysqli_fetch_assoc($result_chart8)) {
    $data_array8[] = $row_chart8;
}
$chart8 = json_encode($data_array8);

$result_min_max8 = mysqli_query($Conn, $sql_min_max8);
$row_min_max8 = mysqli_fetch_assoc($result_min_max8);

$result_min_max82 = mysqli_query($Conn, $sql_min_max82);
$row_min_max82 = mysqli_fetch_assoc($result_min_max82);
//여기는 그래프 관련


$rs8 = mysqli_query($Conn, $sql8);

while ( $row8 = mysqli_fetch_assoc($rs8) ) {
    $rows8[] = $row8;
}


 ?>


 <h1>아파트 매매가격 대비 전세가격 비율 그래프</h1>
 <span style="font-size:20px;">한국 부동산원 자료를 바탕으로 만들어진 데이터 입니다.</span>
 <br>
 <script type="text/javascript">
     google.charts.load('current', { packages: ['corechart'] });
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {
         var chart_array = <?php echo $chart8; ?>;

         //console.log(JSON.stringify(chart_array))
         var header = ['Date&Time(MM-DD HH:MM)', '서울', '부산', '대구', '인천', '광주', '대전', '울산', '경기', '강원', '충북', '충남', '전북', '전남', '경북', '경남', '제주', '세종','전국평균'];
         var row = "";
         var rows = new Array();
         jQuery.each(chart_array, function(index, item) {
             row = [
                 item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                 Number(item.cnt1),
                 Number(item.cnt2),
                 Number(item.cnt3),
                 Number(item.cnt4),
                 Number(item.cnt5),
                 Number(item.cnt6),
                 Number(item.cnt7),
                 Number(item.cnt8),
                 Number(item.cnt9),
                 Number(item.cnt10),
                 Number(item.cnt11),
                 Number(item.cnt12),
                 Number(item.cnt13),
                 Number(item.cnt14),
                 Number(item.cnt15),
                 Number(item.cnt16),
                 Number(item.cnt17),
                 Number(item.cnt_all)
             ];
             rows.push(row);
         });

         var jsonData = [header].concat(rows);
         var data = new google.visualization.arrayToDataTable(jsonData);

         var lineChartOptions = {
             title: '아파트 전세가율 추이',
             chartArea: {left: '7%', width: '91%', height:'72%'},
             seriesType: "bars",
             series: {0: {type: 'line', targetAxisIndex: 0}
             ,1: {type: 'line', targetAxisIndex: 0}
             ,2: {type: 'line', targetAxisIndex: 0}
             ,3: {type: 'line', targetAxisIndex: 0}
             ,4: {type: 'line', targetAxisIndex: 0}
             ,5: {type: 'line', targetAxisIndex: 0}
             ,6: {type: 'line', targetAxisIndex: 0}
             ,7: {type: 'line', targetAxisIndex: 0}
             ,8: {type: 'line', targetAxisIndex: 0}
             ,9: {type: 'line', targetAxisIndex: 0}
             ,10: {type: 'line', targetAxisIndex: 0}
             ,11: {type: 'line', targetAxisIndex: 0}
             ,12: {type: 'line', targetAxisIndex: 0}
             ,13: {type: 'line', targetAxisIndex: 0}
             ,14: {type: 'line', targetAxisIndex: 0}
             ,15: {type: 'line', targetAxisIndex: 0}
             ,16: {type: 'line', targetAxisIndex: 0}
             ,17: {type: 'line', targetAxisIndex: 0}},
             hAxis: {
                 showTextEvery: 6    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
             },
             annotations: {
                    textStyle: {
                      fontSize: 35,
                      opacity: 1.8
                    }
             },
             vAxes: {
                 0: {
                     viewWindow: { min: 45, max: 85}, title : "지역별"
                 }
             },
             interpolateNulls : true,
             //,
             //curveType: 'function',
             legend: { position: 'top' , maxLines: 3}
         };

         var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div8'));
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


 <center><div id="lineChart_div8" style="width: 100%; height: 500px"></div></center>


 <table>
     <thead>
     <tr>
         <th style="font-size: 15px;">조사시점</th>
         <th style="font-size: 15px;">전국</th>
         <th style="font-size: 15px;">서울</th>
         <th style="font-size: 15px;">부산</th>
         <th style="font-size: 15px;">대구</th>
         <th style="font-size: 15px;">인천</th>
         <th style="font-size: 15px;">광주</th>
         <th style="font-size: 15px;">대전</th>
         <th style="font-size: 15px;">울산</th>
         <th style="font-size: 15px;">경기</th>
         <th style="font-size: 15px;">강원</th>
         <th style="font-size: 15px;">충북</th>
         <th style="font-size: 15px;">충남</th>
         <th style="font-size: 15px;">전북</th>
         <th style="font-size: 15px;">전남</th>
         <th style="font-size: 15px;">경북</th>
         <th style="font-size: 15px;">경남</th>
         <th style="font-size: 15px;">제주</th>
         <th style="font-size: 15px;">세종</th>
     </tr>
     </thead>
     <tbody>
       <?php foreach ($rows8 as $row8) { ?>
       <tr>
           <td style="font-size: 15px;"><b><?=$row8['yyyymm']?>월</b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt_all']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt1']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt2']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt3']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt4']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt5']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt6']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt7']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt8']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt9']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt10']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt11']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt12']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt13']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt14']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt15']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt16']?></b></td>
           <td style="font-size: 15px;"><b><?=$row8['cnt17']?></b></td>

       </tr>
       <?php } ?>
     </tbody>
 </table>
 <br><br><br>





 <?php

 $sql_chart9 = "
 select
 yyyymm,
 IFNULL(CAST(cnt as DECIMAL(10,0)),0) as cnt1
 from TongGye_Gongsa_Pay
 group by yyyymm
 order by yyyymm
 ";

 $sql_min_max9 = "
 select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+10 as temp_max
 FROM TongGye_Gongsa_Pay
 ";


 $sql9 = "
 select
 concat(substr(yyyymm,1,4),'년 ',substr(yyyymm,5,2)) as yyyymm,
 IFNULL(CAST(cnt as DECIMAL(10,0)),0) as cnt1
 from TongGye_Gongsa_Pay
 group by yyyymm
 order by yyyymm desc
 limit 10
     ";


 $result_chart9 = mysqli_query($Conn, $sql_chart9);

 while ($row_chart9 = mysqli_fetch_assoc($result_chart9)) {
     $data_array9[] = $row_chart9;
 }
 $chart9 = json_encode($data_array9);

 $result_min_max9 = mysqli_query($Conn, $sql_min_max9);
 $row_min_max9 = mysqli_fetch_assoc($result_min_max9);
 //여기는 그래프 관련


 $rs9 = mysqli_query($Conn, $sql9);

 while ( $row9 = mysqli_fetch_assoc($rs9) ) {
     $rows9[] = $row9;
 }


  ?>


  <h1>건설 공사비 지수 그래프</h1>
  <span style="font-size:20px;">한국건설기술연구원 자료를 바탕으로 만들어진 데이터 입니다.</span>
  <br>
  <br>
  <span style="font-size:15px;">
    ㅇ물가지수는 가격의 변동추이 측정이 목적이며, 가격의 절대수준을 나타내지는 않음<br>
    ㅇ본 지수에 사용된 농림수산품의 조사대상가격은 도매시장 경락가격으로 농어가의 판매가격이 아니며, 소비자물가지수 및 생산자물가지수와 지수수준의 비교는 가능하나 직접공사비 부분 이외의 건설가격의 측정 등에는 이용될 수는 없음<br>
    ㅇ본 지수는 과거 기준연도와의 시계열 일관성 확보를 위해 구지수의 등락율을 기준으로 역산하여 신/구지수간의 시계열을 접속하였음<br>
    ㅇ본 지수의 개발취지와 용도에 반하는 지수의 오용방지와 현재 진행되고 있는 후속 조치의 보호를 위하여 본 지수를 이용하거나 또는 가공하여 별도의 연구를 수행 할 경우에는 반드시 한국건설기술연구원의 사전승인을 받아야 하며, 건설공사비지수를 인용함에 있어 본 자료에서 제시한 결과 이외의 추가적인 해석을 금함
  </span>
  <br>
  <script type="text/javascript">
      google.charts.load('current', { packages: ['corechart'] });
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
          var chart_array = <?php echo $chart9; ?>;

          //console.log(JSON.stringify(chart_array))
          var header = ['Date&Time(MM-DD HH:MM)', '공사비지수'];
          var row = "";
          var rows = new Array();
          jQuery.each(chart_array, function(index, item) {
              row = [
                  item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                  Number(item.cnt1)
              ];
              rows.push(row);
          });

          var jsonData = [header].concat(rows);
          var data = new google.visualization.arrayToDataTable(jsonData);

          var lineChartOptions = {
              title: '건설공사비 추이',
              chartArea: {left: '7%', width: '88%', height:'72%'},
              seriesType: "bars",
              series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 4}},
              hAxis: {
                  showTextEvery: 20    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
              },
              annotations: {
                     textStyle: {
                       fontSize: 35,
                       opacity: 1.8
                     }
              },
              vAxes: {
                  0: {
                      viewWindow: { min: <?=$row_min_max9['temp_min']?>, max: <?=$row_min_max9['temp_max']?>}, title : "공사비지수"
                  }
              },
              interpolateNulls : true,
              //,
              //curveType: 'function',
              legend: { position: 'top' , maxLines: 3}
          };

          var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div9'));
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


  <center><div id="lineChart_div9" style="width: 100%; height: 400px"></div></center>

  
  <table>
      <thead>
      <tr>
          <th style="font-size: 20px; width:20%">조사시점</th>
          <th style="font-size: 20px; width:20%">공사비지수</th>
      </tr>
      </thead>
      <tbody>
        <?php foreach ($rows9 as $row9) { ?>
        <tr>
            <td style="font-size: 20px;"><b><?=$row9['yyyymm']?>월</b></td>
            <td style="font-size: 20px;"><b><?=$row9['cnt1']?></b></td>
        </tr>
        <?php } ?>
      </tbody>
  </table>

<br>






<!-- 국평 아파트 평균가격 그래프-->

<?php
$sql_chart7_1 = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart7_1 = mysqli_query($Conn, $sql_chart7_1);

while ($row_chart7_1 = mysqli_fetch_assoc($result_chart7_1)) {
    $data_array7_1[] = $row_chart7_1;
}
$chart7_1 = json_encode($data_array7_1);



$sql_min_max7_1 = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
GROUP BY INSERT_date
) a
";

$result_min_max7_1 = mysqli_query($Conn, $sql_min_max7_1);
$row_min_max7_1 = mysqli_fetch_assoc($result_min_max7_1);


?>

<h1>전국 국평(85㎡) 평균가격 그래프 (자체집계한 자료입니다.)</h1>
<span style="font-size:20px;">(참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart7_1; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '아파트평균가격(단위:억)',
            legend: 'none',
            chartArea: {left: '4%', width: '93%'},
            hAxis: {
                showTextEvery: 3    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max7_1['temp_min']?>, max: <?=$row_min_max7_1['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div7_1'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div7_1" style="width: 100%; height: 400px"></div></center>





<center><span style="font-size:20px;"><b>Copyright ©2022 오늘집값 - TodayHousePrice.com, Inc. All rights reserved</b></span></center>

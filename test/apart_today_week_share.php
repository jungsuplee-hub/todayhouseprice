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
<title>오늘집값 - 아파트 금일 신규거래 조회</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 금일 아파트 신규 매매/전세 조회">
<meta property="og:description" content="오늘집값 - 금일 등록된 아파트 신규 매매/전세 정보를 조회할 수 있습니다.">
<meta property="og:image" content="./todayhouseprice2.png">
<meta property="og:url" content="http://todayhouseprice.com/apart_today.php">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
     crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="./todayhouseprice.css">
</head>
<?php
$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
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
$insert_date = date("Y-m-d");

//SELECT replace(area_sub_name,' ','') as area_sub_name FROM molit_area_info where area_main_name = '$area_main_name' order by area_sub_name

$before1Day = date("Y-m-d", strtotime($today." -1 day"));
$before2Day = date("Y-m-d", strtotime($today." -2 day"));
$before3Day = date("Y-m-d", strtotime($today." -3 day"));
$before4Day = date("Y-m-d", strtotime($today." -4 day"));
$before5Day = date("Y-m-d", strtotime($today." -5 day"));
$before6Day = date("Y-m-d", strtotime($today." -6 day"));
$before7Day = date("Y-m-d", strtotime($today." -7 day"));

$sql = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	today.size,
      	today.stair,
      	today.price ,
      	today.TYPE,
      	today.STATUS ,
      	today.max_price,
      	today.max_price_date,
      	today.min_price,
      	today.min_price_date,
      	today.last_price,
      	today.last_price_date,
      	ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2) as price_last,

      	case
  			  when CAST(today.price as DECIMAL(10,5)) > CAST(today.last_price as DECIMAL(10,5))
  			  then ROUND(((CAST(today.price as DECIMAL(10,5))/CAST(today.last_price as DECIMAL(10,5))*100)-100),0)
  			  when CAST(today.price as DECIMAL(10,5)) < CAST(today.last_price as DECIMAL(10,5))
  			  then ROUND(100-(CAST(today.price as DECIMAL(10,5))/CAST(today.last_price as DECIMAL(10,5)))*100,0)
			    ELSE 0 END AS percent,
        ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.max_price as DECIMAL(10,5))),2) as price_max,
        ROUND(100-(CAST(today.price as DECIMAL(10,5))/CAST(today.max_price as DECIMAL(10,5)))*100,0) AS max_percent,
			  IFNULL(rent.last_price,0) AS rent_last_price,
			  IFNULL(rent.max_price,0) AS rent_max_price,
			  IFNULL(rent.min_price,0) AS rent_min_price
      from molit_today_update today LEFT join molit_max_min_rent_all_group rent
      ON today.area_main_name = rent.area_main_name
      AND today.doing = rent.dong
      AND today.apart_name = rent.apart_name
      AND ROUND(CAST(today.size as DECIMAL(10,2))) = rent.size
      where today.insert_date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day')
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 100;
      ";

$sql_status = "
  SELECT
      (SELECT COUNT(1) from molit_today_update today WHERE insert_Date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') and status is not null) AS total,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='신고가' and status is not null GROUP BY STATUS),0) AS upup,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='상승' and status is not null GROUP BY STATUS),0) AS up,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='동일' and status is not null GROUP BY STATUS),0) AS same,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='하락' and status is not null GROUP BY STATUS),0) AS down,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='신저가' and status is not null GROUP BY STATUS),0) AS downdown,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='신규' and status is not null GROUP BY STATUS),0) AS new,
      (SELECT SUM(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') and status is not null AND STATUS IN ('신고가','상승')) AS up_price,
      (SELECT SUM(ROUND((CAST(last_price as DECIMAL(10,5)) - CAST(price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date in ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') and status is not null AND STATUS IN ('신저가','하락')) AS down_price
      FROM DUAL;
";




$rs = mysqli_query($Conn, $sql);
while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

$rs_status = mysqli_query($Conn, $sql_status);
$row_status = mysqli_fetch_assoc($rs_status);
$rows_status[] = $row_status;



$last_week = $before6Day.'~'.$insert_date;

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

<h1>최근 일주일 (<?=$last_week?>) 전국 아파트 신규 매매 리스트<br>정렬 : 최근거래대비 변동금액 상위 100, 아래 건수/금액합계는 전체</h1>
<span style="font-size:25px;"><b>총 <?php echo $row_status['total']; ?>건, 총 상승금액 : <?php if($row_status['up_price']==''){echo '0';}else{ echo $row_status['up_price'];} ?>억, 총 하락금액 : <?php if($row_status['down_price']==''){echo '0';}else{ echo $row_status['down_price'];} ?>억<br>(신고가 <?php echo $row_status['upup']; ?>건, 상승 <?php echo $row_status['up']; ?>건, 동일 <?php echo $row_status['same']; ?>건, 하락 <?php echo $row_status['down']; ?>건, 신저가 <?php echo $row_status['downdown']; ?>건, 신규 <?php echo $row_status['new']; ?>건)</b></span>
<br>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:35%;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:14%;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:12%;"><b>신규가격<br>가격변동<br>변동률</b></th>
        <th style="font-size: 20px; width:13%;"><b>최고대비<br>하락/상승률</b></th>
        <th style="font-size: 20px; width:13%;"><b>최근가격</b><br>(최근전세)</th>
        <th style="font-size: 20px; width:13%;"><b>최고가격</b><br>(최고전세)</th>

    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[doing]?>&all_area=N'><b><span style="font-size: 30px;"><?=$row['apart_name']?></span></b><br><?=$row['yearmonthday']?><br><?=$row['area_main_name']?> <?=$row['area_name']?> <?=$row['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; width:14%;"><b><?=$row['size']?>㎡</b><br><?=$row['stair']?>층<br><?=$row['TYPE']?></td>
          <?php

          if ( $row['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; width:12%;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]% 상승<br>신고가</td>";
          } elseif ( $row['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; width:12%;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]% 상승</td>";
          } elseif ( $row['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; width:12%;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]%<br>동일</td>";
          } elseif ( $row['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; width:12%;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]% 하락</td>";
          } elseif ( $row['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; width:12%;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]% 하락<br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%;'><b>$row[price]억</b><br>$row[price_last]억<br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:13%;"><b><?=$row['price_max']?>억<br><?php if($row['max_percent']>=30){ echo "<span style='color:red;'>최고가 대비<br>"; echo $row['max_percent']; echo "%하락</span>";} elseif($row['max_percent']<0){ echo "<span style='color:green;'>최고가 대비<br>"; echo abs($row['max_percent']); echo "%상승</span>";}  else{ echo "최고가 대비<br>"; echo $row['max_percent']; echo "%하락";} ?></b></td>
          <td style="font-size: 20px; width:13%;"><b><?=$row['last_price']?>억</b><br><?=$row['last_price_date']?><br>(<?=$row['rent_last_price']?>억)</td>
          <td style="font-size: 20px; width:13%;"><b><?=$row['max_price']?>억</b><br><?=$row['max_price_date']?><br>(<?=$row['rent_max_price']?>억)</td>

      </tr>
      <?php } ?>
    </tbody>
</table>











<?php
$sql_chart = "
SELECT insert_date,up_price,down_price,(down_price-up_price) as diff_price FROM
(
SELECT
insert_date,
sum(case when STATUS = '상승' OR STATUS = '신고가' then cast(price as decimal(10,2)) - cast(last_price as decimal(10,2)) ELSE 0 END) AS up_price,
sum(case when STATUS = '하락' OR STATUS = '신저가' then cast(last_price as decimal(10,2)) - cast(price as decimal(10,2)) ELSE 0 END) AS down_price
FROM molit_today_update
GROUP BY insert_date
) AS a
WHERE a.up_price > 10
AND a.down_price > 10
";

$sql_min_max = "
select case when max(down_price)>max(up_price) then max(down_price) else max(up_price) end as temp_max, 0 as temp_min
from
(
SELECT
insert_date,
sum(case when STATUS = '상승' OR STATUS = '신고가' then cast(price as decimal(10,2)) - cast(last_price as decimal(10,2)) ELSE 0 END) AS up_price,
sum(case when STATUS = '하락' OR STATUS = '신저가' then cast(last_price as decimal(10,2)) - cast(price as decimal(10,2)) ELSE 0 END) AS down_price
FROM molit_today_update
GROUP BY insert_date
) as a
WHERE a.up_price > 10
AND a.down_price > 10
";

$result_chart = mysqli_query($Conn, $sql_chart);

while ($row_chart = mysqli_fetch_assoc($result_chart)) {
    $data_array[] = $row_chart;
}
$chart = json_encode($data_array);

$result_min_max = mysqli_query($Conn, $sql_min_max);
$row_min_max = mysqli_fetch_assoc($result_min_max);

?>


<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>
<h2>아래 그래프는 "오늘집값" 누적 데이터로 만들어진 그래프 입니다.</h2>
<h1>전국 일자별 총 상승/하락 금액 (단위: 억원, 22년 10월 14일 이후)</h1>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '상승', '하락', '차이'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.up_price),
                Number(item.down_price),
                Number(item.diff_price)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            chartArea: {left: '7%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,1: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,2: {type: 'bars', targetAxisIndex: 1, color: '#ced4da'}},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max['temp_max']?>}, title : "상승/하락(억)"
                },
                1: {
                    viewWindow: { min: -100, max: 300}, title : "차이(억)"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div'));
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


<center><div id="lineChart_div" style="width: 100%; height: 400px"></div></center>






<?php


$sql_chart2 = "
SELECT insert_date,up_cnt,down_cnt,(down_cnt-up_cnt) as diff_cnt FROM
(
SELECT
insert_date,
sum(case when STATUS = '상승' OR STATUS = '신고가' then 1 ELSE 0 END) AS up_cnt,
sum(case when STATUS = '하락' OR STATUS = '신저가' then 1 ELSE 0 END) AS down_cnt
FROM molit_today_update
GROUP BY insert_date
) AS a
WHERE a.up_cnt > 100
AND a.down_cnt > 100
";

$sql_min_max2 = "
select case when max(down_cnt)>max(up_cnt) then max(down_cnt) else max(up_cnt) end as temp_max, 0 as temp_min
from
(
SELECT
insert_date,
sum(case when STATUS = '상승' OR STATUS = '신고가' then 1 ELSE 0 END) AS up_cnt,
sum(case when STATUS = '하락' OR STATUS = '신저가' then 1 ELSE 0 END) AS down_cnt
FROM molit_today_update
GROUP BY insert_date
) as a
WHERE a.up_cnt > 100
AND a.down_cnt > 100
";


$result_chart2 = mysqli_query($Conn, $sql_chart2);

while ($row_chart2 = mysqli_fetch_assoc($result_chart2)) {
    $data_array2[] = $row_chart2;
}
$chart2 = json_encode($data_array2);

$result_min_max2 = mysqli_query($Conn, $sql_min_max2);
$row_min_max2 = mysqli_fetch_assoc($result_min_max2);

?>
<h1>전국 일자별 총 상승/하락 거래건수 (단위: 건, 22년 10월 14일 이후)</h1>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart2; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '상승', '하락', '차이'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.up_cnt),
                Number(item.down_cnt),
                Number(item.diff_cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            chartArea: {left: '7%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,1: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,2: {type: 'bars', targetAxisIndex: 1, color: '#ced4da'}},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max2['temp_max']?>}, title : "상승/하락(건)"
                },
                1: {
                    viewWindow: { min: 0, max: 300}, title : "차이(건)"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div2'));
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


<center><div id="lineChart_div2" style="width: 100%; height: 400px"></div></center>






<?php


$sql_chart3 = "
SELECT
insert_date,
up_price/up_cnt AS avg_up,
down_price/down_cnt AS avg_down,
down_price/down_cnt - up_price/up_cnt AS avg_diff
FROM
(
SELECT
insert_date,
sum(case when STATUS = '상승' OR STATUS = '신고가' then cast(price as decimal(10,2)) - cast(last_price as decimal(10,2)) ELSE 0 END) AS up_price,
sum(case when STATUS = '하락' OR STATUS = '신저가' then cast(last_price as decimal(10,2)) - cast(price as decimal(10,2)) ELSE 0 END) AS down_price,
sum(case when STATUS = '상승' OR STATUS = '신고가' then 1 ELSE 0 END) AS up_cnt,
sum(case when STATUS = '하락' OR STATUS = '신저가' then 1 ELSE 0 END) AS down_cnt
FROM molit_today_update
GROUP BY insert_date
) a
WHERE a.up_cnt+a.down_cnt > 100
";




$sql_min_max3 = "
SELECT
case when max(down_price/down_cnt)>MAX(up_price/up_cnt) then max(down_price/down_cnt) else MAX(up_price/up_cnt) end as temp_max, 0 as temp_min
FROM
(
SELECT
insert_date,
sum(case when STATUS = '상승' OR STATUS = '신고가' then cast(price as decimal(10,2)) - cast(last_price as decimal(10,2)) ELSE 0 END) AS up_price,
sum(case when STATUS = '하락' OR STATUS = '신저가' then cast(last_price as decimal(10,2)) - cast(price as decimal(10,2)) ELSE 0 END) AS down_price,
sum(case when STATUS = '상승' OR STATUS = '신고가' then 1 ELSE 0 END) AS up_cnt,
sum(case when STATUS = '하락' OR STATUS = '신저가' then 1 ELSE 0 END) AS down_cnt
FROM molit_today_update
GROUP BY insert_date
) a
WHERE a.up_cnt+a.down_cnt > 100
";

$result_chart3 = mysqli_query($Conn, $sql_chart3);

while ($row_chart3 = mysqli_fetch_assoc($result_chart3)) {
    $data_array3[] = $row_chart3;
}
$chart3 = json_encode($data_array3);

$result_min_max3 = mysqli_query($Conn, $sql_min_max3);
$row_min_max3 = mysqli_fetch_assoc($result_min_max3);

?>
<h1>전국 일자별 평균 상승/하락 거래금액 (단위: 억, 22년 10월 14일 이후)</h1>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart3; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '상승', '하락', '차이'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.avg_up),
                Number(item.avg_down),
                Number(item.avg_diff)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            chartArea: {left: '7%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,1: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,2: {type: 'bars', targetAxisIndex: 1, color: '#ced4da'}},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max3['temp_max']?>}, title : "상승/하락(억)"
                },
                1: {
                    viewWindow: { min: -0.5, max: 0.5}, title : "차이(억)"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div3'));
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


<center><div id="lineChart_div3" style="width: 100%; height: 400px"></div></center>





<?php
$sql_chart0 = "
SELECT
    concat(year,'년 ',month,'월') as yyyymm,
    SUM(cnt) as cnt
    FROM molit_trend
    where type = '매매'
    group by year, month
    order by cast(year as unsigned), cast(month as unsigned)
";

$sql_min_max0 = "
select min(cnt) - 100 as temp_min, max(cnt) + 100 as temp_max
from
(
SELECT
    concat(year,'년 ',month,'월') as yyyymm,
    SUM(cnt) as cnt
    FROM molit_trend
    where type = '매매'
    group by year, month
) as a
";

$result_chart0 = mysqli_query($Conn, $sql_chart0);

while ($row_chart0 = mysqli_fetch_assoc($result_chart0)) {
    $data_array0[] = $row_chart0;
}
$chart0 = json_encode($data_array0);

$result_min_max0 = mysqli_query($Conn, $sql_min_max0);
$row_min_max0 = mysqli_fetch_assoc($result_min_max0);

?>


<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>

<h1>전국 년월별 거래건수(단위: 건, 2017년 이후)</h1>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart0; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '거래건수'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            chartArea: {left: '10%', width: '87%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 3}},
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max0['temp_min']?>, max: <?=$row_min_max0['temp_max']?>}, title : "거래건수"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div0'));
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


<center><div id="lineChart_div0" style="width: 100%; height: 400px"></div></center>





<br>
<center><span style="font-size:20px;"><b>Copyright ©2022 오늘집값 - TodayHousePrice.com, Inc. All rights reserved</b></span></center>

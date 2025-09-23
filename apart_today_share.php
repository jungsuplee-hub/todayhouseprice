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
$insert_date = date("Y-m-d");
//$insert_date = "2023-02-17";

$sql = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$sql_status = "
  SELECT
      (SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' and status is not null) AS total,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND STATUS ='신고가' and status is not null GROUP BY STATUS),0) AS upup,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND STATUS ='상승' and status is not null GROUP BY STATUS),0) AS up,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND STATUS ='동일' and status is not null GROUP BY STATUS),0) AS same,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND STATUS ='하락' and status is not null GROUP BY STATUS),0) AS down,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND STATUS ='신저가' and status is not null GROUP BY STATUS),0) AS downdown,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND STATUS ='신규' and status is not null GROUP BY STATUS),0) AS new,
      (SELECT SUM(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date = '$insert_date' and status is not null AND STATUS IN ('신고가','상승')) AS up_price,
      (SELECT SUM(ROUND((CAST(last_price as DECIMAL(10,5)) - CAST(price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date = '$insert_date' and status is not null AND STATUS IN ('신저가','하락')) AS down_price
      FROM DUAL;
";




$rs = mysqli_query($Conn, $sql);
while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

$rs_status = mysqli_query($Conn, $sql_status);
$row_status = mysqli_fetch_assoc($rs_status);
$rows_status[] = $row_status;


?>
<div class="market-indicators-wrapper">
  <div class="market-indicators">
    <a class="market-indicator" href="https://m.search.naver.com/search.naver?where=m&sm=mtb_etc&mra=blJH&qvt=0&query=%EB%8C%80%ED%95%9C%EB%AF%BC%EA%B5%AD%20%EC%A4%91%EC%95%99%EC%9D%80%ED%96%89%20%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC" target="_blank" rel="noopener noreferrer">
      <span class="market-indicator__label">기준금리 :</span>
      <span class="market-indicator__icon" aria-hidden="true">🇰🇷</span>
      <span class="market-indicator__value"><?=$row_today['gumri_korea']?></span>
    </a>
    <span class="market-indicator__divider" aria-hidden="true">|</span>
    <a class="market-indicator" href="https://m.search.naver.com/p/crd/rd?m=1&px=736&py=298&sx=736&sy=298&p=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&q=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&ie=utf8&rev=1&ssc=tab.m.all&f=m&w=m&s=LoFy%2FTw7JT27hrVNgxlLxg%3D%3D&time=1672725258737&abt=%5B%7B%22eid%22%3A%22PWL-AREA-EX%22%2C%22vid%22%3A%222%22%7D%2C%7B%22eid%22%3A%22SBR1%22%2C%22vid%22%3A%22634%22%7D%5D&a=nco_xgr*3.list&r=1&i=88211u5i_000000000000&u=https%3A%2F%2Fm.search.naver.com%2Fsearch.naver%3Fwhere%3Dm%26sm%3Dmtb_etc%26mra%3DblJH%26qvt%3D0%26query%3D%25EB%25AF%25B8%25EA%25B5%25AD%2520%25EC%25A4%2591%25EC%2595%2599%25EC%259D%2580%25ED%2596%2589%2520%25EA%25B8%25B0%25EC%25A4%2580%25EA%25B8%2588%25EB%25A6%25AC&cr=1" target="_blank" rel="noopener noreferrer">
      <span class="market-indicator__icon" aria-hidden="true">🇺🇸</span>
      <span class="market-indicator__value"><?=$row_today['gumri_usa']?></span>
    </a>
    <a class="market-indicator" href="https://m.search.naver.com/search.naver?sm=mtb_hty.top&where=m&oquery=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&tqi=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&query=%ED%99%98%EC%9C%A8" target="_blank" rel="noopener noreferrer">
      <span class="market-indicator__icon" aria-hidden="true">🔔</span>
      <span class="market-indicator__label">환율 :</span>
      <span class="market-indicator__value"><?=$row_today['dallor']?>원</span>
    </a>
    <a class="market-indicator" href="https://finance.naver.com/sise/" target="_blank" rel="noopener noreferrer">
      <span class="market-indicator__icon" aria-hidden="true">📈</span>
      <span class="market-indicator__label">코스피 :</span>
      <span class="market-indicator__value"><?=$row_today['kospi']?></span>
    </a>
  </div>
  <div class="market-indicators__update">(updated : <?=$row_today['update_date']?>)</div>
</div>
<br>

<h1><?=$insert_date?> 전국 아파트 신규 매매 리스트
<br>전국 거래 건수/금액합계</h1>
<span style="font-size:25px;"><b>총 <?php echo $row_status['total']; ?>건, 총 상승금액 : <?php if($row_status['up_price']==''){echo '0';}else{ echo $row_status['up_price'];} ?>억, 총 하락금액 : <?php if($row_status['down_price']==''){echo '0';}else{ echo $row_status['down_price'];} ?>억<br>(신고가 <?php echo $row_status['upup']; ?>건, 상승 <?php echo $row_status['up']; ?>건, 동일 <?php echo $row_status['same']; ?>건, 하락 <?php echo $row_status['down']; ?>건, 신저가 <?php echo $row_status['downdown']; ?>건, 신규 <?php echo $row_status['new']; ?>건)</b></span>
<br>
<h1>전국 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows as $row) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row['apart_name']?></span></b><br><?=$row['yearmonthday']?><br><?=$row['area_main_name']?> <?=$row['area_name']?> <?=$row['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row['size']?>㎡</b><br><?=$row['stair']?>층<br><?=$row['TYPE']?></td>
          <?php

          if ( $row['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row[price]억</b><br><br>신고가</td>";
          } elseif ( $row['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row[price]억</b><br><br>상승</td>";
          } elseif ( $row['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row[price]억</b><br><br>동일</td>";
          } elseif ( $row['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row[price]억</b><br><br>하락</td>";
          } elseif ( $row['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row['last_price']?>억</b><br><?=$row['last_price_date']?><br><br><?php if(strpos($row[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row['max_price']?>억</b><br><?=$row['max_price_date']?><br><br><?php if(strpos($row[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>


<?php
$sql_chart = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart = mysqli_query($Conn, $sql_chart);

while ($row_chart = mysqli_fetch_assoc($result_chart)) {
    $data_array[] = $row_chart;
}
$chart = json_encode($data_array);



$sql_min_max = "
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

$result_min_max = mysqli_query($Conn, $sql_min_max);
$row_min_max = mysqli_fetch_assoc($result_min_max);


?>

<span style="font-size:20px;">전국 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
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

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_all'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_all" style="width: 100%; height: 200px"></div></center>



<?php
$sql_seoul = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '서울특별시'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_seoul = mysqli_query($Conn, $sql_seoul);
while ( $row_seoul = mysqli_fetch_assoc($rs_seoul) ) {
    $rows_seoul[] = $row_seoul;
}

?>


<h1>서울특별시 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_seoul as $row_seoul) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_seoul[area_main_name]?>&apart_name=<?=$row_seoul[apart_name]?>&size=<?=$row_seoul[size]?>&dong=<?=$row_seoul[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_seoul['apart_name']?></span></b><br><?=$row_seoul['yearmonthday']?><br><?=$row_seoul['area_main_name']?> <?=$row_seoul['area_name']?> <?=$row_seoul['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_seoul['size']?>㎡</b><br><?=$row_seoul['stair']?>층<br><?=$row_seoul['TYPE']?></td>
          <?php

          if ( $row_seoul['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_seoul[price]억</b><br><br>신고가</td>";
          } elseif ( $row_seoul['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_seoul[price]억</b><br><br>상승</td>";
          } elseif ( $row_seoul['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_seoul[price]억</b><br><br>동일</td>";
          } elseif ( $row_seoul['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_seoul[price]억</b><br><br>하락</td>";
          } elseif ( $row_seoul['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_seoul[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_seoul[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_seoul['last_price']?>억</b><br><?=$row_seoul['last_price_date']?><br><br><?php if(strpos($row_seoul[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_seoul['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_seoul['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_seoul['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_seoul['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_seoul['max_price']?>억</b><br><?=$row_seoul['max_price_date']?><br><br><?php if(strpos($row_seoul[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_seoul['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_seoul['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_seoul['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_seoul['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>

<?php
$sql_chart_seoul = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '서울특별시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_seoul = mysqli_query($Conn, $sql_chart_seoul);

while ($row_chart_seoul = mysqli_fetch_assoc($result_chart_seoul)) {
    $data_array_seoul[] = $row_chart_seoul;
}
$chart_seoul = json_encode($data_array_seoul);



$sql_min_max_seoul = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '서울특별시'
GROUP BY INSERT_date
) a
";

$result_min_max_seoul = mysqli_query($Conn, $sql_min_max_seoul);
$row_min_max_seoul = mysqli_fetch_assoc($result_min_max_seoul);


?>

<span style="font-size:20px;">서울특별시 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_seoul; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_seoul['temp_min']?>, max: <?=$row_min_max_seoul['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_seoul'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_seoul" style="width: 100%; height: 200px"></div></center>







<?php
$sql_gyenggi = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '경기도'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_gyenggi = mysqli_query($Conn, $sql_gyenggi);
while ( $row_gyenggi = mysqli_fetch_assoc($rs_gyenggi) ) {
    $rows_gyenggi[] = $row_gyenggi;
}

?>


<h1>경기도 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_gyenggi as $row_gyenggi) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_gyenggi[area_main_name]?>&apart_name=<?=$row_gyenggi[apart_name]?>&size=<?=$row_gyenggi[size]?>&dong=<?=$row_gyenggi[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_gyenggi['apart_name']?></span></b><br><?=$row_gyenggi['yearmonthday']?><br><?=$row_gyenggi['area_main_name']?> <?=$row_gyenggi['area_name']?> <?=$row_gyenggi['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_gyenggi['size']?>㎡</b><br><?=$row_gyenggi['stair']?>층<br><?=$row_gyenggi['TYPE']?></td>
          <?php

          if ( $row_gyenggi['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyenggi[price]억</b><br><br>신고가</td>";
          } elseif ( $row_gyenggi['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyenggi[price]억</b><br><br>상승</td>";
          } elseif ( $row_gyenggi['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyenggi[price]억</b><br><br>동일</td>";
          } elseif ( $row_gyenggi['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyenggi[price]억</b><br><br>하락</td>";
          } elseif ( $row_gyenggi['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyenggi[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_gyenggi[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_gyenggi['last_price']?>억</b><br><?=$row_gyenggi['last_price_date']?><br><br><?php if(strpos($row_gyenggi[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_gyenggi['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gyenggi['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_gyenggi['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gyenggi['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_gyenggi['max_price']?>억</b><br><?=$row_gyenggi['max_price_date']?><br><br><?php if(strpos($row_gyenggi[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_gyenggi['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gyenggi['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_gyenggi['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gyenggi['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>


<?php
$sql_chart_gyunggi = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '경기도'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_gyunggi = mysqli_query($Conn, $sql_chart_gyunggi);

while ($row_chart_gyunggi = mysqli_fetch_assoc($result_chart_gyunggi)) {
    $data_array_gyunggi[] = $row_chart_gyunggi;
}
$chart_gyunggi = json_encode($data_array_gyunggi);



$sql_min_max_gyunggi = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '경기도'
GROUP BY INSERT_date
) a
";

$result_min_max_gyunggi = mysqli_query($Conn, $sql_min_max_gyunggi);
$row_min_max_gyunggi = mysqli_fetch_assoc($result_min_max_gyunggi);


?>

<span style="font-size:20px;">경기도 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_gyunggi; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_gyunggi['temp_min']?>, max: <?=$row_min_max_gyunggi['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_gyunggi'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_gyunggi" style="width: 100%; height: 200px"></div></center>





<?php
$sql_busan = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '부산광역시'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_busan = mysqli_query($Conn, $sql_busan);
while ( $row_busan = mysqli_fetch_assoc($rs_busan) ) {
    $rows_busan[] = $row_busan;
}

?>


<h1>부산광역시 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_busan as $row_busan) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_busan[area_main_name]?>&apart_name=<?=$row_busan[apart_name]?>&size=<?=$row_busan[size]?>&dong=<?=$row_busan[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_busan['apart_name']?></span></b><br><?=$row_busan['yearmonthday']?><br><?=$row_busan['area_main_name']?> <?=$row_busan['area_name']?> <?=$row_busan['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_busan['size']?>㎡</b><br><?=$row_busan['stair']?>층<br><?=$row_busan['TYPE']?></td>
          <?php

          if ( $row_busan['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_busan[price]억</b><br><br>신고가</td>";
          } elseif ( $row_busan['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_busan[price]억</b><br><br>상승</td>";
          } elseif ( $row_busan['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_busan[price]억</b><br><br>동일</td>";
          } elseif ( $row_busan['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_busan[price]억</b><br><br>하락</td>";
          } elseif ( $row_busan['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_busan[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_busan[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_busan['last_price']?>억</b><br><?=$row_busan['last_price_date']?><br><br><?php if(strpos($row_busan[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_busan['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_busan['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_busan['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_busan['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_busan['max_price']?>억</b><br><?=$row_busan['max_price_date']?><br><br><?php if(strpos($row_busan[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_busan['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_busan['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_busan['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_busan['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>




<?php
$sql_chart_busan = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '부산광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_busan = mysqli_query($Conn, $sql_chart_busan);

while ($row_chart_busan = mysqli_fetch_assoc($result_chart_busan)) {
    $data_array_busan[] = $row_chart_busan;
}
$chart_busan = json_encode($data_array_busan);



$sql_min_max_busan = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '부산광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_busan = mysqli_query($Conn, $sql_min_max_busan);
$row_min_max_busan = mysqli_fetch_assoc($result_min_max_busan);


?>

<span style="font-size:20px;">부산광역시 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_busan; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_busan['temp_min']?>, max: <?=$row_min_max_busan['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_busan'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_busan" style="width: 100%; height: 200px"></div></center>




<?php
$sql_daegu = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '대구광역시'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_daegu = mysqli_query($Conn, $sql_daegu);
while ( $row_daegu = mysqli_fetch_assoc($rs_daegu) ) {
    $rows_daegu[] = $row_daegu;
}

?>


<h1>대구광역시 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_daegu as $row_daegu) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_daegu[area_main_name]?>&apart_name=<?=$row_daegu[apart_name]?>&size=<?=$row_daegu[size]?>&dong=<?=$row_daegu[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_daegu['apart_name']?></span></b><br><?=$row_daegu['yearmonthday']?><br><?=$row_daegu['area_main_name']?> <?=$row_daegu['area_name']?> <?=$row_daegu['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_daegu['size']?>㎡</b><br><?=$row_daegu['stair']?>층<br><?=$row_daegu['TYPE']?></td>
          <?php

          if ( $row_daegu['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daegu[price]억</b><br><br>신고가</td>";
          } elseif ( $row_daegu['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daegu[price]억</b><br><br>상승</td>";
          } elseif ( $row_daegu['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daegu[price]억</b><br><br>동일</td>";
          } elseif ( $row_daegu['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daegu[price]억</b><br><br>하락</td>";
          } elseif ( $row_daegu['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daegu[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_daegu[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_daegu['last_price']?>억</b><br><?=$row_daegu['last_price_date']?><br><br><?php if(strpos($row_daegu[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_daegu['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_daegu['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_daegu['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_daegu['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_daegu['max_price']?>억</b><br><?=$row_daegu['max_price_date']?><br><br><?php if(strpos($row_daegu[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_daegu['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_daegu['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_daegu['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_daegu['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>




<?php
$sql_chart_daegu = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '대구광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_daegu = mysqli_query($Conn, $sql_chart_daegu);

while ($row_chart_daegu = mysqli_fetch_assoc($result_chart_daegu)) {
    $data_array_daegu[] = $row_chart_daegu;
}
$chart_daegu = json_encode($data_array_daegu);



$sql_min_max_daegu = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '대구광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_daegu = mysqli_query($Conn, $sql_min_max_daegu);
$row_min_max_daegu = mysqli_fetch_assoc($result_min_max_daegu);


?>

<span style="font-size:20px;">대구광역시 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_daegu; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_daegu['temp_min']?>, max: <?=$row_min_max_daegu['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_daegu'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_daegu" style="width: 100%; height: 200px"></div></center>




<?php
$sql_incheon = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '인천광역시'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_incheon = mysqli_query($Conn, $sql_incheon);
while ( $row_incheon = mysqli_fetch_assoc($rs_incheon) ) {
    $rows_incheon[] = $row_incheon;
}

?>


<h1>인천광역시 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_incheon as $row_incheon) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_incheon[area_main_name]?>&apart_name=<?=$row_incheon[apart_name]?>&size=<?=$row_incheon[size]?>&dong=<?=$row_incheon[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_incheon['apart_name']?></span></b><br><?=$row_incheon['yearmonthday']?><br><?=$row_incheon['area_main_name']?> <?=$row_incheon['area_name']?> <?=$row_incheon['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_incheon['size']?>㎡</b><br><?=$row_incheon['stair']?>층<br><?=$row_incheon['TYPE']?></td>
          <?php

          if ( $row_incheon['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_incheon[price]억</b><br><br>신고가</td>";
          } elseif ( $row_incheon['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_incheon[price]억</b><br><br>상승</td>";
          } elseif ( $row_incheon['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_incheon[price]억</b><br><br>동일</td>";
          } elseif ( $row_incheon['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_incheon[price]억</b><br><br>하락</td>";
          } elseif ( $row_incheon['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_incheon[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_incheon[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_incheon['last_price']?>억</b><br><?=$row_incheon['last_price_date']?><br><br><?php if(strpos($row_incheon[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_incheon['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_incheon['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_incheon['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_incheon['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_incheon['max_price']?>억</b><br><?=$row_incheon['max_price_date']?><br><br><?php if(strpos($row_incheon[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_incheon['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_incheon['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_incheon['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_incheon['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>




<?php
$sql_chart_incheon = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '인천광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_incheon = mysqli_query($Conn, $sql_chart_incheon);

while ($row_chart_incheon = mysqli_fetch_assoc($result_chart_incheon)) {
    $data_array_incheon[] = $row_chart_incheon;
}
$chart_incheon = json_encode($data_array_incheon);



$sql_min_max_incheon = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '인천광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_incheon = mysqli_query($Conn, $sql_min_max_incheon);
$row_min_max_incheon = mysqli_fetch_assoc($result_min_max_incheon);


?>

<span style="font-size:20px;">인천광역시 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_incheon; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_incheon['temp_min']?>, max: <?=$row_min_max_incheon['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_incheon'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_incheon" style="width: 100%; height: 200px"></div></center>




<?php
$sql_gwangju = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '광주광역시'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_gwangju = mysqli_query($Conn, $sql_gwangju);
while ( $row_gwangju = mysqli_fetch_assoc($rs_gwangju) ) {
    $rows_gwangju[] = $row_gwangju;
}

?>


<h1>광주광역시 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_gwangju as $row_gwangju) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_gwangju[area_main_name]?>&apart_name=<?=$row_gwangju[apart_name]?>&size=<?=$row_gwangju[size]?>&dong=<?=$row_gwangju[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_gwangju['apart_name']?></span></b><br><?=$row_gwangju['yearmonthday']?><br><?=$row_gwangju['area_main_name']?> <?=$row_gwangju['area_name']?> <?=$row_gwangju['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_gwangju['size']?>㎡</b><br><?=$row_gwangju['stair']?>층<br><?=$row_gwangju['TYPE']?></td>
          <?php

          if ( $row_gwangju['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gwangju[price]억</b><br><br>신고가</td>";
          } elseif ( $row_gwangju['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gwangju[price]억</b><br><br>상승</td>";
          } elseif ( $row_gwangju['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gwangju[price]억</b><br><br>동일</td>";
          } elseif ( $row_gwangju['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gwangju[price]억</b><br><br>하락</td>";
          } elseif ( $row_gwangju['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gwangju[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_gwangju[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_gwangju['last_price']?>억</b><br><?=$row_gwangju['last_price_date']?><br><br><?php if(strpos($row_gwangju[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_gwangju['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gwangju['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_gwangju['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gwangju['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_gwangju['max_price']?>억</b><br><?=$row_gwangju['max_price_date']?><br><br><?php if(strpos($row_gwangju[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_gwangju['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gwangju['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_gwangju['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gwangju['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>





<?php
$sql_chart_gwangju = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '광주광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_gwangju = mysqli_query($Conn, $sql_chart_gwangju);

while ($row_chart_gwangju = mysqli_fetch_assoc($result_chart_gwangju)) {
    $data_array_gwangju[] = $row_chart_gwangju;
}
$chart_gwangju = json_encode($data_array_gwangju);



$sql_min_max_gwangju = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '광주광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_gwangju = mysqli_query($Conn, $sql_min_max_gwangju);
$row_min_max_gwangju = mysqli_fetch_assoc($result_min_max_gwangju);


?>

<span style="font-size:20px;">광주광역시 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_gwangju; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_gwangju['temp_min']?>, max: <?=$row_min_max_gwangju['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_gwangju'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_gwangju" style="width: 100%; height: 200px"></div></center>





<?php
$sql_daejun = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '대전광역시'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_daejun = mysqli_query($Conn, $sql_daejun);
while ( $row_daejun = mysqli_fetch_assoc($rs_daejun) ) {
    $rows_daejun[] = $row_daejun;
}

?>


<h1>대전광역시 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_daejun as $row_daejun) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_daejun[area_main_name]?>&apart_name=<?=$row_daejun[apart_name]?>&size=<?=$row_daejun[size]?>&dong=<?=$row_daejun[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_daejun['apart_name']?></span></b><br><?=$row_daejun['yearmonthday']?><br><?=$row_daejun['area_main_name']?> <?=$row_daejun['area_name']?> <?=$row_daejun['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_daejun['size']?>㎡</b><br><?=$row_daejun['stair']?>층<br><?=$row_daejun['TYPE']?></td>
          <?php

          if ( $row_daejun['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daejun[price]억</b><br><br>신고가</td>";
          } elseif ( $row_daejun['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daejun[price]억</b><br><br>상승</td>";
          } elseif ( $row_daejun['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daejun[price]억</b><br><br>동일</td>";
          } elseif ( $row_daejun['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daejun[price]억</b><br><br>하락</td>";
          } elseif ( $row_daejun['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_daejun[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_daejun[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_daejun['last_price']?>억</b><br><?=$row_daejun['last_price_date']?><br><br><?php if(strpos($row_daejun[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_daejun['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_daejun['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_daejun['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_daejun['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_daejun['max_price']?>억</b><br><?=$row_daejun['max_price_date']?><br><br><?php if(strpos($row_daejun[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_daejun['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_daejun['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_daejun['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_daejun['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>





<?php
$sql_chart_daejun = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '대전광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_daejun = mysqli_query($Conn, $sql_chart_daejun);

while ($row_chart_daejun = mysqli_fetch_assoc($result_chart_daejun)) {
    $data_array_daejun[] = $row_chart_daejun;
}
$chart_daejun = json_encode($data_array_daejun);



$sql_min_max_daejun = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '대전광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_daejun = mysqli_query($Conn, $sql_min_max_daejun);
$row_min_max_daejun = mysqli_fetch_assoc($result_min_max_daejun);


?>

<span style="font-size:20px;">대전광역시 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_daejun; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_daejun['temp_min']?>, max: <?=$row_min_max_daejun['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_daejun'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_daejun" style="width: 100%; height: 200px"></div></center>





<?php
$sql_ulsan = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '울산광역시'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_ulsan = mysqli_query($Conn, $sql_ulsan);
while ( $row_ulsan = mysqli_fetch_assoc($rs_ulsan) ) {
    $rows_ulsan[] = $row_ulsan;
}

?>


<h1>울산광역시 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_ulsan as $row_ulsan) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_ulsan[area_main_name]?>&apart_name=<?=$row_ulsan[apart_name]?>&size=<?=$row_ulsan[size]?>&dong=<?=$row_ulsan[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_ulsan['apart_name']?></span></b><br><?=$row_ulsan['yearmonthday']?><br><?=$row_ulsan['area_main_name']?> <?=$row_ulsan['area_name']?> <?=$row_ulsan['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_ulsan['size']?>㎡</b><br><?=$row_ulsan['stair']?>층<br><?=$row_ulsan['TYPE']?></td>
          <?php

          if ( $row_ulsan['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_ulsan[price]억</b><br><br>신고가</td>";
          } elseif ( $row_ulsan['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_ulsan[price]억</b><br><br>상승</td>";
          } elseif ( $row_ulsan['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_ulsan[price]억</b><br><br>동일</td>";
          } elseif ( $row_ulsan['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_ulsan[price]억</b><br><br>하락</td>";
          } elseif ( $row_ulsan['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_ulsan[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_ulsan[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_ulsan['last_price']?>억</b><br><?=$row_ulsan['last_price_date']?><br><br><?php if(strpos($row_ulsan[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_ulsan['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_ulsan['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_ulsan['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_ulsan['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_ulsan['max_price']?>억</b><br><?=$row_ulsan['max_price_date']?><br><br><?php if(strpos($row_ulsan[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_ulsan['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_ulsan['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_ulsan['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_ulsan['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>





<?php
$sql_chart_ulsan = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '울산광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_ulsan = mysqli_query($Conn, $sql_chart_ulsan);

while ($row_chart_ulsan = mysqli_fetch_assoc($result_chart_ulsan)) {
    $data_array_ulsan[] = $row_chart_ulsan;
}
$chart_ulsan = json_encode($data_array_ulsan);



$sql_min_max_ulsan = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '울산광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_ulsan = mysqli_query($Conn, $sql_min_max_ulsan);
$row_min_max_ulsan = mysqli_fetch_assoc($result_min_max_ulsan);


?>

<span style="font-size:20px;">울산광역시 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_ulsan; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_ulsan['temp_min']?>, max: <?=$row_min_max_ulsan['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_ulsan'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_ulsan" style="width: 100%; height: 200px"></div></center>





<?php
$sql_sejong = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '세종특별자치시'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_sejong = mysqli_query($Conn, $sql_sejong);
while ( $row_sejong = mysqli_fetch_assoc($rs_sejong) ) {
    $rows_sejong[] = $row_sejong;
}

?>


<h1>세종특별자치시 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_sejong as $row_sejong) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_sejong[area_main_name]?>&apart_name=<?=$row_sejong[apart_name]?>&size=<?=$row_sejong[size]?>&dong=<?=$row_sejong[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_sejong['apart_name']?></span></b><br><?=$row_sejong['yearmonthday']?><br><?=$row_sejong['area_main_name']?> <?=$row_sejong['area_name']?> <?=$row_sejong['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_sejong['size']?>㎡</b><br><?=$row_sejong['stair']?>층<br><?=$row_sejong['TYPE']?></td>
          <?php

          if ( $row_sejong['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_sejong[price]억</b><br><br>신고가</td>";
          } elseif ( $row_sejong['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_sejong[price]억</b><br><br>상승</td>";
          } elseif ( $row_sejong['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_sejong[price]억</b><br><br>동일</td>";
          } elseif ( $row_sejong['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_sejong[price]억</b><br><br>하락</td>";
          } elseif ( $row_sejong['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_sejong[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_sejong[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_sejong['last_price']?>억</b><br><?=$row_sejong['last_price_date']?><br><br><?php if(strpos($row_sejong[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_sejong['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_sejong['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_sejong['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_sejong['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_sejong['max_price']?>억</b><br><?=$row_sejong['max_price_date']?><br><br><?php if(strpos($row_sejong[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_sejong['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_sejong['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_sejong['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_sejong['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>




<?php
$sql_chart_sejong = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '세종특별자치시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_sejong = mysqli_query($Conn, $sql_chart_sejong);

while ($row_chart_sejong = mysqli_fetch_assoc($result_chart_sejong)) {
    $data_array_sejong[] = $row_chart_sejong;
}
$chart_sejong = json_encode($data_array_sejong);



$sql_min_max_sejong = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '세종특별자치시'
GROUP BY INSERT_date
) a
";

$result_min_max_sejong = mysqli_query($Conn, $sql_min_max_sejong);
$row_min_max_sejong = mysqli_fetch_assoc($result_min_max_sejong);


?>

<span style="font-size:20px;">세종특별자치시 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_sejong; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_sejong['temp_min']?>, max: <?=$row_min_max_sejong['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_sejong'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_sejong" style="width: 100%; height: 200px"></div></center>






<?php
$sql_gangwon = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '강원도'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_gangwon = mysqli_query($Conn, $sql_gangwon);
while ( $row_gangwon = mysqli_fetch_assoc($rs_gangwon) ) {
    $rows_gangwon[] = $row_gangwon;
}

?>


<h1>강원도 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_gangwon as $row_gangwon) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_gangwon[area_main_name]?>&apart_name=<?=$row_gangwon[apart_name]?>&size=<?=$row_gangwon[size]?>&dong=<?=$row_gangwon[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_gangwon['apart_name']?></span></b><br><?=$row_gangwon['yearmonthday']?><br><?=$row_gangwon['area_main_name']?> <?=$row_gangwon['area_name']?> <?=$row_gangwon['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_gangwon['size']?>㎡</b><br><?=$row_gangwon['stair']?>층<br><?=$row_gangwon['TYPE']?></td>
          <?php

          if ( $row_gangwon['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gangwon[price]억</b><br><br>신고가</td>";
          } elseif ( $row_gangwon['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gangwon[price]억</b><br><br>상승</td>";
          } elseif ( $row_gangwon['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gangwon[price]억</b><br><br>동일</td>";
          } elseif ( $row_gangwon['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gangwon[price]억</b><br><br>하락</td>";
          } elseif ( $row_gangwon['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gangwon[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_gangwon[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_gangwon['last_price']?>억</b><br><?=$row_gangwon['last_price_date']?><br><br><?php if(strpos($row_gangwon[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_gangwon['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gangwon['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_gangwon['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gangwon['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_gangwon['max_price']?>억</b><br><?=$row_gangwon['max_price_date']?><br><br><?php if(strpos($row_gangwon[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_gangwon['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gangwon['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_gangwon['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gangwon['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>



<?php
$sql_chart_gangwon = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '강원도'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_gangwon = mysqli_query($Conn, $sql_chart_gangwon);

while ($row_chart_gangwon = mysqli_fetch_assoc($result_chart_gangwon)) {
    $data_array_gangwon[] = $row_chart_gangwon;
}
$chart_gangwon = json_encode($data_array_gangwon);



$sql_min_max_gangwon = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '강원도'
GROUP BY INSERT_date
) a
";

$result_min_max_gangwon = mysqli_query($Conn, $sql_min_max_gangwon);
$row_min_max_gangwon = mysqli_fetch_assoc($result_min_max_gangwon);


?>

<span style="font-size:20px;">강원도 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_gangwon; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_gangwon['temp_min']?>, max: <?=$row_min_max_gangwon['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_gangwon'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_gangwon" style="width: 100%; height: 200px"></div></center>




<?php
$sql_chungcheong = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name in ('충청북도','충청남도')
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_chungcheong = mysqli_query($Conn, $sql_chungcheong);
while ( $row_chungcheong = mysqli_fetch_assoc($rs_chungcheong) ) {
    $rows_chungcheong[] = $row_chungcheong;
}

?>


<h1>충청도 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_chungcheong as $row_chungcheong) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_chungcheong[area_main_name]?>&apart_name=<?=$row_chungcheong[apart_name]?>&size=<?=$row_chungcheong[size]?>&dong=<?=$row_chungcheong[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_chungcheong['apart_name']?></span></b><br><?=$row_chungcheong['yearmonthday']?><br><?=$row_chungcheong['area_main_name']?> <?=$row_chungcheong['area_name']?> <?=$row_chungcheong['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_chungcheong['size']?>㎡</b><br><?=$row_chungcheong['stair']?>층<br><?=$row_chungcheong['TYPE']?></td>
          <?php

          if ( $row_chungcheong['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_chungcheong[price]억</b><br><br>신고가</td>";
          } elseif ( $row_chungcheong['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_chungcheong[price]억</b><br><br>상승</td>";
          } elseif ( $row_chungcheong['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_chungcheong[price]억</b><br><br>동일</td>";
          } elseif ( $row_chungcheong['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_chungcheong[price]억</b><br><br>하락</td>";
          } elseif ( $row_chungcheong['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_chungcheong[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_chungcheong[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_chungcheong['last_price']?>억</b><br><?=$row_chungcheong['last_price_date']?><br><br><?php if(strpos($row_chungcheong[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_chungcheong['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_chungcheong['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_chungcheong['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_chungcheong['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_chungcheong['max_price']?>억</b><br><?=$row_chungcheong['max_price_date']?><br><br><?php if(strpos($row_chungcheong[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_chungcheong['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_chungcheong['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_chungcheong['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_chungcheong['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>




<?php
$sql_chart_chungcheong = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name in ('충청북도','충청남도')
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_chungcheong = mysqli_query($Conn, $sql_chart_chungcheong);

while ($row_chart_chungcheong = mysqli_fetch_assoc($result_chart_chungcheong)) {
    $data_array_chungcheong[] = $row_chart_chungcheong;
}
$chart_chungcheong = json_encode($data_array_chungcheong);



$sql_min_max_chungcheong = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name in ('충청북도','충청남도')
GROUP BY INSERT_date
) a
";

$result_min_max_chungcheong = mysqli_query($Conn, $sql_min_max_chungcheong);
$row_min_max_chungcheong = mysqli_fetch_assoc($result_min_max_chungcheong);


?>

<span style="font-size:20px;">충청도 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_chungcheong; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_chungcheong['temp_min']?>, max: <?=$row_min_max_chungcheong['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_chungcheong'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_chungcheong" style="width: 100%; height: 200px"></div></center>






<?php
$sql_junla = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name in ('전라북도','전라남도')
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_junla = mysqli_query($Conn, $sql_junla);
while ( $row_junla = mysqli_fetch_assoc($rs_junla) ) {
    $rows_junla[] = $row_junla;
}

?>


<h1>전라도 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_junla as $row_junla) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_junla[area_main_name]?>&apart_name=<?=$row_junla[apart_name]?>&size=<?=$row_junla[size]?>&dong=<?=$row_junla[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_junla['apart_name']?></span></b><br><?=$row_junla['yearmonthday']?><br><?=$row_junla['area_main_name']?> <?=$row_junla['area_name']?> <?=$row_junla['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_junla['size']?>㎡</b><br><?=$row_junla['stair']?>층<br><?=$row_junla['TYPE']?></td>
          <?php

          if ( $row_junla['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_junla[price]억</b><br><br>신고가</td>";
          } elseif ( $row_junla['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_junla[price]억</b><br><br>상승</td>";
          } elseif ( $row_junla['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_junla[price]억</b><br><br>동일</td>";
          } elseif ( $row_junla['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_junla[price]억</b><br><br>하락</td>";
          } elseif ( $row_junla['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_junla[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_junla[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_junla['last_price']?>억</b><br><?=$row_junla['last_price_date']?><br><br><?php if(strpos($row_junla[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_junla['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_junla['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_junla['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_junla['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_junla['max_price']?>억</b><br><?=$row_junla['max_price_date']?><br><br><?php if(strpos($row_junla[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_junla['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_junla['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_junla['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_junla['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>




<?php
$sql_chart_junla = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name in ('전라북도','전라남도')
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_junla = mysqli_query($Conn, $sql_chart_junla);

while ($row_chart_junla = mysqli_fetch_assoc($result_chart_junla)) {
    $data_array_junla[] = $row_chart_junla;
}
$chart_junla = json_encode($data_array_junla);



$sql_min_max_junla = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name in ('전라북도','전라남도')
GROUP BY INSERT_date
) a
";

$result_min_max_junla = mysqli_query($Conn, $sql_min_max_junla);
$row_min_max_junla = mysqli_fetch_assoc($result_min_max_junla);


?>

<span style="font-size:20px;">전라도 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_junla; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_junla['temp_min']?>, max: <?=$row_min_max_junla['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_junla'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_junla" style="width: 100%; height: 200px"></div></center>





<?php
$sql_gyengsang = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name in ('경상북도','경상남도')
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_gyengsang = mysqli_query($Conn, $sql_gyengsang);
while ( $row_gyengsang = mysqli_fetch_assoc($rs_gyengsang) ) {
    $rows_gyengsang[] = $row_gyengsang;
}

?>


<h1>경상도 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_gyengsang as $row_gyengsang) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_gyengsang[area_main_name]?>&apart_name=<?=$row_gyengsang[apart_name]?>&size=<?=$row_gyengsang[size]?>&dong=<?=$row_gyengsang[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_gyengsang['apart_name']?></span></b><br><?=$row_gyengsang['yearmonthday']?><br><?=$row_gyengsang['area_main_name']?> <?=$row_gyengsang['area_name']?> <?=$row_gyengsang['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_gyengsang['size']?>㎡</b><br><?=$row_gyengsang['stair']?>층<br><?=$row_gyengsang['TYPE']?></td>
          <?php

          if ( $row_gyengsang['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyengsang[price]억</b><br><br>신고가</td>";
          } elseif ( $row_gyengsang['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyengsang[price]억</b><br><br>상승</td>";
          } elseif ( $row_gyengsang['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyengsang[price]억</b><br><br>동일</td>";
          } elseif ( $row_gyengsang['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyengsang[price]억</b><br><br>하락</td>";
          } elseif ( $row_gyengsang['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_gyengsang[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_gyengsang[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_gyengsang['last_price']?>억</b><br><?=$row_gyengsang['last_price_date']?><br><br><?php if(strpos($row_gyengsang[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_gyengsang['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gyengsang['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_gyengsang['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gyengsang['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_gyengsang['max_price']?>억</b><br><?=$row_gyengsang['max_price_date']?><br><br><?php if(strpos($row_gyengsang[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_gyengsang['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gyengsang['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_gyengsang['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_gyengsang['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>



<?php
$sql_chart_gyengsang = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name in ('경상북도','경상남도')
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_gyengsang = mysqli_query($Conn, $sql_chart_gyengsang);

while ($row_chart_gyengsang = mysqli_fetch_assoc($result_chart_gyengsang)) {
    $data_array_gyengsang[] = $row_chart_gyengsang;
}
$chart_gyengsang = json_encode($data_array_gyengsang);



$sql_min_max_gyengsang = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name in ('경상북도','경상남도')
GROUP BY INSERT_date
) a
";

$result_min_max_gyengsang = mysqli_query($Conn, $sql_min_max_gyengsang);
$row_min_max_gyengsang = mysqli_fetch_assoc($result_min_max_gyengsang);


?>

<span style="font-size:20px;">경상도 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_gyengsang; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_gyengsang['temp_min']?>, max: <?=$row_min_max_gyengsang['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_gyengsang'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_gyengsang" style="width: 100%; height: 200px"></div></center>





<?php
$sql_jeju = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
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
      where today.insert_date = '$insert_date'
      and today.area_main_name = '제주특별자치도'
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$rs_jeju = mysqli_query($Conn, $sql_jeju);
while ( $row_jeju = mysqli_fetch_assoc($rs_jeju) ) {
    $rows_jeju[] = $row_jeju;
}

?>


<h1>제주특별자치도 상승/하락 금액 TOP 10</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%; padding: .5em .5em;"><b>순위</b></th>
        <th style="font-size: 20px; width:35%; padding: .5em .5em;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:13%; padding: .5em .5em;"><b>신규가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최근가격</b></th>
        <th style="font-size: 20px; width:17%; padding: .5em .5em;"><b>최고가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_jeju as $row_jeju) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 30px; padding: .5em .5em; width:5%;"><b><?=$rowcount?></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:35%;"><a style="text-decoration: none;" href='./apart.php?area_main_name=<?=$row_jeju[area_main_name]?>&apart_name=<?=$row_jeju[apart_name]?>&size=<?=$row_jeju[size]?>&dong=<?=$row_jeju[doing]?>&all_area=N'><b><span style="font-size: 25px;"><?=$row_jeju['apart_name']?></span></b><br><?=$row_jeju['yearmonthday']?><br><?=$row_jeju['area_main_name']?> <?=$row_jeju['area_name']?> <?=$row_jeju['doing']?></b><br><b></b></td>
          <td style="font-size: 20px; padding: .5em .5em; width:13%;"><b><?=$row_jeju['size']?>㎡</b><br><?=$row_jeju['stair']?>층<br><?=$row_jeju['TYPE']?></td>
          <?php

          if ( $row_jeju['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_jeju[price]억</b><br><br>신고가</td>";
          } elseif ( $row_jeju['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_jeju[price]억</b><br><br>상승</td>";
          } elseif ( $row_jeju['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_jeju[price]억</b><br><br>동일</td>";
          } elseif ( $row_jeju['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_jeju[price]억</b><br><br>하락</td>";
          } elseif ( $row_jeju['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; padding: .5em .5em; width:13%;'><b>$row_jeju[price]억</b><br><br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%; padding: .5em .5em; width:13%;'><b>$row_jeju[price]억</b><br><br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:17%;"><b><?=$row_jeju['last_price']?>억</b><br><?=$row_jeju['last_price_date']?><br><br><?php if(strpos($row_jeju[price_last], '-') !== false) { echo "<span style='color:red;'>최근대비<br><b>"; echo abs($row_jeju['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_jeju['percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최근대비<br><b>"; echo abs($row_jeju['price_last']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_jeju['percent']); echo "%상승</span>"; } ?></td>
          <td style="font-size: 20px; width:17%;"><b><?=$row_jeju['max_price']?>억</b><br><?=$row_jeju['max_price_date']?><br><br><?php if(strpos($row_jeju[price_max], '-') !== false) { echo "<span style='color:red;'>최고대비<br><b>"; echo abs($row_jeju['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_jeju['max_percent']); echo "%하락</span>";} else{ echo "<span style='color:green;'>최고대비<br><b>"; echo abs($row_jeju['price_max']); echo "억</b>"; if($isMobile == "Y") { echo "<br>"; }else{echo ", ";} echo abs($row_jeju['max_percent']); echo "%상승</span>"; } ?></td>

      </tr>
      <?php } ?>
    </tbody>
</table>





<?php
$sql_chart_jeju = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '제주특별자치도'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_jeju = mysqli_query($Conn, $sql_chart_jeju);

while ($row_chart_jeju = mysqli_fetch_assoc($result_chart_jeju)) {
    $data_array_jeju[] = $row_chart_jeju;
}
$chart_jeju = json_encode($data_array_jeju);



$sql_min_max_jeju = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '제주특별자치도'
GROUP BY INSERT_date
) a
";

$result_min_max_jeju = mysqli_query($Conn, $sql_min_max_jeju);
$row_min_max_jeju = mysqli_fetch_assoc($result_min_max_jeju);


?>

<span style="font-size:20px;">제주특별자치도 국평(85㎡) 평균가격 그래프 (참고. 3월 9일 대상아파트 수가 증가하여 데이터가 변동됨)</span>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_jeju; ?>;
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
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                showTextEvery: 10    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_jeju['temp_min']?>, max: <?=$row_min_max_jeju['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_jeju'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<center><div id="lineChart_div_jeju" style="width: 100%; height: 200px"></div></center>







<?php
$sql_chart10 = "
SELECT insert_date,up_price,down_price,(down_price-up_price) as diff_price FROM
(
SELECT 
insert_date,
sum(case when STATUS = '상승' OR STATUS = '신고가' then cast(price as decimal(10,2)) - cast(last_price as decimal(10,2)) ELSE 0 END) AS up_price,
sum(case when STATUS = '하락' OR STATUS = '신저가' then cast(last_price as decimal(10,2)) - cast(price as decimal(10,2)) ELSE 0 END) AS down_price
FROM molit_today_update
GROUP BY insert_date
) AS a
WHERE a.up_price + a.down_price > 100
";

$sql_min_max10 = "
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
WHERE a.up_price + a.down_price > 100
";

$result_chart10 = mysqli_query($Conn, $sql_chart10);

while ($row_chart10 = mysqli_fetch_assoc($result_chart10)) {
    $data_array10[] = $row_chart10;
}
$chart10 = json_encode($data_array10);

$result_min_max10 = mysqli_query($Conn, $sql_min_max10);
$row_min_max10 = mysqli_fetch_assoc($result_min_max10);

?>


<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>
<h2>아래 그래프는 "오늘집값" 누적 데이터로 만들어진 그래프 입니다.</h2>
<h1>전국 일자별 총 상승/하락 금액 (단위: 억원, 22년 10월 14일 이후)</h1>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart10; ?>;

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
                    viewWindow: { min: 0, max: <?=$row_min_max10['temp_max']?>}, title : "상승/하락(억)"
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

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div10'));
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


<center><div id="lineChart_div10" style="width: 100%; height: 400px"></div></center>





<!--
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

-->




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
                showTextEvery: 15    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
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
//여기는 그래프 관련
$sql_chart0 = "
    SELECT
    concat(year,'년 ',month,'월') as yearmonth
    ,sum(cnt)  AS cnt
    FROM molit_trend
    where type = '매매'
    group by year, month
    order by cast(year as unsigned), cast(month as unsigned)
    ";


$sql_min_max0 = "
    select max(cnt)+100 as temp_max, min(cnt)-100 as temp_min
    from
    (
    SELECT year, month, sum(cnt) as cnt
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
        var header = ['Date&Time(MM-DD HH:MM)','전국 거래량'];
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
            chartArea: {left: '10%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 15    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max0['temp_max']?>}
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



<center><div id="lineChart_div0" style="width: 100%; height: 300px"></div></center>




<?php
//여기는 그래프 관련
$sql_chart01 = "
    SELECT
    concat(year,'년 ',month,'월') as yearmonth
    ,sum(cnt)  AS cnt
    FROM molit_trend
    where type = '매매'
    and area_main_name = '서울특별시'
    group by year, month
    order by cast(year as unsigned), cast(month as unsigned)
    ";


$sql_min_max01 = "
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



$result_chart01 = mysqli_query($Conn, $sql_chart01);

while ($row_chart01 = mysqli_fetch_assoc($result_chart01)) {
    $data_array01[] = $row_chart01;
}
$chart01 = json_encode($data_array01);

$result_min_max01 = mysqli_query($Conn, $sql_min_max01);
$row_min_max01 = mysqli_fetch_assoc($result_min_max01);

?>


<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>

<h1>서울특별시 년월별 거래건수(단위: 건, 2017년 이후)</h1>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart01; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','서울특별시 거래량'];
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
                    viewWindow: { min: 0, max: <?=$row_min_max01['temp_max']?>}
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div01'));
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



<center><div id="lineChart_div01" style="width: 100%; height: 400px"></div></center>

<br>
<center><span style="font-size:20px;"><b>Copyright ©2022 오늘집값 - TodayHousePrice.com, Inc. All rights reserved</b></span></center>

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
      limit 100;
      ";

$rs_busan = mysqli_query($Conn, $sql_busan);
while ( $row_busan = mysqli_fetch_assoc($rs_busan) ) {
    $rows_busan[] = $row_busan;
}

?>


<h1>부산광역시 상승/하락 금액 TOP 100</h1>
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


<center><div id="lineChart_div_busan" style="width: 100%; height: 300px"></div></center>



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
    and area_main_name = '부산광역시'
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
        and area_main_name = '부산광역시'
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

<h1>부산광역시 년월별 거래건수(단위: 건, 2017년 이후)</h1>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart01; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','부산광역시 거래량'];
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

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
<title>오늘집값 - 아파트 평균가격</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="아파트 매매 상세검색">
<meta property="og:description" content="아파트 매매  정보를 상세히 검색 할 수 있습니다.">
<meta property="og:image" content="./todayhouseprice2.png">
<meta property="og:url" content="http://todayhouseprice.com/apart.php">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
     crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="./todayhouseprice.css">
</head>


<?php
$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
$today = date("Y-m-d");
include_once "./config.php";
//session_start();
//$userid = $_SESSION["userid"];
/////////////////////조회수//////////////////////////
$is_count = false;
if (!isset($_COOKIE["todayhouseprice"])) {
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



mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

//조회수 출력
$sql_count = "
select
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count),0),0) AS total,
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count WHERE YMD = '$today'),0),0) AS today
FROM DUAL;
";
$rs_count = mysqli_query($Conn, $sql_count);
$row_count = mysqli_fetch_assoc($rs_count);

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


$sql = "
SELECT insert_date,up_price,down_price,(down_price-up_price) as diff_price  FROM
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
order by a.insert_date desc
    ";

$result_chart = mysqli_query($Conn, $sql_chart);

while ($row_chart = mysqli_fetch_assoc($result_chart)) {
    $data_array[] = $row_chart;
}
$chart = json_encode($data_array);

$result_min_max = mysqli_query($Conn, $sql_min_max);
$row_min_max = mysqli_fetch_assoc($result_min_max);


$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

$this_site = str_replace('.php','',basename( $_SERVER[ "PHP_SELF" ] ));

?>
<?php
  if(!$userid){
?>
<a style="font-size:25px;" href="./login.php?site=<?=$this_site?>"><b>로그인</b></a><span style="font-size:25px;"><b> <--즐겨찾기 기능사용</b></span>  <a style="font-size:25px;" href='./info.php'>(텔레그램으로 매일 알림받기)</a>
<?php
  }else if($userid){
    //$logged = $username."(".$userid.")";
    $logged = $userid;


?>
<span style="font-size:25px;"><b><?=$logged ?>님 </b></span><a style="font-size:25px;" href="./logout.php?site=<?=$this_site?>"><b>로그아웃</b></a>  <a style="font-size:25px;" href="./apart_favorite.php"><b>즐겨찾기</b></a>  <a style="font-size:25px;" href='./info.php'>(텔레그램으로 매일 알림받기)</a>
<?php }?>

<?php if($userid=="ljs1092"){?>
<span style="font-size:25px; float:right;"><b>Total : <?=$row_count['total']?>, Today : <?=$row_count['today']?></b></span>
<?php }else{?>
<span style="font-size:25px; float:right;"><b><a href="./list.php" style="text-decoration-line: none;"><b>[자유게시판]</b></a><a href="./apart_news.php" style="text-decoration-line: none;"><b>[부동산뉴스]</b></a></b></span>
<?php }?>
<table>
    <thead>
    <tr>
      <th style="background: #C0C0C0; width:33%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;"><center>아파트</center></th>
      <th style="background: #DEEBF7; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../officetel/apart_trend.php'>오피스텔</a></center></th>
      <th style="background: #E2F0D9; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../billa/apart_trend.php'>다세대주택(빌라)</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background: #809EAD; width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
      <th style="background: #809EAD; width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매 상세조회</a></center></th>
      <th style="background: #809EAD; width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home_rent.php?user_update=true'>전월세 상세조회</a></center></th>
      <th style="background: #73685d; width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'>부동산 통계</a></center></th>
      <th style="background: #809EAD; width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./list.php'>자유게시판</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend.php'>거래량</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_nobunyang.php'>미분양</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_newbunyang.php'>신규분양</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_buy_burden.php'>주택구입 부담지수</a></center></th>
      <th style="background-color:rgba(0, 0, 0, 0.3); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend_meme_avg.php'>매매 평균가격</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_apart_meme.php'>매매 수급동향</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_apart_rent.php'>전세 수급동향</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_apart_price.php'>매매 가격지수</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_apart_price_rent.php'>전세 가격지수</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_Rent_Rate.php'>아파트 전세가율</a></center></th>
    </tr>
  </thead>
</table>
<br>
<center>
<a href="./apart_today.php"><img style="vertical-align: middle;" width="100", height="100" src="./todayhouseprice2.png"></a>
<span style="font-size:60px; vertical-align: middle; font-family: nanumpen;">&nbsp;&nbsp;오늘집값</span>
</center>



<?php if($isMobile == "N") { ?>
<div id='container'>
    <div id='box-left'>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
             crossorigin="anonymous"></script>
        <!-- 디스플레이광고 수직 -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-2265060002718871"
             data-ad-slot="7863262703"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

    <div id='box-center'>
<?php } ?>




<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>
<span style="font-size:20px;">오늘집값 누적 데이터로 만들어진 그래프 입니다.</span>
<br><br>
<span style="font-size:30px;">아파트 일자별 총 상승/하락 금액 (단위: 억원, 22년 10월 14일 이후)</span>
<br><br>
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
            title: '총금액 추이',
            chartArea: {left: '7%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,1: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,2: {type: 'bars', targetAxisIndex: 1, color: '#ced4da'}},
            hAxis: {
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
                    viewWindow: { min: 0, max: <?=$row_min_max['temp_max']?>}, title : "상승/하락"
                },
                1: {
                    viewWindow: { min: -100, max: 300}, title : "차이"
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

<br>
<details>
   <summary><span style="font-size: 20px;">일자별 총 상승/하락 금액 데이터 상세보기(클릭)<span></summary>

    <table>
        <thead>
        <tr>
            <th style="width:25%; font-size: 15px;">조사시점</th>
            <th style="width:25%; font-size: 15px;">상승(억)</th>
            <th style="width:25%; font-size: 15px;">하락(억)</th>
            <th style="width:25%; font-size: 15px;">차이(하락-상승)</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row) { ?>
          <tr>
              <td style="font-size: 15px;"><b><?=$row['insert_date']?></b></td>
              <td style="font-size: 15px;"><b><?=$row['up_price']?> 억</b></td>
              <td style="font-size: 15px;"><b><?=$row['down_price']?> 억</b></td>
              <td style="font-size: 15px;"><b><?=$row['diff_price']?> 억</b></td>

          </tr>
          <?php } ?>
        </tbody>
    </table>
</details>


<?php if($advertize=="1"){ ?>
<br><br>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
       crossorigin="anonymous"></script>
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-format="fluid"
       data-ad-layout-key="-fb+5w+4e-db+86"
       data-ad-client="ca-pub-2265060002718871"
       data-ad-slot="3474043280"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
<?php } ?>








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


$sql2 = "
SELECT insert_date,up_cnt,down_cnt,(down_cnt-up_cnt) as diff_cnt  FROM
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
order by a.insert_date desc
    ";

$result_chart2 = mysqli_query($Conn, $sql_chart2);

while ($row_chart2 = mysqli_fetch_assoc($result_chart2)) {
    $data_array2[] = $row_chart2;
}
$chart2 = json_encode($data_array2);

$result_min_max2 = mysqli_query($Conn, $sql_min_max2);
$row_min_max2 = mysqli_fetch_assoc($result_min_max2);


$rs2 = mysqli_query($Conn, $sql2);

while ( $row2 = mysqli_fetch_assoc($rs2) ) {
    $rows2[] = $row2;
}

?>
<span style="font-size:30px;">아파트 일자별 총 상승/하락 거래수 (단위: 개, 22년 10월 14일 이후)</span>
<br><br>
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
            title: '거래수 추이',
            chartArea: {left: '7%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,1: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,2: {type: 'bars', targetAxisIndex: 1, color: '#ced4da'}},
            hAxis: {
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
                    viewWindow: { min: 0, max: <?=$row_min_max2['temp_max']?>}, title : "상승/하락"
                },
                1: {
                    viewWindow: { min: 0, max: 300}, title : "차이"
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

<br>
<details>
   <summary><span style="font-size: 20px;">일자별 총 상승/하락 거래수 데이터 상세보기(클릭)<span></summary>

    <table>
        <thead>
        <tr>
            <th style="width:25%; font-size: 15px;">조사시점</th>
            <th style="width:25%; font-size: 15px;">상승(건)</th>
            <th style="width:25%; font-size: 15px;">하락(건)</th>
            <th style="width:25%; font-size: 15px;">차이(하락-상승)</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($rows2 as $row2) { ?>
          <tr>
              <td style="font-size: 15px;"><b><?=$row2['insert_date']?></b></td>
              <td style="font-size: 15px;"><b><?=$row2['up_cnt']?> 건</b></td>
              <td style="font-size: 15px;"><b><?=$row2['down_cnt']?> 건</b></td>
              <td style="font-size: 15px;"><b><?=$row2['diff_cnt']?> 건</b></td>

          </tr>
          <?php } ?>
        </tbody>
    </table>
   <p>details, summary 같이 적용</p>
</details>

<?php if($advertize=="1"){ ?>
<br><br>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
       crossorigin="anonymous"></script>
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-format="fluid"
       data-ad-layout-key="-fb+5w+4e-db+86"
       data-ad-client="ca-pub-2265060002718871"
       data-ad-slot="3474043280"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
<?php } ?>








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

$sql3 = "
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
order by a.insert_date desc
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
<span style="font-size:30px;">아파트 일자별 평균 상승/하락 거래금액 (단위: 억, 22년 10월 14일 이후)</span>
<br><br>
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
            title: '평균 금액 추이',
            chartArea: {left: '7%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,1: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,2: {type: 'bars', targetAxisIndex: 1, color: '#ced4da'}},
            hAxis: {
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
                    viewWindow: { min: 0, max: <?=$row_min_max3['temp_max']?>}, title : "상승/하락"
                },
                1: {
                    viewWindow: { min: -0.5, max: 0.5}, title : "차이"
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

<br>
<details>
   <summary><span style="font-size: 20px;">일자별 평균 상승/하락 거래금액 데이터 상세보기(클릭)<span></summary>

    <table>
        <thead>
        <tr>
            <th style="width:25%; font-size: 15px;">조사시점</th>
            <th style="width:25%; font-size: 15px;">상승(억)</th>
            <th style="width:25%; font-size: 15px;">하락(억)</th>
            <th style="width:25%; font-size: 15px;">차이(하락-상승)</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($rows3 as $row3) { ?>
          <tr>
              <td style="font-size: 15px;"><b><?=$row3['insert_date']?></b></td>
              <td style="font-size: 15px;"><b><?=$row3['avg_up']?> 억</b></td>
              <td style="font-size: 15px;"><b><?=$row3['avg_down']?> 억</b></td>
              <td style="font-size: 15px;"><b><?=$row3['avg_diff']?> 억</b></td>

          </tr>
          <?php } ?>
        </tbody>
    </table>
   <p>details, summary 같이 적용</p>
</details>

<?php if($advertize=="1"){ ?>
<br><br>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
       crossorigin="anonymous"></script>
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-format="fluid"
       data-ad-layout-key="-fb+5w+4e-db+86"
       data-ad-client="ca-pub-2265060002718871"
       data-ad-slot="3474043280"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
<?php } ?>







<?php if($isMobile == "N") { ?>
  </div>


  <div id='box-right'>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
         crossorigin="anonymous"></script>
    <!-- 디스플레이광고 수직 -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-2265060002718871"
         data-ad-slot="7863262703"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>


  </div>
</div>
<?php } ?>


<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : todayhouseprice.com@gmail.com</b></span></center>

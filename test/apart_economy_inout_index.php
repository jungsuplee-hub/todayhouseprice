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
<title>오늘집값 - 무역수지</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 무역수지">
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
select
yyyymm,
IFNULL(CAST(MAX(case when area = '수출금액' then cnt end) as DECIMAL(10,0))/1000,0) as cnt1,
IFNULL(CAST(MAX(case when area = '수입금액' then cnt end) as DECIMAL(10,0))/1000,0) as cnt2,
IFNULL(CAST(MAX(case when area = '무역수지' then cnt end) as DECIMAL(10,0))/1000,0) as cnt3
from TongGye_InOut_Index
group by yyyymm
order by yyyymm
";

$sql_min_max = "
select min(CAST(cnt as DECIMAL(10,0)))/1000 as temp_min, max(CAST(cnt as DECIMAL(10,0)))/1000+100 as temp_max
FROM TongGye_InOut_Index
";


$sql = "
select
yyyymm as yyyymm,
FORMAT(IFNULL(CAST(MAX(case when area = '수출금액' then cnt end) as DECIMAL(10,0)),0)/1000,0) as cnt1,
FORMAT(IFNULL(CAST(MAX(case when area = '수입금액' then cnt end) as DECIMAL(10,0)),0)/1000,0) as cnt2,
FORMAT(IFNULL(CAST(MAX(case when area = '무역수지' then cnt end) as DECIMAL(10,0)),0)/1000,0) as cnt3
from TongGye_InOut_Index
group by yyyymm
order by yyyymm desc
    ";

$result_chart = mysqli_query($Conn, $sql_chart);

while ($row_chart = mysqli_fetch_assoc($result_chart)) {
    $data_array[] = $row_chart;
}
$chart = json_encode($data_array);

$result_min_max = mysqli_query($Conn, $sql_min_max);
$row_min_max = mysqli_fetch_assoc($result_min_max);
//여기는 그래프 관련


$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

$this_site = str_replace('.php','',basename( $_SERVER[ "PHP_SELF" ] ));


$referer_domain = $_SERVER['HTTP_REFERER'];

echo $referer_domain;

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
      <th style="background: #FBE5D6; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../apart_today.php'><center>아파트</center></th>
      <th style="background: #DEEBF7; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../officetel/apart_today.php'>오피스텔</a></center></th>
      <th style="background: #E2F0D9; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../billa/apart_today.php'>다세대주택(빌라)</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매 상세조회</a></center></th>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home_rent.php?user_update=true'>전월세 상세조회</a></center></th>
      <th style="background: #73685d; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'>부동산 통계</a></center></th>
      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값 랭킹</a></center></th>
      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_economy_inout_index.php'>경제지표</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background-color:rgba(0, 0, 0, 0.3); width:18%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_economy_inout_index.php'>무역수지</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_economy_gdp_index.php'>경제성장률</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_economy_customer_mulga.php'>소비자물가지수</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_economy_seller_mulga.php'>생산자물가지수</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_economy_population_index.php'>경제활동인구</a></center></th>
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
<span style="font-size:20px;">관세청 자료를 바탕으로 만들어진 데이터 입니다.</span>
<br>
<br>
<span style="font-size:30px;">수출금액 / 수입금액 / 무역수지 그래프 (천만달러)</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '수출금액', '수입금액', '무역수지'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt2),
                Number(item.cnt3)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '수출/수입/무역수지 추이',
            chartArea: {left: '10%', width: '79%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0}
            ,1: {type: 'line', targetAxisIndex: 0}
            ,2: {type: 'bars', targetAxisIndex: 1 , color: '#515a5a'}},
            hAxis: {
                showTextEvery: 12    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max['temp_max']?>}, title : "수출/수입(천만달러)"
                },
                1: {
                    title : "무역수지(천만달러)"
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
   <summary><span style="font-size: 20px;">수출금액 / 수입금액 / 무역수지 데이터 상세보기(클릭)<span></summary>

     <?php if($advertize=="1"){ ?>
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

    <table>
        <thead>
        <tr>
            <th style="font-size: 20px;">조사시점</th>
            <th style="font-size: 20px;">수출금액<br>(천만달러)</th>
            <th style="font-size: 20px;">수입금액<br>(천만달러)</th>
            <th style="font-size: 20px;">무역수지<br>(천만달러)</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row) { ?>
          <tr>
              <td style="font-size: 20px;"><b><?=$row['yyyymm']?></b></td>
              <td style="font-size: 20px;"><b><?=$row['cnt1']?></b></td>
              <td style="font-size: 20px;"><b><?=$row['cnt2']?></b></td>
              <td style="font-size: 20px;"><b><?=$row['cnt3']?></b></td>

          </tr>
          <?php } ?>
        </tbody>
    </table>
</details>





<?php
$sql_chart2 = "
select
left(yyyymm,4) as year,
SUM(CAST(cnt as DECIMAL(10,0))/1000) as total
from TongGye_InOut_Index
where area = '무역수지'
group by left(yyyymm,4)
order by left(yyyymm,4)
";

$sql_min_max2 = "
select
min(total/1000)-10000 as temp_min, max(total/1000)+10000 as temp_max
FROM
(
select
left(yyyymm,4) as year,
SUM(CAST(cnt as DECIMAL(10,0))) as total
from TongGye_InOut_Index
where area = '무역수지'
group by left(yyyymm,4)
) a
";


$sql2 = "
select
left(yyyymm,4) as year,
FORMAT(SUM(CAST(cnt as DECIMAL(10,0)))/1000,0) as total
from TongGye_InOut_Index
where area = '무역수지'
group by left(yyyymm,4)
order by left(yyyymm,4)
    ";

$result_chart2 = mysqli_query($Conn, $sql_chart2);

while ($row_chart2 = mysqli_fetch_assoc($result_chart2)) {
    $data_array2[] = $row_chart2;
}
$chart2 = json_encode($data_array2);

//여기는 그래프 관련

$result_min_max2 = mysqli_query($Conn, $sql_min_max2);
$row_min_max2 = mysqli_fetch_assoc($result_min_max2);
//여기는 그래프 관련


$rs2 = mysqli_query($Conn, $sql2);

while ( $row2 = mysqli_fetch_assoc($rs2) ) {
    $rows2[] = $row2;
}


?>



<?php if($advertize=="1"){ ?>
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



<br><br>

<span style="font-size:30px;">무역수지 연도별 합계 그래프 (천만달러)</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart2; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','무역수지'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.year,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.total)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '년도별 무역수지 합계 추이',
            chartArea: {left: '10%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 1    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max2['temp_min']?>, max: <?=$row_min_max2['temp_max']?>},title : "무역수지(천만달러)"
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
   <summary><span style="font-size: 20px;">년도 합계 무역수지 데이터 상세보기(클릭)<span></summary>

     <?php if($advertize=="1"){ ?>
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

    <table>
        <thead>
        <tr>
            <th style="font-size: 20px;">조사시점</th>
            <th style="font-size: 20px;">무역수지<br>(천달러)</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($rows2 as $row2) { ?>
          <tr>
              <td style="font-size: 20px;"><b><?=$row2['year']?></b></td>
              <td style="font-size: 20px;"><b><?=$row2['total']?></b></td>

          </tr>
          <?php } ?>
        </tbody>
    </table>
</details>





<?php if($advertize=="1"){ ?>
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

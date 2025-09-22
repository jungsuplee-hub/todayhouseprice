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
<title>오늘집값 - 생산자 물가지수</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 생산자 물가지수">
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
IFNULL(CAST(MAX(case when area = '총지수' then cnt end) as DECIMAL(10,0)),0) as cnt_all
from TongGye_Seller_Mulga
group by yyyymm
order by yyyymm
";

$sql_min_max = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+10 as temp_max
FROM TongGye_Seller_Mulga
where area = '총지수'
";


$sql = "
select
concat(substr(yyyymm,1,4),'년 ',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '총지수' then cnt end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '상품' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '농림수산품' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '광산품' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '공산품' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '전력가스수도및폐기물' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '서비스' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '운송서비스' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '음식및숙박서비스' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '정보통신및방송서비스' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '금융및보험서비스' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '부동산서비스' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전물과학및기술서비스' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '사업지원서비스' then cnt end) as DECIMAL(10,0)),0) as cnt13
from TongGye_Seller_Mulga
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
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매 상세조회</a></center></th>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home_rent.php?user_update=true'>전월세 상세조회</a></center></th>
      <th style="background: #73685d; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'>부동산 통계</a></center></th>
      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값 랭킹</a></center></th>
      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./list.php'>자유게시판</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:15%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend.php'>거래량</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_newbunyang.php'>신규분양</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_nobunyang.php'>미분양</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_nobunyangafter.php'>완공후 미분양</a></center></th>
      <th style="background-color:rgba(0, 0, 0, 0.3); width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend_InitialBunyangRate.php'>초기 분양률</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:18%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_buy_burden.php'>주택구입부담지수</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_apart_meme.php'>매매 수급동향</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_apart_rent.php'>전세 수급동향</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_apart_price.php'>매매 가격지수</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_apart_price_rent.php'>전세 가격지수</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_Rent_Rate.php'>아파트 전세가율</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_meme_avg.php'>매매 평균가격</a></center></th>
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
<span style="font-size:20px;">한국은행 자료를 바탕으로 만들어진 데이터 입니다.
<br>
<br>

<span style="font-size:15px;">
  - 물가지수는 가격의 변동추이 측정이 목적이며, 가격의 절대수준을 나타내지는 않음<br>
  - 농림수산품의 조사대상가격은 도매시장 경락가격 또는 유통가격으로 농어가의 판매가격이 아님<br>
  - 소비자물가지수와 비교는 가능하나 생산자판매단계와 소매단계의 마진을 측정하는 데 이용될 수는 없음<br>
  - 생산자물가지수는 총지수의 추정을 위해 표본설계되어 있으므로 최하위 분류단위인 품목별 지수는 통계적 유의성이 떨어질 수 있음<br>
</span>
<br>
<br>

<span style="font-size:30px;">생산자 물가지수 그래프</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '생산자물가지수'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt_all)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '생산자물가지수 추이',
            legend: 'none',
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                title: 'Time',
                showTextEvery: 20    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0, lineWidth: 4}
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


<center><div id="lineChart_div" style="width: 100%; height: 400px"></div></center>


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
        <th style="font-size: 15px;">조사시점</th>
        <th style="font-size: 15px;">총지수</th>
        <th style="font-size: 15px;">상품</th>
        <th style="font-size: 15px;">농림수산품</th>
        <th style="font-size: 15px;">광산품</th>
        <th style="font-size: 15px;">공산품</th>
        <th style="font-size: 15px;">전려가스수도<br>및폐기물</th>
        <th style="font-size: 15px;">서비스</th>
        <th style="font-size: 15px;">운송<br>서비스</th>
        <th style="font-size: 15px;">음식점및<br>숙박서비스</th>
        <th style="font-size: 15px;">정보통신및<br>방송서비스</th>
        <th style="font-size: 15px;">금융및<br>보험서비스</th>
        <th style="font-size: 15px;">부동산<br>서비스</th>
        <th style="font-size: 15px;">전문과학및<br>기술서비스</th>
        <th style="font-size: 15px;">사업지원<br>서비스</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row['yyyymm']?>월</b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt_all']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt1']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt2']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt3']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt4']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt5']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt6']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt7']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt8']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt9']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt10']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt11']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt12']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt13']?></b></td>

      </tr>
      <?php } ?>
    </tbody>
</table>

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

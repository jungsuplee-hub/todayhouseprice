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
<title>오늘집값 - 아파트 미분양 현황</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 아파트 미분양 현황">
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

$sql_chart2 = "
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

$sql_min_max2 = "
select min(temp) as temp_min, max(temp)+1000 as temp_max
FROM(
select yyyymm as dt, sum(cast(cnt as unsigned)) as temp
from NoBunYangAfter
group by yyyymm
order by yyyymm desc
limit 48
) aa
";


$sql2 = "
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
limit 48
    ";

$result_chart2 = mysqli_query($Conn, $sql_chart2);

while ($row_chart2 = mysqli_fetch_assoc($result_chart2)) {
    $data_array2[] = $row_chart2;
}
$chart2 = json_encode($data_array2);

$result_min_max2 = mysqli_query($Conn, $sql_min_max2);
$row_min_max2 = mysqli_fetch_assoc($result_min_max2);
//여기는 그래프 관련


$rs2 = mysqli_query($Conn, $sql2);

while ( $row2 = mysqli_fetch_assoc($rs2) ) {
    $rows2[] = $row2;
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
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend.php'>거래량</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_newbunyang.php'>신규분양</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_nobunyang.php'>미분양</a></center></th>
      <th style="background-color:rgba(0, 0, 0, 0.3); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend_nobunyangafter.php'>완공후 미분양</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_InitialBunyangRate.php'>초기 분양률</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:25%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_buy_burden.php'>주택구입부담지수</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:25%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_customer_index.php'>부동산 심리지수</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:25%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_gongsa_pay.php'>공사비 지수</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:25%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_Rent_Rate.php'>아파트 전세가율</a></center></th>
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
      <th style="background-color:rgba(255, 255, 255, 0.8); width:20%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_trend_meme_avg.php'>매매 평균가격</a></center></th>
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
<span style="font-size:20px;">국토부 제공 자료를 바탕으로 만들어진 데이터 입니다.</span>
<br>
<br>
<span style="font-size:30px;">최근4년 전국 아파트 공사완료후 미분양 그래프</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart2; ?>;

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
            chartArea: {left: '7%', width: '91%', height:'72%'},
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
                    viewWindow: { min: 0, max: <?=$row_min_max2['temp_max']?> }
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
      <?php foreach ($rows2 as $row2) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row2['yyyymm']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt_all']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt1']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt2']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt3']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt4']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt5']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt6']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt7']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt8']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt9']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt10']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt11']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt12']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt13']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt14']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt15']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt16']?></b></td>
          <td style="font-size: 13px;"><b><?=$row2['cnt17']?></b></td>

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

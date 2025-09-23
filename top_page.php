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
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="http://todayhouseprice.com/js/bootstrap.min.js"></script>
<!--<link href="./css/bootstrap.min.css" rel="stylesheet">-->
<link rel="shortcut icon" type="image/x-icon" href="http://todayhouseprice.com/todayhouseprice2.ico"> 
<link rel='stylesheet' type='text/css' href='http://todayhouseprice.com/todayhouseprice.css'>
<meta property="og:type" content="website">
<meta property="og:image" content="http://todayhouseprice.com/todayhouseprice2.png">
<meta property="og:url" content="http://todayhouseprice.com/apart_today.php">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"

     crossorigin="anonymous"></script>
<?php
$this_site = $_SERVER[ "PHP_SELF" ];

$this_site_without_domain = str_replace('/billa','',$this_site);
$this_site_without_domain = str_replace('/officetel','',$this_site_without_domain);

/////////////////////사용기기체크//////////////////////////
$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";
if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
	$isMobile = "Y";
}else{
	$isMobile = "N";
}

//echo $this_site;
if (strpos($this_site,'officetel')) {
  if ($this_site_without_domain=='/apart_today.php') {
    echo "<title>오늘집값 - 오피스텔 금일 신규거래 조회</title>";
    echo "<meta name='description' content='오피스텔 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.'>";
    echo "<meta property='og:title' content='오늘집값 - 금일 오피스텔 신규 매매/전세 조회'>";
    echo "<meta property='og:description' content='오늘집값 - 금일 등록된 오피스텔 신규 매매/전세 정보를 조회할 수 있습니다.'>";
  }
  elseif ($this_site_without_domain=='/apart_home.php') {
    echo "<title>오늘집값 - 오피스텔 매매 상세조회</title>";
    echo "<meta name='description' content='오피스텔 매매 실거래가를 확인해보세요.'>";
    echo "<meta property='og:title' content='오늘집값 - 오피스텔 매매 상세조회'>";
    echo "<meta property='og:description' content='오늘집값 - 오피스텔 매매 실거래가를 확인해보세요.'>";
  }
  elseif ($this_site_without_domain=='/apart_home_rent.php') {
    echo "<title>오늘집값 - 오피스텔 전세 상세조회</title>";
    echo "<meta name='description' content='오피스텔 전세 실거래가를 확인해보세요.'>";
    echo "<meta property='og:title' content='오늘집값 - 오피스텔 전세 상세조회'>";
    echo "<meta property='og:description' content='오늘집값 - 오피스텔 전세 실거래가를 확인해보세요.'>";
  }
  elseif ($this_site_without_domain=='/apart_bunyang.php') {
    echo "<title>오늘집값 - 오피스텔 분양정보 조회</title>";
    echo "<meta name='description' content='오피스텔 분양정보 조회'>";
    echo "<meta property='og:title' content='오늘집값 - 오피스텔 분양정보 조회'>";
    echo "<meta property='og:description' content='오늘집값 - 오피스텔 분양정보 조회.'>";
  }
  elseif ($this_site_without_domain=='/apart_trend.php') {
    echo "<title>오늘집값 - 오피스텔 거래량</title>";
    echo "<meta name='description' content='오피스텔 거래량정보를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 오피스텔 거래량'>";
    echo "<meta property='og:description' content='오늘집값 - 오피스텔 거래량정보를 확인하세요'>";
  }
  elseif ($this_site_without_domain=='/apart_todayhouseprice_rank_one.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_two.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_three.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_four.php') {
    echo "<title>오늘집값 - 오늘집값 랭킹</title>";
    echo "<meta name='description' content='수집된 데이터를 활용한 다양한 랭킹 정보를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 오늘집값 랭킹'>";
    echo "<meta property='og:description' content='오늘집값 - 수집된 데이터를 활용한 다양한 랭킹 정보를 확인하세요'>";
  }
  elseif ($this_site_without_domain=='/apart_economy_inout_index.php' or $this_site_without_domain=='/apart_economy_gdp_index.php' or $this_site_without_domain=='/apart_economy_customer_mulga.php' or $this_site_without_domain=='/apart_economy_seller_mulga.php' or $this_site_without_domain=='/apart_economy_population_index.php' or $this_site_without_domain=='/apart_economy_population_count.php') {
    echo "<title>오늘집값 - 경제지표</title>";
    echo "<meta name='description' content='경제와 관련된 다양한 지표를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 경제지표'>";
    echo "<meta property='og:description' content='오늘집값 - 경제와 관련된 다양한 지표를 확인하세요'>";
  }
  else{
    echo "<title>오늘집값 - 오피스텔 금일 신규거래 조회</title>";
    echo "<meta name='description' content='오피스텔 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.'>";
    echo "<meta property='og:title' content='오늘집값 - 금일 오피스텔 신규 매매/전세 조회'>";
    echo "<meta property='og:description' content='오늘집값 - 금일 등록된 오피스텔 신규 매매/전세 정보를 조회할 수 있습니다.'>";
  }
}
elseif (strpos($this_site,'billa')) {
  if ($this_site_without_domain=='/apart_today.php') {
    echo "<title>오늘집값 - 빌라 금일 신규거래 조회</title>";
    echo "<meta name='description' content='빌라 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.'>";
    echo "<meta property='og:title' content='오늘집값 - 금일 빌라 신규 매매/전세 조회'>";
    echo "<meta property='og:description' content='오늘집값 - 금일 등록된 빌라 신규 매매/전세 정보를 조회할 수 있습니다.'>";
  }
  elseif ($this_site_without_domain=='/apart_home.php') {
    echo "<title>오늘집값 - 빌라 매매 상세조회</title>";
    echo "<meta name='description' content='빌라 매매 실거래가를 확인해보세요.'>";
    echo "<meta property='og:title' content='오늘집값 - 빌라 매매 상세조회'>";
    echo "<meta property='og:description' content='오늘집값 - 빌라 매매 실거래가를 확인해보세요.'>";
  }
  elseif ($this_site_without_domain=='/apart_home_rent.php') {
    echo "<title>오늘집값 - 빌라 전세 상세조회</title>";
    echo "<meta name='description' content='빌라 전세 실거래가를 확인해보세요.'>";
    echo "<meta property='og:title' content='오늘집값 - 빌라 전세 상세조회'>";
    echo "<meta property='og:description' content='오늘집값 - 빌라 전세 실거래가를 확인해보세요.'>";
  }
  elseif ($this_site_without_domain=='/apart_trend.php') {
    echo "<title>오늘집값 - 빌라 거래량</title>";
    echo "<meta name='description' content='빌라 거래량정보를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 빌라 거래량'>";
    echo "<meta property='og:description' content='오늘집값 - 빌라 거래량정보를 확인하세요'>";
  }
  elseif ($this_site_without_domain=='/apart_todayhouseprice_rank_one.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_two.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_three.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_four.php') {
    echo "<title>오늘집값 - 오늘집값 랭킹</title>";
    echo "<meta name='description' content='수집된 데이터를 활용한 다양한 랭킹 정보를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 오늘집값 랭킹'>";
    echo "<meta property='og:description' content='오늘집값 - 수집된 데이터를 활용한 다양한 랭킹 정보를 확인하세요'>";
  }
  elseif ($this_site_without_domain=='/apart_economy_inout_index.php' or $this_site_without_domain=='/apart_economy_gdp_index.php' or $this_site_without_domain=='/apart_economy_customer_mulga.php' or $this_site_without_domain=='/apart_economy_seller_mulga.php' or $this_site_without_domain=='/apart_economy_population_index.php' or $this_site_without_domain=='/apart_economy_population_count.php') {
    echo "<title>오늘집값 - 경제지표</title>";
    echo "<meta name='description' content='경제와 관련된 다양한 지표를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 경제지표'>";
    echo "<meta property='og:description' content='오늘집값 - 경제와 관련된 다양한 지표를 확인하세요'>";
  }
  else{
    echo "<title>오늘집값 - 빌라 금일 신규거래 조회</title>";
    echo "<meta name='description' content='빌라 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.'>";
    echo "<meta property='og:title' content='오늘집값 - 금일 빌라 신규 매매/전세 조회'>";
    echo "<meta property='og:description' content='오늘집값 - 금일 등록된 빌라 신규 매매/전세 정보를 조회할 수 있습니다.'>";
  }
}
else{
  if ($this_site=='/apart_today.php') {
    echo "<title>오늘집값 - 아파트 금일 신규거래 조회</title>";
    echo "<meta name='description' content='아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.'>";
    echo "<meta property='og:title' content='오늘집값 - 금일 아파트 신규 매매/전세 조회'>";
    echo "<meta property='og:description' content='오늘집값 - 금일 등록된 아파트 신규 매매/전세 정보를 조회할 수 있습니다.'>";
  }
  elseif ($this_site=='/apart_home.php') {
    echo "<title>오늘집값 - 아파트매매/전세 상세조회</title>";
    echo "<meta name='description' content='아파트 매매/전세 실거래가를 확인해보세요.'>";
    echo "<meta property='og:title' content='오늘집값 - 아파트매매/전세 상세조회'>";
    echo "<meta property='og:description' content='오늘집값 - 아파트 매매/전세 실거래가를 확인해보세요.'>";
  }
  elseif ($this_site=='/apart_home_rent.php') {
    echo "<title>오늘집값 - 아파트전세 상세조회</title>";
    echo "<meta name='description' content='아파트 전세 실거래가를 확인해보세요.'>";
    echo "<meta property='og:title' content='오늘집값 - 아파트전세 상세조회'>";
    echo "<meta property='og:description' content='오늘집값 - 아파트 전세 실거래가를 확인해보세요.'>";
  }
  elseif ($this_site=='/apart_bunyang.php') {
    echo "<title>오늘집값 - 아파트 분양정보 조회</title>";
    echo "<meta name='description' content='아파트 분양정보 조회'>";
    echo "<meta property='og:title' content='오늘집값 - 아파트 분양정보 조회'>";
    echo "<meta property='og:description' content='오늘집값 - 아파트 분양정보 조회.'>";
  }
  elseif ($this_site=='/apart_trend.php' or $this_site=='/apart_trend_newbunyang.php' or $this_site=='/apart_trend_nobunyang.php' or $this_site=='/apart_trend_nobunyangafter.php' or $this_site=='/apart_trend_InitialBunyangRate.php' or $this_site=='/apart_trend_buy_burden.php' or $this_site=='/apart_trend_customer_index.php' or $this_site=='/apart_trend_gongsa_pay.php' or $this_site=='/apart_trend_Rent_Rate.php' or $this_site=='/apart_trend_apart_meme.php' or $this_site=='/apart_trend_apart_rent.php' or $this_site=='/apart_trend_apart_price.php' or $this_site=='/apart_trend_apart_price_rent.php' or $this_site=='/apart_trend_meme_avg.php') {
    echo "<title>오늘집값 - 아파트 부동산 통계</title>";
    echo "<meta name='description' content='아파트 관련 부동산 통계정보를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 아파트 부동산 통계'>";
    echo "<meta property='og:description' content='오늘집값 - 아파트 관련 부동산 통계정보를 확인하세요'>";
  }
  elseif ($this_site=='/apart_todayhouseprice_rank_one.php' or $this_site=='/apart_todayhouseprice_rank_two.php' or $this_site=='/apart_todayhouseprice_rank_three.php' or $this_site=='/apart_todayhouseprice_rank_four.php' or $this_site=='/apart_todayhouseprice_rank_five.php') {
    echo "<title>오늘집값 - 오늘집값 랭킹</title>";
    echo "<meta name='description' content='수집된 데이터를 활용한 다양한 랭킹 정보를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 오늘집값 랭킹'>";
    echo "<meta property='og:description' content='오늘집값 - 수집된 데이터를 활용한 다양한 랭킹 정보를 확인하세요'>";
  }
  elseif ($this_site=='/apart_economy_inout_index.php' or $this_site=='/apart_economy_gdp_index.php' or $this_site=='/apart_economy_customer_mulga.php' or $this_site=='/apart_economy_seller_mulga.php' or $this_site=='/apart_economy_population_index.php' or $this_site=='/apart_economy_birth_index.php' or $this_site=='/apart_economy_population_count.php') {
    echo "<title>오늘집값 - 경제지표</title>";
    echo "<meta name='description' content='경제와 관련된 다양한 지표를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 경제지표'>";
    echo "<meta property='og:description' content='오늘집값 - 경제와 관련된 다양한 지표를 확인하세요'>";
  }
  elseif ($this_site=='/apart_search.php') {
    echo "<title>오늘집값 - 검색</title>";
    echo "<meta name='description' content='검색해보세요'>";
    echo "<meta property='og:title' content='오늘집값 - 검색'>";
    echo "<meta property='og:description' content='오늘집값 - 검색해보세요'>";
  }
  elseif ($this_site=='/apart_auction.php') {
    echo "<title>오늘집값 - 아파트 경매예정</title>";
    echo "<meta name='description' content='아파트 경매예정정보를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 아파트 경매예정'>";
    echo "<meta property='og:description' content='오늘집값 - 아파트 경매예정정보를 확인하세요'>";
  }
  elseif ($this_site=='/apart_auction_result.php') {
    echo "<title>오늘집값 - 아파트 경매결과</title>";
    echo "<meta name='description' content='아파트 경매결과정보를 확인하세요'>";
    echo "<meta property='og:title' content='오늘집값 - 아파트 경매결과'>";
    echo "<meta property='og:description' content='오늘집값 - 아파트 경매결과정보를 확인하세요'>";
  }
  else{
    echo "<title>오늘집값 - 아파트 금일 신규거래 조회</title>";
    echo "<meta name='description' content='아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.'>";
    echo "<meta property='og:title' content='오늘집값 - 금일 아파트 신규 매매/전세 조회'>";
    echo "<meta property='og:description' content='오늘집값 - 금일 등록된 아파트 신규 매매/전세 정보를 조회할 수 있습니다.'>";

  }
}

if($isMobile=='Y'){
    echo "<meta name='viewport' content='width=device-width, initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no, shrink-to-fit=no'>";
}

?>







</head>
<?php

/////////////////////세션연결//////////////////////////
session_start();
//session_start();
$is_count = false;
$userid = $_SESSION["userid"];
if (!isset($_COOKIE["todayhouseprice"])) {
    setcookie("todayhouseprice", "count", time() + 60 * 60 * 24);
    $is_count = true;
}
/////////////////////광고사용여부//////////////////////////
$advertize = "1";

/////////////////////디비연결//////////////////////////
$Conn = mysqli_connect("localhost", "root", "e0425820", "jsdb", 3306);
mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");
/////////////////////금일 지수//////////////////////////
$rs_today = mysqli_query($Conn, "select dallor, gumri_usa, gumri_korea, kospi, kosdaq, substr(update_date,1,19) as update_date from today_index");
$row_today = mysqli_fetch_assoc($rs_today);


$today = date("Y-m-d");


/////////////////////조회수//////////////////////////
if ($is_count) {
  $rs = mysqli_query($Conn, "select count(1) as cnt from molit_visit_count where ymd = '$today' and count_type = 'today';");
  $row = mysqli_fetch_assoc($rs);
  if($row['cnt']==0) {
    mysqli_query($Conn, "insert into molit_visit_count (ymd, count, count_type) values('$today',1,'today');");
  }else{
    mysqli_query($Conn, "update molit_visit_count set count = count + 1 where ymd = '$today' and count_type = 'today';");
  }
}



$this_site_for_login = str_replace('.php','',basename( $_SERVER[ "PHP_SELF" ] ));
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
<?php
  if(!$userid){
?>
<span style="font-size:25px;"><b><a href="./login.php?site=<?=$this_site_for_login?>">로그인</a> <?php if($isMobile=='N'){ ?><--즐겨찾기기능<?php } ?></b></span>
<?php
  }else if($userid){
    //$logged = $username."(".$userid.")";
    $logged = $userid;
?>
<span style="font-size:25px;"><b><?=$logged ?>님<a href="./logout.php">로그아웃</a>  <a href="./apart_favorite.php" style="text-decoration-line: none;">[즐겨찾기]</a></b></span>
<?php }?>

<span style="font-size:25px; float:right;"><b><?php if(!$userid){?><a href="http://todayhouseprice.com/info.php" style="text-decoration-line: none;">[텔레그램]</a><a href="http://todayhouseprice.com/guide.php" style="text-decoration-line: none;">[사용가이드]</a><?php } ?><a href="http://todayhouseprice.com/list.php" style="text-decoration-line: none;">[자유게시판]</a><a href="http://todayhouseprice.com/apart_news.php" style="text-decoration-line: none;">[부동산뉴스]</a></b></span>
<table>
    <thead>
    <tr>
<?php
      if (strpos($this_site,'officetel')) {
				echo "<th style='background: #FBE5D6; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../apart_today.php?user_update=true'>아파트</a></center></th>";
				echo "<th style='background: #C0C0C0; width:33%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;'><center>오피스텔</center></th>";
				echo "<th style='background: #E2F0D9; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../billa/apart_today.php?user_update=true'>빌라</a></center></th>";
			}elseif (strpos($this_site,'billa')) {
				echo "<th style='background: #FBE5D6; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../apart_today.php?user_update=true'>아파트</a></center></th>";
				echo "<th style='background: #DEEBF7; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../officetel/apart_today.php?user_update=true'>오피스텔</a></center></th>";
				echo "<th style='background: #C0C0C0; width:33%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;'><center>빌라</center></th>";
			}else{
        if($this_site=='/list.php' or $this_site=='/apart_news.php'){
          echo "<th style='background: #FBE5D6; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../apart_today.php?user_update=true'>아파트</a></center></th>";
  	      echo "<th style='background: #DEEBF7; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../officetel/apart_today.php?user_update=true'>오피스텔</a></center></th>";
  	      echo "<th style='background: #E2F0D9; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../billa/apart_today.php?user_update=true'>빌라</a></center></th>";
        }else{
          echo "<th style='background: #C0C0C0; width:33%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='./apart_today.php'>아파트</a></center></th>";
          //echo "<th style='background: #FFFFE0; width:30%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='./apart_map.php'>실거래지도</a></center></th>";
          //echo "<th style='background: #FFFFE0; width:30%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='./apart_auction.php'>아파트경매</a></center></th>";
  	      echo "<th style='background: #DEEBF7; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../officetel/apart_today.php?user_update=true'>오피스텔</a></center></th>";
  	      echo "<th style='background: #E2F0D9; width:33%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../billa/apart_today.php?user_update=true'>빌라</a></center></th>";
        }
			}
?>


    </tr>
  </thead>
</table>
<?php if(!($this_site=='/list.php' or $this_site=='/apart_news.php')){ ?>
  <table>
      <thead>
      <tr>
      <?php if (strpos($this_site,'billa')) {?>
        <?php if($isMobile=='Y'){?>
        <th style="background: <?php if (strpos($this_site,'apart_today.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일<br>신규등록</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_home.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매<br>상세조회</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_home_rent.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home_rent.php?user_update=true'>전월세<br>상세조회</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_trend.php') or strpos($this_site,'apart_trend_newbunyang.php') or strpos($this_site,'apart_trend_nobunyang.php') or strpos($this_site,'apart_trend_nobunyangafter.php') or strpos($this_site,'apart_trend_InitialBunyangRate.php') or strpos($this_site,'apart_trend_buy_burden.php') or strpos($this_site,'apart_trend_customer_index.php') or strpos($this_site,'apart_trend_gongsa_pay.php') or strpos($this_site,'apart_trend_Rent_Rate.php') or strpos($this_site,'apart_trend_apart_meme.php') or strpos($this_site,'apart_trend_apart_rent.php') or strpos($this_site,'apart_trend_apart_price.php') or strpos($this_site,'apart_trend_apart_price_rent.php') or strpos($this_site,'apart_trend_meme_avg.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'><?php if (strpos($this_site,'officetel') or strpos($this_site,'billa')) { echo "거래량"; } else{ echo "부동산<br>통계";} ?></a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_todayhouseprice_rank_one_share.php') or strpos($this_site,'apart_todayhouseprice_rank_one.php') or strpos($this_site,'apart_todayhouseprice_rank_two.php') or strpos($this_site,'apart_todayhouseprice_rank_three.php') or strpos($this_site,'apart_todayhouseprice_rank_four.php') or strpos($this_site,'apart_todayhouseprice_rank_five.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값<br>랭킹</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_economy_inout_index.php') or strpos($this_site,'apart_economy_gdp_index.php') or strpos($this_site,'apart_economy_customer_mulga.php') or strpos($this_site,'apart_economy_seller_mulga.php') or strpos($this_site,'apart_economy_population_index.php') or strpos($this_site,'apart_economy_birth_index.php') or strpos($this_site,'apart_economy_population_count.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_economy_inout_index.php'>경제지표</a></center></th>
        <?php }else{?>
        <th style="background: <?php if (strpos($this_site,'apart_today.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_home.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매 상세조회</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_home_rent.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home_rent.php?user_update=true'>전월세 상세조회</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_trend.php') or strpos($this_site,'apart_trend_newbunyang.php') or strpos($this_site,'apart_trend_nobunyang.php') or strpos($this_site,'apart_trend_nobunyangafter.php') or strpos($this_site,'apart_trend_InitialBunyangRate.php') or strpos($this_site,'apart_trend_buy_burden.php') or strpos($this_site,'apart_trend_customer_index.php') or strpos($this_site,'apart_trend_gongsa_pay.php') or strpos($this_site,'apart_trend_Rent_Rate.php') or strpos($this_site,'apart_trend_apart_meme.php') or strpos($this_site,'apart_trend_apart_rent.php') or strpos($this_site,'apart_trend_apart_price.php') or strpos($this_site,'apart_trend_apart_price_rent.php') or strpos($this_site,'apart_trend_meme_avg.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'><?php if (strpos($this_site,'officetel') or strpos($this_site,'billa')) { echo "거래량"; } else{ echo "부동산 통계";} ?></a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_todayhouseprice_rank_one_share.php') or strpos($this_site,'apart_todayhouseprice_rank_one.php') or strpos($this_site,'apart_todayhouseprice_rank_two.php') or strpos($this_site,'apart_todayhouseprice_rank_three.php') or strpos($this_site,'apart_todayhouseprice_rank_four.php') or strpos($this_site,'apart_todayhouseprice_rank_five.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값 랭킹</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_economy_inout_index.php') or strpos($this_site,'apart_economy_gdp_index.php') or strpos($this_site,'apart_economy_customer_mulga.php') or strpos($this_site,'apart_economy_seller_mulga.php') or strpos($this_site,'apart_economy_population_index.php') or strpos($this_site,'apart_economy_birth_index.php') or strpos($this_site,'apart_economy_population_count.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_economy_inout_index.php'>경제지표</a></center></th>
        <?php }?>
      <?php }elseif (strpos($this_site,'officetel')){ ?>
        <?php if($isMobile=='Y'){?>
        <th style="background: <?php if (strpos($this_site,'apart_today.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일<br>신규등록</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_home.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매/전세<br>상세조회</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_bunyang.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_bunyang.php'>분양정보</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_trend.php') or strpos($this_site,'apart_trend_newbunyang.php') or strpos($this_site,'apart_trend_nobunyang.php') or strpos($this_site,'apart_trend_nobunyangafter.php') or strpos($this_site,'apart_trend_InitialBunyangRate.php') or strpos($this_site,'apart_trend_buy_burden.php') or strpos($this_site,'apart_trend_customer_index.php') or strpos($this_site,'apart_trend_gongsa_pay.php') or strpos($this_site,'apart_trend_Rent_Rate.php') or strpos($this_site,'apart_trend_apart_meme.php') or strpos($this_site,'apart_trend_apart_rent.php') or strpos($this_site,'apart_trend_apart_price.php') or strpos($this_site,'apart_trend_apart_price_rent.php') or strpos($this_site,'apart_trend_meme_avg.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'><?php if (strpos($this_site,'officetel') or strpos($this_site,'billa')) { echo "거래량"; } else{ echo "부동산<br>통계";} ?></a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_todayhouseprice_rank_one_share.php') or strpos($this_site,'apart_todayhouseprice_rank_one.php') or strpos($this_site,'apart_todayhouseprice_rank_two.php') or strpos($this_site,'apart_todayhouseprice_rank_three.php') or strpos($this_site,'apart_todayhouseprice_rank_four.php') or strpos($this_site,'apart_todayhouseprice_rank_five.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값<br>랭킹</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_economy_inout_index.php') or strpos($this_site,'apart_economy_gdp_index.php') or strpos($this_site,'apart_economy_customer_mulga.php') or strpos($this_site,'apart_economy_seller_mulga.php') or strpos($this_site,'apart_economy_population_index.php') or strpos($this_site,'apart_economy_birth_index.php') or strpos($this_site,'apart_economy_population_count.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_economy_inout_index.php'>경제지표</a></center></th>
        <?php }else{?>
        <th style="background: <?php if (strpos($this_site,'apart_today.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_home.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매/전세 상세조회</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_bunyang.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_bunyang.php'>분양정보</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_trend.php') or strpos($this_site,'apart_trend_newbunyang.php') or strpos($this_site,'apart_trend_nobunyang.php') or strpos($this_site,'apart_trend_nobunyangafter.php') or strpos($this_site,'apart_trend_InitialBunyangRate.php') or strpos($this_site,'apart_trend_buy_burden.php') or strpos($this_site,'apart_trend_customer_index.php') or strpos($this_site,'apart_trend_gongsa_pay.php') or strpos($this_site,'apart_trend_Rent_Rate.php') or strpos($this_site,'apart_trend_apart_meme.php') or strpos($this_site,'apart_trend_apart_rent.php') or strpos($this_site,'apart_trend_apart_price.php') or strpos($this_site,'apart_trend_apart_price_rent.php') or strpos($this_site,'apart_trend_meme_avg.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'><?php if (strpos($this_site,'officetel') or strpos($this_site,'billa')) { echo "거래량"; } else{ echo "부동산 통계";} ?></a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_todayhouseprice_rank_one_share.php') or strpos($this_site,'apart_todayhouseprice_rank_one.php') or strpos($this_site,'apart_todayhouseprice_rank_two.php') or strpos($this_site,'apart_todayhouseprice_rank_three.php') or strpos($this_site,'apart_todayhouseprice_rank_four.php') or strpos($this_site,'apart_todayhouseprice_rank_five.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값 랭킹</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_economy_inout_index.php') or strpos($this_site,'apart_economy_gdp_index.php') or strpos($this_site,'apart_economy_customer_mulga.php') or strpos($this_site,'apart_economy_seller_mulga.php') or strpos($this_site,'apart_economy_population_index.php') or strpos($this_site,'apart_economy_birth_index.php') or strpos($this_site,'apart_economy_population_count.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_economy_inout_index.php'>경제지표</a></center></th>
        <?php }?>
      <?php }else{ ?>
        <?php if($isMobile=='Y'){?>
        <th style="background: <?php if (strpos($this_site,'apart_today.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일<br>신규등록</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_home.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매/전세<br>상세조회</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_bunyang.php') or strpos($this_site,'apart_auction.php') or strpos($this_site,'apart_auction_result.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_bunyang.php'>분양/경매<br>정보</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_trend.php') or strpos($this_site,'apart_trend_newbunyang.php') or strpos($this_site,'apart_trend_nobunyang.php') or strpos($this_site,'apart_trend_nobunyangafter.php') or strpos($this_site,'apart_trend_InitialBunyangRate.php') or strpos($this_site,'apart_trend_buy_burden.php') or strpos($this_site,'apart_trend_customer_index.php') or strpos($this_site,'apart_trend_gongsa_pay.php') or strpos($this_site,'apart_trend_Rent_Rate.php') or strpos($this_site,'apart_trend_apart_meme.php') or strpos($this_site,'apart_trend_apart_rent.php') or strpos($this_site,'apart_trend_apart_price.php') or strpos($this_site,'apart_trend_apart_price_rent.php') or strpos($this_site,'apart_trend_meme_avg.php') or strpos($this_site,'apart_today_week_summary.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today_week_summary.php'><?php if (strpos($this_site,'officetel') or strpos($this_site,'billa')) { echo "거래량"; } else{ echo "부동산<br>통계";} ?></a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_todayhouseprice_rank_one_share.php') or strpos($this_site,'apart_todayhouseprice_rank_one.php') or strpos($this_site,'apart_todayhouseprice_rank_two.php') or strpos($this_site,'apart_todayhouseprice_rank_three.php') or strpos($this_site,'apart_todayhouseprice_rank_four.php') or strpos($this_site,'apart_todayhouseprice_rank_five.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값<br>랭킹</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_economy_inout_index.php') or strpos($this_site,'apart_economy_gdp_index.php') or strpos($this_site,'apart_economy_customer_mulga.php') or strpos($this_site,'apart_economy_seller_mulga.php') or strpos($this_site,'apart_economy_population_index.php') or strpos($this_site,'apart_economy_birth_index.php') or strpos($this_site,'apart_economy_population_count.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_economy_inout_index.php'>경제지표</a></center></th>
        <?php }else{?>
        <th style="background: <?php if (strpos($this_site,'apart_today.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_home.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매/전세 상세조회</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_bunyang.php') or strpos($this_site,'apart_auction.php') or strpos($this_site,'apart_auction_result.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_bunyang.php'>분양/경매정보</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_trend.php') or strpos($this_site,'apart_trend_newbunyang.php') or strpos($this_site,'apart_trend_nobunyang.php') or strpos($this_site,'apart_trend_nobunyangafter.php') or strpos($this_site,'apart_trend_InitialBunyangRate.php') or strpos($this_site,'apart_trend_buy_burden.php') or strpos($this_site,'apart_trend_customer_index.php') or strpos($this_site,'apart_trend_gongsa_pay.php') or strpos($this_site,'apart_trend_Rent_Rate.php') or strpos($this_site,'apart_trend_apart_meme.php') or strpos($this_site,'apart_trend_apart_rent.php') or strpos($this_site,'apart_trend_apart_price.php') or strpos($this_site,'apart_trend_apart_price_rent.php') or strpos($this_site,'apart_trend_meme_avg.php') or strpos($this_site,'apart_today_week_summary.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today_week_summary.php'><?php if (strpos($this_site,'officetel') or strpos($this_site,'billa')) { echo "거래량"; } else{ echo "부동산 통계";} ?></a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_todayhouseprice_rank_one_share.php') or strpos($this_site,'apart_todayhouseprice_rank_one.php') or strpos($this_site,'apart_todayhouseprice_rank_two.php') or strpos($this_site,'apart_todayhouseprice_rank_three.php') or strpos($this_site,'apart_todayhouseprice_rank_four.php') or strpos($this_site,'apart_todayhouseprice_rank_five.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값 랭킹</a></center></th>
        <th style="background: <?php if (strpos($this_site,'apart_economy_inout_index.php') or strpos($this_site,'apart_economy_gdp_index.php') or strpos($this_site,'apart_economy_customer_mulga.php') or strpos($this_site,'apart_economy_seller_mulga.php') or strpos($this_site,'apart_economy_population_index.php') or strpos($this_site,'apart_economy_birth_index.php') or strpos($this_site,'apart_economy_population_count.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_economy_inout_index.php'>경제지표</a></center></th>
        <?php }?>
      <?php } ?>
      
      
      </tr>
    </thead>
  </table>
<?php }?>

<?php
if (!(strpos($this_site,'officetel') or strpos($this_site,'billa'))) {
  if ($this_site=='/apart_trend.php' or $this_site=='/apart_trend_newbunyang.php' or $this_site=='/apart_trend_nobunyang.php' or $this_site=='/apart_trend_nobunyangafter.php' or $this_site=='/apart_trend_InitialBunyangRate.php' or $this_site=='/apart_trend_buy_burden.php' or $this_site=='/apart_trend_customer_index.php' or $this_site=='/apart_trend_gongsa_pay.php' or $this_site=='/apart_trend_Rent_Rate.php' or $this_site=='/apart_trend_apart_meme.php' or $this_site=='/apart_trend_apart_rent.php' or $this_site=='/apart_trend_apart_price.php' or $this_site=='/apart_trend_apart_price_rent.php' or $this_site=='/apart_trend_meme_avg.php' or $this_site=='/apart_today_week_summary.php') {
  ?>
  <table>
      <thead>
      <tr>
        <th style='background-color:<?php if ($this_site=='/apart_today_week_summary.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'>                    <center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_today_week_summary.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_today_week_summary.php'>최근한주<?php if($isMobile == "Y") { echo "<br>";}?> 트렌드</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_newbunyang.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'>         <center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_newbunyang.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_newbunyang.php'>신규분양</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_nobunyang.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'>          <center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_nobunyang.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_nobunyang.php'>미분양</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_nobunyangafter.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'>     <center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_nobunyangafter.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_nobunyangafter.php'>완공후 <?php if($isMobile == "Y") { echo "<br>";}?>미분양</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_InitialBunyangRate.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'> <center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_InitialBunyangRate.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_InitialBunyangRate.php'>초기 <?php if($isMobile == "Y") { echo "<br>";}?>분양률</a></center></th>
      </tr>
    </thead>
  </table>
  <table>
      <thead>
      <tr>
      <th style='background-color:<?php if ($this_site=='/apart_trend.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'>                    <center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend.php'>거래량</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_buy_burden.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_buy_burden.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_buy_burden.php'>주택구입<?php if($isMobile == "Y") { echo "<br>";}?>부담지수</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_customer_index.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_customer_index.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_customer_index.php'>부동산 <?php if($isMobile == "Y") { echo "<br>";}?>심리지수</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_gongsa_pay.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_gongsa_pay.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_gongsa_pay.php'>공사비<?php if($isMobile == "Y") { echo "<br>";}?> 지수</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_Rent_Rate.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_Rent_Rate.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_Rent_Rate.php'>아파트 <?php if($isMobile == "Y") { echo "<br>";}?>전세가율</a></center></th>
      </tr>
    </thead>
  </table>
  <table>
      <thead>
      <tr>
        <th style='background-color:<?php if ($this_site=='/apart_trend_apart_meme.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_apart_meme.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_apart_meme.php'>매매 <?php if($isMobile == "Y") { echo "<br>";}?>수급동향</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_apart_rent.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_apart_rent.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_apart_rent.php'>전세 <?php if($isMobile == "Y") { echo "<br>";}?>수급동향</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_apart_price.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_apart_price.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_apart_price.php'>매매 <?php if($isMobile == "Y") { echo "<br>";}?>가격지수</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_apart_price_rent.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_apart_price_rent.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_apart_price_rent.php'>전세 <?php if($isMobile == "Y") { echo "<br>";}?>가격지수</a></center></th>
        <th style='background-color:<?php if ($this_site=='/apart_trend_meme_avg.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site=='/apart_trend_meme_avg.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_trend_meme_avg.php'>매매 <?php if($isMobile == "Y") { echo "<br>";}?>평균가격</a></center></th>
      </tr>
    </thead>
  </table>
<?php }} ?>


<?php




if ($this_site_without_domain=='/apart_todayhouseprice_rank_one_share.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_one.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_two.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_three.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_four.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_five.php') {
?>
<table>
    <thead>
    <tr>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_one.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_one_share.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_one.php' or $this_site_without_domain=='/apart_todayhouseprice_rank_one_share.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_todayhouseprice_rank_one.php'>하락금액 <?php if($isMobile == "Y") { echo "<br>";}?>Top 100</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_two.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_two.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_todayhouseprice_rank_two.php'>하락률 <?php if($isMobile == "Y") { echo "<br>";}?>Top 100</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_three.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_three.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_todayhouseprice_rank_three.php'>가격 <?php if($isMobile == "Y") { echo "<br>";}?>Top 100</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_four.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_four.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_todayhouseprice_rank_four.php'>가격 하위 <?php if($isMobile == "Y") { echo "<br>";}?>Top 100</a></center></th>
      <?php if (!(strpos($this_site,'officetel') or strpos($this_site,'billa'))) { ?>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_five.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:20%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_todayhouseprice_rank_five.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_todayhouseprice_rank_five.php'>국평 지역 <?php if($isMobile == "Y") { echo "<br>";}?>Top 100</a></center></th>
      <?php }?>
    </tr>
  </thead>
</table>
<?php } ?>


<?php
if ($this_site_without_domain=='/apart_economy_inout_index.php' or $this_site_without_domain=='/apart_economy_gdp_index.php' or $this_site_without_domain=='/apart_economy_customer_mulga.php' or $this_site_without_domain=='/apart_economy_seller_mulga.php' or $this_site_without_domain=='/apart_economy_population_index.php' or $this_site_without_domain=='/apart_economy_birth_index.php' or $this_site_without_domain=='/apart_economy_population_count.php') {
?>
<table>
    <thead>
    <tr>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_economy_inout_index.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:25%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_economy_inout_index.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_economy_inout_index.php'>무역수지</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_economy_gdp_index.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:25%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_economy_gdp_index.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_economy_gdp_index.php'>경제성장률</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_economy_customer_mulga.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:25%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_economy_customer_mulga.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_economy_customer_mulga.php'>소비자물가지수</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_economy_seller_mulga.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:25%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_economy_seller_mulga.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_economy_seller_mulga.php'>생산자물가지수</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_economy_population_index.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:33%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_economy_population_index.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_economy_population_index.php'>경제활동인구</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_economy_birth_index.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:33%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_economy_birth_index.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_economy_birth_index.php'>출산율</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_economy_population_count.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:33%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_economy_population_count.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_economy_population_count.php'>총인구(추정)</a></center></th>
    </tr>
  </thead>
</table>
<?php } ?>


<?php




if (!strpos($this_site,'officetel') and ($this_site_without_domain=='/apart_auction.php' or $this_site_without_domain=='/apart_auction_result.php' or $this_site_without_domain=='/apart_bunyang.php')) {
?>
<table>
    <thead>
    <tr>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_bunyang.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:33%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_bunyang.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_bunyang.php'>아파트 분양정보</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_auction.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:33%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_auction.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_auction.php'>아파트 경매예정</a></center></th>
      <th style='background-color:<?php if ($this_site_without_domain=='/apart_auction_result.php'){ echo "rgba(0, 0, 0, 0.3);"; } else{ echo "rgba(255, 255, 255, 0.8);";} ?> width:34%; padding-top:15px; padding-bottom:10px;'><center><a style='font-size: 20px; color:<?php if ($this_site_without_domain=='/apart_auction_result.php'){ echo "white;";}else{ echo "black;";}?> text-decoration: none;' href='./apart_auction_result.php'>아파트 경매결과 </a></center></th>
    </tr>
  </thead>
</table>
<?php } ?>


<br>
<center>
<a href="./apart_today.php"><img style="vertical-align: middle;" width="100", height="100" src="./todayhouseprice2.png"></a>
<span style="font-size:60px; vertical-align: middle; font-family: nanumpen;">&nbsp;&nbsp;오늘집값</span>
</center>
<br>

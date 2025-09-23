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

<?php
$isOfficetel = strpos($this_site, 'officetel') !== false;
$isBilla = strpos($this_site, 'billa') !== false;
$isListOrNews = ($this_site == '/list.php' || $this_site == '/apart_news.php');

if (!function_exists('thp_is_active')) {
    function thp_is_active($keywords, $current, $currentWithoutDomain) {
        if (!is_array($keywords)) {
            $keywords = array($keywords);
        }
        foreach ($keywords as $keyword) {
            if ($keyword === '') {
                continue;
            }
            if (strpos($current, $keyword) !== false || strpos($currentWithoutDomain, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('thp_render_navigation')) {
    function thp_render_navigation($items, $isMobile, $modifier = 'nav-block--primary') {
        if (empty($items)) {
            return;
        }
        $classes = 'nav-block';
        if (!empty($modifier)) {
            $classes .= ' ' . $modifier;
        }
        echo '<nav class="' . $classes . '">';
        echo '<ul class="nav-block__list">';
        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }
            $labelData = isset($item['label']) ? $item['label'] : '';
            if ($isMobile === 'Y' && isset($item['mobileLabel'])) {
                $labelData = $item['mobileLabel'];
            }
            if (is_array($labelData)) {
                $parts = array();
                foreach ($labelData as $part) {
                    $parts[] = htmlspecialchars($part, ENT_QUOTES, 'UTF-8');
                }
                $label = implode('<br>', $parts);
            } else {
                $label = htmlspecialchars($labelData, ENT_QUOTES, 'UTF-8');
            }
            $href = isset($item['href']) ? $item['href'] : '';
            $isActive = !empty($item['active']);
            $itemClasses = 'nav-block__item';
            if ($isActive) {
                $itemClasses .= ' nav-block__item--active';
            }
            echo '<li class="' . $itemClasses . '">';
            if (!empty($href)) {
                echo '<a class="nav-block__link" href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '">' . $label . '</a>';
            } else {
                echo '<span class="nav-block__link nav-block__link--static">' . $label . '</span>';
            }
            echo '</li>';
        }
        echo '</ul>';
        echo '</nav>';
    }
}

$propertySwitchItems = array();
if ($isOfficetel) {
    $propertySwitchItems[] = array('label' => '아파트', 'href' => '../apart_today.php?user_update=true', 'active' => false);
    $propertySwitchItems[] = array('label' => '오피스텔', 'href' => './apart_today.php?user_update=true', 'active' => true);
    $propertySwitchItems[] = array('label' => '빌라', 'href' => '../billa/apart_today.php?user_update=true', 'active' => false);
} elseif ($isBilla) {
    $propertySwitchItems[] = array('label' => '아파트', 'href' => '../apart_today.php?user_update=true', 'active' => false);
    $propertySwitchItems[] = array('label' => '오피스텔', 'href' => '../officetel/apart_today.php?user_update=true', 'active' => false);
    $propertySwitchItems[] = array('label' => '빌라', 'href' => './apart_today.php?user_update=true', 'active' => true);
} else {
    if ($isListOrNews) {
        $propertySwitchItems[] = array('label' => '아파트', 'href' => '../apart_today.php?user_update=true', 'active' => false);
    } else {
        $propertySwitchItems[] = array('label' => '아파트', 'href' => './apart_today.php?user_update=true', 'active' => true);
    }
    $propertySwitchItems[] = array('label' => '오피스텔', 'href' => '../officetel/apart_today.php?user_update=true', 'active' => false);
    $propertySwitchItems[] = array('label' => '빌라', 'href' => '../billa/apart_today.php?user_update=true', 'active' => false);
}

$trendKeywords = array(
    'apart_trend.php',
    'apart_trend_newbunyang.php',
    'apart_trend_nobunyang.php',
    'apart_trend_nobunyangafter.php',
    'apart_trend_InitialBunyangRate.php',
    'apart_trend_buy_burden.php',
    'apart_trend_customer_index.php',
    'apart_trend_gongsa_pay.php',
    'apart_trend_Rent_Rate.php',
    'apart_trend_apart_meme.php',
    'apart_trend_apart_rent.php',
    'apart_trend_apart_price.php',
    'apart_trend_apart_price_rent.php',
    'apart_trend_meme_avg.php',
    'apart_today_week_summary.php'
);

$rankKeywords = array(
    'apart_todayhouseprice_rank_one.php',
    'apart_todayhouseprice_rank_one_share.php',
    'apart_todayhouseprice_rank_two.php',
    'apart_todayhouseprice_rank_three.php',
    'apart_todayhouseprice_rank_four.php',
    'apart_todayhouseprice_rank_five.php'
);

$economyKeywords = array(
    'apart_economy_inout_index.php',
    'apart_economy_gdp_index.php',
    'apart_economy_customer_mulga.php',
    'apart_economy_seller_mulga.php',
    'apart_economy_population_index.php',
    'apart_economy_birth_index.php',
    'apart_economy_population_count.php'
);

$bunyangKeywords = array(
    'apart_bunyang.php',
    'apart_auction.php',
    'apart_auction_result.php'
);

$primaryNavItems = array(
    array(
        'label' => '금일 신규등록',
        'mobileLabel' => array('금일', '신규등록'),
        'href' => './apart_today.php?user_update=true',
        'active' => thp_is_active(array('apart_today.php'), $this_site, $this_site_without_domain)
    ),
    array(
        'label' => $isBilla ? '매매 상세조회' : '매매/전세 상세조회',
        'mobileLabel' => $isBilla ? array('매매', '상세조회') : array('매매/전세', '상세조회'),
        'href' => './apart_home.php?user_update=true',
        'active' => thp_is_active(array('apart_home.php'), $this_site, $this_site_without_domain)
    )
);

if ($isBilla) {
    $primaryNavItems[] = array(
        'label' => '전월세 상세조회',
        'mobileLabel' => array('전월세', '상세조회'),
        'href' => './apart_home_rent.php?user_update=true',
        'active' => thp_is_active(array('apart_home_rent.php'), $this_site, $this_site_without_domain)
    );
} elseif ($isOfficetel) {
    $primaryNavItems[] = array(
        'label' => '분양정보',
        'mobileLabel' => array('분양', '정보'),
        'href' => './apart_bunyang.php',
        'active' => thp_is_active(array('apart_bunyang.php'), $this_site, $this_site_without_domain)
    );
} else {
    $primaryNavItems[] = array(
        'label' => '분양/경매정보',
        'mobileLabel' => array('분양/경매', '정보'),
        'href' => './apart_bunyang.php',
        'active' => thp_is_active($bunyangKeywords, $this_site, $this_site_without_domain)
    );
}

$primaryNavItems[] = array(
    'label' => ($isOfficetel || $isBilla) ? '거래량' : '부동산 통계',
    'mobileLabel' => ($isOfficetel || $isBilla) ? array('거래량') : array('부동산', '통계'),
    'href' => './apart_trend.php',
    'active' => thp_is_active($trendKeywords, $this_site, $this_site_without_domain)
);

$primaryNavItems[] = array(
    'label' => '오늘집값 랭킹',
    'mobileLabel' => array('오늘집값', '랭킹'),
    'href' => './apart_todayhouseprice_rank_one.php',
    'active' => thp_is_active($rankKeywords, $this_site, $this_site_without_domain)
);

$primaryNavItems[] = array(
    'label' => '경제지표',
    'mobileLabel' => array('경제', '지표'),
    'href' => './apart_economy_inout_index.php',
    'active' => thp_is_active($economyKeywords, $this_site, $this_site_without_domain)
);

$secondaryNavGroups = array();

if (!$isOfficetel && !$isBilla && thp_is_active($trendKeywords, $this_site, $this_site_without_domain)) {
    $secondaryNavGroups[] = array(
        'modifier' => 'nav-block--secondary',
        'items' => array(
            array(
                'label' => '최근한주 트렌드',
                'mobileLabel' => array('최근한주', '트렌드'),
                'href' => './apart_today_week_summary.php',
                'active' => thp_is_active(array('apart_today_week_summary.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '미분양',
                'mobileLabel' => array('미분양'),
                'href' => './apart_trend_nobunyang.php',
                'active' => thp_is_active(array('apart_trend_nobunyang.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '완공후 미분양',
                'mobileLabel' => array('완공후', '미분양'),
                'href' => './apart_trend_nobunyangafter.php',
                'active' => thp_is_active(array('apart_trend_nobunyangafter.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '초기 분양률',
                'mobileLabel' => array('초기', '분양률'),
                'href' => './apart_trend_InitialBunyangRate.php',
                'active' => thp_is_active(array('apart_trend_InitialBunyangRate.php'), $this_site, $this_site_without_domain)
            )
        )
    );

    $secondaryNavGroups[] = array(
        'modifier' => 'nav-block--secondary',
        'items' => array(
            array(
                'label' => '거래량',
                'mobileLabel' => array('거래량'),
                'href' => './apart_trend.php',
                'active' => thp_is_active(array('apart_trend.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '주택구입 부담지수',
                'mobileLabel' => array('주택구입', '부담지수'),
                'href' => './apart_trend_buy_burden.php',
                'active' => thp_is_active(array('apart_trend_buy_burden.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '부동산 심리지수',
                'mobileLabel' => array('부동산', '심리지수'),
                'href' => './apart_trend_customer_index.php',
                'active' => thp_is_active(array('apart_trend_customer_index.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '공사비 지수',
                'mobileLabel' => array('공사비', '지수'),
                'href' => './apart_trend_gongsa_pay.php',
                'active' => thp_is_active(array('apart_trend_gongsa_pay.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '아파트 전세가율',
                'mobileLabel' => array('아파트', '전세가율'),
                'href' => './apart_trend_Rent_Rate.php',
                'active' => thp_is_active(array('apart_trend_Rent_Rate.php'), $this_site, $this_site_without_domain)
            )
        )
    );

    $secondaryNavGroups[] = array(
        'modifier' => 'nav-block--secondary',
        'items' => array(
            array(
                'label' => '매매 수급동향',
                'mobileLabel' => array('매매', '수급동향'),
                'href' => './apart_trend_apart_meme.php',
                'active' => thp_is_active(array('apart_trend_apart_meme.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '전세 수급동향',
                'mobileLabel' => array('전세', '수급동향'),
                'href' => './apart_trend_apart_rent.php',
                'active' => thp_is_active(array('apart_trend_apart_rent.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '매매 가격지수',
                'mobileLabel' => array('매매', '가격지수'),
                'href' => './apart_trend_apart_price.php',
                'active' => thp_is_active(array('apart_trend_apart_price.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '전세 가격지수',
                'mobileLabel' => array('전세', '가격지수'),
                'href' => './apart_trend_apart_price_rent.php',
                'active' => thp_is_active(array('apart_trend_apart_price_rent.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '매매 평균가격',
                'mobileLabel' => array('매매', '평균가격'),
                'href' => './apart_trend_meme_avg.php',
                'active' => thp_is_active(array('apart_trend_meme_avg.php'), $this_site, $this_site_without_domain)
            )
        )
    );
}

if (thp_is_active($rankKeywords, $this_site, $this_site_without_domain)) {
    $rankItems = array(
        array(
            'label' => '하락금액 Top 100',
            'mobileLabel' => array('하락금액', 'Top 100'),
            'href' => './apart_todayhouseprice_rank_one.php',
            'active' => thp_is_active(array('apart_todayhouseprice_rank_one.php', 'apart_todayhouseprice_rank_one_share.php'), $this_site, $this_site_without_domain)
        ),
        array(
            'label' => '하락률 Top 100',
            'mobileLabel' => array('하락률', 'Top 100'),
            'href' => './apart_todayhouseprice_rank_two.php',
            'active' => thp_is_active(array('apart_todayhouseprice_rank_two.php'), $this_site, $this_site_without_domain)
        ),
        array(
            'label' => '가격 Top 100',
            'mobileLabel' => array('가격', 'Top 100'),
            'href' => './apart_todayhouseprice_rank_three.php',
            'active' => thp_is_active(array('apart_todayhouseprice_rank_three.php'), $this_site, $this_site_without_domain)
        ),
        array(
            'label' => '가격 하위 Top 100',
            'mobileLabel' => array('가격 하위', 'Top 100'),
            'href' => './apart_todayhouseprice_rank_four.php',
            'active' => thp_is_active(array('apart_todayhouseprice_rank_four.php'), $this_site, $this_site_without_domain)
        )
    );

    if (!$isOfficetel && !$isBilla) {
        $rankItems[] = array(
            'label' => '국평 지역 Top 100',
            'mobileLabel' => array('국평 지역', 'Top 100'),
            'href' => './apart_todayhouseprice_rank_five.php',
            'active' => thp_is_active(array('apart_todayhouseprice_rank_five.php'), $this_site, $this_site_without_domain)
        );
    }

    $secondaryNavGroups[] = array(
        'modifier' => 'nav-block--secondary nav-block--rank',
        'items' => $rankItems
    );
}

if (thp_is_active($economyKeywords, $this_site, $this_site_without_domain)) {
    $secondaryNavGroups[] = array(
        'modifier' => 'nav-block--secondary nav-block--economy',
        'items' => array(
            array(
                'label' => '무역수지',
                'mobileLabel' => array('무역수지'),
                'href' => './apart_economy_inout_index.php',
                'active' => thp_is_active(array('apart_economy_inout_index.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '경제성장률',
                'mobileLabel' => array('경제성장률'),
                'href' => './apart_economy_gdp_index.php',
                'active' => thp_is_active(array('apart_economy_gdp_index.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '소비자물가지수',
                'mobileLabel' => array('소비자', '물가지수'),
                'href' => './apart_economy_customer_mulga.php',
                'active' => thp_is_active(array('apart_economy_customer_mulga.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '생산자물가지수',
                'mobileLabel' => array('생산자', '물가지수'),
                'href' => './apart_economy_seller_mulga.php',
                'active' => thp_is_active(array('apart_economy_seller_mulga.php'), $this_site, $this_site_without_domain)
            )
        )
    );

    $secondaryNavGroups[] = array(
        'modifier' => 'nav-block--secondary nav-block--economy',
        'items' => array(
            array(
                'label' => '경제활동인구',
                'mobileLabel' => array('경제활동', '인구'),
                'href' => './apart_economy_population_index.php',
                'active' => thp_is_active(array('apart_economy_population_index.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '출산율',
                'mobileLabel' => array('출산율'),
                'href' => './apart_economy_birth_index.php',
                'active' => thp_is_active(array('apart_economy_birth_index.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '총인구(추정)',
                'mobileLabel' => array('총인구', '(추정)'),
                'href' => './apart_economy_population_count.php',
                'active' => thp_is_active(array('apart_economy_population_count.php'), $this_site, $this_site_without_domain)
            )
        )
    );
}

if (!$isOfficetel && thp_is_active($bunyangKeywords, $this_site, $this_site_without_domain)) {
    $secondaryNavGroups[] = array(
        'modifier' => 'nav-block--secondary nav-block--bunyang',
        'items' => array(
            array(
                'label' => '아파트 분양정보',
                'mobileLabel' => array('아파트', '분양정보'),
                'href' => './apart_bunyang.php',
                'active' => thp_is_active(array('apart_bunyang.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '아파트 경매예정',
                'mobileLabel' => array('아파트', '경매예정'),
                'href' => './apart_auction.php',
                'active' => thp_is_active(array('apart_auction.php'), $this_site, $this_site_without_domain)
            ),
            array(
                'label' => '아파트 경매결과',
                'mobileLabel' => array('아파트', '경매결과'),
                'href' => './apart_auction_result.php',
                'active' => thp_is_active(array('apart_auction_result.php'), $this_site, $this_site_without_domain)
            )
        )
    );
}
?>
<header class="site-header">
  <div class="site-header__shell">
    <div class="site-header__brand">
      <a class="site-header__logo" href="./apart_today.php">
        <img src="./todayhouseprice2.png" alt="오늘집값 로고" width="72" height="72" loading="lazy" />
        <div class="site-header__logo-text-group">
          <span class="site-header__logo-text">오늘집값</span>
          <span class="site-header__logo-subtext">REAL ESTATE DASHBOARD</span>
        </div>
      </a>
    </div>
    <div class="site-header__actions">
      <?php if(!$userid){ ?>
      <div class="site-header__auth">
        <a class="button button--primary" href="./login.php?site=<?=$this_site_for_login?>">로그인</a>
        <?php if($isMobile=='N'){ ?>
        <span class="site-header__hint">즐겨찾기 기능 제공</span>
        <?php } ?>
      </div>
      <?php } else { ?>
      <div class="site-header__auth site-header__auth--logged">
        <span class="site-header__welcome"><?=htmlspecialchars($userid, ENT_QUOTES, 'UTF-8')?>님</span>
        <a class="button button--ghost" href="./apart_favorite.php">즐겨찾기</a>
        <a class="button button--ghost" href="./logout.php">로그아웃</a>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="site-header__utilities">
    <?php if(!$userid){ ?>
    <a class="site-header__utility-link" href="http://todayhouseprice.com/info.php">텔레그램</a>
    <a class="site-header__utility-link" href="http://todayhouseprice.com/guide.php">사용가이드</a>
    <?php } ?>
    <a class="site-header__utility-link" href="http://todayhouseprice.com/list.php">자유게시판</a>
    <a class="site-header__utility-link" href="http://todayhouseprice.com/apart_news.php">부동산뉴스</a>
  </div>
  <div class="market-banner market-indicators-wrapper">
    <div class="market-banner__items market-indicators">
      <a class="market-banner__item market-indicator" href="https://m.search.naver.com/search.naver?where=m&sm=mtb_etc&mra=blJH&qvt=0&query=%EB%8C%80%ED%95%9C%EB%AF%BC%EA%B5%AD%20%EC%A4%91%EC%95%99%EC%9D%80%ED%96%89%20%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC" target="_blank" rel="noopener noreferrer">
        <span class="market-indicator__label">기준금리</span>
        <span class="market-indicator__value"><?=htmlspecialchars($row_today['gumri_korea'], ENT_QUOTES, 'UTF-8')?></span>
        <span class="market-indicator__icon" aria-hidden="true">🇰🇷</span>
      </a>
      <a class="market-banner__item market-indicator" href="https://m.search.naver.com/p/crd/rd?m=1&px=736&py=298&sx=736&sy=298&p=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&q=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&ie=utf8&rev=1&ssc=tab.m.all&f=m&w=m&s=LoFy%2FTw7JT27hrVNgxlLxg%3D%3D&time=1672725258737&abt=%5B%7B%22eid%22%3A%22PWL-AREA-EX%22%2C%22vid%22%3A%222%22%7D%2C%7B%22eid%22%3A%22SBR1%22%2C%22vid%22%3A%22634%22%7D%5D&a=nco_xgr*3.list&r=1&i=88211u5i_000000000000&u=https%3A%2F%2Fm.search.naver.com%2Fsearch.naver%3Fwhere%3Dm%26sm%3Dmtb_etc%26mra%3DblJH%26qvt%3D0%26query%3D%25EB%25AF%25B8%25EA%25B5%25AD%2520%25EC%25A4%2591%25EC%2595%2599%25EC%259D%2580%25ED%2596%2589%2520%25EA%25B8%2580%25EC%25A4%2580%25EA%25B8%2588%25EB%25A6%25AC&cr=1" target="_blank" rel="noopener noreferrer">
        <span class="market-indicator__label">US Base Rate</span>
        <span class="market-indicator__value"><?=htmlspecialchars($row_today['gumri_usa'], ENT_QUOTES, 'UTF-8')?></span>
        <span class="market-indicator__icon" aria-hidden="true">🇺🇸</span>
      </a>
      <a class="market-banner__item market-indicator" href="https://m.search.naver.com/search.naver?sm=mtb_hty.top&where=m&oquery=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&tqi=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&query=%ED%99%98%EC%9C%A8" target="_blank" rel="noopener noreferrer">
        <span class="market-indicator__label">환율</span>
        <span class="market-indicator__value"><?=htmlspecialchars($row_today['dallor'], ENT_QUOTES, 'UTF-8')?>원</span>
        <span class="market-indicator__icon" aria-hidden="true">💱</span>
      </a>
      <a class="market-banner__item market-indicator" href="https://finance.naver.com/sise/" target="_blank" rel="noopener noreferrer">
        <span class="market-indicator__label">코스피</span>
        <span class="market-indicator__value"><?=htmlspecialchars($row_today['kospi'], ENT_QUOTES, 'UTF-8')?></span>
        <span class="market-indicator__icon" aria-hidden="true">📈</span>
      </a>
      <a class="market-banner__item market-indicator" href="https://finance.naver.com/sise/" target="_blank" rel="noopener noreferrer">
        <span class="market-indicator__label">코스닥</span>
        <span class="market-indicator__value"><?=htmlspecialchars($row_today['kosdaq'], ENT_QUOTES, 'UTF-8')?></span>
        <span class="market-indicator__icon" aria-hidden="true">📊</span>
      </a>
    </div>
    <div class="market-banner__updated market-indicators__update">업데이트 <?=htmlspecialchars($row_today['update_date'], ENT_QUOTES, 'UTF-8')?></div>
  </div>
  <?php thp_render_navigation($propertySwitchItems, $isMobile, 'nav-block--switch'); ?>
  <?php thp_render_navigation($primaryNavItems, $isMobile, 'nav-block--primary'); ?>
</header>
<?php
foreach ($secondaryNavGroups as $group) {
    $modifier = isset($group['modifier']) ? $group['modifier'] : 'nav-block--secondary';
    $items = isset($group['items']) ? $group['items'] : array();
    thp_render_navigation($items, $isMobile, $modifier);
}
?>
<section class="site-hero">
  <a class="site-hero__brand" href="./apart_today.php">
    <img src="./todayhouseprice2.png" alt="오늘집값 바로가기" width="96" height="96" loading="lazy" />
    <div class="site-hero__copy">
      <h1 class="site-hero__title">오늘의 부동산 흐름을 한눈에</h1>
      <p class="site-hero__subtitle">당일 등록된 매매·전세 정보부터 통계, 경제지표까지 깔끔하게 확인하세요.</p>
    </div>
  </a>
</section>


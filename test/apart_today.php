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
$is_count = false;
if (!isset($_COOKIE["todayhouseprice"])) {
    setcookie("todayhouseprice", "count", time() + 60 * 60);
    $is_count = true;
}
if ($is_count) {
  $rs = mysqli_query($Conn, "select count(1) as cnt from molit_visit_count where ymd = '$today' and count_type = 'apart_today';");
  $row = mysqli_fetch_assoc($rs);
  if($row['cnt']==0) {
    mysqli_query($Conn, "insert into molit_visit_count (ymd, count, count_type) values('$today',1,'apart_today');");
  }else{
    mysqli_query($Conn, "update molit_visit_count set count = count + 1 where ymd = '$today' and count_type = 'apart_today';");
  }
}
/////////////////////조회수//////////////////////////

/////////////////////금일 지수//////////////////////////
$rs_today = mysqli_query($Conn, "select dallor, gumri_usa, gumri_korea, kospi, kosdaq, substr(update_date,1,19) as update_date from today_index");
$row_today = mysqli_fetch_assoc($rs_today);
/////////////////////금일 지수//////////////////////////
$user_update = $_REQUEST["user_update"];
$area_main_name = $_REQUEST["area_main_name"];
$area_sub_name = $_REQUEST["area_sub_name"];
$insert_date = $_REQUEST["insert_date"];
$type = $_REQUEST["type"];

$size1 = $_REQUEST["size1"];
$size2 = $_REQUEST["size2"];
$size3 = $_REQUEST["size3"];
$size4 = $_REQUEST["size4"];

$before1Day = date("Y-m-d", strtotime($today." -1 day"));
$before2Day = date("Y-m-d", strtotime($today." -2 day"));
$before3Day = date("Y-m-d", strtotime($today." -3 day"));
$before4Day = date("Y-m-d", strtotime($today." -4 day"));
$before5Day = date("Y-m-d", strtotime($today." -5 day"));
$before6Day = date("Y-m-d", strtotime($today." -6 day"));
$before7Day = date("Y-m-d", strtotime($today." -7 day"));

$this_hour = date('H');

if ($area_main_name==""){
  $size1 = "true";
  $size2 = "true";
  $size3 = "true";
  $size4 = "true";
}

if ($insert_date == ""){
  if($this_hour=="00" || $this_hour=="01" || $this_hour=="02"
  || $this_hour=="03" || $this_hour=="04" || $this_hour=="05" || $this_hour=="06"){
    $insert_date = date('Y-m-d', $_SERVER['REQUEST_TIME']-86400);
  }else{
    $insert_date = date("Y-m-d");
  }
  if($userid){
    $user_update = "true";
  }
}

if($userid && $user_update=="true"){
  $sql_select_user = "
    select area_main_name, size1, size2, size3, size4 from user where id = '$userid'
  ";
  $rs_user = mysqli_query($Conn, $sql_select_user);
  $row_user = mysqli_fetch_assoc($rs_user);

  $area_main_name = $row_user["area_main_name"];
  $size1 = $row_user["size1"];
  $size2 = $row_user["size2"];
  $size3 = $row_user["size3"];
  $size4 = $row_user["size4"];
}

$size1_text = "";
$size2_text = "";
$size3_text = "";
$size4_text = "";

if($size1=="true"){
  $size1_text = "or cast(today.size as DECIMAL(10,5)) <= 40";
}
if($size2=="true"){
  $size2_text = "or (cast(today.size as DECIMAL(10,5)) > 40 and cast(today.size as DECIMAL(10,5)) <= 60)";
}
if($size3=="true"){
  $size3_text = "or (cast(today.size as DECIMAL(10,5)) > 60 and cast(today.size as DECIMAL(10,5)) <= 85)";
}
if($size4=="true"){
  $size4_text = "or cast(today.size as DECIMAL(10,5)) > 85";
}


$weekend = date("w");

if ($area_main_name==""){
  $area_main_name = "전체";
}
//$area_main_name = "전체";

if ($area_sub_name!=""){
  $area_sub_name_text = "and replace(replace(today.area_name, concat(today.area_main_name,' '),''),' ','') = '$area_sub_name'";
}

//SELECT replace(area_sub_name,' ','') as area_sub_name FROM molit_area_info where area_main_name = '$area_main_name' order by area_sub_name

if ($type==""){
  $type = "all";
}

if ( $area_main_name== '충청도') {
  $area_main_name_text = "today.area_main_name in ('충청북도','충청남도')";
}elseif ( $area_main_name== '경상도' ) {
  $area_main_name_text = "today.area_main_name in ('경상북도','경상남도')";
}elseif ( $area_main_name== '전라도' ) {
  $area_main_name_text = "today.area_main_name in ('전라북도','전라남도')";
}elseif ( $area_main_name== '전체' ){
  $area_main_name_text = "1=1";
}else{
  $area_main_name_text = "today.area_main_name = '".$area_main_name."'";
}




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
      AND ROUND(CAST(today.size as DECIMAL(10,5))) = rent.size
      where $area_main_name_text
      and today.insert_date = '$insert_date'
      $area_sub_name_text
      and (1!=1 $size1_text $size2_text $size3_text $size4_text)
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 100;
      ";

$sql_rent = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.dong ,
      	today.apart_name,
      	today.size,
      	today.stair,
      	today.rent_price ,
      	today.month_price ,
      	today.TYPE,
      	today.STATUS ,
      	today.max_price,
      	today.max_price_date,
      	today.min_price,
      	today.min_price_date,
      	today.last_price,
      	today.last_price_date,
      	ROUND((CAST(today.rent_price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2) as price_last,
        case
  			  when CAST(today.rent_price as DECIMAL(10,5)) > CAST(today.last_price as DECIMAL(10,5))
  			  then ROUND(((CAST(today.rent_price as DECIMAL(10,5))/CAST(today.last_price as DECIMAL(10,5))*100)-100),0)
  			  when CAST(today.rent_price as DECIMAL(10,5)) < CAST(today.last_price as DECIMAL(10,5))
  			  then ROUND(100-(CAST(today.rent_price as DECIMAL(10,5))/CAST(today.last_price as DECIMAL(10,5)))*100,0)
			    ELSE 0 END AS percent,
          ROUND((CAST(today.rent_price as DECIMAL(10,5)) - CAST(today.max_price as DECIMAL(10,5))),2) as price_max,
          ROUND(100-(CAST(today.rent_price as DECIMAL(10,5))/CAST(today.max_price as DECIMAL(10,5)))*100,0) AS max_percent,
        IFNULL(meme.last_price,0) AS meme_last_price,
			  IFNULL(meme.max_price,0) AS meme_max_price,
			  IFNULL(meme.min_price,0) AS meme_min_price
      from molit_today_update_rent today LEFT join molit_max_min_all_group meme
      ON today.area_main_name = meme.area_main_name
      AND today.dong = meme.dong
      AND today.apart_name = meme.apart_name
      AND ROUND(CAST(today.size as DECIMAL(10,5))) = meme.size
      where $area_main_name_text
      and today.insert_date = '$insert_date'
      and today.month_price = '0'
      $area_sub_name_text
      and (1!=1 $size1_text $size2_text $size3_text $size4_text)
      and today.status is not null
      ORDER BY ABS(ROUND((CAST(today.rent_price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 100;
      ";

$sql_favorite = "
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
      AND ROUND(CAST(today.size as DECIMAL(10,5))) = rent.size
    where today.insert_date = '$insert_date'
    and (today.area_main_name, today.doing, today.apart_name, ROUND(CAST(today.size as DECIMAL(10,5)))) in (select area_main_name, dong, apart_name, size from molit_favorite where userid = '$userid')
    and today.status is not null
    AND !(today.last_price = '0' AND today.max_price != '0')
    ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
    limit 100;
    ";
$sql_favorite_rent = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.dong ,
      	today.apart_name,
      	today.size,
      	today.stair,
      	today.rent_price ,
      	today.month_price ,
      	today.TYPE,
      	today.STATUS ,
      	today.max_price,
      	today.max_price_date,
      	today.min_price,
      	today.min_price_date,
      	today.last_price,
      	today.last_price_date,
      	ROUND((CAST(today.rent_price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2) as price_last,
        case
  			  when CAST(today.rent_price as DECIMAL(10,5)) > CAST(today.last_price as DECIMAL(10,5))
  			  then ROUND(((CAST(today.rent_price as DECIMAL(10,5))/CAST(today.last_price as DECIMAL(10,5))*100)-100),0)
  			  when CAST(today.rent_price as DECIMAL(10,5)) < CAST(today.last_price as DECIMAL(10,5))
  			  then ROUND(100-(CAST(today.rent_price as DECIMAL(10,5))/CAST(today.last_price as DECIMAL(10,5)))*100,0)
			    ELSE 0 END AS percent,
          ROUND((CAST(today.rent_price as DECIMAL(10,5)) - CAST(today.max_price as DECIMAL(10,5))),2) as price_max,
          ROUND(100-(CAST(today.rent_price as DECIMAL(10,5))/CAST(today.max_price as DECIMAL(10,5)))*100,0) AS max_percent,
        IFNULL(meme.last_price,0) AS meme_last_price,
        IFNULL(meme.max_price,0) AS meme_max_price,
        IFNULL(meme.min_price,0) AS meme_min_price
      from molit_today_update_rent today LEFT join molit_max_min_all_group meme
      ON today.area_main_name = meme.area_main_name
      AND today.dong = meme.dong
      AND today.apart_name = meme.apart_name
      AND ROUND(CAST(today.size as DECIMAL(10,5))) = meme.size
      where today.insert_date = '$insert_date'
      and today.month_price = '0'
      and (today.area_main_name, today.dong, today.apart_name, ROUND(CAST(today.size as DECIMAL(10,5)))) in (select area_main_name, dong, apart_name, size from molit_favorite where userid = '$userid')
      and today.status is not null
      ORDER BY ABS(ROUND((CAST(today.rent_price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 100;
      ";

$sql_status = "
  SELECT
      (SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) and status is not null) AS total,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='신고가' and status is not null GROUP BY STATUS),0) AS upup,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='상승' and status is not null GROUP BY STATUS),0) AS up,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='동일' and status is not null GROUP BY STATUS),0) AS same,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='하락' and status is not null GROUP BY STATUS),0) AS down,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='신저가' and status is not null GROUP BY STATUS),0) AS downdown,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='신규' and status is not null GROUP BY STATUS),0) AS new,
      (SELECT SUM(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) and status is not null AND STATUS IN ('신고가','상승')) AS up_price,
      (SELECT SUM(ROUND((CAST(last_price as DECIMAL(10,5)) - CAST(price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) and status is not null AND STATUS IN ('신저가','하락')) AS down_price
      FROM DUAL;
";

$sql_status_rent = "
  SELECT
      (SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) and status is not null) AS total,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='신고가' and status is not null GROUP BY STATUS),0) AS upup,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='상승' and status is not null GROUP BY STATUS),0) AS up,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='동일' and status is not null GROUP BY STATUS),0) AS same,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='하락' and status is not null GROUP BY STATUS),0) AS down,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='신저가' and status is not null GROUP BY STATUS),0) AS downdown,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) AND STATUS ='신규' and status is not null GROUP BY STATUS),0) AS new,
      (SELECT SUM(ROUND((CAST(rent_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2))from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) and status is not null AND STATUS IN ('신고가','상승')) AS up_price,
      (SELECT SUM(ROUND((CAST(last_price as DECIMAL(10,5)) - CAST(rent_price as DECIMAL(10,5))),2))from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $area_sub_name_text and (1!=1 $size1_text $size2_text $size3_text $size4_text) and status is not null AND STATUS IN ('신저가','하락')) AS down_price
      FROM DUAL;
";




//조회수 출력
$sql_count = "
select
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count),0),0) AS total,
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count WHERE YMD = '$today'),0),0) AS today
FROM DUAL;
";
$rs_count = mysqli_query($Conn, $sql_count);
$row_count = mysqli_fetch_assoc($rs_count);


$rs = mysqli_query($Conn, $sql);
$rs_count = mysqli_num_rows($rs);
while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

$rs_rent = mysqli_query($Conn, $sql_rent);
$rs_rent_count = mysqli_num_rows($rs_rent);
while ( $row_rent = mysqli_fetch_assoc($rs_rent) ) {
    $rows_rent[] = $row_rent;
}

$rs_favorite = mysqli_query($Conn, $sql_favorite);
$rs_favorite_count = mysqli_num_rows($rs_favorite);
while ( $row_favorite = mysqli_fetch_assoc($rs_favorite) ) {
    $rows_favorite[] = $row_favorite;
}

$rs_favorite_rent = mysqli_query($Conn, $sql_favorite_rent);
$rs_favorite_rent_count = mysqli_num_rows($rs_favorite_rent);
while ( $row_favorite_rent = mysqli_fetch_assoc($rs_favorite_rent) ) {
    $rows_favorite_rent[] = $row_favorite_rent;
}

$rs_status = mysqli_query($Conn, $sql_status);
$row_status = mysqli_fetch_assoc($rs_status);
$rows_status[] = $row_status;

$rs_status_rent = mysqli_query($Conn, $sql_status_rent);
$row_status_rent = mysqli_fetch_assoc($rs_status_rent);
$rows_status_rent[] = $row_status_rent;

?>
<?php
include_once "./top_page.php";
?>



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



<select style="width:200px;font-size:30px;" name="day" id="day" onchange="apart_day_list(this)">
<option value=<?php echo $today; ?> <?php if ($insert_date==$today){echo 'selected';} ?>><?php echo $today; ?></option>
<option value=<?php echo $before1Day; ?> <?php if ($insert_date==$before1Day){echo 'selected';} ?>><?php echo $before1Day; ?></option>
<option value=<?php echo $before2Day; ?> <?php if ($insert_date==$before2Day){echo 'selected';} ?>><?php echo $before2Day; ?></option>
<option value=<?php echo $before3Day; ?> <?php if ($insert_date==$before3Day){echo 'selected';} ?>><?php echo $before3Day; ?></option>
<option value=<?php echo $before4Day; ?> <?php if ($insert_date==$before4Day){echo 'selected';} ?>><?php echo $before4Day; ?></option>
<option value=<?php echo $before5Day; ?> <?php if ($insert_date==$before5Day){echo 'selected';} ?>><?php echo $before5Day; ?></option>
<option value=<?php echo $before6Day; ?> <?php if ($insert_date==$before6Day){echo 'selected';} ?>><?php echo $before6Day; ?></option>
<option value=<?php echo $before7Day; ?> <?php if ($insert_date==$before7Day){echo 'selected';} ?>><?php echo $before7Day; ?></option>
</select>
<span style="font-size:30px;"><b>신규 등록된 </b></span>

<select style="width:170px;font-size:30px;" name="type" id="type" onchange="apart_type(this)">
	<option value="all" <?php if($type=='all'){echo 'selected';}?>>매매/전세</option>
	<option value="meme" <?php if($type=='meme'){echo 'selected';}?>>매매</option>
	<option value="rent" <?php if($type=='rent'){echo 'selected';}?>>전세</option>
</select>
<span style="font-size:30px;"><b>리스트</b></span>
<br>


<span style="font-size:30px;"></b></span><select style="width:220px;font-size:30px;" name="main" id="main" onchange="apart_list(this)">
<?php
$rs_select = mysqli_query($Conn, "SELECT area_main_name FROM molit_area_info group by area_main_name ORDER BY MIN(area_code_seq)");
while ( $row_select = mysqli_fetch_assoc($rs_select) ) {
    $rows_select[] = $row_select;
}?>
  <option value="전체" <?php if ($area_main_name=='전체'){echo 'selected';} ?>>전체</option>
<?php foreach ($rows_select as $row_select) { ?>
  <option value=<?php echo $row_select['area_main_name']; if ($row_select['area_main_name']==$area_main_name){echo ' selected';}?>><?php echo $row_select['area_main_name']; ?></option>
<?php } ?>
</select>




<span style="font-size:30px;"><b>시군구 : </b></span><select style="width:220px;font-size:30px;" name="sub" id="sub" onchange="apart_sub_list(this)">
<option value=''>선택</option>
<?php
$rs_sub = mysqli_query($Conn, "
            SELECT distinct a.area_sub_name
            FROM
            (
              select replace(replace(area_name, concat(area_main_name,' '),''),' ','') as area_sub_name from molit_today_update today where $area_main_name_text and insert_date = '$insert_date' and (1!=1 $size1_text $size2_text $size3_text $size4_text) and status is not null group by area_main_name, area_name
              UNION all
              select replace(replace(area_name, concat(area_main_name,' '),''),' ','') as area_sub_name from molit_today_update_rent today where $area_main_name_text and insert_date = '$insert_date' and (1!=1 $size1_text $size2_text $size3_text $size4_text) and status is not null group by area_main_name, area_name
            ) AS a
            ORDER BY a.area_sub_name
            ");
while ( $row_sub = mysqli_fetch_assoc($rs_sub) ) {
    $rows_sub[] = $row_sub;
}
foreach ($rows_sub as $row_sub) { ?>
  <option value=<?php echo $row_sub['area_sub_name']; if ($row_sub['area_sub_name']==$area_sub_name){echo ' selected';}?>><?php echo $row_sub['area_sub_name']; ?></option>
<?php } ?>
</select>

<br>
<form name="mform">
 <span style="font-size:25px;"><b>상세사이즈 </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size1" onclick="check1(this)" <?php if($size1=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>전용40 ㎡이하 </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size2" onclick="check2(this)" <?php if($size2=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>전용40-60 ㎡ </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size3" onclick="check3(this)" <?php if($size3=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>전용60-85 ㎡ </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size4" onclick="check4(this)" <?php if($size4=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>전용85 ㎡초과</b></span>
</form>

<script>
function check1(country){
  location.href = "./apart_today.php?area_main_name=<?=$area_main_name?>&area_sub_name=<?=$area_sub_name?>&insert_date=<?=$insert_date?>&type=<?=$type?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check2(country){
  location.href = "./apart_today.php?area_main_name=<?=$area_main_name?>&area_sub_name=<?=$area_sub_name?>&insert_date=<?=$insert_date?>&type=<?=$type?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check3(country){
  location.href = "./apart_today.php?area_main_name=<?=$area_main_name?>&area_sub_name=<?=$area_sub_name?>&insert_date=<?=$insert_date?>&type=<?=$type?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check4(country){
  location.href = "./apart_today.php?area_main_name=<?=$area_main_name?>&area_sub_name=<?=$area_sub_name?>&insert_date=<?=$insert_date?>&type=<?=$type?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
</script>
<?php
  if($rs_favorite_count>0 || $rs_favorite_rent_count>0){
?>

<h1>즐겨찾기한 아파트에 신규거래가 있습니다.</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; background: #FF0000; width:35%;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; background: #FF0000; width:14%;"><b>전용면적</b><br>층<br>거래유형<br>(계약갱신)</b></th>
        <th style="font-size: 20px; background: #FF0000; width:12%;"><b>신규가격<br>가격변동<br>변동률</b></th>
        <th style="font-size: 20px; background: #FF0000; width:13%;"><b>최고대비<br>하락/상승률</b></th>
        <th style="font-size: 20px; background: #FF0000; width:13%;"><b>최근가격</b><br>(최근전세)<br>(최근매매)</th>
        <th style="font-size: 20px; background: #FF0000; width:13%;"><b>최고가격</b><br>(최고전세)<br>(최고매매)</th>
        <!--<th style="font-size: 20px; background: #FF0000; width:13%;"><b>최저가격</b><br>(최저전세)<br>(최저매매)</th>-->
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows_favorite as $row_favorite) { ?>
      <tr>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px; width:35%;"><a href='./apart.php?area_main_name=<?=$row_favorite[area_main_name]?>&apart_name=<?=$row_favorite[apart_name]?>&size=<?=$row_favorite[size]?>&dong=<?=$row_favorite[doing]?>&all_area=N'><b><span style="font-size: 27px;"><?=$row_favorite['apart_name']?></span></b><br><?=$row_favorite['yearmonthday']?><br><?=$row_favorite['area_main_name']?> <?=$row_favorite['area_name']?> <?=$row_favorite['doing']?></td>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px; width:14%;"><b><?=$row_favorite['size']?>㎡</b><br><?=$row_favorite['stair']?>층<br><?=$row_favorite['TYPE']?></td>
          <?php

          if ( $row_favorite['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; width:12%;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]% 상승<br>신고가</td>";
          } elseif ( $row_favorite['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; width:12%;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]% 상승</td>";
          } elseif ( $row_favorite['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; width:12%;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]%<br>동일</td>";
          } elseif ( $row_favorite['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; width:12%;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]% 하락</td>";
          } elseif ( $row_favorite['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; width:12%;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]% 하락<br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>신규</td>";
          }
          ?>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px; width:13%;"><b><?=$row_favorite['price_max']?>억<br><?php if($row_favorite['max_percent']>=30){ echo "<span style='color:red;'>최고가 대비<br>"; echo $row_favorite['max_percent']; echo "%하락</span>";} elseif($row_favorite['max_percent']<0){ echo "<span style='color:green;'>최고가 대비<br>"; echo abs($row_favorite['max_percent']); echo "%상승</span>";} else{ echo "최고가 대비<br>"; echo $row_favorite['max_percent']; echo "%하락";} ?></b></td>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px; width:13%;"><b><?=$row_favorite['last_price']?>억</b><br><?=$row_favorite['last_price_date']?><br>(<?=$row_favorite['rent_last_price']?>억)</td>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px; width:13%;"><b><?=$row_favorite['max_price']?>억</b><br><?=$row_favorite['max_price_date']?><br>(<?=$row_favorite['rent_max_price']?>억)</td>
          <!--<td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px; width:13%;"><b><?=$row_favorite['min_price']?>억</b><br><?=$row_favorite['min_price_date']?><br>(<?=$row_favorite['rent_min_price']?>억)</td>-->
      </tr>
      <?php } ?>
    </tbody>
    <tbody>
      <?php foreach ($rows_favorite_rent as $row_favorite_rent) { ?>
      <tr>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px; width:35%;"><a href='./apart_rent.php?area_main_name=<?=$row_favorite_rent[area_main_name]?>&apart_name=<?=$row_favorite_rent[apart_name]?>&size=<?=$row_favorite_rent[size]?>&dong=<?=$row_favorite_rent[dong]?>&all_area=N'><b><span style="font-size: 27px;"><?=$row_favorite_rent['apart_name']?></span></b><br><?=$row_favorite_rent['yearmonthday']?><br><?=$row_favorite_rent['area_main_name']?> <?=$row_favorite_rent['area_name']?> <?=$row_favorite_rent[dong]?></td>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px; width:14%;"><b><?=$row_favorite_rent['size']?>㎡</b><br><?=$row_favorite_rent['stair']?>층<br><?=$row_favorite_rent['TYPE']?></td>
          <?php

          if ( $row_favorite_rent['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; width:12%;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]% 상승<br>신고가</td>";
          } elseif ( $row_favorite_rent['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; width:12%;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]% 상승</td>";
          } elseif ( $row_favorite_rent['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; width:12%;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]%<br>동일</td>";
          } elseif ( $row_favorite_rent['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; width:12%;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]% 하락</td>";
          } elseif ( $row_favorite_rent['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; width:12%;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]% 하락<br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>신규</td>";
          }
          ?>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px; width:13%;"><b><?=$row_favorite_rent['price_max']?>억<br><?php if($row_favorite_rent['max_percent']>=30){ echo "<span style='color:red;'>최고가 대비<br>"; echo $row_favorite_rent['max_percent']; echo "%하락</span>";} elseif($row_favorite_rent['max_percent']<0){ echo "<span style='color:green;'>최고가 대비<br>"; echo abs($row_favorite_rent['max_percent']); echo "%상승</span>";} else{ echo "최고가 대비<br>"; echo $row_favorite_rent['max_percent']; echo "%하락";} ?></b></td>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px; width:13%;"><b><?=$row_favorite_rent['last_price']?>억</b><br><?=$row_favorite_rent['last_price_date']?><br>(<?=$row_favorite_rent['meme_last_price']?>억)</td>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px; width:13%;"><b><?=$row_favorite_rent['max_price']?>억</b><br><?=$row_favorite_rent['max_price_date']?><br>(<?=$row_favorite_rent['meme_max_price']?>억)</td>
          <!--<td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px; width:13%;"><b><?=$row_favorite_rent['min_price']?>억</b><br><?=$row_favorite_rent['min_price_date']?><br>(<?=$row_favorite_rent['meme_min_price']?>억)</td>-->
      </tr>
      <?php } ?>
    </tbody>
</table>
<br>
<?php } ?>













<br>
<?php if($type=="all" or $type=="meme") { ?>

<h1><?=$area_main_name?> <?=$area_sub_name?> 신규 매매 리스트</h1>
<span style="font-size:25px;"><b>총 <?php echo $row_status['total']; ?>건, 총 상승금액 : <?php if($row_status['up_price']==''){echo '0';}else{ echo $row_status['up_price'];} ?>억, 총 하락금액 : <?php if($row_status['down_price']==''){echo '0';}else{ echo $row_status['down_price'];} ?>억<br>(신고가 <?php echo $row_status['upup']; ?>건, 상승 <?php echo $row_status['up']; ?>건, 동일 <?php echo $row_status['same']; ?>건, 하락 <?php echo $row_status['down']; ?>건, 신저가 <?php echo $row_status['downdown']; ?>건, 신규 <?php echo $row_status['new']; ?>건)</b></span>
<br>
<span style="font-size:20px;">검색조건당 최대 100개 조회, 상세검색은 지역과 시군구 포함 검색 필요</span>


<?php if(($advertize=="1" && $isMobile == "Y"  && $rs_count>0) or ($advertize=="1" && $isMobile == "N")){ ?>
<br>


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
        <th style="font-size: 20px; width:35%;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; width:14%;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; width:12%;"><b>신규가격<br>가격변동<br>변동률</b></th>
        <th style="font-size: 20px; width:13%;"><b>최고대비<br>하락/상승률</b></th>
        <th style="font-size: 20px; width:13%;"><b>최근가격</b><br>(최근전세)</th>
        <th style="font-size: 20px; width:13%;"><b>최고가격</b><br>(최고전세)</th>
        <!--<th style="font-size: 20px; width:13%;"><b>최저가격</b><br>(최저전세)</th>-->
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows as $row) { if($add_count!=0 && fmod($add_count, 15)==0){echo '<tr><td colspan="6"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2265060002718871" data-ad-slot="3474043280"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></td></tr>';} $add_count = $add_count + 1; ?>
      <tr>
          <td style="font-size: 20px; width:35%;"><a href='./apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[doing]?>&all_area=N'><b><span style="font-size: 27px;"><?=$row['apart_name']?></span></b><br><?=$row['yearmonthday']?></b><br><?=$row['area_main_name']?> <?=$row['area_name']?> <?=$row['doing']?></td>
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
          <td style="font-size: 20px; width:13%;"><b><?=$row['price_max']?>억<br><?php if($row['max_percent']>=30){ echo "<span style='color:red;'>최고가 대비<br>"; echo $row['max_percent']; echo "%하락</span>";} elseif($row['max_percent']<0){ echo "<span style='color:green;'>최고가 대비<br>"; echo abs($row['max_percent']); echo "%상승</span>";} else{ echo "최고가 대비<br>"; echo $row['max_percent']; echo "%하락";} ?></b></td>
          <td style="font-size: 20px; width:13%;"><b><?=$row['last_price']?>억</b><br><?=$row['last_price_date']?><br>(<?=$row['rent_last_price']?>억)</td>
          <td style="font-size: 20px; width:13%;"><b><?=$row['max_price']?>억</b><br><?=$row['max_price_date']?><br>(<?=$row['rent_max_price']?>억)</td>
          <!--<td style="font-size: 20px; width:13%;"><b><?=$row['min_price']?>억</b><br><?=$row['min_price_date']?><br>(<?=$row['rent_min_price']?>억)</td>-->
      </tr>
      <?php } ?>
    </tbody>
</table>
<?php } if($type=="all" or $type=="rent") { ?>
  <?php if($advertize=="1" && $rs_rent_count>0){ ?>
  <br>
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
<h1><?=$area_main_name?> <?=$area_sub_name?> 신규 전세 리스트</h1>
<span style="font-size:25px;"><b>총 <?php echo $row_status_rent['total']; ?>건, 총 상승금액 : <?php if($row_status_rent['up_price']==''){echo '0';}else{ echo $row_status_rent['up_price'];} ?>억, 총 하락금액 : <?php if($row_status_rent['down_price']==''){echo '0';}else{ echo $row_status_rent['down_price'];} ?>억<br>(신고가 <?php echo $row_status_rent['upup']; ?>건, 상승 <?php echo $row_status_rent['up']; ?>건, 동일 <?php echo $row_status_rent['same']; ?>건, 하락 <?php echo $row_status_rent['down']; ?>건, 신저가 <?php echo $row_status_rent['downdown']; ?>건, 신규 <?php echo $row_status_rent['new']; ?>건)</b></span>
<br>
<span style="font-size:20px;">검색조건당 최대 100개 조회, 상세검색은 지역과 시군구 포함 검색 필요</span>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; background: #809EAD; width:35%;"><b>아파트명<br>거래일자</b></th>
        <th style="font-size: 20px; background: #809EAD; width:14%;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; background: #809EAD; width:12%;"><b>신규가격<br>가격변동<br>변동률</b></th>
        <th style="font-size: 20px; background: #809EAD; width:13%;"><b>최고대비<br>하락/상승률</b></th>
        <th style="font-size: 20px; background: #809EAD; width:13%;"><b>최근가격</b><br>(최근매매)</th>
        <th style="font-size: 20px; background: #809EAD; width:13%;"><b>최고가격</b><br>(최고매매)</th>
        <!--<th style="font-size: 20px; background: #809EAD; width:13%;"><b>최저가격</b><br>(최저매매)</th>-->
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows_rent as $row_rent) { if($add_count!=0 && fmod($add_count, 15)==0){echo '<tr><td colspan="6"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2265060002718871" data-ad-slot="3474043280"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></td></tr>';} $add_count = $add_count + 1; ?>
      <tr>
          <td style="font-size: 20px; width:35%;"><a href='./apart_rent.php?area_main_name=<?=$row_rent[area_main_name]?>&apart_name=<?=$row_rent[apart_name]?>&size=<?=$row_rent[size]?>&dong=<?=$row_rent[dong]?>&all_area=N'><b><span style="font-size: 27px;"><?=$row_rent['apart_name']?><span></b><br><?=$row_rent['yearmonthday']?> <br><?=$row_rent['area_main_name']?> <?=$row_rent['area_name']?> <?=$row_rent[dong]?></td>
          <td style="font-size: 20px; width:14%;"><b><?=$row_rent['size']?>㎡</b><br><?=$row_rent['stair']?>층<br><?=$row_rent['TYPE']?></td>
          <?php

          if ( $row_rent['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px; width:12%;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]% 상승<br>신고가</td>";
          } elseif ( $row_rent['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px; width:12%;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]% 상승</td>";
          } elseif ( $row_rent['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px; width:12%;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]%<br>동일</td>";
          } elseif ( $row_rent['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px; width:12%;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]% 하락</td>";
          } elseif ( $row_rent['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px; width:12%;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]% 하락<br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px; width:12%;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>신규</td>";
          }
          ?>
          <td style="font-size: 20px; width:13%;"><b><?=$row_rent['price_max']?>억<br><?php if($row_rent['max_percent']>=30){ echo "<span style='color:red;'>최고가 대비<br>"; echo $row_rent['max_percent']; echo "%하락</span>";} elseif($row_rent['max_percent']<0){ echo "<span style='color:green;'>최고가 대비<br>"; echo abs($row_rent['max_percent']); echo "%상승</span>";} else{ echo "최고가 대비<br>"; echo $row_rent['max_percent']; echo "%하락";} ?></b></td>
          <td style="font-size: 20px; width:13%;"><b><?=$row_rent['last_price']?>억</b><br><?=$row_rent['last_price_date']?><br>(<?=$row_rent['meme_last_price']?>억)</td>
          <td style="font-size: 20px; width:13%;"><b><?=$row_rent['max_price']?>억</b><br><?=$row_rent['max_price_date']?><br>(<?=$row_rent['meme_max_price']?>억)</td>
          <!--<td style="font-size: 20px; width:13%;"><b><?=$row_rent['min_price']?>억</b><br><?=$row_rent['min_price_date']?><br>(<?=$row_rent['meme_min_price']?>억)</td>-->
      </tr>
      <?php } ?>
    </tbody>
</table>
<?php } ?>
<script>
function apart_day_list(e) {
  <?php echo "window.location.replace('./apart_today.php?'+'area_main_name='+document.getElementById('main').value+'&area_sub_name='+document.getElementById('sub').value+'&insert_date='+document.getElementById('day').value+'&type=$type'+'&size1=$size1'+'&size2=$size2'+'&size3=$size3'+'&size4=$size4');"?>
}
function apart_list(e) {
  <?php echo "window.location.replace('./apart_today.php?'+'area_main_name='+document.getElementById('main').value+'&area_sub_name='+document.getElementById('sub').value+'&insert_date=$insert_date'+'&type=$type'+'&size1=$size1'+'&size2=$size2'+'&size3=$size3'+'&size4=$size4');"?>
}
function apart_sub_list(e) {
  <?php echo "window.location.replace('./apart_today.php?'+'area_main_name='+document.getElementById('main').value+'&area_sub_name='+document.getElementById('sub').value+'&insert_date=$insert_date'+'&type=$type'+'&size1=$size1'+'&size2=$size2'+'&size3=$size3'+'&size4=$size4');"?>
}
function apart_type(e) {
  <?php echo "window.location.replace('./apart_today.php?'+'area_main_name='+document.getElementById('main').value+'&area_sub_name='+document.getElementById('sub').value+'&insert_date=$insert_date'+'&type='+document.getElementById('type').value+'&size1=$size1'+'&size2=$size2'+'&size3=$size3'+'&size4=$size4');"?>
}
</script>

<?php if($advertize=="1"){ ?>
<br>
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

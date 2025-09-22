<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
<title>오늘집값 - 아파트 실거래 조회</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 금일 아파트 신규 매매/전세 조회">
<meta property="og:description" content="오늘집값 - 금일 등록된 아파트 신규 매매/전세 정보를 조회할 수 있습니다.">
<meta property="og:image" content="./todayhouseprice2.png">
<meta property="og:url" content="http://todayhouseprice.com/apart_today.php">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
     crossorigin="anonymous"></script>
</head>
<link rel="stylesheet" type="text/css" href="./test.css">
<?php
$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
$today = date("Y-m-d");

session_start();
$userid = $_SESSION["userid"];
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

$area_main_name = $_REQUEST["area_main_name"];
$area_sub_name = $_REQUEST["area_sub_name"];
$insert_date = $_REQUEST["insert_date"];
$main = $_REQUEST["main"];
$type = $_REQUEST["type"];


$before1Day = date("Y-m-d", strtotime($today." -1 day"));
$before2Day = date("Y-m-d", strtotime($today." -2 day"));
$before3Day = date("Y-m-d", strtotime($today." -3 day"));
$before4Day = date("Y-m-d", strtotime($today." -4 day"));
$before5Day = date("Y-m-d", strtotime($today." -5 day"));
$before6Day = date("Y-m-d", strtotime($today." -6 day"));
$before7Day = date("Y-m-d", strtotime($today." -7 day"));


if ( $insert_date == ''){
  $insert_date = date("Y-m-d");
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


if ( $main == '1'){
  $main_text = "AND cast(today.size as decimal(10,2)) > '49.99'";
}elseif ($main == ''){
  $main = "1";
  $main_text = "AND cast(today.size as decimal(10,2)) > '49.99'";
}else{
  $main = "0";
  $main_text = "";
}

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
			  rent.last_price AS rent_last_price,
			  rent.max_price AS rent_max_price,
			  rent.min_price AS rent_min_price
      from molit_today_update today LEFT join molit_max_min_rent_all rent
      ON today.area_main_name = rent.area_main_name
      AND today.doing = rent.dong
      AND today.apart_name = rent.apart_name
      AND today.size = rent.size
      where $area_main_name_text
      and today.insert_date = '$insert_date'
      $main_text
      $area_sub_name_text
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 300;
      ";

$sql_rent = "
      select
      	yearmonthday,
      	area_main_name,
      	replace(area_name,area_main_name,'') as area_name,
      	dong ,
      	apart_name,
      	size,
      	stair,
      	rent_price ,
      	month_price ,
      	TYPE,
      	STATUS ,
      	max_price,
      	max_price_date,
      	min_price,
      	min_price_date,
      	last_price,
      	last_price_date,
      	ROUND((CAST(rent_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2) as price_last,
        case
  			  when CAST(rent_price as DECIMAL(10,5)) > CAST(last_price as DECIMAL(10,5))
  			  then ROUND(((CAST(rent_price as DECIMAL(10,5))/CAST(last_price as DECIMAL(10,5))*100)-100),0)
  			  when CAST(rent_price as DECIMAL(10,5)) < CAST(last_price as DECIMAL(10,5))
  			  then ROUND(100-(CAST(rent_price as DECIMAL(10,5))/CAST(last_price as DECIMAL(10,5)))*100,0)
			    ELSE 0 END AS percent
      from molit_today_update_rent today
      where $area_main_name_text
      and insert_date = '$insert_date'
      and month_price = '0'
      $main_text
      $area_sub_name_text
      and status is not null
      ORDER BY ABS(ROUND((CAST(rent_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2)) desc
      limit 300;
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
		  rent.last_price AS rent_last_price,
		  rent.max_price AS rent_max_price,
		  rent.min_price AS rent_min_price
    from molit_today_update today LEFT join molit_max_min_rent_all rent
      ON today.area_main_name = rent.area_main_name
      AND today.doing = rent.dong
      AND today.apart_name = rent.apart_name
      AND today.size = rent.size
    where today.insert_date = '$insert_date'
    and (today.area_main_name, today.doing, today.apart_name) in (select area_main_name, dong, apart_name from molit_favorite where userid = '$userid')
    and today.status is not null
    AND !(today.last_price = '0' AND today.max_price != '0')
    ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
    limit 300;
    ";
$sql_favorite_rent = "
      select
      	yearmonthday,
      	area_main_name,
      	replace(area_name,area_main_name,'') as area_name,
      	dong ,
      	apart_name,
      	size,
      	stair,
      	rent_price ,
      	month_price ,
      	TYPE,
      	STATUS ,
      	max_price,
      	max_price_date,
      	min_price,
      	min_price_date,
      	last_price,
      	last_price_date,
      	ROUND((CAST(rent_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2) as price_last,
        case
  			  when CAST(rent_price as DECIMAL(10,5)) > CAST(last_price as DECIMAL(10,5))
  			  then ROUND(((CAST(rent_price as DECIMAL(10,5))/CAST(last_price as DECIMAL(10,5))*100)-100),0)
  			  when CAST(rent_price as DECIMAL(10,5)) < CAST(last_price as DECIMAL(10,5))
  			  then ROUND(100-(CAST(rent_price as DECIMAL(10,5))/CAST(last_price as DECIMAL(10,5)))*100,0)
			    ELSE 0 END AS percent
      from molit_today_update_rent today
      where insert_date = '$insert_date'
      and month_price = '0'
      and (area_main_name, dong, apart_name) in (select area_main_name, dong, apart_name from molit_favorite where userid = '$userid')
      and status is not null
      ORDER BY ABS(ROUND((CAST(rent_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2)) desc
      limit 300;
      ";

$sql_status = "
  SELECT
      (SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null) AS total,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신고가' and status is not null GROUP BY STATUS),0) AS upup,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='상승' and status is not null GROUP BY STATUS),0) AS up,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='동일' and status is not null GROUP BY STATUS),0) AS same,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='하락' and status is not null GROUP BY STATUS),0) AS down,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신저가' and status is not null GROUP BY STATUS),0) AS downdown,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신규' and status is not null GROUP BY STATUS),0) AS new,
      (SELECT SUM(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null AND STATUS IN ('신고가','상승')) AS up_price,
      (SELECT SUM(ROUND((CAST(last_price as DECIMAL(10,5)) - CAST(price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null AND STATUS IN ('신저가','하락')) AS down_price
      FROM DUAL;
";

$sql_status_rent = "
  SELECT
      (SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null) AS total,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신고가' and status is not null GROUP BY STATUS),0) AS upup,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='상승' and status is not null GROUP BY STATUS),0) AS up,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='동일' and status is not null GROUP BY STATUS),0) AS same,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='하락' and status is not null GROUP BY STATUS),0) AS down,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신저가' and status is not null GROUP BY STATUS),0) AS downdown,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신규' and status is not null GROUP BY STATUS),0) AS new,
      (SELECT SUM(ROUND((CAST(rent_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2))from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null AND STATUS IN ('신고가','상승')) AS up_price,
      (SELECT SUM(ROUND((CAST(last_price as DECIMAL(10,5)) - CAST(rent_price as DECIMAL(10,5))),2))from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null AND STATUS IN ('신저가','하락')) AS down_price
      FROM DUAL;
";

mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");



//조회수 출력
$sql_count = "
select
IFNULL((SELECT SUM(COUNT) from molit_visit_count),0) AS total,
IFNULL((SELECT SUM(COUNT) from molit_visit_count WHERE YMD = '$today'),0) AS today
FROM DUAL;
";
$rs_count = mysqli_query($Conn, $sql_count);
$row_count = mysqli_fetch_assoc($rs_count);


$rs = mysqli_query($Conn, $sql);
while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

$rs_rent = mysqli_query($Conn, $sql_rent);
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


if ($row_status['total']==0 and $row_status_rent['total']==0){
  $yesterday = date('Y-m-d', $_SERVER['REQUEST_TIME']-86400);
  $insert_date = $yesterday;

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
  			  rent.last_price AS rent_last_price,
    			rent.max_price AS rent_max_price,
    			rent.min_price AS rent_min_price
        from molit_today_update today LEFT join molit_max_min_rent_all rent
        ON today.area_main_name = rent.area_main_name
        AND today.doing = rent.dong
        AND today.apart_name = rent.apart_name
        AND today.size = rent.size
        where $area_main_name_text
        and today.insert_date = '$insert_date'
        $main_text
        $area_sub_name_text
        and today.status is not null
        AND !(today.last_price = '0' AND today.max_price != '0')
        ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
        limit 300;
        ";

  $sql_rent = "
        select
        	yearmonthday,
        	area_main_name,
        	replace(area_name,area_main_name,'') as area_name,
        	dong ,
        	apart_name,
        	size,
        	stair,
        	rent_price ,
        	month_price ,
        	TYPE,
        	STATUS ,
        	max_price,
        	max_price_date,
        	min_price,
        	min_price_date,
        	last_price,
        	last_price_date,
        	ROUND((CAST(rent_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2) as price_last,
        	case
  			  when CAST(rent_price as DECIMAL(10,5)) > CAST(last_price as DECIMAL(10,5))
  			  then ROUND(((CAST(rent_price as DECIMAL(10,5))/CAST(last_price as DECIMAL(10,5))*100)-100),0)
  			  when CAST(rent_price as DECIMAL(10,5)) < CAST(last_price as DECIMAL(10,5))
  			  then ROUND(100-(CAST(rent_price as DECIMAL(10,5))/CAST(last_price as DECIMAL(10,5)))*100,0)
			    ELSE 0 END AS percent
        from molit_today_update_rent today
        where $area_main_name_text
        and insert_date = '$insert_date'
        and month_price = '0'
        $main_text
        $area_sub_name_text
        and status is not null
        ORDER BY ABS(ROUND((CAST(rent_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2)) desc
        limit 300;
        ";

  $sql_status = "
    SELECT
        (SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null) AS total,
        IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신고가' and status is not null GROUP BY STATUS),0) AS upup,
        IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='상승' and status is not null GROUP BY STATUS),0) AS up,
        IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='동일' and status is not null GROUP BY STATUS),0) AS same,
        IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='하락' and status is not null GROUP BY STATUS),0) AS down,
        IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신저가' and status is not null GROUP BY STATUS),0) AS downdown,
        IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신규' and status is not null GROUP BY STATUS),0) AS new,
        (SELECT SUM(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null AND STATUS IN ('신고가','상승')) AS up_price,
        (SELECT SUM(ROUND((CAST(last_price as DECIMAL(10,5)) - CAST(price as DECIMAL(10,5))),2))from molit_today_update today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null AND STATUS IN ('신저가','하락')) AS down_price
        FROM DUAL;
  ";

  $sql_status_rent = "
  SELECT
      (SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null) AS total,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신고가' and status is not null GROUP BY STATUS),0) AS upup,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='상승' and status is not null GROUP BY STATUS),0) AS up,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='동일' and status is not null GROUP BY STATUS),0) AS same,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='하락' and status is not null GROUP BY STATUS),0) AS down,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신저가' and status is not null GROUP BY STATUS),0) AS downdown,
      IFNULL((SELECT COUNT(1) from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text AND STATUS ='신규' and status is not null GROUP BY STATUS),0) AS new,
      (SELECT SUM(ROUND((CAST(rent_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2))from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null AND STATUS IN ('신고가','상승')) AS up_price,
      (SELECT SUM(ROUND((CAST(last_price as DECIMAL(10,5)) - CAST(rent_price as DECIMAL(10,5))),2))from molit_today_update_rent today WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text $area_sub_name_text and status is not null AND STATUS IN ('신저가','하락')) AS down_price
      FROM DUAL;
  ";

  $rs = mysqli_query($Conn, $sql);

  while ( $row = mysqli_fetch_assoc($rs) ) {
      $rows[] = $row;
  }

  $rs_rent = mysqli_query($Conn, $sql_rent);

  while ( $row_rent = mysqli_fetch_assoc($rs_rent) ) {
      $rows_rent[] = $row_rent;
  }

  $rs_status = mysqli_query($Conn, $sql_status);
  $row_status = mysqli_fetch_assoc($rs_status);
  $rows_status[] = $row_status;

  $rs_status_rent = mysqli_query($Conn, $sql_status_rent);
  $row_status_rent = mysqli_fetch_assoc($rs_status_rent);
  $rows_status_rent[] = $row_status_rent;
}


?>
<?php
  if(!$userid){
?>
<a style="font-size:20px;" href="./login.php"><b>로그인</b></a><span style="font-size:20px;"><b> <-- 로그인을 통해 즐겨찾기 기능을 사용해 보세요!!</b></span>
<?php
  }else if($userid){
    //$logged = $username."(".$userid.")";
    $logged = $userid;
?>
<span style="font-size:20px;"><b><?=$logged ?>님 </b></span><a style="font-size:20px;" href="./logout.php"><b>로그아웃</b></a> <a style="font-size:20px;" href="./apart_favorite.php"><b>즐겨찾기</b></a>
<?php }?>


<span style="font-size:20px; float:right;"><b>Total : <?=$row_count['total']?>, Today : <?=$row_count['today']?></b></span>
<center>
<a href="./apart_today.php"><img style="vertical-align: middle;" width="90", height="90" src="./todayhouseprice2.png"></a>
<span style="font-size:30px; vertical-align: middle;"><b>아파트 매매/전세 조회</b></span>
</center>

<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>
<h1>
<a href='./apart_home.php'>전체 매매 조회하기</a>
<a style="float:right;" href='./apart_home_rent.php'>전체 전/월세 조회하기</a>
</h1>
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





<?php
  if($rs_favorite_count>0 || $rs_favorite_rent_count>0){
?>
<h1>즐겨찾기한 아파트에 신규거래가 있습니다.</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; background: #FF0000;"><b>거래일자</b><br>아파트명</b></th>
        <th style="font-size: 20px; background: #FF0000;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; background: #FF0000;"><b>가격<br>(이전가격)</b></th>
        <th style="font-size: 20px; background: #FF0000;"><b>이전가격<br>(이전전세)</b></th>
        <th style="font-size: 20px; background: #FF0000;"><b>최고가격<br>(최고전세)</b></th>
        <th style="font-size: 20px; background: #FF0000;"><b>최저가격<br>(최저전세)</b></th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows_favorite as $row_favorite) { ?>
      <tr>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px;"><a href='./apart.php?area_main_name=<?=$row_favorite[area_main_name]?>&apart_name=<?=$row_favorite[apart_name]?>&size=<?=$row_favorite[size]?>&dong=<?=$row_favorite[doing]?>&all_area=N'><b><?=$row_favorite['yearmonthday']?></b><br><b><?=$row_favorite['area_main_name']?> <?=$row_favorite['area_name']?> <?=$row_favorite['doing']?></b><br><b><?=$row_favorite['apart_name']?></b></td>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px;"><b><?=$row_favorite['size']?>㎡</b><br><b><?=$row_favorite['stair']?>층</b><br><b><?=$row_favorite['TYPE']?></b></td>
          <?php

          if ( $row_favorite['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]% 상승<br>신고가</td>";
          } elseif ( $row_favorite['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]% 상승</td>";
          } elseif ( $row_favorite['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]%<br>동일</td>";
          } elseif ( $row_favorite['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]% 하락</td>";
          } elseif ( $row_favorite['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>$row_favorite[percent]% 하락<br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px;'><b>$row_favorite[price]억</b><br>$row_favorite[price_last]억<br>신규</td>";
          }
          ?>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px;"><b><?=$row_favorite['last_price']?>억</b><br><b><?=$row_favorite['last_price_date']?></b><br><b><?=$row_favorite['rent_last_price']?></b></td>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px;"><b><?=$row_favorite['max_price']?>억</b><br><b><?=$row_favorite['max_price_date']?></b><br><b><?=$row_favorite['rent_max_price']?></b></td>
          <td style="background-color:rgba(150, 75, 0, 0.2); font-size: 20px;"><b><?=$row_favorite['min_price']?>억</b><br><b><?=$row_favorite['min_price_date']?></b><br><b><?=$row_favorite['rent_min_price']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
    <tbody>
      <?php foreach ($rows_favorite_rent as $row_favorite_rent) { ?>
      <tr>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px;"><a href='./apart_rent.php?area_main_name=<?=$row_favorite_rent[area_main_name]?>&apart_name=<?=$row_favorite_rent[apart_name]?>&size=<?=$row_favorite_rent[size]?>&dong=<?=$row_favorite_rent[dong]?>&all_area=N'><b><?=$row_favorite_rent['yearmonthday']?> <br><?=$row_favorite_rent['area_main_name']?></b><b><?=$row_favorite_rent['area_name']?> <?=$row_favorite_rent[dong]?></b><br><b><?=$row_favorite_rent['apart_name']?></b></td>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px;"><b><?=$row_favorite_rent['size']?>㎡</b><br><b><?=$row_favorite_rent['stair']?>층</b><br><b><?=$row_favorite_rent['TYPE']?></b></td>
          <?php

          if ( $row_favorite_rent['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]% 상승<br>신고가</td>";
          } elseif ( $row_favorite_rent['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]% 상승</td>";
          } elseif ( $row_favorite_rent['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]%<br>동일</td>";
          } elseif ( $row_favorite_rent['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]% 하락</td>";
          } elseif ( $row_favorite_rent['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>$row_favorite_rent[percent]% 하락<br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px;'><b>$row_favorite_rent[rent_price]억</b><br>$row_favorite_rent[price_last]억<br>신규</td>";
          }
          ?>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px;"><b><?=$row_favorite_rent['last_price']?>억</b><br><b><?=$row_favorite_rent['last_price_date']?></b></td>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px;"><b><?=$row_favorite_rent['max_price']?>억</b><br><b><?=$row_favorite_rent['max_price_date']?></b></td>
          <td style="background-color:rgba(80, 188, 223, 0.2); font-size: 20px;"><b><?=$row_favorite_rent['min_price']?>억</b><br><b><?=$row_favorite_rent['min_price_date']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<br>
<?php } ?>











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
              select replace(replace(area_name, concat(area_main_name,' '),''),' ','') as area_sub_name from molit_today_update where $area_main_name_text and insert_date = '$insert_date' $main_text and status is not null group by area_main_name, area_name
              UNION all
              select replace(replace(area_name, concat(area_main_name,' '),''),' ','') as area_sub_name from molit_today_update_rent where $area_main_name_text and insert_date = '$insert_date' $main_text and status is not null group by area_main_name, area_name
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




<span style="font-size:30px;"><b>50㎡이상 : </b></span><select style="width:50px;font-size:30px;" name="main_size" id="main_size" onchange="apart_main(this)">
	<option value="1" <?php if($main=='1'){echo 'selected';}?>>Y</option>
	<option value="0" <?php if($main=='0'){echo 'selected';}?>>N</option>
</select>


<br>
<?php if($type=="all" or $type=="meme") { ?>
<h1><?=$area_main_name?> <?=$area_sub_name?> 신규 매매 리스트</h1>
<span style="font-size:25px;"><b>총 <?php echo $row_status['total']; ?>건, 총 상승금액 : <?php if($row_status['up_price']==''){echo '0';}else{ echo $row_status['up_price'];} ?>억, 총 하락금액 : <?php if($row_status['down_price']==''){echo '0';}else{ echo $row_status['down_price'];} ?>억<br>(신고가 <?php echo $row_status['upup']; ?>건, 상승 <?php echo $row_status['up']; ?>건, 동일 <?php echo $row_status['same']; ?>건, 하락 <?php echo $row_status['down']; ?>건, 신저가 <?php echo $row_status['downdown']; ?>건, 신규 <?php echo $row_status['new']; ?>건)</b></span>
<br>
<span style="font-size:20px;">검색조건당 최대 300개 조회, 상세검색은 지역과 시군구 포함 검색 필요</span>

<table>
    <thead>
    <tr>
        <th style="font-size: 20px;"><b>거래일자</b><br>아파트명</b></th>
        <th style="font-size: 20px;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px;"><b>가격<br>(이전가격)</b></th>
        <th style="font-size: 20px;"><b>이전가격<br>(이전전세)</b></th>
        <th style="font-size: 20px;"><b>최고가격<br>(최고전세)</b></th>
        <th style="font-size: 20px;"><b>최저가격<br>(최저전세)</b></th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px;"><a href='./apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[doing]?>&all_area=N'><b><?=$row['yearmonthday']?></b><br><b><?=$row['area_main_name']?> <?=$row['area_name']?> <?=$row['doing']?></b><br><b><?=$row['apart_name']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['size']?>㎡</b><br><b><?=$row['stair']?>층</b><br><b><?=$row['TYPE']?></b></td>
          <?php

          if ( $row['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]% 상승<br>신고가</td>";
          } elseif ( $row['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]% 상승</td>";
          } elseif ( $row['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]%<br>동일</td>";
          } elseif ( $row['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]% 하락</td>";
          } elseif ( $row['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>$row[percent]% 하락<br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>신규</td>";
          }
          ?>
          <td style="font-size: 20px;"><b><?=$row['last_price']?>억</b><br><b><?=$row['last_price_date']?></b><br><b>(<?=$row['rent_last_price']?>억)</b></td>
          <td style="font-size: 20px;"><b><?=$row['max_price']?>억</b><br><b><?=$row['max_price_date']?></b><br><b>(<?=$row['rent_max_price']?>억)</b></td>
          <td style="font-size: 20px;"><b><?=$row['min_price']?>억</b><br><b><?=$row['min_price_date']?></b><br><b>(<?=$row['rent_min_price']?>억)</b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<?php } if($type=="all" or $type=="rent") { ?>
<h1><?=$area_main_name?> <?=$area_sub_name?> 신규 전세 리스트</h1>
<span style="font-size:25px;"><b>총 <?php echo $row_status_rent['total']; ?>건, 총 상승금액 : <?php if($row_status_rent['up_price']==''){echo '0';}else{ echo $row_status_rent['up_price'];} ?>억, 총 하락금액 : <?php if($row_status_rent['down_price']==''){echo '0';}else{ echo $row_status_rent['down_price'];} ?>억<br>(신고가 <?php echo $row_status_rent['upup']; ?>건, 상승 <?php echo $row_status_rent['up']; ?>건, 동일 <?php echo $row_status_rent['same']; ?>건, 하락 <?php echo $row_status_rent['down']; ?>건, 신저가 <?php echo $row_status_rent['downdown']; ?>건, 신규 <?php echo $row_status_rent['new']; ?>건)</b></span>
<br>
<span style="font-size:20px;">검색조건당 최대 300개 조회, 상세검색은 지역과 시군구 포함 검색 필요</span>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; background: #809EAD;"><b>거래일자</b><br>아파트명</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>전세<br>(보증금)</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>이전가격</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>최고가격</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>최저가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows_rent as $row_rent) { ?>
      <tr>
          <td style="font-size: 20px;"><a href='./apart_rent.php?area_main_name=<?=$row_rent[area_main_name]?>&apart_name=<?=$row_rent[apart_name]?>&size=<?=$row_rent[size]?>&dong=<?=$row_rent[dong]?>&all_area=N'><b><?=$row_rent['yearmonthday']?> <br><?=$row_rent['area_main_name']?></b><b><?=$row_rent['area_name']?> <?=$row_rent[dong]?></b><br><b><?=$row_rent['apart_name']?></b></td>
          <td style="font-size: 20px;"><b><?=$row_rent['size']?>㎡</b><br><b><?=$row_rent['stair']?>층</b><br><b><?=$row_rent['TYPE']?></b></td>
          <?php

          if ( $row_rent['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.7); font-size: 20px;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]% 상승<br>신고가</td>";
          } elseif ( $row_rent['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.4); font-size: 20px;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]% 상승</td>";
          } elseif ( $row_rent['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]%<br>동일</td>";
          } elseif ( $row_rent['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.4); font-size: 20px;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]% 하락</td>";
          } elseif ( $row_rent['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.7); font-size: 20px;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>$row_rent[percent]% 하락<br>신저가</td>";
          } else
          {
            echo "<td style='font-size: 20px;'><b>$row_rent[rent_price]억</b><br>$row_rent[price_last]억<br>신규</td>";
          }
          ?>
          <td style="font-size: 20px;"><b><?=$row_rent['last_price']?>억</b><br><b><?=$row_rent['last_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row_rent['max_price']?>억</b><br><b><?=$row_rent['max_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row_rent['min_price']?>억</b><br><b><?=$row_rent['min_price_date']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<?php } ?>
<script>
function apart_day_list(e) {
  <?php echo "window.location.replace('./apart_today.php?'+'area_main_name='+document.getElementById('main').value+'&area_sub_name='+document.getElementById('sub').value+'&insert_date='+document.getElementById('day').value+'&main=$main&type=$type');"?>
}
function apart_list(e) {
  <?php echo "window.location.replace('./apart_today.php?'+'area_main_name='+document.getElementById('main').value+'&area_sub_name='+document.getElementById('sub').value+'&insert_date=$insert_date'+'&main=$main&type=$type');"?>
}
function apart_sub_list(e) {
  <?php echo "window.location.replace('./apart_today.php?'+'area_main_name='+document.getElementById('main').value+'&area_sub_name='+document.getElementById('sub').value+'&insert_date=$insert_date'+'&main=$main&type=$type');"?>
}
function apart_main(e) {
  <?php echo "window.location.replace('./apart_today.php?'+'area_main_name='+document.getElementById('main').value+'&area_sub_name='+document.getElementById('sub').value+'&insert_date=$insert_date'+'&main='+document.getElementById('main_size').value+'&type=$type');"?>
}
function apart_type(e) {
  <?php echo "window.location.replace('./apart_today.php?'+'area_main_name='+document.getElementById('main').value+'&area_sub_name='+document.getElementById('sub').value+'&insert_date=$insert_date'+'&main='+document.getElementById('main_size').value+'&type='+document.getElementById('type').value);"?>
}
</script>
<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : jungsup2.lee@gmail.com</b></span></center>

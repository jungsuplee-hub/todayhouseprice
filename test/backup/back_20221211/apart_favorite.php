<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
<title>오늘집값 - 아파트 실거래 조회</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 즐겨찾기">
<meta property="og:description" content="오늘집값 - 본인이 설정한 실거래 정보 확인">
<meta property="og:image" content="./todayhouseprice2.png">
<meta property="og:url" content="http://todayhouseprice.com/apart_favorite.php">
</head>
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
  $rs = mysqli_query($Conn, "select count(1) as cnt from molit_visit_count where ymd = '$today' and count_type = 'apart_home';");
  $row = mysqli_fetch_assoc($rs);
  if($row['cnt']==0) {
    mysqli_query($Conn, "insert into molit_visit_count (ymd, count, count_type) values('$today',1,'apart_home');");
  }else{
    mysqli_query($Conn, "update molit_visit_count set count = count + 1 where ymd = '$today' and count_type = 'apart_home';");
  }
}
/////////////////////조회수//////////////////////////


mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

/////////////////////매매//////////////////////////
$sql = "
      select
        area_main_name,
      	area_name,
      	apart_name,
      	size,
      	dong,
      	max_price,
      	min_price,
      	last_price,
      	max_price_date,
      	min_price_date,
      	last_price_date,
      	ROUND((CAST(max_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2) as price_last,
      	ROUND(100-(CAST(last_price as DECIMAL(10,5))/CAST(max_price as DECIMAL(10,5)))*100,0) AS percent
      from molit_max_min_all
      where (area_main_name, dong, apart_name, size) in (select area_main_name, dong, apart_name, size from molit_favorite where userid = '$userid')
      order by date_format(last_price_date,'%Y-%m-%d') desc
      ";

$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

/////////////////////매매//////////////////////////


/////////////////////전세//////////////////////////
$sql_rent = "
      select
        area_main_name,
      	area_name,
      	apart_name,
      	size,
      	dong,
      	max_price,
      	min_price,
      	last_price,
      	max_price_date,
      	min_price_date,
      	last_price_date,
      	ROUND((CAST(max_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2) as price_last,
      	ROUND(100-(CAST(last_price as DECIMAL(10,5))/CAST(max_price as DECIMAL(10,5)))*100,0) AS percent
      from molit_max_min_rent_all
      where (area_main_name, dong, apart_name, size) in (select area_main_name, dong, apart_name, size from molit_favorite where userid = '$userid')
      order by date_format(last_price_date,'%Y-%m-%d') desc
      ";

$rs_rent = mysqli_query($Conn, $sql_rent);

while ( $row_rent = mysqli_fetch_assoc($rs_rent) ) {
    $rows_rent[] = $row_rent;
}

/////////////////////매매//////////////////////////

//조회수 출력
$sql_count = "
select
IFNULL((SELECT SUM(COUNT) from molit_visit_count),0) AS total,
IFNULL((SELECT SUM(COUNT) from molit_visit_count WHERE YMD = '$today'),0) AS today
FROM DUAL;
";
$rs_count = mysqli_query($Conn, $sql_count);
$row_count = mysqli_fetch_assoc($rs_count);

?>
<?php
  if(!$userid){
?>
<a style="font-size:20px;" href="./login.php"><b>로그인</b></a>  <a style="font-size:20px;" href="./list.php"><b>자유게시판</b></a>
<?php
  }else if($userid){
    //$logged = $username."(".$userid.")";
    $logged = $userid;
?>
<span style="font-size:20px;"><b><?=$logged ?>님 </b></span><a style="font-size:20px;" href="./logout.php"><b>로그아웃</b></a>  <a style="font-size:20px;" href="./apart_favorite.php"><b>즐겨찾기</b></a>  <a style="font-size:20px;" href="./list.php"><b>자유게시판</b></a>
<?php }?>

<span style="font-size:20px; float:right;"><b>Total : <?=$row_count['total']?>, Today : <?=$row_count['today']?></b></span>
<br><span style="font-size:20px;"><b>거래 상세리스트 화면에서 하트모양을 클릭하시면 즐겨찾기 할 수 있습니다.</b></span><img style="vertical-align: middle;" width="25", height="25" src="./hearts_empty.png" ><img style="vertical-align: middle;" width="25", height="25" src="./hearts_full.png" >
<center>
<a href="./apart_today.php"><img style="vertical-align: middle;" width="90", height="90" src="./todayhouseprice2.png"></a>
<span style="font-size:30px; vertical-align: middle;"><b><?php echo $userid; ?>님 즐겨찾기</b></span>
</center>
<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>
<h1>
<a href='./apart_home.php'>전체 매매 조회하기</a>
<a style="float:right;" href='./apart_home_rent.php'>전체 전/월세 조회하기</a>
</h1>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-fb+5w+4e-db+86"
     data-ad-client="ca-pub-3758121784656467"
     data-ad-slot="7226824761"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

<h1>매매 리스트</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px;"><b>아파트</b></th>
        <th style="font-size: 20px;"><b>전용면적</b></th>
        <th style="font-size: 20px;"><b>최고가격<br>대비하락</b></th>
        <th style="font-size: 20px;"><b>최근거래</b></th>
        <th style="font-size: 20px;"><b>최고가격</b></th>
        <th style="font-size: 20px;"><b>최저가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px;"><a href='./apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[dong]?>&all_area=N'><b><?=$row['apart_name']?></b><br><?=$row['area_name']?> <?=$row['dong']?></td>
          <td style="font-size: 20px;"><b><?=$row['size']?>㎡</b></td>
          <td style="background-color:rgba(255, 0, 0, 0.3); font-size: 20px;"><b><?=$row['price_last']?>억<br><?=$row['percent']?>% 하락</b></td>
          <td style="font-size: 20px;"><b><?=$row['last_price']?>억</b><br><b><?=$row['last_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['max_price']?>억</b><br><b><?=$row['max_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['min_price']?>억</b><br><b><?=$row['min_price_date']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-fb+5w+4e-db+86"
     data-ad-client="ca-pub-3758121784656467"
     data-ad-slot="7226824761"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

<h1>전세 리스트</h1>
<table>
    <thead>
    <tr>
        <th style="font-size: 20px; background: #809EAD;"><b>아파트</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>전용면적</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>최고가격<br>대비하락</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>최근거래</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>최고가격</b></th>
        <th style="font-size: 20px; background: #809EAD;"><b>최저가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows_rent as $row_rent) { ?>
      <tr>
          <td style="font-size: 20px;"><a href='./apart_rent.php?area_main_name=<?=$row_rent[area_main_name]?>&apart_name=<?=$row_rent[apart_name]?>&size=<?=$row_rent[size]?>&dong=<?=$row_rent[dong]?>&all_area=N'><b><?=$row_rent['apart_name']?></b><br><?=$row_rent['area_name']?> <?=$row_rent['dong']?></td>
          <td style="font-size: 20px;"><b><?=$row_rent['size']?>㎡</b></td>
          <td style="background-color:rgba(255, 0, 0, 0.3); font-size: 20px;"><b><?=$row_rent['price_last']?>억<br><?=$row_rent['percent']?>% 하락</b></td>
          <td style="font-size: 20px;"><b><?=$row_rent['last_price']?>억</b><br><b><?=$row_rent['last_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row_rent['max_price']?>억</b><br><b><?=$row_rent['max_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row_rent['min_price']?>억</b><br><b><?=$row_rent['min_price_date']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

</body>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-fb+5w+4e-db+86"
     data-ad-client="ca-pub-3758121784656467"
     data-ad-slot="7226824761"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : jungsup2.lee@gmail.com</b></span></center>

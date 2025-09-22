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
<title>오늘집값 - 아파트 즐겨찾기</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 즐겨찾기">
<meta property="og:description" content="오늘집값 - 본인이 설정한 실거래 정보 확인">
<meta property="og:image" content="./todayhouseprice2.png">
<meta property="og:url" content="http://todayhouseprice.com/apart_favorite.php">
</head>
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
  $rs = mysqli_query($Conn, "select count(1) as cnt from molit_visit_count where ymd = '$today' and count_type = 'apart_home';");
  $row = mysqli_fetch_assoc($rs);
  if($row['cnt']==0) {
    mysqli_query($Conn, "insert into molit_visit_count (ymd, count, count_type) values('$today',1,'apart_home');");
  }else{
    mysqli_query($Conn, "update molit_visit_count set count = count + 1 where ymd = '$today' and count_type = 'apart_home';");
  }
}
/////////////////////조회수//////////////////////////
$user_update = $_REQUEST["user_update"];



mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

if($userid){
  if($user_update=="true"){
    $area_main_name = $_REQUEST["area_main_name"];
    $size1 = $_REQUEST["size1"];
    $size2 = $_REQUEST["size2"];
    $size3 = $_REQUEST["size3"];
    $size4 = $_REQUEST["size4"];

    mysqli_query($Conn, "update user set area_main_name = '$area_main_name', size1 = '$size1', size2 = '$size2', size3 = '$size3', size4 = '$size4'  where id = '$userid';");

  }else{
    $sql_select_user = "
      select area_main_name, size1, size2, size3, size4 from user where id = '$userid'
    ";
    $rs_user = mysqli_query($Conn, $sql_select_user);
    $row_user = mysqli_fetch_assoc($rs_user);

    if($row_user['area_main_name']!=""){
      $area_main_name = $row_user['area_main_name'];
      $size1 = $row_user['size1'];
      $size2 = $row_user['size2'];
      $size3 = $row_user['size3'];
      $size4 = $row_user['size4'];
    }else{
      mysqli_query($Conn, "update user set area_main_name = '전체', size1 = 'false', size2 = 'true', size3 = 'true', size4 = 'false'  where id = '$userid';");
      $area_main_name = "전체";
      $size1 = "false";
      $size2 = "true";
      $size3 = "true";
      $size4 = "false";
    }
  }
}

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
      from molit_max_min_all_group
      where (area_main_name, dong, apart_name, size) in (select area_main_name, dong, apart_name, ROUND(CAST(size as DECIMAL(10,5))) from molit_favorite where userid = '$userid')
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
      from molit_max_min_rent_all_group
      where (area_main_name, dong, apart_name, size) in (select area_main_name, dong, apart_name, ROUND(size) from molit_favorite where userid = '$userid')
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
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count),0),0) AS total,
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count WHERE YMD = '$today'),0),0) AS today
FROM DUAL;
";
$rs_count = mysqli_query($Conn, $sql_count);
$row_count = mysqli_fetch_assoc($rs_count);

?>
<?php
  if(!$userid){
?>
<a style="font-size:25px;" href="./login.php"><b>로그인</b></a>  <a style="font-size:25px;" href='./info.php'>(텔레그램으로 매일 알림받기)</a>
<?php
  }else if($userid){
    //$logged = $username."(".$userid.")";
    $logged = $userid;
?>
<span style="font-size:25px;"><b><?=$logged ?>님 </b></span><a style="font-size:25px;" href="./logout.php"><b>로그아웃</b></a>  <a style="font-size:25px;" href="./apart_favorite.php"><b>즐겨찾기</b></a>  <a style="font-size:25px;" href='./info.php'>(텔레그램으로 매일 알림받기)</a>
<?php }?>

<?php if($userid=="ljs1092"){?>
<span style="font-size:25px; float:right;"><b>Total : <?=$row_count['total']?>, Today : <?=$row_count['today']?></b></span>
<?php }else{?>
<span style="font-size:25px; float:right;"><b><a href="./list.php" style="text-decoration-line: none;"><b>[자유게시판]</b></a><a href="./apart_news.php" style="text-decoration-line: none;"><b>[부동산뉴스]</b></a></b></span>
<?php }?>
<br><span style="font-size:20px;"><b>거래 상세리스트 화면에서 하트모양을 클릭하시면 즐겨찾기 할 수 있습니다.</b></span><img style="vertical-align: middle;" width="25", height="25" src="./hearts_empty.png" ><img style="vertical-align: middle;" width="25", height="25" src="./hearts_full.png" >
<table>
    <thead>
    <tr>
      <th style="background: #C0C0C0; width:25%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;"><center>아파트</center></th>
      <th style="background: #DEEBF7; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../officetel/apart_favorite.php'>오피스텔</a></center></th>
      <th style="background: #E2F0D9; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../billa/apart_favorite.php'>다세대주택(빌라)</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매 상세조회</a></center></th>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home_rent.php?user_update=true'>전월세 상세조회</a></center></th>
      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'>부동산 통계</a></center></th>
      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값 랭킹</a></center></th>
      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./list.php'>자유게시판</a></center></th>
    </tr>
  </thead>
</table>
<br>
<center>
<a href="./apart_today.php"><img style="vertical-align: middle;" width="100", height="100" src="./todayhouseprice2.png"></a>
<span style="font-size:60px; vertical-align: middle; font-family: nanumpen;">&nbsp;&nbsp;오늘집값</span>
</center>
<br>
<span style="font-size:35px;"><b>개인 즐겨찾기 저장(선택시 자동저장)</b></span>
<br>
<span style="font-size:30px;"><b>선호지역 선택 : </b></span><select style="width:220px;font-size:30px;" name="main" id="main" onchange="apart_list(this)">
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

<form name="mform">
 <span style="font-size:30px;"><b>사이즈 선택 : </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size1" onclick="check1(this)" <?php if($size1=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>전용40 ㎡이하 </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size2" onclick="check2(this)" <?php if($size2=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>전용40-60 ㎡ </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size3" onclick="check3(this)" <?php if($size3=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>전용60-85 ㎡ </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size4" onclick="check4(this)" <?php if($size4=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>전용85 ㎡초과</b></span>
</form>

<script>
function check1(country){
  location.href = "./apart_favorite.php?user_update=true&area_main_name="+document.getElementById("main").value+"&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check2(country){
  location.href = "./apart_favorite.php?user_update=true&area_main_name="+document.getElementById("main").value+"&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check3(country){
  location.href = "./apart_favorite.php?user_update=true&area_main_name="+document.getElementById("main").value+"&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check4(country){
  location.href = "./apart_favorite.php?user_update=true&area_main_name="+document.getElementById("main").value+"&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function apart_list(e) {
  location.href = "./apart_favorite.php?user_update=true&area_main_name="+document.getElementById("main").value+"&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
</script>
<!--
<h1>
<a href='./apart_home.php'>전체 매매 조회하기</a>
<a style="float:right;" href='./apart_home_rent.php'>전체 전/월세 조회하기</a>
</h1>
-->
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

<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : todayhouseprice.com@gmail.com</b></span></center>

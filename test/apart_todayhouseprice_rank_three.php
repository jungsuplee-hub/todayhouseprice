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
<title>오늘집값 - 아파트 랭킹(최고가격 Top 100)</title>
<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 아파트 랭킹(최고가격 Top 100)">
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
$area_main_name = $_REQUEST["area_main_name"];

$size1 = $_REQUEST["size1"];
$size2 = $_REQUEST["size2"];
$size3 = $_REQUEST["size3"];
$size4 = $_REQUEST["size4"];

if ($area_main_name==""){
  $size1 = "true";
  $size2 = "true";
  $size3 = "true";
  $size4 = "true";
  $area_main_name="전체";
}

$size1_text = "";
$size2_text = "";
$size3_text = "";
$size4_text = "";

if($size1=="true"){
  $size1_text = "or cast(size as decimal(10,2)) <= 40";
}
if($size2=="true"){
  $size2_text = "or (cast(size as decimal(10,2)) > 40 and cast(size as decimal(10,2)) <= 60)";
}
if($size3=="true"){
  $size3_text = "or (cast(size as decimal(10,2)) > 60 and cast(size as decimal(10,2)) <= 85)";
}
if($size4=="true"){
  $size4_text = "or cast(size as decimal(10,2)) > 85";
}

if ($area_main_name=="전체"){
  $area_main_name_text = "1=1";
}else{
  $area_main_name_text = "area_main_name = '$area_main_name'";
}

//SELECT replace(area_sub_name,' ','') as area_sub_name FROM molit_area_info where area_main_name = '$area_main_name' order by area_sub_name


$sql = "
select
area_main_name,
area_name,
dong,
apart_name,
size,
ROUND(CAST(max_price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5)),2) as diff_price,
ROUND(100-(CAST(last_price as DECIMAL(10,5))/CAST(max_price as DECIMAL(10,5))*100) ,2) as diff_rate,
max_price,
max_price_date
from molit_max_min_all_group meme
where (1!=1 $size1_text $size2_text $size3_text $size4_text)
and $area_main_name_text
and (max_price_date like '2022%' or max_price_date like '2023%' or max_price_date like '2024%')
order by CAST(max_price as DECIMAL(10,5)) desc
limit 100;
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
      <th style="background: #C0C0C0; width:25%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;"><center>아파트</center></th>
      <th style="background: #DEEBF7; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../officetel/apart_todayhouseprice_rank_three.php'>오피스텔</a></center></th>
      <th style="background: #E2F0D9; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../billa/apart_todayhouseprice_rank_three.php'>다세대주택(빌라)</a></center></th>
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
      <th style="background: #73685d; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값 랭킹</a></center></th>
      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./list.php'>자유게시판</a></center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:25%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>하락금액 Top 100</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:25%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_todayhouseprice_rank_two.php'>하락률 Top 100</a></center></th>
      <th style="background-color:rgba(0, 0, 0, 0.3); width:25%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_three.php'>가격 Top 100</a></center></th>
      <th style="background-color:rgba(255, 255, 255, 0.8); width:25%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:black; text-decoration: none;" href='./apart_todayhouseprice_rank_four.php'>가격 하위 Top 100</a></center></th>
    </tr>
  </thead>
</table>
<br>
<center>
<a href="./apart_today.php"><img style="vertical-align: middle;" width="100", height="100" src="./todayhouseprice2.png"></a>
<span style="font-size:60px; vertical-align: middle; font-family: nanumpen;">&nbsp;&nbsp;오늘집값</span>
</center>
<br>



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

<span style="font-size:30px;"><b>지역 : </b></span><select style="width:220px;font-size:30px;" name="main" id="main" onchange="apart_list(this)">
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
  location.href = "./apart_todayhouseprice_rank_three.php?area_main_name=<?=$area_main_name?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check2(country){
  location.href = "./apart_todayhouseprice_rank_three.php?area_main_name=<?=$area_main_name?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check3(country){
  location.href = "./apart_todayhouseprice_rank_three.php?area_main_name=<?=$area_main_name?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check4(country){
  location.href = "./apart_todayhouseprice_rank_three.php?area_main_name=<?=$area_main_name?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
</script>


<h1><?=$area_main_name?> 아파트 최고가격 Top 100</h1>
<span style="font-size: 20px;">*참고<br>. 거래취소 내용이 반영되지 않은 케이스가 일부 있을 수 있습니다.<br>. 2022년 이후 거래기준 입니다.</span>
<br><br>



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



<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:5%;"><b>순위</b></th>
        <th style="font-size: 20px; width:40%;"><b>아파트명<br>지역</b></th>
        <th style="font-size: 20px; width:17%;"><b>전용면적</b></th>
        <!--<th style="font-size: 20px; width:15%;"><b>하락금액<br>하락률</b></th>-->
        <th style="font-size: 20px; width:18%;"><b>최고가격</b></th>
        <th style="font-size: 20px; width:18%;"><b>거래날자</b></th>

        <!--<th style="font-size: 20px; width:13%;"><b>최저가격</b><br>(최저전세)</th>-->
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows as $row) { if($add_count!=0 && fmod($add_count, 10)==0){echo '<tr><td colspan="6"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2265060002718871" data-ad-slot="3474043280"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></td></tr>';} $add_count = $add_count + 1; ?>
      <tr>
          <td style="font-size: 30px;"><b><?=$add_count?></b></td>
          <td style="font-size: 20px;"><a href='./apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[dong]?>&all_area=N'><b><span style="font-size: 27px;"><?=$row['apart_name']?></span></b><br><?=$row['area_name']?> <?=$row['dong']?></td>
          <td style="font-size: 20px;"><b><?=$row['size']?>㎡</b></td>
          <!--<td style="font-size: 20px;"><b>-<?=$row['diff_price']?>억<br><?php if($row['diff_rate']>50){ echo "<span style='color:fuchsia;'>"; }else if($row['diff_rate']>30){ echo "<span style='color:red;'>"; } ?><?=$row['diff_rate']?>%<?php if($row['diff_rate']>30){ echo "</span>"; } ?></b></td>-->
          <td style="font-size: 20px;"><b><?=$row['max_price']?>억</b></td>
          <td style="font-size: 20px;"><b><?=$row['max_price_date']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

<script>
function apart_list(e) {
  <?php echo "window.location.replace('./apart_todayhouseprice_rank_three.php?'+'area_main_name='+document.getElementById('main').value+'&size1=$size1'+'&size2=$size2'+'&size3=$size3'+'&size4=$size4');"?>
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

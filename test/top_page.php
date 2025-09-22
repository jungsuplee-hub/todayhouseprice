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

$this_site = $_SERVER[ "REQUEST_URI" ];


?>
<center>
<span style="font-size:20px;">기준금리 : </span>
<a href="https://m.search.naver.com/search.naver?where=m&sm=mtb_etc&mra=blJH&qvt=0&query=%EB%8C%80%ED%95%9C%EB%AF%BC%EA%B5%AD%20%EC%A4%91%EC%95%99%EC%9D%80%ED%96%89%20%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC"><img style="vertical-align:top;" width="44", height="24" src="./kor.png"></a>
<span style="font-size:20px;"><?=$row_today['gumri_korea']?></span>
&nbsp;
<a href="https://m.search.naver.com/p/crd/rd?m=1&px=736&py=298&sx=736&sy=298&p=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&q=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&ie=utf8&rev=1&ssc=tab.m.all&f=m&w=m&s=LoFy%2FTw7JT27hrVNgxlLxg%3D%3D&time=1672725258737&abt=%5B%7B%22eid%22%3A%22PWL-AREA-EX%22%2C%22vid%22%3A%222%22%7D%2C%7B%22eid%22%3A%22SBR1%22%2C%22vid%22%3A%22634%22%7D%5D&a=nco_xgr*3.list&r=1&i=88211u5i_000000000000&u=https%3A%2F%2Fm.search.naver.com%2Fsearch.naver%3Fwhere%3Dm%26sm%3Dmtb_etc%26mra%3DblJH%26qvt%3D0%26query%3D%25EB%25AF%25B8%25EA%25B5%25AD%2520%25EC%25A4%2591%25EC%2595%2599%25EC%259D%2580%25ED%2596%2589%2520%25EA%25B8%25B0%25EC%25A4%2580%25EA%25B8%2588%25EB%25A6%25AC&cr=1"><img style="vertical-align: top;" width="44", height="24" src="./usa.png"></a>
<span style="font-size:20px;"><?=$row_today['gumri_usa']?></span>
&nbsp;&nbsp;
<a href="https://m.search.naver.com/search.naver?sm=mtb_hty.top&where=m&oquery=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&tqi=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&query=%ED%99%98%EC%9C%A8"><img style="vertical-align: top;" width="24", height="24" src="./dallor.png"></a>
<span style="font-size:20px;">환율: <?=$row_today['dallor']?>원</span>

&nbsp;&nbsp;
<a href="https://finance.naver.com/sise/"><img style="vertical-align: top;" width="35", height="24" src="./chart.png"></a>
<span style="font-size:20px;">코스피 : <?=$row_today['kospi']?></span>
<br>
<span style="font-size:15px;">(updated : <?=$row_today['update_date']?>)</span>
</center>
<br>
<?php
  if(!$userid){
?>
<a style="font-size:25px;" href="./login.php?site=apart_today"><b>로그인</b></a><span style="font-size:25px;"><b> <--즐겨찾기 기능사용</b></span>  <a style="font-size:25px;" href='./info.php'>(텔레그램으로 매일 알림받기)</a>
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
<table>
    <thead>
    <tr>
<?php
      if (strpos($this_site,'officetel')) {
				echo "<th style='background: #FBE5D6; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../apart_today.php?user_update=true'>아파트</a></center></th>";
				echo "<th style='background: #C0C0C0; width:25%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;'><center>오피스텔</center></th>";
				echo "<th style='background: #E2F0D9; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../billa/apart_today.php?user_update=true'>다세대주택(빌라)</a></center></th>";
			}elseif (strpos($this_site,'billa')) {
				echo "<th style='background: #FBE5D6; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../apart_today.php?user_update=true'>아파트</a></center></th>";
				echo "<th style='background: #DEEBF7; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../officetel/apart_today.php?user_update=true'>오피스텔</a></center></th>";
				echo "<th style='background: #C0C0C0; width:25%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;'><center>다세대주택(빌라)</center></th>";
			}else{
				echo "<th style='background: #C0C0C0; width:25%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;'><center>아파트</center></th>";
	      echo "<th style='background: #DEEBF7; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../officetel/apart_today.php?user_update=true'>오피스텔</a></center></th>";
	      echo "<th style='background: #E2F0D9; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;'><center><a style='text-decoration: none;' href='../billa/apart_today.php?user_update=true'>다세대주택(빌라)</a></center></th>";
			}
?>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background: <?php if (strpos($this_site,'apart_today.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
      <th style="background: <?php if (strpos($this_site,'apart_home.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매 상세조회</a></center></th>
      <th style="background: <?php if (strpos($this_site,'apart_home_rent.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home_rent.php?user_update=true'>전월세 상세조회</a></center></th>
      <th style="background: <?php if (strpos($this_site,'apart_trend.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'>부동산 통계</a></center></th>
      <th style="background: <?php if (strpos($this_site,'apart_todayhouseprice_rank_one.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값 랭킹</a></center></th>
      <th style="background: <?php if (strpos($this_site,'list.php')) { echo '#73685d;';} else {echo '#809EAD;';} ?> width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./list.php'>자유게시판</a></center></th>
    </tr>
  </thead>
</table>
<br>
<center>
<a href="./apart_today.php"><img style="vertical-align: middle;" width="100", height="100" src="./todayhouseprice2.png"></a>
<span style="font-size:60px; vertical-align: middle; font-family: nanumpen;">&nbsp;&nbsp;오늘집값</span>
</center>
<br>

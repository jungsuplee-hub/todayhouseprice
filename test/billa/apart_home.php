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
<title>오늘집값 - 빌라 매매 상세 조회</title>
<meta name="description" content="빌라 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
<meta property="og:type" content="website">
<meta property="og:title" content="오늘집값 - 빌라 매매 상세검색">
<meta property="og:description" content="오늘집값 - 빌라 매매  정보를 상세히 검색 할 수 있습니다.">
<meta property="og:image" content="./todayhouseprice2.png">
<meta property="og:url" content="http://todayhouseprice.com/apart_home.php">
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
$area_main_name = $_REQUEST["area_main_name"];
$area_sub_name = $_REQUEST["area_sub_name"];
$dong = $_REQUEST["dong"];
$apart_name = $_REQUEST["apart_name"];
$orderby = $_REQUEST["orderby"];
$main = $_REQUEST["main"];

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
}elseif($area_main_name==""){
  $area_main_name = "서울특별시";
  $area_sub_name= "강남구";
}

if ($orderby=="" or $orderby=="latest_date"){
  $orderby = "latest_date";
  $orderbytest = "order by date_format(meme.last_price_date,'%Y-%m-%d') desc";
}elseif ($orderby=="max_lastest"){
  $orderbytest = "order by cast(meme.last_price as DECIMAL(10,5)) desc";
}elseif ($orderby=="max_all"){
  $orderbytest = "order by cast(meme.max_price as DECIMAL(10,5)) desc";
}elseif ($orderby=="name"){
  $orderbytest = "order by meme.apart_name, meme.size";
}elseif ($orderby=="diff_price"){
  $orderbytest = "and meme.last_price != '0' order by ROUND((CAST(meme.max_price as DECIMAL(10,5)) - CAST(meme.last_price as DECIMAL(10,5))),2) desc";
}

$area_main_sub_name = $area_main_name.$area_sub_name;
if ($area_main_name==$area_sub_name)
{
  $area_main_sub_name = "";
}

if ( $main == '1'){
  $main_text = "AND cast(meme.size as DECIMAL(10,5)) > '49.99999'";
}elseif ($main == ''){
  $main = "0";
  $main_text = "";
}else{
  $main = "0";
  $main_text = "";
}


if($area_sub_name!=''){
  $sql = "
        select
          meme.area_main_name,
        	meme.area_name,
        	meme.apart_name,
        	meme.size,
        	meme.dong,
        	meme.max_price,
        	meme.min_price,
        	meme.last_price,
        	meme.max_price_date,
        	meme.min_price_date,
        	meme.last_price_date,
        	ROUND((CAST(meme.max_price as DECIMAL(10,5)) - CAST(meme.last_price as DECIMAL(10,5))),2) as price_last,
        	ROUND(100-(CAST(meme.last_price as DECIMAL(10,5))/CAST(meme.max_price as DECIMAL(10,5)))*100,0) AS percent,
          IFNULL(rent.last_price,0) AS rent_last_price,
          IFNULL(rent.max_price,0) AS rent_max_price,
          IFNULL(rent.min_price,0) AS rent_min_price,
          IFNULL(ROUND(rent.last_price/meme.last_price*100),0) as rent_rate
        from molit_max_min_all_billa_group meme LEFT join molit_max_min_rent_all_billa_group rent
        ON meme.area_main_name = rent.area_main_name
        AND meme.dong = rent.dong
        AND meme.apart_name = rent.apart_name
        AND meme.size = rent.size
        where meme.area_main_name = '$area_main_name'
        and replace(meme.area_name,' ','') like '%$area_main_sub_name%'
        and replace(meme.dong,' ','') like '%$dong%'
        and replace(meme.apart_name,' ','') like '%$apart_name%'
        $main_text
        $orderbytest
        limit 100
        ";
}else{
  $sql = "";
}




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

?>
<?php
  if(!$userid){
?>
<a style="font-size:25px;" href="./login.php"><b>로그인</b></a><span style="font-size:25px;"><b> <--즐겨찾기 기능사용</b></span>  <a style="font-size:25px;" href='./info.php'>(텔레그램으로 매일 알림받기)</a>
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
<span style="font-size:25px; float:right;"><b><a href="./list.php" style="text-decoration-line: none;"><b>[자유게시판]</b></a><a href="../apart_news.php" style="text-decoration-line: none;"><b>[부동산뉴스]</b></a></b></span>
<?php }?>
<table>
    <thead>
    <tr>
      <th style="background: #FBE5D6; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../apart_home.php?area_main_name=<?=$area_main_name?>&area_sub_name=<?=$area_sub_name?>&dong=<?=$dong?>&apart_name=<?=$apart_name?>&orderby=<?=$orderby?>'>아파트</a></center></th>
      <th style="background: #DEEBF7; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../officetel/apart_home.php?area_main_name=<?=$area_main_name?>&area_sub_name=<?=$area_sub_name?>&dong=<?=$dong?>&apart_name=<?=$apart_name?>&orderby=<?=$orderby?>'>오피스텔</a></center></th>
      <th style="background: #C0C0C0; width:25%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;"><center>다세대주택(빌라)</center></th>
    </tr>
  </thead>
</table>
<table>
    <thead>
    <tr>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
      <th style="background: #73685d; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매 상세조회</a></center></th>
      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home_rent.php?user_update=true'>전월세 상세조회</a></center></th>
      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'>거래량</a></center></th>
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






<span style="font-size:30px;"><b>지역 : </b></span><select style="width:200px;font-size:30px;" name="main" id="main" onchange="categoryChange(this)">
<option>지역선택</option>
<?php
$rs_select = mysqli_query($Conn, "SELECT area_main_name FROM molit_area_info group by area_main_name ORDER BY MIN(area_code_seq)");
while ( $row_select = mysqli_fetch_assoc($rs_select) ) {
    $rows_select[] = $row_select;
}

foreach ($rows_select as $row_select) { ?>
  <option value=<?php echo $row_select['area_main_name']; if ($row_select['area_main_name']==$area_main_name){echo ' selected';}?>><?php echo $row_select['area_main_name']; ?></option>
<?php } ?>
</select>






<span style="font-size:30px;"><b>시/군/구 : </b></span><select style="width:160px;font-size:30px;" name="sub" id="sub" onchange="apart_list(this)">
<!--
<option value=<?php if($area_sub_name!=''){echo $area_sub_name;}?>><?php if($area_sub_name!=''){echo $area_sub_name;}?></option>
</select>
-->
<option>선택</option>
<?php
$rs2_select = mysqli_query($Conn, "SELECT replace(area_sub_name,' ','') as area_sub_name FROM molit_area_info where area_main_name = '$area_main_name' order by area_sub_name");
while ( $row2_select = mysqli_fetch_assoc($rs2_select) ) {
    $rows2_select[] = $row2_select;
}

foreach ($rows2_select as $row2_select) { ?>
  <option value=<?php echo $row2_select['area_sub_name']; if ($row2_select['area_sub_name']==$area_sub_name){echo ' selected';}?>><?php echo $row2_select['area_sub_name']; ?></option>
<?php } ?>
</select>







<span style="font-size:30px;"><b>읍/면/동 : </b></span><select style="width:180px;font-size:30px;" name="dong" id="dong" onchange="apart_dong_list(this)">
<option value=''>선택</option>
<?php
$rs3_select = mysqli_query($Conn, "select replace(dong,' ','') as dong from billa_dong where area_main_name = '$area_main_name' and replace(area_sub_name,' ','') = replace('$area_sub_name','$area_main_name','') group by area_main_name, area_sub_name, dong");
while ( $row3_select = mysqli_fetch_assoc($rs3_select) ) {
    $rows3_select[] = $row3_select;
}

foreach ($rows3_select as $row3_select) { ?>
  <option value=<?php echo $row3_select['dong']; if ($row3_select['dong']==$dong){echo ' selected';}?>><?php echo $row3_select['dong']; ?></option>
<?php } ?>
</select>


<br>
<span style="font-size:30px;"><b>주택명 : </b></span><select style="width:200px;font-size:30px;" name="apart_name" id="apart_name" onchange="apart_apart_list(this)">
<option value=''>선택</option>
<?php
$rs4_select = mysqli_query($Conn, "select replace(apart_name,' ','') as apart_name from billa_dong where area_main_name = '$area_main_name' and replace(area_sub_name,' ','') = replace('$area_sub_name','$area_main_name','') and replace(dong,' ','') = '$dong' group by area_main_name, area_sub_name, dong, apart_name");
while ( $row4_select = mysqli_fetch_assoc($rs4_select) ) {
    $rows4_select[] = $row4_select;
}

foreach ($rows4_select as $row4_select) { ?>
  <option value=<?php echo $row4_select['apart_name']; if ($row4_select['apart_name']==$apart_name){echo ' selected';}?>><?php echo $row4_select['apart_name']; ?></option>
<?php } ?>
</select>




<span style="font-size:30px;"><b>정렬방식 : </b></span><select style="width:210px;font-size:30px;" name="orderby" id="orderby" onchange="apart_orderby(this)">
	<option value="latest_date" <?php if($orderby=='latest_date'){echo 'selected';}?>>최근거래날짜</option>
	<option value="diff_price" <?php if($orderby=='diff_price'){echo 'selected';}?>>최고대비하락</option>
	<option value="max_lastest" <?php if($orderby=='max_lastest' or $orderby==''){echo 'selected';}?>>최근최고가격</option>
	<option value="max_all" <?php if($orderby=='max_all'){echo 'selected';}?>>역대최고가격</option>
	<option value="name" <?php if($orderby=='name'){echo 'selected';}?>>이름순</option>

</select>




<span style="font-size:30px;"><b>50㎡이상: </b></span><select style="width:90px;font-size:30px;" name="main_size" id="main_size" onchange="apart_main(this)">
	<option value="1" <?php if($main=='1'){echo 'selected';}?>>Y</option>
	<option value="0" <?php if($main=='0'){echo 'selected';}?>>N</option>
</select>


<script>
function categoryChange(e) {

	var good_kangwon = ["강릉시","고성군","동해시","삼척시","속초시","양구군","양양군","영월군","원주시","인제군","정선군","철원군","춘천시","태백시","평창군","홍천군","화천군","횡성군"];
	var good_gyeonggi = ["가평군","고양시덕양구","고양시일산동구","고양시일산서구","과천시","광명시","광주시","구리시","군포시","김포시","남양주시","동두천시","부천시","성남시분당구","성남시수정구","성남시중원구","수원시권선구","수원시영통구","수원시장안구","수원시팔달구","시흥시","안산시단원구","안산시상록구","안성시","안양시동안구","안양시만안구","양주시","양평군","여주시","연천군","오산시","용인시기흥구","용인시수지구","용인시처인구","의왕시","의정부시","이천시","파주시","평택시","포천시","하남시","화성시"];
	var good_gyeongnam = ["거제시","거창군","고성군","김해시","남해군","밀양시","사천시","산청군","양산시","의령군","진주시","창녕군","창원시마산합포구","창원시마산회원구","창원시성산구","창원시의창구","창원시진해구","통영시","하동군","함안군","함양군","합천군"];
	var good_gyeongbuk = ["경산시","경주시","고령군","구미시","군위군","김천시","문경시","봉화군","상주시","성주군","안동시","영덕군","영양군","영주시","영천시","예천군","울릉군","울진군","의성군","청도군","청송군","칠곡군","포항시남구","포항시북구"];
	var good_gwangju = ["광산구","남구","동구","북구","서구"];
	var good_daegu = ["남구","달서구","달성군","동구","북구","서구","수성구","중구"];
	var good_daejun = ["대덕구","동구","서구","유성구","중구"];
	var good_busan = ["강서구","금정구","기장군","남구","동구","동래구","부산진구","북구","사상구","사하구","서구","수영구","연제구","영도구","중구","해운대구"];
	var good_seoul = ["강남구","강동구","강북구","강서구","관악구","광진구","구로구","금천구","노원구","도봉구","동대문구","동작구","마포구","서대문구","서초구","성동구","성북구","송파구","양천구","영등포구","용산구","은평구","종로구","중구","중랑구"];
	var good_sejong = ["세종특별자치시"];
	var good_ulsan = ["남구","동구","북구","울주군","중구"];
	var good_incheon = ["강화군","계양구","남동구","동구","미추홀구","부평구","서구","연수구","옹진군","중구"];
	var good_junnam = ["강진군","고흥군","곡성군","광양시","구례군","나주시","담양군","목포시","무안군","보성군","순천시","신안군","여수시","영광군","영암군","완도군","장성군","함평군","해남군","화순군"];
	var good_junbuk = ["고창군","군산시","김제시","남원시","무주군","순창군","완주군","익산시","임실군","장수군","전주시 덕진구","전주시 완산구","정읍시","진안군"];
	var good_jeju = ["서귀포시","제주시"];
	var good_chungnam = ["계룡시","공주시","금산군","논산시","당진시","보령시","부여군","서산시","서천군","아산시","예산군","천안시동남구","천안시서북구","청양군","태안군","홍성군"];
	var good_chungbuk = ["괴산군","단양군","보은군","영동군","옥천군","음성군","제천시","증평군","진천군","청주시상당구","청주시서원구","청주시청원구","청주시흥덕구","충주시"];

	var target = document.getElementById("sub");

	if(e.value == "강원도") var d = good_kangwon;
  else if(e.value == "경기도") var d = good_gyeonggi;
  else if(e.value == "경상남도") var d = good_gyeongnam;
  else if(e.value == "경상북도") var d = good_gyeongbuk;
  else if(e.value == "광주광역시") var d = good_gwangju;
  else if(e.value == "대구광역시") var d = good_daegu;
  else if(e.value == "대전광역시") var d = good_daejun;
  else if(e.value == "부산광역시") var d = good_busan;
  else if(e.value == "서울특별시") var d = good_seoul;
  else if(e.value == "세종특별자치시") var d = good_sejong;
  else if(e.value == "울산광역시") var d = good_ulsan;
  else if(e.value == "인천광역시") var d = good_incheon;
  else if(e.value == "전라남도") var d = good_junnam;
  else if(e.value == "전라북도") var d = good_junbuk;
  else if(e.value == "제주특별자치도") var d = good_jeju;
  else if(e.value == "충청남도") var d = good_chungnam;
  else if(e.value == "충청북도") var d = good_chungbuk;


	target.options.length = 0;

  var opt = document.createElement("option");
  opt.value = "선택";
	opt.innerHTML = "선택";
	target.appendChild(opt);

	for (x in d) {
		var opt = document.createElement("option");
		opt.value = d[x];
		opt.innerHTML = d[x];
		target.appendChild(opt);
	}
}

function apart_list(e) {
  window.location.replace("./apart_home.php?"
  +"area_main_name="+document.getElementById('main').value
  +"&area_sub_name="+document.getElementById('sub').value
  +"&main="+document.getElementById('main_size').value
  +"&orderby="+document.getElementById('orderby').value);
}

function apart_orderby(e) {
  window.location.replace("./apart_home.php?"
  +"area_main_name="+document.getElementById('main').value
  +"&area_sub_name="+document.getElementById('sub').value
  +"&dong="+document.getElementById('dong').value
  +"&apart_name="+document.getElementById('apart_name').value
  +"&main="+document.getElementById('main_size').value
  +"&orderby="+document.getElementById('orderby').value);
}

function apart_dong_list(e) {
  window.location.replace("./apart_home.php?"
  +"area_main_name="+document.getElementById('main').value
  +"&area_sub_name="+document.getElementById('sub').value
  +"&dong="+document.getElementById('dong').value
  +"&main="+document.getElementById('main_size').value
  +"&orderby="+document.getElementById('orderby').value);
}

function apart_apart_list(e) {
  window.location.replace("./apart_home.php?"
  +"area_main_name="+document.getElementById('main').value
  +"&area_sub_name="+document.getElementById('sub').value
  +"&dong="+document.getElementById('dong').value
  +"&apart_name="+document.getElementById('apart_name').value
  +"&main="+document.getElementById('main_size').value
  +"&orderby="+document.getElementById('orderby').value);
}

function apart_main(e) {
  window.location.replace("./apart_home.php?"
  +"area_main_name="+document.getElementById('main').value
  +"&area_sub_name="+document.getElementById('sub').value
  +"&dong="+document.getElementById('dong').value
  +"&apart_name="+document.getElementById('apart_name').value
  +"&main="+document.getElementById('main_size').value
  +"&orderby="+document.getElementById('orderby').value);
}
</script>
<br>
<span style="font-size:20px;"><?php if ($area_main_name!="지역선택") {echo $area_main_name;} ?> <?php if ($area_main_name!="지역선택") {echo $area_sub_name;} ?> <?php echo $dong; ?> 실거래 리스트(2017년 이후), 검색조건당 최대 100개 조회</span>


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
        <th style="font-size: 20px; width:35%;"><b>주택명</b></th>
        <th style="font-size: 20px; width:11%;"><b>전용면적</b></th>
        <th style="font-size: 20px; width:13%;"><b>최고가격<br>대비하락<br>(전세가율)</b></th>
        <th style="font-size: 20px; width:14%;"><b>최근거래<br>(최근전세)</b></th>
        <th style="font-size: 20px; width:14%;"><b>최고가격<br>(최고전세)</b></th>
        <th style="font-size: 20px; width:14%;"><b>최저가격<br>(최저전세)</b></th>
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows as $row) { if($add_count!=0 && fmod($add_count, 15)==0){echo '<tr><td colspan="6"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2265060002718871" data-ad-slot="3474043280"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></td></tr>';} $add_count = $add_count + 1; ?>
      <tr>
          <td style="font-size: 20px;"><a href='./apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[dong]?>&all_area=N'><b><?=$row['apart_name']?></b><br><?=$row['area_name']?> <?=$row['dong']?></td>
          <td style="font-size: 20px;"><b><?=$row['size']?>㎡</b></td>
          <td style="background-color:rgba(255, 0, 0, 0.3); font-size: 20px;"><b><?=$row['price_last']?>억<br><?=$row['percent']?>% 하락</b><br>(<?=$row['rent_rate']?>%)</td>
          <td style="font-size: 20px;"><b><?=$row['last_price']?>억</b><br><?=$row['last_price_date']?><br>(<?=$row['rent_last_price']?>억)</td>
          <td style="font-size: 20px;"><b><?=$row['max_price']?>억</b><br><?=$row['max_price_date']?><br>(<?=$row['rent_max_price']?>억)</td>
          <td style="font-size: 20px;"><b><?=$row['min_price']?>억</b><br><?=$row['min_price_date']?><br>(<?=$row['rent_min_price']?>억)</td>
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

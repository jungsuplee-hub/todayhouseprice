<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<link rel="stylesheet" type="text/css" href="./test.css">
<link rel="stylesheet" type="text/css" href="./button.css">
<?php

$area_main_name = $_REQUEST["area_main_name"];
$area_sub_name = $_REQUEST["area_sub_name"];
$dong = $_REQUEST["dong"];
$apart_name = $_REQUEST["apart_name"];
$orderby = $_REQUEST["orderby"];
$main = $_REQUEST["main"];

$today = date("Y-m-d");

if ($orderby=="" or $orderby=="latest_date"){
  $orderby = "latest_date";
  $orderbytest = "date_format(last_price_date,'%Y-%m-%d') desc";
}elseif ($orderby=="max_lastest"){
  $orderbytest = "cast(last_price as decimal(10,2)) desc";
}elseif ($orderby=="max_all"){
  $orderbytest = "cast(max_price as decimal(10,2)) desc";
}elseif ($orderby=="name"){
  $orderbytest = "apart_name, size";
}

$area_main_sub_name = $area_main_name.$area_sub_name;
if ($area_main_name==$area_sub_name)
{
  $area_main_sub_name = "";
}

if ( $main == "1"){
  $main_text = "AND cast(size as decimal(10,2)) > '49.99'";
}else{
  $main_text = "";
  $main = "0";
}

$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);

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
      	last_price_date
      from molit_max_min_all
      where area_main_name = '$area_main_name'
      and replace(area_name,' ','') like '%$area_main_sub_name%'
      and replace(dong,' ','') like '%$dong%'
      and replace(apart_name,' ','') like '%$apart_name%'
      $main_text
      order by $orderbytest
      ";

mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

if ($area_main_name == ""){
  $rs = mysqli_query($Conn, "select count(1) as cnt from molit_visit_count where ymd = '$today' and count_type = 'apart_home';");
  $row = mysqli_fetch_assoc($rs);
  if($row['cnt']==0) {
    mysqli_query($Conn, "insert into molit_visit_count (ymd, count, count_type) values('$today',1,'apart_home');");
  }else{
    mysqli_query($Conn, "update molit_visit_count set count = count + 1 where ymd = '$today' and count_type = 'apart_home';");
  }
  
}


$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

?>
<h1><center>전국 아파트 실거래가 조회</center></h1>


<button class="large button" disabled><a href="https://naver.com/">실거래조회 홈페이지</a></button>
<button class="large red button" disabled><a href="https://naver.com/">금일 신규거래 리스트</a></button>
<button class="large green button" disabled><a href="https://naver.com/">텔레그램 알림정보</a></button>
<button class="large blue button" disabled>Button</button>

<a href="http://1.239.38.238:8880/apart_today.php?area_main_name=전체&insert_date=<?=$today?>&main=<?=$main?>">금일 신규거래 리스트 바로가기</a><br><br>
<span style="font-size:30px;"><b>지역 : </b></span><select style="width:150px;font-size:22px;" name="main" id="main" onchange="categoryChange(this)">
<option>지역선택</option>
<?php 
$rs_select = mysqli_query($Conn, "SELECT area_main_name FROM molit_area_info group by area_main_name");
while ( $row_select = mysqli_fetch_assoc($rs_select) ) {
    $rows_select[] = $row_select;
}

foreach ($rows_select as $row_select) { ?>
  <option value=<?php echo $row_select['area_main_name']; if ($row_select['area_main_name']==$area_main_name){echo ' selected';}?>><?php echo $row_select['area_main_name']; ?></option>
<?php } ?>
</select>






<span style="font-size:30px;"><b>지역구 : </b></span><select style="width:150px;font-size:22px;" name="sub" id="sub" onchange="apart_list(this)">
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







<span style="font-size:30px;"><b>읍/면/동 : </b></span><select style="width:150px;font-size:22px;" name="dong" id="dong" onchange="apart_dong_list(this)">
<option value=''>선택</option>
<?php 
$rs3_select = mysqli_query($Conn, "select replace(dong,' ','') as dong from apart_dong where area_main_name = '$area_main_name' and replace(area_sub_name,' ','') = replace('$area_sub_name','$area_main_name','') group by area_main_name, area_sub_name, dong");
while ( $row3_select = mysqli_fetch_assoc($rs3_select) ) {
    $rows3_select[] = $row3_select;
}

foreach ($rows3_select as $row3_select) { ?>
  <option value=<?php echo $row3_select['dong']; if ($row3_select['dong']==$dong){echo ' selected';}?>><?php echo $row3_select['dong']; ?></option>
<?php } ?>
</select>


<br>
<span style="font-size:30px;"><b>아파트 : </b></span><select style="width:150px;font-size:22px;" name="apart_name" id="apart_name" onchange="apart_apart_list(this)">
<option value=''>선택</option>
<?php 
$rs4_select = mysqli_query($Conn, "select replace(apart_name,' ','') as apart_name from apart_dong where area_main_name = '$area_main_name' and replace(area_sub_name,' ','') = replace('$area_sub_name','$area_main_name','') and replace(dong,' ','') = '$dong' group by area_main_name, area_sub_name, dong, apart_name");
while ( $row4_select = mysqli_fetch_assoc($rs4_select) ) {
    $rows4_select[] = $row4_select;
}

foreach ($rows4_select as $row4_select) { ?>
  <option value=<?php echo $row4_select['apart_name']; if ($row4_select['apart_name']==$apart_name){echo ' selected';}?>><?php echo $row4_select['apart_name']; ?></option>
<?php } ?>
</select>




<span style="font-size:30px;"><b>정렬방식 : </b></span><select style="width:150px;font-size:22px;" name="orderby" id="orderby" onchange="apart_orderby(this)">
	<option value="max_lastest" <?php if($orderby=='max_lastest' or $orderby==''){echo 'selected';}?>>최근최고가격</option>
	<option value="max_all" <?php if($orderby=='max_all'){echo 'selected';}?>>역대최고가격</option>
	<option value="latest_date" <?php if($orderby=='latest_date'){echo 'selected';}?>>최근거래날짜</option>
	<option value="name" <?php if($orderby=='name'){echo 'selected';}?>>이름순</option>
</select>




<span style="font-size:30px;"><b>50㎡이상: </b></span><select style="width:150px;font-size:22px;" name="main_size" id="main_size" onchange="apart_main(this)">
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
	var good_junnam = ["고창군","군산시","김제시","남원시","무주군","부안군","순창군","완주군","익산시","임실군","장수군","전주시덕진구","전주시완산구","정읍시","진안군"];
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
  opt.value = "시/군/구 선택";
	opt.innerHTML = "시/군/구 선택";
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

<h1><?php if ($area_main_name!="지역선택") {echo $area_main_name;} ?> <?php if ($area_main_name!="지역선택") {echo $area_sub_name;} ?> <?php echo $dong; ?> 실거래 리스트(2017년 이후)</h1>

<table>
    <thead>
    <tr>
        <th style="font-size: 20px;"><b>아파트</b></th>
        <th style="font-size: 20px;"><b>전용면적</b></th>
        <th style="font-size: 20px;"><b>최근거래</b></th>
        <th style="font-size: 20px;"><b>최고가격</b></th>
        <th style="font-size: 20px;"><b>최저가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px;"><a href='http://1.239.38.238:8880/apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[dong]?>'><b><?=$row['apart_name']?></b><br><?=$row['area_name']?> <?=$row['dong']?></td>
          <td style="font-size: 20px;"><b><?=$row['size']?>㎡</b></td>
          <td style="font-size: 20px;"><b><?=$row['last_price']?>억</b><br><b><?=$row['last_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['max_price']?>억</b><br><b><?=$row['max_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['min_price']?>억</b><br><b><?=$row['min_price_date']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<h3><center>Copyright ©2022 Lee, Inc. All rights reserved<br>Developer : jungsup2.lee@gmail.com</center></h3>
</body>
<!--
<?
$sql = mysql_query(" select mb_id from $g4[member_table] ");
// $option 에 자바스크립트 소스를 정의한다
$option = " var arr = new Array(); ";
for ($i=0; $row=mysql_fetch_array($sql); $i++) { 
    // php 의 for 문을 활용하여 자바스크립트 배열 생성
    $option .= " arr[$i] = '$row[mb_id]'; ";
}
?>





<select onchange="categoryChange(this)">
	<option>걸그룹을 선택해주세요</option>
	<option value="a">블랙핑크</option>
	<option value="b">에프엑스</option>
	<option value="c">EXID</option>
</select>

<select id="good">
<option>좋아하는 멤버를 선택해주세요</option>
</select>

<script>
function categoryChange(e) {
	var good_a = ["지수", "제니", "로제", "리사"];
	var good_b = ["빅토리아", "엠버", "루나", "크리스탈"];
	var good_c = ["LE", "하니", "정화", "혜린", "솔지"];
	var target = document.getElementById("good");

	if(e.value == "a") var d = good_a;
	else if(e.value == "b") var d = good_b;
	else if(e.value == "c") var d = good_c;

	target.options.length = 0;

	for (x in d) {
		var opt = document.createElement("option");
		opt.value = d[x];
		opt.innerHTML = d[x];
		target.appendChild(opt);
	}	
}
</script>
-->

<?php
include_once "../top_page.php";
?>
<?php
$user_update = $_REQUEST["user_update"];
$email = "";
$email_yn = "";

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
    
    $sql_select_user = "
      select area_main_name, size1, size2, size3, size4, email, IFNULL(email_yn,'Y') as email_yn from user where id = '$userid'
    ";
    $rs_user = mysqli_query($Conn, $sql_select_user);
    $row_user = mysqli_fetch_assoc($rs_user);

    $size1 = $row_user['size1'];
    $size2 = $row_user['size2'];
    $size3 = $row_user['size3'];
    $size4 = $row_user['size4'];
    $email = $row_user['email'];
    $email_yn = $row_user['email_yn'];
    
  }else{
    $sql_select_user = "
      select area_main_name, size1, size2, size3, size4 , email, email_yn from user where id = '$userid'
    ";
    $rs_user = mysqli_query($Conn, $sql_select_user);
    $row_user = mysqli_fetch_assoc($rs_user);

    if($row_user['area_main_name']!=""){
      $area_main_name = $row_user['area_main_name'];
      $size1 = $row_user['size1'];
      $size2 = $row_user['size2'];
      $size3 = $row_user['size3'];
      $size4 = $row_user['size4'];
      $email = $row_user['email'];
      $email_yn = $row_user['email_yn'];
    }else{
      mysqli_query($Conn, "update user set area_main_name = '전체', size1 = 'false', size2 = 'true', size3 = 'true', size4 = 'false'  where id = '$userid';");
      $area_main_name = "전체";
      $size1 = "false";
      $size2 = "true";
      $size3 = "true";
      $size4 = "false";
      $email = $row_user['email'];
      $email_yn = $row_user['email_yn'];
    }
  }
}else{
  echo "<script> alert('세션이 만료되었습니다. 다시 로그인해주세요.'); history.back(); </script> ";
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
      from molit_max_min_all_billa_group
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
      from molit_max_min_rent_all_billa_group
      where (area_main_name, dong, apart_name, size) in (select area_main_name, dong, apart_name, ROUND(size) from molit_favorite where userid = '$userid')
      order by date_format(last_price_date,'%Y-%m-%d') desc
      ";

$rs_rent = mysqli_query($Conn, $sql_rent);

while ( $row_rent = mysqli_fetch_assoc($rs_rent) ) {
    $rows_rent[] = $row_rent;
}

/////////////////////매매//////////////////////////
?>

<span style="font-size:20px;"><b>거래 상세리스트 화면에서 하트모양을 클릭하시면 즐겨찾기 할 수 있습니다.</b></span><img style="vertical-align: middle;" width="25", height="25" src="./hearts_empty.png" ><img style="vertical-align: middle;" width="25", height="25" src="./hearts_full.png" >
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
<br>
<form name="mform">
 <span style="font-size:30px;"><b>사이즈 선택 : <?php if($isMobile == "Y") { echo "<br>";}?></b></span>
 <span style="font-size:25px;"><b>전용</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size1" onclick="check1(this)" <?php if($size1=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>40 ㎡이하 </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size2" onclick="check2(this)" <?php if($size2=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>40-60 ㎡ </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size3" onclick="check3(this)" <?php if($size3=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>60-85 ㎡ </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size4" onclick="check4(this)" <?php if($size4=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>85 ㎡초과</b></span>
</form>
<br>
<span style="font-size:30px;"><b>이메일 구독 : </b></span>
<input style="width:22px; height:22px;" type="checkbox" id="email" onclick="email(this)" <?php if($email_yn=="Y"){ echo "checked";}?>><span style="font-size:20px;"><b> <?php if($isMobile == "Y") { echo "<br>";}?>(구독하시면 매일아침 신규거래건을 메일로 보내드립니다.) </b></span>


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
function email(country){
  if(document.getElementById("email").checked){
    location.href = "../email_yn_update.php?email=<?=$email?>&status=Y";
  }else{
    location.href = "../email_yn_update.php?email=<?=$email?>&status=N";
  }
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
        <th style="font-size: 20px; width:30%;"><b>주택명</b></th>
        <th style="font-size: 20px; width:17%;"><b>전용면적</b></th>
        <th style="font-size: 20px; width:17%;"><b>최고가격<br>대비하락</b></th>
        <th style="font-size: 20px; width:18%;"><b>최근거래</b></th>
        <th style="font-size: 20px; width:18%;"><b>최고가격</b></th>
        <?php if($isMobile == "N") { ?>
        <th style="font-size: 20px;"><b>최저가격</b></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px;"><a href='./apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[dong]?>&all_area=N'><b><?=$row['apart_name']?></b><br><?=$row['area_name']?> <?=$row['dong']?></td>
          <td style="font-size: 20px;"><b><?=$row['size']?>㎡</b></td>
          <td style="background-color:rgba(255, 0, 0, 0.3); font-size: 20px;"><b><?=$row['price_last']?>억<br><?=$row['percent']?>%하락</b></td>
          <td style="font-size: 20px;"><b><?=$row['last_price']?>억</b><br><b><?=$row['last_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['max_price']?>억</b><br><b><?=$row['max_price_date']?></b></td>
          <?php if($isMobile == "N") { ?>
          <td style="font-size: 20px;"><b><?=$row['min_price']?>억</b><br><b><?=$row['min_price_date']?></b></td>
          <?php } ?>
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
        <th style="font-size: 20px; background: #809EAD; width:30%;"><b>주택명</b></th>
        <th style="font-size: 20px; background: #809EAD; width:17%;"><b>전용면적</b></th>
        <th style="font-size: 20px; background: #809EAD; width:17%;"><b>최고가격<br>대비하락</b></th>
        <th style="font-size: 20px; background: #809EAD; width:18%;"><b>최근거래</b></th>
        <th style="font-size: 20px; background: #809EAD; width:18%;"><b>최고가격</b></th>
        <?php if($isMobile == "N") { ?>
        <th style="font-size: 20px; background: #809EAD;"><b>최저가격</b></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows_rent as $row_rent) { ?>
      <tr>
          <td style="font-size: 20px;"><a href='./apart_rent.php?area_main_name=<?=$row_rent[area_main_name]?>&apart_name=<?=$row_rent[apart_name]?>&size=<?=$row_rent[size]?>&dong=<?=$row_rent[dong]?>&all_area=N'><b><?=$row_rent['apart_name']?></b><br><?=$row_rent['area_name']?> <?=$row_rent['dong']?></td>
          <td style="font-size: 20px;"><b><?=$row_rent['size']?>㎡</b></td>
          <td style="background-color:rgba(255, 0, 0, 0.3); font-size: 20px;"><b><?=$row_rent['price_last']?>억<br><?=$row_rent['percent']?>%하락</b></td>
          <td style="font-size: 20px;"><b><?=$row_rent['last_price']?>억</b><br><b><?=$row_rent['last_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row_rent['max_price']?>억</b><br><b><?=$row_rent['max_price_date']?></b></td>
          <?php if($isMobile == "N") { ?>
          <td style="font-size: 20px;"><b><?=$row_rent['min_price']?>억</b><br><b><?=$row_rent['min_price_date']?></b></td>
          <?php } ?>
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

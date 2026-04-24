<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<link rel="stylesheet" type="text/css" href="./test.css">
<?php

$area_main_name = $_REQUEST["area_main_name"];
$insert_date = $_REQUEST["insert_date"];
$main = $_REQUEST["main"];

if ( $insert_date == ''){
  $insert_date = date("Y-m-d");
}

if ( $main == '1'){
  $main_text = "AND cast(size as decimal(10,2)) > '49.99'";
}else{
  $main_text = "";
}

if ( $area_main_name== '충청도') {
  $area_main_name_text = "area_main_name in ('충청북도','충청남도')";
}elseif ( $area_main_name== '경상도' ) {
  $area_main_name_text = "area_main_name in ('경상북도','경상남도')";
}elseif ( $area_main_name== '전라도' ) {
  $area_main_name_text = "area_main_name in ('전라북도','전라남도')";
}elseif ( $area_main_name== '전체' ){
  $area_main_name_text = "1=1";
}else{
  $area_main_name_text = "area_main_name = '".$area_main_name."'";
}


$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);

$sql = "
      select
      	yearmonthday,
      	area_main_name,
      	replace(area_name,area_main_name,'') as area_name,
      	doing ,
      	apart_name,
      	size,
      	stair,
      	price ,
      	TYPE,
      	STATUS ,
      	max_price,
      	max_price_date,
      	min_price,
      	min_price_date,
      	last_price,
      	last_price_date,
      	ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),2) as price_last
      from molit_today_update
      where $area_main_name_text
      and insert_date = '$insert_date'
      $main_text
      ";

$sql_status = "
  SELECT
      IFNULL((SELECT COUNT(1) from molit_today_update WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text AND STATUS ='신고가' GROUP BY STATUS),0) AS upup,
      IFNULL((SELECT COUNT(1) from molit_today_update WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text AND STATUS ='상승' GROUP BY STATUS),0) AS up,
      IFNULL((SELECT COUNT(1) from molit_today_update WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text AND STATUS ='동일' GROUP BY STATUS),0) AS same,
      IFNULL((SELECT COUNT(1) from molit_today_update WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text AND STATUS ='하락' GROUP BY STATUS),0) AS down,
      IFNULL((SELECT COUNT(1) from molit_today_update WHERE insert_Date = '$insert_date' AND $area_main_name_text $main_text AND STATUS ='신저가' GROUP BY STATUS),0) AS downdown
      FROM DUAL;
";

mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

mysqli_query($Conn, "update molit_visit_count set count = count + 1 where count_type = 'apart_today';");

$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

$rs_status = mysqli_query($Conn, $sql_status);
$row_status = mysqli_fetch_assoc($rs_status);
$rows_status[] = $row_status;

?>
<h1><center>전국 아파트 실거래가 조회</center></h1>
<a href='http://1.239.38.238:8880/apart_home.php'>Home</a>
<h1>
<span style="font-size:30px;"></b></span><select style="width:220px;font-size:30px;" name="main" id="main" onchange="apart_list(this)">
<?php 
$rs_select = mysqli_query($Conn, "SELECT area_main_name FROM molit_area_info group by area_main_name");
while ( $row_select = mysqli_fetch_assoc($rs_select) ) {
    $rows_select[] = $row_select;
}?>
  <option value="전체" <?php if ($area_main_name=='전체'){echo 'selected';} ?>>전체</option>
<?php foreach ($rows_select as $row_select) { ?>
  <option value=<?php echo $row_select['area_main_name']; if ($row_select['area_main_name']==$area_main_name){echo ' selected';}?>><?php echo $row_select['area_main_name']; ?></option>
<?php } ?>
</select>
<?php echo $insert_date; ?> 신규 실거래 리스트(2017년 이후) <br><?php if ( $main == '1'){echo '(전용면적 50㎡ 이상)';}?></h1>

<h2>신고가 <?php echo $row_status['upup']; ?>건, 상승 <?php echo $row_status['up']; ?>건, 동일 <?php echo $row_status['same']; ?>건, 하락 <?php echo $row_status['down']; ?>건, 신저가 <?php echo $row_status['downdown']; ?>건</h2>

<script>
function apart_list(e) {
  <?php echo "window.location.href = './apart_today2.php?'+'area_main_name='+document.getElementById('main').value+'&insert_date=$insert_date'+'&main=$main';"?>
}
</script>

<table>
    <thead>
    <tr>
        <th style="font-size: 20px;"><b>거래일자</b><br>아파트명</b></th>
        <th style="font-size: 20px;"><b>전용면적</b><br>층<br>거래유형</b></th>
        <th style="font-size: 20px;"><b>가격</b></th>
        <th style="font-size: 20px;"><b>이전가격</b></th>
        <th style="font-size: 20px;"><b>최고가격</b></th>
        <th style="font-size: 20px;"><b>최저가격</b></th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px;"><a href='http://1.239.38.238:8880/apart.php?area_main_name=<?=$row[area_main_name]?>&apart_name=<?=$row[apart_name]?>&size=<?=$row[size]?>&dong=<?=$row[doing]?>'><b><?=$row['yearmonthday']?></b><br><b><?=$row['area_name']?></b><br><b><?=$row['apart_name']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['size']?>㎡</b><br><b><?=$row['stair']?>층</b><br><b><?=$row['TYPE']?></b></td>
          <?php 

          if ( $row['STATUS']== '신고가') {
            echo "<td style='background-color:rgba(0, 0, 255, 0.5); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>신고가</td>";
          } elseif ( $row['STATUS']== '상승') {
            echo "<td style='background-color:rgba(0, 255, 0, 0.5); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>상승</td>";
          } elseif ( $row['STATUS']== '동일') {
            echo "<td style='background-color:rgba(255, 255, 0, 0.5); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>동일</td>";
          } elseif ( $row['STATUS']== '하락') {
            echo "<td style='background-color:rgba(255, 165, 0, 0.5); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>하락</td>";
          } elseif ( $row['STATUS']== '신저가') {
            echo "<td style='background-color:rgba(255, 0, 0, 0.5); font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>신저가</td>";
          } else 
          {
            echo "<td style='font-size: 20px;'><b>$row[price]억</b><br>$row[price_last]억<br>신규</td>";
          }
          ?>
          <td style="font-size: 20px;"><b><?=$row['last_price']?>억</b><br><b><?=$row['last_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['max_price']?>억</b><br><b><?=$row['max_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['min_price']?>억</b><br><b><?=$row['min_price_date']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<h3><center>Copyright ©2022 Lee, Inc. All rights reserved<br>Developer : jungsup2.lee@gmail.com</center></h3>
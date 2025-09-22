<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<link rel="stylesheet" type="text/css" href="./test.css">
<?php

$area_main_name = $_REQUEST["area_main_name"];
$insert_date = $_REQUEST["insert_date"];
$main = $_REQUEST["main"];

if ( $insert_date == ''){
  $insert_date = '2022-10-14';
}

if ( $main == ''){
  $main = '0';
}

$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);

if ( $main == '1') {
  if ( $area_main_name== '충청도') {
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
      where area_main_name in ('충청북도','충청남도')
      and insert_date = '$insert_date'
      AND cast(size as decimal(10,2)) > '49.99'
      ";
  } elseif ( $area_main_name== '경상도' ) {
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
      where area_main_name in ('경상북도','경상남도')
      and insert_date = '$insert_date'
      AND cast(size as decimal(10,2)) > '49.99'
      ";
  } elseif ( $area_main_name== '전라도' ){
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
      where area_main_name in ('전라북도','전라남도')
      and insert_date = '$insert_date'
      AND cast(size as decimal(10,2)) > '49.99'
      ";
  } else{
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
      where area_main_name = '$area_main_name'
      and insert_date = '$insert_date'
      AND cast(size as decimal(10,2)) > '49.99'
      ";
  }
}else{
  
  if ( $area_main_name== '충청도') {
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
      where area_main_name in ('충청북도','충청남도')
      and insert_date = '$insert_date'
      ";
  } elseif ( $area_main_name== '경상도' ) {
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
      where area_main_name in ('경상북도','경상남도')
      and insert_date = '$insert_date'
      ";
  } elseif ( $area_main_name== '전라도' ){
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
      where area_main_name in ('전라북도','전라남도')
      and insert_date = '$insert_date'
      ";
  } else{
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
      where area_main_name = '$area_main_name'
      and insert_date = '$insert_date'
      ";
  }
}


mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

mysqli_query($Conn, "update molit_visit_count set count = count + 1 where count_type = 'apart_today';");

$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

?>
<!--

<h1><?php echo $area_name; ?> <?php echo $dong; ?> <?php echo $apart_name; ?><br><?php echo $size; ?>㎡(<?php echo round(((float)$size)/3.30579,2); ?>평) 실거래 리스트(2017년 이후)</h1>
<h1><a href='https://m.land.naver.com/search/result/<?php echo str_replace(' ','%20',$dong); ?><?php echo str_replace(' ','%20',$apart_name); ?>아파트'>네이버 부동산 바로가기</a><h1>
<h1><a href='https://hogangnono.com/search?q=<?php echo str_replace(' ','%20',$dong); ?><?php echo str_replace(' ','%20',$apart_name); ?>아파트'>호갱노노 바로가기</a><h1>
-->
<a href='http://1.239.38.238:8880/apart_home.php'>Home</a>
<h1><?php echo $area_main_name; ?> <?php echo $insert_date; ?> 신규 실거래 리스트(2017년 이후) <br><?php if ( $main == '1'){echo '(전용면적 50㎡ 이상)';}?></h1>

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
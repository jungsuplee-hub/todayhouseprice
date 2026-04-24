<head>
<link rel='stylesheet' type='text/css' href='./todayhouseprice.css'>
</head>

<?php
$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

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
  $size1_text = "or cast(meme.size as decimal(10,2)) <= 40";
}
if($size2=="true"){
  $size2_text = "or (cast(meme.size as decimal(10,2)) > 40 and cast(meme.size as decimal(10,2)) <= 60)";
}
if($size3=="true"){
  $size3_text = "or (cast(meme.size as decimal(10,2)) > 60 and cast(meme.size as decimal(10,2)) <= 85)";
}
if($size4=="true"){
  $size4_text = "or cast(meme.size as decimal(10,2)) > 85";
}

if ($area_main_name=="전체"){
  $area_main_name_text = "1=1";
}else{
  $area_main_name_text = "meme.area_main_name = '$area_main_name'";
}

//SELECT replace(area_sub_name,' ','') as area_sub_name FROM molit_area_info where area_main_name = '$area_main_name' order by area_sub_name


//$sql = "
//select
//area_main_name,
//area_name,
//dong,
//apart_name,
//size,
//last_price,
//last_price_date
//from molit_max_min_all_group meme
//where (1!=1 $size1_text $size2_text $size3_text $size4_text)
//and $area_main_name_text
//and last_price is not null
//and (last_price_date like '2022%' or last_price_date like '2023%' or last_price_date like '2024%')
//order by CAST(last_price as DECIMAL(10,5))
//limit 100;
//      ";

$sql = "
SELECT
area_main_name,
area_name,
dong,
apart_name,
size,
last_price,
last_price_date,
build_year,
hocnt
FROM
(
select
meme.area_main_name,
meme.area_name,
meme.dong,
meme.apart_name,
meme.size,
meme.last_price,
meme.last_price_date,
dong.build_year,
(SELECT hocnt from TotalAptList WHERE kaptcode = dong.apart_code LIMIT 1) AS hocnt
from molit_max_min_all_group meme, apart_dong dong
where meme.area_main_name = dong.area_main_name
and meme.apart_name = dong.apart_name
and meme.dong = dong.dong
and meme.area_main_name = '서울특별시'
and meme.last_price is not null
and meme.size = '85'
and (meme.last_price_date like '2022%' or meme.last_price_date like '2023%' or meme.last_price_date like '2024%')
) a
WHERE a.hocnt >= 200
order by CAST(a.last_price as DECIMAL(10,5))
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

?>

<h1>서울 아파트 국평(85㎡) 최저가격 Top 100</h1>
<span style="font-size: 20px;">*참고
<br>. 거래취소 내용이 반영되지 않은 케이스가 일부 있을 수 있습니다.
<br>. 2022년 이후 거래기준 입니다.
<br>. 200세대 이상을 기준으로 하였으며,국토부 아파트상세정보와 매칭이 안되 누락되는 케이스가 존재할 수 있습니다.
</span>
<br><br>


<table>
    <thead>
    <tr>
        <th style="font-size: 25px; width:7%;"><b>순위</b></th>
        <th style="font-size: 25px; width:36%;"><b>아파트명<br>지역</b></th>
        <th style="font-size: 20px; width:13%;"><b>전용면적</b></th>
        <!--<th style="font-size: 20px; width:15%;"><b>하락금액<br>하락률</b></th>-->
        <th style="font-size: 20px; width:13%;"><b>최저가격</b></th>
        <th style="font-size: 20px; width:15%;"><b>거래일자</b></th>
        <th style="font-size: 20px; width:14%;"><b>세대수<br>건축년도</b></th>

        <!--<th style="font-size: 20px; width:13%;"><b>최저가격</b><br>(최저전세)</th>-->
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows as $row) { $add_count = $add_count + 1; ?>
      <tr>
          <td style="font-size: 30px;"><b><?=$add_count?></b></td>
          <td><span style="font-size: 30px;"><b><?=$row['apart_name']?></b></span><br><span style="font-size: 20px;"><?=$row['area_name']?> <?=$row['dong']?></span></td>
          <td style="font-size: 20px;"><b><?=$row['size']?>㎡</b></td>
          <!--<td style="font-size: 20px;"><b>-<?=$row['diff_price']?>억<br><?php if($row['diff_rate']>50){ echo "<span style='color:fuchsia;'>"; }else if($row['diff_rate']>30){ echo "<span style='color:red;'>"; } ?><?=$row['diff_rate']?>%<?php if($row['diff_rate']>30){ echo "</span>"; } ?></b></td>-->
          <td style="font-size: 20px;"><b><?=$row['last_price']?>억</b></td>
          <td style="font-size: 20px;"><b><?=$row['last_price_date']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['hocnt']?>세대<br><?=$row['build_year']?>년</b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : todayhouseprice.com@gmail.com</b></span></center>

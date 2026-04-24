<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<link rel="stylesheet" type="text/css" href="./test.css">
<?php

$apart_name = $_REQUEST["apart_name"];
$size = $_REQUEST["size"];
$dong = $_REQUEST["dong"];
$area_name = $_REQUEST["area_name"];

$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);

$sql = "
    SELECT concat(year,'/',month,'/',day) as yearmonthday, apart_name, size, stair, price, type
    FROM molit_info_incheon
    where apart_name = '$apart_name'
    and size = '$size'
    order by insert_date desc
    ";

mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}
?>

<h1><?php echo $area_name; ?> <?php echo $dong; ?> <?php echo $apart_name; ?><br><?php echo $size; ?>m2 사이즈 실거래 리스트</h1>
<h1><a href='https://m.land.naver.com/search/result/<?php echo str_replace(' ','%20',$dong); ?><?php echo str_replace(' ','%20',$apart_name); ?>아파트'>네이버 부동산 바로가기</a><h1>



<table>
    <thead>
    <tr>
        <th>아파트명</th>
        <th>거래일자</th>
        <th>층</th>
        <th>가격</th>
        <th>거래유형</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td><?=$row['apart_name']?></td>
          <td><?=$row['yearmonthday']?></td>
          <td><?=$row['stair']?>층</td>
          <td><?=$row['price']?>억</td>
          <td><?=$row['type']?></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
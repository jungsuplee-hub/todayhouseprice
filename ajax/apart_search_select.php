<?php
//$q = intval($_GET['q']);
$q = $_REQUEST["q"];

$Conn = mysqli_connect("localhost", "root", "e0425820", "jsdb", 3306);
mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

//$sql="SELECT * FROM user WHERE id = '".$q."'";
$sql="SELECT area_main_name, replace(area_sub_name,' ','') as area_sub_name, replace(dong,' ','') as dong, replace(apart_name,' ','') as apart_name, build_year, IFNULL(addr,concat(area_main_name,' ',area_sub_name,' ',dong)) as addr, doro, TRIM(LEADING '0' FROM doro_code1) as doro_code1 , TRIM(LEADING '0' FROM doro_code2) as doro_code2 FROM apart_dong where (apart_name like '%$q%' or addr like '%$q%' or concat(doro,' ', TRIM(LEADING '0' FROM doro_code1),' ',TRIM(LEADING '0' FROM doro_code2)) like '%$q%')  limit 10";


$result = mysqli_query($Conn,$sql);

echo "<table>
    <thead>
    <tr>
        <th style='font-size: 20px; width:35%;'><b>아파트명</b></th>
        <th style='font-size: 20px; width:42%;'><b>주소</b></th>
        <th style='font-size: 20px; width:13%;'><b>건축년도</b></th>
    </tr>
    </thead>
    <tbody>";

while($row = mysqli_fetch_array($result))
{
  echo "<tr>";
  echo "<td style='font-size: 20px;'><a href='./apart_home.php?area_main_name=$row[area_main_name]&area_sub_name=$row[area_sub_name]&dong=$row[dong]&apart_name=$row[apart_name]&main=0&orderby=latest_date'>" . $row['apart_name'] . "</td>";
  if($row['doro']==null){
    echo "<td style='font-size: 20px;'>" . $row['addr'] . "</td>";
  }
  else{
    echo "<td style='font-size: 20px;'>" . $row['addr'] . " (".$row['doro']." ".$row['doro_code1']." ".$row['doro_code2'].")"."</td>";
  }
  if($row['build_year']==null){
    echo "<td style='font-size: 20px;'></td>";
  }
  else{
    echo "<td style='font-size: 20px;'>" . $row['build_year'] . "년</td>";
  }
  echo "</tr>";
}
echo "</tbody></table>";

mysqli_close($Conn);
?>



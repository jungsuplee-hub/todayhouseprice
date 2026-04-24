<?php
include_once "../top_page.php";
?>

<?php
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
last_price,
last_price_date
from molit_max_min_all_officetel_group meme
where (1!=1 $size1_text $size2_text $size3_text $size4_text)
and $area_main_name_text
and last_price is not null
and (last_price_date like '2022%' or last_price_date like '2023%' or last_price_date like '2024%')
order by CAST(last_price as DECIMAL(10,5))
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
 <span style="font-size:25px;"><b>전용</b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size1" onclick="check1(this)" <?php if($size1=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>40 ㎡이하 </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size2" onclick="check2(this)" <?php if($size2=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>40-60 ㎡ </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size3" onclick="check3(this)" <?php if($size3=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>60-85 ㎡ </b></span>
 <input style="width:22px; height:22px;" type="checkbox" id="size4" onclick="check4(this)" <?php if($size4=="true"){ echo "checked";}?>><span style="font-size:25px;"><b>85 ㎡초과</b></span>
</form>

<script>
function check1(country){
  location.href = "./apart_todayhouseprice_rank_four.php?area_main_name=<?=$area_main_name?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check2(country){
  location.href = "./apart_todayhouseprice_rank_four.php?area_main_name=<?=$area_main_name?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check3(country){
  location.href = "./apart_todayhouseprice_rank_four.php?area_main_name=<?=$area_main_name?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
function check4(country){
  location.href = "./apart_todayhouseprice_rank_four.php?area_main_name=<?=$area_main_name?>&size1="+document.getElementById("size1").checked+"&size2="+document.getElementById("size2").checked+"&size3="+document.getElementById("size3").checked+"&size4="+document.getElementById("size4").checked;
}
</script>


<h1><?=$area_main_name?> 오피스텔 최저가격 Top 100</h1>
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
        <th style="font-size: 20px;"><b>순위</b></th>
        <th style="font-size: 20px;"><b>오피스텔명<br>지역</b></th>
        <th style="font-size: 20px;"><b>전용면적</b></th>
        <!--<th style="font-size: 20px; width:15%;"><b>하락금액<br>하락률</b></th>-->
        <th style="font-size: 20px;"><b>최저가격</b></th>
        <th style="font-size: 20px;"><b>거래일자</b></th>

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
          <td style="font-size: 20px;"><b><?=$row['last_price']?>억</b></td>
          <td style="font-size: 20px;"><b><?=$row['last_price_date']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

<script>
function apart_list(e) {
  <?php echo "window.location.replace('./apart_todayhouseprice_rank_four.php?'+'area_main_name='+document.getElementById('main').value+'&size1=$size1'+'&size2=$size2'+'&size3=$size3'+'&size4=$size4');"?>
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

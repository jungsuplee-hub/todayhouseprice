<?php
include_once "./top_page.php";
?>

<?php
$area_main_name = $_REQUEST["area_main_name"];

if ($area_main_name==""){

  $area_main_name="전체";
}

if ($area_main_name=="전체"){
  $area_main_name_text = "1=1";
}else{
  $area_main_name_text = "area_main_name = '$area_main_name'";
}

$before1Day = date("Y-m-d", strtotime($today." -1 day"));

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
select
insert_date, area_main_name, area_sub_name, total_price, total_cnt, cast(total_avg as decimal(10,2)) as total_avg
from avg_meme_price_apart_85
where insert_date = '$before1Day'
and $area_main_name_text
order by cast(total_avg as decimal(10,2)) desc
limit 100;
";


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


<h1><?=$area_main_name?> 지역별 국평(85㎡, 100세대 이상) 평균가격 Top 100</h1>
<span style="font-size: 20px;">*참고
<br>. 국토부 아파트상세정보와 매칭이 안되 누락되는 케이스가 존재할 수 있습니다.
<br>. 각 아파트별 마지막 거래가격 기준입니다.
<br>. 전일(<?=$before1Day?>)에 집계된 데이터 입니다.
<br>. 참고로만 봐주시기 바랍니다.
</span>
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
      <th style="font-size: 30px; width:10%;"><b>순위</b></th>
      <th style="font-size: 30px; width:40%;"><b>지역</th>
      <th style="font-size: 30px; width:20%;"><b>평균가(억)</b></th>
      <th style="font-size: 30px; width:30%;"><b>집계대상 아파트수</b></th>

        <!--<th style="font-size: 20px; width:13%;"><b>최저가격</b><br>(최저전세)</th>-->
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows as $row) { if($add_count!=0 && fmod($add_count, 10)==0){echo '<tr><td colspan="6"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2265060002718871" data-ad-slot="3474043280"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></td></tr>';} $add_count = $add_count + 1; ?>
      <tr>
        <td style="font-size: 30px;"><b><?=$add_count?></b></td>
        <td style="font-size: 30px;"><b><?=$row['area_main_name']?> <?=$row['area_sub_name']?></b></td>
        <td style="font-size: 30px;"><b><?=$row['total_avg']?>억</b></td>
        <td style="font-size: 30px;"><b><?=$row['total_cnt']?>개</b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

<script>
function apart_list(e) {
  <?php echo "window.location.replace('./apart_todayhouseprice_rank_five.php?'+'area_main_name='+document.getElementById('main').value);"?>
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

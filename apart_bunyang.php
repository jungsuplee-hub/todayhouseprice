<?php
include_once "./top_page.php";
?>

<?php

$area_main_name = $_REQUEST["area_main_name"];

if ($area_main_name=="전체"){
  $area_main_name_text = "1=1";
}else{
  $area_main_name_text = "HSSPLY_ADRES like '$area_main_name%'";
}

$sql = "
SELECT * FROM
(
  SELECT 
  HOUSE_NM,
  case when CNSTRCT_ENTRPS_NM = 'null' then BSNS_MBY_NM else CNSTRCT_ENTRPS_NM end as CNSTRCT_ENTRPS_NM,
  HSSPLY_ADRES,
  HMPG_ADRES,
  RCRIT_PBLANC_DE,
  RCEPT_BGNDE,
  RCEPT_ENDDE,
  replace(MVN_PREARNGE_YM,'NSPRC_NMnull','') as MVN_PREARNGE_YM,
  TOT_SUPLY_HSHLDCO
  FROM 
  Bunyang_Info
  where $area_main_name_text
  
  UNION ALL
  
  SELECT 
  concat(HOUSE_NM,' (무순위 청약)') as HOUSE_NM,
  BSNS_MBY_NM as CNSTRCT_ENTRPS_NM,
  HSSPLY_ADRES,
  HMPG_ADRES,
  RCRIT_PBLANC_DE,
  SUBSCRPT_RCEPT_BGNDE as RCEPT_BGNDE,
  SUBSCRPT_RCEPT_ENDDE as RCEPT_ENDDE,
  replace(MVN_PREARNGE_YM,'NSPRC_NMnull','') as MVN_PREARNGE_YM,
  TOT_SUPLY_HSHLDCO
  FROM 
  Bunyang_Info_Remain
  where $area_main_name_text
) a
ORDER BY a.RCRIT_PBLANC_DE desc
LIMIT 100
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

<h1>아파트 분양정보</h1>
<span style="font-size:20px;">청약홈 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://www.applyhome.co.kr/co/coa/selectMainView.do'>[출처링크]</a>
<br>단지명 클릭시 분양 시행사 홈페이지로 이동합니다.</span>
<br><br>

<span style="font-size:30px;">지역 : </b></span><select style="width:220px;font-size:30px;" name="main" id="main" onchange="bunyang_search(this)">
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
        <th style="font-size: 20px; width:50%;">단지명<br>건설사(시행사)<br>공급위치</b></th>
        <th style="font-size: 20px; width:20%;"><b>공고일자</b></th>
        <th style="font-size: 20px; width:20%;"><b>청약시작일<br>청약종료일<br>(입주예정월)</b></th>
        <th style="font-size: 20px; width:10%;"><b>공급세대</b></th>

        <!--<th style="font-size: 20px; width:13%;"><b>최저가격</b><br>(최저전세)</th>-->
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows as $row) { if($add_count!=0 && fmod($add_count, 10)==0){echo '<tr><td colspan="6"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2265060002718871" data-ad-slot="3474043280"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></td></tr>';} $add_count = $add_count + 1; ?>
      <tr>
        <?php if($row['HMPG_ADRES']=='null'){ ?>
          <td style="font-size: 20px; width:50%;"><b><?=$row['HOUSE_NM']?></b><br><span style="font-size: 15px;"><?=$row['CNSTRCT_ENTRPS_NM']?><br><?=$row['HSSPLY_ADRES']?></span></td>
        <?php }else{ ?>
          <td style="font-size: 20px; width:50%;"><b><a href='<?=$row[HMPG_ADRES]?>' target='_blank'><?=$row['HOUSE_NM']?></b></a><br><span style="font-size: 15px;"><?=$row['CNSTRCT_ENTRPS_NM']?><br><?=$row['HSSPLY_ADRES']?></span></td>
        <?php } ?>
          <td style="font-size: 20px; width:20%;"><b><?=$row['RCRIT_PBLANC_DE']?></b></td>
          <td style="font-size: 20px; width:20%;"><b><?=$row['RCEPT_BGNDE']?><br><?=$row['RCEPT_ENDDE']?><br>(<?=$row['MVN_PREARNGE_YM']?>)</b></td>
          <td style="font-size: 20px; width:10%;"><b><?=$row['TOT_SUPLY_HSHLDCO']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

<script>

function bunyang_search(e) {
  <?php echo "window.location.replace('./apart_bunyang.php?'+'area_main_name='+document.getElementById('main').value);"?>
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

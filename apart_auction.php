<?php
include_once "./top_page.php";
?>

<?php

$area_main_name = $_REQUEST["area_main_name"];
$date_from = $_REQUEST["from"];
$date_to = $_REQUEST["to"];
$search_text = $_REQUEST["search_text"];

if ($area_main_name=="전체"){
  $area_main_name_text = "1=1";
}else{
  $area_main_name_text = "LOCATION like '$area_main_name%'";
}

if($date_from=='' || $date_from==null){
  $date_from = date("Y-m-d");
}
if($date_to=='' || $date_to==null){
  $date_to = date("Y-m-d", strtotime($today." +21 day"));
}

$sql = "
SELECT 
COURT
,SAGUN_NUM
,MULGUN_NUM
,TYPE
,LOCATION
,GUNMUL_INFO
,BIGO
,PRICE
,MIN_PRICE
,PERCENT
,DAMDANG
,DUE_DATE
,STATUS
,INSERT_DATE
,ID
,AUCTION_RESULT
FROM 
Auction_Apart_Info
where $area_main_name_text
and STR_TO_DATE(replace(due_date,'.',''), '%Y%m%d') >= CURDATE()
and STR_TO_DATE(replace(due_date,'.',''), '%Y%m%d') between '$date_from' and '$date_to'
and LOCATION like '%$search_text%'
ORDER BY DUE_DATE, LOCATION
limit 300
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

<h1>아파트 경매 예정(2023년 6월 이후)</h1>
<span style="font-size:20px;">대한민국 법원 경매정보 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://www.courtauction.go.kr/RetrieveMainInfo.laf'>[출처링크]</a>
<br>사건번호 클릭시 상세정보 페이지로 이동합니다.
<br>조회 날짜와 상관없이 과거날짜는 조회 안됩니다.
<br>조회 조건에 따라 최대 300건만 표시됩니다.</span>
<br><br>


<span style="font-size:30px;">지역 : </b></span><select style="width:220px;font-size:30px;" name="main" id="main" onchange="apart_list(this)">
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

<?php if($isMobile == "Y") { echo "<br>";}else{ echo "&nbsp;";}?>
<span style="font-size:30px;">날짜 : <input style="font-size:25px;" type = "date" id = "date_from" value =<?=$date_from?> > ~
<input style="font-size:25px;" type = "date" id = "date_to" value =<?=$date_to?> >
<br>소재지 검색 : <input style="font-size:25px;" type = "text" id = "search_text" value = <?=$search_text?> >
<input style="font-size:25px;" type = "button" name = "search" value ="조회" onclick="auction_search(this)">
</span>
<br>

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
        <th style="font-size: 20px; width:20%;">법원<br>사건번호</b></th>
        <th style="font-size: 20px; width:40%;"><b>소재지 및 내역<br>비고</b></th>
        <th style="font-size: 20px; width:20%;"><b>감정평가액<br>최저매각가격<br>비율</b></th>
        <th style="font-size: 20px; width:20%;"><b>담당계<br>매각기일<br>진행상태</b></th>

        <!--<th style="font-size: 20px; width:13%;"><b>최저가격</b><br>(최저전세)</th>-->
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows as $row) { if($add_count!=0 && fmod($add_count, 10)==0){echo '<tr><td colspan="6"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2265060002718871" data-ad-slot="3474043280"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></td></tr>';} $add_count = $add_count + 1; ?>
      <tr>
          <!--<td style="font-size: 20px; width:50%;"><b><a href='<?=$row[HMPG_ADRES]?>' target='_blank'><?=$row['HOUSE_NM']?></b></a><br><span style="font-size: 15px;"><?=$row['CNSTRCT_ENTRPS_NM']?><br><?=$row['HSSPLY_ADRES']?></span></td>-->
          <td style="font-size: 20px; width:20%;"><b><?=$row['COURT']?><br><a href='https://www.courtauction.go.kr/RetrieveRealEstCarHvyMachineMulDetailInfo.laf?jiwonNm=<?php echo urlencode(iconv("UTF-8","EUC-KR",$row[COURT])); ?>&saNo=<?=$row[ID]?>&maemulSer=<?=$row[MULGUN_NUM]?>' target='_blank'><?=$row[SAGUN_NUM]?></a></b></td>
          <td style="font-size: 20px; width:40%;"><b><?=$row['LOCATION']?><br><br><?=$row['GUNMUL_INFO']?><br><br><?=$row['BIGO']?></b></td>
          <td style="font-size: 20px; width:20%;"><b><?=$row['PRICE']?><br><?=$row['MIN_PRICE']?><br>(<?=$row['PERCENT']?>)</b></td>
          <td style="font-size: 20px; width:20%;"><b><?=$row['DAMDANG']?><br><?=$row['DUE_DATE']?><br><?=$row['STATUS']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

<script>
function apart_list(e) {
  <?php //echo "window.location.replace('./apart_auction.php?'+'area_main_name='+document.getElementById('main').value);"?>
}


function auction_search(e) {
  <?php echo "window.location.replace('./apart_auction.php?'+'area_main_name='+document.getElementById('main').value+'&from='+document.getElementById('date_from').value+'&to='+document.getElementById('date_to').value+'&search_text='+document.getElementById('search_text').value);"?>
}
</script>
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

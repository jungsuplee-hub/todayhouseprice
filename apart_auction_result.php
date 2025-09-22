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
  $date_from = date("Y-m-d", strtotime($today." -8 day"));
}
if($date_to=='' || $date_to==null){
  $date_to = date("Y-m-d", strtotime($today." -1 day"));
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
,IFNULL(replace(replace(AUCTION_RESULT,'<br />',''),' ','<br>'),'미종국') as AUCTION_RESULT
,SUBSTRING_INDEX(SUBSTRING_INDEX(SAGUN_NUM, '			', 1) ,'타경',1) AS YEAR
,REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(SAGUN_NUM, '			', 1) ,'타경',-1), '\r\n', '') AS NUM
FROM 
Auction_Apart_Info
where $area_main_name_text
and STR_TO_DATE(replace(due_date,'.',''), '%Y%m%d') < CURDATE()
and STR_TO_DATE(replace(due_date,'.',''), '%Y%m%d') between '$date_from' and '$date_to'
and LOCATION like '%$search_text%'
ORDER BY DUE_DATE DESC, LOCATION
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

<h1>아파트 경매 결과(2023년 6월 이후)</h1>
<span style="font-size:20px;">대한민국 법원 경매정보 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://www.courtauction.go.kr/RetrieveMainInfo.laf'>[출처링크]</a>
<br>사건번호 클릭시 상세정보 페이지로 이동합니다.
<br>조회 날짜와 상관없이 미래날짜는 조회 안됩니다.
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
        <th style="font-size: 20px; width:20%;"><b>담당계<br>매각기일<br>진행상태<br>결과</b></th>

        <!--<th style="font-size: 20px; width:13%;"><b>최저가격</b><br>(최저전세)</th>-->
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows as $row) { if($add_count!=0 && fmod($add_count, 10)==0){echo '<tr><td colspan="6"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2265060002718871" data-ad-slot="3474043280"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></td></tr>';} $add_count = $add_count + 1; ?>
      <tr>
          <!--<td style="font-size: 20px; width:50%;"><b><a href='<?=$row[HMPG_ADRES]?>' target='_blank'><?=$row['HOUSE_NM']?></b></a><br><span style="font-size: 15px;"><?=$row['CNSTRCT_ENTRPS_NM']?><br><?=$row['HSSPLY_ADRES']?></span></td>-->
          <td style="font-size: 20px; width:20%;"><b><?=$row['COURT']?><br><a href='https://www.courtauction.go.kr/RetrieveRealEstDetailInqSaList.laf?jiwonNm=<?php echo urlencode(iconv("UTF-8","EUC-KR",$row[COURT])); ?>&saYear=<?=$row[YEAR]?>&saSer=<?=$row[NUM]?>&_SRCH_SRNID=PNO102014' target='_blank'><?=$row[SAGUN_NUM]?></a></b></td>
          <td style="font-size: 20px; width:40%;"><b><?=$row['LOCATION']?><br><br><?=$row['GUNMUL_INFO']?><br><br><?=$row['BIGO']?></b></td>
          <td style="font-size: 20px; width:20%;"><b><?=$row['PRICE']?><br><?=$row['MIN_PRICE']?><br>(<?=$row['PERCENT']?>)</b></td>
          <td style="font-size: 20px; width:20%;"><b><?=$row['DAMDANG']?><br><?=$row['DUE_DATE']?><br><?=$row['STATUS']?><br><?php if(strpos($row['AUCTION_RESULT'], "유찰") !== false) {  echo "<span style='color:red;'>";} elseif(strpos($row['AUCTION_RESULT'], "취하") !== false) {  echo "<span style='color:OrangeRed;'>";}  elseif(strpos($row['AUCTION_RESULT'], "미종국") !== false) {  echo "<span style='color:RebeccaPurple;'>";} else{echo "<span style='color:blue;'>";}?><?=$row['AUCTION_RESULT']?></span></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

<script>

function apart_list(e) {
  <?php //echo "window.location.replace('./apart_auction_result.php?'+'area_main_name='+document.getElementById('main').value);"?>
}

function auction_search(e) {
  <?php echo "window.location.replace('./apart_auction_result.php?'+'area_main_name='+document.getElementById('main').value+'&from='+document.getElementById('date_from').value+'&to='+document.getElementById('date_to').value+'&search_text='+document.getElementById('search_text').value);"?>
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



<!--
SELECT 
YYYYMM,
MAEGAK_PRICE_RATE,
ROUND((MAEGAK/ALL_CNT)*100,1) AS MAEGAK_RATE,
ROUND((YOUCHAL/ALL_CNT)*100,1) AS YOUCHAL_RATE,
ALL_CNT,
MAEGAK,
YOUCHAL,
CANCEL,
(ALL_CNT-MAEGAK-YOUCHAL-CANCEL) AS ETC
FROM
(
	SELECT SUBSTR(DUE_DATE,1,7) AS YYYYMM, 
	COUNT(1) AS ALL_CNT,
	SUM(CASE WHEN AUCTION_RESULT LIKE '%매각%' THEN 1 ELSE 0 END) AS MAEGAK,
	ROUND(AVG(CASE WHEN AUCTION_RESULT LIKE '%매각%' THEN CAST(REPLACE(RESULT_PRICE,',','') AS  UNSIGNED)/CAST(REPLACE(PRICE,',','') AS  UNSIGNED) END)*100,1) AS MAEGAK_PRICE_RATE,
	SUM(CASE WHEN AUCTION_RESULT LIKE '%유찰%' THEN 1 ELSE 0 END) AS YOUCHAL,
	SUM(CASE WHEN AUCTION_RESULT LIKE '%취하%' THEN 1 ELSE 0 END) AS CANCEL
	FROM Auction_Apart_Info
	GROUP BY SUBSTR(DUE_DATE,1,7)
) AS a
ORDER BY YYYYMM










SELECT * FROM
(
SELECT 
case 
when aa.area_main_name = '서울특별시' then 1 
when aa.area_main_name = '경기도' then 2 
when aa.area_main_name = '부산광역시' then 3 
when aa.area_main_name = '대구광역시' then 4 
when aa.area_main_name = '인천광역시' then 5 
when aa.area_main_name = '광주광역시' then 6 
when aa.area_main_name = '대전광역시' then 7 
when aa.area_main_name = '울산광역시' then 8 
when aa.area_main_name = '세종특별자치시' then 9
when aa.area_main_name = '강원도' then 10
when aa.area_main_name = '충청북도' then 11 
when aa.area_main_name = '충청남도' then 12
when aa.area_main_name = '전라남도' then 13
when aa.area_main_name = '전라북도' then 14
when aa.area_main_name = '경상남도' then 15
when aa.area_main_name = '경상북도' then 16
when aa.area_main_name = '제주특별자치도' then 17 ELSE 0 END AS main_seq, 
aa.area_main_name,
aa.TOTAL_COUNT,
aa.STATUS_COUNT,
aa.AVG_START_PRICE,
aa.AVG_RESULT_PRICE,
aa.DIFF_PRICE,
aa.UPDOWN_RATE,

bb.TOTAL_COUNT AS TOTAL_COUNT_2,
bb.STATUS_COUNT AS STATUS_COUNT_2,
bb.AVG_START_PRICE AS AVG_START_PRICE_2,
bb.AVG_RESULT_PRICE AS AVG_RESULT_PRICE_2,
bb.DIFF_PRICE as DIFF_PRICE_2,
bb.UPDOWN_RATE AS UPDOWN_RATE_2
FROM
(
SELECT 
a.area_main_name
, COUNT(1) AS TOTAL_COUNT
, ROUND(AVG(a.STATUS_COUNT),1) AS STATUS_COUNT
, ROUND(AVG(a.START_PRICE)/10000,0) AS AVG_START_PRICE
, ROUND(AVG(a.RESULT_PRICE)/10000,0) AS AVG_RESULT_PRICE
, ROUND((AVG(a.START_PRICE) - AVG(a.RESULT_PRICE))/10000,0) AS DIFF_PRICE
, ROUND(100 - (SUM(a.RESULT_PRICE) / SUM(a.START_PRICE) * 100),2) AS UPDOWN_RATE
FROM
(
SELECT 
SUBSTRING_INDEX(LOCATION, ' ', 1) AS area_main_name, 
CAST(REPLACE(REPLACE(REPLACE(STATUS,'유찰',''),'회',''),'신건','0') AS CHAR(5)) AS STATUS_COUNT,
CAST(REPLACE(PRICE,',','') AS CHAR(20)) AS START_PRICE,
CAST(REPLACE(RESULT_PRICE,',','') AS CHAR(20)) RESULT_PRICE
FROM Auction_Apart_Info
WHERE result_price IS NOT NULL
and result_price != '0'
AND STR_TO_DATE(due_date,'%Y.%m.%d ') BETWEEN date_add(now(),interval -1 month) AND NOW()
) as a
GROUP BY a.area_main_name
) AS aa,
(
SELECT 
a.area_main_name
, COUNT(1) AS TOTAL_COUNT
, ROUND(AVG(a.STATUS_COUNT),1) AS STATUS_COUNT
, ROUND(AVG(a.START_PRICE)/10000,0) AS AVG_START_PRICE
, ROUND(AVG(a.RESULT_PRICE)/10000,0) AS AVG_RESULT_PRICE
, ROUND((AVG(a.START_PRICE) - AVG(a.RESULT_PRICE))/10000,0) AS DIFF_PRICE
, ROUND(100 - (SUM(a.RESULT_PRICE) / SUM(a.START_PRICE) * 100),2) AS UPDOWN_RATE
FROM
(
SELECT 
SUBSTRING_INDEX(LOCATION, ' ', 1) AS area_main_name, 
CAST(REPLACE(REPLACE(REPLACE(STATUS,'유찰',''),'회',''),'신건','0') AS CHAR(5)) AS STATUS_COUNT,
CAST(REPLACE(PRICE,',','') AS CHAR(20)) AS START_PRICE,
CAST(REPLACE(RESULT_PRICE,',','') AS CHAR(20)) RESULT_PRICE
FROM Auction_Apart_Info
WHERE result_price IS NOT NULL
and result_price != '0'
AND STR_TO_DATE(due_date,'%Y.%m.%d ') BETWEEN date_add(now(),INTERVAL -2 month) AND date_add(now(),interval -1 month)
) as a
GROUP BY a.area_main_name
) AS bb
WHERE aa.area_main_name = bb.area_main_name
) AS aaa
ORDER BY aaa.main_seq

-->

<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : todayhouseprice.com@gmail.com</b></span></center>

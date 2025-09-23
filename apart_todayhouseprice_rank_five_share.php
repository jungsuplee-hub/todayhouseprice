<head>
<link rel='stylesheet' type='text/css' href='./todayhouseprice.css'>
</head>

<?php
$Conn = mysqli_connect("localhost", "root", "e0425820", "jsdb", 33306);
mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");


$rs_today = mysqli_query($Conn, "select dallor, gumri_usa, gumri_korea, kospi, kosdaq, substr(update_date,1,19) as update_date from today_index");
$row_today = mysqli_fetch_assoc($rs_today);


$sql = "
select
insert_date, area_main_name, area_sub_name, total_price, total_cnt, cast(total_avg as decimal(10,2)) as total_avg
from avg_meme_price_apart_85
where insert_date = '2023-02-25'
order by cast(total_avg as decimal(10,2)) desc
limit 100;
";


$rs = mysqli_query($Conn, $sql);
$rs_count = mysqli_num_rows($rs);
while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

?>

<div class="market-indicators-wrapper">
  <div class="market-indicators">
    <a class="market-indicator" href="https://m.search.naver.com/search.naver?where=m&sm=mtb_etc&mra=blJH&qvt=0&query=%EB%8C%80%ED%95%9C%EB%AF%BC%EA%B5%AD%20%EC%A4%91%EC%95%99%EC%9D%80%ED%96%89%20%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC" target="_blank" rel="noopener noreferrer">
      <span class="market-indicator__label">기준금리 :</span>
      <span class="market-indicator__icon" aria-hidden="true">🇰🇷</span>
      <span class="market-indicator__value"><?=$row_today['gumri_korea']?></span>
    </a>
    <span class="market-indicator__divider" aria-hidden="true">|</span>
    <a class="market-indicator" href="https://m.search.naver.com/p/crd/rd?m=1&px=736&py=298&sx=736&sy=298&p=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&q=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&ie=utf8&rev=1&ssc=tab.m.all&f=m&w=m&s=LoFy%2FTw7JT27hrVNgxlLxg%3D%3D&time=1672725258737&abt=%5B%7B%22eid%22%3A%22PWL-AREA-EX%22%2C%22vid%22%3A%222%22%7D%2C%7B%22eid%22%3A%22SBR1%22%2C%22vid%22%3A%22634%22%7D%5D&a=nco_xgr*3.list&r=1&i=88211u5i_000000000000&u=https%3A%2F%2Fm.search.naver.com%2Fsearch.naver%3Fwhere%3Dm%26sm%3Dmtb_etc%26mra%3DblJH%26qvt%3D0%26query%3D%25EB%25AF%25B8%25EA%25B5%25AD%2520%25EC%25A4%2591%25EC%2595%2599%25EC%259D%2580%25ED%2596%2589%2520%25EA%25B8%25B0%25EC%25A4%2580%25EA%25B8%2588%25EB%25A6%25AC&cr=1" target="_blank" rel="noopener noreferrer">
      <span class="market-indicator__icon" aria-hidden="true">🇺🇸</span>
      <span class="market-indicator__value"><?=$row_today['gumri_usa']?></span>
    </a>
    <a class="market-indicator" href="https://m.search.naver.com/search.naver?sm=mtb_hty.top&where=m&oquery=%EA%B8%B0%EC%A4%80%EA%B8%88%EB%A6%AC&tqi=hJnuJlpr4K8ssEFzQ5ZssssstIC-072630&query=%ED%99%98%EC%9C%A8" target="_blank" rel="noopener noreferrer">
      <span class="market-indicator__icon" aria-hidden="true">🔔</span>
      <span class="market-indicator__label">환율 :</span>
      <span class="market-indicator__value"><?=$row_today['dallor']?>원</span>
    </a>
    <a class="market-indicator" href="https://finance.naver.com/sise/" target="_blank" rel="noopener noreferrer">
      <span class="market-indicator__icon" aria-hidden="true">📈</span>
      <span class="market-indicator__label">코스피 :</span>
      <span class="market-indicator__value"><?=$row_today['kospi']?></span>
    </a>
  </div>
  <div class="market-indicators__update">(updated : <?=$row_today['update_date']?>)</div>
</div>
<br>


<h1>전국 국평(85㎡, 100세대 이상) 평균가격 Top 100</h1>
<span style="font-size: 25px;">*참고
<br>. 국토부 아파트상세정보와 매칭이 안되 집계가 누락되는 케이스가 존재할 수 있습니다.
<br>. 각 아파트별 마지막 거래가격 기준입니다.
<br>. 참고로만 봐주시기 바랍니다.
</span>
<br><br>


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
      <?php $add_count = 0; foreach ($rows as $row) { $add_count = $add_count + 1; ?>
      <tr>
          <td style="font-size: 30px;"><b><?=$add_count?></b></td>
          <td style="font-size: 30px;"><b><?=$row['area_main_name']?> <?=$row['area_sub_name']?></b></td>
          <td style="font-size: 30px;"><b><?=$row['total_avg']?>억</b></td>
          <td style="font-size: 30px;"><b><?=$row['total_cnt']?>개</b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>

<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : todayhouseprice.com@gmail.com</b></span></center>

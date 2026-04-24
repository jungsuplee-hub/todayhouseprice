<?php
include_once "./top_page.php";
?>
<?php



$sql = "
select
news_company,
news_title,
news_link,
news_picture_link,
substr(insert_date,1,10) as insert_date
from budongsan_news_history
order by insert_date desc
limit 30;
    ";



$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

$this_site = str_replace('.php','',basename( $_SERVER[ "PHP_SELF" ] ));

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




<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->

<h1>부동산관련 최신뉴스</h1>

<span style="font-size:25px;"><b>*참고 : 텍스트 기반으로 자동으로 수집하기 때문에 일부 부동산과 맞지 않는 뉴스가 있을 수도 있습니다.</b></span>
<br>
<br>
<?php if($advertize=="1"){ ?>
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
        <th style="font-size: 20px; width:10%;">신문사</th>
        <th style="font-size: 20px; width:28%;">사진</th>
        <th style="font-size: 20px; width:46%;">제목</th>
        <th style="font-size: 20px; width:16%;">일자</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 18px; width:10%;"><b><?=$row['news_company']?></b></td>
          <td style="font-size: 18px; width:28%;"><a href="<?=$row['news_link']?>" target="_blank"><b><img style="vertical-align: middle;" width="200", height="120" src="<?=$row['news_picture_link']?>"></a></b></td>
          <td style="font-size: 18px; width:46%;"><b><a href="<?=$row['news_link']?>" target="_blank"><?=$row['news_title']?></a></b></td>
          <td style="font-size: 15px; width:16%;"><b><?=$row['insert_date']?></b></td>


      </tr>
      <?php } ?>
    </tbody>
</table>

<?php if($advertize=="1"){ ?>
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

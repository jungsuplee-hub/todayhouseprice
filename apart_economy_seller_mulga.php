<?php
include_once "{$_SERVER[DOCUMENT_ROOT]}/top_page.php";
?>

<?php
$sql_chart = "
select
yyyymm,
IFNULL(CAST(MAX(case when area = '총지수' then cnt end) as DECIMAL(10,0)),0) as cnt_all
from TongGye_Seller_Mulga
group by yyyymm
order by yyyymm
";

$sql_min_max = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+10 as temp_max
FROM TongGye_Seller_Mulga
where area = '총지수'
";


$sql = "
select
concat(substr(yyyymm,1,4),'년 ',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '총지수' then cnt end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '상품' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '농림수산품' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '광산품' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '공산품' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '전력가스수도및폐기물' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '서비스' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '운송서비스' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '음식및숙박서비스' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '정보통신및방송서비스' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '금융및보험서비스' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '부동산서비스' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전물과학및기술서비스' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '사업지원서비스' then cnt end) as DECIMAL(10,0)),0) as cnt13
from TongGye_Seller_Mulga
group by yyyymm
order by yyyymm desc
    ";


$result_chart = mysqli_query($Conn, $sql_chart);

while ($row_chart = mysqli_fetch_assoc($result_chart)) {
    $data_array[] = $row_chart;
}
$chart = json_encode($data_array);

$result_min_max = mysqli_query($Conn, $sql_min_max);
$row_min_max = mysqli_fetch_assoc($result_min_max);
//여기는 그래프 관련


$rs = mysqli_query($Conn, $sql);

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




<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<span style="font-size:20px;">한국은행 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://kosis.kr/statHtml/statHtml.do?orgId=301&tblId=DT_404Y014'>[출처링크]</a></span>
<br>
<br>

<span style="font-size:15px;">
  - 물가지수는 가격의 변동추이 측정이 목적이며, 가격의 절대수준을 나타내지는 않음<br>
  - 농림수산품의 조사대상가격은 도매시장 경락가격 또는 유통가격으로 농어가의 판매가격이 아님<br>
  - 소비자물가지수와 비교는 가능하나 생산자판매단계와 소매단계의 마진을 측정하는 데 이용될 수는 없음<br>
  - 생산자물가지수는 총지수의 추정을 위해 표본설계되어 있으므로 최하위 분류단위인 품목별 지수는 통계적 유의성이 떨어질 수 있음<br>
</span>
<br>
<br>

<span style="font-size:30px;">생산자 물가지수 그래프</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '생산자물가지수'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt_all)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '생산자물가지수 추이',
            legend: 'none',
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
                title: 'Time',
                showTextEvery: 20    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0, lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max['temp_min']?>, max: <?=$row_min_max['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div'));
        lineChart.draw(data, lineChartOptions);

        // 테이블 차트
        //var tableChartOptions = {
        //    showRowNumber: true,
        //    width: '40%',
        //    height: '20%'
        //}

        //var tableChart = new google.visualization.Table(document.getElementById('tableChart_div'));
        //tableChart.draw(data, tableChartOptions);
    }
</script>


<center><div id="lineChart_div" style="width: 100%; height: 400px"></div></center>


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
        <th style="font-size: 15px;">조사시점</th>
        <th style="font-size: 15px;">총지수</th>
        <th style="font-size: 15px;">상품</th>
        <th style="font-size: 15px;">농림수산품</th>
        <th style="font-size: 15px;">광산품</th>
        <th style="font-size: 15px;">공산품</th>
        <th style="font-size: 15px;">전려가스수도<br>및폐기물</th>
        <th style="font-size: 15px;">서비스</th>
        <th style="font-size: 15px;">운송<br>서비스</th>
        <th style="font-size: 15px;">음식점및<br>숙박서비스</th>
        <th style="font-size: 15px;">정보통신및<br>방송서비스</th>
        <th style="font-size: 15px;">금융및<br>보험서비스</th>
        <th style="font-size: 15px;">부동산<br>서비스</th>
        <th style="font-size: 15px;">전문과학및<br>기술서비스</th>
        <th style="font-size: 15px;">사업지원<br>서비스</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row['yyyymm']?>월</b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt_all']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt1']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt2']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt3']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt4']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt5']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt6']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt7']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt8']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt9']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt10']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt11']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt12']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt13']?></b></td>

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

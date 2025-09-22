<?php
include_once "./top_page.php";
?>
<?php
$sql_chart = "
select dt, temp
from
(
select
concat(substr(RESEARCH_DATE,1,4),'/',substr(RESEARCH_DATE,5,2),'/',substr(RESEARCH_DATE,7,2)) as dt,
CAST(JEON_SND_INDICES as DECIMAL(10,2)) as temp
from AptRentalMarketTrend
where 1=1
and LEVEL_NO = 0
and REGION_CD = 'A1000'
order by RESEARCH_DATE desc
limit 156
) aa
order by aa.dt
";

$sql_min_max = "
select
MIN(CAST(JEON_SND_INDICES as DECIMAL(10,2)))-5 as temp_min,
MAX(CAST(JEON_SND_INDICES as DECIMAL(10,2)))+5 as temp_max
from AptRentalMarketTrend
where 1=1
and LEVEL_NO = 0
and REGION_CD = 'A1000'
order by RESEARCH_DATE desc
limit 156;
";


$sql = "
  select concat(substr(RESEARCH_DATE,1,4),'/',substr(RESEARCH_DATE,5,2),'/',substr(RESEARCH_DATE,7,2)) as RESEARCH_DATE,
  CAST(MAX(case when REGION_CD = 'A1000' then JEON_SND_INDICES end) as DECIMAL(10,2)) as case_BUY_A1000,
  CAST(MAX(case when REGION_CD = '11000' then JEON_SND_INDICES end) as DECIMAL(10,2)) as case_BUY_11000,
  CAST(MAX(case when REGION_CD = 'A2000' then JEON_SND_INDICES end) as DECIMAL(10,2)) as case_BUY_A2000,
  CAST(MAX(case when REGION_CD = 'A2001' then JEON_SND_INDICES end) as DECIMAL(10,2)) as case_BUY_A2001,
  CAST(MAX(case when REGION_CD = 'A3000' then JEON_SND_INDICES end) as DECIMAL(10,2)) as case_BUY_A3000,
  CAST(MAX(case when REGION_CD = 'A9000' then JEON_SND_INDICES end) as DECIMAL(10,2)) as case_BUY_A9000
  from
  (
  select RESEARCH_DATE, REGION_CD, JEON_SND_INDICES
  from AptRentalMarketTrend
  where 1=1
  and LEVEL_NO = 0
  and REGION_CD in ('A1000','11000','A2000','A2001','A3000','A9000')
  ) aa
  group by aa.RESEARCH_DATE
  order by aa.RESEARCH_DATE desc
  limit 156
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
<span style="font-size:20px;">국토부 제공 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://www.data.go.kr/data/15099305/openapi.do'>[출처링크]</a>
<br>전세수급지수는 100을 기준으로, 이보다 낮을수록 집을 구하려는 수요가 적음을 나타낸다.</span>
<br>
<br>
<span style="font-size:30px;">최근3년 전국 아파트 전세수급동향 그래프</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '전세수급동향'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.dt,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.temp)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전세수급동향 추이',
            legend: 'none',
            chartArea: {left: '4%', width: '93%'},
            hAxis: {
                title: 'Time',
                showTextEvery: 15    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
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


<center><div id="lineChart_div" style="width: 100%; height: 300px"></div></center>


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
        <th style="font-size: 20px;">조사날짜</th>
        <th style="font-size: 20px;">전국</th>
        <th style="font-size: 20px;">서울</th>
        <th style="font-size: 20px;">수도권</th>
        <th style="font-size: 20px;">지방권</th>
        <th style="font-size: 20px;">6대광역시</th>
        <th style="font-size: 20px;">9개도</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px;"><b><?=$row['RESEARCH_DATE']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['case_BUY_A1000']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['case_BUY_11000']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['case_BUY_A2000']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['case_BUY_A2001']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['case_BUY_A3000']?></b></td>
          <td style="font-size: 20px;"><b><?=$row['case_BUY_A9000']?></b></td>
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

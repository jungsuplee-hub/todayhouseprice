<?php
include_once "../top_page.php";
?>

<?php
$sql_chart = "
SELECT YEAR, cnt
FROM TongGye_Population
WHERE age = '계'
ORDER BY year
";

$sql_min_max = "
SELECT 
max(cnt) as temp_max, 
min(cnt) as temp_min
FROM TongGye_Population
WHERE age = '계'
";


$sql = "
SELECT 
YEAR,
cnt_total,
cnt_0019,
cnt_2039,
cnt_4059,
cnt_6079,
cnt_8000,
ROUND((cnt_0019 / cnt_total * 100),2) as cnt_0019_rate,
ROUND((cnt_2039 / cnt_total * 100),2) as cnt_2039_rate,
ROUND((cnt_4059 / cnt_total * 100),2) as cnt_4059_rate,
ROUND((cnt_6079 / cnt_total * 100),2) as cnt_6079_rate,
ROUND((cnt_8000 / cnt_total * 100),2) as cnt_8000_rate  
FROM
(
select
YEAR,
SUM(case when age = '계' then cnt ELSE 0 END) cnt_total,
SUM(case when age = '0 - 4세' OR age = '5 - 9세' OR age = '10 - 14세' OR age = '15 - 19세' then cnt ELSE 0 END) cnt_0019,
SUM(case when age = '20 - 24세' OR age = '25 - 29세' OR age = '30 - 34세' OR age = '35 - 39세' then cnt ELSE 0 END) cnt_2039,
SUM(case when age = '40 - 44세' OR age = '45 - 49세' OR age = '50 - 54세' OR age = '55 - 59세' then cnt ELSE 0 END) cnt_4059,
SUM(case when age = '60 - 64세' OR age = '65 - 69세' OR age = '70 - 74세' OR age = '75 - 79세' then cnt ELSE 0 END) cnt_6079,
SUM(case when age = '80 - 84세' OR age = '85 - 89세' OR age = '90 - 94세' OR age = '95 - 99세' OR age = '100세 이상' then cnt ELSE 0 END) cnt_8000
from TongGye_Population
group by YEAR 
) a
ORDER BY YEAR 
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


<span style="font-size:20px;">통계청 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://kosis.kr/statHtml/statHtml.do?orgId=101&tblId=DT_1BPA001'>[출처링크]</a></span>
<br>
<br>
<span style="font-size:30px;">년도별 총인구 그래프</span>
<br>
<br>


<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','총인구'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.YEAR,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '년도별 총인구 (예상치)',
            chartArea: {left: '10%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 5    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max['temp_min']?>, max: <?=$row_min_max['temp_max']?>},title : "총인구"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div'));
        lineChart.draw(data, lineChartOptions);
    }
</script>



<center><div id="lineChart_div" style="width: 100%; height: 400px"></div></center>


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

<span style="font-size: 30px;">년도별 총인구 상세데이터 <span>

<table>
    <thead>
    <tr>
        <th style="font-size: 20px; width:10%">년도</th>
        <th style="font-size: 20px; width:16%">전체</th>
        <th style="font-size: 20px; width:15%">0세-19세<br>(비율%)</th>
        <th style="font-size: 20px; width:15%">20세-39세<br>(비율%)</th>
        <th style="font-size: 20px; width:15%">40세-59세<br>(비율%)</th>
        <th style="font-size: 20px; width:15%">60세-79세<br>(비율%)</th>
        <th style="font-size: 20px; width:14%">80세이상<br>(비율%)</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px;"><b><?=$row['YEAR']?>년</b></td>
          <td style="font-size: 20px;"><b><?=number_format($row['cnt_total'])?></b></td>
          <td style="font-size: 20px;"><b><?=number_format($row['cnt_0019'])?></b><br>(<?=$row['cnt_0019_rate']?>%)</td>
          <td style="font-size: 20px;"><b><?=number_format($row['cnt_2039'])?></b><br>(<?=$row['cnt_2039_rate']?>%)</td>
          <td style="font-size: 20px;"><b><?=number_format($row['cnt_4059'])?></b><br>(<?=$row['cnt_4059_rate']?>%)</td>
          <td style="font-size: 20px;"><b><?=number_format($row['cnt_6079'])?></b><br>(<?=$row['cnt_6079_rate']?>%)</td>
          <td style="font-size: 20px;"><b><?=number_format($row['cnt_8000'])?></b><br>(<?=$row['cnt_8000_rate']?>%)</td>
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

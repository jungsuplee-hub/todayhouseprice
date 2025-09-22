<?php
include_once "./top_page.php";
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






<?php
$sql_chart = "
select
yyyymm,
IFNULL(CAST(fire_rate as DECIMAL(10,2)),0) as cnt1
from TongGye_EconomyPopulation
group by yyyymm
order by yyyymm
";

$sql_min_max = "
select
min(CAST(fire_rate as DECIMAL(10,2))) as temp_min, max(CAST(fire_rate as DECIMAL(10,2))) as temp_max
FROM TongGye_EconomyPopulation
";

$result_chart = mysqli_query($Conn, $sql_chart);

while ($row_chart = mysqli_fetch_assoc($result_chart)) {
    $data_array[] = $row_chart;
}
$chart = json_encode($data_array);

$result_min_max = mysqli_query($Conn, $sql_min_max);
$row_min_max = mysqli_fetch_assoc($result_min_max);
//여기는 그래프 관련

?>



<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<span style="font-size:20px;">통계청 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://kosis.kr/statHtml/statHtml.do?orgId=101&tblId=DT_1DA7001S'>[출처링크]</a></span>
<br>
<br>
<span style="font-size:30px;">경제활동인구 총괄</span>
<br>
<br>
<span style="font-size:30px;">실업률 (%)</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '실업률'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
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

<center><div id="lineChart_div" style="width: 100%; height: 200px"></div></center>



<?php
$sql_chart2 = "
select
yyyymm,
IFNULL(CAST(hire_rate as DECIMAL(10,2)),0) as cnt1
from TongGye_EconomyPopulation
group by yyyymm
order by yyyymm
";

$sql_min_max2 = "
select
min(CAST(hire_rate as DECIMAL(10,2))) as temp_min, max(CAST(hire_rate as DECIMAL(10,2))) as temp_max
FROM TongGye_EconomyPopulation
";

$result_chart2 = mysqli_query($Conn, $sql_chart2);

while ($row_chart2 = mysqli_fetch_assoc($result_chart2)) {
    $data_array2[] = $row_chart2;
}
$chart2 = json_encode($data_array2);

$result_min_max2 = mysqli_query($Conn, $sql_min_max2);
$row_min_max2 = mysqli_fetch_assoc($result_min_max2);
//여기는 그래프 관련

?>



<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>
<span style="font-size:30px;">고용률 (%)</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart2; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '고용률'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
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
                    viewWindow: { min: <?=$row_min_max2['temp_min']?>, max: <?=$row_min_max2['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div2'));
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

<center><div id="lineChart_div2" style="width: 100%; height: 200px"></div></center>


<?php
$sql_chart03 = "
select
yyyymm,
IFNULL(CAST(population_eco as DECIMAL(10,0)),0) as cnt1
from TongGye_EconomyPopulation
group by yyyymm
order by yyyymm
";

$sql_min_max03 = "
select
min(CAST(population_eco as DECIMAL(10,0))) as temp_min, max(CAST(population_eco as DECIMAL(10,0))) as temp_max
FROM TongGye_EconomyPopulation
";

$result_chart03 = mysqli_query($Conn, $sql_chart03);

while ($row_chart03 = mysqli_fetch_assoc($result_chart03)) {
    $data_array03[] = $row_chart03;
}
$chart03 = json_encode($data_array03);

$result_min_max03 = mysqli_query($Conn, $sql_min_max03);
$row_min_max03 = mysqli_fetch_assoc($result_min_max03);
//여기는 그래프 관련

?>



<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>
<span style="font-size:30px;">경제활동 인구 (천명)</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart03; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '경제활동 인구'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
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
                    viewWindow: { min: <?=$row_min_max03['temp_min']?>, max: <?=$row_min_max03['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div03'));
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

<center><div id="lineChart_div03" style="width: 100%; height: 300px"></div></center>




<?php
$sql_chart3 = "
select
yyyymm,
IFNULL(CAST(parti_eco_rate as DECIMAL(10,2)),0) as cnt1
from TongGye_EconomyPopulation
group by yyyymm
order by yyyymm
";

$sql_min_max3 = "
select
min(CAST(parti_eco_rate as DECIMAL(10,2))) as temp_min, max(CAST(parti_eco_rate as DECIMAL(10,2))) as temp_max
FROM TongGye_EconomyPopulation
";

$result_chart3 = mysqli_query($Conn, $sql_chart3);

while ($row_chart3 = mysqli_fetch_assoc($result_chart3)) {
    $data_array3[] = $row_chart3;
}
$chart3 = json_encode($data_array3);

$result_min_max3 = mysqli_query($Conn, $sql_min_max3);
$row_min_max3 = mysqli_fetch_assoc($result_min_max3);
//여기는 그래프 관련

?>



<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>
<span style="font-size:30px;">경제활동 참가율 (%)</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart3; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '경제활동 참가율'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
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
                    viewWindow: { min: <?=$row_min_max3['temp_min']?>, max: <?=$row_min_max3['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div3'));
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

<center><div id="lineChart_div3" style="width: 100%; height: 300px"></div></center>



<?php
$sql = "
select
concat(substr(yyyymm,1,4),'년 ',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(population_all as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(population_eco as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(hire as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(fire as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(population_noeco as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(parti_eco_rate as DECIMAL(10,1)),0) as cnt6,
IFNULL(CAST(fire_rate as DECIMAL(10,1)),0) as cnt7,
IFNULL(CAST(hire_rate as DECIMAL(10,1)),0) as cnt8
from TongGye_EconomyPopulation
group by yyyymm
order by yyyymm desc
    ";

$rs = mysqli_query($Conn, $sql);

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}
?>


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
        <th style="font-size: 15px;">15세이상인구<br>(천명)</th>
        <th style="font-size: 15px;">경제활동인구<br>(천명)</th>
        <th style="font-size: 15px;">취업자<br>(천명)</th>
        <th style="font-size: 15px;">실업자<br>(천명)</th>
        <th style="font-size: 15px;">비경제활동인구<br>(천명)</th>
        <th style="font-size: 15px;">경제활동참가율<br>(%)</th>
        <th style="font-size: 15px;">실업률<br>(%)</th>
        <th style="font-size: 15px;">고용률<br>(%)</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row['yyyymm']?>월</b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt1']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt2']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt3']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt4']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt5']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt6']?>%</b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt7']?>%</b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt8']?>%</b></td>
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

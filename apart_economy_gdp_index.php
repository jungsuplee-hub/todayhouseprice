<?php
include_once "{$_SERVER[DOCUMENT_ROOT]}/top_page.php";
?>

<?php
$sql_chart = "
select
yyyyquarter,
IFNULL(CAST(cnt as DECIMAL(10,2)),0) as cnt1
from TongGye_GDP
group by yyyyquarter
order by yyyyquarter
";

$sql_min_max = "
select min(CAST(cnt as DECIMAL(10,2))) as temp_min, max(CAST(cnt as DECIMAL(10,2))) as temp_max
FROM TongGye_GDP
";


$sql = "
select
concat(substr(yyyyquarter,1,4),'년 ',substr(yyyyquarter,5,2)) as yyyyquarter,
IFNULL(CAST(cnt as DECIMAL(10,2)),0) as cnt1
from TongGye_GDP
group by yyyyquarter
order by yyyyquarter desc
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
<span style="font-size:20px;">한국은행 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://kosis.kr/statHtml/statHtml.do?orgId=301&tblId=DT_200Y002'>[출처링크]</a></span>
<br>
<br>
<span style="font-size:30px;">분기별 국내총생산(실질성장률) 그래프 (전분기대비%)</span>
<br>
<br>


<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','경제성장률'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyyquarter,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '년도별 경제성장률 추이',
            chartArea: {left: '10%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 7    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max['temp_min']?>, max: <?=$row_min_max['temp_max']?>},title : "경제성장률"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div'));
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



<br>

<details>
   <summary><span style="font-size: 30px;">분기별 국내총생산(실질성장률) 데이터 상세보기(클릭)<span></summary>

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
            <th style="font-size: 20px; width:20%">조사시점</th>
            <th style="font-size: 20px; width:20%">경제성장률</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row) { ?>
          <tr>
              <td style="font-size: 20px;"><b><?=$row['yyyyquarter']?>분기</b></td>
              <td style="font-size: 20px;"><b><?=$row['cnt1']?>%</b></td>
          </tr>
          <?php } ?>
        </tbody>
    </table>
</details>


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






<?php
$sql_chart2 = "
select
year,
IFNULL(CAST(cnt as DECIMAL(10,2)),0) as cnt1
from TongGye_GDP_year
group by year
order by year
";

$sql_min_max2 = "
select min(CAST(cnt as DECIMAL(10,2))) as temp_min, max(CAST(cnt as DECIMAL(10,2))) as temp_max
FROM TongGye_GDP_year
";


$sql2 = "
select
year as year,
IFNULL(CAST(cnt as DECIMAL(10,2)),0) as cnt1
from TongGye_GDP_year
group by year
order by year desc
    ";


$result_chart2 = mysqli_query($Conn, $sql_chart2);

while ($row_chart2 = mysqli_fetch_assoc($result_chart2)) {
    $data_array2[] = $row_chart2;
}
$chart2 = json_encode($data_array2);

$result_min_max2 = mysqli_query($Conn, $sql_min_max2);
$row_min_max2 = mysqli_fetch_assoc($result_min_max2);
//여기는 그래프 관련


$rs2 = mysqli_query($Conn, $sql2);

while ( $row2 = mysqli_fetch_assoc($rs2) ) {
    $rows2[] = $row2;
}
?>




<br>
<br>
<span style="font-size:30px;">년도별 국내총생산(실질성장률) 그래프 (전년도대비%)</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart2; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','경제성장률'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.year,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '년도별 경제성장률 추이',
            chartArea: {left: '10%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 1    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max2['temp_min']?>, max: <?=$row_min_max2['temp_max']?>},title : "경제성장률"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div2'));
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



<center><div id="lineChart_div2" style="width: 100%; height: 400px"></div></center>


<br>


<details>
   <summary><span style="font-size: 30px;">년도별 국내총생산(실질성장률) 데이터 상세보기(클릭)<span></summary>
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
            <th style="font-size: 20px; width:20%">조사시점</th>
            <th style="font-size: 20px; width:20%">경제성장률</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($rows2 as $row2) { ?>
          <tr>
              <td style="font-size: 20px;"><b><?=$row2['year']?>년</b></td>
              <td style="font-size: 20px;"><b><?=$row2['cnt1']?>%</b></td>
          </tr>
          <?php } ?>
        </tbody>
    </table>
</details>




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

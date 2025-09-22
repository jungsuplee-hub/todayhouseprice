<?php
include_once "./top_page.php";
?>

<?php
$sql_chart = "
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '수출금액' then cnt end) as DECIMAL(10,0))/10000,0) as cnt1,
IFNULL(CAST(MAX(case when area = '수입금액' then cnt end) as DECIMAL(10,0))/10000,0) as cnt2,
IFNULL(CAST(MAX(case when area = '무역수지' then cnt end) as DECIMAL(10,0))/10000,0) as cnt3
from TongGye_InOut_Index
group by yyyymm
order by yyyymm
";

$sql_min_max = "
select min(CAST(cnt as DECIMAL(10,0)))/10000 as temp_min, max(CAST(cnt as DECIMAL(10,0)))/10000+100 as temp_max
FROM TongGye_InOut_Index
";


$sql = "
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
FORMAT(IFNULL(CAST(MAX(case when area = '수출금액' then cnt end) as DECIMAL(10,0)),0)/10000,0) as cnt1,
FORMAT(IFNULL(CAST(MAX(case when area = '수입금액' then cnt end) as DECIMAL(10,0)),0)/10000,0) as cnt2,
FORMAT(IFNULL(CAST(MAX(case when area = '무역수지' then cnt end) as DECIMAL(10,0)),0)/10000,0) as cnt3
from TongGye_InOut_Index
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
<span style="font-size:20px;">관세청 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://kosis.kr/statHtml/statHtml.do?orgId=134&tblId=DT_134001_001'>[출처링크]</a></span>
<br>
<br>
<span style="font-size:30px;">수출금액 / 수입금액 / 무역수지 그래프 (천만달러)</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '수출금액', '수입금액', '무역수지'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt2),
                Number(item.cnt3)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '수출/수입/무역수지 추이',
            chartArea: {left: '10%', width: '79%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0}
            ,1: {type: 'line', targetAxisIndex: 0}
            ,2: {type: 'bars', targetAxisIndex: 1 , color: '#515a5a'}},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max['temp_max']?>}, title : "수출/수입(천만달러)"
                },
                1: {
                    title : "무역수지(천만달러)"
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
   <summary><span style="font-size: 30px;">수출금액 / 수입금액 / 무역수지 데이터 상세보기(클릭)<span></summary>

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
            <th style="font-size: 20px;">조사시점</th>
            <th style="font-size: 20px;">수출금액<br>(천만달러)</th>
            <th style="font-size: 20px;">수입금액<br>(천만달러)</th>
            <th style="font-size: 20px;">무역수지<br>(천만달러)</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row) { ?>
          <tr>
              <td style="font-size: 20px;"><b><?=$row['yyyymm']?></b></td>
              <td style="font-size: 20px;"><b><?=$row['cnt1']?></b></td>
              <td style="font-size: 20px;"><b><?=$row['cnt2']?></b></td>
              <td style="font-size: 20px;"><b><?=$row['cnt3']?></b></td>

          </tr>
          <?php } ?>
        </tbody>
    </table>
</details>





<?php
$sql_chart2 = "
select
left(yyyymm,4) as year,
SUM(CAST(cnt as DECIMAL(10,0))/10000) as total
from TongGye_InOut_Index
where area = '무역수지'
group by left(yyyymm,4)
order by left(yyyymm,4)
";

$sql_min_max2 = "
select
min(total/10000)-10000 as temp_min, max(total/10000)+10000 as temp_max
FROM
(
select
left(yyyymm,4) as year,
SUM(CAST(cnt as DECIMAL(10,0))) as total
from TongGye_InOut_Index
where area = '무역수지'
group by left(yyyymm,4)
) a
";


$sql2 = "
select
left(yyyymm,4) as year,
FORMAT(SUM(CAST(cnt as DECIMAL(10,0)))/10000,0) as total
from TongGye_InOut_Index
where area = '무역수지'
group by left(yyyymm,4)
order by left(yyyymm,4) desc
    ";

$result_chart2 = mysqli_query($Conn, $sql_chart2);

while ($row_chart2 = mysqli_fetch_assoc($result_chart2)) {
    $data_array2[] = $row_chart2;
}
$chart2 = json_encode($data_array2);

//여기는 그래프 관련

$result_min_max2 = mysqli_query($Conn, $sql_min_max2);
$row_min_max2 = mysqli_fetch_assoc($result_min_max2);
//여기는 그래프 관련


$rs2 = mysqli_query($Conn, $sql2);

while ( $row2 = mysqli_fetch_assoc($rs2) ) {
    $rows2[] = $row2;
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



<br><br>

<span style="font-size:30px;">무역수지 연도별 합계 그래프 (천만달러)</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart2; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','무역수지'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.year,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.total)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '년도별 무역수지 합계 추이',
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
                    viewWindow: { min: <?=$row_min_max2['temp_min']?>, max: <?=$row_min_max2['temp_max']?>},title : "무역수지(천만달러)"
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
   <summary><span style="font-size: 30px;">년도 합계 무역수지 데이터 상세보기(클릭)<span></summary>

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
            <th style="font-size: 20px;">조사시점</th>
            <th style="font-size: 20px;">무역수지<br>(천만달러)</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach ($rows2 as $row2) { ?>
          <tr>
              <td style="font-size: 20px;"><b><?=$row2['year']?></b></td>
              <td style="font-size: 20px;"><b><?=$row2['total']?></b></td>

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

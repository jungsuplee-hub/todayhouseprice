<?php
include_once "../top_page.php";
?>

<?php


//$apart_name = $_REQUEST["apart_name"];
//$size = ROUND($_REQUEST["size"]);
//$dong = $_REQUEST["dong"];
$area_main_name = $_REQUEST["area_main_name"];
$year = $_REQUEST["year"];
//$all_area = $_REQUEST["all_area"];


if($area_main_name=="" || $area_main_name=="전체"){
  $area_main_name_text = "";
  $area_main_name="전체";
}else{
  $area_main_name_text = "and area_main_name = '$area_main_name'";
}

if($year==""){
  $year = "2023";
}
$year_text = "and year = '$year'";
//if( $all_area == "Y"){
//  $size_text = "";
//}else{
//  $size_text = "and ROUND(CAST(size as DECIMAL(10,2))) = '$size'";
//}




$sql = "
select area_main_name
, sum(1_cnt) as 1_cnt
,sum(2_cnt) as 2_cnt
,sum(3_cnt) as 3_cnt
,sum(4_cnt) as 4_cnt
,sum(5_cnt) as 5_cnt
,sum(6_cnt) as 6_cnt
,sum(7_cnt) as 7_cnt
,sum(8_cnt) as 8_cnt
,sum(9_cnt) as 9_cnt
,sum(10_cnt) as 10_cnt
,sum(11_cnt) as 11_cnt
,sum(12_cnt) as 12_cnt
from
(
SELECT
area_main_name
,case when month='1' then sum(cnt) else 0 end as 1_cnt
,case when month='2' then sum(cnt) else 0 end as 2_cnt
,case when month='3' then sum(cnt) else 0 end as 3_cnt
,case when month='4' then sum(cnt) else 0 end as 4_cnt
,case when month='5' then sum(cnt) else 0 end as 5_cnt
,case when month='6' then sum(cnt) else 0 end as 6_cnt
,case when month='7' then sum(cnt) else 0 end as 7_cnt
,case when month='8' then sum(cnt) else 0 end as 8_cnt
,case when month='9' then sum(cnt) else 0 end as 9_cnt
,case when month='10' then sum(cnt) else 0 end as 10_cnt
,case when month='11' then sum(cnt) else 0 end as 11_cnt
,case when month='12' then sum(cnt) else 0 end as 12_cnt
FROM molit_trend
where type = '오피스텔매매'
$year_text
group by area_main_name, month
) as a
group by a.area_main_name
    ";

$sql_detail = "
    select replace(replace(area_name, concat(area_main_name,' '),''),' ','') as area_main_name
    , sum(1_cnt) as 1_cnt
    ,sum(2_cnt) as 2_cnt
    ,sum(3_cnt) as 3_cnt
    ,sum(4_cnt) as 4_cnt
    ,sum(5_cnt) as 5_cnt
    ,sum(6_cnt) as 6_cnt
    ,sum(7_cnt) as 7_cnt
    ,sum(8_cnt) as 8_cnt
    ,sum(9_cnt) as 9_cnt
    ,sum(10_cnt) as 10_cnt
    ,sum(11_cnt) as 11_cnt
    ,sum(12_cnt) as 12_cnt
    from
    (
    SELECT
    max(area_main_name) as area_main_name,
    area_name
    ,case when month='1' then sum(cnt) else 0 end as 1_cnt
    ,case when month='2' then sum(cnt) else 0 end as 2_cnt
    ,case when month='3' then sum(cnt) else 0 end as 3_cnt
    ,case when month='4' then sum(cnt) else 0 end as 4_cnt
    ,case when month='5' then sum(cnt) else 0 end as 5_cnt
    ,case when month='6' then sum(cnt) else 0 end as 6_cnt
    ,case when month='7' then sum(cnt) else 0 end as 7_cnt
    ,case when month='8' then sum(cnt) else 0 end as 8_cnt
    ,case when month='9' then sum(cnt) else 0 end as 9_cnt
    ,case when month='10' then sum(cnt) else 0 end as 10_cnt
    ,case when month='11' then sum(cnt) else 0 end as 11_cnt
    ,case when month='12' then sum(cnt) else 0 end as 12_cnt
    FROM molit_trend
    where type = '오피스텔매매'
    $year_text
    $area_main_name_text
    group by area_name, month
    ) as a
    group by a.area_name
        ";

$sql_rent = "
select area_main_name
, sum(1_cnt) as 1_cnt
,sum(2_cnt) as 2_cnt
,sum(3_cnt) as 3_cnt
,sum(4_cnt) as 4_cnt
,sum(5_cnt) as 5_cnt
,sum(6_cnt) as 6_cnt
,sum(7_cnt) as 7_cnt
,sum(8_cnt) as 8_cnt
,sum(9_cnt) as 9_cnt
,sum(10_cnt) as 10_cnt
,sum(11_cnt) as 11_cnt
,sum(12_cnt) as 12_cnt
from
(
SELECT
area_main_name
,case when month='1' then sum(cnt) else 0 end as 1_cnt
,case when month='2' then sum(cnt) else 0 end as 2_cnt
,case when month='3' then sum(cnt) else 0 end as 3_cnt
,case when month='4' then sum(cnt) else 0 end as 4_cnt
,case when month='5' then sum(cnt) else 0 end as 5_cnt
,case when month='6' then sum(cnt) else 0 end as 6_cnt
,case when month='7' then sum(cnt) else 0 end as 7_cnt
,case when month='8' then sum(cnt) else 0 end as 8_cnt
,case when month='9' then sum(cnt) else 0 end as 9_cnt
,case when month='10' then sum(cnt) else 0 end as 10_cnt
,case when month='11' then sum(cnt) else 0 end as 11_cnt
,case when month='12' then sum(cnt) else 0 end as 12_cnt
FROM molit_trend
where type = '오피스텔전월세'
$year_text
group by area_main_name, month
) as a
group by a.area_main_name
    ";

$sql_detail_rent = "
    select replace(replace(area_name, concat(area_main_name,' '),''),' ','') as area_main_name
    , sum(1_cnt) as 1_cnt
    ,sum(2_cnt) as 2_cnt
    ,sum(3_cnt) as 3_cnt
    ,sum(4_cnt) as 4_cnt
    ,sum(5_cnt) as 5_cnt
    ,sum(6_cnt) as 6_cnt
    ,sum(7_cnt) as 7_cnt
    ,sum(8_cnt) as 8_cnt
    ,sum(9_cnt) as 9_cnt
    ,sum(10_cnt) as 10_cnt
    ,sum(11_cnt) as 11_cnt
    ,sum(12_cnt) as 12_cnt
    from
    (
    SELECT
    max(area_main_name) as area_main_name,
    area_name
    ,case when month='1' then sum(cnt) else 0 end as 1_cnt
    ,case when month='2' then sum(cnt) else 0 end as 2_cnt
    ,case when month='3' then sum(cnt) else 0 end as 3_cnt
    ,case when month='4' then sum(cnt) else 0 end as 4_cnt
    ,case when month='5' then sum(cnt) else 0 end as 5_cnt
    ,case when month='6' then sum(cnt) else 0 end as 6_cnt
    ,case when month='7' then sum(cnt) else 0 end as 7_cnt
    ,case when month='8' then sum(cnt) else 0 end as 8_cnt
    ,case when month='9' then sum(cnt) else 0 end as 9_cnt
    ,case when month='10' then sum(cnt) else 0 end as 10_cnt
    ,case when month='11' then sum(cnt) else 0 end as 11_cnt
    ,case when month='12' then sum(cnt) else 0 end as 12_cnt
    FROM molit_trend
    where type = '오피스텔전월세'
    $year_text
    $area_main_name_text
    group by area_name, month
    ) as a
    group by a.area_name
        ";

mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

//조회수 출력
$sql_count = "
select
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count),0),0) AS total,
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count WHERE YMD = '$today'),0),0) AS today
FROM DUAL;
";
$rs_count = mysqli_query($Conn, $sql_count);
$row_count = mysqli_fetch_assoc($rs_count);

if($area_main_name=="" || $area_main_name=="전체"){
  $rs = mysqli_query($Conn, $sql);
}else{
  $rs = mysqli_query($Conn, $sql_detail);
}
while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

if($area_main_name=="" || $area_main_name=="전체"){
  $rs_rent = mysqli_query($Conn, $sql_rent);
}else{
  $rs_rent = mysqli_query($Conn, $sql_detail_rent);
}
while ( $row_rent = mysqli_fetch_assoc($rs_rent) ) {
    $rows_rent[] = $row_rent;
}

//여기는 그래프 관련
$sql_chart = "
    SELECT
    concat(month,'월') as month
    , sum(case when YEAR = '2020' then cnt ELSE 0 END)  AS cnt20
    , sum(case when YEAR = '2021' then cnt ELSE 0 END)  AS cnt21
    , sum(case when YEAR = '2022' then cnt ELSE 0 END)  AS cnt22
    , sum(case when YEAR = '2023' then cnt ELSE 0 END)  AS cnt23
    FROM molit_trend
    where type = '오피스텔매매'
    $area_main_name_text
    group by month
    order by cast(month as unsigned)
    ";


$sql_min_max = "
    select max(cnt)+100 as max_cnt, min(cnt)-100 as min_cnt
    from
    (
    SELECT year, month, sum(cnt) as cnt
        FROM molit_trend
        where type = '오피스텔매매'
        $area_main_name_text
        group by year, month
    ) as a
";

//여기는 그래프 관련
$sql_chart_rent = "
    SELECT
    concat(month,'월') as month
    , sum(case when YEAR = '2020' then cnt ELSE 0 END)  AS cnt20
    , sum(case when YEAR = '2021' then cnt ELSE 0 END)  AS cnt21
    , sum(case when YEAR = '2022' then cnt ELSE 0 END)  AS cnt22
    , sum(case when YEAR = '2023' then cnt ELSE 0 END)  AS cnt23
    FROM molit_trend
    where type = '오피스텔전월세'
    $area_main_name_text
    group by month
    order by cast(month as unsigned)
    ";
$sql_min_max_rent = "
    select max(cnt)+100 as max_cnt, min(cnt)-100 as min_cnt
    from
    (
    SELECT year, month, sum(cnt) as cnt
        FROM molit_trend
        where type = '오피스텔전월세'
        $area_main_name_text
        group by year, month
    ) as a
";

$result_chart = mysqli_query($Conn, $sql_chart);

if (mysqli_num_rows($result_chart) > 0) {
    while ($row_chart = mysqli_fetch_assoc($result_chart)) {
        $data_array[] = $row_chart;
    }
    $chart = json_encode($data_array);

    $result_min_max = mysqli_query($Conn, $sql_min_max);
    $row_min_max = mysqli_fetch_assoc($result_min_max);

}

$result_chart_rent = mysqli_query($Conn, $sql_chart_rent);

if (mysqli_num_rows($result_chart_rent) > 0) {
    while ($row_chart_rent = mysqli_fetch_assoc($result_chart_rent)) {
        $data_array_rent[] = $row_chart_rent;
    }
    $chart_rent = json_encode($data_array_rent);

    $result_min_max_rent = mysqli_query($Conn, $sql_min_max_rent);
    $row_min_max_rent = mysqli_fetch_assoc($result_min_max_rent);

}
//여기는 그래프 관련

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
<span style="font-size:20px;">국토부 제공 실거래 자료를 바탕으로 하기 때문에 참고 용도로만 사용하시기 바랍니다.<br>전일까지 데이터를 집계한 결과 입니다.(금일 실거래 건은 다음날 반영 됩니다.)<br></span>
<br>
<select style="width:220px;font-size:30px;" name="main" id="main" onchange="apart_list(this)">
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
<span style="font-size:30px;">오피스텔 매매 거래량 그래프</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['년도별/월별', '2020년', '2021년', '2022년', '2023년'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.month,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt20),
                Number(item.cnt21),
                Number(item.cnt22),
                Number(item.cnt23)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var Options = {
            title: '년도별/월별 거래량',
            chartArea: {left: '6%', width: '82%'},
            hAxis: {
                //title: '월',
                showTextEvery: 1    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            seriesType: "bars",
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            series: {
                0: { targetAxisIndex: 0 }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max['max_cnt']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var memeChart = new google.visualization.ComboChart(document.getElementById('memeChart_div'));
        memeChart.draw(data, Options);

        // 테이블 차트
        //var tableChartOptions = {
        //    showRowNumber: true,
        //    width: '40%',
        //    height: '20%'
        //}

        //var tableChart = new google.visualization.Table(document.getElementById('tableChart_div'));
        //tableChart.draw(data, tableChartOptions);
    }

    google.charts.setOnLoadCallback(drawChart2);

    function drawChart2() {
        var chart_array = <?php echo $chart_rent; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['년도별/월별', '2020년', '2021년', '2022년', '2023년'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.month,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt20),
                Number(item.cnt21),
                Number(item.cnt22),
                Number(item.cnt23)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var Options = {
            title: '년도별/월별 거래량',
            chartArea: {left: '6%', width: '82%'},
            hAxis: {
                //title: '월',
                showTextEvery: 1    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            seriesType: "bars",
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            series: {
                0: { targetAxisIndex: 0 }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max_rent['max_cnt']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var rentChart = new google.visualization.ComboChart(document.getElementById('rentChart_div'));
        rentChart.draw(data, Options);

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





<?php

//여기는 그래프 관련
$sql_chart2 = "
    SELECT
    concat(year,'년 ',month,'월') as yearmonth
    ,sum(cnt)  AS cnt
    FROM molit_trend
    where type = '오피스텔매매'
    $area_main_name_text
    group by year, month
    order by cast(year as unsigned), cast(month as unsigned)
    ";


$sql_min_max2 = "
    select max(cnt)+100 as temp_max, min(cnt)-100 as temp_min
    from
    (
    SELECT year, month, sum(cnt) as cnt
        FROM molit_trend
        where type = '오피스텔매매'
        $area_main_name_text
        group by year, month
    ) as a
";



$result_chart2 = mysqli_query($Conn, $sql_chart2);

while ($row_chart2 = mysqli_fetch_assoc($result_chart2)) {
    $data_array2[] = $row_chart2;
}
$chart2 = json_encode($data_array2);

$result_min_max2 = mysqli_query($Conn, $sql_min_max2);
$row_min_max2 = mysqli_fetch_assoc($result_min_max2);



?>


<span style="font-size:30px;">년월별 매매 거래량 그래프</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart2; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','거래량'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yearmonth,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '년월별 거래량 추이',
            chartArea: {left: '10%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 8    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max2['temp_max']?>},title : "거래량"
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
<span style="font-size:30px;">월별 매매 거래량 그래프</span>
<br>




<center><div id="memeChart_div" style="width: 100%; height: 300px"></div></center>
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


<span style="font-size:30px;"><?=$area_main_name?> 오피스텔 전월세 거래량 그래프</span>
<br>




<?php

//여기는 그래프 관련
$sql_chart3 = "
    SELECT
    concat(year,'년 ',month,'월') as yearmonth
    ,sum(cnt)  AS cnt
    FROM molit_trend
    where type = '오피스텔전월세'
    $area_main_name_text
    group by year, month
    order by cast(year as unsigned), cast(month as unsigned)
    ";


$sql_min_max3 = "
    select max(cnt)+100 as temp_max, min(cnt)-100 as temp_min
    from
    (
    SELECT year, month, sum(cnt) as cnt
        FROM molit_trend
        where type = '오피스텔전월세'
        $area_main_name_text
        group by year, month
    ) as a
";



$result_chart3 = mysqli_query($Conn, $sql_chart3);

while ($row_chart3 = mysqli_fetch_assoc($result_chart3)) {
    $data_array3[] = $row_chart3;
}
$chart3 = json_encode($data_array3);

$result_min_max3 = mysqli_query($Conn, $sql_min_max3);
$row_min_max3 = mysqli_fetch_assoc($result_min_max3);



?>


<span style="font-size:30px;">년월별 전세 거래량 그래프</span>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart3; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','거래량'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yearmonth,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '년월별 거래량 추이',
            chartArea: {left: '10%', width: '85%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 8    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max3['temp_max']?>},title : "거래량"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div3'));
        lineChart.draw(data, lineChartOptions);
    }
</script>



<center><div id="lineChart_div3" style="width: 100%; height: 400px"></div></center>


<br>
<span style="font-size:30px;">월별 전세 거래량 그래프</span>
<br>


<center><div id="rentChart_div" style="width: 100%; height: 300px"></div></center>
<br>

<select style="width:130px;font-size:30px;" name="year" id="year" onchange="apart_year(this)">
  <option value="2023" <?php if ($year=='2023'){echo 'selected';} ?>>2023</option>
  <option value="2022" <?php if ($year=='2022'){echo 'selected';} ?>>2022</option>
  <option value="2021" <?php if ($year=='2021'){echo 'selected';} ?>>2021</option>
  <option value="2020" <?php if ($year=='2020'){echo 'selected';} ?>>2020</option>
  <option value="2019" <?php if ($year=='2019'){echo 'selected';} ?>>2019</option>
  <option value="2018" <?php if ($year=='2018'){echo 'selected';} ?>>2018</option>
  <option value="2017" <?php if ($year=='2017'){echo 'selected';} ?>>2017</option>
</select>
<span style="font-size:30px;">년 </span>

<span style="font-size:30px;"><b><?=$area_main_name?> 매매 / 전월세 거래량 상세데이터</b></span>
<br>
<br>
<span style="font-size:30px;"><?=$area_main_name?> 오피스텔 매매 거래량 상세</span>

<table>
    <thead>
    <tr>
      <th style="font-size: 20px;">지역</th>
      <th style="font-size: 20px;">1월</th>
      <th style="font-size: 20px;">2월</th>
      <th style="font-size: 20px;">3월</th>
      <th style="font-size: 20px;">4월</th>
      <th style="font-size: 20px;">5월</th>
      <th style="font-size: 20px;">6월</th>
      <th style="font-size: 20px;">7월</th>
      <th style="font-size: 20px;">8월</th>
      <th style="font-size: 20px;">9월</th>
      <th style="font-size: 20px;">10월</th>
      <th style="font-size: 20px;">11월</th>
      <th style="font-size: 20px;">12월</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px;"><b><?=$row['area_main_name']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['1_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['2_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['3_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['4_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['5_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['6_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['7_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['8_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['9_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['10_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['11_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['12_cnt']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
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


<span style="font-size:30px;"><?=$area_main_name?> 오피스텔 전월세 거래량 상세</span>
<br>
<table>
    <thead>
    <tr>
      <th style="background: #809EAD; font-size: 20px;">지역</th>
      <th style="background: #809EAD; font-size: 20px;">1월</th>
      <th style="background: #809EAD; font-size: 20px;">2월</th>
      <th style="background: #809EAD; font-size: 20px;">3월</th>
      <th style="background: #809EAD; font-size: 20px;">4월</th>
      <th style="background: #809EAD; font-size: 20px;">5월</th>
      <th style="background: #809EAD; font-size: 20px;">6월</th>
      <th style="background: #809EAD; font-size: 20px;">7월</th>
      <th style="background: #809EAD; font-size: 20px;">8월</th>
      <th style="background: #809EAD; font-size: 20px;">9월</th>
      <th style="background: #809EAD; font-size: 20px;">10월</th>
      <th style="background: #809EAD; font-size: 20px;">11월</th>
      <th style="background: #809EAD; font-size: 20px;">12월</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows_rent as $row_rent) { ?>
      <tr>
          <td style="font-size: 20px;"><b><?=$row_rent['area_main_name']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['1_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['2_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['3_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['4_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['5_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['6_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['7_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['8_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['9_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['10_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['11_cnt']?></b></td>
          <td style="font-size: 15px;"><b><?=$row_rent['12_cnt']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<script>
function apart_list(e) {
  <?php echo "window.location.replace('./apart_trend.php?'+'area_main_name='+document.getElementById('main').value+'&year='+document.getElementById('year').value);"?>
}
function apart_year(e) {
  <?php echo "window.location.replace('./apart_trend.php?'+'area_main_name='+document.getElementById('main').value+'&year='+document.getElementById('year').value);"?>
}
</script>

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

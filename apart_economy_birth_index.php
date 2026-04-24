<?php
include_once "{$_SERVER[DOCUMENT_ROOT]}/top_page.php";
?>

<?php

$area_main_name = $_REQUEST["area_main_name"];

if($area_main_name == ""){
  $area_main_name = "서울특별시";
}


$sql_chart = "
select
year,
IFNULL(CAST(MAX(case when area = '전국' then birth_rate end) as DECIMAL(10,2)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '$area_main_name' then birth_rate end) as DECIMAL(10,2)),0) as cnt1
from TongGye_Birth
group by year
order by year
";

$sql_min_max = "
select min(CAST(birth_rate as DECIMAL(10,2))) as temp_min, max(CAST(birth_rate as DECIMAL(10,2))) as temp_max
FROM TongGye_Birth
where area in ('전국','$area_main_name')
";


$sql = "
select
year as year,
IFNULL(CAST(MAX(case when area = '전국' then birth_rate end) as DECIMAL(10,2)),2) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울특별시' then birth_rate end) as DECIMAL(10,2)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산광역시' then birth_rate end) as DECIMAL(10,2)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구광역시' then birth_rate end) as DECIMAL(10,2)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천광역시' then birth_rate end) as DECIMAL(10,2)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주광역시' then birth_rate end) as DECIMAL(10,2)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전광역시' then birth_rate end) as DECIMAL(10,2)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산광역시' then birth_rate end) as DECIMAL(10,2)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '세종특별자치시' then birth_rate end) as DECIMAL(10,2)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '경기도' then birth_rate end) as DECIMAL(10,2)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '강원도' then birth_rate end) as DECIMAL(10,2)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충청북도' then birth_rate end) as DECIMAL(10,2)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '충청남도' then birth_rate end) as DECIMAL(10,2)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전라북도' then birth_rate end) as DECIMAL(10,2)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '전라남도' then birth_rate end) as DECIMAL(10,2)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경상북도' then birth_rate end) as DECIMAL(10,2)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '경상남도' then birth_rate end) as DECIMAL(10,2)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '제주특별자치도' then birth_rate end) as DECIMAL(10,2)),0) as cnt17
from TongGye_Birth
group by year
order by year desc
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
<span style="font-size:20px;">통계청[인구동향조사] 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://kosis.kr/statHtml/statHtml.do?orgId=101&tblId=DT_1B81A23'>[출처링크]</a></span>
<br>
<br>
<span style="font-size:20px;">*참고<br>출산율 이란?<br>한 여자가 평생동안 평균 몇 명의 자녀를 낳는가를 나타내며, 출산력 수준비교를 위해 대표적으로 활용되는 지표로서 연령별 출산율(ASFR)의 총합</span>
<br>
<br>
<span style="font-size:30px;"><b>지역 : </b></span><select style="width:220px;font-size:30px;" name="main" id="main" onchange="apart_list(this)">
<?php
$rs_select = mysqli_query($Conn, "SELECT area_main_name FROM molit_area_info group by area_main_name ORDER BY MIN(area_code_seq)");
while ( $row_select = mysqli_fetch_assoc($rs_select) ) {
    $rows_select[] = $row_select;
}?>
<?php foreach ($rows_select as $row_select) { ?>
  <option value=<?php echo $row_select['area_main_name']; if ($row_select['area_main_name']==$area_main_name){echo ' selected';}?>><?php echo $row_select['area_main_name']; ?></option>
<?php } ?>
</select>

<script>
function apart_list(e) {
  <?php echo "window.location.replace('./apart_economy_birth_index.php?'+'area_main_name='+document.getElementById('main').value);"?>
}
</script>
<span style="font-size:30px;">&nbsp;&nbsp;년도별 출산율 그래프</span>
<br>
<br>


<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '<?=$area_main_name?>','전국'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.year,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt_all)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '출생률 추이',
            chartArea: {left: '7%', width: '91%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0}
            ,1: {type: 'bars', targetAxisIndex: 0}},
            hAxis: {
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
                    viewWindow: { min: 0.5, max: 2}
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
   <summary><span style="font-size: 30px;">년도별 출산율 데이터 상세보기(클릭)<span></summary>

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
          <th style="font-size: 15px;">조사년도</th>
          <th style="font-size: 15px;">전국</th>
          <th style="font-size: 13px;">서울</th>
          <th style="font-size: 13px;">부산</th>
          <th style="font-size: 13px;">대구</th>
          <th style="font-size: 13px;">인천</th>
          <th style="font-size: 13px;">광주</th>
          <th style="font-size: 13px;">대전</th>
          <th style="font-size: 13px;">울산</th>
          <th style="font-size: 13px;">세종</th>
          <th style="font-size: 13px;">경기</th>
          <th style="font-size: 13px;">강원</th>
          <th style="font-size: 13px;">충북</th>
          <th style="font-size: 13px;">충남</th>
          <th style="font-size: 13px;">전북</th>
          <th style="font-size: 13px;">전남</th>
          <th style="font-size: 13px;">경북</th>
          <th style="font-size: 13px;">경남</th>
          <th style="font-size: 13px;">제주</th>

      </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row) { ?>
        <tr>
            <td style="font-size: 15px;"><b><?=$row['year']?>년</b></td>
            <td style="font-size: 15px;"><b><?=$row['cnt_all']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt1']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt2']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt3']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt4']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt5']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt6']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt7']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt8']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt9']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt10']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt11']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt12']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt13']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt14']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt15']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt16']?></b></td>
            <td style="font-size: 13px;"><b><?=$row['cnt17']?></b></td>

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
year as year,
IFNULL(CAST(MAX(case when area = '서울특별시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '세종특별자치시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '경기도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '강원도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충청북도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '충청남도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전라북도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '전라남도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경상북도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '경상남도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '제주특별자치도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt17
from TongGye_Birth
group by year
order by year
";

$sql_min_max2 = "
select min(CAST(birth_cnt as DECIMAL(10,0))) as temp_min, max(CAST(birth_cnt as DECIMAL(10,0))) as temp_max
FROM TongGye_Birth
where area = '전국'
";


$sql2 = "
select
year as year,
IFNULL(CAST(MAX(case when area = '전국' then birth_cnt end) as DECIMAL(10,0)),2) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울특별시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산광역시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '세종특별자치시' then birth_cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '경기도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '강원도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충청북도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '충청남도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전라북도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '전라남도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경상북도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '경상남도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '제주특별자치도' then birth_cnt end) as DECIMAL(10,0)),0) as cnt17
from TongGye_Birth
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
<span style="font-size:30px;">년도별 출생아수 그래프</span>
<br>
<br>


<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart2; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '서울', '부산', '대구', '인천', '광주', '대전', '울산', '세종', '경기', '강원', '충북', '충남', '전북', '전남', '경북', '경남', '제주'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.year,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt2),
                Number(item.cnt3),
                Number(item.cnt4),
                Number(item.cnt5),
                Number(item.cnt6),
                Number(item.cnt7),
                Number(item.cnt8),
                Number(item.cnt9),
                Number(item.cnt10),
                Number(item.cnt11),
                Number(item.cnt12),
                Number(item.cnt13),
                Number(item.cnt14),
                Number(item.cnt15),
                Number(item.cnt16),
                Number(item.cnt17)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '출생아수 추이',
            chartArea: {left: '7%', width: '91%', height:'72%'},
            seriesType: "bars",
            isStacked: true,
            hAxis: {
                showTextEvery: 1    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
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
                    viewWindow: { min: 0, max: <?=$row_min_max2['temp_max']?> }
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
   <summary><span style="font-size: 30px;">년도별 출생아수 데이터 상세보기(클릭)<span></summary>

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
          <th style="font-size: 15px;">조사년도</th>
          <th style="font-size: 15px;">전국</th>
          <th style="font-size: 13px;">서울</th>
          <th style="font-size: 13px;">부산</th>
          <th style="font-size: 13px;">대구</th>
          <th style="font-size: 13px;">인천</th>
          <th style="font-size: 13px;">광주</th>
          <th style="font-size: 13px;">대전</th>
          <th style="font-size: 13px;">울산</th>
          <th style="font-size: 13px;">세종</th>
          <th style="font-size: 13px;">경기</th>
          <th style="font-size: 13px;">강원</th>
          <th style="font-size: 13px;">충북</th>
          <th style="font-size: 13px;">충남</th>
          <th style="font-size: 13px;">전북</th>
          <th style="font-size: 13px;">전남</th>
          <th style="font-size: 13px;">경북</th>
          <th style="font-size: 13px;">경남</th>
          <th style="font-size: 13px;">제주</th>

      </tr>
      </thead>
      <tbody>
        <?php foreach ($rows2 as $row2) { ?>
        <tr>
            <td style="font-size: 15px;"><b><?=$row2['year']?>년</b></td>
            <td style="font-size: 15px;"><b><?=$row2['cnt_all']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt1']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt2']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt3']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt4']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt5']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt6']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt7']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt8']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt9']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt10']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt11']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt12']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt13']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt14']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt15']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt16']?></b></td>
            <td style="font-size: 13px;"><b><?=$row2['cnt17']?></b></td>

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

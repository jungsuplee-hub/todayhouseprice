<?php
include_once "./top_page.php";
?>
<?php

$area_main_name = $_REQUEST["area_main_name"];

if($area_main_name == ""){
  $area_main_name = "서울특별시";
}

$area_main_name_short = "";

if($area_main_name == "강원도") { $area_main_name_short = "강원"; }
else if($area_main_name == "경기도")  { $area_main_name_short = "경기"; }
else if($area_main_name == "경상남도")  { $area_main_name_short = "경남"; }
else if($area_main_name == "경상북도")  { $area_main_name_short = "경북"; }
else if($area_main_name == "광주광역시")  { $area_main_name_short = "광주"; }
else if($area_main_name == "대구광역시")  { $area_main_name_short = "대구"; }
else if($area_main_name == "대전광역시")  { $area_main_name_short = "대전"; }
else if($area_main_name == "부산광역시")  { $area_main_name_short = "부산"; }
else if($area_main_name == "서울특별시")  { $area_main_name_short = "서울"; }
else if($area_main_name == "세종특별자치시")  { $area_main_name_short = "세종"; }
else if($area_main_name == "울산광역시")  { $area_main_name_short = "울산"; }
else if($area_main_name == "인천광역시")  { $area_main_name_short = "인천"; }
else if($area_main_name == "전라남도")  { $area_main_name_short = "전남"; }
else if($area_main_name == "전라북도")  { $area_main_name_short = "전북"; }
else if($area_main_name == "제주특별자치도")  { $area_main_name_short = "제주"; }
else if($area_main_name == "충청남도")  { $area_main_name_short = "충남"; }
else if($area_main_name == "충청북도")  { $area_main_name_short = "충북"; }


$sql_chart = "
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '전국' then cnt end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '$area_main_name_short' then cnt end) as DECIMAL(10,0)),0) as cnt1
from MemeAvg
group by yyyymm
order by yyyymm
";

$sql_min_max = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+50 as temp_max
FROM MemeAvg
where area = '$area_main_name_short'
";

$sql_min_max2 = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+50 as temp_max
FROM MemeAvg
where area = '전국'
";


$sql = "
select
concat(substr(yyyymm,1,4),'년 ',substr(yyyymm,5,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '전국' then cnt end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then cnt end) as DECIMAL(10,0)),0) as cnt17
from MemeAvg
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

$result_min_max2 = mysqli_query($Conn, $sql_min_max2);
$row_min_max2 = mysqli_fetch_assoc($result_min_max2);
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
<br>
<span style="font-size:20px;">한국 부동산원 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://kosis.kr/statHtml/statHtml.do?orgId=408&tblId=DT_KAB_11672_S15'>[출처링크]</a></span>
<br><br>
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
  <?php echo "window.location.replace('./apart_trend_meme_avg.php?'+'area_main_name='+document.getElementById('main').value);"?>
}
</script>
<span style="font-size:30px;">아파트 매매 실거래 평균가격 그래프 (단위: 만원/㎡)</span>
<br><br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '<?=$area_main_name_short?>','전국평균'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt_all)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '아파트 평균가격 추이',
            chartArea: {left: '7%', width: '91%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0}
            ,1: {type: 'line', targetAxisIndex: 0}},
            hAxis: {
                showTextEvery: 6    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?php if($row_min_max['temp_min']>$row_min_max2['temp_min']){ echo $row_min_max2['temp_min']; } else { echo $row_min_max['temp_min'];}?>, max: <?php if($row_min_max['temp_max']>$row_min_max2['temp_max']){echo $row_min_max['temp_max'];} else { echo $row_min_max2['temp_max'];}?>}
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
        <th style="font-size: 15px;">전국</th>
        <th style="font-size: 15px;">서울</th>
        <th style="font-size: 15px;">부산</th>
        <th style="font-size: 15px;">대구</th>
        <th style="font-size: 15px;">인천</th>
        <th style="font-size: 15px;">광주</th>
        <th style="font-size: 15px;">대전</th>
        <th style="font-size: 15px;">울산</th>
        <th style="font-size: 15px;">경기</th>
        <th style="font-size: 15px;">강원</th>
        <th style="font-size: 15px;">충북</th>
        <th style="font-size: 15px;">충남</th>
        <th style="font-size: 15px;">전북</th>
        <th style="font-size: 15px;">전남</th>
        <th style="font-size: 15px;">경북</th>
        <th style="font-size: 15px;">경남</th>
        <th style="font-size: 15px;">제주</th>
        <th style="font-size: 15px;">세종</th>
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
          <td style="font-size: 15px;"><b><?=$row['cnt14']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt15']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt16']?></b></td>
          <td style="font-size: 15px;"><b><?=$row['cnt17']?></b></td>

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

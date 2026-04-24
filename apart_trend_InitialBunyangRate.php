<?php
include_once "./top_page.php";
?>
<?php
$sql_chart = "
select
yyyyquarter,
IFNULL(CAST(MAX(case when area = '서울' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '수도권' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '기타지방' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '전국' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt_all
from InitialBunYangRate
group by yyyyquarter
order by yyyyquarter
";

$sql_min_max = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+10 as temp_max
FROM InitialBunYangRate
";


$sql = "
select
concat(substr(yyyyquarter,1,4),'년 ',substr(yyyyquarter,5,2)) as yyyyquarter,
IFNULL(CAST(MAX(case when area = '전국' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '수도권' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '기타지방' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt3
from InitialBunYangRate
group by yyyyquarter
order by yyyyquarter desc
    ";


$sql2 = "
select
concat(substr(yyyyquarter,1,4),'년 ',substr(yyyyquarter,5,2)) as yyyyquarter,
IFNULL(CAST(MAX(case when area = '전국' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충북' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충남' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전북' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전남' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경북' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경남' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종' then replace(cnt,'-','0') end) as DECIMAL(10,0)),0) as cnt17
from InitialBunYangRate
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


$rs2 = mysqli_query($Conn, $sql2);

while ( $row2 = mysqli_fetch_assoc($rs2) ) {
    $rows2[] = $row2;
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
<span style="font-size:20px;">주택도시보증공사 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://kosis.kr/statHtml/statHtml.do?orgId=414&tblId=DT_41401N_008'>[출처링크]</a></span>
<br>
<br>
<span style="font-size:30px;">아파트 평균 초기분양율 그래프</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '서울', '수도권', '기타지방','전국평균'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyyquarter,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt2),
                Number(item.cnt3),
                Number(item.cnt_all)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전국 초기분양률 추이',
            chartArea: {left: '7%', width: '88%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 4}
            ,1: {type: 'line', targetAxisIndex: 0, lineWidth: 4}
            ,2: {type: 'line', targetAxisIndex: 0, lineWidth: 4}
            ,3: {type: 'bars', targetAxisIndex: 0 , color: '#ced4da'}},
            hAxis: {
                showTextEvery: 2    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max['temp_max']?>}, title : "지역별"
                },
                1: {
                    viewWindow: { min: 0, max: 100}, title : "전국"
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
        <th style="font-size: 20px; width:20%">조사시점</th>
        <th style="font-size: 20px; width:20%">전국</th>
        <th style="font-size: 20px; width:20%">서울</th>
        <th style="font-size: 20px; width:20%">수도권</th>
        <th style="font-size: 20px; width:20%">지방</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) { ?>
      <tr>
          <td style="font-size: 20px;"><b><?=$row['yyyyquarter']?>분기</b></td>
          <td style="font-size: 20px;"><b><?=$row['cnt_all']?>%</b></td>
          <td style="font-size: 20px;"><b><?=$row['cnt1']?>%</b></td>
          <td style="font-size: 20px;"><b><?=$row['cnt2']?>%</b></td>
          <td style="font-size: 20px;"><b><?=$row['cnt3']?>%</b></td>
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
      <?php foreach ($rows2 as $row2) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row2['yyyyquarter']?>분기</b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt_all']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt1']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt2']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt3']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt4']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt5']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt6']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt7']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt8']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt9']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt10']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt11']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt12']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt13']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt14']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt15']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt16']?></b></td>
          <td style="font-size: 15px;"><b><?=$row2['cnt17']?></b></td>

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

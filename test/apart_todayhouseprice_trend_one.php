<?php
include_once "./top_page.php";
?>
<?php

$area_main_name = $_REQUEST["area_main_name"];

if($area_main_name == ""){
  $area_main_name = "서울특별시";
}

$sql_chart = "
select
yyyyquarter,
IFNULL(CAST(MAX(case when area = '$area_main_name_short' then cnt end) as DECIMAL(10,0)),0) as cnt1,
ROUND(avg(cast(cnt as UNSIGNED))) as cnt_all
from BuyBurdenIndex
group by yyyyquarter
order by yyyyquarter
";

$sql_min_max = "
select min(CAST(cnt as DECIMAL(10,0))) as temp_min, max(CAST(cnt as DECIMAL(10,0)))+10 as temp_max
FROM BuyBurdenIndex
where area = '$area_main_name_short'
";


$sql = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt_all,
ROUND(SUM(case when area_main_name = '서울특별시' then total_price end)     / SUM(case when area_main_name = '서울특별시' then total_cnt end)    ,4) as cnt_1,
ROUND(SUM(case when area_main_name = '부산광역시' then total_price end)     / SUM(case when area_main_name = '부산광역시' then total_cnt end)    ,4) as cnt_2,
ROUND(SUM(case when area_main_name = '대구광역시' then total_price end)     / SUM(case when area_main_name = '대구광역시' then total_cnt end)    ,4) as cnt_3,
ROUND(SUM(case when area_main_name = '인천광역시' then total_price end)     / SUM(case when area_main_name = '인천광역시' then total_cnt end)    ,4) as cnt_4,
ROUND(SUM(case when area_main_name = '광주광역시' then total_price end)     / SUM(case when area_main_name = '광주광역시' then total_cnt end)    ,4) as cnt_5,
ROUND(SUM(case when area_main_name = '대전광역시' then total_price end)     / SUM(case when area_main_name = '대전광역시' then total_cnt end)    ,4) as cnt_6,
ROUND(SUM(case when area_main_name = '울산광역시' then total_price end)     / SUM(case when area_main_name = '울산광역시' then total_cnt end)    ,4) as cnt_7,
ROUND(SUM(case when area_main_name = '경기도' then total_price end)         / SUM(case when area_main_name = '경기도' then total_cnt end)        ,4) as cnt_8,
ROUND(SUM(case when area_main_name = '강원도' then total_price end)         / SUM(case when area_main_name = '강원도' then total_cnt end)        ,4) as cnt_9,
ROUND(SUM(case when area_main_name = '충청북도' then total_price end)       / SUM(case when area_main_name = '충청북도' then total_cnt end)      ,4) as cnt_10,
ROUND(SUM(case when area_main_name = '충청남도' then total_price end)       / SUM(case when area_main_name = '충청남도' then total_cnt end)      ,4) as cnt_11,
ROUND(SUM(case when area_main_name = '전라북도' then total_price end)       / SUM(case when area_main_name = '전라북도' then total_cnt end)      ,4) as cnt_12,
ROUND(SUM(case when area_main_name = '전라남도' then total_price end)       / SUM(case when area_main_name = '전라남도' then total_cnt end)      ,4) as cnt_13,
ROUND(SUM(case when area_main_name = '경상북도' then total_price end)       / SUM(case when area_main_name = '경상북도' then total_cnt end)      ,4) as cnt_14,
ROUND(SUM(case when area_main_name = '경상남도' then total_price end)       / SUM(case when area_main_name = '경상남도' then total_cnt end)      ,4) as cnt_15,
ROUND(SUM(case when area_main_name = '제주특별자치도' then total_price end) / SUM(case when area_main_name = '제주특별자치도' then total_cnt end),4) as cnt_16,
ROUND(SUM(case when area_main_name = '세종특별자치시' then total_price end) / SUM(case when area_main_name = '세종특별자치시' then total_cnt end),4) as cnt_17,
SUM(total_cnt) as cnt_count_all,
SUM(case when area_main_name = '서울특별시' then total_cnt end) as cnt_count_1,
SUM(case when area_main_name = '부산광역시' then total_cnt end) as cnt_count_2,
SUM(case when area_main_name = '대구광역시' then total_cnt end) as cnt_count_3,
SUM(case when area_main_name = '인천광역시' then total_cnt end) as cnt_count_4,
SUM(case when area_main_name = '광주광역시' then total_cnt end) as cnt_count_5,
SUM(case when area_main_name = '대전광역시' then total_cnt end) as cnt_count_6,
SUM(case when area_main_name = '울산광역시' then total_cnt end) as cnt_count_7,
SUM(case when area_main_name = '경기도' then total_cnt end)     as cnt_count_8,
SUM(case when area_main_name = '강원도' then total_cnt end)     as cnt_count_9,
SUM(case when area_main_name = '충청북도' then total_cnt end)   as cnt_count_10,
SUM(case when area_main_name = '충청남도' then total_cnt end)   as cnt_count_11,
SUM(case when area_main_name = '전라북도' then total_cnt end)   as cnt_count_12,
SUM(case when area_main_name = '전라남도' then total_cnt end)   as cnt_count_13,
SUM(case when area_main_name = '경상북도' then total_cnt end)   as cnt_count_14,
SUM(case when area_main_name = '경상남도' then total_cnt end)   as cnt_count_15,
SUM(case when area_main_name = '제주특별자치도' then total_cnt end) as cnt_count_16,
SUM(case when area_main_name = '세종특별자치시' then total_cnt end) as cnt_count_17
FROM avg_meme_price_apart_85
GROUP BY INSERT_date
ORDER BY insert_Date desc
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
<span style="font-size:20px;">주택금융통계시스템 자료를 바탕으로 만들어진 데이터 입니다. <a href='https://houstat.hf.go.kr/research/portal/main/indexPage.do'>[출처링크]</a>
<br><br>주택구입부담지수란?
<br>중위소득 가구가 표준대출을 받아 중간가격의 주택을 구입하는 경우의 상환부담을 나타내는 지수
<br><br>ex) 지수가 91%라고 하면 중간소득 가구가 중간가격의 주택을 구입할 경우 <br>적정부담액 (소득의 약25%)의 90.1%를 주택구입담보대출 원리금 상환으로 부담한다는 것으로<br>지수의 수치가 높을수록 주택구입 부담이 커지는 것을 의미
</span>
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
  <?php echo "window.location.replace('./apart_trend_buy_burden.php?'+'area_main_name='+document.getElementById('main').value);"?>
}
</script>
<span style="font-size:30px;">주택구입부담지수 그래프</span>
<br>
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
                item.yyyyquarter,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt1),
                Number(item.cnt_all)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '주택구입 부담지수',
            chartArea: {left: '7%', width: '88%', height:'72%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0}
            ,1: {type: 'bars', targetAxisIndex: 0}},
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
                    viewWindow: { min: 0, max: <?php if($row_min_max['temp_max']>=100) { echo $row_min_max['temp_max']; } else { echo "100";}?>}
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
          <td style="font-size: 15px;"><b><?=$row['yyyyquarter']?>분기</b></td>
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

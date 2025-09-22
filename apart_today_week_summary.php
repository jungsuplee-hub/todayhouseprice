<?php
include_once "./top_page.php";
?>
<?php
$insert_date = date("Y-m-d");
$before1Day = date("Y-m-d", strtotime($today." -1 day"));
$before2Day = date("Y-m-d", strtotime($today." -2 day"));
$before3Day = date("Y-m-d", strtotime($today." -3 day"));
$before4Day = date("Y-m-d", strtotime($today." -4 day"));
$before5Day = date("Y-m-d", strtotime($today." -5 day"));
$before6Day = date("Y-m-d", strtotime($today." -6 day"));
$before7Day = date("Y-m-d", strtotime($today." -7 day"));
$before8Day = date("Y-m-d", strtotime($today." -8 day"));
$before9Day = date("Y-m-d", strtotime($today." -9 day"));
$before10Day = date("Y-m-d", strtotime($today." -10 day"));
$before11Day = date("Y-m-d", strtotime($today." -11 day"));
$before12Day = date("Y-m-d", strtotime($today." -12 day"));
$before13Day = date("Y-m-d", strtotime($today." -13 day"));
$before14Day = date("Y-m-d", strtotime($today." -14 day"));
$before15Day = date("Y-m-d", strtotime($today." -15 day"));
$before16Day = date("Y-m-d", strtotime($today." -16 day"));
$before17Day = date("Y-m-d", strtotime($today." -17 day"));
$before18Day = date("Y-m-d", strtotime($today." -18 day"));
$before19Day = date("Y-m-d", strtotime($today." -19 day"));
$before20Day = date("Y-m-d", strtotime($today." -20 day"));
$before21Day = date("Y-m-d", strtotime($today." -21 day"));
$before22Day = date("Y-m-d", strtotime($today." -22 day"));
$before23Day = date("Y-m-d", strtotime($today." -23 day"));
$before24Day = date("Y-m-d", strtotime($today." -24 day"));
$before25Day = date("Y-m-d", strtotime($today." -25 day"));
$before26Day = date("Y-m-d", strtotime($today." -26 day"));
$before27Day = date("Y-m-d", strtotime($today." -27 day"));
$before28Day = date("Y-m-d", strtotime($today." -28 day"));
$before29Day = date("Y-m-d", strtotime($today." -29 day"));
$before30Day = date("Y-m-d", strtotime($today." -30 day"));

//$insert_date = "2023-02-17";

$sql = "
      select
      	today.yearmonthday,
      	today.area_main_name,
      	replace(today.area_name,today.area_main_name,'') as area_name,
      	today.doing ,
      	today.apart_name,
      	CAST(today.size as DECIMAL(10,2)) as size,
      	today.stair,
      	today.price ,
      	today.TYPE,
      	today.STATUS ,
      	today.max_price,
      	today.max_price_date,
      	today.min_price,
      	today.min_price_date,
      	today.last_price,
      	today.last_price_date,
      	ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),0) as price_last,

      	case
  			  when CAST(today.price as DECIMAL(10,5)) > CAST(today.last_price as DECIMAL(10,5))
  			  then ROUND(((CAST(today.price as DECIMAL(10,5))/CAST(today.last_price as DECIMAL(10,5))*100)-100),0)
  			  when CAST(today.price as DECIMAL(10,5)) < CAST(today.last_price as DECIMAL(10,5))
  			  then ROUND(100-(CAST(today.price as DECIMAL(10,5))/CAST(today.last_price as DECIMAL(10,5)))*100,0)
			    ELSE 0 END AS percent,
        ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.max_price as DECIMAL(10,5))),0) as price_max,
        ROUND(100-(CAST(today.price as DECIMAL(10,5))/CAST(today.max_price as DECIMAL(10,5)))*100,0) AS max_percent,
			  IFNULL(rent.last_price,0) AS rent_last_price,
			  IFNULL(rent.max_price,0) AS rent_max_price,
			  IFNULL(rent.min_price,0) AS rent_min_price
      from molit_today_update today LEFT join molit_max_min_rent_all_group rent
      ON today.area_main_name = rent.area_main_name
      AND today.doing = rent.dong
      AND today.apart_name = rent.apart_name
      AND ROUND(CAST(today.size as DECIMAL(10,2))) = rent.size
      where today.insert_date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day')
      and today.status is not null
      AND !(today.last_price = '0' AND today.max_price != '0')
      ORDER BY ABS(ROUND((CAST(today.price as DECIMAL(10,5)) - CAST(today.last_price as DECIMAL(10,5))),2)) desc
      limit 10;
      ";

$sql_status = "
  SELECT
      (SELECT COUNT(1) from molit_today_update today WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') and status is not null) AS total,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='신고가' and status is not null GROUP BY STATUS),0) AS upup,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='상승' and status is not null GROUP BY STATUS),0) AS up,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='동일' and status is not null GROUP BY STATUS),0) AS same,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='하락' and status is not null GROUP BY STATUS),0) AS down,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='신저가' and status is not null GROUP BY STATUS),0) AS downdown,
      IFNULL((SELECT COUNT(1) from molit_today_update today WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') AND STATUS ='신규' and status is not null GROUP BY STATUS),0) AS new,
      (SELECT SUM(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),0))from molit_today_update today WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') and status is not null AND STATUS IN ('신고가','상승')) AS up_price,
      (SELECT SUM(ROUND((CAST(last_price as DECIMAL(10,5)) - CAST(price as DECIMAL(10,5))),0))from molit_today_update today WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day') and status is not null AND STATUS IN ('신저가','하락')) AS down_price
      FROM DUAL;
";




$rs = mysqli_query($Conn, $sql);
while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}

$rs_status = mysqli_query($Conn, $sql_status);
$row_status = mysqli_fetch_assoc($rs_status);
$rows_status[] = $row_status;


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



<h1>최근 일주일(<?=$before6Day?>~<?=$insert_date?>) 전국 아파트 시황

<br>

<br>1. 전국 거래 건수/금액합계</h1>
<span style="font-size:25px;"><b>총 <?php echo $row_status['total']; ?>건, <span style="color:green;">총 상승금액 : <?php if($row_status['up_price']==''){echo '0';}else{ echo $row_status['up_price'];} ?>억</span>, <span style="color:red;">총 하락금액 : <?php if($row_status['down_price']==''){echo '0';}else{ echo $row_status['down_price'];} ?>억</span><br>(<span style="color:green;">신고가 <?php echo $row_status['upup']; ?>건, 상승 <?php echo $row_status['up']; ?>건</span>, 동일 <?php echo $row_status['same']; ?>건, <span style="color:red;">하락 <?php echo $row_status['down']; ?>건, 신저가 <?php echo $row_status['downdown']; ?>건</span>, 신규 <?php echo $row_status['new']; ?>건)</b></span>
<br>







<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>
<h1>2. 전국 일자별 총 상승/하락 금액 (단위: 억원)</h1>


<?php
$sql_chart10 = "
SELECT insert_date,up_price,down_price,(down_price-up_price) as diff_price FROM
(
SELECT 
insert_date,
sum(case when STATUS = '상승' OR STATUS = '신고가' then cast(price as decimal(10,2)) - cast(last_price as decimal(10,2)) ELSE 0 END) AS up_price,
sum(case when STATUS = '하락' OR STATUS = '신저가' then cast(last_price as decimal(10,2)) - cast(price as decimal(10,2)) ELSE 0 END) AS down_price
FROM molit_today_update
GROUP BY insert_date
) AS a
WHERE a.up_price + a.down_price > 100
";

$sql_min_max10 = "
select case when max(down_price)>max(up_price) then max(down_price) else max(up_price) end as temp_max, 0 as temp_min
from
(
SELECT 
insert_date,
sum(case when STATUS = '상승' OR STATUS = '신고가' then cast(price as decimal(10,2)) - cast(last_price as decimal(10,2)) ELSE 0 END) AS up_price,
sum(case when STATUS = '하락' OR STATUS = '신저가' then cast(last_price as decimal(10,2)) - cast(price as decimal(10,2)) ELSE 0 END) AS down_price
FROM molit_today_update
GROUP BY insert_date
) as a
WHERE a.up_price + a.down_price > 100
";

$result_chart10 = mysqli_query($Conn, $sql_chart10);

while ($row_chart10 = mysqli_fetch_assoc($result_chart10)) {
    $data_array10[] = $row_chart10;
}
$chart10 = json_encode($data_array10);

$result_min_max10 = mysqli_query($Conn, $sql_min_max10);
$row_min_max10 = mysqli_fetch_assoc($result_min_max10);

?>



<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart10; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '상승', '하락', '차이'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.up_price),
                Number(item.down_price),
                Number(item.diff_price)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            chartArea: {left: '7%', width: '85%', height:'70%'},
            colors: ['#009900','#FF0000'],
            seriesType: "bars",
            series: {0: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,1: {type: 'line', targetAxisIndex: 0, lineWidth: 3}
            ,2: {type: 'bars', targetAxisIndex: 1, color: '#999999'}},
            hAxis: {
                showTextEvery: 8    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
                ,slantedText: true
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max10['temp_max']?>}, title : "상승/하락(억)"
                },
                1: {
                    viewWindow: { min: -100, max: 300}, title : "차이(억)"
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div10'));
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


<center><div id="lineChart_div10" style="width: 100%; height: 500px"></div></center>




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




<h1>3. 지역별 상승/하락 거래수, 상승/하락 금액</h1>



<?php
$sql_every = "
SELECT * FROM
(
SELECT 
case 
when b.area_main_name = '서울특별시' then 1 
when b.area_main_name = '경기도' then 2 
when b.area_main_name = '부산광역시' then 3 
when b.area_main_name = '대구광역시' then 4 
when b.area_main_name = '인천광역시' then 5 
when b.area_main_name = '광주광역시' then 6 
when b.area_main_name = '대전광역시' then 7 
when b.area_main_name = '울산광역시' then 8 
when b.area_main_name = '세종특별자치시' then 9
when b.area_main_name = '강원도' then 10
when b.area_main_name = '충청북도' then 11 
when b.area_main_name = '충청남도' then 12
when b.area_main_name = '전라남도' then 13
when b.area_main_name = '전라북도' then 14
when b.area_main_name = '경상남도' then 15
when b.area_main_name = '경상북도' then 16
when b.area_main_name = '제주특별자치도' then 17 ELSE 0 END AS main_seq, 
b.area_main_name ,

b.up_count, 
b.down_count ,
case when b.up_count>b.down_count then 'up' when b.up_count<b.down_count then 'down' ELSE 'same' END AS COUNT_STATUS,

b.up_price, 
b.down_price ,
case when b.up_price>b.down_price then 'up' when b.up_price<b.down_price then 'down' ELSE 'same' END AS PRICE_STATUS,

b_2.up_count_week, 
b_2.down_count_week ,
case when b_2.up_count_week>b_2.down_count_week then 'up' when b_2.up_count_week<b_2.down_count_week then 'down' ELSE 'same' END AS COUNT_STATUS_WEEK,

b_2.up_price_week, 
b_2.down_price_week ,
case when b_2.up_price_week>b_2.down_price_week then 'up' when b_2.up_price_week<b_2.down_price_week then 'down' ELSE 'same' END AS PRICE_STATUS_WEEK

FROM
(
	SELECT a.area_main_name, 
	SUM(a.total_count) AS total_count, 
	sum(a.up_count) AS up_count, 
	sum(a.down_count) AS down_count ,
	sum(a.same_count) AS same_count ,
	round(sum(a.up_price),0) AS up_price, 
	round(sum(a.down_price),0) AS down_price 
	FROM 
	(
		SELECT 
		area_main_name, 
		COUNT(1) AS total_count,
		sum(case when STATUS ='상승' then 1 when STATUS='신고가' then 1 ELSE 0 END) AS up_count ,
		sum(case when STATUS ='하락' then 1 when STATUS='신저가' then 1 ELSE 0 END) AS down_count ,
		sum(case when STATUS ='동일' then 1 when STATUS='신규' then 1 ELSE 0 END) AS same_count ,
		sum(case when STATUS ='상승' then (price-last_price) when STATUS='신고가' then (price-last_price) ELSE 0 END) AS up_price ,
		sum(case when STATUS ='하락' then (last_price-price) when STATUS='신저가' then (last_price-price) ELSE 0 END) AS down_price 
		FROM molit_today_update
		WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day')
		GROUP BY area_main_name
	) AS a 
	GROUP BY a.area_main_name
) AS b,
(
	SELECT a.area_main_name, 
	SUM(a.total_count) AS total_count_week, 
	sum(a.up_count) AS up_count_week, 
	sum(a.down_count) AS down_count_week ,
	sum(a.same_count) AS same_count_week ,
	round(sum(a.up_price),0) AS up_price_week, 
	round(sum(a.down_price),0) AS down_price_week 
	FROM 
	(
		SELECT 
		area_main_name, 
		COUNT(1) AS total_count,
		sum(case when STATUS ='상승' then 1 when STATUS='신고가' then 1 ELSE 0 END) AS up_count ,
		sum(case when STATUS ='하락' then 1 when STATUS='신저가' then 1 ELSE 0 END) AS down_count ,
		sum(case when STATUS ='동일' then 1 when STATUS='신규' then 1 ELSE 0 END) AS same_count ,
		sum(case when STATUS ='상승' then (price-last_price) when STATUS='신고가' then (price-last_price) ELSE 0 END) AS up_price ,
		sum(case when STATUS ='하락' then (last_price-price) when STATUS='신저가' then (last_price-price) ELSE 0 END) AS down_price 
		FROM molit_today_update
		WHERE insert_Date IN ('$insert_date','$before1Day','$before2Day','$before3Day','$before4Day','$before5Day','$before6Day','$before7Day','$before8Day','$before9Day','$before10Day','$before11Day','$before12Day','$before13Day','$before14Day','$before15Day','$before16Day','$before17Day','$before18Day','$before19Day','$before20Day','$before21Day','$before22Day','$before23Day','$before24Day','$before25Day','$before26Day','$before27Day','$before28Day','$before29Day','$before30Day')
		GROUP BY area_main_name
	) AS a 
	GROUP BY a.area_main_name
) AS b_2
WHERE b.area_main_name = b_2.area_main_name
) AS c
ORDER BY c.main_seq
      ";

$rs_every = mysqli_query($Conn, $sql_every);
while ( $row_every = mysqli_fetch_assoc($rs_every) ) {
    $rows_every[] = $row_every;
}

?>



<table>
    <thead>
    <tr>
        <th style="font-size: 30px; width:20%; padding: .5em .5em; background: #FBE5D6; color:black;" rowspan='2'><b><center>지역</center></b></th>
        <th style="font-size: 30px; width:40%; padding: .5em .5em; background: #FBE5D6; color:black;" colspan='4'><b><center>최근 일주일</center></b></th>
        <th style="font-size: 30px; width:40%; padding: .5em .5em; background: #FBE5D6; color:black;" colspan='4'><b><center>최근 한달</center></b></th>
    </tr>
    <tr>
        <th style="font-size: 20px; width:10%; padding: .5em .5em; background: #DEEBF7; color:black;"><b><center>상승거래<br>(건)</center></b></th>
        <th style="font-size: 20px; width:10%; padding: .5em .5em; background: #DEEBF7; color:black;"><b><center>하락거래<br>(건)</center></b></th>
        <th style="font-size: 20px; width:10%; padding: .5em .5em; background: #E2F0D9; color:black;"><b><center>상승금액<br>(억)</center></b></th>
        <th style="font-size: 20px; width:10%; padding: .5em .5em; background: #E2F0D9; color:black;"><b><center>하락금액<br>(억)</center></b></th>
        <th style="font-size: 20px; width:10%; padding: .5em .5em; background: #DEEBF7; color:black;"><b><center>상승거래<br>(건)</center></b></th>
        <th style="font-size: 20px; width:10%; padding: .5em .5em; background: #DEEBF7; color:black;"><b><center>하락거래<br>(건)</center></b></th>
        <th style="font-size: 20px; width:10%; padding: .5em .5em; background: #E2F0D9; color:black;"><b><center>상승금액<br>(억)</center></b></th>
        <th style="font-size: 20px; width:10%; padding: .5em .5em; background: #E2F0D9; color:black;"><b><center>하락금액<br>(억)</center></b></th>
    </tr>
    </thead>
    <tbody>
      <?php $rowcount = 0; foreach ($rows_every as $row_every) { $rowcount = $rowcount + 1; ?>
      <tr>
          <td style="font-size: 25px; width:20%; padding: .3em .3em;"><b><?=$row_every['area_main_name']?></b></td>
          <td style="font-size: 25px; width:10%; padding: .3em .3em; <?php if($row_every[COUNT_STATUS]=='up'){echo 'background-color:rgba(0, 255, 0, 0.4);';} ?>"><b><?=$row_every['up_count']?></b></td>
          <td style="font-size: 25px; width:10%; padding: .3em .3em; <?php if($row_every[COUNT_STATUS]=='down'){echo 'background-color:rgba(255, 0, 0, 0.4);';} ?>"><b><?=$row_every['down_count']?></b></td>
          <td style="font-size: 25px; width:10%; padding: .3em .3em; <?php if($row_every[PRICE_STATUS]=='up'){echo 'background-color:rgba(0, 255, 0, 0.4);';} ?>"><b><?=$row_every['up_price']?></b></td>
          <td style="font-size: 25px; width:10%; padding: .3em .3em; <?php if($row_every[PRICE_STATUS]=='down'){echo 'background-color:rgba(255, 0, 0, 0.4);';} ?>"><b><?=$row_every['down_price']?></b></td>
          <td style="font-size: 25px; width:10%; padding: .3em .3em; <?php if($row_every[COUNT_STATUS_WEEK]=='up'){echo 'background-color:rgba(0, 255, 0, 0.4);';} ?>"><b><?=$row_every['up_count_week']?></b></td>
          <td style="font-size: 25px; width:10%; padding: .3em .3em; <?php if($row_every[COUNT_STATUS_WEEK]=='down'){echo 'background-color:rgba(255, 0, 0, 0.4);';} ?>"><b><?=$row_every['down_count_week']?></b></td>
          <td style="font-size: 25px; width:10%; padding: .3em .3em; <?php if($row_every[PRICE_STATUS_WEEK]=='up'){echo 'background-color:rgba(0, 255, 0, 0.4);';} ?>"><b><?=$row_every['up_price_week']?></b></td>
          <td style="font-size: 25px; width:10%; padding: .3em .3em; <?php if($row_every[PRICE_STATUS_WEEK]=='down'){echo 'background-color:rgba(255, 0, 0, 0.4);';} ?>"><b><?=$row_every['down_price_week']?></b></td>
      </tr>
      <?php } ?>
    </tbody>
</table>












<br>
<h1>4. 전국 국평(85㎡) 아파트 평균가격 그래프(단위: 억)</h1>



<?php
$sql_chart = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart = mysqli_query($Conn, $sql_chart);

while ($row_chart = mysqli_fetch_assoc($result_chart)) {
    $data_array[] = $row_chart;
}
$chart = json_encode($data_array);



$sql_min_max = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
GROUP BY INSERT_date
) a
";

$result_min_max = mysqli_query($Conn, $sql_min_max);
$row_min_max = mysqli_fetch_assoc($result_min_max);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전국',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '5%', width: '92%'},
            hAxis: {
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

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_all'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<div id="lineChart_div_all" style="width: 100%; height: 200px;"></div>


<?php
$sql_chart_seoul = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '서울특별시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_seoul = mysqli_query($Conn, $sql_chart_seoul);

while ($row_chart_seoul = mysqli_fetch_assoc($result_chart_seoul)) {
    $data_array_seoul[] = $row_chart_seoul;
}
$chart_seoul = json_encode($data_array_seoul);



$sql_min_max_seoul = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '서울특별시'
GROUP BY INSERT_date
) a
";

$result_min_max_seoul = mysqli_query($Conn, $sql_min_max_seoul);
$row_min_max_seoul = mysqli_fetch_assoc($result_min_max_seoul);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_seoul; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '서울특별시',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_seoul['temp_min']?>, max: <?=$row_min_max_seoul['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_seoul'));
        lineChart.draw(data, lineChartOptions);
    }
</script>



<?php
$sql_chart_gyunggi = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '경기도'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_gyunggi = mysqli_query($Conn, $sql_chart_gyunggi);

while ($row_chart_gyunggi = mysqli_fetch_assoc($result_chart_gyunggi)) {
    $data_array_gyunggi[] = $row_chart_gyunggi;
}
$chart_gyunggi = json_encode($data_array_gyunggi);



$sql_min_max_gyunggi = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '경기도'
GROUP BY INSERT_date
) a
";

$result_min_max_gyunggi = mysqli_query($Conn, $sql_min_max_gyunggi);
$row_min_max_gyunggi = mysqli_fetch_assoc($result_min_max_gyunggi);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_gyunggi; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '경기도',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_gyunggi['temp_min']?>, max: <?=$row_min_max_gyunggi['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_gyunggi'));
        lineChart.draw(data, lineChartOptions);
    }
</script>




<div id="lineChart_div_seoul" style="width: 50%; height: 150px; float:left;"></div>
<div id="lineChart_div_gyunggi" style="width: 50%; height: 150px; float:right;"></div>




<?php
$sql_chart_busan = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '부산광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_busan = mysqli_query($Conn, $sql_chart_busan);

while ($row_chart_busan = mysqli_fetch_assoc($result_chart_busan)) {
    $data_array_busan[] = $row_chart_busan;
}
$chart_busan = json_encode($data_array_busan);



$sql_min_max_busan = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '부산광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_busan = mysqli_query($Conn, $sql_min_max_busan);
$row_min_max_busan = mysqli_fetch_assoc($result_min_max_busan);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_busan; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '부산광역시',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_busan['temp_min']?>, max: <?=$row_min_max_busan['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_busan'));
        lineChart.draw(data, lineChartOptions);
    }
</script>












<?php
$sql_chart_daegu = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '대구광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_daegu = mysqli_query($Conn, $sql_chart_daegu);

while ($row_chart_daegu = mysqli_fetch_assoc($result_chart_daegu)) {
    $data_array_daegu[] = $row_chart_daegu;
}
$chart_daegu = json_encode($data_array_daegu);



$sql_min_max_daegu = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '대구광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_daegu = mysqli_query($Conn, $sql_min_max_daegu);
$row_min_max_daegu = mysqli_fetch_assoc($result_min_max_daegu);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_daegu; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '대구광역시',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_daegu['temp_min']?>, max: <?=$row_min_max_daegu['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_daegu'));
        lineChart.draw(data, lineChartOptions);
    }
</script>



<div id="lineChart_div_busan" style="width: 50%; height: 150px; float:left;"></div>
<div id="lineChart_div_daegu" style="width: 50%; height: 150px; float:right;"></div>





<?php
$sql_chart_incheon = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '인천광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_incheon = mysqli_query($Conn, $sql_chart_incheon);

while ($row_chart_incheon = mysqli_fetch_assoc($result_chart_incheon)) {
    $data_array_incheon[] = $row_chart_incheon;
}
$chart_incheon = json_encode($data_array_incheon);



$sql_min_max_incheon = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '인천광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_incheon = mysqli_query($Conn, $sql_min_max_incheon);
$row_min_max_incheon = mysqli_fetch_assoc($result_min_max_incheon);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_incheon; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '인천광역시',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_incheon['temp_min']?>, max: <?=$row_min_max_incheon['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_incheon'));
        lineChart.draw(data, lineChartOptions);
    }
</script>













<?php
$sql_chart_gwangju = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '광주광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_gwangju = mysqli_query($Conn, $sql_chart_gwangju);

while ($row_chart_gwangju = mysqli_fetch_assoc($result_chart_gwangju)) {
    $data_array_gwangju[] = $row_chart_gwangju;
}
$chart_gwangju = json_encode($data_array_gwangju);



$sql_min_max_gwangju = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '광주광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_gwangju = mysqli_query($Conn, $sql_min_max_gwangju);
$row_min_max_gwangju = mysqli_fetch_assoc($result_min_max_gwangju);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_gwangju; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '광주광역시',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_gwangju['temp_min']?>, max: <?=$row_min_max_gwangju['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_gwangju'));
        lineChart.draw(data, lineChartOptions);
    }
</script>





<div id="lineChart_div_incheon" style="width: 50%; height: 150px; float:left;"></div>
<div id="lineChart_div_gwangju" style="width: 50%; height: 150px; float:right;"></div>




<?php
$sql_chart_daejun = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '대전광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_daejun = mysqli_query($Conn, $sql_chart_daejun);

while ($row_chart_daejun = mysqli_fetch_assoc($result_chart_daejun)) {
    $data_array_daejun[] = $row_chart_daejun;
}
$chart_daejun = json_encode($data_array_daejun);



$sql_min_max_daejun = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '대전광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_daejun = mysqli_query($Conn, $sql_min_max_daejun);
$row_min_max_daejun = mysqli_fetch_assoc($result_min_max_daejun);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_daejun; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '대전광역시',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_daejun['temp_min']?>, max: <?=$row_min_max_daejun['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_daejun'));
        lineChart.draw(data, lineChartOptions);
    }
</script>











<?php
$sql_chart_ulsan = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '울산광역시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_ulsan = mysqli_query($Conn, $sql_chart_ulsan);

while ($row_chart_ulsan = mysqli_fetch_assoc($result_chart_ulsan)) {
    $data_array_ulsan[] = $row_chart_ulsan;
}
$chart_ulsan = json_encode($data_array_ulsan);



$sql_min_max_ulsan = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '울산광역시'
GROUP BY INSERT_date
) a
";

$result_min_max_ulsan = mysqli_query($Conn, $sql_min_max_ulsan);
$row_min_max_ulsan = mysqli_fetch_assoc($result_min_max_ulsan);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_ulsan; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '울산광역시',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_ulsan['temp_min']?>, max: <?=$row_min_max_ulsan['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_ulsan'));
        lineChart.draw(data, lineChartOptions);
    }
</script>





<div id="lineChart_div_daejun" style="width: 50%; height: 150px; float:left;"></div>
<div id="lineChart_div_ulsan" style="width: 50%; height: 150px; float:right;"></div>




<?php
$sql_chart_sejong = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '세종특별자치시'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_sejong = mysqli_query($Conn, $sql_chart_sejong);

while ($row_chart_sejong = mysqli_fetch_assoc($result_chart_sejong)) {
    $data_array_sejong[] = $row_chart_sejong;
}
$chart_sejong = json_encode($data_array_sejong);



$sql_min_max_sejong = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '세종특별자치시'
GROUP BY INSERT_date
) a
";

$result_min_max_sejong = mysqli_query($Conn, $sql_min_max_sejong);
$row_min_max_sejong = mysqli_fetch_assoc($result_min_max_sejong);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_sejong; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '세종특별자치시',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_sejong['temp_min']?>, max: <?=$row_min_max_sejong['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_sejong'));
        lineChart.draw(data, lineChartOptions);
    }
</script>










<?php
$sql_chart_gangwon = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '강원도'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_gangwon = mysqli_query($Conn, $sql_chart_gangwon);

while ($row_chart_gangwon = mysqli_fetch_assoc($result_chart_gangwon)) {
    $data_array_gangwon[] = $row_chart_gangwon;
}
$chart_gangwon = json_encode($data_array_gangwon);



$sql_min_max_gangwon = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '강원도'
GROUP BY INSERT_date
) a
";

$result_min_max_gangwon = mysqli_query($Conn, $sql_min_max_gangwon);
$row_min_max_gangwon = mysqli_fetch_assoc($result_min_max_gangwon);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_gangwon; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '강원도',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_gangwon['temp_min']?>, max: <?=$row_min_max_gangwon['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_gangwon'));
        lineChart.draw(data, lineChartOptions);
    }
</script>




<div id="lineChart_div_sejong" style="width: 50%; height: 150px; float:left;"></div>
<div id="lineChart_div_gangwon" style="width: 50%; height: 150px; float:right;"></div>




<?php
$sql_chart_chungcheong = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name in ('충청북도','충청남도')
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_chungcheong = mysqli_query($Conn, $sql_chart_chungcheong);

while ($row_chart_chungcheong = mysqli_fetch_assoc($result_chart_chungcheong)) {
    $data_array_chungcheong[] = $row_chart_chungcheong;
}
$chart_chungcheong = json_encode($data_array_chungcheong);



$sql_min_max_chungcheong = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name in ('충청북도','충청남도')
GROUP BY INSERT_date
) a
";

$result_min_max_chungcheong = mysqli_query($Conn, $sql_min_max_chungcheong);
$row_min_max_chungcheong = mysqli_fetch_assoc($result_min_max_chungcheong);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_chungcheong; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '충청도',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_chungcheong['temp_min']?>, max: <?=$row_min_max_chungcheong['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_chungcheong'));
        lineChart.draw(data, lineChartOptions);
    }
</script>










<?php
$sql_chart_junla = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name in ('전라북도','전라남도')
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_junla = mysqli_query($Conn, $sql_chart_junla);

while ($row_chart_junla = mysqli_fetch_assoc($result_chart_junla)) {
    $data_array_junla[] = $row_chart_junla;
}
$chart_junla = json_encode($data_array_junla);



$sql_min_max_junla = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name in ('전라북도','전라남도')
GROUP BY INSERT_date
) a
";

$result_min_max_junla = mysqli_query($Conn, $sql_min_max_junla);
$row_min_max_junla = mysqli_fetch_assoc($result_min_max_junla);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_junla; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '전라도',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_junla['temp_min']?>, max: <?=$row_min_max_junla['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_junla'));
        lineChart.draw(data, lineChartOptions);
    }
</script>



<div id="lineChart_div_chungcheong" style="width: 50%; height: 150px; float:left;"></div>
<div id="lineChart_div_junla" style="width: 50%; height: 150px; float:right;"></div>



<?php
$sql_chart_gyengsang = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name in ('경상북도','경상남도')
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_gyengsang = mysqli_query($Conn, $sql_chart_gyengsang);

while ($row_chart_gyengsang = mysqli_fetch_assoc($result_chart_gyengsang)) {
    $data_array_gyengsang[] = $row_chart_gyengsang;
}
$chart_gyengsang = json_encode($data_array_gyengsang);



$sql_min_max_gyengsang = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name in ('경상북도','경상남도')
GROUP BY INSERT_date
) a
";

$result_min_max_gyengsang = mysqli_query($Conn, $sql_min_max_gyengsang);
$row_min_max_gyengsang = mysqli_fetch_assoc($result_min_max_gyengsang);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_gyengsang; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '경상도',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_gyengsang['temp_min']?>, max: <?=$row_min_max_gyengsang['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_gyengsang'));
        lineChart.draw(data, lineChartOptions);
    }
</script>












<?php
$sql_chart_jeju = "
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as cnt
FROM avg_meme_price_apart_85
where area_main_name = '제주특별자치도'
GROUP BY INSERT_date
ORDER BY insert_Date
";

$result_chart_jeju = mysqli_query($Conn, $sql_chart_jeju);

while ($row_chart_jeju = mysqli_fetch_assoc($result_chart_jeju)) {
    $data_array_jeju[] = $row_chart_jeju;
}
$chart_jeju = json_encode($data_array_jeju);



$sql_min_max_jeju = "
SELECT MAX(avg_price)+0.01 AS temp_max, MIN(avg_price)-0.01 AS temp_min
FROM
(
SELECT 
insert_date,
ROUND(SUM(total_price) / SUM(total_cnt),4) as avg_price
FROM avg_meme_price_apart_85
where area_main_name = '제주특별자치도'
GROUP BY INSERT_date
) a
";

$result_min_max_jeju = mysqli_query($Conn, $sql_min_max_jeju);
$row_min_max_jeju = mysqli_fetch_assoc($result_min_max_jeju);


?>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart_jeju; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '국평평균가격'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.insert_date,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.cnt)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '제주특별자치도',
            titleTextStyle: {
              fontSize: 25, 
              bold: true,    
            },
            legend: 'none',
            chartArea: {left: '10%', width: '85%'},
            hAxis: {
                showTextEvery: 25    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 , lineWidth: 4}
            },
            vAxes: {
                0: {
                    viewWindow: { min: <?=$row_min_max_jeju['temp_min']?>, max: <?=$row_min_max_jeju['temp_max']?> }
                }
            },
            interpolateNulls : true
            //,
            //curveType: 'function',
            //legend: { position: 'bottom' }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('lineChart_div_jeju'));
        lineChart.draw(data, lineChartOptions);
    }
</script>


<div id="lineChart_div_gyengsang" style="width: 50%; height: 150px; float:left;"></div>
<div id="lineChart_div_jeju" style="width: 50%; height: 150px; float:right;"></div>




<?php
//여기는 그래프 관련
$sql_chart0 = "
    SELECT
    concat(year,'년 ',month,'월') as yearmonth
    ,sum(cnt)  AS cnt
    FROM molit_trend
    where type = '매매'
    group by year, month
    order by cast(year as unsigned), cast(month as unsigned)
    ";


$sql_min_max0 = "
    select max(cnt)+100 as temp_max, min(cnt)-100 as temp_min
    from
    (
    SELECT year, month, sum(cnt) as cnt
        FROM molit_trend
        where type = '매매'
        group by year, month
    ) as a
";



$result_chart0 = mysqli_query($Conn, $sql_chart0);

while ($row_chart0 = mysqli_fetch_assoc($result_chart0)) {
    $data_array0[] = $row_chart0;
}
$chart0 = json_encode($data_array0);

$result_min_max0 = mysqli_query($Conn, $sql_min_max0);
$row_min_max0 = mysqli_fetch_assoc($result_min_max0);

?>


<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<h2>&nbsp;</h2>


<h1>5. 전국 년월별 거래건수(단위: 건, 2017년 이후)</h1>

<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart0; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','전국 거래량'];
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
            chartArea: {left: '10%', width: '85%', height:'65%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 3    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
                ,slantedText: true
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max0['temp_max']?>}
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div0'));
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



<center><div id="lineChart_div0" style="width: 100%; height: 360px"></div></center>




<?php
//여기는 그래프 관련
$sql_chart01 = "
    SELECT
    concat(year,'년 ',month,'월') as yearmonth
    ,sum(cnt)  AS cnt
    FROM molit_trend
    where type = '매매'
    and area_main_name = '서울특별시'
    group by year, month
    order by cast(year as unsigned), cast(month as unsigned)
    ";


$sql_min_max01 = "
    select max(cnt)+100 as temp_max, min(cnt)-100 as temp_min
    from
    (
    SELECT year, month, sum(cnt) as cnt
        FROM molit_trend
        where type = '매매'
        and area_main_name = '서울특별시'
        group by year, month
    ) as a
";



$result_chart01 = mysqli_query($Conn, $sql_chart01);

while ($row_chart01 = mysqli_fetch_assoc($result_chart01)) {
    $data_array01[] = $row_chart01;
}
$chart01 = json_encode($data_array01);

$result_min_max01 = mysqli_query($Conn, $sql_min_max01);
$row_min_max01 = mysqli_fetch_assoc($result_min_max01);

?>


<!--<a style="font-size:15px; float:right;" href='./info.php'>(텔레그램 매일 알림받기)</a>-->
<br>

<h1>6. 서울특별시 년월별 거래건수(단위: 건, 2017년 이후)</h1>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart01; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)','서울특별시 거래량'];
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
            chartArea: {left: '10%', width: '85%', height:'65%'},
            seriesType: "bars",
            series: {0: {type: 'bars', targetAxisIndex: 0  , color: '#515a5a'}}
            ,hAxis: {
                showTextEvery: 3    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
                ,slantedText: true
            },
            annotations: {
                   textStyle: {
                     fontSize: 35,
                     opacity: 1.8
                   }
            },
            vAxes: {
                0: {
                    viewWindow: { min: 0, max: <?=$row_min_max01['temp_max']?>}
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div01'));
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



<center><div id="lineChart_div01" style="width: 100%; height: 350px"></div></center>

<br>




<?php


$sql_chart4 = "
select * FROM
(
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
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
from NoBunYang
group by yyyymm
order by yyyymm desc
limit 48
) aa
order by aa.yyyymm
";

$sql_min_max4 = "
select min(temp) as temp_min, max(temp) as temp_max
FROM(
select yyyymm as dt, sum(cast(cnt as unsigned)) as temp
from NoBunYang
group by yyyymm
order by yyyymm desc
limit 48
) aa
";


$sql4 = "
select
concat(substr(yyyymm,1,4),'/',substr(yyyymm,5,2)) as yyyymm,
sum(cast(cnt as unsigned)) as cnt_all,
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
from NoBunYang
group by yyyymm
order by yyyymm desc
limit 6
    ";


$result_chart4 = mysqli_query($Conn, $sql_chart4);

while ($row_chart4 = mysqli_fetch_assoc($result_chart4)) {
    $data_array4[] = $row_chart4;
}
$chart4 = json_encode($data_array4);

$result_min_max4 = mysqli_query($Conn, $sql_min_max4);
$row_min_max4 = mysqli_fetch_assoc($result_min_max4);

$rs4 = mysqli_query($Conn, $sql4);

while ( $row4 = mysqli_fetch_assoc($rs4) ) {
    $rows4[] = $row4;
}
?>

<h1>7. 전국 아파트 미분양 그래프</h1>
<span style="font-size:20px;">국토부 제공 자료를 바탕으로 만들어진 데이터 입니다.</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart4; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '서울', '부산', '대구', '인천', '광주', '대전', '울산', '경기', '강원', '충북', '충남', '전북', '전남', '경북', '경남', '제주', '세종'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
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
            title: '전국 미분양 추이',
            chartArea: {left: '7%', width: '91%', height:'70%'},
            seriesType: "bars",
            isStacked: true,
            hAxis: {
                showTextEvery: 2    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
                ,slantedText: true
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
                    viewWindow: { min: 0, max: <?=$row_min_max4['temp_max']?> }
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div4'));
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


<center><div id="lineChart_div4" style="width: 100%; height: 400px"></div></center>

<table>
    <thead>
    <tr>
        <th style="font-size: 15px;">조사년월</th>
        <th style="font-size: 15px;">전국</th>
        <th style="font-size: 13px;">서울</th>
        <th style="font-size: 13px;">부산</th>
        <th style="font-size: 13px;">대구</th>
        <th style="font-size: 13px;">인천</th>
        <th style="font-size: 13px;">광주</th>
        <th style="font-size: 13px;">대전</th>
        <th style="font-size: 13px;">울산</th>
        <th style="font-size: 13px;">경기</th>
        <th style="font-size: 13px;">강원</th>
        <th style="font-size: 13px;">충북</th>
        <th style="font-size: 13px;">충남</th>
        <th style="font-size: 13px;">전북</th>
        <th style="font-size: 13px;">전남</th>
        <th style="font-size: 13px;">경북</th>
        <th style="font-size: 13px;">경남</th>
        <th style="font-size: 13px;">제주</th>
        <th style="font-size: 13px;">세종</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows4 as $row4) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row4['yyyymm']?></b></td>
          <td style="font-size: 15px;"><b><?=$row4['cnt_all']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt1']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt2']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt3']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt4']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt5']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt6']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt7']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt8']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt9']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt10']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt11']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt12']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt13']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt14']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt15']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt16']?></b></td>
          <td style="font-size: 13px;"><b><?=$row4['cnt17']?></b></td>

      </tr>
      <?php } ?>
    </tbody>
</table>
<br>







<?php


$sql_chart5 = "
select
concat(substr(yearmonth,1,4),'/',substr(yearmonth,6,2)) as yyyymm,
IFNULL(CAST(MAX(case when area = '서울특별시' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산광역시' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구광역시' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천광역시' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주광역시' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전광역시' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산광역시' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기도' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원도' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충청북도' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충청남도' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전라북도' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전라남도' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경상북도' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경상남도' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주특별자치도' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종특별자치시' then cnt end) as DECIMAL(10,0)),0) as cnt17
from
(
select 
area,
yearmonth,
cnt
from
(
SELECT 
REPLACE(SUBSTRING_INDEX(LOCATION, ' ', 1),'강원특별자치도','강원도') AS area, 
left(due_date,7) as yearmonth,
count(1) as cnt
FROM Auction_Apart_Info
where auction_result is not null
group by REPLACE(SUBSTRING_INDEX(LOCATION, ' ', 1),'강원특별자치도','강원도'), left(due_date,7)
) as a
) as aa
group by concat(substr(yearmonth,1,4),'/',substr(yearmonth,6,2)) 
order by yyyymm
";

$sql_min_max5 = "
select min(all_cnt) as temp_min, max(all_cnt) as temp_max
from
(
SELECT 
left(due_date,7) as yearmonth,
count(1) as all_cnt
FROM Auction_Apart_Info
where auction_result is not null
group by left(due_date,7)
) as a
";


$sql5 = "
select
concat(substr(yearmonth,1,4),'/',substr(yearmonth,6,2)) as yyyymm,
sum(cnt) as cnt_all,
IFNULL(CAST(MAX(case when area = '서울특별시' then cnt end) as DECIMAL(10,0)),0) as cnt1,
IFNULL(CAST(MAX(case when area = '부산광역시' then cnt end) as DECIMAL(10,0)),0) as cnt2,
IFNULL(CAST(MAX(case when area = '대구광역시' then cnt end) as DECIMAL(10,0)),0) as cnt3,
IFNULL(CAST(MAX(case when area = '인천광역시' then cnt end) as DECIMAL(10,0)),0) as cnt4,
IFNULL(CAST(MAX(case when area = '광주광역시' then cnt end) as DECIMAL(10,0)),0) as cnt5,
IFNULL(CAST(MAX(case when area = '대전광역시' then cnt end) as DECIMAL(10,0)),0) as cnt6,
IFNULL(CAST(MAX(case when area = '울산광역시' then cnt end) as DECIMAL(10,0)),0) as cnt7,
IFNULL(CAST(MAX(case when area = '경기도' then cnt end) as DECIMAL(10,0)),0) as cnt8,
IFNULL(CAST(MAX(case when area = '강원도' then cnt end) as DECIMAL(10,0)),0) as cnt9,
IFNULL(CAST(MAX(case when area = '충청북도' then cnt end) as DECIMAL(10,0)),0) as cnt10,
IFNULL(CAST(MAX(case when area = '충청남도' then cnt end) as DECIMAL(10,0)),0) as cnt11,
IFNULL(CAST(MAX(case when area = '전라북도' then cnt end) as DECIMAL(10,0)),0) as cnt12,
IFNULL(CAST(MAX(case when area = '전라남도' then cnt end) as DECIMAL(10,0)),0) as cnt13,
IFNULL(CAST(MAX(case when area = '경상북도' then cnt end) as DECIMAL(10,0)),0) as cnt14,
IFNULL(CAST(MAX(case when area = '경상남도' then cnt end) as DECIMAL(10,0)),0) as cnt15,
IFNULL(CAST(MAX(case when area = '제주특별자치도' then cnt end) as DECIMAL(10,0)),0) as cnt16,
IFNULL(CAST(MAX(case when area = '세종특별자치시' then cnt end) as DECIMAL(10,0)),0) as cnt17
from
(
select 
area,
yearmonth,
cnt
from
(
SELECT 
REPLACE(SUBSTRING_INDEX(LOCATION, ' ', 1),'강원특별자치도','강원도') AS area, 
left(due_date,7) as yearmonth,
count(1) as cnt
FROM Auction_Apart_Info
where auction_result is not null
group by REPLACE(SUBSTRING_INDEX(LOCATION, ' ', 1),'강원특별자치도','강원도'), left(due_date,7)
) as a
) as aa
group by concat(substr(yearmonth,1,4),'/',substr(yearmonth,6,2)) 
order by yyyymm desc
";


$result_chart5 = mysqli_query($Conn, $sql_chart5);

while ($row_chart5 = mysqli_fetch_assoc($result_chart5)) {
    $data_array5[] = $row_chart5;
}
$chart5 = json_encode($data_array5);

$result_min_max5 = mysqli_query($Conn, $sql_min_max5);
$row_min_max5 = mysqli_fetch_assoc($result_min_max5);

$rs5 = mysqli_query($Conn, $sql5);

while ( $row5 = mysqli_fetch_assoc($rs5) ) {
    $rows5[] = $row5;
}
?>

<h1>8. 전국 아파트 경매 그래프</h1>
<span style="font-size:20px;">법원 경매정보 제공 자료를 바탕으로 만들어진 데이터 입니다. (마지막월은 현시점 데이터입니다.)</span>
<br>
<br>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart5; ?>;

        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '서울', '부산', '대구', '인천', '광주', '대전', '울산', '경기', '강원', '충북', '충남', '전북', '전남', '경북', '경남', '제주', '세종'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.yyyymm,  // 너무 긴 날짜 및 시간을 짧게 추출
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
            title: '전국 경매건수 추이',
            chartArea: {left: '7%', width: '91%', height:'70%'},
            seriesType: "bars",
            isStacked: true,
            hAxis: {
                showTextEvery: 1    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
                ,slantedText: true
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
                    viewWindow: { min: 0, max: <?=$row_min_max5['temp_max']?> }
                }
            },
            interpolateNulls : true,
            //,
            //curveType: 'function',
            legend: { position: 'top' , maxLines: 3}
        };

        var lineChart = new google.visualization.ComboChart(document.getElementById('lineChart_div5'));
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


<center><div id="lineChart_div5" style="width: 100%; height: 400px"></div></center>

<table>
    <thead>
    <tr>
        <th style="font-size: 15px;">조사년월</th>
        <th style="font-size: 15px;">전국</th>
        <th style="font-size: 13px;">서울</th>
        <th style="font-size: 13px;">부산</th>
        <th style="font-size: 13px;">대구</th>
        <th style="font-size: 13px;">인천</th>
        <th style="font-size: 13px;">광주</th>
        <th style="font-size: 13px;">대전</th>
        <th style="font-size: 13px;">울산</th>
        <th style="font-size: 13px;">경기</th>
        <th style="font-size: 13px;">강원</th>
        <th style="font-size: 13px;">충북</th>
        <th style="font-size: 13px;">충남</th>
        <th style="font-size: 13px;">전북</th>
        <th style="font-size: 13px;">전남</th>
        <th style="font-size: 13px;">경북</th>
        <th style="font-size: 13px;">경남</th>
        <th style="font-size: 13px;">제주</th>
        <th style="font-size: 13px;">세종</th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($rows5 as $row5) { ?>
      <tr>
          <td style="font-size: 15px;"><b><?=$row5['yyyymm']?></b></td>
          <td style="font-size: 15px;"><b><?=$row5['cnt_all']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt1']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt2']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt3']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt4']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt5']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt6']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt7']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt8']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt9']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt10']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt11']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt12']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt13']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt14']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt15']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt16']?></b></td>
          <td style="font-size: 13px;"><b><?=$row5['cnt17']?></b></td>

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



<center><span style="font-size:20px;"><b>Copyright ©2022 오늘집값 - TodayHousePrice.com, Inc. All rights reserved</b></span></center>

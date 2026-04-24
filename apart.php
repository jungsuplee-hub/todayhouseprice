<?php
include_once "./top_page.php";
?>
<?php

$apart_name = $_REQUEST["apart_name"];
$size = ROUND($_REQUEST["size"]);
$dong = $_REQUEST["dong"];
$area_main_name = $_REQUEST["area_main_name"];
$all_area = $_REQUEST["all_area"];



if( $all_area == "Y"){
  $size_text = "";
}else{
  $size_text = "and ROUND(CAST(size as DECIMAL(10,5))) = '$size'";
}




$sql = "
    SELECT concat(year,'/',month,'/',day) as yearmonthday, apart_name, size, stair, price, type, cancel_yn, cancel_date
    FROM molit_info_all
    where area_main_name = '$area_main_name'
    and apart_name = '$apart_name'
    and dong = '$dong'
    $size_text
    order by date_format(concat(year,'/',month,'/',day),'%Y-%m-%d') desc
    ";

$sql_doro = "
    SELECT build_year, doro, doro_code1, doro_code2, jibun, latitude, longitude
    FROM apart_dong
    where area_main_name = '$area_main_name'
    and apart_name = replace('$apart_name','(임대)','')
    and dong = '$dong'
    ";

$sql_apart_info = "
  SELECT
   b.kaptDongCnt
  ,b.hoCnt
  ,b.kaptBcompany
  ,b.codeHeatNm
  ,b.KaptTel
  ,b.codeHallNm
  ,b.codeGarbage
  ,b.kaptdWtimebus
  ,b.subwayLine
  ,b.subwayStation
  ,b.kaptdWtimesub
  ,b.welfareFacility
  ,b.convenientFacility
  ,b.educationFacility
  ,(SELECT CONCAT(GROUP_CONCAT(ptpNM SEPARATOR '㎡, '),'㎡') AS ptpNM
  FROM naver_info_detail
  where hscpNo = a.hscpNo
  ) AS all_size
  FROM apart_dong a, TotalAptList b
  WHERE a.apart_code = b.kaptCode
  AND a.area_main_name = '$area_main_name'
  AND a.dong = '$dong'
  AND a.apart_name = '$apart_name'
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

$rs = mysqli_query($Conn, $sql);
$rs_count = mysqli_num_rows($rs);
while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}


$rs_doro = mysqli_query($Conn, $sql_doro);
$row_doro = mysqli_fetch_assoc($rs_doro);

$build_year = $row_doro['build_year'];
$doro = $row_doro['doro'];
$doro_code1 = $row_doro['doro_code1'];
$doro_code2 = $row_doro['doro_code2'];
$jibun = $row_doro['jibun'];
$latitude = $row_doro['latitude'];
$longitude = $row_doro['longitude'];


$rs_apart_info = mysqli_query($Conn, $sql_apart_info);
$row_apart_info = mysqli_fetch_assoc($rs_apart_info);
$apart_info_count = mysqli_num_rows($rs_apart_info);

//여기는 그래프 관련
$sql_chart = "SELECT STR_TO_DATE(CONCAT(YEAR,LPAD(MONTH,'2','0'),LPAD(DAY,'2','0')), '%Y%m%d') AS dt, CAST(price AS DECIMAL(10,6)) AS temp  from molit_info_all  WHERE area_main_name = '$area_main_name'  and apart_name = '$apart_name'  and dong = '$dong' and ROUND(CAST(size as DECIMAL(10,5))) = '$size'  ORDER BY STR_TO_DATE(CONCAT(YEAR,LPAD(MONTH,'2','0'),LPAD(DAY,'2','0')), '%Y%m%d')";

$sql_min_max = "SELECT ROUND(count(1)/10) as cnt, ROUND(MAX(CAST(price AS DECIMAL(10,5)))+2) AS temp_max, ROUND(MIN(CAST(price AS DECIMAL(10,5)))-2) AS temp_min  from molit_info_all  WHERE area_main_name = '$area_main_name'  and apart_name = '$apart_name' and dong = '$dong' and ROUND(CAST(size as DECIMAL(10,5))) = '$size'";

$result_chart = mysqli_query($Conn, $sql_chart);

if (mysqli_num_rows($result_chart) > 0) {
    while ($row_chart = mysqli_fetch_assoc($result_chart)) {
        $data_array[] = $row_chart;
    }
    $chart = json_encode($data_array);

    $result_min_max = mysqli_query($Conn, $sql_min_max);
    $row_min_max = mysqli_fetch_assoc($result_min_max);

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



<span style="font-size:25px;"><b><?php echo $area_main_name; ?> <?php echo $dong; ?> <?php echo $apart_name; ?>(건축년도 : <?php echo $build_year; ?>년)</b></span>
  <?php

  if($userid && $all_area != 'Y'){

    $sql_favorite = "
    select count(1) cnt from molit_favorite where userid = '$userid' and area_main_name = '$area_main_name' and dong = '$dong' and apart_name = '$apart_name' and size = '$size';
    ";
    $rs_favorite = mysqli_query($Conn, $sql_favorite);
    $row_favorite = mysqli_fetch_assoc($rs_favorite);

    if ($row_favorite['cnt']>0){
    ?>
      <img style="vertical-align: middle;" width="50", height="50" src="./hearts_full.png" onclick="delete_favorite();" >
<?php } else{?>
      <img style="vertical-align: middle;" width="50", height="50" src="./hearts_empty.png" onclick="add_favorite();" > <span style="font-size:25px;"><b><--클릭을 하여 즐겨찾기를 추가</b></span>
<?php }} elseif(!$userid){ ?>
      <img style="vertical-align: middle;" width="50", height="50" src="./hearts_empty.png" onclick="need_login();" > <span style="font-size:25px;"><b><--클릭을 하여 즐겨찾기를 추가</b></span>
<?php }?>
  <br>
<span style="font-size:25px;"><b>전용면적 : <?php if( $all_area=="Y") { echo "전체";} else {echo $size; echo "㎡";}?>, 실거래 리스트(2017년 이후)</b></span>

<script>
  function delete_favorite()
  {
    if (confirm("즐겨찾기에서 삭제하시겠습니까?")) {
        <?php echo "window.location.replace('./apart_update_favorite.php?userid=$userid&area_main_name=$area_main_name&apart_name=$apart_name&size=$size&dong=$dong&all_area=$all_area&add=N&rent=N');"?>
    }
  }
  function add_favorite()
  {
    if (confirm("즐겨찾기로 등록하시겠습니까?")) {
        <?php echo "window.location.replace('./apart_update_favorite.php?userid=$userid&area_main_name=$area_main_name&apart_name=$apart_name&size=$size&dong=$dong&all_area=$all_area&add=Y&rent=N');"?>
    }
  }
  function need_login()
  {
    alert("로그인후 사용해 주세요.");
  }
</script>

<?php if($apart_info_count>0) { ?>
<br>
<table>
    <thead>
    <tr>
        <th style="background-color:rgba(216, 216, 216, 1); color:black; font-size: 15px; padding-bottom:5px; padding-top:5px;">동수(세대수)</th>
        <th style="background-color:rgba(216, 216, 216, 1); color:black;  font-size: 15px; padding-bottom:5px; padding-top:5px;">건설사</th>
        <th style="background-color:rgba(216, 216, 216, 1); color:black;  font-size: 15px; padding-bottom:5px; padding-top:5px;">난방</th>
        <th style="background-color:rgba(216, 216, 216, 1); color:black;  font-size: 15px; padding-bottom:5px; padding-top:5px;">관리사무소</th>
        <th style="background-color:rgba(216, 216, 216, 1); color:black;  font-size: 15px; padding-bottom:5px; padding-top:5px;">현관구조</th>
        <th style="background-color:rgba(216, 216, 216, 1); color:black;  font-size: 15px; padding-bottom:5px; padding-top:5px;">음식물처리방식</th>
    </tr>
    </thead>
    <tbody>
      <tr>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;">총 <?=$row_apart_info['kaptDongCnt']?>동(<?=$row_apart_info['hoCnt']?>세대)</td>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['kaptBcompany']?></td>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['codeHeatNm']?></td>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['KaptTel']?></td>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['codeHallNm']?></td>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['codeGarbage']?></td>
      </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <th style="background-color:rgba(216, 216, 216, 1); color:black; font-size: 15px; padding-bottom:5px; padding-top:5px;">버스정류장 거리</th>
        <th style="background-color:rgba(216, 216, 216, 1); color:black;  font-size: 15px; padding-bottom:5px; padding-top:5px;">주변지하철 호선</th>
        <th style="background-color:rgba(216, 216, 216, 1); color:black;  font-size: 15px; padding-bottom:5px; padding-top:5px;">주변지하철역</th>
        <th style="background-color:rgba(216, 216, 216, 1); color:black;  font-size: 15px; padding-bottom:5px; padding-top:5px;">지하철 거리</th>
        <th style="background-color:rgba(216, 216, 216, 1); color:black;  font-size: 15px; padding-bottom:5px; padding-top:5px;">공급면적전체</th>
    </tr>
    </thead>
    <tbody>
      <tr>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['kaptdWtimebus']?></td>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['subwayLine']?></td>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['subwayStation']?></td>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['kaptdWtimesub']?></td>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['all_size']?></td>
      </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <th style="background-color:rgba(216, 216, 216, 1); color:black; font-size: 15px; padding-bottom:5px; padding-top:5px;">단지내 편의시설</th>
    </tr>
    </thead>
    <tbody>
      <tr>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['welfareFacility']?></td>
      </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <th style="background-color:rgba(216, 216, 216, 1); color:black; font-size: 15px; padding-bottom:5px; padding-top:5px;">주변편의시설</th>
    </tr>
    </thead>
    <tbody>
      <tr>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['convenientFacility']?></td>
      </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <th style="background-color:rgba(216, 216, 216, 1); color:black; font-size: 15px; padding-bottom:5px; padding-top:5px;">주변 학군</th>
    </tr>
    </thead>
    <tbody>
      <tr>
          <td style="font-size: 15px; padding-bottom:5px; padding-top:5px;"><?=$row_apart_info['educationFacility']?></td>
      </tr>
    </tbody>
</table>
<?php  } ?>

<h1>
<a href='./apart.php?area_main_name=<?php echo $area_main_name; ?>&apart_name=<?php echo $apart_name; ?>&size=<?php echo $size; ?>&dong=<?php echo $dong; ?>&all_area=Y'>전체면적보기</a>
<a style="float:right;" href='./apart_rent.php?area_main_name=<?php echo $area_main_name; ?>&apart_name=<?php echo $apart_name; ?>&size=<?php echo $size; ?>&dong=<?php echo $dong; ?>&all_area=<?php echo $all_area; ?>'>해당 아파트 전/월세 정보 보기</a>
</h1>
<h2>
<a target="_blank" href='https://m.land.naver.com/search/result/<?php echo str_replace(' ','%20',$dong); ?><?php echo str_replace(' ','%20',$apart_name); ?>아파트'>네이버 부동산 바로가기</a>
<a style="float:right;" target="_blank" href='https://hogangnono.com/search?q=<?php echo str_replace(' ','%20',$dong); ?> <?php echo str_replace(' ','%20', str_replace($dong,'',$apart_name)); ?>아파트'>호갱노노 바로가기</a>
</h2>
<span>네이버와 호갱노노 연결은 주소 및 명칭을 기반으로 하기 때문에 정확하지 않을 수 있습니다.</span>


<?php 

if($latitude==null){ ?>
  <center>
    <iframe id="inlineFrameExample"
        title="Inline Frame Example"
        width="80%"
        height="400"
        src="https://m.map.kakao.com/actions/searchView?q=<?php echo str_replace(' ','%20',$area_main_name); ?>%20<?php echo str_replace(' ','%20',$dong); ?>%20<?php echo str_replace(' ','%20',$apart_name); ?>&wxEnc=LQMSQP&wyEnc=QNLURRS&lvl=4#!/all/map/place">
    </iframe>
  </center>
<?php  }else{ ?>
  
  <center>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=ixgiefa17p&amp;submodules=panorama,geocoder,drawing,visualization"></script>
    
    <div id="wrap" class="section">
        <div id="map" style="width:80%;height:400px;"></div>
        <code id="snippet" class="snippet"></code>
    </div>
    <script id="code">
    var map = new naver.maps.Map('map', {
        center: new naver.maps.LatLng(<?=$latitude?>, <?=$longitude?>),
        zoom: 17
    });
    
    var marker = new naver.maps.Marker({
        position: new naver.maps.LatLng(<?=$latitude?>, <?=$longitude?>),
        map: map
    });
    </script>
  </center>
<?php } ?>


<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.load('current', { packages: ['table'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var chart_array = <?php echo $chart; ?>;
        //console.log(JSON.stringify(chart_array))
        var header = ['Date&Time(MM-DD HH:MM)', '가격(억)'];
        var row = "";
        var rows = new Array();
        jQuery.each(chart_array, function(index, item) {
            row = [
                item.dt,  // 너무 긴 날짜 및 시간을 짧게 추출
                Number(item.temp)
            ];
            rows.push(row);
        });

        var jsonData = [header].concat(rows);
        var data = new google.visualization.arrayToDataTable(jsonData);

        var lineChartOptions = {
            title: '가격추이 / 단위(억)',
            legend: 'none',
            chartArea: {left: '4%', width: '93%'},
            hAxis: {
                title: 'Time',
                showTextEvery: <?=$row_min_max['cnt']?>    // X축 레이블이 너무 많아 보기 힘드므로 4개마다 하나씩 표시
            },
            series: {
                0: { targetAxisIndex: 0 }
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




<center><div id="lineChart_div" style="width: 80%; height: 300px"></div></center>

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
        <!--<th style="font-size: 20px;">아파트명</th>-->
        <th style="font-size: 20px;">거래일자</th>
        <th style="font-size: 20px;">전용면적</th>
        <th style="font-size: 20px;">층</th>
        <th style="font-size: 20px;">가격</th>
        <th style="font-size: 20px;">거래유형</th>
    </tr>
    </thead>
    <tbody>
      <?php $add_count = 0; foreach ($rows as $row) { if($add_count!=0 && fmod($add_count, 15)==0){echo '<tr><td colspan="6"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871" crossorigin="anonymous"></script> <ins class="adsbygoogle" style="display:block" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-2265060002718871" data-ad-slot="3474043280"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script></td></tr>';} $add_count = $add_count + 1; ?>
      <tr>
          <!--<td style="font-size: 20px;"><b><?php if($row['cancel_yn']=='O'){echo '<del>';}?><?=$row['apart_name']?><?php if($row['cancel_yn']=='O'){echo '</del>';}?></b></td>-->
          <td style="font-size: 20px;"><b><?php if($row['cancel_yn']=='O'){echo '<del>';}?><?=$row['yearmonthday']?><?php if($row['cancel_yn']=='O'){echo '</del>';}?></b></td>
          <td style="font-size: 20px;"><b><?php if($row['cancel_yn']=='O'){echo '<del>';}?><?=$row['size']?>㎡<?php if($row['cancel_yn']=='O'){echo '</del>';}?></b></td>
          <td style="font-size: 20px;"><b><?php if($row['cancel_yn']=='O'){echo '<del>';}?><?=$row['stair']?>층<?php if($row['cancel_yn']=='O'){echo '</del>';}?></b></td>
          <td style="font-size: 20px;"><b><?php if($row['cancel_yn']=='O'){echo '<del>';}?><?=$row['price']?>억<?php if($row['cancel_yn']=='O'){echo '</del>';}?></b></td>
          <td style="font-size: 20px;"><b><?php if($row['cancel_yn']=='O'){echo '<del>';}?><?=$row['type']?><?php if($row['cancel_yn']=='O'){echo '</del><span style="color:red;"><br>거래취소<br>';echo $row['cancel_date']; echo'</span>';}?></b></td>
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

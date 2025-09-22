<!DOCTYPE html>
<html>
<head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EF60WVGV7F"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'G-EF60WVGV7F');
gtag('config', 'AW-945296853');
gtag('event', 'conversion', {'send_to': 'AW-945296853/nBcaCMiZnYcYENWr4MID'});
</script>
<link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, shrink-to-fit=no">
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=ixgiefa17p"></script>
<script type="text/javascript" src="./js/MarkerClustering.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link rel='stylesheet' type='text/css' href='./todayhouseprice_map.css'>
<meta charset="EUC-KR">
<title>오늘집값 - 실거래 지도</title>
<meta name='description' content='아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.'>
<meta property='og:title' content='오늘집값 - 실거래 지도'>
<meta property='og:description' content='오늘집값 - 금일 등록된 아파트 신규 매매/전세 정보를 조회할 수 있습니다.'>

<style>
    .jb-wrap {
        width: 80%;
        position: relative;
    }
    .jb-wrap img {
        vertical-align: middle;
        opacity: 70%;
    }
    .jb-text {
        width:55px;
        font-size: 10px;
        padding: 1px 1px;
        text-align: center;
        position: absolute;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        top: 50%;
        left: 50%;
        transform: translate( -40%, -87% );
    }
    .jb-text_sub {
        width:55px;
        font-size: 10px;
        padding: 1px 1px;
        text-align: center;
        position: absolute;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        top: 50%;
        left: 50%;
        transform: translate( -42%, -20% );
    }
    @FONT-FACE {
    font-family:'nanumpen';
    src:url("NanumPen.ttf");
    }
</style>
</head>


<?php


/////////////////////세션연결//////////////////////////
session_start();
//session_start();
$is_count = false;
$userid = $_SESSION["userid"];
if (!isset($_COOKIE["todayhouseprice"])) {
    setcookie("todayhouseprice", "count", time() + 60 * 60 * 24);
    $is_count = true;
}
/////////////////////광고사용여부//////////////////////////
$advertize = "1";
/////////////////////사용기기체크//////////////////////////
$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";
if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
	$isMobile = "Y";
}else{
	$isMobile = "N";
}
/////////////////////디비연결//////////////////////////
$Conn = mysqli_connect("localhost", "root", "e0425820", "jsdb", 33306);
mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");
/////////////////////금일 지수//////////////////////////
$rs_today = mysqli_query($Conn, "select dallor, gumri_usa, gumri_korea, kospi, kosdaq, substr(update_date,1,19) as update_date from today_index");
$row_today = mysqli_fetch_assoc($rs_today);


$today = date("Y-m-d");


/////////////////////조회수//////////////////////////
if ($is_count) {
  $rs = mysqli_query($Conn, "select count(1) as cnt from molit_visit_count where ymd = '$today' and count_type = 'today';");
  $row = mysqli_fetch_assoc($rs);
  if($row['cnt']==0) {
    mysqli_query($Conn, "insert into molit_visit_count (ymd, count, count_type) values('$today',1,'today');");
  }else{
    mysqli_query($Conn, "update molit_visit_count set count = count + 1 where ymd = '$today' and count_type = 'today';");
  }
}



$this_site_for_login = str_replace('.php','',basename( $_SERVER[ "PHP_SELF" ] ));
?>

<?php


$before1Day = date("Y-m-d", strtotime($today." -1 day"));
$before2Day = date("Y-m-d", strtotime($today." -2 day"));
$before3Day = date("Y-m-d", strtotime($today." -3 day"));
$before4Day = date("Y-m-d", strtotime($today." -4 day"));


$sql = "
SELECT 
yearmonthday, 
area_main_name, 
replace(replace(area_name,concat(area_main_name, ' '), ''),' ','') as area_sub_name, 
replace(doing,' ','') as dong, 
replace(apart_name,'''','') as apart_name,
CAST(size as DECIMAL(10,0)) as size,
stair,
ROUND(CAST(price as DECIMAL(10,5)),1) as price,
STATUS,
case when STATUS='상승' then 'todayhouseprice_map_icon_up.png' 
      when STATUS='신고가' then 'todayhouseprice_map_icon_upup.png' 
      when STATUS='하락' then 'todayhouseprice_map_icon_down.png' 
      when STATUS='신저가' then 'todayhouseprice_map_icon_downdown.png' 
      when STATUS='동일' then 'todayhouseprice_map_icon_same.png' 
      else 'todayhouseprice_map_icon2.png'
  end as icon,
TYPE,
ROUND(CAST(last_price as DECIMAL(10,5)),1) as last_price,
ROUND(CAST(max_price as DECIMAL(10,5)),1) as max_price,
ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),1) as price_last,
ROUND(100-(CAST(price as DECIMAL(10,5))/CAST(max_price as DECIMAL(10,5)))*100,0) AS max_percent,
(SELECT latitude FROM apart_dong WHERE area_main_name = a.area_main_name AND dong = a.doing AND apart_name = a.apart_name limit 1) AS latitude,
(SELECT longitude FROM apart_dong WHERE area_main_name = a.area_main_name AND dong = a.doing AND apart_name = a.apart_name limit 1) AS longitude
from molit_today_update a
where insert_date = '$today'
order by ABS(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),1)) desc
";

$rs = mysqli_query($Conn, $sql);
$rs_count = mysqli_num_rows($rs);

if ($rs_count == 0){
    $today = $before1Day;
    $sql = "
    SELECT 
    yearmonthday, 
    area_main_name, 
    replace(replace(area_name,concat(area_main_name, ' '), ''),' ','') as area_sub_name, 
    replace(doing,' ','') as dong, 
    replace(apart_name,'''','') as apart_name,
    CAST(size as DECIMAL(10,0)) as size,
    stair,
    ROUND(CAST(price as DECIMAL(10,5)),1) as price,
    STATUS,
    case when STATUS='상승' then 'todayhouseprice_map_icon_up.png' 
          when STATUS='신고가' then 'todayhouseprice_map_icon_upup.png' 
          when STATUS='하락' then 'todayhouseprice_map_icon_down.png' 
          when STATUS='신저가' then 'todayhouseprice_map_icon_downdown.png' 
          when STATUS='동일' then 'todayhouseprice_map_icon_same.png' 
          else 'todayhouseprice_map_icon2.png'
      end as icon,
    TYPE,
    ROUND(CAST(last_price as DECIMAL(10,5)),1) as last_price,
    ROUND(CAST(max_price as DECIMAL(10,5)),1) as max_price,
    ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),1) as price_last,
    ROUND(100-(CAST(price as DECIMAL(10,5))/CAST(max_price as DECIMAL(10,5)))*100,0) AS max_percent,
    (SELECT latitude FROM apart_dong WHERE area_main_name = a.area_main_name AND dong = a.doing AND apart_name = a.apart_name limit 1) AS latitude,
    (SELECT longitude FROM apart_dong WHERE area_main_name = a.area_main_name AND dong = a.doing AND apart_name = a.apart_name limit 1) AS longitude
    from molit_today_update a
    where insert_date = '$today'
    order by ABS(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),1)) desc
    ";
    $rs = mysqli_query($Conn, $sql);
    $rs_count = mysqli_num_rows($rs);

    if ($rs_count == 0){
        $today = $before2Day;
        $sql = "
        SELECT 
        yearmonthday, 
        area_main_name, 
        replace(replace(area_name,concat(area_main_name, ' '), ''),' ','') as area_sub_name, 
        replace(doing,' ','') as dong, 
        replace(apart_name,'''','') as apart_name,
        CAST(size as DECIMAL(10,0)) as size,
        stair,
        ROUND(CAST(price as DECIMAL(10,5)),1) as price,
        STATUS,
        case when STATUS='상승' then 'todayhouseprice_map_icon_up.png' 
              when STATUS='신고가' then 'todayhouseprice_map_icon_upup.png' 
              when STATUS='하락' then 'todayhouseprice_map_icon_down.png' 
              when STATUS='신저가' then 'todayhouseprice_map_icon_downdown.png' 
              when STATUS='동일' then 'todayhouseprice_map_icon_same.png' 
              else 'todayhouseprice_map_icon2.png'
          end as icon,
        TYPE,
        ROUND(CAST(last_price as DECIMAL(10,5)),1) as last_price,
        ROUND(CAST(max_price as DECIMAL(10,5)),1) as max_price,
        ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),1) as price_last,
        ROUND(100-(CAST(price as DECIMAL(10,5))/CAST(max_price as DECIMAL(10,5)))*100,0) AS max_percent,
        (SELECT latitude FROM apart_dong WHERE area_main_name = a.area_main_name AND dong = a.doing AND apart_name = a.apart_name limit 1) AS latitude,
        (SELECT longitude FROM apart_dong WHERE area_main_name = a.area_main_name AND dong = a.doing AND apart_name = a.apart_name limit 1) AS longitude
        from molit_today_update a
        where insert_date = '$today'
        order by ABS(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),1)) desc
        ";
        $rs = mysqli_query($Conn, $sql);
        $rs_count = mysqli_num_rows($rs);

        if ($rs_count == 0){
            $today = $before3Day;
            $sql = "
            SELECT 
            yearmonthday, 
            area_main_name, 
            replace(replace(area_name,concat(area_main_name, ' '), ''),' ','') as area_sub_name, 
            replace(doing,' ','') as dong, 
            replace(apart_name,'''','') as apart_name,
            CAST(size as DECIMAL(10,0)) as size,
            stair,
            ROUND(CAST(price as DECIMAL(10,5)),1) as price,
            STATUS,
            case when STATUS='상승' then 'todayhouseprice_map_icon_up.png' 
                  when STATUS='신고가' then 'todayhouseprice_map_icon_upup.png' 
                  when STATUS='하락' then 'todayhouseprice_map_icon_down.png' 
                  when STATUS='신저가' then 'todayhouseprice_map_icon_downdown.png' 
                  when STATUS='동일' then 'todayhouseprice_map_icon_same.png' 
                  else 'todayhouseprice_map_icon2.png'
              end as icon,
            TYPE,
            ROUND(CAST(last_price as DECIMAL(10,5)),1) as last_price,
            ROUND(CAST(max_price as DECIMAL(10,5)),1) as max_price,
            ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),1) as price_last,
            ROUND(100-(CAST(price as DECIMAL(10,5))/CAST(max_price as DECIMAL(10,5)))*100,0) AS max_percent,
            (SELECT latitude FROM apart_dong WHERE area_main_name = a.area_main_name AND dong = a.doing AND apart_name = a.apart_name limit 1) AS latitude,
            (SELECT longitude FROM apart_dong WHERE area_main_name = a.area_main_name AND dong = a.doing AND apart_name = a.apart_name limit 1) AS longitude
            from molit_today_update a
            where insert_date = '$today'
            order by ABS(ROUND((CAST(price as DECIMAL(10,5)) - CAST(last_price as DECIMAL(10,5))),1)) desc
            ";
            $rs = mysqli_query($Conn, $sql);
        }
    }
}

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}


?>

<body>

<!-- 네이버 지도가 뿌려질 곳 !  -->
<a href="./apart_today.php"><img style="vertical-align: middle;" width="30", height="30" src="./todayhouseprice2.png"></a>
<span style="font-size:25px; vertical-align: middle; font-family: nanumpen;">&nbsp;&nbsp;<?=$today?> 실거래, 총 <?=$rs_count?>건</span>
<div id="map" style="width:98%; height:93%; position:absolute; margin: 0 auto;"></div>

<script type="text/javascript">

//var locationBtnHtml = '<a href="#" class="btn_mylct"><img style="vertical-align: middle;" width="40px", height="40px" src="./todayhouseprice_button_current_location.png"></a>';

var mapDiv = document.getElementById('map');
var map = new naver.maps.Map('map', {
    center: new naver.maps.LatLng(37.5666103, 126.9783882), //지도 시작 지점
    zoom: 13,
    //줌 컨트롤//
    scaleControl: false,
    logoControl: false,
    mapDataControl: false,
    minZoom: 9,
    mapTypeControl: true,
    mapTypeControlOptions: {
        style: naver.maps.MapTypeControlStyle.BUTTON,
        position: naver.maps.Position.TOP_RIGHT
    },
    zoomControl: true,
    zoomControlOptions: {
        style: naver.maps.ZoomControlStyle.SMALL,
        position: naver.maps.Position.TOP_RIGHT
    },
    //줌 컨트롤//
});

var mylocation_lat;
var mylocation_long;

/*
naver.maps.Event.once(map, 'init', function() {
    //customControl 객체 이용하기
    var customControl = new naver.maps.CustomControl(locationBtnHtml, {
        position: naver.maps.Position.TOP_LEFT
    });

    customControl.setMap(map);

    naver.maps.Event.addDOMListener(customControl.getElement(), 'click', function() {
        map.setCenter(new naver.maps.LatLng(mylocation_lat, mylocation_long));
    });
});
*/

var areaArr = [];
areaArr.push(			
	<?php 
		$add_count = 0; 
		foreach ($rows as $row) {
			if($add_count == 0){
			  echo "{area_main_name : '".$row['area_main_name']."' ,area_sub_name : '".$row['area_sub_name']."' ,dong : '".$row['dong']."' ,apart_name : '".$row['apart_name']."' , size : '".$row['size']."' , stair : '".$row['stair']."' , price : '".$row['price']."' , STATUS : '".$row['STATUS']."' , TYPE : '".$row['TYPE']."' , price_last : '".$row['price_last']."' , last_price : '".$row['last_price']."' , max_price : '".$row['max_price']."' , max_percent : '".$row['max_percent']."' , lat : '".$row['latitude']."' , lng : '".$row['longitude']."' , icon : '".$row['icon']."'}";
			} else{
			  echo ",{area_main_name : '".$row['area_main_name']."' ,area_sub_name : '".$row['area_sub_name']."' ,dong : '".$row['dong']."' ,apart_name : '".$row['apart_name']."' , size : '".$row['size']."' , stair : '".$row['stair']."' , price : '".$row['price']."' , STATUS : '".$row['STATUS']."' , TYPE : '".$row['TYPE']."' , price_last : '".$row['price_last']."' , last_price : '".$row['last_price']."' , max_price : '".$row['max_price']."' , max_percent : '".$row['max_percent']."' , lat : '".$row['latitude']."' , lng : '".$row['longitude']."' , icon : '".$row['icon']."'}";
			} $add_count = $add_count + 1; 
	 }
	?>
);
//////////////// 지역정보를 담는 배열 ///////////////////

var markers = [];// 마커 정보를 담는 배열
var infoWindows = [];// 정보창을 담는 배열


// 지역을 담은 배열의 길이만큼 for문으로 마커와 정보창을 채워주자 !
for (var i = 0; i < areaArr.length; i++) {


  var marker = new naver.maps.Marker({
      map: map,
      title: areaArr[i].apart_name, // 지역구 이름 
      position: new naver.maps.LatLng(areaArr[i].lat , areaArr[i].lng), // 지역구의 위도 경도 넣기 ,
        icon:{
            content:[
                '<div class="jb-wrap">'+
                    '<div class="jb-image"><img style="vertical-align: middle;" width="65px", height="60px" src="./'+areaArr[i].icon+'"></div>'+
                    '<div class="jb-text">'+
                        '<p><b>'+areaArr[i].apart_name+'</b></p>'+
                    '</div>'+
                    '<div class="jb-text_sub">'+
                        '<p><b>'+areaArr[i].price+'억/'+areaArr[i].size+'㎡</b></p>'+
                    '</div>'+
                '</div>'
            ].join(''),
            size: new naver.maps.Size(38, 58),
            anchor: new naver.maps.Point(19,58),
        }
  });


  //content: '<div style="width:200px; padding:10px;"><center><span style="font-size:20px;"><b><a href="./apart.php?area_main_name='+areaArr[i].area_main_name+'&area_sub_name='+areaArr[i].area_sub_name+'&dong='+areaArr[i].dong+'&apart_name='+areaArr[i].apart_name+'&size='+areaArr[i].size+'">' 
  //   + areaArr[i].apart_name+'</a></b></span></center>'
  //   + areaArr[i].price+'억<br>직전거래대비 '
  //   + areaArr[i].price_last+'억 '
  //   + areaArr[i].STATUS+'<br>최고가 대비 '
  //   + areaArr[i].max_percent+'% 하락<br>'
  //   + areaArr[i].size+'㎡ / '
  //   + areaArr[i].stair+'층 / '
  //   + areaArr[i].TYPE+'</div>'

  
  /* 클릭시 정보창 */
 var infoWindow = new naver.maps.InfoWindow({
     content: 
     '<div style="padding:2px;"><center><span style="font-size:20px;"><b><a href="./apart.php?area_main_name='+areaArr[i].area_main_name+'&area_sub_name='+areaArr[i].area_sub_name+'&dong='+areaArr[i].dong+'&apart_name='+areaArr[i].apart_name+'&size='+areaArr[i].size+'">' 
     + areaArr[i].apart_name+'</a></b></span></center>'+
     '<center><table>'+
        '<thead>'+
            '<tr>'+
                '<th>현재</th>'+
                '<th>직전</th>'+
                '<th>차이</th>'+
                '<th>최고</th>'+
            '</tr>'+
        '</thead>'+
        '<tbody>'+
            '<tr>'+
                '<td><b>'+areaArr[i].price+'억</b></td>'+
                '<td><b>'+areaArr[i].last_price+'억</b></td>'+
                '<td><b>'+areaArr[i].price_last+'억</b></td>'+
                '<td><b>'+areaArr[i].max_price+'억</b></td>'+
            '</tr>'+
        '</tbody>'+
    '</table>'+
    '<table></center>'
 }); // 클릭했을 때 띄워줄 정보 HTML 작성
 markers.push(marker); // 생성한 마커를 배열에 담는다.
 infoWindows.push(infoWindow); // 생성한 정보창을 배열에 담는다.
 
}
// 지역을 담은 배열의 길이만큼 for문으로 마커와 정보창을 채워주자 !

//////////////// 클릭이벤트 ////////////////
function getClickHandler(seq) {
  return function(e) {  // 마커를 클릭하는 부분
    var marker = markers[seq], // 클릭한 마커의 시퀀스로 찾는다.
        infoWindow = infoWindows[seq]; // 클릭한 마커의 시퀀스로 찾는다

    if (infoWindow.getMap()) {
        infoWindow.close();
    } else {
        infoWindow.open(map, marker); // 표출
        //map.setCenter(marker.getPosition()); //현재위치로 이동
    }
	}
}

for (var i=0, ii=markers.length; i<ii; i++) {
	console.log(markers[i] , getClickHandler(i));
  naver.maps.Event.addListener(markers[i], 'click', getClickHandler(i)); // 클릭한 마커 핸들러
}
//////////////// 클릭이벤트 ////////////////

//////////////// 보여지는 지역만 마커하기 ////////////////
naver.maps.Event.addListener(map, 'zoom_changed', function() {
    updateMarkers(map, markers);
});

naver.maps.Event.addListener(map, 'dragend', function() {
    updateMarkers(map, markers);
});

function updateMarkers(map, markers) {

    var mapBounds = map.getBounds();
    var marker, position;

    for (var i = 0; i < markers.length; i++) {

        marker = markers[i];
        position = marker.getPosition();
        infoWindow = infoWindows[i];
        infoWindow.close();

        if (mapBounds.hasLatLng(position)) {
            showMarker(map, marker);
        } else {
            hideMarker(map, marker);
        }
    }
}
function showMarker(map, marker) {
    if (marker.setMap()) return;
    marker.setMap(map);
}

function hideMarker(map, marker) {
    if (!marker.setMap()) return;
    marker.setMap(null);
}
//////////////// 보여지는 지역만 마커하기 ////////////////


//////////////// 현재위치 마커하기 ////////////////
/*
getUserLocation();

function success({ coords, timestamp }) {
    var latitude = coords.latitude;   // 위도
    var longitude = coords.longitude; // 경도

    mylocation_lat = latitude;
    mylocation_long = longitude;
    
    var marker = new naver.maps.Marker({
      position: new naver.maps.LatLng(latitude, longitude),
      map: map,
      icon: {
        url: './todayhouseprice_icon_current_location.jpg', //50, 68 크기의 원본 이미지
        size: new naver.maps.Size(25, 34),
        scaledSize: new naver.maps.Size(25, 34),
        origin: new naver.maps.Point(0, 0),
        anchor: new naver.maps.Point(12, 34)
    }
    });
}

function getUserLocation() {
    if (!navigator.geolocation) {
        throw "위치 정보가 지원되지 않습니다.";
    }
    navigator.geolocation.getCurrentPosition(success);
}
*/
//////////////// 현재위치 마커하기 ////////////////


//////////////// 클러스터링 ////////////////

$(document).ready(function(){
    var htmlMarker1 = {
    content: '<div style="cursor:pointer;width:40px;height:40px;line-height:42px;font-size:10px;color:white;text-align:center;font-weight:bold;background:url(https://navermaps.github.io/maps.js.ncp/docs/img/cluster-marker-1.png);background-size:contain;"></div>',
    size: N.Size(40, 40),
    anchor: N.Point(20, 20)
    },
    htmlMarker2 = {
        content: '<div style="cursor:pointer;width:40px;height:40px;line-height:42px;font-size:10px;color:white;text-align:center;font-weight:bold;background:url(https://navermaps.github.io/maps.js.ncp/docs/img/cluster-marker-2.png);background-size:contain;"></div>',
        size: N.Size(40, 40),
        anchor: N.Point(20, 20)
    },
    htmlMarker3 = {
        content: '<div style="cursor:pointer;width:40px;height:40px;line-height:42px;font-size:10px;color:white;text-align:center;font-weight:bold;background:url(https://navermaps.github.io/maps.js.ncp/docs/img/cluster-marker-3.png);background-size:contain;"></div>',
        size: N.Size(40, 40),
        anchor: N.Point(20, 20)
    },
    htmlMarker4 = {
        content: '<div style="cursor:pointer;width:40px;height:40px;line-height:42px;font-size:10px;color:white;text-align:center;font-weight:bold;background:url(https://navermaps.github.io/maps.js.ncp/docs/img/cluster-marker-4.png);background-size:contain;"></div>',
        size: N.Size(40, 40),
        anchor: N.Point(20, 20)
    },
    htmlMarker5 = {
        content: '<div style="cursor:pointer;width:40px;height:40px;line-height:42px;font-size:10px;color:white;text-align:center;font-weight:bold;background:url(https://navermaps.github.io/maps.js.ncp/docs/img/cluster-marker-5.png);background-size:contain;"></div>',
        size: N.Size(40, 40),
        anchor: N.Point(20, 20)
    };

    var markerClustering = new MarkerClustering({
    minClusterSize: 4,
    maxZoom: 15,
    map: map,
    markers: markers,
    disableClickZoom: false,
    gridSize: 120,
    icons: [htmlMarker1, htmlMarker2, htmlMarker3, htmlMarker4, htmlMarker5],
    indexGenerator: [10, 100, 200, 500, 1000],
    stylingFunction: function(clusterMarker, count) {
        $(clusterMarker.getElement()).find('div:first-child').text(count);
    }
    });
});



//////////////// 클러스터링 ////////////////








</script>
</body>
</html>

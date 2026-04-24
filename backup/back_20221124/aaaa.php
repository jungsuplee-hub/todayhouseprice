<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<title>Table V04</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" type="image/png" href="https://colorlib.com/etc/tb/Table_Fixed_Header/images/icons/favicon.ico">

<link rel="stylesheet" type="text/css" href="./Table V04_files/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="./Table V04_files/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="./Table V04_files/animate.css">

<link rel="stylesheet" type="text/css" href="./Table V04_files/select2.min.css">

<link rel="stylesheet" type="text/css" href="./Table V04_files/perfect-scrollbar.css">

<link rel="stylesheet" type="text/css" href="./Table V04_files/util.css">
<link rel="stylesheet" type="text/css" href="./Table V04_files/main.css">

<meta name="robots" content="noindex, follow">
<script type="text/javascript" async="" src="./Table V04_files/analytics.js" nonce="2ae6dd04-2080-4222-88d9-aefa2500b045"></script><script defer="" referrerpolicy="origin" src="./Table V04_files/s.js"></script><script nonce="2ae6dd04-2080-4222-88d9-aefa2500b045">(function(w,d){!function(a,e,t,r){a.zarazData=a.zarazData||{};a.zarazData.executed=[];a.zaraz={deferred:[],listeners:[]};a.zaraz.q=[];a.zaraz._f=function(e){return function(){var t=Array.prototype.slice.call(arguments);a.zaraz.q.push({m:e,a:t})}};for(const e of["track","set","debug"])a.zaraz[e]=a.zaraz._f(e);a.zaraz.init=()=>{var t=e.getElementsByTagName(r)[0],z=e.createElement(r),n=e.getElementsByTagName("title")[0];n&&(a.zarazData.t=e.getElementsByTagName("title")[0].text);a.zarazData.x=Math.random();a.zarazData.w=a.screen.width;a.zarazData.h=a.screen.height;a.zarazData.j=a.innerHeight;a.zarazData.e=a.innerWidth;a.zarazData.l=a.location.href;a.zarazData.r=e.referrer;a.zarazData.k=a.screen.colorDepth;a.zarazData.n=e.characterSet;a.zarazData.o=(new Date).getTimezoneOffset();a.zarazData.q=[];for(;a.zaraz.q.length;){const e=a.zaraz.q.shift();a.zarazData.q.push(e)}z.defer=!0;for(const e of[localStorage,sessionStorage])Object.keys(e||{}).filter((a=>a.startsWith("_zaraz_"))).forEach((t=>{try{a.zarazData["z_"+t.slice(7)]=JSON.parse(e.getItem(t))}catch{a.zarazData["z_"+t.slice(7)]=e.getItem(t)}}));z.referrerPolicy="origin";z.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(a.zarazData)));t.parentNode.insertBefore(z,t)};["complete","interactive"].includes(e.readyState)?zaraz.init():a.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,0,"script");})(window,document);</script></head>
<body>
<div class="limiter">
<div class="container-table100">
<div class="wrap-table100">
<div class="table100 ver1 m-b-110">
<div class="table100-head">
<table>
<thead>
<tr class="row100 head">
<th class="cell100 column1">아파트명</th>
<th class="cell100 column2">층</th>
<th class="cell100 column2">사이즈</th>
<th class="cell100 column4">가격</th>
<th class="cell100 column5">거래타입</th>
</tr>
</thead>
</table>
</div>
<div class="table100-body js-pscroll ps ps--active-y">
<table>
<tbody>

<?php

$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);

$sql = "
    SELECT *
    FROM molit_info
    where apart_name = '관악파크푸르지오'
    and size = '84.98'
    order by year, month, day
    ";

mysqli_query($Conn, "set names utf8;");
mysqli_query($Conn, "set session character_set_connection=utf8;");
mysqli_query($Conn, "set session character_set_results=utf8;");
mysqli_query($Conn, "set session character_set_client=utf8;");

$rs = mysqli_query($Conn, $sql);


$articles = [];

while ( $row = mysqli_fetch_assoc($rs) ) {
    $rows[] = $row;
}
?>

<?php foreach ($rows as $row) { ?>
  <tr class="row100 body">
  <td class="cell100 column1"><?=$row['apart_name']?></td>
  <td class="cell100 column2"><?=$row['stair']?></td>
  <td class="cell100 column2"><?=$row['size']?></td>
  <td class="cell100 column4"><?=$row['price']?></td>
  <td class="cell100 column5"><?=$row['type']?></td>
  </tr>
<?php } ?>

</tbody>
</table>
<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 585px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 291px;"></div></div></div>
</div>
</div>
</div>
</div>

<script src="./Table V04_files/jquery-3.2.1.min.js"></script>

<script src="./Table V04_files/popper.js"></script>
<script src="./Table V04_files/bootstrap.min.js"></script>

<script src="./Table V04_files/select2.min.js"></script>

<script src="./Table V04_files/perfect-scrollbar.min.js"></script>
<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})
		});


	</script>

<script async="" src="./Table V04_files/js"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

<script src="./Table V04_files/main.js"></script>
<script defer="" src="./Table V04_files/v652eace1692a40cfa3763df669d7439c1639079717194" integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw==" data-cf-beacon="{&quot;rayId&quot;:&quot;7563544848631f4b&quot;,&quot;token&quot;:&quot;cd0b4b3a733644fc843ef0b185f98241&quot;,&quot;version&quot;:&quot;2022.8.1&quot;,&quot;si&quot;:100}" crossorigin="anonymous"></script>


</body></html>
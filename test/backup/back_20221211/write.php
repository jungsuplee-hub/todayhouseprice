<?php
	include "./config.php";
	include "./db/db_con.php";
	include "./login_check.php";

	$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
	$today = date("Y-m-d");
	//조회수 출력
	$sql_count = "
	select
	IFNULL((SELECT SUM(COUNT) from molit_visit_count),0) AS total,
	IFNULL((SELECT SUM(COUNT) from molit_visit_count WHERE YMD = '$today'),0) AS today
	FROM DUAL;
	";
	$rs_count = mysqli_query($Conn, $sql_count);
	$row_count = mysqli_fetch_assoc($rs_count);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
    <title>오늘집값 - 아파트 실거래 조회</title>
		<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
		<meta property="og:type" content="website">
		<meta property="og:title" content="오늘집값">
		<meta property="og:description" content="오늘집값 - 아파트 매매  정보를 상세히 검색 할 수 있습니다.">
		<meta property="og:image" content="./todayhouseprice2.png">
		<meta property="og:url" content="http://todayhouseprice.com/">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
         crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="./test.css">
	</head>
	<body>
		<!-- 표준 네비게이션 바 (화면 상단에 위치, 화면에 의존하여 확대 및 축소) -->
		<?php
		  if(!$userid){
		?>
		<a style="font-size:20px;" href="./login.php"><b>로그인</b></a>
		<?php
		  }else if($userid){
		    //$logged = $username."(".$userid.")";
		    $logged = $userid;
		?>
		<span style="font-size:20px;"><b><?=$logged ?>님 </b></span><a style="font-size:20px;" href="./logout.php"><b>로그아웃</b></a>  <a style="font-size:20px;" href="./apart_favorite.php"><b>즐겨찾기</b></a>  <a style="font-size:20px;" href="./index.php"><b>홈페이지</b></a>
		<?php }?>
		<span style="font-size:20px; float:right;"><b>Total : <?=$row_count['total']?>, Today : <?=$row_count['today']?></b></span>
		<center>
		<a href="./apart_today.php"><img style="vertical-align: middle;" width="90", height="90" src="./todayhouseprice2.png"></a>
		<span style="font-size:30px; vertical-align: middle;"><b>자유게시판</b></span>
		</center>
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
		     crossorigin="anonymous"></script>
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-format="fluid"
		     data-ad-layout-key="-fb+5w+4e-db+86"
		     data-ad-client="ca-pub-3758121784656467"
		     data-ad-slot="7226824761"></ins>
		<script>
		     (adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		<div class="container">
			<div id="board_write">
                <form action="write_ok.php" method="post">
					<table class="table table-striped" style="text-align: center; border: 1px solid #ddddda">
						<thead>
							<tr>
								<th style="text-align: center;"><h2>게시판 글쓰기</h2></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="text-align: left;"><b>아이디 : <?=$userid?></b></td>
							</tr>
							<tr>
								<td style="text-align: left;"><b>제목 : </b><input style="width:93%;" type="text" placeholder="글 제목" name="title" id="utitle" required></td>
							</tr>
							<!--
							<tr>
								<td><input type="password" class="form-control" placeholder="글 비밀번호" name="pw" id="upw" style="width: 150px;"></td>
							</tr>
						-->
							<tr>
								<td style="vertical-align: middle; text-align: left;"><b>내용 : </b><textarea placeholder="글 내용" name="content" id="ucontent" style="width:93%; height: 200px;" required></textarea></td>
							</tr>
						</tbody>
					</table>
					<br>
					<!--<input type="checkbox" value="1" name="lockpost">비밀글<br><br>-->
					<button type="submit" style="font-size: 20px; width:110px;">글쓰기</button>
				</form>
			</div>
		</div>
		<script src="./js/login.js"></script>
	</body>
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3758121784656467"
	     crossorigin="anonymous"></script>
	<ins class="adsbygoogle"
	     style="display:block"
	     data-ad-format="fluid"
	     data-ad-layout-key="-fb+5w+4e-db+86"
	     data-ad-client="ca-pub-3758121784656467"
	     data-ad-slot="7226824761"></ins>
	<script>
	     (adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : jungsup2.lee@gmail.com</b></span></center>
</html>

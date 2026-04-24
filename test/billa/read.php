<?php
	include "./config.php";
	include "./db/db_con.php";
	session_start();
	$userid = $_SESSION["userid"];

	$bno = $_GET['idx']; // $bno에 idx값을 받아와 넣음
	/* 조회수 올리기  */
	$hit = mysqli_fetch_array(mq("select
									*
								  from
									board
								  where
									idx ='".$bno."'
								"));
	$hit = $hit['hit'] + 1;
	mq("update
		 board
	   set
		 hit = '".$hit."'
	   where
		 idx = '".$bno."'
	");
	/* 조회수 올리기 끝 */

	/* 받아온 idx값을 선택해서 게시글 정보 가져오기 */
	$sql = mq("select
				 *
			   from
				 board
			   where
				 idx='".$bno."'
			");
	$board = $sql->fetch_array();

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
		<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EF60WVGV7F"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-EF60WVGV7F');
	gtag('config', 'AW-945296853');
	gtag('event', 'conversion', {'send_to': 'AW-945296853/nBcaCMiZnYcYENWr4MID'});
</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="./todayhouseprice2.ico">
    <title>오늘집값 - 게시판</title>
		<meta name="description" content="빌라 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
		<meta property="og:type" content="website">
		<meta property="og:title" content="오늘집값">
		<meta property="og:description" content="오늘집값 - 빌라 매매  정보를 상세히 검색 할 수 있습니다.">
		<meta property="og:image" content="./todayhouseprice2.png">
		<meta property="og:url" content="http://todayhouseprice.com/">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
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
		<?php if($userid=="ljs1092"){?>
<span style="font-size:20px; float:right;"><b>Total : <?=$row_count['total']?>, Today : <?=$row_count['today']?></b></span>
<?php }?>
		<center>
		<a href="./apart_today.php"><img style="vertical-align: middle;" width="90", height="90" src="./todayhouseprice2.png"></a>
		<span style="font-size:30px; vertical-align: middle;"><b>자유게시판</b></span>
		</center>

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

		<div class="container">
			<!-- 글 불러오기 -->
			<div id="board_read">
				<table class="table table-striped" style="text-align: center; border: 1px solid #ddddda">
					<thead>
						<tr>
							<th colspan="2" style="text-align: center;"><h2>게시판 글읽기</h2></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th style="font-size: 20px;">작성자 : <?=$board['name']?> / 작성일자 : <?=$board['date']?></th>
						</tr>
						<tr>
							<th style="font-size: 20px;">글 제목 : <?=$board['title']?></th>
						</tr>
						<tr>
							<th style="font-size: 20px;">글 내용 : <?=$board['content']?></th>
						</tr>
					</tbody>
				</table>
				<!-- 목록, 수정, 삭제 -->
				<br>
				<a href="list.php"><button style="font-size: 20px; width:110px;">목록</button></a>
				<!-- 자신의 글만 수정, 삭제 할 수 있도록 설정-->
				<?php
					if($userid==$board['name'] || $role=="ADMIN"){ // 본인 아이디거나, 관리자 계정이거나
				?>
						<a href="update.php?idx=<?=$board['idx']?>"><button style="font-size: 20px; width:110px;">수정</button></a>
						<a href="delete.php?idx=<?=$board['idx']?>"><button style="font-size: 20px; width:110px;">삭제</button></a>
				<?php } ?>
			</div>
		</div>
		<!-- 댓글 불러오기 -->
		<div class="container">
			<div class="reply_view">
				<h3 style="padding:10px 0 15px 0; border-bottom: solid 1px gray;">댓글목록</h3>
				<?php
					$sql3=mq("select
						*
					  from
						reply
					  where
						con_num='".$bno."'
					  order by
						idx asc
					");
					while($reply=$sql3->fetch_array()){
				?>
				<div class="dat_view">
					<form method="post" id="modal_form2" action="reply_delete.php">
						<input type="hidden" name="rno" class="rno" value=<?=$reply['idx']?>>
						<input type="hidden" name="bno" class="bno" value=<?=$bno?>>
						<input type="hidden" name="userid" class="userid" value=<?=$userid?>>
						<div><b><?=$reply['name']?></b> / <?=$reply['date']?> <?php if ($userid == $reply['name']) {?><button type="submit" id="rep_btn">삭제</button><?php }?></div>
						<div><?php echo nl2br("$reply[content]"); ?></div>
					</form>
					<br>
				</div>

				<?php } ?>
				<!-- 댓글 달기 -->
				<div>
					<form method="post" id="modal_form2" action="reply_ok.php">
						<input type="hidden" name="bno" class="bno" value=<?=$bno?>>
						<input type="hidden" name="dat_user" id="dat_user" class="dat_user" value=<?=$userid?>>
						<div style="margin-top:10px;">
							<textarea style="width:30%" name="content" class="content" id="content"></textarea>
							<br>
							<button type="submit" id="rep_btn">댓글등록</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- 댓글 불러오기 끝 -->
		<script src="./js/login.js"></script>
		<script src="./js/event.js"></script>
	</body>

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

	<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : todayhouseprice.com@gmail.com</b></span></center>
</html>

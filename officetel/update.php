<?php
	include "./config.php";
	include "./db/db_con.php";
	include "./login_check.php";

	$bno = $_GET['idx']; // $bno에 idx값을 받아와 넣음
	/* 받아온 idx값을 선택해서 게시글 정보 가져오기 */
	$sql = mq("select
				 *
			   from
				 board
			   where
				 idx='$bno'
			");
	$board = $sql->fetch_array();

	$Conn = mysqli_connect("localhost", "root", "e0425820", "jsdb", 3306);
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
		<meta name="description" content="아파트 매매, 전세 실거래가를 확인해보세요. 당일 등록된 매매/전세정보를 확인하고 본인만의 즐겨찾기를 설정 할 수 있습니다.">
		<meta property="og:type" content="website">
		<meta property="og:title" content="오늘집값">
		<meta property="og:description" content="오늘집값 - 아파트 매매  정보를 상세히 검색 할 수 있습니다.">
		<meta property="og:image" content="./todayhouseprice2.png">
		<meta property="og:url" content="http://todayhouseprice.com/">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2265060002718871"
         crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="./test.css">
		<script src="https://cdn.tiny.cloud/1/sbuaimecfilbpa7m8ttyytjo2fhbkbunkwhe1e8ks1pynpmg/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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
			<div id="board_write">
                <form action="update_ok.php" method="post">
                <input type="hidden" name="idx" value="<?=$bno?>" />
					<table class="table table-striped" style="text-align: center; border: 1px solid #ddddda">
						<thead>
							<tr>
								<th colspan="2" style="text-align: center;"><h2>게시판 수정하기</h2></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="text-align: left;"><b>아이디 : <?=$userid?></b></td>
							</tr>
							<tr>
								<td style="text-align: left;"><b>제목 : </b><input style="width:93%;" type="text" placeholder="글 제목" name="title" id="utitle" value="<?=$board['title']?>" required></td>
							</tr>
							<!--
							<tr>
								<td><input type="password" class="form-control" placeholder="글 비밀번호" name="pw" id="upw" style="width: 150px;"></td>
							</tr>
						-->
							<tr>
								<td style="vertical-align: middle; text-align: left;"><b>내용 : </b>
								<textarea name="maintext" id="maintext" style="width:99%; height: 600px;"><?=$board['content']?></textarea>
								</td>
							</tr>
						</tbody>
					</table>
					<br>
					<button type="submit" style="font-size: 20px; width:110px;">글쓰기</button>
				</form>
			</div>
		</div>
		<script src="./js/login.js"></script>
		<script>
    tinymce.init({
      selector: 'textarea',
      plugins: ['advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'print', 'preview', 'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media', 'table', 'paste', 'code', 'help', 'wordcount', 'save' ],
    toolbar: 'formatselect fontselect fontsizeselect |'
            + ' forecolor backcolor |'
            + ' bold italic underline strikethrough |'
            + ' alignjustify alignleft aligncenter alignright |'
            + ' bullist numlist |'
            + ' table tabledelete |'
            + ' link image',
    fontsize_formats: '9px 10px 11px 12px 13px 14px 15px 16px 18px 20px 22px 24px 28px 32px 36px 48px',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    menubar: false,
  setup: function(editor) {}
 });
  </script>
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

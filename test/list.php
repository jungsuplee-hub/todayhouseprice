<?php
	include_once "./db/db_con.php";
	include_once "./config.php";
	//session_start();
	//$userid = $_SESSION["userid"];
	// 현재 페이지 번호를 확인
	if (isset($_GET["page"]))
		$page = $_GET["page"]; //1,2,3,4,5
	else
		$page = 1;

	$Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
	$today = date("Y-m-d");
	//조회수 출력
	$sql_count = "
select
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count),0),0) AS total,
FORMAT(IFNULL((SELECT SUM(COUNT) from molit_visit_count WHERE YMD = '$today'),0),0) AS today
FROM DUAL;
	";
	$rs_count = mysqli_query($Conn, $sql_count);
	$row_count = mysqli_fetch_assoc($rs_count);


$this_site = str_replace('.php','',basename( $_SERVER[ "PHP_SELF" ] ));
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
		<link rel="stylesheet" type="text/css" href="./todayhouseprice.css">
	</head>
	<body>

		<?php
		  if(!$userid){
		?>
		<a style="font-size:25px;" href="./login.php?site=<?=$this_site?>"><b>로그인</b></a>  <a style="font-size:25px;" href='./info.php'>(텔레그램으로 매일 알림받기)</a>
		<?php
		  }else if($userid){
		    //$logged = $username."(".$userid.")";
		    $logged = $userid;
		?>
		<span style="font-size:25px;"><b><?=$logged ?>님 </b></span><a style="font-size:25px;" href="./logout.php?site=<?=$this_site?>"><b>로그아웃</b></a>  <a style="font-size:25px;" href="./apart_favorite.php"><b>즐겨찾기</b></a>  <a style="font-size:25px;" href='./info.php'>(텔레그램으로 매일 알림받기)</a>
		<?php }?>
		<?php if($userid=="ljs1092"){?>
		<span style="font-size:25px; float:right;"><b>Total : <?=$row_count['total']?>, Today : <?=$row_count['today']?></b></span>
		<?php }else{?>
		<span style="font-size:25px; float:right;"><b><a href="./list.php" style="text-decoration-line: none;"><b>[자유게시판]</b></a><a href="./apart_news.php" style="text-decoration-line: none;"><b>[부동산뉴스]</b></a></b></span>
		<?php }?>
		<table>
		    <thead>
		    <tr>
		      <th style="background: #C0C0C0; width:25%; font-size: 30px; color:black; padding-top:5px; padding-bottom:0px;"><center>아파트</center></th>
		      <th style="background: #DEEBF7; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../officetel/list.php'>오피스텔</a></center></th>
		      <th style="background: #E2F0D9; width:25%; font-size: 30px; padding-top:5px; padding-bottom:0px;"><center><a style="text-decoration: none;" href='../billa/list.php'>다세대주택(빌라)</a></center></th>
		    </tr>
		  </thead>
		</table>
		<table>
		    <thead>
		    <tr>
		      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_today.php?user_update=true'>금일 신규등록</a></center></th>
		      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home.php?user_update=true'>매매 상세조회</a></center></th>
		      <th style="background: #809EAD; width:17%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_home_rent.php?user_update=true'>전월세 상세조회</a></center></th>
		      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_trend.php'>부동산 통계</a></center></th>
		      <th style="background: #809EAD; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./apart_todayhouseprice_rank_one.php'>오늘집값 랭킹</a></center></th>
		      <th style="background: #73685d; width:16%; padding-top:15px; padding-bottom:10px;"><center><a style="font-size: 20px; color:white; text-decoration: none;" href='./list.php'>자유게시판</a></center></th>
		    </tr>
		  </thead>
		</table>
		<br>
		<center>
		<a href="./apart_today.php"><img style="vertical-align: middle;" width="100", height="100" src="./todayhouseprice2.png"></a>
		<span style="font-size:60px; vertical-align: middle; font-family: nanumpen;">&nbsp;&nbsp;오늘집값</span>
		</center>
		<br>





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

		<!-- 비밀 글 모달창 구현 끝-->
		<div class="container">
			<div id="board_area">
			  <h3>사이트 개선 의견을 포함하여 자유롭게 글을 남겨주세요.</h3>
			  <table>
					<thead>
				  	<tr>
							<th style="font-size: 20px; width:9%; text-align: center;">번호</th>
							<th style="font-size: 20px; width:50%; text-align: center;">제목</th>
							<th style="font-size: 20px; width:16%; text-align: center;">작성자</th>
							<th style="font-size: 20px; width:15%; text-align: center;">작성일</th>
							<th style="font-size: 20px; width:10%; text-align: center;">조회수</th>
				    </tr>
					</thead>
			    <!-- 페이징 구현 -->
			    <?php
			    	$sql = mq("select
			    					*
			    			   from
			    					board
			    			");
			    	$total_record = mysqli_num_rows($sql); // 게시판 총 레코드 수z

			    	$list = 10; // 한 페이지에 보여줄 개수
			  		$block_cnt = 10; // 블록당 보여줄 페이지 개수
			  		$block_num = ceil($page / $block_cnt); // 현재 페이지 블록 구하기
			  		$block_start = (($block_num - 1) * $block_cnt) + 1; // 블록의 시작 번호  ex) 1,6,11 ...
			    	$block_end = $block_start + $block_cnt - 1; // 블록의 마지막 번호 ex) 5,10,15 ...


			    	$total_page = ceil($total_record / $list); // 페이징한 페이지 수
			    	if($block_end > $total_page){ // 블록의 마지막 번호가 페이지 수 보다 많다면
			    		$block_end = $total_page; // 마지막 번호는 페이지 수
			    	}
			    	$total_block = ceil($total_page / $block_cnt); // 블럭 총 개수
			    	$page_start = ($page - 1) * $list; // 페이지 시작

			    	/* 게시글 정보 가져오기  limit : (시작번호, 보여질 수) */
			    	$sql2 = mq("select
			    					*
			    				from
			    					board
			    				order by
			    					idx desc limit $page_start, $list
			    			");
			    	while($board = $sql2->fetch_array()){
			    		$title=$board["title"];
			    		/* 글자수가 30이 넘으면 ... 처리해주기 */

			    		/* 댓글 수 구하기 */
			    		$sql3 = mq("select
			    						*
			    				    from
			    						reply
			    					where
			    						con_num='".$board['idx']."'
			    				");
			    		$rep_count = mysqli_num_rows($sql3); // 레코드의 수(댓글의 수)

			    ?>

			      <!-- 글 목록 가져오기 -->
			      <tbody>
			      	<tr>
			          <td style="font-size: 20px; text-align: center;"><?=$board['idx']; ?></td>
			          <td style="font-size: 20px;"><a style="text-decoration-line: none;" href="./read.php?idx=<?=$board['idx']?>"><?=$title?>[<?=$rep_count?>]</a>
			          <td style="font-size: 20px; text-align: center;"><?=$board['name'];?></td>
			          <td style="font-size: 20px; text-align: center;"><?=$board['date'];?></td>
			          <td style="font-size: 20px; text-align: center;"><?=$board['hit']; ?></td>
			        </tr>
			      </tbody>
			      <?php } ?>
			    </table>
					<br>
			    <div id="page_num" style="font-size: 20px; text-align: center;">
			    	<?php
				    	if ($page <= 1){
				    		// 빈 값
				    	} else {
				    		echo "<a href='list.php?page=1'>처음</a>";
				    	}

				    	if ($page <= 1){
				    		// 빈 값
				    	} else {
				    		$pre = $page - 1;
				    		echo "<a href='list.php?page=$pre'>◀ 이전 </a>";

				    	}

				    	for($i = $block_start; $i <= $block_end; $i++){
				    		if($page == $i){
				    			echo "<b> $i </b>";
				    		} else {
				    			echo "<a href='list.php?page=$i'> $i </a>";
				    		}
				    	}

				    	if($page >= $total_page){
				    		// 빈 값
				    	} else {
				    		$next = $page + 1;
				    		echo "<a href='list.php?page=$next'> 다음 ▶</a>";
				    	}

				    	if($page >= $total_page){
				    		// 빈 값
				    	} else {
				    		echo "<a href='list.php?page=$total_page'>마지막</a>";
				    	}
					?>
				</div>
			    <div>
			      <a href="write.php"><button style="font-size: 20px; width:110px;">글쓰기</button></a>
			    </div>
			  <!--<div id="search_box" style="text-align: center; padding-top: 20px;">
			  	<form action="search_result.php" method="get">
			  		<select name="category">
			  			<option value="title">제목</option>
			  			<option value="name">글쓴이</option>
			  			<option value="content">내용</option>
			  		</select>
			  		<input type="text" name="search" size="40" required="required">
			  			<button class="btn btn-primary">검색</button>
			  	</form>
			  </div>
			-->
		  </div>
		</div>
		<script src="./js/login.js"></script>

		<script>
		<!-- 비밀글 클릭시 모달창을 띄우는 이벤트 -->
		$(function(){
		    $(".lock_check").click(function(){
			    <!-- 관리자 계정일 경우 바로 해당 글로 이동 -->
			    if($(this).attr("data-check")=="ADMIN") {
			    	var action_url = $(this).attr("data-action")+$(this).attr("data-idx");
					$(location).attr("href",action_url);
			    }
				$("#modal_div").modal();
				<!-- 주소에 data-idx(idx)값을 더하기 -->
				var action_url = $("#modal_form").attr("data-action")+$(this).attr("data-idx");
				$("#modal_form").attr("action",action_url);
			});
		});

		<!-- 일반 글 클릭시 해당 idx의 read 페이지로 이동하는 이벤트 -->
		$(function(){
		    $(".read_check").click(function(){
			    var action_url = $(this).attr("data-action");
			    console.log(action_url);
			    $(location).attr("href",action_url);
			});
		});
		</script>
	</body>
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



	<br>
	<center><span style="font-size:20px;"><b>Copyright ©2022 TodayHousePrice, Inc. All rights reserved<br>Developer : todayhouseprice.com@gmail.com</b></span></center>
</html>

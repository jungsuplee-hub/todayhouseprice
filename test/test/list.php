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


?>
<?php
include_once "./top_page.php";
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

<?php
	include "./config.php";
	include "./db/db_con.php";

	$bno = $_POST['idx']; // $bno(hidden)에 idx값을 받아와 넣음
	$date = date('Y-m-d');
	/* 받아온 idx값을 선택해서 게시글 수정 */
	$sql = mq("update
			board
	   set
			date = '".$date."',
			title='".$_POST['title']."',
			content='".$_POST['maintext']."'
	   where
			idx='".$bno."'
	");

	echo "
			<script>
					alert('수정되었습니다.');
					location.href = './read.php?idx=$bno';
			</script>
	";
?>

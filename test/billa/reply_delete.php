<?php
	include './db/db_con.php';

	// hidden의 값 rno를 받아와 그 값에 해당하는 idx 에 대한 reply 테이블 정보 가져오기
	$rno = $_POST['rno'];
	$bno = $_POST['bno'];
	$role = $_POST['userid'];

	$sql = mq("delete
					   from
							reply
					   where
							idx='".$rno."'
					");

		echo "
				<script>
						alert('댓글이 삭제 되었습니다.');
						location.href = './read.php?idx=$bno';
				</script>
		";
?>

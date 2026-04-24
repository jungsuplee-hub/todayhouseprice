<?php
	include './config.php';
	include './db/db_con.php';

	$bno = $_POST['bno'];
	//$userpw = $_POST['dat_pw'];
	$times = mktime();  // ���� ������ �ð��� timestamp ������ ������
  $date1 = date("Y-m-d H:i:s", $times);  // �� -> ��-��-�� ��:��:��  ��ȯ

	if($_POST['content']!=''){
		$sql = mq("insert
						reply
				   set
						con_num = '".$bno."',
						name = '".$userid."',
						content = '".$_POST['content']."',
						date = '".$date1."'
				");
			echo "
		      <script>
	    	      alert('댓글등록이 완료 되었습니다.');
		          location.href = './read.php?idx=$bno';
		      </script>
		  ";
	}
?>

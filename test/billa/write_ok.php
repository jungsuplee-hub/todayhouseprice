<?php
	include "./config.php";
	include "./db/db_con.php";

	$name = $userid;
	$date = date('Y-m-d');
	//$userpw = $_POST['pw']; // 입력받은 패스워드를 해쉬값으로 암호화
	$title = $_POST['title'];
	$content = $_POST['maintext'];

  if($name!=''){
    mq("alter table board auto_increment =1"); //auto_increment 값 초기화 (삭제 시 번호 비지 않게 하기 위해서)
    mq("INSERT
			board
		SET
			name = '".$name."', 
			title = '".$title."',
			content = '".$content."',
			date ='".$date."',
			lock_post = '".$lo_post."'
	");
	
	echo"
  	<script>
  		alert('글쓰기 완료되었습니다.');
  		location.href = 'list.php';
  	</script>
  	";
  }else{
    echo"
  	<script>
  		alert('세션이 만료되었습니다. 다시로그인 해주세요.');
  		location.href = 'login.php';
  	</script>
  	";
  }
?>

<!-- DB 연동 -->
<?php
	$db_id="root";
	$db_pw="e0425820";
	$db_name="jsdb";
	$db_domain="localhost";
	$db=mysqli_connect($db_domain,$db_id,$db_pw,$db_name);
	
	mysqli_query($db, "set names utf8;");
  mysqli_query($db, "set session character_set_connection=utf8;");
  mysqli_query($db, "set session character_set_results=utf8;");
  mysqli_query($db, "set session character_set_client=utf8;");
	
	// 페이징, 조회수 처리 등 코드 간소화를 위해 사용할 함수
	function mq($sql){
		global $db;
		return $db->query($sql);
	}
?>
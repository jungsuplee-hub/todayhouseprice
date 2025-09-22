<!-- 세션 관리 -->
<?php
	session_start();
	//session_start();
	$userid = $_SESSION["userid"];
	$advertize = "1";
	
	$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

  if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
	  $isMobile = "Y";
  }else{
    $isMobile = "N";
  }
	
	
	//if (isset($_SESSION["userid"])) {
	//	$userid = $_SESSION["userid"];
	//}else{
	//	$userid = "";
	//}s
	//if (isset($_SESSION["username"])){
	//	$username = $_SESSION["username"];
	//}else{
	//	$username = "";
	//}if (isset($_SESSION["role"])){ // 사용자, 관리자 구분 용도
	//	$role = $_SESSION["role"];
	//}else{
	//	$role = "";
	//}
?>

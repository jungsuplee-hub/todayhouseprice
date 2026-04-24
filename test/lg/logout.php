<?php
  session_start();
  unset($_SESSION["lguserid"]);
  
  $location_text = "<script> alert('로그아웃 했습니다.'); location.href = 'deploy.php'; </script>";

  echo $location_text;

?>

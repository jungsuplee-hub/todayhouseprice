<?php
  session_start();
  unset($_SESSION["userid"]);

  $site = $_REQUEST["site"];
  //unset($_SESSION["username"]);
  if ($site==""){
    $location_text = "<script> alert('로그아웃 했습니다.'); location.href = 'index.php'; </script>";
  }else{
    $location_text = "<script> alert('로그아웃 했습니다.'); location.href = '".$site.".php'; </script>";
  }

  echo $location_text;

?>

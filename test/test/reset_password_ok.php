<?php
	//include_once "./db/db_con.php";
    $id   = $_POST['id'];
    $pass = $_POST['pass']; // 입력받은 패스워드를 해쉬값으로 암호화
    //$name = $_POST['name'];
    //$gender = $_POST['gender'];
    //$phone = $_POST['phone'];
    $email  = $_POST['email'];

    $times = mktime();  // 현재 서버의 시간을 timestamp 값으로 가져옴
    $date1 = date("Y-m-d H:i:s", $times);  // 초 -> 년-월-일 시:분:초  변환

    $Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);

    $rs = mysqli_query($Conn, "select count(1) as cnt from user where id ='$id' and email = '$email';");
    $row = mysqli_fetch_assoc($rs);

    if($row['cnt']>0){
      mysqli_query($Conn, "update user set pass = '$pass' where id = '$id' and email = '$email'");
      session_start();
		  $_SESSION["userid"] = $id;
		  echo "<script> alert('비밀번호가 초기화되었습니다.'); location.href = './deploy.php';</script> ";

    }else{
      echo "<script> alert('이메일 주소가 일치하지 않습니다.'); history.back(); </script> ";
    }
?>

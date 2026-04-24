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


//  $con = mysqli_connect("localhost", "user1", "12345", "bbs");

//  	$sql = "insert into user(id, pass, name, gender, phone, email) ";
//  	$sql .= "values('$id', '$pass', '$name', '$gender', '$phone', '$email')";
// 	mq("INSERT
// 			user
// 		SET
// 			id = '$id' ,
// 			pass = '$pass',
// 			name = '$name',
// 			gender = '$gender',
// 			phone = '$phone',
// 			email = '$email'
// 		");
//    $Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
//    mysqli_query($db, "set names utf8;");
//    mysqli_query($db, "set session character_set_connection=utf8;");
//    mysqli_query($db, "set session character_set_results=utf8;");
//    mysqli_query($db, "set session character_set_client=utf8;");
//    mysqli_query($Conn, "insert into user(id,pass,name,gender,phone,email) values('$id','$pass','$name','$gender','$phone','$email');");
    $Conn = mysqli_connect("1.239.38.238", "root", "e0425820", "jsdb", 33306);
		//mysqli_query($Conn, "insert into user(id,pass,name,gender,phone,email) values('$id','$pass','$name','$gender','$phone','$email');");
		mysqli_query($Conn, "insert into user(id,pass,email,insert_date) values('$id','$pass','$email','$date1');");

    //mq("insert into user(id,pass,name,gender,phone,email) values('".$id."','".$pass."','".$name."','".$gender."','".$phone."','".$email."')");

		session_start();
		$_SESSION["userid"] = $id;

    echo "
	      <script>
    	      alert('회원가입이 완료 되었습니다.');
	          location.href = 'index.php';
	      </script>
	  ";
?>

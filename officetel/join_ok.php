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

    if($id!=""){
      if($pass!=""){
        if($email!=""){
          $Conn = mysqli_connect("localhost", "root", "e0425820", "jsdb", 3306);
          mysqli_query($Conn, "set names utf8;");
          mysqli_query($Conn, "set session character_set_connection=utf8;");
          mysqli_query($Conn, "set session character_set_results=utf8;");
          mysqli_query($Conn, "set session character_set_client=utf8;");
      		mysqli_query($Conn, "insert into user(id,pass,email,insert_date, area_main_name, size1, size2, size3, size4) values('$id','$pass','$email','$date1','전체','false','true','true','false');");

      		session_start();
      		$_SESSION["userid"] = $id;

          echo "
      	      <script>
          	      alert('회원가입이 완료 되었습니다.');
      	          location.href = 'index.php';
      	      </script>
      	  ";
        }else{
          echo "
        	      <script>
            	      alert('이메일주소를 입력해 주세요.');
        	          history.back();
        	      </script>
        	  ";
        }
      }else{
        echo "
  	      <script>
      	      alert('비밀번호를 입력해 주세요.');
  	          history.back();
  	      </script>
  	  ";
      }
    }
    else{
      echo "
  	      <script>
      	      alert('ID를 입력해 주세요.');
  	          history.back();
  	      </script>
  	  ";
    }
?>
